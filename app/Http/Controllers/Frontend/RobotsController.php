<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function index()
    {
        $content = "User-agent: *\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /register\n";
        $content .= "Disallow: /password/reset\n";
        $content .= "Allow: /\n\n";
        
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain'
        ]);
    }
}
