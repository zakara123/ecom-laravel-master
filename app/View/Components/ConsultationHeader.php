<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConsultationHeader extends Component
{
    public $appointmentData;
    /**
     * Create a new component instance.
     */
    public function __construct($appointmentData = null)
    {
        $this->appointmentData = $appointmentData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.consultation-header');
    }
}
