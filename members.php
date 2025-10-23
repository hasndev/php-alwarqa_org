<!-- Home -->

<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
	<div class="banner_inner d-flex align-items-center">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="banner_content text-center">
						<h2><?= $language == "ar" ? "الاعضاء" : "Members" ?></h2>
						<div class="mt-2">
							<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
								/</a>
							<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "الاعضاء" : "Members" ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Members -->

<div class="teachers">
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
		<div class="row teachers_row" <?= $language == "ar" ? 'dir="rtl"' : "" ?>>

			<?php
			$count = 0;
			$q = 'SELECT *, count(`id`) as num,
			(SELECT `name` From `users` WHERE `users`.`id`=`members`.`done_by`) emp
			FROM `members` WHERE `status`=? Order by id DESC';
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
	</div>
</div>