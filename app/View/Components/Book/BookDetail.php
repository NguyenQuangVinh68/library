<?php

namespace App\View\Components\Book;

use Illuminate\View\Component;

class BookDetail extends Component
{

    public $sach;
    public $size;
    public $rate;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sach, $size = null, $rate)
    {
        $this->sach = $sach;
        $this->size = $size;
        $this->rate = $rate;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.book.book-detail');
    }
}
