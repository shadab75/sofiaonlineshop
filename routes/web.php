<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\blogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\BlogController as HomeBlogController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\ConditionsController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\UserController as HomeUserController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishlistController;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Http\Controllers\Home\TagController as HomeTagController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin-panel/dashboard',[AdminController::class,'index'])->name('dashboard')->middleware('role:admin');
 Route::prefix('admin-panel/management')->name('admin.')->middleware('role:admin')->group(function(){
    Route::get('/comments/{comment}/change-approve',[CommentController::class,'changeApprove'])->name('comments.change-approve');
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('blogs', blogController::class);
    Route::post('/images',[ImageController::class,'store'])->name('images.store');
//  Route::post('/upload',[ImageController::class,'upload'])->name('ckeditor.upload');
//     Route::post('image-upload', [ImageController::class, 'storeImage'])->name('image.upload');
    Route::get('/settings',[SettingController::class,'index'])->name('setting.index');
    Route::get('/settings/{setting}/edit',[SettingController::class,'edit'])->name('setting.edit');
    Route::get('/settings/{setting}',[SettingController::class,'show'])->name('setting.show');
    Route::put('/settings/{setting}',[SettingController::class,'update'])->name('setting.update');
    Route::get('/contactus-form',[ContactUsController::class,'index'])->name('contactUs.index');
    Route::get('/contactus-form/{form}',[ContactUsController::class,'show'])->name('contactus.show');



    // Get Category Attributes
    Route::get('/category-attributes/{category}' ,[CategoryController::class , 'getCategoryAttributes']);

    // Edit Product Image
    Route::get('/products/{product}/images-edit' ,[ProductImageController::class , 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy' ,[ProductImageController::class , 'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary' ,[ProductImageController::class , 'setPrimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add' ,[ProductImageController::class , 'add'])->name('products.images.add');

    // Edit Product Category
    Route::get('/products/{product}/category-edit' ,[ProductController::class , 'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-update' ,[ProductController::class , 'updateCategory'])->name('products.category.update');


});

//profile
Route::prefix('profile')->name('home.')->group(function(){
Route::get('/',[UserProfileController::class,'index'])->middleware('auth')->name('users_profile.index');
Route::get('/comments',[HomeCommentController::class,'usersProfileIndex'])->middleware('auth')->name('comments.users_profile.index');
Route::get('/wishlist',[WishlistController::class,'usersProfileIndex'])->middleware('auth')->name('wishlist.users_profile.index');
Route::get('/compare',[CompareController::class,'index'])->middleware('auth')->name('compare.index');
Route::get('/address',[AddressController::class,'index'])->middleware('auth')->name('address.index');
Route::post('/address',[AddressController::class,'store'])->middleware('auth')->name('address.store');
Route::put('/address/{address}',[AddressController::class,'update'])->middleware('auth')->name('address.update');
Route::get('/add-to-compare/{product}',[CompareController::class,'add'])->middleware('auth')->name('compare.add');
Route::get('/remove-from-compare/{product}',[CompareController::class,'remove'])->middleware('auth')->name('compare.remove');
Route::get('/orders',[CartController::class,'usersProfileIndex'])->middleware('auth')->name('orders.users_profile.index');
Route::get('/logout',[HomeUserController::class,'logout'])->middleware('auth')->name('logout');
Route::resource('users', HomeUserController::class)->middleware('auth');

});
Route::get('/get-province-cities-list',[AddressController::class,'getProvinceCitiesList'])->middleware('auth');
//
Route::get('/cart',[CartController::class,'index'])->name('home.cart.index')->middleware('auth');
Route::post('/add-to-cart',[CartController::class,'add'])->middleware('auth')->name('home.cart.add');
Route::get('/remove-from-/{rowId}',[CartController::class,'remove'])->middleware('auth')->name('home.cart.remove');
Route::put('/cart',[CartController::class,'update'])->middleware('auth')->name('home.cart.update');
Route::get('/clear-cart',[CartController::class,'clear'])->middleware('auth')->name('home.cart.clear');
Route::post('/check-coupon',[CartController::class,'checkCoupon'])->middleware('auth')->name('home.coupons.check');
Route::get('/checkout',[CartController::class,'checkout'])->middleware('auth')->name('home.orders.checkout');
Route::post('/payment',[PaymentController::class,'payment'])->middleware('auth')->name('home.payment');
Route::get('/payment-verify',[PaymentController::class,'paymentVerify'])->middleware('auth')->name('home.payment_verify');

Route::get('/',[HomeController::class,'index'])->name('home.index');
Route::get('/categories/{category:slug}',[HomeCategoryController::class,'show'])->name('home.categories.show');
Route::get('/products/{product:slug}',[HomeProductController::class,'show'])->name('home.products.show');
Route::post('/comments/{product}',[HomeCommentController::class,'store'])->middleware('auth')->name('home.comments.store');
Route::get('/tags/{tag:name}',[HomeTagController::class,'show'])->name('tags.show');
Route::get('/blogs/{blog:slug}',[HomeBlogController::class,'show'])->name('home.blogs.show');
Route::get('/blogs',[HomeBlogController::class,'index'])->name('home.blogs.index');

//newest products
Route::get('/latest-products',[HomeController::class,'latestProducts'])->name('home.latest-products');
//is_sale products
Route::get('/discounted-products',[HomeController::class,'discountedProducts'])->name('home.discounted-products');
//wishlist
Route::get('/add-to-wishlist/{product}',[WishlistController::class,'add'])->middleware('auth')->name('home.wishlist.add');
Route::get('/remove-from-wishlist/{product}',[WishlistController::class,'remove'])->middleware('auth')->name('home.wishlist.remove');

//Auth

Route::any('/login',[AuthController::class,'login'])->name('login')->middleware('guest');
Route::post('/check-otp',[AuthController::class,'checkOtp']);
Route::post('/resend-otp',[AuthController::class,'resendOtp']);

Route::get('/about-us',[HomeController::class,'aboutUs'])->name('home.about-us');
Route::get('/contact-us',[HomeController::class,'contactUs'])->name('home.contact-us');
Route::post('/contact-us-form',[HomeController::class,'contactUsForm'])->name('home.contact-us.form');
Route::get('/policies',[ConditionsController::class,'index'])->name('home.policies');
Route::get('/return-terms',[HomeController::class,'return'])->name('home.return-term');
Route::get('/sitemap',function (){
 $sitemap = Sitemap::create()
     ->add(Url::create('/')
         ->setLastModificationDate(Carbon::yesterday())
         ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
         ->setPriority(1))
     ->add(Url::create('/about-us')
         ->setLastModificationDate(Carbon::yesterday())
         ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
         ->setPriority(0.4))
     ->add(Url::create('/contact-us')
         ->setLastModificationDate(Carbon::yesterday())
         ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
         ->setPriority(0.4))
    ->add(Url::create('/return-terms')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ->setPriority(0.4))
    ->add(Url::create('/policies')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ->setPriority(0.4))
    ->add(Url::create('/blogs')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.8))
    ->add(Url::create('/latest-products')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.7))
    ->add(Url::create('/discounted-products')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.7));
     Product::all()->each(function (Product $product) use ($sitemap){
       $sitemap->add(Url::create("/products/{$product->slug}")
           ->setLastModificationDate($product->updated_at)
           ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
           ->setPriority(0.9));
     });
    Blog::all()->each(function (Blog $blog) use ($sitemap){
        $sitemap->add(Url::create("/blogs/{$blog->slug}")
            ->setLastModificationDate($blog->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.9));
    });
    Category::all()->each(function (Category $category) use ($sitemap){
        $sitemap->add(Url::create("/categories/{$category->name}")
            ->setLastModificationDate($category->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.9));

    });
    Tag::all()->each(function (Tag $tag) use ($sitemap){
        $sitemap->add(Url::create("/tags/{$tag->name}")
            ->setLastModificationDate($tag->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));

    });
    $sitemap->writeToFile(public_path('sitemap.xml'));
    abort('404');
});
Route::get('/search',[SearchController::class,'index'])->name('search');
Route::get('/mobileSearch',[SearchController::class,'mobileSearch'])->name('mobileSearch');


Route::get('/test',function (){
    return public_path();
});



