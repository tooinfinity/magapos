<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Compiled and minified CSS -->
    <title>Login</title>
    <style>
        .image {
            width: 100%;
            height: 100vh;
            margin: 0;
            padding: 0;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
            z-index: 1;
        }

        .login {
            width: 100%;
            height: 100vh;

        }

        .login-body {
            position: absolute;
            top: 25%;
            left: 30%;
            text-align: center;
        }

    </style>
</head>

<body>

    <div class="row no-gutters">
        <div class="col-md-6">
            <img class="image" src="{{ asset('/uploads/settings/informatique.jpg') }}" alt="">
        </div>
        <div class="col-md-6 login  mx-auto my-auto">
            <div class="login-body">

                <img class="pb-5" src="{{ asset('/uploads/settings/magasin_logo.png') }}" style="width:400px;"
                    alt="magasin logo">
                <h2>Welcome To Your Store</h2>
                <br>
                @include('partials._errors')
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="input-group mb-3">
                        <input class="form-control" placeholder="Enter Your Email" type="email" name="email" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input class="form-control" placeholder="Enter Your Password" type="password" name="password"
                            id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 offset-8">
                            <button type="submit" class="btn btn-primary btn-block float-right">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Compiled and minified JavaScript -->
    <script src="/js/materialize.min.js"></script>
</body>

</html>
