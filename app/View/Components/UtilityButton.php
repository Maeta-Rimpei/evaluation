<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UtilityButton extends Component
{
    public $label;

    public $type;

    public $class;

    public $icon;

    /**
     * Create a new component instance.
     *
     * @param $label ラベルタグ
     * 　　　　$type ボタンのタイプ属性
     *        $class ボタンのクラス属性
     *        $icon ボタンのアイコン
     *  
     * @return void
     */
    public function __construct($label = null, $type = 'button', $class = '', $icon = null)
    {
        $this->type = $type;
        $this->label = $label;
        $this->class = $class;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.utility-button');
    }
}