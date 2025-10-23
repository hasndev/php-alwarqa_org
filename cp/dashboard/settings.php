<?php
#
##
### Check if the user Have permission or not not
if ($_SESSION['lvl'] != 1) {
  echo '<script>location.replace("/cp/dashboard/main")</script>';
}
#
##
### Get Settings
$q = 'SELECT * FROM `settings` where `id`=1';
$settings = getData($con, $q);
#
##
### Check the news is found or not and redirect if it not
if (count($settings) == 0) {
  echo '<script>location.replace("/cp/dashboard/main")</script>';
  die;
}

?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="container-xxl flex-grow-1 container-p-y">
        <h2 class="page-title">نظرة عامة على الإعدادات</h2>
        <p>استكشاف وتكوين الإعدادات الخاصة بك 🚀</p>
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link <?= empty($opr_type) ? 'active' : '' ?>" href="/cp/dashboard/settings">الاعدادات العامة</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/cp/dashboard/social_media">إعدادات وحسابات التواصل الاجتماعي</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($opr_type == 'seo') ? 'active' : '' ?>" href="/cp/dashboard/settings/seo">إعدادات الـSEO</a>
          </li>
        </ul>

        <?php
        #Add and Update News
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
          //General
          if (empty($opr_type) && $_SESSION['lvl'] == 1) {
            $map_link = selectItem($con, 'settings', 'map_link', 1);
            #
            $q = 'UPDATE `settings` SET 
            `about`=?, `about_ar`=?, `mission`=?, `mission_ar`=?, `vision`=?, `vision_ar`=?, `email`=?,`phone`=?,`map_link`=?';
            $d = setData($con, $q, [
              $_POST['about'], $_POST['about_ar'], $_POST['mission'], $_POST['mission_ar'], $_POST['vision'], $_POST['vision_ar'],
              $_POST['email'], $_POST['phone'], ($_POST['map_link'] == '' ? $map_link : $_POST['map_link'])
            ]);
            if ($d > 0)
              echo "<script>swal('تعديل الإعدادات', ' تم تعديل الإعدادات بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/settings');});</script>";
            else
              echo "<script>swal('تعديل الإعدادات', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
          //SEO
          if ("seo" == $opr_type && $_SESSION['lvl'] == 1) {
            #
            $q = 'UPDATE `settings` SET `keywords`=?, `og_title`=?, `og_description`=?, `og_image`=?, `author`=?, `description`=?';
            $d = setData($con, $q, [$_POST['keywords'], $_POST['og_title'], $_POST['og_description'], $_POST['og_image'], $_POST['author'], $_POST['description']]);
            #
            if ($d > 0) {
              echo "<script>swal('تعديل الإعدادات', ' تم تعديل الإعدادات بنجاح', 'success').then((value) => {location.replace('/cp/dashboard/settings/seo');});</script>";
            } else
              echo "<script>swal('تعديل الإعدادات', 'حدث خطأ ما في التعديل', 'error');</script>";
          }
        }
        if (empty($opr_type)) { ?>
          <form class="needs-validation" method="POST" enctype="multipart/form-data">
            <hr class="my-4">

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="about">نص من نحن EN</label>
                <textarea class="form-control" name="about" id="about" rows="4"><?= isset($settings[0]['about']) ? $settings[0]['about'] : '' ?></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="about_ar">نص من نحن AR</label>
                <textarea class="form-control" name="about_ar" id="about_ar" rows="4"><?= isset($settings[0]['about_ar']) ? $settings[0]['about_ar'] : '' ?></textarea>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="mission">نص رسالتنا EN</label>
                <textarea class="form-control" name="mission" id="mission" rows="4"><?= isset($settings[0]['mission']) ? $settings[0]['mission'] : '' ?></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="mission_ar">نص رسالتنا AR</label>
                <textarea class="form-control" name="mission_ar" id="mission_ar" rows="4"><?= isset($settings[0]['mission_ar']) ? $settings[0]['mission_ar'] : '' ?></textarea>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="vision">نص الرؤيا EN</label>
                <textarea class="form-control" name="vision" id="vision" rows="4"><?= isset($settings[0]['vision']) ? $settings[0]['vision'] : '' ?></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="vision_ar">نص الرؤيا AR</label>
                <textarea class="form-control" name="vision_ar" id="vision_ar" rows="4"><?= isset($settings[0]['vision_ar']) ? $settings[0]['vision_ar'] : '' ?></textarea>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="email">البريد الالكتروني</label>
                <input type="email" name="email" value="<?= isset($settings[0]['email']) ? $settings[0]['email'] : '' ?>" class="form-control" id="email" placeholder="Email">
              </div>
              <div class="form-group col-md-6">
                <label for="phone">رقم الهاتف</label>
                <input type="text" name="phone" value="<?= isset($settings[0]['phone']) ? $settings[0]['phone'] : '' ?>" class="form-control" id="phone" placeholder="Phone">
              </div>
            </div>
            <div class="form-group">
              <label for="map_link">خريطة كوكل كـ Iframe</label>
              <?= isset($settings[0]['map_link']) ? $settings[0]['map_link'] : '' ?>
              <label for="map_link mt-4">خريطة كوكل جديدة كـ Iframe</label>
              <input type="text" name="map_link" class="form-control" id="map_link" placeholder="Google Map Link">
            </div>

            <button type="submit" class="btn btn-primary" name="update">حفظ التغيير</button>
          </form>

          <!-- SEO Settings -->
        <?php }
        if ("seo" == $opr_type && $_SESSION['lvl'] == 1) {
        ?>
          <form class="needs-validation" method="POST" enctype="multipart/form-data">
            <hr class="my-4">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="keywords">Keywords</label>
                <input type="text" name="keywords" class="form-control" id="keywords" value="<?= isset($settings[0]['keywords']) ? $settings[0]['keywords'] : '' ?>" placeholder="Keywords">
              </div>
              <div class="form-group col-md-6">
                <label for="author">Author</label>
                <input type="text" name="author" class="form-control" id="author" value="<?= isset($settings[0]['author']) ? $settings[0]['author'] : '' ?>" placeholder="Author">
              </div>
              <div class="form-group col-md-12">
                <label for="description">Description</label>
                <input type="text" name="description" class="form-control" id="description" value="<?= isset($settings[0]['description']) ? $settings[0]['description'] : '' ?>" placeholder="Description">
              </div>
            </div>
            <div class="form-group">
              <label for="og_title">og:title</label>
              <input type="text" name="og_title" class="form-control" id="og_title" value="<?= isset($settings[0]['og_title']) ? $settings[0]['og_title'] : '' ?>" placeholder="og:title">
            </div>
            <div class="form-group">
              <label for="og_description">og:description</label>
              <input type="text" name="og_description" class="form-control" id="og_description" value="<?= isset($settings[0]['og_description']) ? $settings[0]['og_description'] : '' ?>" placeholder="og:description">
            </div>
            <div class="form-group">
              <label for="og_image">og:image</label>
              <input type="text" name="og_image" class="form-control" id="og_image" value="<?= isset($settings[0]['og_image']) ? $settings[0]['og_image'] : '' ?>" placeholder="og:image">
            </div>

            <button type="submit" class="btn btn-primary" name="update">حفظ التغيير</button>
          </form>
        <?php } ?>

      </div>
    </div> <!-- /.col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->