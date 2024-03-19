<?php

namespace App\Models;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\isEmpty;

class Product extends Model
{
    use HasFactory,Sluggable;
    protected $table = "products";
    protected $guarded=[];
    protected $appends = ['quantity_check','sale_check','price_check'];
    public function sluggable(): array
    {
        // TODO: Implement sluggable() method.
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function getQuantityCheckAttribute()
    {
        return $this->variations()->where('quantity' , '>' , 0)->first() ?? 0;
    }

    public function getSaleCheckAttribute()
    {
        return $this->variations()->where('quantity' , '>' , 0)->where('sale_price', '!=' , null)->where('date_on_sale_from' , '<' , Carbon::now())->where('date_on_sale_to' , '>' , Carbon::now())->orderBy('sale_price')->first() ?? false;
    }

    public function getPriceCheckAttribute()
    {
        return $this->variations()->where('quantity' , '>' , 0)->orderBy('price')->first() ?? false;
    }

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال' : 'غیرفعال';
    }

    public function scopeFilter($query)
    {
        if (request()->has('sortBy')){
            $sortBy = Request()->sortBy;
            switch ($sortBy){
                case 'max':
                    $query->orderByDesc(
                      ProductVariation::query()->select('price')->whereColumn('product_variations.product_id','=','products.id')
                      ->orderBy('sale_price','desc')->take(1)
                    );
                    break;
                case 'min':
                    $query->orderBy(
                        ProductVariation::query()->select('price')->whereColumn('product_variations.product_id','=','products.id')
                            ->orderBy('sale_price','desc')->take(1)
                    );
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query;
                    break;

            }
        }
        if (request()->has('attribute')){
             foreach (request()->attribute as $attribute){
                 $query->whereHas('attributes',function ($query) use ($attribute){
                     foreach (explode('-',$attribute)as $index=>$item){
                         if ($index==0){
                             $query->where('value',$item);
                         }else{
                             $query->orWhere('value',$item);
                         }
                     }
                 });

             }
        }

        if (request()->has('variation')){
            $query->whereHas('variations',function ($query){
               foreach (explode('-',request()->variation)as $index=>$variation){
                    if ($index==0){
                        $query->where('value',$variation);
                    }else{
                        $query->orWhere('value',$variation);
                    }
               }
            });
        }

//        if ($query->count()<1){
//            App::abort('404');
//        }
    return $query;
    }

    public function scopeSearch($query)
    {
        $keyword = request()->search;
        if (request()->has('search')&&trim($keyword)!=''){
            $query->where('name','LIKE','%'.trim($keyword).'%');
        }
        if ($query->count()<1){
            alert()->error('کالایی با این مشخصات پیدا نکردیم');
        }
        return $query;




    }
    public function scopeUserSearch($query)
    {
        $keyword = request()->userSearch;
        if (request()->has('userSearch')&&trim($keyword)!=''){
            $query->where('name','LIKE','%'.trim($keyword).'%');
        }
        if ($query->count()<1){
            alert()->error('کالایی با این مشخصات پیدا نکردیم');
        }
        return $query;




    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('approved','=',1);
   }
    public function checkUserWishlist($userId)
    {
        return $this->hasMany(Wishlist::class)->where('user_id','=',$userId)->exists();
    }

}
