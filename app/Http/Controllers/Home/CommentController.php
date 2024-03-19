<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;


class CommentController extends Controller
{
    //
    public function store(Request $request,Product $product)
    {

       $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
           'text'=>'required|min:5|max:5000',
           'rate'=>'required|digits_between:0,5'

       ]);
       if ($validator->fails()){
           return redirect()->to(url()->previous().'#comments')->withErrors($validator);
       }
       if (auth()->check()){
           try {
               DB::beginTransaction();
               Comment::query()->create([
                  'user_id'=>auth()->id(),
                  'product_id'=>$product->id,
                  'text'=>$request->text
               ]);
              if ($product->rates()->where('user_id',auth()->id())->exists()){
                  $productRate=$product->rates()->where('user_id',auth()->id())->first();
                  $productRate->update([
                     'rate'=>$request->rate
                  ]);
              }else{
                  ProductRate::query()->create([
                     'user_id'=>auth()->id(),
                     'product_id'=>$product->id,
                     'rate'=>$request->rate
                  ]);
              }
              DB::commit();

           }catch (Exception $ex){
            DB::rollBack();
            alert()->error('مشکل در ویرایش محصول','خطای سیستمی')->persistent('حله');
            return redirect()->back();
           }
           alert()->success('نظر ارزشمند شما با موفقیت برای محصول ثبت شد','باتشکر');
           return redirect()->back();
       }else{
           alert()->warning('برای ثبت نظر نیاز است در ابتدا وارد سایت بشوید','دقت کنید' );
           return redirect()->back();
       }
    }

    public function usersProfileIndex()
    {
        SEOTools::setTitle('لیست نظرات');
        SEOMeta::addMeta('robots','noindex,nofollow');
        $comments = Comment::query()->where('user_id','=',auth()->id())->where('approved','=',1)->get();
        return view('home.users_profile.comments',compact('comments'));
    }
}
