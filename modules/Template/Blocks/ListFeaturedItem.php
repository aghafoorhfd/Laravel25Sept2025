<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class ListFeaturedItem extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
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
                            'type'      => 'editor',
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
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style'),
                    'values'        => [
                        [
                            'value'   => 'normal',
                            'name' => __("Normal")
                        ],
                        [
                            'value'   => 'style2',
                            'name' => __("Style 2")
                        ],
                        [
                            'value'   => 'style3',
                            'name' => __("Style 3")
                        ],
                        [
                            'value'   => 'style4',
                            'name' => __("Style 4")
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function getName()
    {
        return __('List Featured Item');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.list-featured-item.index', $model);
    }
}
