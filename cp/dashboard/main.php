  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row align-items-center mb-2">
          <div class="col">
            <h2 class="h5 page-title">مرحبا مجدداً, كنا بأنتظارك 😊🚀!</h2>
          </div>
          <div class="col-auto">

          </div>
        </div>
        <div class="mb-2 align-items-center">
          <!-- info small box -->
          <div class="row">
            <?php
            if (substr($_SESSION['permission'], 1, 1) == 1) {
            ?>
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col">
                        <span class="h2 mb-0">
                          <?php
                          $D = getData($con, 'SELECT count(`id`)categories FROM `categories`');
                          echo $D[0]['categories'];
                          ?>
                        </span>
                        <p class="h5 mb-0">الاصناف</p>
                        <!-- <span class="badge badge-pill badge-primary">+15.5%</span> -->
                        <span class="fe fe-arrow-right fe-12 text-primary"></span> <a class="text-primary" href="/admin/dashboard/projects">عرض المزيد</a>

                      </div>
                      <div class="col-auto">
                        <span class="fe fe-32 fe-list text-info mb-0"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            if (substr($_SESSION['permission'], 5, 1) == 1) {
            ?>
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col">
                        <span class="h2 mb-0">
                          <?php
                          $D = getData($con, 'SELECT count(`id`)programs FROM `programs`');
                          echo $D[0]['programs'];
                          ?>
                        </span>
                        <p class="h5 mb-0">البرامج</p>
                        <!-- <span class="badge badge-pill badge-success">+16.5%</span> -->
                        <span class="fe fe-arrow-right fe-12 text-primary"></span> <a class="text-primary" href="/admin/dashboard/projects">عرض المزيد</a>

                      </div>
                      <div class="col-auto">
                        <span class="fe fe-32 fe-layers text-success mb-0"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            if (substr($_SESSION['permission'], 10, 1) == 1) {
            ?>
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col">
                        <span class="h2 mb-0">
                          <?php
                          $D = getData($con, 'SELECT count(`id`)events FROM `blogs`');
                          echo $D[0]['events'];
                          ?>
                        </span>
                        <p class="h5 mb-0">النشاطات</p>
                        <!-- <span class="badge badge-pill badge-warning">+1.5%</span> -->
                        <span class="fe fe-arrow-right fe-12 text-primary"></span> <a class="text-primary" href="/admin/dashboard/projects">عرض المزيد</a>

                      </div>
                      <div class="col-4 text-right">
                        <i class="fa fa-bullhorn fa-2x text-warning"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div> <!-- end section -->
          <!-- Contact -->
          <div class="row items-align-baseline mb-4">
            <div class="col-md-12">
              <div class="card shadow">
                <h5 class="card-header">احدث المراسلات</h5>
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
                      $q = 'SELECT * FROM `contact` Order by id DESC LIMIT 5';
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
          </div> <!-- .row -->
        </div>
        <div class="row items-align-baseline">
          <div class="col-md-12 col-lg-4">
            <div class="card shadow eq-card mb-4">
              <div class="card-body mb-n3">
                <div class="row items-align-baseline h-100">
                  <div class="col-md-6 my-3">
                    <p class="mb-0"><strong class="mb-0 text-uppercase text-muted">Earning</strong></p>
                    <h3>$2,562</h3>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  </div>
                  <div class="col-md-6 my-4 text-center">
                    <div lass="chart-box mx-4">
                      <div id="radialbarWidget"></div>
                    </div>
                  </div>
                  <div class="col-md-6 border-top py-3">
                    <p class="mb-1"><strong class="text-muted">Cost</strong></p>
                    <h4 class="mb-0">108</h4>
                    <p class="small text-muted mb-0"><span>37.7% Last week</span></p>
                  </div> <!-- .col -->
                  <div class="col-md-6 border-top py-3">
                    <p class="mb-1"><strong class="text-muted">Revenue</strong></p>
                    <h4 class="mb-0">1168</h4>
                    <p class="small text-muted mb-0"><span>-18.9% Last week</span></p>
                  </div> <!-- .col -->
                </div>
              </div> <!-- .card-body -->
            </div> <!-- .card -->
          </div> <!-- .col -->
          <div class="col-md-12 col-lg-4">
            <div class="card shadow eq-card mb-4">
              <div class="card-body">
                <div class="chart-widget mb-2">
                  <div id="radialbar"></div>
                </div>
                <div class="row items-align-center">
                  <div class="col-4 text-center">
                    <p class="text-muted mb-1">Cost</p>
                    <h6 class="mb-1">$1,823</h6>
                    <p class="text-muted mb-0">+12%</p>
                  </div>
                  <div class="col-4 text-center">
                    <p class="text-muted mb-1">Revenue</p>
                    <h6 class="mb-1">$6,830</h6>
                    <p class="text-muted mb-0">+8%</p>
                  </div>
                  <div class="col-4 text-center">
                    <p class="text-muted mb-1">Earning</p>
                    <h6 class="mb-1">$4,830</h6>
                    <p class="text-muted mb-0">+8%</p>
                  </div>
                </div>
              </div> <!-- .card-body -->
            </div> <!-- .card -->
          </div> <!-- .col -->
          <div class="col-md-12 col-lg-4">
            <div class="card shadow eq-card mb-4">
              <div class="card-body">
                <div class="d-flex mt-3 mb-4">
                  <div class="flex-fill pt-2">
                    <p class="mb-0 text-muted">Total</p>
                    <h4 class="mb-0">108</h4>
                    <span class="small text-muted">+37.7%</span>
                  </div>
                  <div class="flex-fill chart-box mt-n2">
                    <div id="barChartWidget"></div>
                  </div>
                </div> <!-- .d-flex -->
                <div class="row border-top">
                  <div class="col-md-6 pt-4">
                    <h6 class="mb-0">108 <span class="small text-muted">+37.7%</span></h6>
                    <p class="mb-0 text-muted">Cost</p>
                  </div>
                  <div class="col-md-6 pt-4">
                    <h6 class="mb-0">1168 <span class="small text-muted">-18.9%</span></h6>
                    <p class="mb-0 text-muted">Revenue</p>
                  </div>
                </div> <!-- .row -->
              </div> <!-- .card-body -->
            </div> <!-- .card -->
          </div> <!-- .col-md -->
        </div> <!-- .row -->

      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->