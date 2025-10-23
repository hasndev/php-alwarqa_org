<!-- Partnerships -->

<!-- <div class="py-3 mt-4 pt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto d-flex flex-wrap flex-sm-row flex-column justify-content-center align-items-center">
                <img src="/assets/images/partnerships/Harvard-University-Main-Logo.png" alt="Partner Logo 1" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/rasberry-pi-logo.png" alt="Partner Logo 2" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/thesippariq.png" alt="Partner Logo 3" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/Harvard-University-Main-Logo.png" alt="Partner Logo 1" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/rasberry-pi-logo.png" alt="Partner Logo 2" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/thesippariq.png" alt="Partner Logo 3" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/Harvard-University-Main-Logo.png" alt="Partner Logo 1" class="img-fluid mx-3 my-2" style="max-height: 50px;">
                <img src="/assets/images/partnerships/rasberry-pi-logo.png" alt="Partner Logo 2" class="img-fluid mx-3 my-2" style="max-height: 50px;">
            </div>
        </div>
    </div>
</div> -->

<!-- Client 1 - HCF Bootstrap 5 Component -->
<section class="py-3 py-xl-6 mt-4">
    <div class="container overflow-hidden">
        <div class="row gy-3 gy-md-6">
            <div class="col-lg-2 col-md-4 align-self-center text-center">
                <img src="/assets/images/partnerships/rasberry-pi-logo.png" alt="Partner Logo 2" class="img-fluid mx-3 my-2" style="max-height: 50px;">
            </div>
            <div class="col-lg-2 col-md-4 align-self-center text-center">
                <img src="/assets/images/partnerships/thesippariq.png" alt="Partner Logo 3" class="img-fluid mx-3 my-2" style="max-height: 50px;">
            </div>
            <div class="col-lg-2 col-md-4 align-self-center text-center">
                <img src="/assets/images/partnerships/rasberry-pi-logo.png" alt="Partner Logo 3" class="img-fluid mx-3 my-2" style="max-height: 50px;">
            </div>
            <div class="col-lg-2 col-md-4 align-self-center text-center">
                <img src="/assets/images/partnerships/thesippariq.png" alt="Partner Logo 1" class="img-fluid mx-3 my-2" style="max-height: 50px;">
            </div>
        </div>
    </div>
</section>


<!-- Footer -->

<footer <?= $language == "ar" ? ' class="footer text-right" dir="rtl"' : 'class="footer"' ?>>
    <div class="container">
        <div class="row">

            <!-- About -->
            <div class="col-lg-3 footer_col">
                <div class="footer_about">
                    <div <?= $language == "ar" ? 'class="logo_container-ar"' : 'class="logo_container"' ?>>
                        <a href="#">
                            <div class="logo_content d-flex flex-row align-items-end justify-content-start">
                                <div class="logo_img"><img src="/assets/images/logo.png" alt=""></div>

                            </div>
                        </a>
                    </div><br>
                    <div class="footer_about_text">
                        <p>
                            <?= $language == "ar" ? ' تعمل منظمة الورقة على تنمية المهارات العملية للشباب
                            من خلال التدريب وورش العمل، مع التركيز على القيادة والاتصال وحل المشكلات
                            وريادة الأعمال لخلق قوى عاملة مهرة.' : 'AlWarqa Organization develops practical skills in youth through training and
                            workshops, focusing on leadership, communication, problem-solving, and
                            entrepreneurship to create a more skilled workforce.' ?>
                        </p>
                    </div>
                    <div class="footer_social" <?= $language == "ar" ? 'dir="ltr"' : '' ?>>
                        <ul>
                            <?php
                            $q = 'SELECT `icon`, `link`
                            FROM `social_media` WHERE `status`=? Order by id DESC';
                            $D = getData($con, $q, [1]);
                            foreach ($D as $row) {
                            ?>
                                <li><a target="_blank" href="<?= $row['link'] ?>"><?= $row['icon'] ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 footer_col">
                <div class="footer_links">
                    <div class="footer_title"><?= $language == "ar" ? 'روابط سريعة' : 'Quick menu' ?></div>
                    <ul class="footer_list">
                        <li><a href="/<?= $language ?>/home"><?= $language == "ar" ? 'الصفحة الرئيسية' : 'Home' ?></a>
                        </li>
                        <li><a href="/<?= $language ?>/about"><?= $language == "ar" ? 'عنا' : 'About us' ?></a></li>
                        <li><a href="/<?= $language ?>/members"><?= $language == "ar" ? 'الاعضاء' : 'Members' ?></a>
                        </li>
                        <li><a href="/<?= $language ?>/contact"><?= $language == "ar" ? 'تواصل معنا' : 'Contact us' ?></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 footer_col">
                <div class="footer_links">
                    <div class="footer_title"><?= $language == "ar" ? 'روابط مفيدة' : 'Useful Links' ?></div>
                    <ul class="footer_list">
                        <li><a href="/<?= $language ?>/events"><?= $language == "ar" ? 'نشاطاتنا' : 'Events' ?></a></li>
                        <li><a href="/<?= $language ?>/programs"><?= $language == "ar" ? 'برامجنا' : 'Programs' ?></a>
                        </li>
                        <li><a href="/<?= $language ?>/gallery"><?= $language == "ar" ? 'معرض الصور' : 'Gallery' ?></a>
                        </li>
                        <li><a href="/<?= $language ?>/success_story"><?= $language == "ar" ? 'قصص النجاح' : 'Success Stories' ?></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 footer_col">
                <div class="footer_contact">
                    <div class="footer_title"><?= $language == "ar" ? 'تواصل معنا' : 'Contact Us' ?></div>
                    <div <?= $language == "ar" ? 'class="footer_contact_info-ar text-right" style=" margin-top: 20px;" dir="rtl"' : 'class="footer_contact_info"' ?>>
                        <div class="footer_contact_item">
                            <div class="footer_contact_title"><?= $language == "ar" ? 'العنوان' : 'Address' ?>:</div>
                            <div class="footer_contact_line">
                                <?= $language == "ar" ? 'العراق - ميسان, العمارة' : 'Iraq - Maysan, Amarah' ?></div>
                        </div>
                        <div class="footer_contact_item">
                            <div class="footer_contact_title"><?= $language == "ar" ? 'رقم الهاتف' : 'Phone' ?>:</div>
                            <div class="footer_contact_line" dir="ltr"><?= $phone ?></div>
                        </div>
                        <div class="footer_contact_item">
                            <div class="footer_contact_title"><?= $language == "ar" ? 'البريد الالكتروني' : 'Email' ?>:
                            </div>
                            <div class="footer_contact_line"><?= $email ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <div class="copyright">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved To <a href="/home">Al
                        Waraqah Organization for
                        Skills Development</a>
                </div>

            </div>
        </div>
    </div>
</footer>
</div>

<script src="/assets/js/jquery-3.2.1.min.js"></script>
<script src="/assets/styles/bootstrap4/popper.js"></script>
<script src="/assets/styles/bootstrap4/bootstrap.min.js"></script>
<script src="/assets/plugins/greensock/TweenMax.min.js"></script>
<script src="/assets/plugins/greensock/TimelineMax.min.js"></script>
<script src="/assets/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="/assets/plugins/greensock/animation.gsap.min.js"></script>
<script src="/assets/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="/assets/plugins/easing/easing.js"></script>
<script src="/assets/plugins/video-js/video.min.js"></script>
<script src="/assets/plugins/video-js/Youtube.min.js"></script>
<script src="/assets/plugins/parallax-js-master/parallax.min.js"></script>
<script src="/assets/js/custom.js"></script>
<script src="/assets/js/theme.js"></script>
<script src="/assets/js/contact.js"></script>
<script>
    $(document).ready(function() {
        $(".customer-logos").slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });
    });
</script>
<!-- Google reCaptcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>


<?php
#Add and Update News
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact'])) {
    $err = "";
    #
    ##
    ###Check Input Vilidation
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $err = "Please Enter The Name";
    }
    #
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $err = "Please Enter The Email";
    }
    #
    if (!isset($_POST['subject']) || empty($_POST['subject'])) {
        $err = "Please Enter The Subject";
    }
    #
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

        // Google secret API
        $secretAPIkey = '6LfYeLYlAAAAAGwujIL0jHvUFYMzNkepl05PGxDa';

        // reCAPTCHA response verification
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretAPIkey . '&response=' . $_POST['g-recaptcha-response']);

        // Decode JSON data
        $response = json_decode($verifyResponse);
        if ($response->success) {
            if (empty($err)) {
                #
                $toMail = "hassanjabbaralfaraji@gmail.com";
                $header = "From: " . $name . "<" . $email . ">\r\n";
                // mail($toMail, $subject, $message, $header);
                #
                $q = 'INSERT INTO `contact`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)';
                $d = setData($con, $q, [$_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']]);
                $title = ($language == "ar" ? "ابقى على تواصل معنا" : "Get In Touch");
                if ($d > 0) {
                    echo "<script>swal('" . $title . "', ' " . ($language == "ar" ? "تم إرسال الرسالة بنجاح" : "Sent Message Successfully") . "', 'success').then((value) => {location.replace('/" . $language . "/home');});</script>";
                } else {
                    echo "<script>swal('" . $title . "', '" . ($language == "ar" ? "حدث خطأ ما أثناء الإضافة" : "Something Went Wrong With Adding") . "', 'error');</script>";
                }
            } else {
                echo "<script>swal('" . $title . "', '" . $err . "', 'error');</script>";
            }
        } else {
            echo "<script>swal('" . $title . "', '" . ($language == "ar" ? "فشل التحقق من الروبوت، يرجى المحاولة مرة أخرى." : "Robot verification failed, please try again.") . "', 'error');</script>";
        }
    } else {
        echo "<script>swal('" . $title . "', '" . ($language == "ar" ? "يرجى التحقق من مربع reCAPTCHA." : "Please check on the reCAPTCHA box.") . "', 'error');</script>";
    }
}

?>