<?php
namespace Modules\User\Blocks;

use App\User;
use Modules\Template\Blocks\BaseBlock;

class ListInstructors extends BaseBlock
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
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Desc')
                ],
                [
                    'id'        => 'number',
                    'type'      => 'input',
                    'inputType' => 'number',
                    'label'     => __('Number Item')
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
                            'value'   => 'carousel',
                            'name' => __("Slider Carousel")
                        ],
                        [
                            'value'   => 'box_shadow',
                            'name' => __("Box Shadow")
                        ]
                    ]
                ],
                [
                    'id'            => 'order',
                    'type'          => 'radios',
                    'label'         => __('Order'),
                    'values'        => [
                        [
                            'value'   => 'id',
                            'name' => __("Date Create")
                        ],
                        [
                            'value'   => 'name',
                            'name' => __("Name")
                        ],
                    ]
                ],
                [
                    'id'            => 'order_by',
                    'type'          => 'radios',
                    'label'         => __('Order By'),
                    'values'        => [
                        [
                            'value'   => 'asc',
                            'name' => __("ASC")
                        ],
                        [
                            'value'   => 'desc',
                            'name' => __("DESC")
                        ],
                    ]
                ]
            ]
        ]);
    }

    public function getName()
    {
        return __('Instructors: List Items');
    }

    public function content($model = [])
    {
        $model_User = User::select("users.*");
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        $model_User->orderBy("users.".$model['order'], $model['order_by']);
        $model_User->where("users.status", "publish");
        $model_User->groupBy("users.id");
        $list = $model_User->limit($model['number'])->get();
        $data = [
            'rows'       => $list,
            'style_list' => $model['style'],
            'title'      => $model['title'] ?? "",
            'desc'      => $model['desc'] ?? "",
        ];
        return view('User::frontend.blocks.list-instructor.index', $data);
    }
}
