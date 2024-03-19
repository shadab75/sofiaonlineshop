<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = "tags";
    protected $guarded=[];
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_tag')->where('is_active','=',1);
    }
}
