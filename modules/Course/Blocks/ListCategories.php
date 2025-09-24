<?php
namespace Modules\Course\Blocks;

use Modules\Course\Models\CourseCategory;
use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class ListCategories extends BaseBlock
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
                    'inputType' => 'text',
                    'label'     => __('Sub Title')
                ],
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Category(ies)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'      => 'category_id',
                            'type'    => 'select2',
                            'label'   => __('Select Category'),
                            'select2' => [
                                'ajax'  => [
                                    'url'      => url('/admin/module/course/category/getForSelect2'),
                                    'dataType' => 'json'
                                ],
                                'width' => '100%',
                                'allowClear' => 'true',
                                'placeholder' => __('-- Select --')
                            ],
                            'pre_selected'=>url('/admin/module/course/category/getForSelect2?pre_selected=1')
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
        return __('Course: List Categories');
    }

    public function content($model = [])
    {
        if(!empty($model['list_item'])){
            foreach($model['list_item'] as $key => $oneModel){
                $model['list_item'][$key]['data'] = CourseCategory::find($oneModel['category_id']);
            }
        }
        $data = [
            'rows'       => $model['list_item'],
            'title'      => @$model['title'],
            'sub_title'      => @$model['sub_title'],
        ];

        return view('Course::frontend.blocks.list-category.index', $data);
    }
}
