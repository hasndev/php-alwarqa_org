<?php
#
##
### Check if the user Have permission or not not
if (substr($_SESSION['permission'], 5, 1) != 1) {
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
          $err = "الرجاء ادخال اسم البرنامج";
        #
        if (!isset($_POST['name_en']) || empty($_POST['name_en']))
          $err = "الرجاء ادخال اسم البرنامج باللغة الانكليزية";
        else {
          $slug = slugify($_POST['name_en']);
        }
        if (!isset($_POST['type']) || $_POST['type'] == '0')
          $err = "الرجاء اختيار نوع البرنامج";
        #
        if (!isset($_POST['category']) || $_POST['category'] == '0')
          $err = "الرجاء اختيار صنف البرنامج";
        #
        #Check Slug in Add Opreation
        if ("add" == $opr_type) {
          $slug = slugify($_POST['name_en']); // Generate slug from Category title
          $qs = "SELECT `id` FROM `programs` WHERE `slug`=?";
          $ds = getData($con, $qs, [$slug]);
          if (count($ds) > 0) {
            // A Category with this slug already exists; you may want to generate a unique slug
            $base_slug = $slug;
            $counter = 1;
            do {
              $slug = $base_slug . '-' . $counter;
              $qs = "SELECT `id` FROM `programs` WHERE `slug`=?";
              $ds = getData($con, $qs, [$slug]);
              $counter++;
            } while (count($ds) > 0);
          }
        }

        # Check Slug in Edit Operation
        if ("edit" == $opr_type && !empty($id)) {
          $o_slug = selectItem($con, 'programs', 'slug', $id);
          if ($slug != $o_slug) {
            $slug = slugify($_POST['name_en']); // Generate slug from Category title
            $qs = "SELECT `id` FROM `programs` WHERE `slug`=?";
            $ds = getData($con, $qs, [$slug]);
            if (count($ds) > 0) {
              // A Category with this slug already exists; you may want to generate a unique slug
              $base_slug = $slug;
              $counter = 1;
              do {
                $slug = $base_slug . '-' . $counter;
                $qs = "SELECT `id` FROM `programs` WHERE `slug`=?";
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

            $file_name = selectItem($con, 'programs', 'pic', $id);
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              if ($file_name != '')
                unlink(__DIR__ . "/../assets/images/programs/" . $file_name);
              $file_name = moveFile($_FILES['photo'], "programs", "jpg");
            }
            #
            $q = 'UPDATE `programs` SET `name`=?, `name_en`=?, `slug`=?, `category`=?, `trainer`=?, `price`=?, `type`=?, `note`=?, `summary`=?, `summary_en`=?, `pic`=?,`done_by`=? WHERE `id`=?';
            $d = setData($con, $q, [$_POST['name'], $_POST['name_en'], $slug, $_POST['category'], $_POST['trainer'], $_POST['price'], $_POST['type'], $_POST['note'], $_POST['summary'], $_POST['summary_en'], $file_name, $_SESSION['user_id'], $id]);
            if ($d > 0) {
              echo "<script>swal('تعديل البرنامج', ' تم تعديل البرنامج بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/programs');});</script>";
            } else
              echo "<script>swal('تعديل البرنامج', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //Add
          if ("add" == $opr_type) {
            #upload page photo
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $file_name = moveFile($_FILES['photo'], "programs", "jpg");
            } else
              $file_name = '';
            // vd($file_name);
            #
            $q = 'INSERT INTO `programs`(`name`, `name_en`, `slug`, `category`, `trainer` `price`, `type`, `note`, `summary`, `summary_en`, `pic`, `done_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
            $d = setData($con, $q, [$_POST['name'], $_POST['name_en'], $slug, $_POST['category'], $_POST['trainer'], $_POST['price'], $_POST['type'], $_POST['note'], $_POST['summary'], $_POST['summary_en'], $file_name, $_SESSION['user_id']]);
            #
            if ($d > 0) {
              echo "<script>swal('اضافة برنامج', ' تم اضافة البرنامج بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/programs');});</script>";
            } else
              echo "<script>swal('اضافة برنامج', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
          }
        } else
          echo "<script>swal('البرامج', '" . $err . "', 'error');</script>";
      }
      #Delete News
      if ("delete" == $opr_type && !empty($id)) {
        $file_name = selectItem($con, 'programs', 'pic', $id);
        if ($file_name != '')
          unlink(__DIR__ . "/../assets/images/programs/" . $file_name);

        $q = 'DELETE FROM `programs` WHERE id=?';
        $d = setData($con, $q, [$id]);
        echo '<script>location.replace("/cp/dashboard/programs")</script>';
        die();
      }
      #Active
      if ("active" == $opr_type && !empty($id)) {
        $q = 'UPDATE `programs` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [1, $id]);
        echo '<script>location.replace("/cp/dashboard/programs")</script>';
        die();
      }
      #NotActive
      if ("notactive" == $opr_type && !empty($id)) {
        $q = 'UPDATE `programs` SET `status`=? WHERE id=?';
        $d = setData($con, $q, [0, $id]);
        echo '<script>location.replace("/cp/dashboard/programs")</script>';
        die();
      }

      if (empty($opr_type)) { ?>
        <h2 class="page-title">البرامج</h2>
        <p>استكشاف وعرض البرامج 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل البرامج</h5>
              <h5 class="filter"><a href="/cp/dashboard/programs/add"><i class='fe fe-plus-square icon'></i></a></h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1" width="100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الصورة</th>
                      <th>الاسم</th>
                      <th>Name</th>
                      <th>الصنف</th>
                      <th>تم بوسطة</th>
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
                      (SELECT `name` From `categories` WHERE `categories`.`id`=`programs`.`category`) category,
                      (SELECT `name` From `users` WHERE `users`.`id`=`programs`.`done_by`) emp
                      FROM `programs` Order by id DESC';
                    $D = getData($con, $q);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><img src="/cp/assets/images/programs/<?= $row['pic'] ?>" style="max-height: 100px; max-width: 180px;" alt="Project"></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['name_en'] ?></td>
                        <td><?= $row['category'] ?></td>
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
                          <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="text-muted sr-only">العمليات</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" dir="rtl">
                              <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/programs/details/<?= $row['id'] ?>"><i class="fe fe-info me-1"></i> التفاصيل</a>
                              <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/programs/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                              <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/programs/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                              <?php
                              if ($row['status'] == 1)
                                echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/programs/notactive/' . $row['id'] . '"><i class="fa fa-eye-slash me-1"></i> اخفاء</a> ';
                              else
                                echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/programs/active/' . $row['id'] . '"><i class="fa fa-eye me-1"></i> اظهار</a> ';
                              ?>
                            </div>
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
          </div> <!-- simple table -->
        <?php }
      if ("details" == $opr_type) {
        $q = 'SELECT *,
          (SELECT `name` From `users` WHERE `users`.`id`=`programs`.`done_by`) emp,
          (SELECT `name` From `categories` WHERE `categories`.`id`=`programs`.`category`) category
          FROM `programs` where `id`=?';
        $project_details = getData($con, $q, [$id]);
        #
        ##
        ### Check the news is found or not and redirect if it not
        if (count($project_details) == 0) {
          echo '<script>location.replace("/cp/dashboard/main")</script>';
          die;
        }
        #
        $project = $project_details[0];
        ?>
          <h2 class="page-title">تفاصيل البرنامج</h2>
          <p>استكشاف وعرض تفاصيل البرامج 🚀</p>
          <div class="row my-4">
            <div class="col-md-12">
              <div class="card px-4 py-2">
                <h3 class="text-primary py-4">
                  <?= $project['name'] . " - " . $project['name_en']  ?>
                </h3>

                <h5 class="mb-4">
                  الصنف: <?= $project['category'] ?>
                </h5>

                <h5 class="mb-4">
                  النوع: <?= $project['type'] == 1 ? "مدفوع" : "مجاني" ?>
                  <?= $project['type'] == 1 ? "<br><br> السعر: " . $project['price'] . " ع.د" : "" ?>
                </h5>

                <h5 class="mb-4">
                  المدرب: <?= $project['trainer'] ?>
                </h5>

                <div class="row">
                  <div class="col-md-8">
                    <h4>ملخص قصير:</h4>
                    <div class="mb-4">
                      <p>
                        <?= $project['summary'] ?>
                      </p>
                    </div>
                    <h4>Summary:</h4>
                    <div class="mb-4">
                      <p>
                        <?= $project['summary_en'] ?>
                      </p>
                    </div>
                    <h4>الملاحظات (الوصف):</h4>
                    <div class="">
                      <p>
                        <?= $project['note'] ?>
                      </p>
                    </div>
                  </div>

                  <div class="col-md-4 mb-4">
                    <?php if ($project['pic'] != '') { ?>
                      <div class="card h-100">
                        <img class="img-fluid rounded rounded-lg" src="/cp/assets/images/programs/<?= $project['pic'] ?>" style="height: 250px; width:auto;" alt="<?= $project['pic'] ?>" />
                      </div>
                    <?php } else
                      echo "<h4>لم يتم تحميل اي صورة</h4>" ?>
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
            (SELECT `name` From `users` WHERE `users`.`id`=`programs`.`done_by`) emp
            FROM `programs` where `id`=?';
          $project = getData($con, $q, [$id]);
          #
          ##
          ### Check the news is found or not and redirect if it not
          if (count($project) == 0) {
            echo '<script>location.replace("/cp/dashboard/main")</script>';
          }
        }
        #
        ##
        ### Get All Categories
        $q_categories = 'SELECT `id`,`name` FROM `categories` where `status`="1"';
        $categories = getData($con, $q_categories);
        ?>
          <h2 class="page-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> البرنامج</h2>
          <p>استكشاف وإضافة البرامج 🚀</p>
          <div class="row my-4">
            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <strong class="card-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> البرنامج</strong>
                </div>
                <div class="card-body">
                  <form class="needs-validation" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                      <label for="name">اسم البرنامج <span class="text-danger">*</span></label>
                      <input type="text" name="name" class="form-control" id="name" value="<?= isset($project[0]['name']) ? $project[0]['name'] : '' ?>" placeholder="اسم البرنامج" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="name_en">Program Name <span class="text-danger">*</span></label>
                      <input type="text" name="name_en" class="form-control" id="name_en" value="<?= isset($project[0]['name_en']) ? $project[0]['name_en'] : '' ?>" placeholder="Program Name" required>
                    </div>

                    <label for="category">اختر الصنف</label>
                    <div class="input-group mb-3">
                      <select class="custom-select" name="category" id="category" aria-label="Example select with button addon">
                        <?php foreach ($categories as $category) : ?>
                          <option value="<?= $category['id'] ?>" <?= isset($project[0]['category']) && ($category['id'] == $project[0]['category']) ? " selected " : "" ?>><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group mb-3">
                      <label for="trainer">اسم المدرب <span class="text-danger">*</span></label>
                      <input type="text" name="trainer" class="form-control" id="trainer" value="<?= isset($project[0]['trainer']) ? $project[0]['trainer'] : '' ?>" placeholder="اسم المدرب" required>
                    </div>

                    <div class="mb-3">
                      <label for="type" class="form-label">اختر نوع البرنامج <span class="text-danger">*</span></label>
                      <select class="custom-select" name="type" id="type" required onchange="togglePriceInput()">
                        <option value="2" <?= isset($users[0]['type']) && ($users[0]['type'] == 2) ? " selected " : "" ?>>مجاني</option>
                        <option value="1" <?= isset($users[0]['type']) && ($users[0]['type'] == 1) ? " selected " : "" ?>>مدفوع</option>
                      </select>
                    </div>

                    <div class="form-group mb-3" id="inputPrice">
                      <label for="price">السعر <span class="text-danger">*</span></label>
                      <input type="text" name="price" class="form-control" id="price" value="<?= isset($project[0]['price']) ? $project[0]['price'] : '' ?>" placeholder="السعر" required>
                    </div>

                    <?php if ("edit" == $opr_type) { ?>
                      <div class="col-lg-12 mb-4">
                        <label for="pic">الصورة الحالية </label><br>
                        <img src="/cp/assets/images/programs/<?= $project[0]['pic'] ?>" height="100px" width="180px" alt="">
                      </div>
                    <?php } ?>

                    <label for="photo">اختيار صورة <span class="text-danger">*</span></label>
                    <div class="custom-file mb-3">
                      <label for="formFileMultiple" class="form-label">Select <?= "edit" == $opr_type ? 'New' : '' ?> Picture</label>
                      <input class="custom-file-label" name="photo" type="file" id="formFileMultiple" />
                    </div>

                    <div class="form-group mb-3" dir="ltr">
                      <label for="summary">ملخص قصير</label>
                      <textarea class="summernote" name="summary" id="summary" rows="4"><?= isset($project[0]['summary']) ? $project[0]['summary'] : '' ?></textarea>
                    </div>

                    <div class="form-group mb-3" dir="ltr">
                      <label for="summary_en">Summary</label>
                      <textarea class="summernote" name="summary_en" id="summary_en" rows="4"><?= isset($project[0]['summary_en']) ? $project[0]['summary_en'] : '' ?></textarea>
                    </div>

                    <div class="form-group mb-3" dir="ltr">
                      <label for="note">الملاحظات (الوصف)</label>
                      <textarea class="summernote" name="note" id="note" rows="4"><?= isset($project[0]['note']) ? $project[0]['note'] : '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" name="<?= "edit" == $opr_type ? "update" : "addnew" ?>"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?></button>
                  </form>
                </div> <!-- /.card-body -->
              </div> <!-- /.card -->
            </div> <!-- /.col -->


          <?php } ?>

          </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->

  <script>
    function togglePriceInput() {
      var typeSelect = document.getElementById("type");
      var inputPrice = document.getElementById("inputPrice");

      if (typeSelect.value === "1") {
        inputPrice.style.display = "block";
      } else {
        inputPrice.style.display = "none";
      }
    }

    // Call the function initially to set the initial state
    togglePriceInput();
  </script>