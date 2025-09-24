<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class AppDownload extends BaseBlock
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
                    'id'    => 'icon_capture',
                    'type'  => 'uploader',
                    'label' => __('Image Capture Uploader')
                ],
                [
                    'id'        => 'link_apple',
                    'type'      => 'input',
                    'inputType' => 'textArea',
                    'label'     => __('AppStore Link')
                ],
                [
                    'id'        => 'link_google',
                    'type'      => 'input',
                    'inputType' => 'textArea',
                    'label'     => __('GooglePlay Link')
                ]
            ]
        ]);
    }

    public function getName()
    {
        return __('App Download');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.app-download.index', $model);
    }
}
