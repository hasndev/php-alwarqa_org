<!-- Home -->

<section class="banner_area" style="background: url(/assets/images/contact.jpg) no-repeat center center;">
	<div class="banner_inner d-flex align-items-center">
		<div class="overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="banner_content text-center">
						<h2><?= $language == "ar" ? "التواصل" : "Contact" ?></h2>
						<div class="mt-2">
							<a class="text-white" href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?>
								/</a>
							<a class="text-white" href="/<?= $language ?>/programs"><?= $language == "ar" ? "تواصل معنا" : "Contact Us" ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- Contact -->

<div class="contact mt-4 pt-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
						<?= $language == "ar" ? "تواصل معنا" : "Contact Us" ?>
					</h2>
				</div>
			</div>
		</div>
		<div class="row row-xl-eq-height" <?= $language == "ar" ? 'dir="rtl"' : "" ?>>
			<!-- Contact Content -->
			<div class="col-xl-6">
				<div class="contact_content">
					<div class="row">
						<div class="col-xl-6">
							<div class="contact_about">
								<div class="logo_container">
									<a href="#" <?= $language == "ar" ? 'class="text-right" dir="rtl"' : '' ?>>
										<div class="logo_content d-flex flex-row align-items-end justify-content-start">
											<div class="logo_img"><img src="/assets/images/logo.png" alt=""></div>
											<h4 class="logo_text" style="line-height: 1.2; margin-right: 20px;">
												<?= $language == "ar" ? 'منظمة الورقة لتطوير المهارات' : 'AlWarqa Organization for Skills Development' ?>
											</h4>
										</div>
									</a>
								</div>
								<div class="contact_about_text">
									<p class="<?= $language == "ar" ? 'text-right' : '' ?>">
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
									</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 footer_col mt-4">
							<div class="footer_contact">
								<div class="footer_title <?= $language == "ar" ? 'text-right' : '' ?>"><?= $language == "ar" ? 'تواصل معنا' : 'Contact Us' ?></div>
								<div <?= $language == "ar" ? 'class="footer_contact_info-ar text-right" style=" margin-top: 20px;" dir="rtl"' : 'class="footer_contact_info"' ?>>
									<div class="footer_contact_item">
										<div class="footer_contact_title"><?= $language == "ar" ? 'العنوان' : 'Address' ?>:</div>
										<div class="footer_contact_line"><?= $language == "ar" ? 'العراق - ميسان, العمارة' : 'Iraq - Maysan, Amarah' ?></div>
									</div>
									<div class="footer_contact_item">
										<div class="footer_contact_title"><?= $language == "ar" ? 'رقم الهاتف' : 'Phone' ?>:</div>
										<div class="footer_contact_line" dir="ltr"><?= $phone ?></div>
									</div>
									<div class="footer_contact_item">
										<div class="footer_contact_title"><?= $language == "ar" ? 'البريد الالكتروني' : 'Email' ?>:</div>
										<div class="footer_contact_line"><?= $email ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
			<div class="col-xl-6 map_col mt-4">
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