<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>GrandEmpress</title>
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
    <link rel="stylesheet" href="{{asset('admin/login_page.css')}}">


</head>


<body>

<div class="login-wrap">
    <div class="login-html">
        {{--<input id="tab-1" type="radio" name="tab" class="sign-in" checked style="display:none"><label for="tab-1" class="tab">Sign In</label>--}}
        {{--<input id="tab-2" type="radio" name="tab" class="sign-up" style="display:none"><label for="tab-2" class="tab">Sign Up</label>--}}
        <div class="login-form">
            <form method="POST" action="admin-login" aria-label="{{ __('Login') }}">
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
                    {{--<div class="foot-lnk">--}}
                        {{--<a href="#forgot">Forgot Password?</a>--}}
                    {{--</div>--}}
                </div>
            </form>

        </div>
    </div>

</div>

</body>

</html>