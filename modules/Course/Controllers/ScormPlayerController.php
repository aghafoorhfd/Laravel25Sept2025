<?php
namespace Modules\Course\Controllers;

use App\Http\Controllers\Controller;
use Modules\Media\Models\MediaScormFile;

class ScormPlayerController extends Controller
{
    public function player($id = ''){
        if(empty($id)) return '';

        $scorm = MediaScormFile::getByFileId($id);

        debugbar()->disable();

        return view('Course::frontend.scorm.player',['scorm'=>$scorm]);
    }
}
