<?php
#
##
### Check if the user Have permission or not not
if (substr($_SESSION['permission'], 10, 1) != 1) {
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
        if (!isset($_POST['title']) || empty($_POST['title']))
          $err = "الرجاء ادخال عنوان الخبر";
        #
        if (!isset($_POST['title']) || empty($_POST['title']))
          $err = "الرجاء ادخال عنوان الخبر باللغة الانكليزية";
        else {
          $slug = slugify($_POST['title_en']);
        }
        # Check Slug in Add Operation
        if ("add" == $opr_type) {
          $slug = slugify($_POST['title_en']); // Generate slug from Category title
          $qs = "SELECT `id` FROM `blogs` WHERE `slug`=?";
          $ds = getData($con, $qs, [$slug]);
          if (count($ds) > 0) {
            // A Category with this slug already exists; you may want to generate a unique slug
            $base_slug = $slug;
            $counter = 1;
            do {
              $slug = $base_slug . '-' . $counter;
              $qs = "SELECT `id` FROM `blogs` WHERE `slug`=?";
              $ds = getData($con, $qs, [$slug]);
              $counter++;
            } while (count($ds) > 0);
          }
        }
        # Check Slug in Edit Operation
        if ("edit" == $opr_type && !empty($id)) {
          $o_slug = selectItem($con, 'blogs', 'slug', $id);
          if ($slug != $o_slug) {
            $slug = slugify($_POST['title_en']); // Generate slug from Category title
            $qs = "SELECT `id` FROM `blogs` WHERE `slug`=?";
            $ds = getData($con, $qs, [$slug]);
            if (count($ds) > 0) {
              // A Category with this slug already exists; you may want to generate a unique slug
              $base_slug = $slug;
              $counter = 1;
              do {
                $slug = $base_slug . '-' . $counter;
                $qs = "SELECT `id` FROM `blogs` WHERE `slug`=?";
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

            $file_name = selectItem($con, 'blogs', 'pic', $id);
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              if ($file_name != '')
                unlink(__DIR__ . "/../assets/images/blogs/" . $file_name);
              $file_name = moveFile($_FILES['photo'], "blogs", "jpg");
            }
            #
            #
            $q = 'UPDATE `blogs` SET `title`=?, `title_en`=?, `slug`=?, `date_add`=?, `summary`=?, `summary_en`=?, `note`=?, `pic`=?,`done_by`=? WHERE `id`=?';
            $d = setData($con, $q, [$_POST['title'], $_POST['title_en'], $slug, $_POST['date_add'], $_POST['summary'], $_POST['summary_en'], $_POST['note'], $file_name, $_SESSION['user_id'], $id]);
            if ($d > 0)
              echo "<script>swal('تعديل نشاط', ' تم تحديث النشاط بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/blogs');});</script>";
            else
              echo "<script>swal('تعديل نشاط', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //Add
          if ("add" == $opr_type) {
            #upload page photo
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $file_name = moveFile($_FILES['photo'], "blogs", "jpg");
            }
            #
            $q = 'INSERT INTO `blogs`(`title`, `title_en`, `slug`, `date_add`, `summary`,  `summary_en`, `note`, `pic`, `done_by`) VALUES (?,?,?,?,?,?,?,?,?)';
            $d = setData($con, $q, [$_POST['title'], $_POST['title_en'], $slug, $_POST['date_add'], $_POST['summary'], $_POST['summary_en'], $_POST['note'], $file_name, $_SESSION['user_id']]);
            #
            if ($d > 0) {
              echo "<script>swal('اضافة نشاط', ' تم اضافة النشاط بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/blogs');});</script>";
            } else
              echo "<script>swal('اضافة نشاط', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
          }
        } else
          echo "<script>swal('النشاطات', '" . $err . "', 'error');</script>";
      }
      #Delete News
      if ("delete" == $opr_type && !empty($id)) {
        $file_name = selectItem($con, 'blogs', 'pic', $id);
        if ($file_name != '')
          unlink(__DIR__ . "/../assets/images/blogs/" . $file_name);

        $q = 'DELETE FROM `blogs` WHERE id=?';
        $d = setData($con, $q, [$id]);
        echo '<script>location.replace("/cp/dashboard/blogs")</script>';
        die();
      }
      #Active
      if ("active" == $opr_type && !empty($id)) {
        $q = 'UPDATE `blogs` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [1, $id]);
        echo '<script>location.replace("/cp/dashboard/blogs")</script>';
        die();
      }
      #NotActive
      if ("notactive" == $opr_type && !empty($id)) {
        $q = 'UPDATE `blogs` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [0, $id]);
        echo '<script>location.replace("/cp/dashboard/blogs")</script>';
        die();
      }

      if (empty($opr_type)) { ?>
        <h2 class="page-title">النشاطات</h2>
        <p>استكشف واكتشف أحدث النشاطات والاحداث وورش العمل 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل النشاطات</h5>
              <h5 class="filter"><a href="/cp/dashboard/blogs/add"><i class='fe fe-plus-square icon'></i></a></h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>صورة</th>
                      <th>عنوان</th>
                      <th>Title</th>
                      <th>تاريخ النشاط</th>
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
                      (SELECT `name` From `users` WHERE `users`.`id`=`blogs`.`done_by`) emp
                      FROM `blogs` Order by id DESC';
                    $D = getData($con, $q);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><img src="/cp/assets/images/blogs/<?= $row['pic'] ?>" style="max-height: 100px; max-width: 160px;" alt="Blogs"></td>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['title_en'] ?></td>
                        <td><?= date("F j, Y", strtotime($row['date_add'])) ?></td>
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
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/blogs/details/<?= $row['id'] ?>"><i class="fe fe-info me-1"></i> التفاصيل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/blogs/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/blogs/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                            <?php
                            if ($row['status'] == 1)
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/blogs/notactive/' . $row['id'] . '"><i class="fa fa-eye-slash me-1"></i> اخفاء</a> ';
                            else
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/blogs/active/' . $row['id'] . '"><i class="fa fa-eye me-1"></i> اضهار</a> ';
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

      if ("details" == $opr_type) {
        $q = 'SELECT *,
          (SELECT `name` From `users` WHERE `users`.`id`=`blogs`.`done_by`) emp
          FROM `blogs` where `id`=?';
        $blog_details = getData($con, $q, [$id]);
        #
        ##
        ### Check the news is found or not and redirect if it not
        if (count($blog_details) == 0) {
          echo '<script>location.replace("/cp/dashboard/main")</script>';
          die;
        }
        #
        $blog = $blog_details[0];
      ?>
        <h2 class="page-title">تفاصيل النشاط</h2>
        <p>استكشف واستعرض تفاصيل النشاط 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card px-4 py-2">
              <h3 class="text-primary py-4">
                <?= $blog['title'] . " - " . $blog['title_en'] ?>
              </h3>

              <h5 class="mb-4">
                تاريخ النشاط: <?= date("F j, Y", strtotime($blog['date_add'])) ?>
              </h5>

              <div class="row">
                <div class="col-md-8">
                  <h4>الملخص:</h4>
                  <div class="mb-4">
                    <p>
                      <?= $blog['summary'] ?>
                    </p>
                  </div>
                  <h4>Summary:</h4>
                  <div class="mb-4">
                    <p>
                      <?= $blog['summary_en'] ?>
                    </p>
                  </div>
                  <h4>ملاحظات (الوصف):</h4>
                  <div class="">
                    <p>
                      <?= $blog['note'] ?>
                    </p>
                  </div>
                </div>

                <div class="col-md-4 mb-4">
                  <?php if ($blog['pic'] != '') { ?>
                    <div class="card h-100">
                      <img class="img-fluid rounded rounded-lg" src="/cp/assets/images/blogs/<?= $blog['pic'] ?>" style="height: 250px; width:auto;" alt="<?= $project['pic'] ?>" />
                    </div>
                  <?php } else
                    echo "<h4>لم يتم اضافة صورة</h4>" ?>
                </div>

              </div>
            </div>
          </div>
        </div>


      <?php }

      if ("add" == $opr_type || "edit" == $opr_type) {
        $whr = "";
        $params = [];
        if ("edit" == $opr_type && !empty($id)) {
          $q = 'SELECT *,
            (SELECT `name` From `users` WHERE `users`.`id`=`blogs`.`done_by`) emp
            FROM `blogs` where `id`=?';
          $blog = getData($con, $q, [$id]);
          #
          ##
          ### Check the news is found or not and redirect if it not
          if (count($blog) == 0) {
            echo '<script>location.replace("/cp/dashboard/main")</script>';
          }
        }
      ?>
        <h2 class="page-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> نشاط</h2>
        <p>استكشاف وإضافة نشاط 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <strong class="card-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> نشاط</strong>
              </div>
              <div class="card-body">
                <form class="needs-validation" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="title">عنوان النشاط <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" id="title" value="<?= isset($blog[0]['title']) ? $blog[0]['title'] : '' ?>" placeholder="عنوان النشاط" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="title_en">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" id="title_en" value="<?= isset($blog[0]['title_en']) ? $blog[0]['title_en'] : '' ?>" placeholder="Title" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="date_add">تاريخ النشاط <span class="text-danger">*</span></label>
                    <input type="date" name="date_add" class="form-control" id="date_add" value="<?= isset($blog[0]['date_add']) ? $blog[0]['date_add'] : '' ?>" placeholder="Blog Date" required>
                  </div>

                  <?php if ("edit" == $opr_type) { ?>
                    <div class="col-lg-12 mb-4">
                      <label for="pic">الصورة الحالية </label><br>
                      <img src="/cp/assets/images/blogs/<?= $blog[0]['pic'] ?>" height="100px" width="100px" alt="">
                    </div>
                  <?php } ?>

                  <label for="photo">اختر صورة <span class="text-danger">*</span></label>
                  <div class="custom-file mb-3">
                    <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" />
                  </div>

                  <div class="form-group mb-3">
                    <label for="summary">ملحص قصير</label>
                    <textarea class="summernote" name="summary" id="summary" rows="4"><?= isset($blog[0]['summary']) ? $blog[0]['summary'] : '' ?></textarea>
                  </div>

                  <div class="form-group mb-3">
                    <label for="summary_en">Summary</label>
                    <textarea class="summernote" name="summary_en" id="summary_en" rows="4"><?= isset($blog[0]['summary_en']) ? $blog[0]['summary_en'] : '' ?></textarea>
                  </div>

                  <div class="form-group mb-3">
                    <label for="note">ملاحظات</label>
                    <textarea class="summernote" name="note" id="note" rows="4"><?= isset($blog[0]['note']) ? $blog[0]['note'] : '' ?></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary" name="<?= "edit" == $opr_type ? "update" : "addnew" ?>"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?></button>
                </form>
              </div> <!-- /.card-body -->
            </div> <!-- /.card-body -->
          </div> <!-- /.card -->
        </div> <!-- /.col -->


      <?php } ?>

    </div> <!-- .col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->