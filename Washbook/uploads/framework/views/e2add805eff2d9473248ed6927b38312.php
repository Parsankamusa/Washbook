<?php global $s_v_data, $title; ?>
<?= view( 'includes/auth-head', $s_v_data ); ?>

<style>
    .btn-google {
        background-color: #dd4b39;
        color: #fff;
    }

    .btn-facebook {
        background-color: #3b5998;
        color: #fff;
    }

    .btn-google:hover,
    .btn-facebook:hover {
        opacity: 0.8;
    }

    .btn-google i,
    .btn-facebook i {
        font-size: 15px;
    }
</style>

<body class="bg-white">
    <div class="auth-content">

        <div class="login-card">
            <div class="card-logo pb-4 text-center">
                <a href="<?=  env('APP_URL') ; ?>" class="logo-link">
                    <img class="logo-dark" src="<?=  asset('uploads/app/logo.png') ; ?>" alt="logo-dark">
                </a>
            </div>
            <div>
                <div>
                    <h3>Sign In</h3>
                    <p class="text-gray-500">Access your account using your email and password.</p>
                </div>
                <form class="simcy-form" action="<?=  url('Auth@signin') ; ?>" data-parsley-validate="" method="POST" loader="true" novalidate="">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label">Email Address</label>
                        </div>
                        <input type="email" class="form-control form-control-lg" name="email" placeholder="Enter your email address" required="">
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Password</label>
                            <a class="text-primary float-right" href="<?=  url('Auth@forgot') ; ?>">Forgot Password?</a>
                        </div>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control form-control-lg" name="password" placeholder="Enter your password" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block">Access Account</button>
                    </div>
                </form>
                <div class="social-auth-links text-center mt-4">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" onclick="signInWithGoogle(); return false;" class="btn btn-lg btn-google btn-block">
                                <i class="fab fa-google mr-2"></i> Sign in with Google
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" onclick="signInWithFacebook(); return false;" class="btn btn-lg btn-facebook btn-block">
                                <i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook
                            </a>
                        </div>
                <div class="text-center mt-2">
                    <p class="text-gray-500">Don't have an account? <a href="<?=  url('Auth@getstarted') ; ?>" class="text-primary">Create an Account</a></p>
                </div>
                
                    </div>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <p class="text-gray-500 mb-0">© <?=  date('Y') ; ?> <?=  env('APP_NAME') ; ?> • All Rights Reserved.</p>
        </div>
    </div>

    <?= view( 'includes/auth-scripts', $s_v_data ); ?>

    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

    <!-- Include Google Sign-In and Facebook JavaScript SDKs -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <script>
        // Google Sign-In
        function signInWithGoogle() {
            gapi.load('auth2', function() {
                gapi.auth2.init({
                    client_id: 'YOUR_GOOGLE_CLIENT_ID',
                    scope: 'profile email'
                }).then(function(auth2) {
                    auth2.signIn().then(function(googleUser) {
                        var profile = googleUser.getBasicProfile();
                        var userData = {
                            name: profile.getName(),
                            email: profile.getEmail(),
                            googleId: profile.getId()
                        };

                        fetch('/auth/google', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(userData)
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log('Google Sign-In successful');
                                // Redirect or perform additional actions as needed
                            } else {
                                console.error('Google Sign-In failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }, function(error) {
                        console.error('Google Sign-In error:', error);
                    });
                });
            });
        }

        // Facebook Sign-In
        function signInWithFacebook() {
            FB.init({
                appId: 'YOUR_FACEBOOK_APP_ID',
                cookie: true,
                xfbml: true,
                version: 'v3.2'
            });

            FB.login(function(response) {
                if (response.authResponse) {
                    FB.api('/me', { fields: 'name, email' }, function(response) {
                        var userData = {
                            name: response.name,
                            email: response.email,
                            facebookId: response.id
                        };

                        fetch('/auth/facebook', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(userData)
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log('Facebook Sign-In successful');
                                // Redirect or perform additional actions as needed
                            } else {
                                console.error('Facebook Sign-In failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    });
                } else {
                    console.error('Facebook Sign-In failed');
                }
            }, { scope: 'public_profile,email' });
        }
    </script>

</body>

</html>

<?php return;
