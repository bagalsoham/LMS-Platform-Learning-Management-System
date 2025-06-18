<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

// Checkbox Component
class Checkbox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $name, public $label = '')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkbox');
    }
}
// Switch Component
class SwitchInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $name, public $label = '')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.switch');
    }
}

// Select Component
class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $name, public $label = '', public $options = [])
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}

// Toggle Component (appears to be same as Switch, but keeping separate as requested)
class Toggle extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $name, public $label = '' , public $checked =false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toggle');
    }
}
