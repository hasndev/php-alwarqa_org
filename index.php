<?php
$url = [];
function sanitizeUrl($url)
{
    // Remove any characters that are not allowed in a URL
    $url = preg_replace('/[^a-zA-Z0-9_\-\p{Arabic}\/]+/', '', $url);
    // Remove trailing slashes
    $url = rtrim($url, '/');
    // Explode the sanitized URL
    $url = explode('/', $url);
    return $url;
}
#
function getUrl()
{
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
        $url = sanitizeUrl($url);
        return $url;
    }
}

$url = getUrl();

include(__DIR__ . "/db.php");

$language = isset($url[0]) ? $url[0] : "ar"; // Default language is "ar"
$cat_id = isset($url[1]) ? $url[1] : "home"; // Default category is "home"
$sub_cat = isset($url[2]) ? $url[2] : "";
$slag = isset($url[3]) ? $url[3] : "";
 
include(__DIR__ . "/function.php");

if ($cat_id == "logout") {
	include(__DIR__ . "/cp/logout.php");
}

// Dashboard Management
if (isset($url[0]) && "cp" == $url[0]) {
	$cat_id = isset($url[1]) ? $url[1] : ""; //dashboard
	$sub_cat = isset($url[2]) ? $url[2] : ""; //index-file
	$opr_type = isset($url[3]) ? $url[3] : ""; //Operating Type
	$id = isset($url[4]) ? filter_var($url[4], FILTER_SANITIZE_NUMBER_INT) : ""; //id



	if ($cat_id == "login") {
		include(__DIR__ . "/cp/login.php");
	} elseif (!isset($_SESSION['is_login'])) {
		echo '<script>location.replace("/cp/login")</script>';
	} elseif ("" == $cat_id) {
		echo '<script>location.replace("/cp/login")</script>';
	} elseif ("change_password" == $cat_id) {
		include(__DIR__ . "/cp/change_password.php");
	} else {
		include(__DIR__ . "/cp/dashboard/header.php");
		if (file_exists(__DIR__ . "/cp/dashboard/$sub_cat.php")) {
			include(__DIR__ . "/cp/dashboard/$sub_cat.php");
		} else {
			echo '<script>location.replace("/404.html")</script>';
		}
		include(__DIR__ . "/cp/dashboard/footer.php");
	}
	// Website
} else {
	######################

	include(__DIR__ . "/template/header.php");
	#
	if (file_exists(__DIR__ . "/$cat_id.php"))
		include(__DIR__ . "/$cat_id.php");
	#
	include(__DIR__ . "/template/footer.php");
	######################
}
