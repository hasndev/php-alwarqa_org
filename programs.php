<?php if (empty($sub_cat)) { ?>
	<!-- Home -->
	<section class="banner_area" style="background: url(/assets/images/courses.jpg) no-repeat center center;">
		<div class="banner_inner d-flex align-items-center">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="banner_content text-center">
							<h2><?= $language == "ar" ? "البرامج" : "Programs" ?></h2>
							<div class="mt-2">
								<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
									/</a>
								<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "برامجنا" : "Our Programs" ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Our Programs -->

	<div class="courses">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="section_title text-center">
						<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
							<?= $language == "ar" ? "برامجنا" : "Our Programs" ?>
						</h2>
					</div>
				</div>
			</div>

			<?php
			$count = 0;
			$q = 'SELECT *, count(`id`) as num,
			(SELECT `name` From `categories` WHERE `categories`.`id`=`programs`.`category`) category_name,
			(SELECT `name_en` From `categories` WHERE `categories`.`id`=`programs`.`category`) category_name_en,
			(SELECT `name` From `users` WHERE `users`.`id`=`programs`.`done_by`) emp
			FROM `programs` WHERE `status`=? Order by id DESC';
			$D = getData($con, $q, [1]);
			foreach ($D as $row) {
				$count = $row['num'];
			?>
				<!-- Featured Course -->
				<div class="row featured_row">
					<div class="col-lg-6 featured_col">
						<div class="featured_content">
							<div class="featured_header d-flex flex-row align-items-center justify-content-start">
								<div class="featured_tag"><a href="/<?= $language . '/programs/' . $row['id'] ?>"><?= $language == "ar" ? $row['category_name'] : $row['category_name_en'] ?></a>
								</div>
								<div class="featured_price ml-auto" <?= $language == "ar" ? 'dir="rtl"' : '' ?>>
									<?php
									if ($row['type'] == 1) {
										echo ($language == "ar" ? "السعر: " : "Price: ") . '<span>' . number_format($row['price']) . ' IQD</span>';
									} else echo ""
									?>
								</div>
							</div>
							<div <?= $language == "ar" ? 'class="featured_title text-right" dir="rtl"' : 'class="featured_title"' ?>>
								<h3><a href="/<?= $language . '/programs/details/' . $row['slug'] ?>"><?= $language == "ar" ? $row['name'] : $row['name_en'] ?></a>
								</h3>
							</div>
							<div style="display:block; word-wrap: break-word;" <?= $language == "ar" ? 'class="featured_text text-right" dir="rtl"' : 'class="featured_text"' ?>>
								<?= $language == "ar" ? $row['summary'] : $row['summary_en'] ?>
							</div>
							<div <?= $language == "ar" ? 'class="featured_footer d-flex align-items-center justify-content-start text-right" dir="rtl"'
										: 'class="featured_footer d-flex align-items-center justify-content-start"' ?>>
								<!-- <div class="featured_author_image <?= $language == "ar" ? "ml-3" : "" ?>"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div> -->
								<div class="featured_author_name"><?= $language == "ar" ? "المدرب:" : "Trainer:" ?>
									<a><?= $row['trainer'] ?></a>
								</div>
								<div class="course_sales ml-auto">
									<a style="color:#fcb92c;" href="/<?= $language . '/programs/details/' . $row['slug'] ?>">
										<?= $language == "ar" ? "اقرأ المزيد" : "Read More" ?>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 featured_col">
						<!-- Background image artist https://unsplash.com/@jtylernix -->
						<div class="featured_background" style="background-image:url(/cp/assets/images/programs/<?= $row['pic'] ?>)"></div>
					</div>
				</div>
			<?php
			}
			?>

			<div class="my-5"></div>
		</div>
	</div>
<?php }
if ("details" == $sub_cat && $slag != "") {
	$q = 'SELECT *,
	(SELECT `name` From `users` WHERE `users`.`id`=`programs`.`done_by`) emp,
	(SELECT `name` From `categories` WHERE `categories`.`id`=`programs`.`category`) category,
	(SELECT `name_en` From `categories` WHERE `categories`.`id`=`programs`.`category`) category_en
	FROM `programs` where `slug`=?';
	$program_details = getData($con, $q, [$slag]);
	#
	##
	### Check the news is found or not and redirect if it not
	if (count($program_details) == 0) {
		echo '<script>location.replace("/' . $language . '/' . $cat_id . '")</script>';
		die;
	}
	#
	$program = $program_details[0];
?>

	<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
		<div class="banner_inner d-flex align-items-center">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="banner_content text-center">
							<h2><?= $language == "ar" ? $program['name'] : $program['name_en']  ?></h2>
							<div class="mt-2">
								<a class="text-white" dir="rtl"><?= $language == "ar" ? $program['name'] : $program['name_en']  ?></a>

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
								<div class="news_post_image text-center " width="100%">
									<img style="max-height: 400px;" src="/cp/assets/images/programs/<?= $program['pic'] ?>" alt="">
								</div><br><br>
							</div>
							<div class="news_post_body">
								<div class="news_post_title mb-2 text-warning"><a><?= $language == "ar" ? $program['name'] : $program['name_en']  ?></a></div>
								<h5 class="mb-2">
									<i class="fas fa-list fa-md"></i> <?= $language == "ar" ? "الصنف" : "Category"  ?>: <?= $language == "ar" ? $program['category'] : $program['category_en']  ?>
								</h5>

								<h5 class="mb-2">
									<i class="fas fa-briefcase fa-md"></i> <?= $language == "ar" ? "النوع" : "Type"  ?>: <?= $program['type'] == 1 ? ($language == "ar" ? "مدفوع" : "Paid") : ($language == "ar" ? "مجاني" : "Free") ?>
									<?= $program['type'] == 1 ? "<br><br> السعر: " . $program['price'] . " ع.د" : "" ?>
								</h5>

								<h5 class="mb-2 text-warning">
									<i class="fas fa-user fa-md"></i> <?= $language == "ar" ? "المدرب" : "Trainer"  ?>: <?= $program['trainer'] ?>
								</h5>
								<div class="row" style="display:block; word-wrap: break-word;">
									<div class="news_post_text px-2">
										<p>
											<?= $program['note'] ?>
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
							<h4 class="text-warning"><?= $language == "ar" ? "البرامج ذات الصلة" : "Related Projects" ?></h4>
							<div class="row">
								<?php
								$qp = "SELECT *,
								(SELECT `name` From `categories` WHERE `categories`.`id`=`programs`.`category`) category_name
								FROM `programs` WHERE `status`=? and category =? and slug!=? Order by  RAND() LIMIT 4";
								$dp = getData($con, $qp, [1, $program['category'], $slag]);
								if (count($dp) > 0) {
									foreach ($dp as $row) {
								?>
										<div class="col-md-12 mb-2">
											<i class="fa fa-rocket text-warning"></i> <a class="text-warning" href="/<?= $language ?>/projects/details/<?= $row['slug'] ?>"><?= $language == "ar" ? $row['name'] : $row['name_en']  ?></a>
										</div>
								<?php }
								} else echo '<div class="col-md-12 mb-2">' . ($language == "ar" ? "لا يوجد أي برامج ذات صلة" : "There is No Programs Related") . '</div>'
								?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
<?php } ?>