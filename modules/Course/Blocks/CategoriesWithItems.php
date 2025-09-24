<?php
namespace Modules\Course\Blocks;

use Illuminate\Support\Str;
use Modules\Course\Models\Course;
use Modules\Course\Models\CourseCategory;
use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class CategoriesWithItems extends BaseBlock
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
                    'label'       => __('List Category(ies)').'<br/>'.__('(Add the Category you need to filter)'),
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
                            'id'        => 'number',
                            'type'      => 'input',
                            'inputType' => 'number',
                            'label'     => __('Number Item')
                        ],
                        [
                            'type'=> "checkbox",
                            'label'=>__("Only featured items?"),
                            'id'=> "is_featured",
                            'default'=>true
                        ],
                        [
                            'id'        => 'order',
                            'type'      => 'input',
                            'inputType' => 'number',
                            'label'     => __('Order')
                        ]
                    ]
                ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Course: Categories With Items');
    }

    public function content($model = [])
    {
        $data = [];
        // if(!empty($model['list_item'])){
        //     $data = $model['list_item'];
        //     usort($data, function($a, $b) {
        //         return $a['order'] <=> $b['order'];
        //     });
        //     foreach($data as $key => $oneModel){
        //         $dataSelected = CourseCategory::where('id',$oneModel['category_id'])->select('name', 'slug')->first();
        //         $data[$key]['name'] = $dataSelected->name;
        //         $data[$key]['slug'] = $dataSelected->slug;
        //         $list = Course::where('category_id',$oneModel['category_id'])->limit($oneModel['number']);
        //         if(empty($list)){
        //             continue;
        //         }
        //         if(!empty($oneModel['is_featured']))
        //         {
        //             $list->where('is_featured',1);
        //         }
        //         $data[$key]['data'] = $list->get();
        //     }
        // }
        $data = [
            'rows'       => $data,
            'title'      => @$model['title'],
            'sub_title'  => @$model['sub_title'],
        ];

        return view('Course::frontend.blocks.category-with-items.index', $data);
    }
}
