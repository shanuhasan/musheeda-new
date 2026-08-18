<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsletterForm extends Component
{
    public $source;
    public $title;
    public $description;

    /**
     * Create a new component instance.
     */
    public function __construct($source = 'website', $title = 'Subscribe to our Newsletter', $description = 'Get the latest news and updates delivered to your inbox.')
    {
        $this->source = $source;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.newsletter-form');
    }
}
