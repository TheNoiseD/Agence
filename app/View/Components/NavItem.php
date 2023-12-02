<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavItem extends Component
{
    public $url;
    public $text;
    public $dropdown;

    public function __construct($url, $text, $dropdown = false)
    {
        $this->url = $url;
        $this->text = $text;
        $this->dropdown = $dropdown;
    }

    public function render()
    {
        return view('components.nav-item');
    }
}
