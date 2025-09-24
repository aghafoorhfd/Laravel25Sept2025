<?php
namespace Modules\Course\Models;

use App\BaseModel;

class LessonsTranslation extends BaseModel
{
    protected $table = 'bravo_terms_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $cleanFields = [
        'content'
    ];
}
