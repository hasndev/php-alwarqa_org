<!-- Home -->

<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
	<div class="banner_inner d-flex align-items-center">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="banner_content text-center">
						<h2><?= $language == "ar" ? "قصص النجاح" : "Success Stories" ?></h2>
						<div class="mt-2">
							<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
								/</a>
							<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "قصص النجاح" : "Success Stories" ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- Success Story -->

<div class="courses">
	<div class="container">
		<div class="row justify-content-around space-x-3">
			<?php
			#
			$sn = 1;
			$q = 'SELECT *,
			(SELECT `name` From `users` WHERE `users`.`id`=`stories`.`done_by`) emp
			FROM `stories` Order by id DESC';
			$D = getData($con, $q);
			foreach ($D as $row) {
			?>
				<!-- Success Story -->
				<div class="col-lg-6 col-md-6">
					<div class="featured_row">
						<div class="text-center">
							<div class="video_container_outer">
								<div class="video_container">
									<?php
									if ($row['type'] == 1) {
										echo '<iframe class="video_container_outer" style="background-color:white" src="https://www.youtube.com/embed/' . $row['link'] . '" allowfullscreen></iframe>';
									} else {
										$file_extension = pathinfo($row['pic'], PATHINFO_EXTENSION);
										if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
											// Display an image if the file is an image
											echo '<img class="video_container_outer" src="/cp/assets/images/stories/' . $row['pic'] . '" alt="Image">';
										} elseif (in_array($file_extension, array('mp4', 'webm', 'ogg'))) {
											// Display a video if the file is a video
											echo '<video controls class="video_container_outer" style="background-color:white">
									<source src="/cp/assets/images/stories/' . $row['pic'] . '" type="video/' . $file_extension . ' ">
										Your browser does not support the video tag.
									</video>';
										} else {
											// Handle other file types or provide an error message
											echo 'Unsupported file type: ' . $file_extension;
										}
									}
									?>
								</div>
							</div>
							<div class="section_title text-center">
								<h3 class="font-bold font-weight-bold p-2 border-2" style="color:#fcb92c;">
									<?= $row['title'] ?>
								</h3>
								<div>
									<?= $row['note'] ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}

			?>

		</div>
	</div>
</div>