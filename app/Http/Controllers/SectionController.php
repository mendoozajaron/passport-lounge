<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
     public function show(string $key)
    {
        return Section::where('key', $key)->firstOrFail();
    }
}
