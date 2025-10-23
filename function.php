<?php
#
##
### My Fumction
//Print Array
function vd($d)
{
    echo "<pre>";
    print_r($d);
    echo "</pre>";
    die;
}
#
function getUTS($time)
{
    return date("Y-M-d", $time);
}
#
// Get Picture Name
function selectItem($con, $table, $column, $id)
{
    $result = getData($con, 'SELECT ' . $column . ' FROM `' . $table . '` WHERE `id`=?', [$id]);
    if (!empty($result) && isset($result[0][$column])) {
        return $result[0][$column];
    } else {
        return null;
    }
}
#
//Select User Logo 
function userLogo($con, $user_id)
{
    $q = "SELECT `pic` FROM `users` WHERE id=?";
    $d = getData($con, $q, [$user_id]);
    if (count($d) > 0) {
        return "/cp/assets/images/avatars/" . $d[0]['pic'];
    }
}
#
//Move Uploaded Picture & Return File Name
function moveFile($file, $folder, $ext, $inc = 0)
{
    $time = intval(time()) + $inc;
    $file_name = $time . "." . $ext;
    $file_tmp = $file['tmp_name'];
    move_uploaded_file($file_tmp, "./cp/assets/images/" . $folder . "/" . $file_name);
    return $file_name;
}
#
//Select User Logo 
function slugify($name)
{
    // Replace spaces with underscores
    $name = str_replace(' ', '_', $name);
    if (!class_exists('Transliterator')) {
        // Transliterator class is not available, cannot perform transliteration
        return $name;
    }
    // Create a transliterator for Arabic to Latin
    $transliterator = Transliterator::create('Any-Latin; Latin-ASCII; Lower()');
    // Transliterate
    $slug = $transliterator->transliterate($name);
    // Remove non-alphanumeric characters
    $slug = preg_replace('/[^a-zA-Z0-9_]+/', '', $slug);
    return $slug;
}
#
// Determine the number of days ago
function getTimeAgo($dateString)
{
    $dateAdded = new DateTime($dateString);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($dateAdded);
    $daysAgo = $interval->format('%a');

    if ($daysAgo == 1) {
        return "1 day ago";
    } else {
        return $daysAgo . " days ago";
    }
}
#
// Covert Description to SubDescription
function SubDescription($description, $maxLength = 250)
{
    $description = strip_tags($description, '<br>'); // Remove all tags except <br>
    $description = str_replace('<br>', "\n", $description); // Replace <br> with newline character

    if (strlen($description) >= $maxLength) {
        $subDescription = trim(substr($description, 0, $maxLength)) . ".....";
    } else {
        $subDescription = $description;
    }

    return nl2br($subDescription); // Convert newlines to <br> tags
}
#
// Subscription
function subscription($con, $email)
{
    $err = '';
    #
    if (!isset($email)) $err = "Please Enter Your Email";
    #
    $is_fond = getData($con, 'SELECT id FROM `subscription` WHERE `email`=?', [$email]);
    if (count($is_fond) > 0) $err = "You are Already Subscribed";
    #
    if ($err == '') {
        $query = 'INSERT INTO `subscription` (`email`) VALUES (?)';
        $d = setData($con, $query, [$email]);
        if ($d > 0) {
            return [1, "Subscribe is Successfully!"];
        } else {
            $err = "Error occurred";
        }
    }
    if ($err != '') {
        return [0, $err];
    }
}

// Helper function to generate a random 16-byte IV
function generateRandomIV()
{
    return openssl_random_pseudo_bytes(16);
}

// Helper function to encrypt data using a secret key and IV
function encryptData($data, $secretKey)
{
    $iv = generateRandomIV();
    return base64_encode($iv . openssl_encrypt($data, 'AES-256-CBC', $secretKey, OPENSSL_RAW_DATA, $iv));
}

// Helper function to decrypt data using a secret key and IV
function decryptData($encryptedData, $secretKey)
{
    $dataWithIV = base64_decode($encryptedData);
    $iv = substr($dataWithIV, 0, 16);
    $encryptedDataWithoutIV = substr($dataWithIV, 16);
    return openssl_decrypt($encryptedDataWithoutIV, 'AES-256-CBC', $secretKey, OPENSSL_RAW_DATA, $iv);
}

//MAX Sequence add +1 when add item
function maxSequence($con, $table)
{
    $q = "SELECT MAX(`sequence`) as `max_seq` FROM " . $table . "";
    $d = getData($con, $q);
    if (count($d) > 0) {
        return  $d[0]['max_seq'];
    } else return 0;
}

//Update Sequence Before deleted any item For the items that exsist after this item
function updateSeqForDeleted($con, $table, $id)
{
    $q = "SELECT `sequence` FROM " . $table . " WHERE id=?";
    $result = getData($con, $q, [$id]);
    if (!empty($result) && isset($result[0]['sequence'])) {
        $sequence = $result[0]['sequence'];
        $qs = "SELECT `sequence`,`id` FROM " . $table . " WHERE `sequence` > ?";
        $ds = getData($con, $qs, [$sequence]);
        foreach ($ds as $rows) {
            $q = 'UPDATE ' . $table . ' SET `sequence` = `sequence` - 1 WHERE id=?';
            $d = setData($con, $q, [$rows['id']]);
            if ($d <= 0) {
                return false;
            }
        }
        return true;
    }
    return false;
}

//Update Sequence to Move it up and down the above sequence
function seqUP($con, $table, $id)
{
    $q = "SELECT `sequence` FROM " . $table . " WHERE id=?";
    $d = getData($con, $q, [$id]);
    if ($d > 0) {
        $sequence = $d[0]['sequence'];
        $next_seq = $sequence - 1;

        $q = "SELECT `id` FROM " . $table . " WHERE `sequence`=?";
        $d = getData($con, $q, [$next_seq]);
        $next_id = $d[0]['id'];
        if ($d > 0) {
            $q = "UPDATE " . $table . " SET `sequence` = CASE `id` WHEN ? THEN " . ($sequence - 1) . " WHEN ? THEN " . ($next_seq + 1) . " END WHERE id IN(?, ?)";
            $d = setData($con, $q, [$id, $next_id, $id, $next_id]);
            if ($d > 0) {
                return true;
            }
        }
    }
    return false;
}

//Update Sequence to Move it up and down the above sequence
function seqDown($con, $table, $id)
{
    $q = "SELECT `sequence` FROM " . $table . " WHERE id=?";
    $d = getData($con, $q, [$id]);
    if ($d > 0) {
        $sequence = $d[0]['sequence'];
        $next_seq = $sequence + 1;

        $q = "SELECT `id` FROM " . $table . " WHERE `sequence`=?";
        $d = getData($con, $q, [$next_seq]);
        $next_id = $d[0]['id'];
        if ($d > 0) {
            $q = "UPDATE " . $table . " SET `sequence` = CASE `id` WHEN ? THEN " . ($sequence + 1) . " WHEN ? THEN " . ($next_seq - 1) . " END WHERE id IN(?, ?)";
            $d = setData($con, $q, [$id, $next_id, $id, $next_id]);
            if ($d > 0) {
                return true;
            }
        }
    }
    return false;
}
# Getting Link for Download Software
function getLinkUrl($fileName)
{
    $secretKey = 'egma-group.com';
    $timestamp = time();
    $verificationData = $fileName . ',' . $timestamp;
    $encryptedToken = encryptData($verificationData, $secretKey);
    return 'http://upload.egma-group.com/?token=' . urlencode($encryptedToken);
}
