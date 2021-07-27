<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ushauri - Getting better one text at a time</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
</head>

<body>
    <div class="auth-layout-wrap">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{ asset('/assets/images/ushauri_logo.png') }}" style="margin-left: 50px;" width="51%" height="60%">

                                <h4>Login</h4>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Phone Number/Email address</label>
                                    <input id="email" type="text" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <div class="">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>

                            </form>
                            @if (Route::has('password.request'))

                            <div class="mt-3 text-center">

                                <a href="#" class="text-muted"><u>Forgot
                                        Password?</u></a>
                            </div>
                            @endif
                            <div class="center">
                                <img class="pl-3" src="{{ asset('assets/images/login/moh.png') }}" alt="ushauri" height="40" style="margin-left: 20px;">
                                <img class="pl-3" src="{{ asset('assets/images/login/CDC-LOGO.jpg') }}" alt="ushauri" height="40" style="margin-left: 95px;">
                                <img class="pl-3" src="{{ asset('assets/images/login/logo_3.png') }}" alt="ushauri" width="31%" style="margin-left: 95px;">
                            </div>
                            <div class="register-link m-t-15 text-center">
                                <p>&copy; mHealth Kenya &nbsp;2016 - <?php echo date('Y'); ?> <b> Powered by : <a href="https://mhealthkenya.org/" target="_blank"> mHealth Kenya </a></b> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>