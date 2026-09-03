<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }
}
