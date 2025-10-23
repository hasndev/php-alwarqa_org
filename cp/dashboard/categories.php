<?php
#
##
### Check if the user Have permission or not not
if (substr($_SESSION['permission'], 1, 1) != 1) {
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
        if (!isset($_POST['name_en']) || empty($_POST['name_en']))
          $err = "الرجاء ادخال اسم الصنف";
        else {
          $slug = slugify($_POST['name_en']);
        }
        # Check Slug in Add Operation
        if ("add" == $opr_type) {
          $slug = slugify($_POST['name_en']); // Generate slug from Category title
          $qs = "SELECT `id` FROM `categories` WHERE `slug`=?";
          $ds = getData($con, $qs, [$slug]);
          if (count($ds) > 0) {
            // A Category with this slug already exists; you may want to generate a unique slug
            $base_slug = $slug;
            $counter = 1;
            do {
              $slug = $base_slug . '-' . $counter;
              $qs = "SELECT `id` FROM `categories` WHERE `slug`=?";
              $ds = getData($con, $qs, [$slug]);
              $counter++;
            } while (count($ds) > 0);
          }
        }

        # Check Slug in Edit Operation
        if ("edit" == $opr_type && !empty($id)) {
          $o_slug = selectItem($con, 'categories', 'slug', $id);
          if ($slug != $o_slug) {
            $slug = slugify($_POST['name_en']); // Generate slug from Category title
            $qs = "SELECT `id` FROM `categories` WHERE `slug`=?";
            $ds = getData($con, $qs, [$slug]);
            if (count($ds) > 0) {
              // A Category with this slug already exists; you may want to generate a unique slug
              $base_slug = $slug;
              $counter = 1;
              do {
                $slug = $base_slug . '-' . $counter;
                $qs = "SELECT `id` FROM `categories` WHERE `slug`=?";
                $ds = getData($con, $qs, [$slug]);
                $counter++;
              } while (count($ds) > 0);
            }
          }
        }
        #
        if (empty($err)) {
          //Update
          if ("edit" == $opr_type && !empty($id)) {

            $file_name = selectItem($con, 'categories', 'pic', $id);

            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              if ($file_name != '')
                unlink(__DIR__ . "/../assets/images/categories/" . $file_name);
              $file_name = moveFile($_FILES['photo'], "categories", "jpg");
            }
            #
            $q = 'UPDATE `categories` SET `name`=?, `name_en`=?,`slug`=?,`pic`=?,`done_by`=? WHERE `id`=?';
            $d = setData($con, $q, [$_POST['name'], $_POST['name_en'], $slug, $file_name, $_SESSION['user_id'], $id]);
            if ($d > 0)
              echo "<script>swal('تعديل الصنف', ' تم تحديث الصنف بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/categories');});</script>";
            else
              echo "<script>swal('تعديل الصنف', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //Add
          if ("add" == $opr_type) {
            #upload page photo
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $file_name = moveFile($_FILES['photo'], "categories", "jpg");
            } else $file_name = '';
            // vd($file_name);
            #
            $q = 'INSERT INTO `categories`(`name`, `name_en`, `slug`, `pic`, `done_by`) VALUES (?,?,?,?,?)';
            $d = setData($con, $q, [$_POST['name'], $_POST['name_en'], $slug, $file_name, $_SESSION['user_id']]);
            #
            if ($d > 0) {
              echo "<script>swal('اضافة صنف', ' تمت إضافة الصنف بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/categories');});</script>";
            } else
              echo "<script>swal('اضافة صنف', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
          }
        } else
          echo "<script>swal('الاصناف', '" . $err . "', 'error');</script>";
      }
      #Delete News
      if ("delete" == $opr_type && !empty($id)) {
        $file_name = selectItem($con, 'categories', 'pic', $id);
        if ($file_name != '')
          unlink(__DIR__ . "/../assets/images/categories/" . $file_name);

        $q = 'DELETE FROM `categories` WHERE id=?';
        $d = setData($con, $q, [$id]);
        echo '<script>location.replace("/cp/dashboard/categories")</script>';
        die();
      }
      #Active
      if ("active" == $opr_type && !empty($id)) {
        $q = 'UPDATE `categories` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [1, $id]);
        echo '<script>location.replace("/cp/dashboard/categories")</script>';
        die();
      }
      #NotActive
      if ("notactive" == $opr_type && !empty($id)) {
        $q = 'UPDATE `categories` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [0, $id]);
        echo '<script>location.replace("/cp/dashboard/categories")</script>';
        die();
      }

      if (empty($opr_type)) { ?>
        <h2 class="page-title">الاصناف</h2>
        <p>استكشاف وعرض تفاصيل الاصناف 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل الاصناف</h5>
              <h5 class="filter"><a href="/cp/dashboard/categories/add"><i class='fe fe-plus-square icon'></i></a></h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الصورة</th>
                      <th>الاسم</th>
                      <th>Name</th>
                      <th>Slag</th>
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
                      (SELECT `name` From `users` WHERE `users`.`id`=`categories`.`done_by`) emp
                      FROM `categories` Order by id DESC';
                    $D = getData($con, $q);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><img src="/cp/assets/images/categories/<?= $row['pic'] ?>" style="max-height: 100px; max-width: 100px;border-radius:10px;" alt="Project"></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['name_en'] ?></td>
                        <td><?= $row['slug'] ?></td>
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
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/categories/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/categories/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                            <?php
                            if ($row['status'] == 1)
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/categories/notactive/' . $row['id'] . '"><i class="fa fa-eye-slash me-1"></i> اخفاء</a> ';
                            else
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/categories/active/' . $row['id'] . '"><i class="fa fa-eye me-1"></i> اظهار</a> ';
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
          $q = 'SELECT `id`,`name`, `name_en`, `pic`, `status`,
            (SELECT `name` From `users` WHERE `users`.`id`=`categories`.`done_by`) emp
            FROM `categories` where `id`=?';
          $category = getData($con, $q, [$id]);
          #
          ##
          ### Check the news is found or not and redirect if it not
          if (count($category) == 0) {
            echo '<script>location.replace("/cp/dashboard/main")</script>';
          }
        }
      ?>
        <h2 class="page-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> صنف</h2>
        <p>استكشاف وإضافة الاصناف 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <strong class="card-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> صنف</strong>
              </div>
              <div class="card-body">
                <form class="needs-validation" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="name">اسم الصنف <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= isset($category[0]['name']) ? $category[0]['name'] : '' ?>" placeholder="اسم الصنف" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="name_en">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name_en" class="form-control" id="name_en" value="<?= isset($category[0]['name_en']) ? $category[0]['name_en'] : '' ?>" placeholder="اسم الصنف" required>
                  </div>

                  <?php if ("edit" == $opr_type) { ?>
                    <div class="col-lg-12 mb-4">
                      <label for="pic">الصورة الحالية </label><br>
                      <img src="/cp/assets/images/categories/<?= $category[0]['pic'] ?>" height="100px" width="100px" alt="">
                    </div>
                  <?php } ?>

                  <label for="photo">اختر صورة <span class="text-danger">*</span></label>
                  <div class="custom-file mb-3">
                    <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" />
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