<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('colorlib/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/toast.js') }}"></script>

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('colorlib/css/style.css') }}">
</head>

<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset('assets/img/instagram/instagram-4.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ route('page') }}" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        <form action="{{ route('authenticate') }}" method="POST" class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                <input type="text" name="email" id="your_name" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Password" required/>
                            </div>
                            {{-- <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term">
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember
                                    me</label>
                            </div> --}}
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="{{ asset('colorlib/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('colorlib/js/main.js') }}"></script>

    @if (Session::has('success'))
        <script>
            Toast.fire({
                timer: 3000,
                icon: 'success',
                title: '{{ session('success') }}',
            })
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Toast.fire({
                timer: 3000,
                icon: 'error',
                title: '{{ session('error') }}',
            })
        </script>
    @endif
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
