<?php
namespace Modules\Media\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Models\MediaFile;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class MediaController extends Controller
{
    public function preview($id, $size = 'thumb')
    {
        return redirect(FileHelper::url($id, $size));
    }

    public function privateFileStore(Request $request)
    {
        if(!$user_id = Auth::id()){
           return $this->sendError(__("Please logged in"));
        }

        $fileName = 'file';

        $file = $request->file($fileName);

        try {
            $group = 'default';
            $this->validatePrivateFile($file, $group);
        } catch (\Exception $exception) {
           return $this->sendError($exception->getMessage());
        }
        $folder = 'private/'.$user_id.'/';
        $folder = $folder . date('Y/m/d');

        $newFileName = Str::slug(substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.')));
        if(empty($newFileName)) $newFileName = md5($file->getClientOriginalName());

        $i = 0;
        do {
            $newFileName2 = $newFileName . ($i ? $i : '');
            $testPath = $folder . '/' . $newFileName2 . '.' . $file->getClientOriginalExtension();
            $i++;
        } while (Storage::disk('local')->exists($testPath));

        $check = $file->storeAs( $folder, $newFileName2 . '.' . $file->getClientOriginalExtension(),'local');

        if ($check) {
            try {
                $path = str_replace('private/','',$check);
               return $this->sendSuccess(['data' => [
                    'path'=>$path,
                    'name'=>$newFileName2,
                    'size'=>$file->getSize(),
                    'file_type'=>$file->getMimeType(),
                    'file_extension'=> $file->getClientOriginalExtension(),
                    'download'=>route('media.private.view',['path'=>$path])
                ]]);

            } catch (\Exception $exception) {

                Storage::disk('local')->delete($check);

               return $this->sendError($exception->getMessage());
            }
        }
       return $this->sendError(__("Can not upload the file"));
    }

   /**
 * Validate uploaded file (Allow all types)
 *
 * @param UploadedFile $file
 * @param string $group
 * @return bool
 * @throws \Exception
 */
   public function validatePrivateFile($file, $group = "default")
{
    $group = 'default';

    $allowedExtsImage = [
        'jpg', 'jpeg', 'bmp', 'png', 'gif', 'svg'
    ];

    if (!$file || !$file->isValid()) {
        throw new \Exception(__("Invalid file upload"));
    }

    // Upload configuration
    $uploadConfigs = [
        'default' => [
            'max_size'   => 200000000, // ~200 MB
            'max_width'  => null,
            'max_height' => null,
            'types'      => [] // Empty means all file types allowed
        ]
    ];

    $config = isset($uploadConfigs[$group]) ? $uploadConfigs[$group] : $uploadConfigs['default'];

    // Size check
    if ($file->getSize() > $config['max_size']) {
        throw new \Exception(__("Maximum upload file size is :max_size B", [
            'max_size' => $config['max_size']
        ]));
    }

    // If the file is an image, check dimensions
    if (@getimagesize($file->getPathname())) {
        if (!empty($config['max_width']) && $config['max_width'] > 0) {
            $imagedata = getimagesize($file->getPathname());
            if ($imagedata[0] > $config['max_width']) {
                throw new \Exception(__("Maximum width allowed is: :number", ['number' => $config['max_width']]));
            }
            if (!empty($config['max_height']) && $imagedata[1] > $config['max_height']) {
                throw new \Exception(__("Maximum height allowed is: :number", ['number' => $config['max_height']]));
            }
        }
    }

    // ✅ Removed file type restriction
    // Previously: in_array(...) check removed

    // Additional image-specific dimension checks
    $file_extension = strtolower($file->getClientOriginalExtension());
    if (in_array($file_extension, $allowedExtsImage)) {
        if ($file_extension == "svg") {
            return true;
        }
        if (!empty($config['max_width']) || !empty($config['max_height'])) {
            $imagedata = getimagesize($file->getPathname());
            if (empty($imagedata)) {
                throw new \Exception(__("Can not get image dimensions"));
            }
            if (!empty($config['max_width']) && $imagedata[0] > $config['max_width']) {
                throw new \Exception(__("Maximum width allowed is: :number", ['number' => $config['max_width']]));
            }
            if (!empty($config['max_height']) && $imagedata[1] > $config['max_height']) {
                throw new \Exception(__("Maximum height allowed is: :number", ['number' => $config['max_height']]));
            }
        }
    }

    return true;
}


    public function privateFileView(){

        $path = 'private/'.\request()->get('path');

        if(Storage::disk('local')->exists($path)) {

            header('Content-Type: ' . mime_content_type(storage_path('app/'.$path)));

            echo Storage::disk('local')->get($path);
            exit;
        }

        abort(404);
    }
    public function getFile(){

        $id = \request()->get('id');
        if(!Auth::check()){

            return $this->sendSuccess();
        }

        if(empty($id)){
            return $this->sendSuccess();
        }
        $file = (new MediaFile())->findById($id);
        if(empty($file)){
            return $this->sendSuccess();
        }

        return $this->sendSuccess($file);
    }
}
