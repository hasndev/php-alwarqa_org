<?php
$q = 'SELECT `id`,`name`, `pic`,`username`,`email`,`address`,`phone`,`status`
FROM `users` where `id`=?';
$users_details = getData($con, $q, [$_SESSION['user_id']]);
#
##
### Check the news is found or not and redirect if it not
if (count($users_details) == 0) {
  echo '<script>location.replace("/cp/dashboard/main")</script>';
  die;
}
#
$user = $users_details[0];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['info'])) {
  $err = "";
  #
  ##
  ###Check Input Vilidation
  if (!isset($_POST['name']) || empty($_POST['name']))
    $err = "الرجاء ادخال اسم الموظف";

  if (empty($err)) {
    //Update
    if ("info" == $opr_type && $_SESSION['user_id'] != 1) {
      $file_name = selectItem($con, 'users', 'pic', $_SESSION['user_id']);
      if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
        if ($file_name != '')
          unlink(__DIR__ . "/../assets/images/avatars/" . $file_name);
        $file_name = moveFile($_FILES['photo'], "avatars", "jpg");
      }
      #
      // vd($_FILES['photo']);
      // die;
      $q = 'UPDATE `users` SET `name`=?,`email`=?,`phone`=?, `address`=?, `pic`=? WHERE `id`=?';
      $d = setData($con, $q, [$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $file_name, $_SESSION['user_id']]);
      if ($d > 0)
        echo "<script>swal('تعديل الموظف', ' تم تحديث الموظف بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/profile');});</script>";
      else
        echo "<script>swal('تعديل الموظف', 'حدث خطأ ما في التعديل', 'error');</script>";
    }
  } else
    echo "<script>swal('الموظفين', '" . $err . "', 'error');</script>";
}
?>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <?php if (empty($opr_type)) { ?>
          <div class="container-xxl flex-grow-1 container-p-y">
            <h2 class="page-title">ملفي الشخصي</h2>
            <p>استكشاف وعرض تفاصيل ملفك الشخصي 🚀</p>
            <div class="row">
              <div class="col-md-12">
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#home">ملفي الشخصي</a>
                  </li>
                  <?php if ($_SESSION['user_id'] != 1) { ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/cp/dashboard/profile/info">تغيير بياناتي</a>
                    </li>
                  <?php } ?>
                </ul>
                <div class="card mb-4">
                  <h5 class="card-header">تفاصيل الملف الشخصي</h5>
                  <!-- Account -->
                  <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                      <img src="/cp/assets/images/avatars/<?= $user['pic'] ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                    </div>
                  </div>
                  <hr class="my-0" />
                  <div class="card-body">
                    <div class="row">
                      <div class="mb-3 col-md-6">
                        <label for="firstName" class="form-label"><strong>الاسم</strong></label>
                        <p><?= $user['name'] ?></p>
                      </div>
                      <div class="mb-3 col-md-6">
                        <label for="email" class="form-label"><strong>اسم المستخدم</strong></label>
                        <p>@<?= $user['username'] ?></p>
                      </div>
                      <div class="mb-3 col-md-6">
                        <label for="email" class="form-label"><strong>البريد الاكتروني</strong></label>
                        <p><?= $user['email'] ?></p>
                      </div>
                      <div class="mb-3 col-md-6">
                        <label class="form-label" for="phoneNumber"><strong>رقم الهاتف</strong></label>
                        <p><?= $user['phone'] ?></p>
                      </div>
                      <div class="mb-3 col-md-6">
                        <label class="form-label" for="phoneNumber"><strong>عنوان السكن</strong></label>
                        <p><?= $user['address'] ?></p>
                      </div>
                    </div>
                  </div>
                  <!-- /Account -->
                </div>
              </div>
            </div>
          </div>

        <?php }
        if ("info" == $opr_type && $_SESSION['user_id'] != 1) {
        ?>
          <div class="container-xxl flex-grow-1 container-p-y">
            <h2 class="page-title">ملفي الشخصي</h2>
            <p>قم بتحديث التفاصيل الخاصة بك 🚀</p>
            <form class="needs-validation" method="POST" enctype="multipart/form-data">
              <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" href="/cp/dashboard/profile">ملفي الشخصي</a>
                </li>
                <?php if ($_SESSION['user_id'] != 1) { ?>
                  <li class="nav-item">
                    <a class="nav-link active" href="/cp/dashboard/profile/info">تغيير بياناتي</a>
                  </li>
                <?php } ?>
              </ul>
              <div class="row mt-5 align-items-center">
                <div class="col-md-3 text-center mb-5">
                  <div class="avatar avatar-xl">
                    <img src="/cp/assets/images/avatars/<?= $user['pic'] ?>" alt="..." class="avatar-img rounded-circle">
                  </div>
                </div>
                <div class="col">
                  <div class="row align-items-center">
                    <div class="col-md-7">
                      <h4 class="mb-1"><?= $user['name'] ?></h4>
                      <h6 class="small"><span class="badge badge-dark">@<?= $user['username'] ?></span></h6>
                      <h6 class="small mb-3"><span class="badge badge-dark"><?= $_SESSION['lvl'] == '1' ? "Admin" : "Employee" ?></span></h6>
                    </div>
                  </div>
                  <div class="row mb-4">
                    <div class="col">
                      <p class="small mb-0 text-muted"><?= $user['address'] ?></p>
                      <p class="small mb-0 text-muted"><?= $user['email'] ?></p>
                      <p class="small mb-0 text-muted"><?= $user['phone'] ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <hr class="my-4">
              <div class="form-group">
                <label for="name">الاسم الكامل</label>
                <input type="text" name="name" id="name" value="<?= isset($user['name']) ? $user['name'] : '' ?>" class="form-control" placeholder="الاسم الكامل">
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email">البريد الالكتروني</label>
                  <input type="email" name="email" class="form-control" id="email" value="<?= isset($user['email']) ? $user['email'] : '' ?>" placeholder="البريد الالكتروني">
                </div>
                <div class="form-group col-md-6">
                  <label for="phone">رقم الهاتف</label>
                  <input type="text" name="phone" class="form-control" id="phone" value="<?= isset($user['phone']) ? $user['phone'] : '' ?>" placeholder="رقم الهاتف">
                </div>
              </div>
              <div class="form-group">
                <label for="address">عنوان السكن</label>
                <input type="text" name="address" class="form-control" id="address" value="<?= isset($user['address']) ? $user['address'] : '' ?>" placeholder="عنوان السكن">
              </div>

              <label for="photo">اختيار صورة</label>
              <div class="custom-file mb-3">
                <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" />
              </div>
              <button type="submit" class="btn btn-primary" name="info">حفظ التغيير</button>
            </form>
          </div>

        <?php } ?>

      </div> <!-- /.col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->