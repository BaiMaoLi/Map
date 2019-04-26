<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>GrandExpress</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Map Tracker') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">




    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{asset('css/login_page.css')}}">
    <link rel="stylesheet" href="{{asset('css/animation.css')}}">





</head>


<body>

<div class="login-wrap">
    <div class="login-html">
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
                <div class="sign-in-htm">

                    <div class="group">
                        <label for="email" class="label">Email Address</label>
                        <input id="email" type="email" class="input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required >
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>


                    <div class="group">
                        <label for="password" class="label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-check">
                        <div class="group">
                            <input type="checkbox" class="form-check form-check-input check" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember"><span class="icon"></span> {{ __('Remember Me') }}</label>
                        </div>
                    </div>

                    <div class="group">
                        <input type="submit" class="button" value="Sign In">
                    </div>
                    <div class="hr"></div>
                </div>
            </form>





            <div class="sign-up-htm">
                <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                    @csrf

                    <div class="group">
                        <label for="name" class="label">Username</label>
                        <input id="name" type="text" class="input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>


                    <div class="group">
                        <label for="email" class="label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email"  class="input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="group">
                        <label for="phone_number" class="label">Phone Number</label>
                        <input id="phone_number" type="text" class="input form-control" name="phone_number" required>
                        @if ($errors->has('phone_number'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                        @endif
                    </div>


                    <div class="group">
                        <label for="password" class="label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>


                    <div class="group">
                        <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control input" name="password_confirmation" required>
                    </div>

                    <input id="kind" type="hidden" class="form-control" name="kind" value="passanger">

                    <div class="form-check">
                        <div class="group">
                            <input type="checkbox" class="form-check form-check-input check" name="remember" id="driver" name="driver">
                            <label for="driver"><span class="icon"></span> I am a driver</label>
                        </div>
                    </div>



                    <div class="group profile_url_house" style="display:none; transition:display 1s;">
                        <label for="profile_url" class="label">Profile Url</label>
                        <input id="profile_url" type="text" class="input form-control" name="profile_url">
                        @if ($errors->has('profile_url'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('profile_url') }}</strong>
                                </span>
                        @endif
                    </div>


                    <div class="group">
                        <input type="submit" class="button" value="Sign Up">
                    </div>


                    {{--<div class="hr"></div>--}}
                    {{--<div class="foot-lnk">--}}
                    {{--<label for="tab-1">Already Member?</label>--}}
                    {{--</div>--}}
                </form>
            </div>
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('js/bootstrap-notify.js')}}"></script>

<script>
    $(document).ready(function(){

        $('#driver').change(function() {
            if (this.checked) {
                $('.profile_url_house').show();
                $('#kind').val("driver")
            }
            else{ $('.profile_url_house').hide();
                $('#kind').val("passanger");}
        });

    });


    // $.notify("Ensure your Location in your Settings is turned on", {
    //     animate: {
    //         enter: 'animated lightSpeedIn',
    //         exit: 'animated lightSpeedOut'
    //     }
    // });


    // $.notify( "Ensure your Location in your Settings is turned on");
    // $.notify("Ensure your Location in your Settings is turned on", {
    //     animate: {
    //         enter: 'animated fadeInRight',
    //         exit: 'animated fadeOutRight'
    //     }
    // });

    // $.notify("Ensure your Location in your Settings is turned on", {
    //     animate: {
    //         enter: 'animated bounceInDown',
    //         exit: 'animated bounceOutUp'
    //     }
    // });

    $.notify(
    {
        message:"Ensure your Location in your Settings is turned on",
        type:"danger"

    }, {
        animate: {
            enter: 'animated bounceIn',
            exit: 'animated bounceOut'
        }
    });



</script>

</body>

</html>































{{--<!DOCTYPE html>--}}
{{--<!DOCTYPE html>--}}
{{--<html lang="en" >--}}

{{--<head>--}}
    {{--<meta charset="UTF-8">--}}
    {{--<title>GrandEmpress</title>--}}
    {{--<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>--}}


    {{--<meta charset="utf-8">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}

    {{--<!-- CSRF Token -->--}}
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

    {{--<title>{{ config('app.name', 'Map Tracker') }}</title>--}}

    {{--<!-- Scripts -->--}}
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}



    {{--<!-- Fonts -->--}}
    {{--<link rel="dns-prefetch" href="https://fonts.gstatic.com">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}

    {{--<link rel="stylesheet" href="{{asset('css/login_page.css')}}">--}}


    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}



{{--</head>--}}


{{--<body>--}}

{{--<div class="login-wrap">--}}
    {{--<div class="login-html">--}}
        {{--<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>--}}
        {{--<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>--}}
        {{--<div class="login-form">--}}
            {{--<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">--}}
                {{--@csrf--}}
                {{--<div class="sign-in-htm">--}}

                    {{--<div class="group">--}}
                        {{--<label for="email" class="label">Email Address</label>--}}
                        {{--<input id="email" type="email" class="input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required >--}}
                        {{--@if ($errors->has('email'))--}}
                            {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}


                    {{--<div class="group">--}}
                        {{--<label for="password" class="label">{{ __('Password') }}</label>--}}
                        {{--<input id="password" type="password" class="input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>--}}
                        {{--@if ($errors->has('password'))--}}
                            {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                            {{--</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}

                    {{--<div class="form-check">--}}
                        {{--<div class="group">--}}
                            {{--<input type="checkbox" class="form-check form-check-input check" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
                            {{--<label for="remember"><span class="icon"></span> {{ __('Remember Me') }}</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="group">--}}
                        {{--<input type="submit" class="button" value="Sign In">--}}
                    {{--</div>--}}
                    {{--<div class="hr"></div>--}}
                {{--</div>--}}
            {{--</form>--}}





        {{--<div class="sign-up-htm">--}}
            {{--<form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">--}}
                {{--@csrf--}}

                {{--<div class="group">--}}
                    {{--<label for="name" class="label">Username</label>--}}
                    {{--<input id="name" type="text" class="input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>--}}
                    {{--@if ($errors->has('name'))--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                    {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}


                {{--<div class="group">--}}
                    {{--<label for="email" class="label">{{ __('E-Mail Address') }}</label>--}}
                    {{--<input id="email" type="email"  class="input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>--}}
                    {{--@if ($errors->has('email'))--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}

                {{--<div class="group">--}}
                    {{--<label for="phone_number" class="label">Phone Number</label>--}}
                    {{--<input id="phone_number" type="text" class="input form-control" name="phone_number" required>--}}
                    {{--@if ($errors->has('phone_number'))--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('phone_number') }}</strong>--}}
                                    {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}


                {{--<div class="group">--}}
                    {{--<label for="password" class="label">{{ __('Password') }}</label>--}}
                    {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input" name="password" required>--}}
                    {{--@if ($errors->has('password'))--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}


                {{--<div class="group">--}}
                    {{--<label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>--}}
                    {{--<input id="password-confirm" type="password" class="form-control input" name="password_confirmation" required>--}}
                {{--</div>--}}

                {{--<input id="kind" type="hidden" class="form-control" name="kind" value="passanger">--}}

                {{--<div class="form-check">--}}
                    {{--<div class="group">--}}
                        {{--<input type="checkbox" class="form-check form-check-input check" name="remember" id="driver" name="driver">--}}
                        {{--<label for="driver"><span class="icon"></span> I am a driver</label>--}}
                    {{--</div>--}}
                {{--</div>--}}



                {{--<div class="group profile_url_house" style="display:none; transition:display 1s;">--}}
                    {{--<label for="profile_url" class="label">Profile Url</label>--}}
                    {{--<input id="profile_url" type="text" class="input form-control" name="profile_url">--}}
                    {{--@if ($errors->has('profile_url'))--}}
                        {{--<span class="invalid-feedback" role="alert">--}}
                                    {{--<strong>{{ $errors->first('profile_url') }}</strong>--}}
                                {{--</span>--}}
                    {{--@endif--}}
                {{--</div>--}}


                {{--<div class="group">--}}
                    {{--<input type="submit" class="button" value="Sign Up">--}}
                {{--</div>--}}


                {{--<div class="hr"></div>--}}
                {{--<div class="foot-lnk">--}}
                    {{--<label for="tab-1">Already Member?</label>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

{{--</div>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
{{--<script src="{{asset('js/bootstrap-notify.js')}}"></script>--}}

{{--<script>--}}
    {{--$(document).ready(function(){--}}

        {{--$('#driver').change(function() {--}}
            {{--if (this.checked) {--}}
                {{--$('.profile_url_house').show();--}}
                {{--$('#kind').val("driver")--}}
            {{--}--}}
            {{--else{ $('.profile_url_house').hide();--}}
                {{--$('#kind').val("passanger");}--}}
        {{--});--}}

    {{--})--}}
    {{--// $.notify({--}}
    {{--//     // options--}}
    {{--//     message: 'Hello World'--}}
    {{--// },{--}}
    {{--//     // settings--}}
    {{--//     type: 'danger'--}}
    {{--// });--}}
    {{--// $.notifyDefaults({--}}
    {{--//     type: 'success',--}}
    {{--//     allow_dismiss: false--}}
    {{--// });--}}
    {{--// $.notify('You can not close me!');--}}
    {{--alert("Ensure your Location in your Settings is turned on");--}}

{{--</script>--}}

{{--</body>--}}

{{--</html>--}}