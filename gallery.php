<!-- Home -->

<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
	<div class="banner_inner d-flex align-items-center">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="banner_content text-center">
						<h2><?= $language == "ar" ? "معرض الصور" : "Gallery" ?></h2>
						<div class="mt-2">
							<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
								/</a>
							<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "معرضنا" : "Our Gallery" ?></a>
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
						<?= $language == "ar" ? "معرضنا" : "Our Gallery" ?>
					</h2>
				</div>
			</div>
		</div>

		<div class="row courses_row" <?= $language == "ar" ? 'dir="rtl"' : "" ?>>
			<?php
			#
			$sn = 1;
			$q = 'SELECT *,
            (SELECT `name` From `users` WHERE `users`.`id`=`gallery`.`done_by`) emp
            FROM `gallery` WHERE `status`=? Order by id DESC';
			$D = getData($con, $q, [1]);
			foreach ($D as $row) {
			?>

				<!-- Gallery -->
				<div class="col-lg-4 col-md-6">
					<div class="course">
						<div class="course_image">
							<?php
							$file_extension = pathinfo($row['pic'], PATHINFO_EXTENSION);

							if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
								// Display an image if the file is an image
								echo '<img style="max-height: 300px; max-width: 300px;border-radius:10px;" src="/cp/assets/images/gallery/' . $row['pic'] . '" alt="Image">';
							} elseif (in_array($file_extension, array('mp4', 'webm', 'ogg'))) {
								// Display a video if the file is a video
								echo '<video controls style="max-height: 400px; max-width: 400px;border-radius:10px;">
									 	<source src="/cp/assets/images/gallery/' . $row['pic'] . '" type="video/' . $file_extension . ' ">
									 	Your browser does not support the video tag.
									 </video>';
							} else {
								// Handle other file types or provide an error message
								echo 'Unsupported file type: ' . $file_extension;
							}
							?>
						</div>
						<h5 class="course_title mb-2 text-center"><?= $row['title'] ?></h5><br>
					</div>
				</div>
			<?php
			}

			?>

		</div>

	</div>
</div>