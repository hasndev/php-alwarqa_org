<!DOCTYPE html>
<html lang="en">

<head>
    <title>AlWarqa Organization</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="AlWarqa Organization for Skills Development is an independent non-profit, non-governmental organization registered in Iraq, whose main goal is to develop digital and life skills for youth and children. It aims to enhance the role of teachers in schools and introduce digital learning curricula in Iraqi schools. READ MORE">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/assets/styles/bootstrap4/bootstrap.min.css">
    <link href="/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="/assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/OwlCarousel2-2.2.1/animate.css">
    <link href="/assets/plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/responsive.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/courses.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/courses_responsive.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/about.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/about_responsive.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/contact.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/contact_responsive.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/news.css">
    <link rel="stylesheet" type="text/css" href="/assets/styles/news_responsive.css">


    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-x3u/yoA/Gsy4OPIeaWTZ0zx4DBLAfz21YYLqq5p6OwIgEdXq24THvA02HJS9mC+6" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <?php
    if ($language == "ar") {
    ?>
        <style>
            @font-face {
                font-family: 'AlJazeera';
                src: url('/assets/fonts/Al-Jazeera-Arabic-Regular.ttf') format('woff2'),
                    /* Modern Browsers */
                    url('/assets/fonts/Al-Jazeera-Arabic-Bold.ttf') format('woff'),
                    /* Modern Browsers */
                    url('/assets/fonts/Al-Jazeera-Arabic-Light.ttf') format('woff');
                /* Older Browsers */
                font-weight: normal;
                font-style: normal;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: 'AlJazeera', sans-serif !important;

            }

            body {
                font-family: 'AlJazeera', sans-serif !important;
            }
        </style>
    <?php
    }
    ?>
</head>


</head>

<body>
    <div class="super_container">

        <!-- Header -->
        <header class="header">
            <!-- Top Bar -->
            <div class="top_bar">
                <div class="top_bar_container">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="top_bar_content d-flex flex-row align-items-center justify-content-start <?= $language == "ar" ? "text-center" : "" ?>">
                                    <ul class="top_bar_contact_list">
                                        <?php
                                        #
                                        ##
                                        ### Get Settings
                                        $q = 'SELECT `email`, `phone`, `map_link` FROM `settings` where `id`=1';
                                        $settings = getData($con, $q);
                                        $email = $settings[0]['email'];
                                        $phone = $settings[0]['phone'];
                                        $map_link = $settings[0]['map_link'];
                                        if ($language != "ar") {
                                            echo '<li>
                                                      <div class="question">Have any questions?</div>
                                                  </li>
                                                  ';
                                        }
                                        ?>

                                        <li>
                                            <div><?= $phone ?></div>
                                        </li>
                                        <li>
                                            <div><?= $email ?></div>
                                        </li>
                                        <?php
                                        if ($language == "ar") {
                                            echo '<li>
                                                    <div class="question" dir="rtl">تواصل معنا في حال كانت لديك اي اسئلة.</div>
                                                  </li>
                                            ';
                                        }
                                        ?>
                                    </ul>
                                    <div class="top_bar_login ml-auto <?= $language == "ar" ? "items-center justify-center" : "" ?>">
                                        <ul>
                                            <li><a href="/en/<?= $cat_id . "/" . $sub_cat . "/" . $slag ?>">En <img src="/assets/images/flag/us.png" alt="English Flag" height="15px"></a></li>
                                            <li><a href="/ar/<?= $cat_id . "/" . $sub_cat . "/" . $slag ?>">ع <img src="/assets/images/flag/iraq.png" alt="Iraqi Flag" height="15px"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Content -->
            <div class="header_container">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="header_content d-flex flex-row align-items-center justify-content-start">
                                <div class="logo_container">
                                    <a href="#">
                                        <div class="logo_content d-flex flex-row align-items-end justify-content-start">
                                            <div class="logo_img"><img src="/assets/images/logo.png" height="50px" alt=""></div>
                                        </div>
                                    </a>
                                </div>
                                <nav class="main_nav_contaner ml-auto">
                                    <ul class="main_nav">
                                        <li <?= ($cat_id == 'home') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?></a></li>
                                        <li <?= ($cat_id == 'programs') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/programs"><?= $language == "ar" ? "برامجنا" : "Programs" ?></a></li>
                                        <li <?= ($cat_id == 'events') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/events"><?= $language == "ar" ? "نشاطاتنا" : "Events" ?></a></li>
                                        <li <?= ($cat_id == 'gallery') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/gallery"><?= $language == "ar" ? "معرض الصور" : "Gallery" ?></a></li>
                                        <li <?= ($cat_id == 'success_story') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/success_story"><?= $language == "ar" ? "قصص النجاح" : "success Stories" ?></a></li>
                                        <li <?= ($cat_id == 'members') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/members"><?= $language == "ar" ? "الاعضاء" : "Members" ?></a></li>
                                        <li <?= ($cat_id == 'about') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/about"><?= $language == "ar" ? "عنا" : "About us" ?></a></li>
                                        <li <?= ($cat_id == 'contact') ? 'class="active"' : '' ?>><a href="/<?= $language ?>/contact"><?= $language == "ar" ? "تواصل معنا" : "Contact us" ?></a></li>
                                    </ul>
                                    <!-- Hamburger -->

                                    <div class="hamburger menu_mm">
                                        <i class="fa fa-bars menu_mm" aria-hidden="true"></i>
                                    </div>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>

        <!-- Menu -->

        <div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
            <div class="menu_close_container">
                <div class="menu_close">
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="search" style="margin-bottom: 10px;">
                <h4><?= $language == "ar" ? "القائمة" : "Menu" ?></h4>
                <hr>
            </div>
            <nav class="menu_nav">
                <ul class="menu_mm">
                    <li class="menu_mm"><a href="/<?= $language ?>/home"><?= $language == "ar" ? "الصفحة الرئيسية" : "Home" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/programs"><?= $language == "ar" ? "برامجنا" : "Programs" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/events"><?= $language == "ar" ? "نشاطاتنا" : "Events" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/gallery"><?= $language == "ar" ? "معرض الصور" : "Gallery" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/success_story"><?= $language == "ar" ? "قصص النجاح" : "success Stories" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/members"><?= $language == "ar" ? "الاعضاء" : "Members" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/about"><?= $language == "ar" ? "عنا" : "About us" ?></a></li>
                    <li class="menu_mm"><a href="/<?= $language ?>/contact"><?= $language == "ar" ? "تواصل معنا" : "Contact us" ?></a></li>
                </ul>
                <div class="top_bar_login ml-auto">
                    <ul>
                        <li><a href="/en/<?= (!empty($cat_id) ? ($cat_id . "/") : '') . (!empty($sub_cat) ? ($sub_cat . "/") : '') . (!empty($slag) ? $slag : '') ?>">En <img src="/assets/images/flag/us.png" alt="English Flag" height="15px"></a></li>
                        <li><a href="/ar/<?= (!empty($cat_id) ? ($cat_id . "/") : '') . (!empty($sub_cat) ? ($sub_cat . "/") : '') . (!empty($slag) ? $slag : '') ?>">ع <img src="/assets/images/flag/iraq.png" alt="Iraqi Flag" height="15px"></a></li>
                    </ul>
                </div>
            </nav>
            <div class="menu_extra">
                <div class="menu_phone"><span class="menu_title">phone:</span>+964 782 227 8550</div>
                <div class="menu_social">
                    <span class="menu_title">follow us</span>
                    <ul>
                        <?php
                        $q = 'SELECT `id`,`name`, `icon`, `link`, `status`
                      FROM `social_media` Order by id DESC';
                        $D = getData($con, $q);
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