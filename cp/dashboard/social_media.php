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
            $err = "الرجاء ادخال اسم المنصة";
          else {
            $slug = slugify($_POST['name']);
          }
          #Check Slug in Add Opreation
          if ("add" == $opr_type) {
            $qs = "SELECT `id` FROM `social_media` WHERE `slug`=?";
            $ds = getData($con, $qs, [$slug]);
            if (count($ds) > 0)
              $err = "هذة المنصة موجودة بالفعل";
          }
          #Check Slug in Edit Opreation
          if ("edit" == $opr_type && !empty($id)) {
            $o_slug = selectItem($con, 'social_media', 'slug', $id);
            if ($slug != $o_slug) {
              $qs = "SELECT `id` FROM `social_media` WHERE `slug`=?";
              $ds = getData($con, $qs, [$slug]);
              if (count($ds) > 0)
                $err = "هذة المنصة موجودة بالفعل";
            }
          }
          #
          if (empty($err)) {
            //Update
            if ("edit" == $opr_type && !empty($id)) {
              #
              $q = 'UPDATE `social_media` SET `name`=?,`slug`=?,`icon`=?,`link`=? WHERE `id`=?';
              $d = setData($con, $q, [$_POST['name'], $slug, $_POST['icon'], $_POST['link'], $id]);
              if ($d > 0)
                echo "<script>swal('تعديل الحساب', ' تم تعديل الحساب بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/social_media');});</script>";
              else
                echo "<script>swal('تعديل الحساب', 'حدث خطأ ما في التعديل', 'error');</script>";
            }
            //Add
            if ("add" == $opr_type) {
              #
              $q = 'INSERT INTO `social_media`(`name`, `slug`, `icon`, `link`) VALUES (?,?,?,?)';
              $d = setData($con, $q, [$_POST['name'], $slug, $_POST['icon'], $_POST['link']]);
              #
              if ($d > 0) {
                echo "<script>swal('إضافة حساب', ' تمت إضافة الحساب بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/social_media');});</script>";
              } else
                echo "<script>swal('إضافة حساب', 'حدث خطأ ما أثناء الإضافة', 'error');</script>";
            }
          } else
            echo "<script>swal('حسابات منصات التواصل', '" . $err . "', 'error');</script>";
        }
        #Delete News
        if ("delete" == $opr_type && !empty($id)) {
          $q = 'DELETE FROM `social_media` WHERE id=?';
          $d = setData($con, $q, [$id]);
          echo '<script>location.replace("/cp/dashboard/social_media")</script>';
          die();
        }
        #Active
        if ("active" == $opr_type && !empty($id)) {
          $q = 'UPDATE `social_media` SET `status`=? WHERE id=?';
          $d = setData($con, $q, [1, $id]);
          echo '<script>location.replace("/cp/dashboard/social_media")</script>';
          die();
        }
        #NotActive
        if ("notactive" == $opr_type && !empty($id)) {
          $q = 'UPDATE `social_media` SET `status`=? WHERE id=?';
          $d = setData($con, $q, [0, $id]);
          echo '<script>location.replace("/cp/dashboard/social_media")</script>';
          die();
        }

        if (empty($opr_type)) { ?>
          <h2 class="page-title">نظرة عامة على حسابات التواصل الاجتماعي</h2>
          <p>استكشاف وعرض تفاصيل وحسابات التواصل الاجتماعي 🚀</p>
          <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link" href="/cp/dashboard/settings">الاعدادات العامة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="/cp/dashboard/social_media">إعدادات وحسابات التواصل الاجتماعي</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/cp/dashboard/settings/seo">إعدادات الـSEO</a>
            </li>
          </ul>
          <div class="row my-4">
            <div class="col-md-12">
              <div class="card shadow">
                <h5 class="card-header">كل حسابات التواصل الاجتماعي</h5>
                <h5 class="filter"><a href="/cp/dashboard/social_media/add"><i class='fe fe-plus-square icon'></i></a></h5>
                <div class="card-body">
                  <!-- table -->
                  <table class="table datatables" id="dataTable-1">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>صورة</th>
                        <th>اسم المنصة</th>
                        <th>رابط</th>
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
                      $q = 'SELECT `id`,`name`, `icon`, `link`, `status`
                      FROM `social_media` Order by id DESC';
                      $D = getData($con, $q);
                      foreach ($D as $row) {
                      ?>
                        <tr>
                          <td><?php echo $sn++; ?></td>
                          <td><?= $row['icon'] ?></td>
                          <td><?= $row['name'] ?></td>
                          <td><a target="_blank" href="<?= $row['link'] ?>"><?= $row['link'] != '' ? 'رابط الحساب' : '' ?></a></td>
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
                              <span class="text-muted sr-only">العمليات</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/social_media/edit/<?= $row['id'] ?>"><i class="fe fe-edit me-1"></i> تعديل</a>
                              <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/social_media/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                              <?php
                              if ($row['status'] == 1)
                                echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/social_media/notactive/' . $row['id'] . '"><i class="fa fa-eye-slash me-1"></i> اخفاء</a> ';
                              else
                                echo '<a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/social_media/active/' . $row['id'] . '"><i class="fa fa-eye me-1"></i> اظهار</a> ';
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
            $q = 'SELECT `id`,`name`, `icon`, `link`
            FROM `social_media` where `id`=?';
            $account = getData($con, $q, [$id]);
            #
            ##
            ### Check the news is found or not and redirect if it not
            if (count($account) == 0) {
              echo '<script>location.replace("/cp/dashboard/main")</script>';
            }
          }
        ?>
          <h2 class="page-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> حسابات التواصل الاجتماعي</h2>
          <p>استكشاف وإضافة حسابات التواصل الاجتماعي 🚀</p>
          <div class="row my-4">
            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <strong class="card-title"><?= "edit" == $opr_type ? "تعديل" : "اضافة" ?> حساب</strong>
                </div>
                <div class="card-body">
                  <form class="needs-validation" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                      <label for="name">اسم المنصة <span class="text-danger">*</span></label>
                      <input type="text" name="name" class="form-control" id="name" value="<?= isset($account[0]['name']) ? $account[0]['name'] : '' ?>" placeholder="اسم المنصة" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="link">الرابط <span class="text-danger">*</span></label>
                      <input type="text" name="link" class="form-control" id="link" value="<?= isset($account[0]['link']) ? $account[0]['link'] : '' ?>" placeholder="الرابط" required>
                    </div>

                    <div class="form-group mb-3">
                      <label for="icon">المنصات <span class="text-danger">*</span></label>

                      <!-- Facebook -->
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" checked type="radio" name="icon" id="facebook" value='<i class="fab fa-facebook"></i>' <?= (isset($account[0]['icon']) && $account[0]['icon'] === '<i class="fab fa-facebook"></i>') ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="facebook">
                          <i class="fab fa-facebook"></i> Facebook
                        </label>
                      </div>

                      <!-- Twitter -->
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="icon" id="twitter" value='<i class="fab fa-twitter"></i>' <?= (isset($account[0]['icon']) && $account[0]['icon'] === '<i class="fab fa-twitter"></i>') ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="twitter">
                          <i class="fab fa-twitter"></i> Twitter
                        </label>
                      </div>

                      <!-- Instagram -->
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="icon" id="instagram" value='<i class="fab fa-instagram"></i>' <?= (isset($account[0]['icon']) && $account[0]['icon'] === '<i class="fab fa-instagram"></i>') ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="instagram">
                          <i class="fab fa-instagram"></i> Instagram
                        </label>
                      </div>

                      <!-- LinkedIn -->
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="icon" id="linkedin" value='<i class="fab fa-linkedin"></i>' <?= (isset($account[0]['icon']) && $account[0]['icon'] === '<i class="fab fa-linkedin"></i>') ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="linkedin">
                          <i class="fab fa-linkedin"></i> LinkedIn
                        </label>
                      </div>

                    </div>



                    <button type="submit" class="btn btn-primary" name="<?= "edit" == $opr_type ? "update" : "addnew" ?>"><?= "edit" == $opr_type ? "Edit" : "Add" ?></button>
                  </form>
                </div> <!-- /.card-body -->
              </div> <!-- /.card -->
            </div> <!-- /.col -->
          </div>


        <?php } ?>

      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->