<?php  
  session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <link href="assets/img/logo-kma.png" rel="icon">
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="assets/css/style-login.css">
    <style>
        body {
            overflow: hidden;
        }
        @media (max-width: 500px) {
            body {
                overflow: hidden;
            }
            .login-wrap {
                position: fixed;
                width: 90%;
                height: 90%;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        }
    </style>
	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap py-5">
		      	        <div class="img d-flex align-items-center justify-content-center" style="background-image: url(images/KMA.png); background-color:white"></div>
                        <h3 class="text-center mb-0">Welcome</h3>
                        <p class="text-center">Please Login</p>
                            <?php
                                if (isset($_GET["gagal"])) { ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-size: 17px;">
                                    <strong> Username atau password salah. Silakan coba lagi.</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <?php unset($_GET["gagal"]);
                                    
                                } 
                            ?>

                            <?php
                                if (isset($_GET["belum_terdaftar"])) { ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-size: 17px;">
                                    <strong> Akun belum terdaftar.</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <?php unset($_GET["gagal"]);
                                    
                                } 
                            ?>

                            <script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href.split('?')[0]);
                            }
                            </script>
                            <?php  
                                // Check if alert session is set
                                if (isset($_SESSION['alert'])) {
                                    $alertType = $_SESSION['alert'];

                                    // Display alert based on the session value
                                    echo '  <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-size: 17px;">
                                                <strong>'.$alertType.'</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';

                                    // Clear the alert session after displaying it
                                    unset($_SESSION['alert']);
                                }
                            ?>
                        <form action="cek-login.php" class="login-form" method="POST">
                            <div class="form-group">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
                                <input type="text" name="username" class="form-control" placeholder="Masukan username" id="username">
                            </div>
                            <div class="form-group">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span></div>
                                <input type="password" name="password" class="form-control form-password" placeholder="Masukan password">
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-100 text-md-left ml-4">
                                    <input type="checkbox" class="form-check-input me-2 form-checkbox" id="show-password">
                                    <label for="show-password" class="text-white">Lihat Password</label>
                                </div>
                                <div class="w-100 text-md-right">
                                    <a href="lupa-password.php">Forgot Password</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn form-control btn-primary rounded submit px-3" name="login">Login</button>
                            </div>
                            <div class="w-100 text-center mt-4 text">
                                <p class="mb-0 text-white">Don't have an account?</p>
                                <a href="registrasi-user.php">Sign Up</a>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js-login/jquery.min.js"></script>
    <script src="js-login/popper.js"></script>
    <script src="js-login/bootstrap.min.js"></script>
    <script src="js-login/main.js"></script>
</body>
</html>
<script>
  var checkbox = document.getElementById('show-password');
  var password = document.querySelector('.form-password');

  checkbox.addEventListener('change', function() {
    if (password.type === 'password') {
      password.type = 'text';
    } else {
      password.type = 'password';
    }
  });
</script>

<script>
    // Fungsi untuk membuka pengaturan penghapusan cache
    function autoClearCache() {
        var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        var isFirefox = typeof InstallTrigger !== 'undefined';

        if (isChrome) {
            // Untuk Google Chrome
            chrome.browsingData.remove({}, { "appcache": true, "cache": true, "cookies": true });
        } else if (isFirefox) {
            // Untuk Mozilla Firefox
            browser.browsingData.remove({ "since": 0, "originTypes": { "unprotectedWeb": true } });
        } else {
            // Jika browser lain, berikan instruksi manual
            alert('Mohon hapus cache secara manual melalui pengaturan browser Anda.');
        }
    }

    // Panggil fungsi secara otomatis (opsional)
    autoClearCache();
</script>