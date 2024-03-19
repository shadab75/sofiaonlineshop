<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OTPSms;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Exception;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {

        SEOTools::setTitle('ورود');
        SEOMeta::addMeta('robots','noindex,nofollow');
     if ($request->method()=='GET'){
         return view('auth.login');
     }
     $request->validate([
        'cellphone'=>'required|iran_mobile'
     ]);

        try {
            $user = User::query()->where('cellphone',$request->cellphone)->first();
            $OTPCode = mt_rand(100000,999999);
            $loginToken = Hash::make('Sofia@Shop!%&#Shadab75!&Kourosh$%$%!@');
            if ($user){
                $user->update([
                    'otp'=>$OTPCode,
                    'login_token'=>$loginToken
                ]);
            }else{

                $user=User::query()->create([
                    'cellphone'=>$request->cellphone,
                    'otp'=>$OTPCode,
                    'login_token'=>$loginToken
                ]);
            }
            $user->notify(new OTPSms($OTPCode));
            return response(['login_token'=>$loginToken],200);
        }catch (Exception $ex){
            return response(['errors'=>$ex->getMessage()],402);
        }


    }

    public function checkOtp(Request $request)
    {

        $request->validate([
            'otp'=>'required|digits:6',
            'login_token'=>'required'
        ]);
        try {
            $user =User::query()->where('login_token',$request->login_token)->firstOrFail();
            if ($user->otp==$request->otp){
                auth()->login($user,$remember=true);
                return response(['ورود با موفقیت انجام شد'],200);

            }else{
                return response(['errors'=>['otp'=> ['کد تاییدیه نادرست است']]],422);

            }
        }catch (Exception $ex){
            return response(['errors'=>$ex->getMessage()],402);
        }
    }
    public function resendOtp(Request $request)
    {

        $request->validate([
            'login_token'=>'required'
        ]);

        try {
            $user = User::query()->where('login_token',$request->login_token)->firstOrFail();
            $OTPCode = mt_rand(100000,999999);
            $loginToken = Hash::make('Sofia@Shop!%&#Shadab75!&Kourosh$%$%!@');
            $user->update([
                'otp'=>$OTPCode,
                'login_token'=>$loginToken
            ]);
            $user->notify(new OTPSms($OTPCode));
            return response(['login_token'=>$loginToken],200);
        }catch (Exception $ex){
            return response(['errors'=>$ex->getMessage()],402);
        }


    }



}
