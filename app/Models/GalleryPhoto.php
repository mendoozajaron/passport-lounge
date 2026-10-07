<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return asset('storage/'.$this->path);
    }
}
