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
								<div class="home_title" style="line-height: 1.2;">منظمة الورقة لتطوير المهارات
								</div>
								<div class="home_subtitle">

								</div>
								<div class="button home_button mt-3">
									<a href="about">اقرأ المزيد عنا
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
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">من نحن؟</h2>
				</div>
			</div>
		</div>

		<div class="row" dir="rtl">

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
									<p class="text-right">
										منظمة الورقة لتطوير المهارات هي منظمة غير ربحية مقرها في الشرق الأوسط
										تهدف إلى تمكين وتعزيز مهارات الأفراد، وخاصة الشباب، من خلال برامج
										تدريبية وورش عمل مختلفة. تركز المؤسسة على تطوير المهارات العملية في
										مجالات مثل القيادة والاتصال وحل المشكلات وريادة الأعمال، بهدف خلق قوى
										عاملة أكثر مهارة وتنافسية. كما تقدم المؤسسة خدمات التوجيه والتدريب
										الشخصي لدعم الأفراد في تحقيق أهدافهم الشخصية والمهنية.
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

					<div class="accordion_container" dir="ltr">
						<div class="accordion d-flex flex-row align-items-center active">
							<div>رسالتنا</div>
						</div>
						<div class="accordion_panel">
							<div>
								<p class="text-right" dir="ltr">
									رسالتنا هي تعزيز التعليم من خلال تحسين الأساليب والاستثمار في المواهب لتحقيق
									نتائج إيجابية. نسعى لتعزيز الثقافة الرقمية ورفع الوعي، وتحسين المناهج
									التعليمية من خلال تقديم الاستشارات والدراسات.
								</p>
							</div>
						</div>
					</div>

					<div class="accordion_container" dir="ltr">
						<div class="accordion d-flex flex-row align-items-center">
							<div>رؤيتنا</div>
						</div>
						<div class="accordion_panel">
							<div>
								<p class="text-right" dir="ltr">
									رؤيتنا هي خلق عالم يتمتع الجميع فيه بالحصول على تعليم ذو جودة عالية، مما
									يمكنهم من تحقيق إمكاناتهم الكاملة والمساهمة بشكل إيجابي في مجتمعاتهم.
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

<div class="courses">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">
						نشاطاتنا
					</h2>
				</div>
			</div>
		</div>

		<div class="row courses_row">

			<!-- Course -->
			<div class="col-lg-4 col-md-6">
				<div class="course">
					<div class="course_image"><img src="/assets/images/course_1.jpg" alt=""></div>
					<div class="course_body">
						<div class="course_header d-flex flex-row align-items-center justify-content-start">
							<div class="course_tag"><a href="#">Featured</a></div>
							<div class="course_price ml-auto">Price: <span>$35</span></div>
						</div>
						<div class="course_title text-right" dir="rtl">
							<h3><a href="programs">دورة وسائل الاعلام الاجتماعية</a></h3>
						</div>
						<div class="course_text text-right" dir="rtl">يتمثل وصف الدورة القصير في أنها دورة
							تدريبية تهدف إلى تحسين مهارات القيادة والتواصل والتفكير الإبداعي في بيئة العمل،
							وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل النتائج.</div>
							<div <?= $language == "ar" ? 'class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl"'
										: 'class="course_footer d-flex align-items-center justify-content-start"' ?>>
								<div class="course_author_image <?= $language == "ar" ? "ml-3" : "" ?>"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
								<div class="course_author_name"><?= $language == "ar" ? "المدرب:" : "Trainer:" ?> <a href="#">James S. Morrison</a></div>
								<div class="course_sales ml-auto">
									<a style="color:#fcb92c;" href="page-details">
										<?= $language == "ar" ? "اقرأ المزيد" : "Read More" ?>
									</a>
								</div>
							</div>
					</div>
				</div>
			</div>

			<!-- Course -->
			<div class="col-lg-4 col-md-6">
				<div class="course">
					<div class="course_image"><img src="/assets/images/course_1.jpg" alt=""></div>
					<div class="course_body">
						<div class="course_header d-flex flex-row align-items-center justify-content-start">
							<div class="course_tag"><a href="#">Featured</a></div>
							<div class="course_price ml-auto">Price: <span>$35</span></div>
						</div>
						<div class="course_title text-right" dir="rtl">
							<h3><a href="programs">دورة وسائل الاعلام الاجتماعية</a></h3>
						</div>
						<div class="course_text text-right" dir="rtl">يتمثل وصف الدورة القصير في أنها دورة
							تدريبية تهدف إلى تحسين مهارات القيادة والتواصل والتفكير الإبداعي في بيئة العمل،
							وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل النتائج.</div>
						<div class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
							<div class="course_author_image"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
							<div class="course_author_name">بواسطة <a href="#">James S. Morrison</a></div>
							<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>
						</div>
					</div>
				</div>
			</div>


			<!-- Course -->
			<div class="col-lg-4 col-md-6">
				<div class="course">
					<div class="course_image"><img src="/assets/images/course_1.jpg" alt=""></div>
					<div class="course_body">
						<div class="course_header d-flex flex-row align-items-center justify-content-start">
							<div class="course_tag"><a href="#">Featured</a></div>
							<div class="course_price ml-auto">Price: <span>$35</span></div>
						</div>
						<div class="course_title text-right" dir="rtl">
							<h3><a href="programs">دورة وسائل الاعلام الاجتماعية</a></h3>
						</div>
						<div class="course_text text-right" dir="rtl">يتمثل وصف الدورة القصير في أنها دورة
							تدريبية تهدف إلى تحسين مهارات القيادة والتواصل والتفكير الإبداعي في بيئة العمل،
							وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل النتائج.</div>
						<div class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
							<div class="course_author_image"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
							<div class="course_author_name">بواسطة <a href="#">James S. Morrison</a></div>
							<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>
						</div>
					</div>
				</div>
			</div>


			<!-- Course -->
			<div class="col-lg-4 col-md-6">
				<div class="course">
					<div class="course_image"><img src="/assets/images/course_1.jpg" alt=""></div>
					<div class="course_body">
						<div class="course_header d-flex flex-row align-items-center justify-content-start">
							<div class="course_tag"><a href="#">Featured</a></div>
							<div class="course_price ml-auto">Price: <span>$35</span></div>
						</div>
						<div class="course_title text-right" dir="rtl">
							<h3><a href="programs">دورة وسائل الاعلام الاجتماعية</a></h3>
						</div>
						<div class="course_text text-right" dir="rtl">يتمثل وصف الدورة القصير في أنها دورة
							تدريبية تهدف إلى تحسين مهارات القيادة والتواصل والتفكير الإبداعي في بيئة العمل،
							وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل النتائج.</div>
						<div class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
							<div class="course_author_image"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
							<div class="course_author_name">بواسطة <a href="#">James S. Morrison</a></div>
							<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>
						</div>
					</div>
				</div>
			</div>


			<!-- Course -->
			<div class="col-lg-4 col-md-6">
				<div class="course">
					<div class="course_image"><img src="/assets/images/course_1.jpg" alt=""></div>
					<div class="course_body">
						<div class="course_header d-flex flex-row align-items-center justify-content-start">
							<div class="course_tag"><a href="#">Featured</a></div>
							<div class="course_price ml-auto">Price: <span>$35</span></div>
						</div>
						<div class="course_title text-right" dir="rtl">
							<h3><a href="programs">دورة وسائل الاعلام الاجتماعية</a></h3>
						</div>
						<div class="course_text text-right" dir="rtl">يتمثل وصف الدورة القصير في أنها دورة
							تدريبية تهدف إلى تحسين مهارات القيادة والتواصل والتفكير الإبداعي في بيئة العمل،
							وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل النتائج.</div>
						<div class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
							<div class="course_author_image"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
							<div class="course_author_name">بواسطة <a href="#">James S. Morrison</a></div>
							<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>
						</div>
					</div>
				</div>
			</div>


			<!-- Course -->
			<div class="col-lg-4 col-md-6">
				<div class="course">
					<div class="course_image"><img src="/assets/images/course_1.jpg" alt=""></div>
					<div class="course_body">
						<div class="course_header d-flex flex-row align-items-center justify-content-start">
							<div class="course_tag"><a href="#">Featured</a></div>
							<div class="course_price ml-auto">Price: <span>$35</span></div>
						</div>
						<div class="course_title text-right" dir="rtl">
							<h3><a href="programs">دورة وسائل الاعلام الاجتماعية</a></h3>
						</div>
						<div class="course_text text-right" dir="rtl">يتمثل وصف الدورة القصير في أنها دورة
							تدريبية تهدف إلى تحسين مهارات القيادة والتواصل والتفكير الإبداعي في بيئة العمل،
							وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل النتائج.</div>
						<div class="course_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
							<div class="course_author_image"><img src="/assets/images/featured_author.jpg" alt="https://unsplash.com/@anthonytran"></div>
							<div class="course_author_name">بواسطة <a href="#">James S. Morrison</a></div>
							<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>
						</div>
					</div>
				</div>
			</div>


		</div>
		<div class="row" style="justify-content: center;">
			<div class="button home_button mt-3">
				<a href="events">أظهار المزيد
					<div class="button_arrow">
						<i class="fa fa-angle-right text-white" aria-hidden="true"></i>
					</div>
				</a>
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
					<div class="milestone_icon"><img src="/assets/images/milestone_1.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="1548">0</div>
					<div class="milestone_text">Online Courses</div>
				</div>
			</div>

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="/assets/images/milestone_2.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="7286">0</div>
					<div class="milestone_text">Students</div>
				</div>
			</div>

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="/assets/images/milestone_3.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="257">0</div>
					<div class="milestone_text">Teachers</div>
				</div>
			</div>

			<!-- Milestone -->
			<div class="col-lg-3 milestone_col">
				<div class="milestone text-center">
					<div class="milestone_icon"><img src="/assets/images/milestone_4.svg" alt=""></div>
					<div class="milestone_counter" data-end-value="39">0</div>
					<div class="milestone_text">Countries</div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Our Programs -->

<div class="courses">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">برامجنا</h2>
				</div>
			</div>
		</div>

		<!-- Featured Course -->
		<div class="row featured_row">
			<div class="col-lg-6 featured_col">
				<div class="featured_content">
					<div class="featured_header d-flex flex-row align-items-center justify-content-start">
						<div class="featured_tag"><a href="#">Featured</a></div>
						<div class="featured_price ml-auto">Price: <span>$35</span></div>
					</div>
					<div class="featured_title text-right" dir="rtl">
						<h3><a href="page-details">دورة وسائل الاعلام الاجتماعية</a></h3>
					</div>
					<div class="featured_text text-right" dir="rtl">
						يتمثل وصف الدورة القصير في أنها دورة تدريبية تهدف إلى تحسين مهارات القيادة والتواصل
						والتفكير الإبداعي في بيئة العمل، وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل
						النتائج.
					</div>
					<div class="featured_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
						<div class="featured_author_image"><img src="/assets/images/featured_author.jpg" alt=""></div>
						<div class="featured_author_name">بواسطة <a href="#">محمد محسن علي</a></div>
						<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>

					</div>
				</div>
			</div>
			<div class="col-lg-6 featured_col">
				<!-- Background image artist https://unsplash.com/@jtylernix -->
				<div class="featured_background" style="background-image:url(/assets/images/featured.jpg)"></div>
			</div>
		</div>
		<!-- Featured Course -->
		<div class="row featured_row">
			<div class="col-lg-6 featured_col">
				<!-- Background image artist https://unsplash.com/@jtylernix -->
				<div class="featured_background" style="background-image:url(/assets/images/featured.jpg)"></div>
			</div>
			<div class="col-lg-6 featured_col">
				<div class="featured_content">
					<div class="featured_header d-flex flex-row align-items-center justify-content-start">
						<div class="featured_tag"><a href="#">Featured</a></div>
						<div class="featured_price ml-auto">Price: <span>$35</span></div>
					</div>
					<div class="featured_title text-right" dir="rtl">
						<h3><a href="page-details">دورة وسائل الاعلام الاجتماعية</a></h3>
					</div>
					<div class="featured_text text-right" dir="rtl">
						يتمثل وصف الدورة القصير في أنها دورة تدريبية تهدف إلى تحسين مهارات القيادة والتواصل
						والتفكير الإبداعي في بيئة العمل، وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل
						النتائج.
					</div>
					<div class="featured_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
						<div class="featured_author_image"><img src="/assets/images/featured_author.jpg" alt=""></div>
						<div class="featured_author_name">بواسطة <a href="#">محمد محسن علي</a></div>
						<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>

					</div>
				</div>
			</div>
		</div>
		<!-- Featured Course -->
		<div class="row featured_row">
			<div class="col-lg-6 featured_col">
				<div class="featured_content">
					<div class="featured_header d-flex flex-row align-items-center justify-content-start">
						<div class="featured_tag"><a href="#">Featured</a></div>
						<div class="featured_price ml-auto">Price: <span>$35</span></div>
					</div>
					<div class="featured_title text-right" dir="rtl">
						<h3><a href="page-details">دورة وسائل الاعلام الاجتماعية</a></h3>
					</div>
					<div class="featured_text text-right" dir="rtl">
						يتمثل وصف الدورة القصير في أنها دورة تدريبية تهدف إلى تحسين مهارات القيادة والتواصل
						والتفكير الإبداعي في بيئة العمل، وتعتمد على تطبيقات عملية وأساليب تفاعلية لتحقيق أفضل
						النتائج.
					</div>
					<div class="featured_footer d-flex align-items-center justify-content-start text-right" dir="rtl">
						<div class="featured_author_image"><img src="/assets/images/featured_author.jpg" alt=""></div>
						<div class="featured_author_name">بواسطة <a href="#">محمد محسن علي</a></div>
						<div class="course_sales ml-auto"><a style="color:#fcb92c;" href="page-details">اقرأ المزيد</a></div>

					</div>
				</div>
			</div>
			<div class="col-lg-6 featured_col">
				<!-- Background image artist https://unsplash.com/@jtylernix -->
				<div class="featured_background" style="background-image:url(/assets/images/featured.jpg)"></div>
			</div>
		</div>
		<div class="my-5"></div>
		<div class="row mt-4" style="justify-content: center;">
			<div class="button home_button mt-3">
				<a href="programs">عرض المزيد
					<div class="button_arrow">
						<i class="fa fa-angle-right text-white" aria-hidden="true"></i>
					</div>
				</a>
			</div>

		</div>
	</div>
</div>

<!-- Members -->

<div class="teachers">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">الاعضاء</h2>
				</div>
			</div>
		</div>
		<div class="row teachers_row">

			<!-- Teacher -->
			<div class="col-lg-4 col-md-6">
				<div class="teacher">
					<div class="teacher_image"><img src="/assets/images/teacher_1.jpg" alt="https://unsplash.com/@nickkarvounis"></div>
					<div class="teacher_body text-center">
						<div class="teacher_title"><a href="#">اسم الشخص الثلاثي</a></div>
						<div class="teacher_subtitle">التخصص</div>
						<div class="teacher_social">
							<ul>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Teacher -->
			<div class="col-lg-4 col-md-6">
				<div class="teacher">
					<div class="teacher_image"><img src="/assets/images/teacher_2.jpg" alt="https://unsplash.com/@rawpixel"></div>
					<div class="teacher_body text-center">
						<div class="teacher_title"><a href="#">اسم الشخص الثلاثي</a></div>
						<div class="teacher_subtitle">التخصص</div>
						<div class="teacher_social">
							<ul>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Teacher -->
			<div class="col-lg-4 col-md-6">
				<div class="teacher">
					<div class="teacher_image"><img src="/assets/images/teacher_3.jpg" alt="https://unsplash.com/@taylor_grote"></div>
					<div class="teacher_body text-center">
						<div class="teacher_title"><a href="#">اسم الشخص الثلاثي</a></div>
						<div class="teacher_subtitle">التخصص</div>
						<div class="teacher_social">
							<ul>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Teacher -->
			<div class="col-lg-4 col-md-6">
				<div class="teacher">
					<div class="teacher_image"><img src="/assets/images/teacher_4.jpg" alt="https://unsplash.com/@benjaminrobyn"></div>
					<div class="teacher_body text-center">
						<div class="teacher_title"><a href="#">اسم الشخص الثلاثي</a></div>
						<div class="teacher_subtitle">التخصص</div>
						<div class="teacher_social">
							<ul>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Teacher -->
			<div class="col-lg-4 col-md-6">
				<div class="teacher">
					<div class="teacher_image"><img src="/assets/images/teacher_5.jpg" alt="https://unsplash.com/@christinhumephoto"></div>
					<div class="teacher_body text-center">
						<div class="teacher_title"><a href="#">اسم الشخص الثلاثي</a></div>
						<div class="teacher_subtitle">التخصص</div>
						<div class="teacher_social">
							<ul>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- Teacher -->
			<div class="col-lg-4 col-md-6">
				<div class="teacher">
					<div class="teacher_image"><img src="/assets/images/teacher_6.jpg" alt="https://unsplash.com/@rawpixel"></div>
					<div class="teacher_body text-center">
						<div class="teacher_title"><a href="#">اسم الشخص الثلاثي</a></div>
						<div class="teacher_subtitle">التخصص</div>
						<div class="teacher_social">
							<ul>
								<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col text-center">
				<div class="button teachers_button"><a href="members">عرض كل الاعضاء<div class="button_arrow"><i class="fa fa-angle-right text-white" aria-hidden="true"></i>
						</div></a></div>
			</div>
		</div>
	</div>
</div>


<!-- Success Story -->

<div class="video">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">قصة نجاح</h2>
					<div class="pt-4 mt-4" dir="rtl">
						نادية علي هي رئيسة قسم تقنيات أنظمة الحاسوب في جامعة البصرة في العراق، ومؤسسة نوادي
						البرمجة في العراق، وهي منظمة تدريبية تعلم الشباب البرمجة. تعتبر نادية علي مناصرة متحمسة
						لتعليم البرمجة وتعتقد أن الجميع يجب أن يحصل على فرصة لتعلم البرمجة. إنها مصدر إلهام
						للعديد من الشباب في العراق وحول العالم.
						<br>
						وهنا مقتطف من كلمات نادية علي من المقال:
						<br>
						"أعتقد أن البرمجة هي أداة قوية يمكن أن تساعد الشباب على التعلم والنمو. يمكن أن تساعدهم
						على تطوير مهارات حل المشكلات والإبداع والثقة بالنفس. أنا متحمسة لجعل تعليم البرمجة أكثر
						إمكانية للشباب في العراق، وأنا ممتنة لدعم نادي البرمجة في هذا المسعى."
					</div>
				</div>
			</div>
		</div>
		<div class="featured_row">
			<div class="col">
				<div class="video_container_outer">
					<div class="video_container">
						<!-- Video poster image artist: https://unsplash.com/@annademy -->
						<video id="vid1" class="video-js vjs-default-skin" controls data-setup='{ "poster": "/assets/images/video.jpg", "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://youtu.be/5_MRXyYjHDk"}], "youtube": { "iv_load_policy": 1 } }'>
						</video>
					</div>
				</div>
			</div>
		</div>

		<div class="row p-4">
			<div class="col text-center">
				<div class="button teachers_button"><a href="success_story">شاهد كل قصص النجاح<div class="button_arrow"><i class="fa fa-angle-right text-white" aria-hidden="true"></i>
						</div></a></div>
			</div>
		</div>
	</div>
</div>


<!-- Contact -->

<div class="contact mt-4 pt-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="section_title text-center">
					<h2 class="font-bold font-weight-bold pb-2 border border-left-0 border-right-0 border-top-0 border-warning border-2" style="color:#fcb92c;">تواصل معنا</h2>
				</div>
			</div>
		</div>
		<div class="row row-xl-eq-height mt-4 pt-4" dir="rtl">
			<!-- Contact Content -->
			<div class="col-xl-6">
				<div class="contact_content" style="padding-top:0px">
					<div class="contact_form_container">
						<form action="#" id="contact_form" class="contact_form">
							<div>
								<div class="row">
									<div class="col-lg-6 contact_name_col">
										<input type="text" class="contact_input pr-2" placeholder="الاسم" required="required">
									</div>
									<div class="col-lg-6">
										<input type="email" class="contact_input pr-2" placeholder="البريد الالكتروني" required="required">
									</div>
								</div>
							</div>
							<div><input type="text" class="contact_input pr-2" placeholder="الموضوع" required="required"></div>
							<div><textarea class="contact_input contact_textarea pr-2" placeholder="الرسالة"></textarea></div>
							<div class="button teachers_button"><a href="#">ارسال..<div class="button_arrow"><i class="fa fa-angle-right text-white" aria-hidden="true"></i></div>
								</a></div>
						</form>
					</div>
				</div>
			</div>

			<!-- Contact Map -->
			<div class="col-xl-6 map_col">
				<div class="contact_map pl-4">

					<!-- Google Map -->
					<div id="google_map" class="google_map text-center">
						<div class="map_container">
							<div id='map' width="100%">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d211.86856419785303!2d47.153726436898324!3d31.82779713386888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fe7eb81f5b4a317%3A0x351e6cd155d75e70!2z2YXZhti42YXYqSDYp9mE2YjYsdmC2Kkg2YTYqti32YjZitixINin2YTZhdmH2KfYsdin2Ko!5e0!3m2!1sar!2siq!4v1683967251034!5m2!1sar!2siq&z=50" width="100%" height="95%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
								</iframe>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>