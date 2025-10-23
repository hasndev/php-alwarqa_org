<!-- Home -->
<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
	<div class="banner_inner d-flex align-items-center">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="banner_content text-center">
						<h2><?= $language == "ar" ? "عنا" : "About" ?></h2>
						<div class="mt-2">
							<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
								/</a>
							<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "عنا" : "About" ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

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