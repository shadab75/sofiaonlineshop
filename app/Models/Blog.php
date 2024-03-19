<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use HasFactory,Sluggable,InteractsWithMedia;
    protected $table = "blogs";
    protected $guarded=[];
    public function sluggable(): array
    {
        // TODO: Implement sluggable() method.
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال':'غیر فعال';
    }

    public static function last()
    {
    return static ::all()->last();
    }

}
