<?php

namespace App\View\Components\Chart;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Facility;
use App\Models\Patient;
use App\Models\Room;

class Header extends Component
{
    public $patient;
    public $facility;
    public $room;
    public function __construct($patient)
    {
        $this->patient = $patient;

        $this->room = Room::where('patient', $this->patient->id)->first();
        $this->facility = Facility::where('id', $this->room->facility)->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart.header');
    }
}
