<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalAndDeleteButton extends Component
{
    //ボタン関係変数
    public $type;

    public $buttonClass;

    public $icon;

    public $dataBsToggle;

    public $dataBsTarget;

    //Modal関係変数
    public $id;

    public $href;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type='button', $buttonClass='danger', $icon=null, $dataBsToggle, $dataBsTarget, $id, $href)
    {
        $this->type = $type;
        $this->buttonClass = $buttonClass;
        $this->icon = $icon;
        $this->dataBsToggle = $dataBsToggle;
        $this->dataBsTarget = $dataBsTarget;
        $this->id = $id;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-and-delete-button');
    }
}
