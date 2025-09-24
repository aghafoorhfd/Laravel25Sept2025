<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class Slide extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => '<b>'.__('Banner Content').'</b>',
                    'title_field' => 'title',
                    'settings'    => [
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
                            'id'        => 'order',
                            'type'      => 'input',
                            'inputType' => 'number',
                            'label'     => __('Order')
                        ],
                    ]
                ],
                [
                    'id'          => 'list_sub',
                    'type'        => 'listItem',
                    'label'       => '<b>'.__('List Category Item(s)').'</b>',
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'    => 'icon_image',
                            'type'  => 'uploader',
                            'label' => __('Image Uploader')
                        ],
                        [
                            'id'        => 'order',
                            'type'      => 'input',
                            'inputType' => 'number',
                            'label'     => __('Order')
                        ],
                    ]
                ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Banner Slide');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.slide.index', $model);
    }
}
