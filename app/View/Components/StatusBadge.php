<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;
    public $outline;

    /**
     * Create a new component instance.
     *
     * @param string $status
     * @param bool $outline
     */
    public function __construct($status, $outline = false)
    {
        $this->status = $status;
        $this->outline = $outline;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.status-badge');
    }
}
