<?php
namespace Modules\Media\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaScormFile extends BaseModel
{
    protected $table = 'media_scorm_files';

    public static function getByFileId($file_id){
        return Cache::rememberForever('media_scorm_files:' . $file_id, function () use ($file_id) {
            $check = parent::query()->where('file_id',$file_id)->first();
            if($check) return $check;

            return static::generateScorm($file_id);
        });
    }

    public  static  function generateScorm($file_id){
        $file = (new MediaFile())->findById($file_id);

        $scorm = static::getScormInfo($file);
        if(!empty($scorm))
        {
            $a = new self();
            $a->file_id = $file_id;
            $a->index_path = $scorm['index_path'];
            $a->resource_path = $scorm['resource_path'];
            $a->version = $scorm['version'];
            $a->save();
            return $a;
        }

        return new self();
    }
    public static function getScormInfo($file){
        if(!in_array(strtolower($file->file_extension),['zip','rar']))
        {
            return '';
        }

        $path_parts = pathinfo(public_path('uploads/' . $file->file_path));
        $relative_parts = pathinfo( $file->file_path);

        $manifest = $path_parts['dirname'].'/scorm-'.$file->id.'/manifest.xml';

        if(!is_dir($path_parts['dirname'].'/scorm-'.$file->id)) {

            $zip = new \ZipArchive;
            if ($zip->open(ltrim(public_path('uploads/' . $file->file_path), "/")) === true) {
                $zip->extractTo($path_parts['dirname'] . '/scorm-' . $file->id);
                $zip->close();
            } else {
                return '';
            }
        }
        if(!file_exists($manifest)){
            $manifest = $path_parts['dirname'].'/scorm-'.$file->id.'/imsmanifest.xml';
            if(!file_exists($manifest)){
                return '';
            }
        }

        $valueXmlArr = static::readXml($manifest);
        if(!$valueXmlArr) {
            return '';
        }
        $valueXmlArr['index_path'] = $relative_parts['dirname'].'/scorm-'.$file->id.'/'.$valueXmlArr['index_path'];
        $valueXmlArr['resource_path'] = $relative_parts['dirname'].'/scorm-'.$file->id.'/'.$valueXmlArr['resource_path'];
        return $valueXmlArr;
    }

    protected static function readXml($fileXml) {

        $read = new \DOMDocument("");
        if(!$read->load( $fileXml)) {
            return false;
        }
        $value['version'] = $read->getElementsByTagName('schemaversion')->item(0)->nodeValue;
        $resource = $read->getElementsByTagName('resource');
        $path = '';
        foreach ($resource as $item) {
            $scormtype = $item->getAttribute('adlcp:scormType');
            if(empty($scormtype)) {
                $scormtype = $item->getAttribute('adlcp:scormtype');
            }
            $type = $item->getAttribute('type');
            $href = $item->getAttribute('href');

            if($scormtype == 'sco' && $type == 'webcontent' && !empty($href)) {
                $path = $href;
            }
        }

        $arr = explode("/", $path);
        $value['index_path'] = $path;
        $value['resource_path'] = implode("/", $arr) . "/";

        return $value;
    }
}
