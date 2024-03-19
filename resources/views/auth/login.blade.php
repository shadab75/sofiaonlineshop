@extends('home.layouts.home')

@section('title')
    صفحه ورود
@endsection
@section('style')
    {!! htmlScriptTagJsApi([
'callback_then'=>'callbackThen',
'callback_catch'=>'callbackCatch',
]) !!}
@endsection
@section('script')
    <script>
        let loginToken;

        $('#main-footer').css("margin-top",500);
        $('#loginForm').submit(function (event){
            event.preventDefault();
          $.post("{{url('/login')}}",
              {
                  '_token':"{{csrf_token()}}",
                  'cellphone':$('#cellphoneInput').val()
              },function (response,status){
                loginToken = response.login_token;
              swal({
                  icon:'success',
                  text:'رمز یک بار مصرف برای شما ارسال شد',
                  button:'حله',
                  timer:5000,
                  width: '50px'

              })
                // $('#loginForm').fadeOut();
              $("#loginForm").css("display", "none");
              $('#checkOTPForm').css("display", "block");
              timer();

              }
          ).fail(function (response){
              $('#cellphoneInput').addClass('mb-1');
             $('#cellphoneInputError').fadeIn();
             $('#cellphoneInputErrorText').html(response.responseJSON.errors.cellphone[0]);
          })

        });
        $('#checkOTPForm').submit(function (event){
            event.preventDefault();
            $.post("{{url('/check-otp')}}",
                {
                    '_token':"{{csrf_token()}}",
                    'otp':$('#checkOTPInput').val(),
                    'login_token':loginToken
                },function (response,status){
                    swal({
                        icon:'success',
                        text:'ورود شما موفقیت آمیز بود',
                        timer:5000,

                    })
                    $(location).attr('href',"{{route('home.index')}}");

                }
            ).fail(function (response){
                console.log(response.responseJSON)
                $('#checkOTPInput').addClass('mb-1');
                $('#checkOTPInputError').fadeIn();
                $('#checkOTPInputError').html(response.responseJSON.errors.otp[0]);
            })

        });
        $('#resendOTPButton').click(function (event){
            event.preventDefault();
            $.post("{{url('/resend-otp')}}",
                {
                    '_token':"{{csrf_token()}}",
                    'login_token':loginToken
                },function (response,status){
                    loginToken = response.login_token;
                    swal({
                        icon:'success',
                        text:'رمز یک بار مصرف برای شما ارسال شد',
                        button:'حله',
                        timer:5000
                    })
                    // $('#loginForm').fadeOut();
                    $("#resendOTPButton").css("display", "none");
                    timer();
                    $('#resendOTPTime').css("display", "block");


                }
            ).fail(function (response){
                swal({
                    icon:'error',
                    text:'مشکل در ارسال دوباره رمز یکبار مصرف ، مجدد تلاش کنید ',
                    button:'حله',
                    timer:5000
                })
            })

        });
        function timer()
        {
            let time = "1:01";
            let interval = setInterval(function (){
                let countdown = time.split(':');
                let minutes = parseInt(countdown[0],10);
                let seconds = parseInt(countdown[1],10);
                --seconds;
                minutes = (seconds<0)?--minutes:minutes;
                if (minutes<0){
                    clearInterval(interval);
                    $('#resendOTPTime').hide();
                    $('#resendOTPButton').fadeIn();
                };
                seconds = (seconds<0)?59:seconds;
                seconds = (seconds<10)?'0'+seconds:seconds;
                $('#resendOTPTime').html(minutes+':'+seconds);
                time =minutes+':'+seconds;
            },1000);
        }

    </script>
    <script>
        function callbackThen(response){
            response.json().then(function (data){
                if (data.success && data.score>0.5){
                    console.log('valid score')
                }else{
                    document.getElementById('contact-form').addEventListener('submit',function (e){
                        event.preventDefault();
                        alert('recaptcha error.stop form submission')
                    });
                }
            });
        }
        function callbackCatch(error){
            console.log('Error: '+error)
        }
    </script>
@endsection
@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{route('home.index')}}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ورود </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-70 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> ورود / ثبت نام </h4>
                            </a>
                        </div>
                        <div class="tab-content">

                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">

                                    <div class="login-register-form">

                                        <form id="loginForm">

                                            <input id="cellphoneInput" name="cellphone" placeholder=" شماره تلفن همراه خود را وارد کنید"  type="text">
                                            <div class="input-error-validation" id="cellphoneInputError">
                                                <span id="cellphoneInputErrorText" style="font-size: 15px"></span>
                                            </div>
                                            <div class="button-box d-flex justify-content-between">
                                                <button type="submit" style="border-radius: 30px">ارسال کد تایید</button>
                                            </div>
                                        </form>

                                        <form id="checkOTPForm" style="display: none">
                                            <input id="checkOTPInput" placeholder="رمز یک بار مصرف را وارد کنید"  type="text">
                                            <div class="input-error-validation" id="checkOTPInputError">
                                                <strong id="checkOTPInputErrorText"></strong>
                                            </div>
                                            <div class="button-box d-flex justify-content-between">
                                                <button type="submit">ورود</button>
                                            <div>
                                                <button style="display: none" id="resendOTPButton" type="submit">ارسال مجدد</button>
                                                <span id="resendOTPTime" style="font-size: 15px;color: red"></span>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="mb-10 text-right">
                        <div class="alert alert-info"><h5>راهنما ورود به وبسایت</h5>
                            <hr>
                            <ul style="list-style:square" class="p-3">
                                <li class="p-1" ><p style="font-size: 15px">کاربران گرامی در حال حاضر ورود و ثبت نام فقط بر اساس شماره موبایل شما انجام میگیرد.</p></li>
                                <li class="p-1"><p style="font-size: 15px">   شماره موبایل که در دسترس و متعلق به خودتان است را برای تایید رمز یکبار مصرف وارد کنید.</p></li>
                                <li class="p-1"><p style="font-size: 15px">            ورود به وب سایت حتما با شماره ای که در مرحله ثبت نام تایید شده است باشد در غیر این صورت قادر به
                                        دسترسی اطلاعات کاربری خود از جمله تراکنش های انجام شده نیستید.</p></li>
                                <li class="p-1"><p style="font-size: 15px">در صورت وجود هرگونه مشکلات با یکی از راه های ارتباطی که در <a style="color: #418ed7"
                                            href="{{route('home.contact-us')}}">صفحه تماس با ما</a> ذکر شده اند به ما پیام دهید .</p></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
