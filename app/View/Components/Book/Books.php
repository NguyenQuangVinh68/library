<?php

namespace App\View\Components\Book;

use Illuminate\View\Component;

class Books extends Component
{

    public $sach;

    // public $product;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sach)
    {
        $this->sach = $sach;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.book.books');
    }
}
