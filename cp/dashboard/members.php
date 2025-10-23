<?php
#
##
### Check if the user Have permission or not not
if (substr($_SESSION['permission'], 16, 1) != 1) {
  echo '<script>location.replace("/cp/dashboard/main")</script>';
}
?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <?php
      #Add and Update News
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['addnew']) || isset($_POST['update']))) {
        $err = "";
        #
        ##
        ###Check Input Vilidation
        if (!isset($_POST['name']) || empty($_POST['name']))
          $err = "الرجاء ادخال اسم العضو";
        #
        if (empty($err)) {
          //Update
          if ("edit" == $opr_type && !empty($id)) {

            $file_name = selectItem($con, 'members', 'pic', $id);

            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              if ($file_name != '')
                unlink(__DIR__ . "/../assets/images/members/" . $file_name);
              $file_name = moveFile($_FILES['photo'], "members", "jpg");
            }
            #
            $q = 'UPDATE `members` SET `name`=?, `job`=?,`facebook`=?,`instagram`=?,`linkedin`=?,`twitter`=?,`pic`=?,`done_by`=? WHERE `id`=?';
            $d = setData($con, $q, [
              $_POST['name'], $_POST['job'], $_POST['facebook'], $_POST['instagram'],
              $_POST['linkedin'], $_POST['twitter'], $file_name, $_SESSION['user_id'], $id
            ]);
            if ($d > 0)
              echo "<script>swal('تعديل العضو', ' تم تحديث العضو بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/members');});</script>";
            else
              echo "<script>swal('تعديل العضو', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //Add
          if ("add" == $opr_type) {
            #upload page photo
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $file_name = moveFile($_FILES['photo'], "members", "jpg");
            } else $file_name = '';
            // vd($file_name);
            #
            $q = 'INSERT INTO `members`(`name`, `job`,`facebook`,`instagram`,`linkedin`,`twitter`, `pic`, `done_by`) VALUES (?,?,?,?,?,?,?,?)';
            $d = setData($con, $q, [
              $_POST['name'], $_POST['job'], $_POST['facebook'], $_POST['instagram'],
              $_POST['linkedin'], $_POST['twitter'], $file_name, $_SESSION['user_id']
            ]);
            #
            if ($d > 0) {
              echo "<script>swal('اضافة عضو', ' تمت إضافة العضو بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/members');});</script>";
            } else
              echo "<script>swal('اضافة عضو', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
          }
        } else
          echo "<script>swal('الاعضاء', '" . $err . "', 'error');</script>";
      }
      #Delete News
      if ("delete" == $opr_type && !empty($id)) {
        $file_name = selectItem($con, 'members', 'pic', $id);
        if ($file_name != '')
          unlink(__DIR__ . "/../assets/images/members/" . $file_name);

        $q = 'DELETE FROM `members` WHERE id=?';
        $d = setData($con, $q, [$id]);
        echo '<script>location.replace("/cp/dashboard/members")</script>';
        die();
      }
      #Active
      if ("active" == $opr_type && !empty($id)) {
        $q = 'UPDATE `members` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [1, $id]);
        echo '<script>location.replace("/cp/dashboard/members")</script>';
        die();
      }
      #NotActive
      if ("notactive" == $opr_type && !empty($id)) {
        $q = 'UPDATE `members` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [0, $id]);
        echo '<script>location.replace("/cp/dashboard/members")</script>';
        die();
      }

      if (empty($opr_type)) { ?>
        <h2 class="page-title">الاعضاء</h2>
        <p>استكشاف وعرض تفاصيل الاعضاء 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل الاعضاء</h5>
              <h5 class="filter"><a href="/cp/dashboard/members/add"><i class='fe fe-plus-square icon'></i></a></h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الصورة</th>
                      <th>الاسم</th>
                      <th>العنوان الوظيفي</th>
                      <th>الحسابات</th>
                      <th>تم بواسطة</th>
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
                    $q = 'SELECT *,
                      (SELECT `name` From `users` WHERE `users`.`id`=`members`.`done_by`) emp
                      FROM `members` Order by id DESC';
                    $D = getData($con, $q);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><img src="/cp/assets/images/members/<?= $row['pic'] ?>" style="max-height: 100px; max-width: 100px;border-radius:10px;" alt="Project"></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['job'] ?></td>
                        <td class="">
                          <?php
                          if ($row['instagram'] != '')
                            echo '<a href="' . $row['instagram'] . '" target="_blank"><i class="fab fa-instagram fa-lg"></i></a> ';
                          if ($row['facebook'] != '')
                            echo '<a href="' . $row['facebook'] . '" target="_blank"><i class="fab fa-facebook fa-lg"></i></a> ';
                          if ($row['linkedin'] != '')
                            echo '<a href="' . $row['linkedin'] . '" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a> ';
                          if ($row['twitter'] != '')
                            echo '<a href="' . $row['twitter'] . '" target="_blank"><i class="fab fa-twitter fa-lg"></i></a> ';
                          ?>
                        </td>
                        <td><?= $row['emp'] ?></td>
                        <td>
                          <?php
                          if ($row['status'] == 1)
                            echo '<span class="bg-success text-white p-2 rounded">ظاهر</span>';
                          else
                            echo '<span class="bg-danger text-white p-2 rounded">مخفي</span>';
                          ?>
                        </td>
                        <td>
                          <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">Action</span>
                          </button>
                          <div class="dropdown-menu dropdown-menu-right text-right align-right">
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/members/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/members/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                            <?php
                            if ($row['status'] == 1)
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/members/notactive/' . $row['id'] . '"><i class="fa fa-eye-slash me-1"></i> اخفاء</a> ';
                            else
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/members/active/' . $row['id'] . '"><i class="fa fa-eye me-1"></i> اظهار</a> ';
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

      if ("add" == $opr_type || "edit" == $opr_type) {
        $whr = "";
        $params = [];
        if ("edit" == $opr_type && !empty($id)) {
          $q = 'SELECT *,
            (SELECT `name` From `users` WHERE `users`.`id`=`members`.`done_by`) emp
            FROM `members` where `id`=?';
          $member = getData($con, $q, [$id]);
          #
          ##
          ### Check the news is found or not and redirect if it not
          if (count($member) == 0) {
            echo '<script>location.replace("/cp/dashboard/main")</script>';
          }
        }
      ?>
        <h2 class="page-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> عضو</h2>
        <p>استكشاف وإضافة الاعضاء 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <strong class="card-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> عضو</strong>
              </div>
              <div class="card-body">
                <form class="needs-validation" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="name">اسم العضو <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= isset($member[0]['name']) ? $member[0]['name'] : '' ?>" placeholder="اسم العضو" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="job">العنوان الوظيفي <span class="text-danger">*</span></label>
                    <input type="text" name="job" class="form-control" id="job" value="<?= isset($member[0]['job']) ? $member[0]['job'] : '' ?>" placeholder="اسم العضو" required>
                  </div>

                  <?php if ("edit" == $opr_type) { ?>
                    <div class="col-lg-12 mb-4">
                      <label for="pic">الصورة الحالية </label><br>
                      <img src="/cp/assets/images/members/<?= $member[0]['pic'] ?>" height="100px" width="100px" alt="">
                    </div>
                  <?php } ?>

                  <label for="photo">اختر صورة <span class="text-danger">*</span></label>
                  <div class="custom-file mb-3">
                    <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" />
                  </div>

                  <div class="form-group mb-3">
                    <label for="facebook">حساب الفيسبوك </label>
                    <input type="text" name="facebook" class="form-control" id="facebook" value="<?= isset($member[0]['facebook']) ? $member[0]['facebook'] : '' ?>" placeholder="اسم العضو">
                  </div>

                  <div class="form-group mb-3">
                    <label for="instagram">حساب الانستغرام </label>
                    <input type="text" name="instagram" class="form-control" id="instagram" value="<?= isset($member[0]['instagram']) ? $member[0]['instagram'] : '' ?>" placeholder="اسم العضو">
                  </div>

                  <div class="form-group mb-3">
                    <label for="linkedin">حساب اللنكد ان </label>
                    <input type="text" name="linkedin" class="form-control" id="linkedin" value="<?= isset($member[0]['linkedin']) ? $member[0]['linkedin'] : '' ?>" placeholder="اسم العضو">
                  </div>

                  <div class="form-group mb-3">
                    <label for="twitter">حساب التويتر </label>
                    <input type="text" name="twitter" class="form-control" id="twitter" value="<?= isset($member[0]['twitter']) ? $member[0]['twitter'] : '' ?>" placeholder="اسم العضو">
                  </div>

                  <button type="submit" class="btn btn-primary" name="<?= "edit" == $opr_type ? "update" : "addnew" ?>"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?></button>
                </form>
              </div> <!-- /.card-body -->
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>

      <?php } ?> <!-- end section -->
    </div> <!-- .col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->