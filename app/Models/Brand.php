<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory,Sluggable;
    protected $table = "brands";
    protected $guarded=[];

    public function sluggable(): array
    {
        // TODO: Implement sluggable() method.
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function getIsActiveAttribute($is_active)
    {
       return $is_active ? 'فعال':'غیر فعال';
    }
}
