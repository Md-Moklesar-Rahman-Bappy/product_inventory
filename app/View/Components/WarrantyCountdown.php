<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class WarrantyCountdown extends Component
{
    public $start;
    public $end;

    public function __construct($start, $end)
    {
        $this->start = $start ? Carbon::parse($start) : null;
        $this->end   = $end ? Carbon::parse($end) : null;
    }

    public function render()
    {
        return view('components.warranty-countdown');
    }
}
