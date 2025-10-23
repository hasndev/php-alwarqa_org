<?php require_once(__DIR__ . '/../db.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content>
  <meta name="author" content>
  <link rel="icon" href="favicon.ico">
  <title>AlWarqa Organization - Change Password</title>
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
  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-x3u/yoA/Gsy4OPIeaWTZ0zx4DBLAfz21YYLqq5p6OwIgEdXq24THvA02HJS9mC+6" crossorigin="anonymous">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <link rel="icon" href="/assets/images/logo.png" type="/assets/image/x-icon" />
</head>

<body>
  <div class="wrapper rtl">

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
              <p class="mb-4">قم بتغيير كلمة المرور الخاصة بك لتكون آمنًا</p>
              <div class="form-group">
                <label for="username">اسم المستخدم</label>
                <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="اسم المستخدم" required autofocus>
              </div>
              <div class="form-group">
                <label for="c_password">كلمة المرور الحالية</label>
                <div class="input-group">
                  <input type="password" name="c_password" id="c_password" class="form-control form-control-lg inputPassword" placeholder="كلمة المرور الحالية" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary showPasswordButton" type="button"><i class="fa fa-eye-slash"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="n_password">كلمة المرور الجديدة</label>
                <div class="input-group">
                  <input type="password" name="n_password" id="n_password" class="form-control form-control-lg inputPassword" placeholder="كلمة المرور الجديدة" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary showPasswordButton" type="button"><i class="fa fa-eye-slash"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="con_password">تأكيد كلمة المرور</label>
                <div class="input-group">
                  <input type="password" name="con_password" id="con_password" class="form-control form-control-lg inputPassword" placeholder="تأكيد كلمة المرور" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary showPasswordButton" type="button"><i class="fa fa-eye-slash"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Stay logged
                  in</label>
              </div>
              <input class="btn btn-lg btn-primary text-white btn-block" name="btn_change_pass" type="submit" value="Let me in">
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

    $(document).ready(function() {
      const passwordInputs = $(".inputPassword");
      const showPasswordButtons = $(".showPasswordButton");

      showPasswordButtons.on("click", function() {
        const passwordInput = $(this)
          .closest(".input-group")
          .find(".form-control");

        if (passwordInput.attr("type") === "password") {
          passwordInput.attr("type", "text");
          $(this).html("<i class='fa fa-eye'></i>");
        } else {
          passwordInput.attr("type", "password");
          $(this).html("<i class='fa fa-eye-slash'></i>");
        }
      });
    });
  </script>

</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_change_pass'])) {
  global $con;
  $username = $_POST['username'];
  $c_password = $_POST['c_password'];
  $n_password = $_POST['n_password'];
  $con_password = $_POST['con_password'];

  if (isset($username)) {
    $sql = "SELECT * FROM `users` WHERE `username`=?";
    $res = getData($con, $sql, [$username]);
    if (count($res) > 0) {
      $pass = $res[0]['password'];
      if (password_verify($c_password, $pass)) {
        if ($n_password == $con_password) {
          $new_pass = password_hash($n_password, PASSWORD_DEFAULT);
          $exit = "UPDATE `users` SET `password` = ? where `username` =?";
          $result = setData($con, $exit, [$new_pass, $username]);
          if ($result) {
            echo "<script>swal('Change Password', 'Password Changed successfully', 'success').then((value) => {location.replace('logout');});</script>";
          } else {
            echo "<script>swal('Change Password', 'Something went wrong', 'error');</script>";
          }
        } else {
          echo "<script>swal('Change Password', 'The new password you entered does not match', 'error');</script>";
        }
      } else {
        echo "<script>swal('Change Password', 'Incorrect username or password, please try again', 'error');</script>";
      }
    } else {
      echo "<script>swal('Change Password', 'Incorrect username or password, please try again', 'error');</script>";
    }
  }
}


?>