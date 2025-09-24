<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class Parallax extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'textArea',
                    'label'     => __('Sub Title')
                ],
                [
                    'id'    => 'icon_image',
                    'type'  => 'uploader',
                    'label' => __('Image Uploader')
                ],
                [
                    'id'        => 'link',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Link Redirect')
                ],
                [
                    'id'        => 'text_btn',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Button Text')
                ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Parallax Text');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.parallax.index', $model);
    }
}
