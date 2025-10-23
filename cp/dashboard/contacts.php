<?php
#
##
### Check if the user Have permission or not not
if (substr($_SESSION['permission'], 40, 1) != 1) {
  echo '<script>location.replace("/cp/dashboard/main")</script>';
}
#
##
###Delete Contact
if ("delete" == $opr_type && !empty($id)) {
  $q = 'DELETE FROM `contact` WHERE id=?';
  $d = setData($con, $q, [$id]);
  echo '<script>location.replace("/cp/dashboard/contacts")</script>';
  die();
}
?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">

      <?php if (empty($opr_type)) { ?>
        <h2 class="page-title">المراسلات</h2>
        <p>استكشاف واستعرض المراسلات 🚀</p>
        <div class="row my-4">
          <div class="col-md-12">
            <div class="card shadow">
              <h5 class="card-header">كل المراسلات</h5>
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الاسم</th>
                      <th>البريد الالكتروني</th>
                      <th>الموضوع</th>
                      <th>الرسالة بشكل مختصر</th>
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
                    $q = 'SELECT * FROM `contact` Order by id DESC';
                    $D = getData($con, $q);
                    foreach ($D as $row) {
                    ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['subject'] ?></td>
                        <td><?= SubDescription($row['message'], 100) ?></td>
                        <td>
                          <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-muted sr-only">العمليات</span>
                          </button>
                          <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/contacts/details/<?= $row['id'] ?>"><i class="fe fe-info me-1"></i> التفاصيل</a>
                            <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/contacts/delete/<?= $row['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                            <a class="dropdown-item" style="text-align: right;" href="mailto:<?= $row['email'] ?>"><i class="fe fe-message-circle me-1"></i> ارسال ايميل</a>
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
        </div>
      <?php }
      if ("details" == $opr_type) {
        $q = 'SELECT `id`,`name`, `email`, `subject`,`message`
          FROM `contact` where `id`=?';
        $contact_details = getData($con, $q, [$id]);
        #
        ##
        ### Check the news is found or not and redirect if it not
        if (count($contact_details) == 0) {
          echo '<script>location.replace("/cp/dashboard/main")</script>';
          die;
        }
        #
        $contact = $contact_details[0];
      ?>
        <div class="container-xxl flex-grow-1 container-p-y">
          <h2 class="page-title">المراسلات</h2>
          <p>استكشاف وعرض تفاصيل المراسلات 🚀</p>
          <div class="row">
            <div class="col-md-12">
              <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" href="/cp/dashboard/contacts">المراسلات</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active">تفاصيل المراسلات</a>
                </li>
              </ul>
              <div class="card mb-4">
                <h5 class="card-header">تفاصيل المراسلات</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                  <div class="row">
                    <div class="mb-3 col-md-6">
                      <label for="firstName" class="form-label"><strong>الاسم</strong></label>
                      <p><?= $contact['name'] ?></p>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="email" class="form-label"><strong>البريد الالكتروني</strong></label>
                      <p><?= $contact['email'] ?></p>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label class="form-label" for="phoneNumber"><strong>الموضوع</strong></label>
                      <p><?= $contact['subject'] ?></p>
                    </div>
                    <div class="mb-3 col-md-12">
                      <label class="form-label" for="phoneNumber"><strong>الرسالة</strong></label>
                      <p><?= $contact['message'] ?></p>
                    </div>
                    <div class="mb-3 col-md-2">
                      <a class="btn btn-danger" href="/cp/dashboard/contacts/delete/<?= $contact['id'] ?>"><i class="fe fe-trash me-1"></i> حذف</a>
                      <a class="btn btn-info" href="mailto:<?= $contact['email'] ?>"><i class="fe fe-message-circle me-1"></i> ارسال ايميل</a>
                    </div>
                  </div>
                </div>
                <!-- /Account -->
              </div>
            </div>
          </div>
        </div>

      <?php } ?>

    </div> <!-- /.col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->