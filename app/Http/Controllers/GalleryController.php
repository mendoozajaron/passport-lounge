<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryPhoto;

class GalleryController extends Controller
{
     public function index()
    {
        return GalleryPhoto::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'path', 'sort_order']);
    }
}
