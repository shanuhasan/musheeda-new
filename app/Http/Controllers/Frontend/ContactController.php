<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Fallback title/description if no dynamic SEO model is available
        $seoModel = new Page();
        $seoModel->title = 'Contact Us';
        $seoModel->excerpt = 'Get in touch with us for any inquiries, quotes, or demo requests.';

        return view('frontend.contact')->with('seoModel', $seoModel);
    }
}
