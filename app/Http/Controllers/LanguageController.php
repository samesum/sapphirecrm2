<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function select_lng(Request $request)
    {
        session(['language' => strtolower($request->language)]);
        return redirect()->back();
    }
}
