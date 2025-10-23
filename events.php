<?php if (empty($sub_cat)) { ?>
	<!-- Home -->
	<section class="banner_area" style="background: url(/assets/images/courses.jpg) no-repeat center center;">
		<div class="banner_inner d-flex align-items-center">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="banner_content text-center">
							<h2><?= $language == "ar" ? "النشاطات" : "Events" ?></h2>
							<div class="mt-2">
								<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
									/</a>
								<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "نشاطاتنا" : "Our Events" ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Events -->

	<div class="courses">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="section_title text-center">
						<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
							<?= $language == "ar" ? "نشاطاتنا" : "Our Events" ?>
						</h2>
					</div>
				</div>
			</div>

			<div class="row courses_row" <?= $language == "ar" ? 'dir="rtl"' : "" ?>>

				<?php
				if ($language == 'en') {
				?>
					<style>
						.course_summary {
							max-height: 300px;
							/* Adjust this value as needed */
							overflow: hidden;
							text-overflow: ellipsis;
							white-space: nowrap;
						}
					</style>
				<?php
				}
				$count = 0;
				$q = 'SELECT *, count(`id`) as num,
				(SELECT `name` From `users` WHERE `users`.`id`=`blogs`.`done_by`) emp
				FROM `blogs` WHERE `status`=? Order by id DESC';
				$D = getData($con, $q, [1]);
				foreach ($D as $row) {
					$count = $row['num'];
				?>
					<!-- Course -->
					<div class="col-lg-4 col-md-6">
						<div class="course">
							<div class="course_image"><img src="/cp/assets/images/blogs/<?= $row['pic'] ?>" alt=""></div>
							<div class="course_body">
								<div class="course_header d-flex flex-row align-items-center justify-content-start">
									<div class="course_tag"><a class="text-white"><?= date("F j, Y", strtotime($row['date_add'])) ?></a></div>
								</div>
								<div <?= $language == "ar" ? 'class="course_title text-right" dir="rtl"' : 'class="course_title"' ?>>
									<h3><a href="/<?= $language . '/events/details/' . $row['slug'] ?>"><?= $language == "ar" ? $row['title'] : $row['title_en'] ?></a></h3>
								</div>
								<div class="course_text">
									<div <?= $language == "ar" ? 'class="course_summary text-right" dir="rtl"' : 'class="course_summary"' ?>>
										<?= SubDescription(($language == "ar" ? $row['summary'] : $row['summary_en']), 300) ?>
									</div>
								</div>
								<div <?= $language == "ar" ? 'class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl"' : 'class="course_footer d-flex align-items-center justify-content-start"' ?>>
									<div class="course_sales ml-auto">
										<a style="color:#fcb92c;" href="/<?= $language . '/events/details/' . $row['slug'] ?>">
											<?= $language == "ar" ? "اقرأ المزيد" : "Read More" ?>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php
				}
				?>
			</div>
			<div class="row" style="justify-content: center;">
				<div class="button home_button mt-3">
					<?php
					if ($count > 6) {
					?>
						<a href="/<?= $language ?>/events"><?= $language == "ar" ? "عرض المزيد" : "Show More" ?>
							<div class="button_arrow">
								<i class="fa fa-angle-right text-white" aria-hidden="true"></i>
							</div>
						</a>

					<?php
					}
					?>
				</div>

			</div>

		</div>
	</div>
<?php }
if ("details" == $sub_cat && $slag != "") {
	$q = 'SELECT *,
	(SELECT `name` From `users` WHERE `users`.`id`=`blogs`.`done_by`) emp
	FROM `blogs` where `slug`=?';
	$blogs_details = getData($con, $q, [$slag]);
	#
	##
	### Check the news is found or not and redirect if it not
	if (count($blogs_details) == 0) {
		echo '<script>location.replace("/' . $language . '/' . $cat_id . '")</script>';
		die;
	}
	#
	$blog = $blogs_details[0];
?>

	<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
		<div class="banner_inner d-flex align-items-center">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="banner_content text-center">
							<h2><?= $language == "ar" ? $blog['title'] : $blog['title_en']  ?></h2>
							<div class="mt-2">
								<a class="text-white" dir="rtl"><?= $language == "ar" ? $blog['title'] : $blog['title_en']  ?></a>

								/ <a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- News -->

	<div class="news">
		<div class="container">
			<div class="row" <?= $language == "ar" ? "dir='rtl'" : ""  ?>>

				<!-- News Posts -->
				<div class="col-lg-8">
					<div class="news_posts">

						<!-- News Post -->
						<div class="news_post" <?= $language == "ar" ? "dir='rtl' style='text-align:right;'" : ""  ?>>
							<div class="row justify-content-center">
								<div class="news_post_image text-center" width="100%">
									<img style="max-height: 400px;" src="/cp/assets/images/blogs/<?= $blog['pic'] ?>" alt="">
								</div><br><br>
							</div>
							<div class="news_post_body">
								<div class="news_post_title mb-2 text-warning"><a><?= $language == "ar" ? $blog['title'] : $blog['title_en']  ?></a></div>
								<h5 class="mb-2">
									<i class="fas fa-calendar fa-md"></i> <?= $language == "ar" ? "التاريخ" : "Date"  ?>: <?= date("F j, Y", strtotime($blog['date_add'])) ?>
								</h5>

								<div class="row" style="display:block; word-wrap: break-word;">
									<div class="news_post_text px-2">
										<p>
											<?= $blog['note'] ?>
										</p>

									</div>
								</div>
							</div>

						</div>
					</div>

				</div>

				<div class="col-lg-4">
					<div class="sidebar">
						<div class="container widget category-widget bg-light p-4" <?= $language == "ar" ? "dir='rtl' style='text-align:right;'" : ""  ?>>
							<h4 class="text-warning"><?= $language == "ar" ? "النشاطات ذات الصلة" : "Related Events" ?></h4>
							<div class="row">
								<?php
								$qp = "SELECT * FROM `blogs` WHERE `status`=? and slug!=? Order by  RAND() LIMIT 4";
								$dp = getData($con, $qp, [1, $slag]);
								if (count($dp) > 0) {
									foreach ($dp as $row) {
								?>
										<div class="col-md-12 mb-2">
											<i class="fa fa-rocket text-warning"></i> <a class="text-warning" href="/<?= $language ?>/events/details/<?= $row['slug'] ?>"><?= $language == "ar" ? $row['name'] : $row['name_en']  ?></a>
										</div>
								<?php }
								} else echo '<div class="col-md-12 mb-2">' . ($language == "ar" ? "لا توجد نشاطات ذات صلة" : "There is No Events Related") . '</div>'
								?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
<?php } ?>