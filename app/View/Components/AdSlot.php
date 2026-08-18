<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdSlot extends Component
{
    public $placement;
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct($placement, $class = '')
    {
        $this->placement = $placement;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ad-slot');
    }
}
