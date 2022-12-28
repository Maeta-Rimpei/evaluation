<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UtilityButton extends Component
{
    public $label;

    public $href;

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
    public function __construct($label = null, $href = null, $type = 'button', $class = 'primary', $icon = null)
    {
        $this->label = $label;
        $this->href = $href;
        $this->type = $type;
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