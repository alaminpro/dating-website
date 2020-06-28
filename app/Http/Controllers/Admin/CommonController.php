<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interest;

class CommonController extends Controller
{
    public function interests()
    {
        $interests = Interest::all();
        return view('admin.interests', compact('interests'));
    }

}
