<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>AlWarqa Organization Dashboard</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="/cp/assets/css/simplebar.css">
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="/cp/assets/css/feather.css">
    <link rel="stylesheet" href="/cp/assets/css/select2.css">
    <link rel="stylesheet" href="/cp/assets/css/dropzone.css">
    <link rel="stylesheet" href="/cp/assets/css/uppy.min.css">
    <link rel="stylesheet" href="/cp/assets/css/jquery.steps.css">
    <link rel="stylesheet" href="/cp/assets/css/jquery.timepicker.css">
    <link rel="stylesheet" href="/cp/assets/css/quill.snow.css">
    <link rel="stylesheet" href="/cp/assets/css/dataTables.bootstrap4.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="/cp/assets/css/daterangepicker.css">
    <!-- summernote -->
    <link href="/cp/assets/vendor/summernote/summernote-bs4.min.css" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-x3u/yoA/Gsy4OPIeaWTZ0zx4DBLAfz21YYLqq5p6OwIgEdXq24THvA02HJS9mC+6" crossorigin="anonymous">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- App CSS -->
    <link rel="stylesheet" href="/cp/assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="/cp/assets/css/app-dark.css" id="darkTheme" disabled>
    <style>
        a,
        a:hover {
            text-decoration-line: none;
        }
    </style>
</head>

<body class="vertical light rtl ">
    <div class="wrapper">
        <nav class="topnav navbar navbar-light">
            <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <i class="fe fe-menu navbar-toggler-icon"></i>
            </button>
            <form class="form-inline mr-auto searchform text-muted">
                <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
            </form>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                        <i class="fe fe-sun fe-16"></i>
                    </a>
                </li>
                <li class="nav-item nav-notif">
                    <a class="nav-link text-muted my-2" href="..#" data-toggle="modal" data-target=".modal-notif">
                        <span class="fe fe-bell fe-16"></span>
                        <span class="dot dot-md bg-success"></span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm mt-2">
                            <img src="<?php echo userLogo($con, $_SESSION['user_id']); ?>" alt="..." class="avatar-img rounded-circle">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right text-right" dir="rtl" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item">
                            <span class="avatar avatar-sm mt-2">
                                <img src="<?php echo userLogo($con, $_SESSION['user_id']); ?>" alt="..." class="avatar-img rounded-circle">
                            </span>
                            <span class="font-bold text-primary"><?= $_SESSION['uname'] ?></span>
                        </a>
                        <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/profile"><i class="fe fe-user"></i> الملف الشخصي</a>
                        <a class="dropdown-item" style="text-align: right;" href="/cp/dashboard/settings"><i class="fe fe-settings"></i> الاعدادت</a>
                        <a class="dropdown-item" style="text-align: right;" href="/cp/change_password"><i class="fe fe-key"></i> تغير كلمة المرور</a>
                        <a class="dropdown-item" style="text-align: right;" href="/cp/logout"><i class="fe fe-log-out"></i> تسجيل الخروج</a>
                    </div>
                </li>
            </ul>
        </nav>
        <?php
        #array For Pages
        $pages = [];
        $pages[] = [
            "title" => "اللوحة الرئيسية",
            "icon" => "fe fe-home",
            "pages" => ["main"],
            "slag" => "main",
            "lvl" => [$_SESSION['lvl']]
        ];
        $pages[] = [
            "title" => "الاصناف",
            "icon" => "fa fa-list-ul",
            "pages" => ["categories"],
            "slag" => "categories",
            "lvl" => [substr($_SESSION['permission'], 1, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "البرامج",
            "icon" => "fe fe-layers",
            "pages" => ["programs", "programs"],
            "slag" => "programs",
            "lvl" => [substr($_SESSION['permission'], 5, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "النشاطات",
            "icon" => "fa fa-bullhorn",
            "pages" => ["blogs"],
            "slag" => "blogs",
            "lvl" => [substr($_SESSION['permission'], 10, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "المعرض",
            "icon" => "fa fa-camera",
            "pages" => ["gallery"],
            "slag" => "gallery",
            "lvl" => [substr($_SESSION['permission'], 15, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "قصص النجاح",
            "icon" => "fa fa-trophy",
            "pages" => ["stories"],
            "slag" => "stories",
            "lvl" => [substr($_SESSION['permission'], 20, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        // $pages[] = [
        //   "title" => "Online shop",
        //   "icon" => "fe fe-layers",
        //   "pages" => ["online_shop", "online_shop_item", "online_shop_category"],
        //   "slag" => "online_shop",
        //   "lvl" => [substr($_SESSION['permission'], 30, 1) == 1 ? $_SESSION['lvl'] : ""]
        // ];
        $pages[] = [
            "title" => "الاعضاء",
            "icon" => "fe fe-users",
            "pages" => ["members"],
            "slag" => "members",
            "lvl" => [substr($_SESSION['permission'], 30, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "المراسلات",
            "icon" => "fa fa-envelope",
            "pages" => ["contacts"],
            "slag" => "contacts",
            "lvl" => [substr($_SESSION['permission'], 40, 1) == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "الحسابات",
            "icon" => "fe fe-users",
            "pages" => ["accounts"],
            "slag" => "accounts",
            "lvl" => [$_SESSION['lvl'] == 1 ? $_SESSION['lvl'] : ""]
        ];
        $pages[] = [
            "title" => "ملفي الشخص",
            "icon" => "fe fe-user",
            "pages" => ["profile"],
            "slag" => "profile",
            "lvl" => [$_SESSION['lvl']]
        ];
        $pages[] = [
            "title" => "الاعدادات",
            "icon" => "fe fe-settings",
            "pages" => ["settings", "social_media"],
            "slag" => "settings",
            "lvl" => [$_SESSION['lvl'] == 1 ? $_SESSION['lvl'] : ""]
        ];
        //<i class="fe fe-calendar"></i>
        ?>
        <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
            <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <nav class="vertnav navbar navbar-light">
                <!-- nav bar -->
                <div class="w-100 mb-4 d-flex">
                    <a class="navbar-brand mx-auto my-2 flex-fill text-center rtl" href="/cp/dashboard/main">
                        <img src="/assets/images/logo.png" style="height: 70px; width:70px;" alt="Hassan Jabbar Template">
                    </a>
                </div>

                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <?php
                    foreach ($pages as $s) {
                        if (in_array($_SESSION['lvl'], $s['lvl'])) {
                            $isActive = (in_array($sub_cat, $s['pages'])) ? " active " : "";
                    ?>
                            <li class="nav-item w-100<?= $isActive ?>">
                                <a href="/cp/dashboard/<?= $s["slag"] ?>" class="nav-link">
                                    <i class="fe-16 <?= $s["icon"] ?>"></i>
                                    <span class="ml-3 item-text"><?= $s["title"] ?></span>
                                </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>

            </nav>
        </aside>
        <main role="main" class="main-content">