<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Media\Helpers\FileHelper;

class CounterNumber extends BaseBlock
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
                            'id'        => 'counter',
                            'type'      => 'input',
                            'inputType' => 'number',
                            'label'     => __('Counter Number')
                        ],
                    ]
                ]
            ]
        ]);
    }

    public function getName()
    {
        return __('Counter Number');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.counter-number.index', $model);
    }
}
