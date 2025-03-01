<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppointmentSideMenu extends Component
{
    public $activeMenu;
    public $appointmentData;

    /**
     * Create a new component instance.
     */
    public function __construct($activeMenu, $appointmentData = null)
    {
        $this->activeMenu = $activeMenu;
        $this->appointmentData = $appointmentData;  // Add the sales variable
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.appointment-side-menu');
    }
}
