<?php
#
##
### Check if the user Have permission or not not
if ($_SESSION['lvl'] != 1) {
  echo '<script>location.replace("/cp/dashboard/main")</script>';
}
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <?php
      #Add and Update User
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['addnew']) || isset($_POST['update']))) {
        $err = "";
        #
        ##
        ###Check Input Vilidation
        if (!isset($_POST['name']) || empty($_POST['name']))
          $err = "الرجاء ادخال اسم الموظف";
        #
        if (!isset($_POST['username']) || empty($_POST['username']))
          $err = "الرجاء ادخال اسم المستخدم للموظف";
        #
        if (strlen($_POST['username']) != strlen(utf8_decode($_POST['username']))) {
          $err = "الرجاء ادخال اسم المستخدم للموظف باللغة الانكليزية";
        }
        #
        if (!empty($_POST['username'])) {
          if (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 20) {
            $err .= "يجب أن يتراوح اسم المستخدم بين 3 و20 حرفًا. ";
          }
          if (!preg_match("/^[a-z0-9_]+$/", $_POST['username'])) {
            $err .= "يمكن أن يحتوي اسم المستخدم فقط على أحرف صغيرة وأرقام وشرطات سفلية.";
          }
        }
        #
        ##
        ###Check Username is exsist For Edit Opreation
        if ("edit" == $opr_type && !empty($id)) {
          $username = selectItem($con, 'users', 'username', $id);
          if ($username != $_POST['username']) {
            $ues = $_POST['username'];
            $q = "SELECT `id` FROM `users` WHERE `username`=?";
            $d = getData($con, $q, [$ues]);
            if (count($d) > 0) $err = "اسم المستخدم موجود بالفعل! غيرها من فضلك";
          }
        }
        #
        ##
        ###Check Username is exsist For Add Opreation
        if ("add" == $opr_type) {
          $q = "SELECT `id` FROM `users` WHERE `username`=?";
          $d = getData($con, $q, [$_POST['username']]);
          if (count($d) > 0)
            $err = "اسم المستخدم موجود بالفعل! غيرها من فضلك";
          #
        }
        #
        $per[0] = 1;
        for ($i = 1; $i < 60; $i++) {
          $per[$i] = 0;
        }

        if ($_POST['lvl'] == 1) {
          for ($i = 1; $i < 60; $i++) {
            $per[$i] = 1;
          }
        } else {
          for ($i = 1; $i < 60; $i++) {
            if (isset($_POST['per' . $i])) $per[$i] = 1;
          }
        }

        $permission = "";
        foreach ($per as $p) {
          $permission .= $p;
        }

        if (empty($err)) {
          //Update
          if ("edit" == $opr_type && !empty($id)) {
            $file_name = selectItem($con, 'users', 'pic', $id);
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              if ($file_name != '')
                unlink(__DIR__ . "/../assets/images/avatars/" . $file_name);
              $file_name = moveFile($_FILES['photo'], "avatars", "jpg");
            }
            #
            $q = 'UPDATE `users` SET `name`=?,`username`=?,`email`=?,`phone`=?, `address`=?, `pic`=?, `permission`=?,`lvl`=? WHERE `id`=?';
            $d = setData($con, $q, [$_POST['name'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['address'], $file_name, $permission, $_POST['lvl'], $id]);
            if ($d > 0)
              echo "<script>swal('تعديل الموظف', ' تم تحديث الموظف بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/accounts');});</script>";
            else
              echo "<script>swal('تعديل الموظف', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //Add
          if ("add" == $opr_type) {
            #upload page photo
            $file_name = '';
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $file_name = moveFile($_FILES['photo'], "avatars", "jpg");
            } else $file_name = '';
            #
            $password = password_hash("12345", PASSWORD_DEFAULT);
            #
            $q = 'INSERT INTO `users`(`name`, `username`, `email`,`phone`, `address`, `pic`, `password`,`permission`,`lvl`) VALUES (?,?,?,?,?,?,?,?,?)';
            $d = setData($con, $q, [$_POST['name'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['address'], $file_name, $password, $permission, $_POST['lvl']]);
            #
            if ($d > 0)
              echo "<script>swal('إضافة موظف', ' تمت إضافة الموظف بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/accounts');});</script>";
            else
              echo "<script>swal('إضافة موظف', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
          }
        } else
          echo "<script>swal('الموظفين', '" . $err . "', 'error');</script>";
      }
      #Active
      if ("active" == $opr_type && !empty($id)) {
        $q = 'UPDATE `users` SET `status`=? WHERE `id`=? and id>2';
        $d = setData($con, $q, [1, $id]);
        echo '<script>location.replace("/cp/dashboard/accounts")</script>';
        die();
      }
      #NotActive
      if ("notactive" == $opr_type && !empty($id)) {
        $q = 'UPDATE `users` SET `status`=? WHERE `id`=? and id>2';
        $d = setData($con, $q, [0, $id]);
        echo '<script>location.replace("/cp/dashboard/accounts")</script>';
        die();
      }
      #Reset Password
      if ("reset" == $opr_type && !empty($id)) {
        #
        $password = password_hash("12345", PASSWORD_DEFAULT);
        #
        $q = 'UPDATE `users` SET `password`=? WHERE `id`=? and id>2';
        $d = setData($con, $q, [$password, $id]);
        echo '<script>location.replace("/cp/dashboard/accounts")</script>';
        die();
      }

      if (empty($opr_type)) { ?>
        <h2 class="page-title">نظرة عامة على الحسابات</h2>
        <p>استكشاف وعرض تفاصيل الحسابات 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل الحسابات</h5>
              <h5 class="filter"><a href="/cp/dashboard/accounts/add"><i class='fe fe-plus-square icon'></i></a></h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>صورة</th>
                      <th>الاسم الكامل</th>
                      <th>اسم المستخدم</th>
                      <th>رقم الهاتف</th>
                      <th>الحالة</th>
                      <th>العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $params = [];
                    $whr = "";
                    #
                    if ($_SESSION['lvl'] != 1) {
                      $whr .= " AND `d`.`user_id`=?";
                      $params[] = $_SESSION['user_id'];
                    }

                    #
                    $sn = 1;
                    $q = 'SELECT `id`,`name`, `pic`,`username`,`phone`,`status`
                      FROM `users` WHERE id>2 and id!=? Order by id DESC';
                    $D = getData($con, $q, [$_SESSION['user_id']]);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td>
                          <?php if ($row['pic'] != '') { ?>
                            <img src="/cp/assets/images/avatars/<?= $row['pic']; ?>" alt="Account Picture" style="max-height: 100px; max-width: 160px;" />
                          <?php } else echo "لا توجد صورة" ?>
                        </td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td>
                          <?php
                          if ($row['status'] == 1)
                            echo '<span class="bg-success text-white p-2 rounded">فعال</span>';
                          else
                            echo '<span class="bg-danger text-white p-2 rounded">محظور</span>';
                          ?>
                        </td>
                        <td>
                          <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">العمليات</span>
                          </button>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/accounts/details/<?= $row['id'] ?>"><i class="fe fe-info me-1"></i> نفاصبل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/accounts/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/accounts/reset/<?= $row['id'] ?>"><i class="fe fe-key me-1"></i> استعادة كلمة المرور</a>
                            <?php
                            if ($row['status'] == 1)
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/accounts/notactive/' . $row['id'] . '"><i class="fa fa-lock me-1"></i> حظر</a> ';
                            else
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/accounts/active/' . $row['id'] . '"><i class="fa fa-unlock me-1"></i> تفعيل</a> ';
                            ?>
                          </div>
                        </td>
                      </tr>
                    <?php
                    }

                    ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> <!-- simple table -->


      <?php }

      if ("details" == $opr_type && !empty($id)) {

        $q = 'SELECT `id`,`name`, `pic`,`username`,`email`,`address`,`phone`,`status`
          FROM `users` where `id`=?';
        $users_details = getData($con, $q, [$id]);
        #
        ##
        ### Check the news is found or not and redirect if it not
        if (count($users_details) == 0) {
          echo '<script>location.replace("/cp/dashboard/main")</script>';
          die;
        }
        #
        $user = $users_details[0];
      ?>

        <div class="container-xxl flex-grow-1 container-p-y">
          <h2 class="page-title">تفاصيل الحساب</h2>
          <p>استكشاف وعرض تفاصيل الحساب 🚀</p>

          <div class="row">
            <div class="col-md-12">

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
                      <p><?= $user['username'] ?></p>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="email" class="form-label"><strong>البريد الالكتروني</strong></label>
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

      if ("add" == $opr_type || "edit" == $opr_type) {
        $whr = "";
        $params = [];
        if ("edit" == $opr_type && !empty($id)) {
          $q = 'SELECT `id`,`name`, `pic`,`username`,`email`,`phone`,`address`,`permission`,`status`,`lvl`
            FROM `users` where `id`=? and id>2 and id!=? ';
          $users = getData($con, $q, [$id, $_SESSION['user_id']]);
          #
          ##
          ### Check the user is found or not and redirect if it not
          if (count($users) == 0) {
            echo '<script>location.replace("/cp/dashboard/main")</script>';
          }
        }
      ?>
        <h2 class="page-title"><?= "edit" == $opr_type ? "نعديل" : "اضافة" ?> حساب</h2>
        <p>استكشاف وإضافة الحسابات 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <strong class="card-title"><?= "edit" == $opr_type ? "نعديل" : "اضافة" ?> حساب</strong>
              </div>
              <div class="card-body">
                <form class="needs-validation" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="name">الاسم الكامل <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= isset($users[0]['name']) ? $users[0]['name'] : '' ?>" placeholder="الاسم الكامل" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="username">اسم المستخدم <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" id="username" value="<?= isset($users[0]['username']) ? $users[0]['username'] : '' ?>" placeholder="اسم المستخدم" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="email">البريد الالكتروني <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= isset($users[0]['email']) ? $users[0]['email'] : '' ?>" placeholder="البريد الالكتروني" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="phone">رقم الهاتف <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" id="phone" value="<?= isset($users[0]['phone']) ? $users[0]['phone'] : '' ?>" placeholder="رقم الهاتف" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="address">عنوان السكن <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" id="address" value="<?= isset($users[0]['address']) ? $users[0]['address'] : '' ?>" placeholder="عنوان السكن">
                  </div>

                  <?php if ("edit" == $opr_type) { ?>
                    <div class="col-lg-12 mb-4">
                      <label for="pic">الصورة الحالية </label><br>
                      <img src="/cp/assets/images/avatars/<?= $users[0]['pic'] ?>" height="100px" width="100px" alt="">
                    </div>
                  <?php } ?>

                  <label for="photo">اختيار صورة <span class="text-danger">*</span></label>
                  <div class="custom-file mb-3">
                    <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" multiple />
                  </div>

                  <label for="lvl">نوع الحساب</label>
                  <div class="input-group mb-3">
                    <select class="custom-select" name="lvl" id="lvl" aria-label="Example select with button addon">
                      <option value="2" <?= isset($users[0]['lvl']) && ($users[0]['lvl'] == 2) ? " selected " : "" ?>>حساب موظف</option>
                      <option value="1" <?= isset($users[0]['lvl']) && ($users[0]['lvl'] == 1) ? " selected " : "" ?>>خساب ادمن</option>
                    </select>
                  </div>

                  <div class="card mb-4 border-right-primary" id="permissionsCard">
                    <div class="card-header text-primary font-weight-bold">الصلاخيات</div>
                    <div class="card-body">

                      <!-- Categories -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per1" id="per1" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 1, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per1">الاصناف</label>
                      </div>

                      <!-- Programs -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per5" id="per5" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 5, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per5">البرامج</label>
                      </div>

                      <!-- Events -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per10" id="per10" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 10, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per10">النشاطات</label>
                      </div>


                      <!-- Gallery -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per15" id="per15" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 15, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per15">المعرض</label>
                      </div>


                      <!-- Stories -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per20" id="per20" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 20, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per20">قصص النجاح</label>
                      </div>


                      <!-- Members -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per30" id="per30" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 30, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per30">الاعضاء</label>
                      </div>


                      <!-- Contacts -->
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="per40" id="per40" <?php if (isset($users[0]['permission']) && (substr($users[0]['permission'], 40, 1) == 1)) echo "checked='checked'"; ?>>
                        <label class="form-check-label" for="per40">المراسلات</label>
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary" name="<?= "edit" == $opr_type ? "update" : "addnew" ?>"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?></button>
                </form>
              </div>
            </div> <!-- /.card-body -->
          </div> <!-- /.card -->
        </div> <!-- /.col -->


      <?php } ?>

    </div> <!-- .col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->

<script>
  $(document).ready(function() {
    var permissionsCard = $('#permissionsCard');
    var selectUserType = $('#lvl');

    // Show/hide permissions card based on user type selection
    selectUserType.change(function() {
      if (selectUserType.val() == '1') { // Admin selected
        permissionsCard.hide();
      } else { // Employee or other options selected
        permissionsCard.show();
      }
    });

    // Trigger change event on page load to handle initial display
    selectUserType.trigger('change');
  });
</script>