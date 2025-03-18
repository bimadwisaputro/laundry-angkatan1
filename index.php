<?php
session_start();
include('php/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login Laundry PPKD</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/adminlte/assets/img/favicon.png" rel="icon">
    <link href="assets/adminlte/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- css spinner load -->
    <link rel="stylesheet" href="css/loading_spinner.css" type="text/css">
    <!-- Vendor CSS Files -->
    <link href="assets/adminlte/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/adminlte/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/adminlte/assets/css/style.css" rel="stylesheet">
    <!-- izitoast -->
    <link href="assets/iziToast/dist/css/iziToast.css" rel="stylesheet">

</head>

<body>
    <div id="loading">
        <div class="loader">
            <div class="inner one"></div>
            <div class="inner two"></div>
            <div class="inner three"></div>
        </div>
    </div>
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.php" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/adminlte/assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Laundry PPKD</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                    <?php if (isset($_GET['form']) && $_GET['form'] == 'register') { ?>
                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Register</h5>
                                            <p class="text-center small">Enter your personal details to create account</p>
                                        </div>

                                        <form class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="yourName" class="form-label">Your Name</label>
                                                <input type="text" name="name" class="form-control" id="yourName" placeholder="Enter Your Name" required>
                                                <div class="invalid-feedback">Please, enter your name!</div>
                                            </div>

                                            <div class="col-12">
                                                <label for="yourEmail" class="form-label">Your Email</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope"></i></span>
                                                    <input type="text" name="email" class="form-control" id="yourEmail" placeholder="Enter Your Email" required>
                                                    <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="yourPassword" class="form-label">Password</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-lock-fill"></i></span>
                                                    <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Enter Your Password" required>
                                                    <div class="invalid-feedback">Please enter your password!</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                                    <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                            </div>
                                            <div class="col-12">
                                                <p class="small mb-0">Already have an account? <a href="index.php">Log in</a></p>
                                            </div>
                                        </form>
                                    <?php } else { ?>

                                        <div class="pt-4 pb-2">
                                            <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                                            <p class="text-center small">Enter your Email & password to login</p>
                                        </div>

                                        <div class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope"></i></span>
                                                    <input type="email" name="username" class="form-control" id="email" required>
                                                    <div class="invalid-feedback">Please enter your Email.</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-lock-fill"></i></span>
                                                    <input type="password" name="password" class="form-control" id="password" required>
                                                    <div class="invalid-feedback">Please enter your password!</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-check">
                                                    <!-- <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">Remember me</label> -->
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100" type="button" id="login">Login</button>
                                            </div>
                                            <!-- tidak register jika ada admin yang mendaftarkan users -->
                                            <!-- <div class="col-12">
                                                <p class="small mb-0">Don't have account? <a href="?form=register">Register</a></p>
                                            </div> -->
                                            <div class="col-12">
                                                <div id="info"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="https://bootstrapmade.com/">@PPKD Jakarta Pusat</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Jquery -->
    <script src=" https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- Vendor JS Files -->
    <script src="assets/adminlte/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/adminlte/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/adminlte/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/adminlte/assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/adminlte/assets/vendor/quill/quill.js"></script>
    <script src="assets/adminlte/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/adminlte/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/adminlte/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/adminlte/assets/js/main.js"></script>
    <!-- izitoast -->
    <script src="assets/iziToast/dist/js/iziToast.js"></script>

    <script>
        iziToast.settings({
            timeout: 3000, // default timeout
            resetOnHover: true,
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX',
            position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            onOpen: function() {
                console.log('callback abriu!');
            },
            onClose: function() {
                console.log("callback fechou!");
            }
        });


        // info
        $('#infoClick').click(function() {
            iziToast.info({
                position: "center",
                title: 'Hello',
                message: 'iziToast.info()'
            });
        }); // ! click

        // success
        $('#successClick').click(function() {
            iziToast.success({
                timeout: 5000,
                icon: 'fa fa-chrome',
                title: 'OK',
                message: 'iziToast.sucess() with custom icon!'
            });
        }); // ! .click

        // warning
        $('#warningClick').click(function() {
            iziToast.warning({
                position: "bottomLeft",
                title: 'Caution',
                message: '日本語環境のテスト'
            });
        });

        // error
        $('#errorClick').click(function() {
            iziToast.error({
                title: 'Error',
                message: 'Illegal operation'
            });
        });

        // custom toast
        $('#customClick').click(function() {

            iziToast.show({
                color: 'dark',
                icon: 'fa fa-user',
                title: 'Hey',
                message: 'Custom Toast!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button>Ok</button>',
                        function(instance, toast) {
                            alert("Hello world!");
                        }
                    ],
                    [
                        '<button>Close</button>',
                        function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ]
                ]
            });

        }); // ! .click()



        $(document).ready(function() {
            $("#email").focus();
            setTimeout(function() {
                $('#loading').hide();
            }, 2000);
        })

        $(document).on('click', '[id=login]', function() {
            checkform();
        })

        $(document).on('keypress', '[id=password]', function(e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                checkform();
            }
        });

        function checkform() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;

            if (email == "" || password == "") {
                $("#info").html('<div class="alert alert-danger" role="alert">Email / Password Masih Kosong !</div>')
                iziToast.error({
                    timeout: 5000,
                    icon: 'fa fa-close',
                    title: 'Login Failed',
                    message: 'Email / Password Masih Kosong !'
                });
            }

            if (email != "" && password != "") {

                if (!emailPattern.test(email)) {
                    $("#info").html('<div class="alert alert-warning" role="alert">Email Tidak Valid! Gunakan format email</div>')
                    iziToast.warning({
                        timeout: 5000,
                        icon: 'fa fa-close',
                        title: 'Login Failed',
                        message: 'Email Tidak Valid! Gunakan format email'
                    });
                    $("#email").focus();
                    return false;
                }

                console.log(password);
                console.log(passwordPattern.test(password));
                // return false;

                if (!passwordPattern.test(password)) {
                    // console.log(password)
                    $("#info").html('<div class="alert alert-warning" role="alert">Password harus terdiri dari 8 karakter... 1 huruf besar, 1 huruf kecil , 1 angka dan 1 karakter khusus. </div>')
                    iziToast.warning({
                        timeout: 5000,
                        icon: 'fa fa-close',
                        title: 'Login Failed',
                        message: 'Password harus terdiri dari 8 karakter... 1 huruf besar, 1 huruf kecil , 1 angka dan 1 karakter khusus.'
                    });
                    $("#password").focus();
                    return false;
                }

                //post login ke php
                $('#loading').show();
                dataMap = {};
                dataMap['email'] = email;
                dataMap['password'] = password;
                $.post('php/login.php', dataMap, function(response) {
                    // Log the response to the consol
                    console.log(response);
                    var res = JSON.parse(response);
                    if (res.login_status == 1) {
                        $("#info").html('<div class="alert alert-success" role="alert">Login Success!</div>')
                        iziToast.success({
                            timeout: 5000,
                            icon: 'fa fa-check',
                            title: 'Login Success',
                            message: 'Loading Page.. !'
                        });
                        setTimeout(function() {
                            window.location.href = "home.php?page=dashboard";
                        }, 3000);
                    } else {
                        iziToast.error({
                            timeout: 5000,
                            icon: 'fa fa-close',
                            title: 'Login Failed',
                            message: '' + res.message + ''
                        });
                        $("#info").html('<div class="alert alert-danger" role="alert">' + res.message + '</div>')
                    }
                    setTimeout(function() {
                        $('#loading').hide();
                    }, 3000);
                });

            }

        }
    </script>

</body>

</html>