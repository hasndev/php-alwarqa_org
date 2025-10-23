<?php require_once(__DIR__ . '/../db.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content>
  <meta name="author" content>
  <link rel="icon" href="favicon.ico">
  <title>AlWarqa Organization - Login</title>
  <!-- Simple bar CSS -->
  <link rel="stylesheet" href="/cp/assets/css/simplebar.css">
  <!-- Fonts CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Icons CSS -->
  <link rel="stylesheet" href="/cp/assets/css/feather.css">
  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="/cp/assets/css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="/cp/assets/css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="/cp/assets/css/app-dark.css" id="darkTheme" disabled>
  <link rel="stylesheet" href="/cp/assets/css/app-rtl.css" id="darkTheme" disabled>
  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-x3u/yoA/Gsy4OPIeaWTZ0zx4DBLAfz21YYLqq5p6OwIgEdXq24THvA02HJS9mC+6" crossorigin="anonymous">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <link rel="icon" href="/assets/images/logo.png" type="/assets/image/x-icon" />
</head>

<body class="rtl">
  <div class="wrapper">

    <main class="wrapper">
      <div class="my-5"></div>
      <!-- Center the form horizontally and vertically -->
      <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-6 mt-4">
          <div class="w-50 mx-auto">
            <form class="mx-auto text-center" method="POST" id="login-form">
              <a class="navbar-brand mx-auto my-2 flex-fill text-center" href="/home">
                <img src="/assets/images/logo.png" style="height: 70px; width:70px;" alt="Hassan Jabbar Template">
              </a>
              <h4 class="mb-2">مرحباً بك في لوحة معلومات منظمة الورقة 🚀</h4>
              <p class="mb-4">يرجى تسجيل الدخول إلى الحساب الخاص بك</p>
              <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="اسم المستخدم" required autofocus>
              </div>
              <div class="form-group">
                <label for="inputPassword">كلمة المرور</label>
                <div class="input-group">
                  <input type="password" name="password" id="inputPassword" class="form-control form-control-lg" placeholder="كلمة المرور" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="showPasswordButton"><i class="fa fa-eye-slash"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">ابق متصلا</label>
              </div>
              <input class="btn btn-lg btn-primary btn-block" name="btn_login" type="submit" value="Let me in">
            </form>
          </div>
        </div>
      </div>
    </main>
    <!-- main -->
  </div> <!-- .wrapper -->
  <script src="/cp/assets/js/jquery.min.js"></script>
  <script src="/cp/assets/js/popper.min.js"></script>
  <script src="/cp/assets/js/moment.min.js"></script>
  <script src="/cp/assets/js/bootstrap.min.js"></script>
  <script src="/cp/assets/js/simplebar.min.js"></script>
  <script src='/cp/assets/js/daterangepicker.js'></script>
  <script src='/cp/assets/js/jquery.stickOnScroll.js'></script>
  <script src="/cp/assets/js/tinycolor-min.js"></script>
  <script src="/cp/assets/js/config.js"></script>
  <script src="/cp/assets/js/apps.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');

    document.addEventListener("DOMContentLoaded", function() {
      const passwordInput = document.getElementById("inputPassword");
      const showPasswordButton = document.getElementById("showPasswordButton");

      showPasswordButton.addEventListener("click", function() {
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          showPasswordButton.innerHTML = "<i class='fa fa-eye'></i>";
        } else {
          passwordInput.type = "password";
          showPasswordButton.innerHTML = "<i class='fa fa-eye-slash'></i>";
        }
      });
    });
  </script>

</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username) || empty($password)) {
    echo "<script>swal('Sign In', 'Please Fill in All Fields', 'error');</script>";
  } else {
    $q = "SELECT * FROM `users` where `username`=?";
    $d = getData($con, $q, [$username]);

    if (count($d)) {
      $pass = $d[0]['password'];
      if (password_verify($password, $pass)) {
        if ($d[0]['status'] == 1) {
          $_SESSION['is_login'] = 1;
          $_SESSION['user_id'] = $d[0]['id'];
          $_SESSION['permission'] = $d[0]['permission'];
          $_SESSION['uname'] = $d[0]['name'];
          $_SESSION['lvl'] = $d[0]['lvl'];
          echo '<script>location.replace("/cp/dashboard/main")</script>';
        } else {
          echo "<script>swal('Sign In', 'Your account is currently suspended, please check with the site administrator', 'error');</script>";
        }
      } else {
        echo "<script>swal('Sign In', 'Incorrect Username or Password, please try again', 'error');</script>";
      }
    } else {
      echo "<script>swal('Sign In', 'Incorrect Username or Password, please try again', 'error');</script>";
    }
  }
}


?>