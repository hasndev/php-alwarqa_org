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
        if (!isset($_POST['title']) || empty($_POST['title']))
          $err = "الرجاء ادخال عنوان القصة";
        else {
          $slug = slugify($_POST['title']);
        }
        # Check Slug in Add Operation
        if ("add" == $opr_type) {
          $slug = slugify($_POST['title']); // Generate slug from Category title
          $qs = "SELECT `id` FROM `stories` WHERE `slug`=?";
          $ds = getData($con, $qs, [$slug]);
          if (count($ds) > 0) {
            // A Category with this slug already exists; you may want to generate a unique slug
            $base_slug = $slug;
            $counter = 1;
            do {
              $slug = $base_slug . '-' . $counter;
              $qs = "SELECT `id` FROM `stories` WHERE `slug`=?";
              $ds = getData($con, $qs, [$slug]);
              $counter++;
            } while (count($ds) > 0);
          }
        }

        # Check Slug in Edit Operation
        if ("edit" == $opr_type && !empty($id)) {
          $o_slug = selectItem($con, 'stories', 'slug', $id);
          if ($slug != $o_slug) {
            $slug = slugify($_POST['title']); // Generate slug from Category title
            $qs = "SELECT `id` FROM `stories` WHERE `slug`=?";
            $ds = getData($con, $qs, [$slug]);
            if (count($ds) > 0) {
              // A Category with this slug already exists; you may want to generate a unique slug
              $base_slug = $slug;
              $counter = 1;
              do {
                $slug = $base_slug . '-' . $counter;
                $qs = "SELECT `id` FROM `stories` WHERE `slug`=?";
                $ds = getData($con, $qs, [$slug]);
                $counter++;
              } while (count($ds) > 0);
            }
          }
        }
        #
        if (empty($err)) {
          #
          if (isset($_POST['link']) || !empty($_POST['link'])) {
            $url = rtrim($_POST['link'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $link = isset($url[3]) ? $url[3] : "";
          }
          //Update
          if ("edit" == $opr_type && !empty($id)) {

            $file_name = selectItem($con, 'stories', 'pic', $id);

            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              if ($file_name != '')
                unlink(__DIR__ . "/../assets/images/stories/" . $file_name);
              $file_name = moveFile($_FILES['photo'], "stories", "jpg");
            }
            #
            $q = 'UPDATE `stories` SET `title`=?,`slug`=?,`type`=?,`link`=?,`pic`=?,`note`=?,`done_by`=? WHERE `id`=?';
            $d = setData($con, $q, [$_POST['title'], $slug, $_POST['type'], $link, $file_name, $_POST['note'], $_SESSION['user_id'], $id]);
            if ($d > 0)
              echo "<script>swal('تعديل القصة', ' تم تحديث القصة بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/stories');});</script>";
            else
              echo "<script>swal('تعديل القصة', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //Add
          if ("add" == $opr_type) {
            #upload page photo
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $time = intval(time());
              $ext = strrchr($_FILES["photo"]["name"], ".");
              $file_name = $time . $ext;
              $file_tmp = $_FILES['photo']['tmp_name'];
              move_uploaded_file($file_tmp, __DIR__ . "/../assets/images/stories/" . $file_name);
            } else $file_name = '';
            // vd($file_name);
            #
            $q = 'INSERT INTO `stories`( `title`, `slug`, `type`, `link`, `pic`, `date_add`, `note`, `done_by`) VALUES (?,?,?,?,?,?,?,?)';
            $d = setData($con, $q, [$_POST['title'], $slug, $_POST['type'], $link, $file_name, date("Y-m-d"), $_POST['note'], $_SESSION['user_id']]);
            #
            if ($d > 0) {
              $sid = $con->lastInsertId();
              $q = 'UPDATE `stories` SET `status`=? WHERE id!=?';
              $d = setData($con, $q, [0, $sid]);
              #
              echo "<script>swal('اضافة قصة', ' تمت إضافة القصة بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/stories');});</script>";
            } else
              echo "<script>swal('اضافة قصة', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
          }
        } else
          echo "<script>swal('القصة', '" . $err . "', 'error');</script>";
      }
      #Delete News
      if ("delete" == $opr_type && !empty($id)) {
        $file_name = selectItem($con, 'stories', 'pic', $id);
        if ($file_name != '')
          unlink(__DIR__ . "/../assets/images/stories/" . $file_name);

        $q = 'DELETE FROM `stories` WHERE id=?';
        $d = setData($con, $q, [$id]);
        echo '<script>location.replace("/cp/dashboard/stories")</script>';
        die();
      }
      #Active
      if ("active" == $opr_type && !empty($id)) {
        $q = 'UPDATE `stories` SET `status`=?';
        $d = setData($con, $q, [0]);
        #
        $q = 'UPDATE `stories` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [1, $id]);
        echo '<script>location.replace("/cp/dashboard/stories")</script>';
        die();
      }
      #NotActive
      if ("notactive" == $opr_type && !empty($id)) {
        $q = 'UPDATE `stories` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [0, $id]);
        echo '<script>location.replace("/cp/dashboard/stories")</script>';
        die();
      }

      if (empty($opr_type)) { ?>
        <h2 class="page-title">القصص</h2>
        <p>استكشاف وعرض تفاصيل القصص 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل القصص</h5>
              <h5 class="filter"><a href="/cp/dashboard/stories/add"><i class='fe fe-plus-square icon'></i></a></h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الميديا</th>
                      <th>العنوان</th>
                      <th>تاريخ الاضافة</th>
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
                      (SELECT `name` From `users` WHERE `users`.`id`=`stories`.`done_by`) emp
                      FROM `stories` Order by id DESC';
                    $D = getData($con, $q);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td>
                          <?php
                          if ($row['type'] == 1) {
                            echo '<iframe style="max-width: 200px; max-height: 200px;" src="https://www.youtube.com/embed/' . $row['link'] . '" allowfullscreen></iframe>';
                          } else {
                            $file_extension = pathinfo($row['pic'], PATHINFO_EXTENSION);
                            if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
                              // Display an image if the file is an image
                              echo '<img style="max-height: 150px; max-width: 150px;border-radius:10px;" src="/cp/assets/images/stories/' . $row['pic'] . '" alt="Image">';
                            } elseif (in_array($file_extension, array('mp4', 'webm', 'ogg'))) {
                              // Display a video if the file is a video
                              echo '<video controls style="max-height: 200px; max-width: 200px;border-radius:10px;">
                          <source src="/cp/assets/images/stories/' . $row['pic'] . '" type="video/' . $file_extension . ' ">
                              Your browser does not support the video tag.
                          </video>';
                            } else {
                              // Handle other file types or provide an error message
                              echo 'Unsupported file type: ' . $file_extension;
                            }
                          }
                          ?>
                        </td>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['date_add'] ?></td>
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
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/stories/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/stories/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                            <?php
                            if ($row['status'] == 1)
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/stories/notactive/' . $row['id'] . '"><i class="fa fa-eye-slash me-1"></i> اخفاء</a> ';
                            else
                              echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/stories/active/' . $row['id'] . '"><i class="fa fa-eye me-1"></i> اظهار</a> ';
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
            (SELECT `name` From `users` WHERE `users`.`id`=`stories`.`done_by`) emp
            FROM `stories` where `id`=?';
          $category = getData($con, $q, [$id]);
          #
          ##
          ### Check the news is found or not and redirect if it not
          if (count($category) == 0) {
            echo '<script>location.replace("/cp/dashboard/main")</script>';
          }
        }
      ?>
        <h2 class="page-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> قصة</h2>
        <p>استكشاف وإضافة القصص 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <strong class="card-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> قصة</strong>
              </div>
              <div class="card-body">
                <form class="needs-validation" method="POST" enctype="multipart/form-data">
                  <div class="form-group mb-3">
                    <label for="title">عنوان القصة <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" id="title" value="<?= isset($category[0]['title']) ? $category[0]['title'] : '' ?>" placeholder="عنوان القصة" required>
                  </div>

                  <div class="mb-3">
                    <label for="type" class="form-label">النوع <span class="text-danger">*</span></label>
                    <select class="custom-select" name="type" id="type" required onchange="toggleFields()">
                      <option value="2" <?= isset($category[0]['type']) && ($category[0]['type'] == 2) ? " selected " : "" ?>>ملف</option>
                      <option value="1" <?= isset($category[0]['type']) && ($category[0]['type'] == 1) ? " selected " : "" ?>>رابط يوتيوب</option>
                    </select>
                  </div>

                  <div class="form-group mb-3" id="inputPrice">
                    <label for="link">رابط الفيديو <span class="text-danger">*</span></label>
                    <input type="text" name="link" class="form-control" id="link" value="<?= isset($category[0]['link']) ? "https://youtu.be/" . $category[0]['link'] : '' ?>" placeholder="رابط الفيديو">
                  </div>

                  <?php if ("edit" == $opr_type) { ?>
                    <div class="col-lg-12 mb-4" id="fileView">
                      <label for="pic">ملف الفيديو او الصورة </label><br>
                      <?php
                      $file_extension = pathinfo($category[0]['pic'], PATHINFO_EXTENSION);

                      if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
                        // Display an image if the file is an image
                        echo '<img style="max-height: 150px; max-width: 150px;border-radius:10px;" src="/cp/assets/images/stories/' . $category[0]['pic'] . '" alt="Image">';
                      } elseif (in_array($file_extension, array('mp4', 'webm', 'ogg'))) {
                        // Display a video if the file is a video
                        echo '<video controls style="max-height: 200px; max-width: 200px;border-radius:10px;">
                          <source src="/cp/assets/images/stories/' . $category[0]['pic'] . '" type="video/' . $file_extension . ' ">
                              Your browser does not support the video tag.
                          </video>';
                      } else {
                        // Handle other file types or provide an error message
                        echo 'Unsupported file type: ' . $file_extension;
                      }
                      ?>
                    </div>
                  <?php } ?>

                  <div class="form-group mb-3" id="inputPic">
                    <label for="photo">اختر ملف <span class="text-danger">*</span></label>
                    <div class="custom-file mb-3">
                      <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" />
                    </div>
                  </div>

                  <div class="form-group mb-3" dir="ltr">
                    <label for="note">الملاحظات (الوصف)</label>
                    <textarea class="summernote" name="note" id="note" rows="4"><?= isset($category[0]['note']) ? $category[0]['note'] : '' ?></textarea>
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

<script>
  function toggleFields() {
    var typeSelect = document.getElementById("type");
    var inputPrice = document.getElementById("inputPrice");
    var inputPic = document.getElementById("inputPic");
    var fileView = document.getElementById("fileView");

    if (typeSelect.value === "1") {
      inputPrice.style.display = "block";
      inputPic.style.display = "none";
      fileView.style.display = "none";
    } else if (typeSelect.value === "2") {
      inputPrice.style.display = "none";
      inputPic.style.display = "block";
      fileView.style.display = "block";
    }
  }

  // Call the function initially to set the initial state
  toggleFields();
</script>