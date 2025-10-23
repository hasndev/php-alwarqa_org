<!-- Hero -->
<div class="home" style="height:640px">
	<!-- Background image artist https://unsplash.com/@thepootphotographer -->
	<div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="/assets/images/about.jpg" data-speed="0.8"></div>
	<div class="home_container">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="home_slider_container text-center">
						<div class="breadcrumbs">
							<div class="home_text mt-4 pt-4">
								<div class="home_title" style="line-height: 1.1;">
									<?= $language == "ar" ? "منظمة الورقة لتطوير المهارات" : "AlWarqa Organization for Skills Development" ?>
								</div>
								<div class="home_subtitle">
									<?php
									if ($language == "ar") {
										echo 'منظمة الورقة لتطوير المهارات منظمة غير ربحية وغير حكومية مستقلة 
										هدفها الرئيسي تطوير المهارات الرقمية والحياتية للشباب والاطفال 
										واهدف لتعزيز دور المعلمين في المدارس وادخال مناهج التعلم الرقمي في العراق';
									} else {
										echo 'AlWarqa Organization for Skills Development is an
										independent non-profit, non-governmental organization registered in Iraq,
										whose main goal is to develop digital and life skills for youth and
										children. It aims to enhance the role of teachers in schools and introduce
										digital learning curricula in Iraqi schools.';
									}
									?>

								</div>
								<div class="button home_button mt-3">
									<a href="/<?= $language ?>/about">
										<?= $language == "ar" ? "اقرأ المزيد عنا" : "Read More" ?>
										<div class="button_arrow">
											<i class="fa fa-angle-right text-white" aria-hidden="true"></i>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- About US -->

<div class="grouped_sections">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
						<?= $language == "ar" ? "من نحن؟" : "About Us" ?>
					</h2>
				</div>
			</div>
		</div>

		<?php
		# Get All Settings
		$q = 'SELECT * FROM `settings` where `id`=1';
		$settings = getData($con, $q);
		?>

		<div class="row" <?= $language == "ar" ? 'dir="rtl"' : '' ?>>

			<!-- About Us -->
			<div class="col-lg-8 grouped_col">
				<div class="accordions">
					<div class="row about_row row-lg-eq-height">
						<div class="col-lg-6 mb-4 text-center">
							<div class="about_image"><img src="/assets/images/about-logo.png" alt="https://unsplash.com/@jtylernix"></div>
						</div>
						<div class="col-lg-6">
							<div class="about_content">
								<div>
									<p <?= $language == "ar" ? 'class="text-right"' : '' ?>>
										<?= $language == "ar" ? $settings[0]['about_ar'] : $settings[0]['about'] ?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Mission and Vision -->

			<div class="col-lg-4 grouped_col">
				<div class="accordions">

					<div class="accordion_container" <?= $language == "ar" ? 'dir="ltr"' : '' ?>>
						<div class="accordion d-flex flex-row align-items-center active">
							<div><?= $language == "ar" ? "رسالتنا" : "Our Mission" ?></div>
						</div>
						<div class="accordion_panel">
							<div>
								<p <?= $language == "ar" ? 'class="text-right" dir="rtl"' : '' ?>>
									<?= $language == "ar" ? $settings[0]['mission_ar'] : $settings[0]['mission'] ?>
								</p>
							</div>
						</div>
					</div>

					<div class="accordion_container" <?= $language == "ar" ? 'dir="ltr"' : '' ?>>
						<div class="accordion d-flex flex-row align-items-center">
							<div><?= $language == "ar" ? "رؤيتنا" : "Our Vision" ?></div>
						</div>
						<div class="accordion_panel">
							<div>
								<p <?= $language == "ar" ? 'class="text-right" dir="rtl"' : '' ?>>
									<?= $language == "ar" ? $settings[0]['vision_ar'] : $settings[0]['vision'] ?>
								</p>
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>
	</div>
</div>

<!-- Events -->

<div class="courses pb-0">
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

		<div class="row pt-4" <?= $language == "ar" ? 'dir="rtl"' : "" ?>>

			<?php
			$count = 0;
			$q = 'SELECT *, count(`id`) as num,
			(SELECT `name` From `users` WHERE `users`.`id`=`blogs`.`done_by`) emp
			FROM `blogs` WHERE `status`=? Order by id DESC LIMIT 6';
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
							<div style="display:block; word-wrap: break-word;" <?= $language == "ar" ? 'class="featured_text text-right" dir="rtl"' : 'class="featured_text"' ?>>
								<?= $language == "ar" ? $row['summary'] : $row['summary_en'] ?>
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


<!-- Analysis -->

<div class="milestones">
	<!-- Background image artis https://unsplash.com/@thepootphotographer -->
	<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="/assets/images/milestones.jpg" data-speed="0.8"></div>
	<div class="container">
		<div class="row milestones_container">

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="/assets/images/analysis/courses.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="
					<?php
					$D = getData($con, 'SELECT count(`id`)programs FROM `programs`');
					echo $D[0]['programs'];
					?>
					">0</div>
					<div class="milestone_text"><?= $language == "ar" ? "البرامج" : "Programs" ?></div>
				</div>
			</div>

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img style="height: 90px;" src="/assets/images/analysis/events.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="
					<?php
					$D = getData($con, 'SELECT count(`id`)events FROM `blogs`');
					echo $D[0]['events'];
					?>
					">0</div>
					<div class="milestone_text"><?= $language == "ar" ? "النشاطات" : "Events" ?></div>
				</div>
			</div>

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="/assets/images/analysis/teacher.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="
					<?php
					$D = getData($con, 'SELECT count(`id`)programs FROM `programs`');
					echo $D[0]['programs'];
					?>
					">0</div>
					<div class="milestone_text"><?= $language == "ar" ? "المدربين" : "Trainers" ?></div>
				</div>
			</div>

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="/assets/images/analysis/students.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="
					<?php
					$D = getData($con, 'SELECT count(`id`)programs FROM `programs`');
					echo $D[0]['programs'];
					?>
					">0</div>
					<div class="milestone_text"><?= $language == "ar" ? "المتدربين" : "Trainees" ?></div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Our Programs -->

<div class="courses pb-4">
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
		FROM `programs` WHERE `status`=? Order by id DESC LIMIT 3';
		$D = getData($con, $q, [1]);
		foreach ($D as $row) {
			$count = $row['num'];
		?>
			<!-- Featured Course -->
			<div class="row pt-4">
				<div class="col-lg-6 featured_col">
					<div class="featured_content">
						<div class="featured_header d-flex flex-row align-items-center justify-content-start">
							<div class="featured_tag"><a href="/<?= $language . '/programs/' . $row['id'] ?>"><?= $language == "ar" ? $row['category_name'] : $row['category_name_en'] ?></a></div>
							<div class="featured_price ml-auto" <?= $language == "ar" ? 'dir="rtl"' : '' ?>>
								<?php
								if ($row['type'] == 1) {
									echo ($language == "ar" ? "السعر: " : "Price: ") . '<span>' . number_format($row['price']) . ' IQD</span>';
								} else echo ""
								?>
							</div>
						</div>
						<div <?= $language == "ar" ? 'class="featured_title text-right" dir="rtl"' : 'class="featured_title"' ?>>
							<h3><a href="/<?= $language . '/programs/details/' . $row['slug'] ?>"><?= $language == "ar" ? $row['name'] : $row['name_en'] ?></a></h3>
						</div>
						<div style="display:block; word-wrap: break-word;" <?= $language == "ar" ? 'class="featured_text text-right" dir="rtl"' : 'class="featured_text"' ?>>
							<?= $language == "ar" ? $row['summary'] : $row['summary_en'] ?>
						</div>
						<div <?= $language == "ar" ? 'class="featured_footer d-flex align-items-center justify-content-start text-right" dir="rtl"'
									: 'class="featured_footer d-flex align-items-center justify-content-start"' ?>>
							<!-- <div class="featured_author_image <?= $language == "ar" ? "ml-3" : "" ?>"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div> -->
							<div class="featured_author_name"><?= $language == "ar" ? "المدرب:" : "Trainer:" ?> <a><?= $row['trainer'] ?></a></div>
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
		if ($count > 6) {
		?>
			<div class="my-5"></div>
			<div class="row mt-4" style="justify-content: center;">
				<div class="button home_button mt-3">
					<a href="/<?= $language ?>/events"><?= $language == "ar" ? "عرض المزيد" : "Show More" ?>
						<div class="button_arrow">
							<i class="fa fa-angle-right text-white" aria-hidden="true"></i>
						</div>
					</a>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>

<!-- Members -->

<div class="teachers pb-4">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
						<?= $language == "ar" ? "الاعضاء" : "Members" ?>
					</h2>
				</div>
			</div>
		</div>
		<div class="row pt-4" <?= $language == "ar" ? 'dir="rtl"' : "" ?>>

			<?php
			$count = 0;
			$q = 'SELECT *, count(`id`) as num,
			(SELECT `name` From `users` WHERE `users`.`id`=`members`.`done_by`) emp
			FROM `members` WHERE `status`=? Order by id DESC LIMIT 6';
			$D = getData($con, $q, [1]);
			foreach ($D as $row) {
				$count = $row['num'];
			?>
				<!-- Member -->
				<div class="col-lg-4 col-md-6">
					<div class="teacher">
						<div class="teacher_image"><img src="/cp/assets/images/members/<?= $row['pic'] ?>" alt="<?= $row['name'] ?>.jpg"></div>
						<div class="teacher_body text-center">
							<div class="teacher_title"><a><?= $row['name'] ?></a></div>
							<div class="teacher_subtitle"><?= $row['job'] ?></div>
							<div class="teacher_social" dir="ltr">
								<ul>
									<?php
									if ($row['instagram'] != '')
										echo '<li><a href="' . $row['instagram'] . '" target="_blank"><i class="fab fa-instagram fa-lg"></i></a></li> ';
									if ($row['facebook'] != '')
										echo '<li><a href="' . $row['facebook'] . '" target="_blank"><i class="fab fa-facebook fa-lg"></i></a></li> ';
									if ($row['linkedin'] != '')
										echo '<li><a href="' . $row['linkedin'] . '" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a></li> ';
									if ($row['twitter'] != '')
										echo '<li><a href="' . $row['twitter'] . '" target="_blank"><i class="fab fa-twitter fa-lg"></i></a></li> ';
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<div class="row">
			<div class="col text-center">
				<div class="button teachers_button">
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
</div>


<!-- Success Story وصلنه هنا نحتاج نضيف سكشنات المعرض وكذلك قصص النجاح-->

<div class="video">
	<div class="container">
		<?php

		$q = 'SELECT *,
		(SELECT `name` From `users` WHERE `users`.`id`=`stories`.`done_by`) emp
		FROM `stories` WHERE `status`=? Order by id DESC';
		$D = getData($con, $q, [1]);
		foreach ($D as $row) {
		?>
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="section_title text-center">
						<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
							<?= $language == "ar" ? "قصص النجاح" : "Success Story" ?>
						</h2>
					</div>
				</div>
			</div>
			<div class="featured_row" style="margin-top: 20px;">
				<div class="col">
					<div class="video_container_outer">
						<div class="video_container">
							<?php
							if ($row['type'] == 1) {
								echo '<iframe class="video_container_outer" src="https://www.youtube.com/embed/' . $row['link'] . '" allowfullscreen></iframe>';
							} else {
								$file_extension = pathinfo($row['pic'], PATHINFO_EXTENSION);
								if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
									// Display an image if the file is an image
									echo '<img src="/cp/assets/images/stories/' . $row['pic'] . '" alt="Image">';
								} elseif (in_array($file_extension, array('mp4', 'webm', 'ogg'))) {
									// Display a video if the file is a video
									echo '<video controls>
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
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="section_title text-center">
						<div class="pt-4">
							<h3 class="font-bold"><?= $row['title'] ?></h3>
							<?= $row['note'] ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		?>

		<div class="row p-4">
			<div class="col text-center">
				<div class="button teachers_button">
					<a href="/<?= $language ?>/success_story"><?= $language == "ar" ? "عرض المزيد" : "Show More" ?>
						<div class="button_arrow">
							<i class="fa fa-angle-right text-white" aria-hidden="true"></i>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Contact -->

<div class="contact mt-4 pt-4">
	<div class="container-fluid">
		<div class="row  pb-0">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
						<?= $language == "ar" ? "تواصل معنا" : "Contact Us" ?>
					</h2>
				</div>
			</div>
		</div>
		<div class="row row-xl-eq-height">
			<!-- Contact Content -->
			<div class="col-xl-6">
				<div class="contact_content" style="padding-top:0px">
					<div class="contact_form_container">
						<form method="POST" id="contact_form" class="contact_form" <?= ($language == "ar" ? "dir='rtl' style='padding-right: 5px;'" : "") ?>>
							<div>
								<div class="row">
									<div class="col-lg-6 contact_name_col">
										<input type="text" name="name" id="name" class="contact_input" <?= ($language == "ar" ? "placeholder='الاسم الكامل' style='padding-right: 5px;'" : "placeholder='Full Name'") ?> required="required">
									</div>
									<div class="col-lg-6">
										<input type="email" name="email" id="email" class="contact_input" <?= ($language == "ar" ? "placeholder='البريد الالكتروني' style='padding-right: 5px;'" : "placeholder='E-mail'") ?> required="required">
									</div>
								</div>
							</div>
							<div>
								<input type="text" name="subject" id="subject" class="contact_input" <?= ($language == "ar" ? "placeholder='الموضوع' style='padding-right: 5px;'" : "placeholder='Subject'") ?> required="required">
							</div>
							<div>
								<textarea class="contact_input contact_textarea" name="message" id="message" <?= ($language == "ar" ? "placeholder='الرسالة' style='padding-right: 5px;'" : "placeholder='Message'") ?>></textarea>
							</div>
							<div class="form-group mb-4">
								<!-- Google reCAPTCHA block -->
								<div class="g-recaptcha" data-sitekey="6LfYeLYlAAAAAML8vxILQyhytMBOr9Cmgpmul-FQ"></div><br>
							</div>
							<div class="button" dir="ltr">
								<button class="p-2 button text-white" type="submit" name="contact" style="border: none; cursor: pointer;" id="form-submit"><?= $language == "ar" ? "ارسال الرسالة" : "Send Message" ?></button>
								<i class="fa fa-angle-right text-white pr-2" aria-hidden="true"></i>
							</div>

						</form>
					</div>
				</div>
			</div>

			<!-- Contact Map -->
			<div class="col-xl-6 map_col mt-4 pt-4">
				<div class="contact_map">

					<!-- Google Map -->
					<div id="google_map" class="google_map text-center">
						<div class="map_container">
							<div id='map' width="100%">
								<?= $map_link ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>