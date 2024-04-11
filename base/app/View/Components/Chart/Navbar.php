<?php

namespace App\View\Components\Chart;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $patient;
    public function __construct($patient)
    {
        $this->patient = $patient;
    }
    public function render(): View|Closure|string
    {
        return view('components.chart.navbar');
    }
}
