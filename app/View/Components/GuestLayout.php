<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /** @var string|null */
    public $pageTitle;

    public function __construct($pageTitle = null)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.guest');
    }
}
