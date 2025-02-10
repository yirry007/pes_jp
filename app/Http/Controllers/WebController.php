<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WebController extends Controller
{
    /**
     * display admin page (react project)
     * @return View
     */
    public function admin()
    {
        return view('admin');
    }

    public function test()
    {
        return 'test web';
    }
}
