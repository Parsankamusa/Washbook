<?php global $s_v_data, $title; ?>
<?= view( 'includes/auth-head', $s_v_data ); ?>

<body class="bg-white">
    <div class="auth-content">

        <div class="login-card wide">
            <div class="card-logo pb-4 text-center">
                <a href="<?=  env('APP_URL') ; ?>" class="logo-link">
                    <img class="logo-dark" src="<?=  asset('uploads/app/logo.png') ; ?>" alt="logo-dark">
                </a>
            </div>
            <div>
                <div>
                    <h3>Create Account</h3>
                    <p class="text-gray-500">Enter your details to create a new account.</p>
                </div>
                <form class="simcy-form" action="<?=  url('Auth@createaccount') ; ?>" data-parsley-validate="" method="POST" loader="true" novalidate="" onsubmit="return handleFormSubmit(event)">
                    <div class="row space-nne">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label">First Name</label>
                                </div>
                                <input type="text" class="form-control form-control-lg" name="fname" placeholder="First Name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label">First Name</label>
                                </div>
                                <input type="text" class="form-control form-control-lg" name="lname" placeholder="First Name" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label">Company Name</label>
                                </div>
                                <input type="text" class="form-control form-control-lg" name="company" placeholder="Company Name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label">Email Address</label>
                                </div>
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Email Address" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label">Phone Number</label>
                                </div>
                                <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" required="">
                                <input class="hidden-phone" type="hidden" name="phonenumber">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label class="form-label">Password</label>
                                </div>
                                <input type="password" class="form-control form-control-lg" name="password" placeholder="Enter your password" required="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-1">
                        <button class="btn btn-lg btn-primary btn-block mt-1">Create Account</button>
                    </div>
                </form>
                <div class="text-center mt-2">
                    <p class="text-gray-500">Already have an account? <a href="<?=  url('Auth@get') ; ?>" class="text-primary">Sign In</a></p>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <p class="text-gray-500 mb-0">© <?=  date('Y') ; ?> <?=  env('APP_NAME') ; ?> • All Rights Reserved.</p>
        </div>
    </div>

    <?= view( 'includes/auth-scripts', $s_v_data ); ?>

    <script>
        function handleFormSubmit(event) {
            event.preventDefault(); 
            const formData = new FormData(event.target);
            fetch('<?=  url("Auth@createaccount") ; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                   
                    window.location.href = '<?=  url("Auth@get") ; ?>';
                } else {
                    console.error('Error:', response.status);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

            return false;
        }
    </script>

</body>

</html>

<?php return;
