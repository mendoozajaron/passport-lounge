<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
{
    return MenuItem::orderBy('category')   // 'drink' comes before 'food'
        ->orderBy('position')
        ->get();
}
}
