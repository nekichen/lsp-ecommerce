<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>

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
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="{{ route('register') }}" method="POST" class="register-form" id="register-form">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" required />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" required />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password" required />
                            </div>
                            {{-- <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password" id="re_pass" placeholder="Repeat your password"/>
                            </div> --}}
                            <div class="form-group">
                                <input type="checkbox" name="role" id="agree-term" class="agree-term" required>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all
                                    statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit"
                                    value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{ asset('assets/hoshi_ganteng.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ route('login') }}" class="signup-image-link">I am already member</a>
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
