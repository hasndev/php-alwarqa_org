<?php
require_once "./db.php";
require_once "./function.php";
#
##
### Add Customer in (Admin->Offer->config)
if (isset($_POST['type']) && "addCust" == $_POST['type']) {
  $err = '';
  #
  if (!isset($_POST['email'])) $err = "Please Enter The Email Address";
  #
  $is_fond = getData($con, 'SELECT id FROM `offer_cust` WHERE `customer_email`=? and offer_id=?', [$_POST['email'], $_POST['id']]);
  if (count($is_fond) > 0) $err = "This Email is Already Added";
  #
  if ($err == '') {
    $query = 'INSERT INTO `offer_cust` (`offer_id`,`customer_email`) VALUES (?,?)';
    $d = setData($con, $query, [$_POST['id'], $_POST['email']]);
    if ($d > 0) {
      $data = [
        'message' => 'The Email Added Successfully!'
      ];
      http_response_code(200);
      echo json_encode($data);
    } else {
      $err = "Error occurred";
    }
  }

  if ($err != '') {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
    echo json_encode($data);
  }
}
#
##
### Subscription
if (isset($_POST['type']) && "subscribe" == $_POST['type']) {
  $err = '';
  #
  if (!isset($_POST['email'])) $err = "Please Enter Your Email";
  #
  $is_fond = getData($con, 'SELECT id FROM `subscription` WHERE `email`=?', [$_POST['email']]);
  if (count($is_fond) > 0) $err = "You are Already Subscribed";
  #
  if ($err == '') {
    $query = 'INSERT INTO `subscription` (`email`) VALUES (?)';
    $d = setData($con, $query, [$_POST['email']]);
    if ($d > 0) {
      $data = [
        'message' => 'Subscribe is Successfully!'
      ];
      http_response_code(200);
      echo json_encode($data);
    } else {
      $err = "Error occurred";
    }
  }

  if ($err != '') {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
    echo json_encode($data);
  }
}
#
##
### UnSubscription
if (isset($_POST['type']) && "unsubscribe" == $_POST['type']) {
  $err = '';
  #
  if (!isset($_POST['email'])) $err = "Please Enter Your Email";
  #
  $is_fond = getData($con, 'SELECT id FROM `subscription` WHERE `email`=?', [$_POST['email']]);
  if (count($is_fond) == 0) $err = "Your Email Not Found";
  #
  if ($err == '') {
    $query = 'UPDATE `subscription` SET `status` =? WHERE `email` =?';
    $d = setData($con, $query, [0, $_POST['email']]);
    if ($d > 0) {
      $data = [
        'message' => 'Unsubscribe is a Successfully!'
      ];
      http_response_code(200);
      echo json_encode($data);
    } else {
      $err = "Error occurred";
    }
  }

  if ($err != '') {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
    echo json_encode($data);
  }
}
#
##
### Register// We have sent a verification link to your email. Please check your inbox and follow the instructions to complete the verification process.
if (isset($_POST['type']) && "register" == $_POST['type']) {
  $err = "";
  #
  ##
  ###Check Input Vilidation
  if (!isset($_POST['name']) || empty($_POST['name']))
    $err = "Please Enter Your Name";
  #
  if (!isset($_POST['username']) || empty($_POST['username']))
    $err = "Please Enter The Username";
  #
  if (!isset($_POST['password']) || empty($_POST['password']))
    $err = "Please Enter Your Password";
  else
      if ($_POST['password'] != $_POST['c_password'])
    $err = "The Passwords is Not Matching";
  #
  if (!empty($_POST['username'])) {
    if (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 20) {
      $err .= "Username must be between 3 and 20 characters. ";
    }
    if (!preg_match("/^[a-z0-9_]+$/", $_POST['username'])) {
      $err .= "Username can only contain lowercase letters, numbers, and underscores.";
    }
  }
  #
  ##
  ###Check Username is exsist For Add Opreation
  $q = "SELECT `id` FROM `customers` WHERE `username`=?";
  $d = getData($con, $q, [$_POST['username']]);
  if (count($d) > 0)
    $err = "Username already exists! Please change it";
  #
  $q = "SELECT `value` FROM `settings` WHERE `key`=?";
  $d = getData($con, $q, ["verify"]);
  if (count($d) > 0) {
    $verify = $d[0]['value'];
    if ($d[0]['value'] == 1)
      $status = "2";
    else
      $status = "1";
  }
  #

  if (empty($err)) {
    #
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    #
    $q = 'INSERT INTO `customers`(`name`, `username`,`email`,`workshop`,`phone`,`address`,`city`, `note`, `pic`, `password`, `create_time`,`type`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';
    $d = setData($con, $q, [$_POST['name'], $_POST['username'], $_POST['email'], $_POST['workshop'],  $_POST['phone'], $_POST['address'],  $_POST['city'], "", "userlogo.jpg", $password, date("d-m-Y H:i"), 0, $status]);
    #
    if ($d > 0) {
      ##################->Start Email<-#####################
      $custId = $con->lastInsertId();
      $secretKey = 'egma-group.com';
      $timestamp = time();
      $verificationData = $custId . ',' . $timestamp;
      $encryptedToken = encryptData($verificationData, $secretKey);
      $verificationLink = 'http://egma-group.com/verify/confirm?token=' . urlencode($encryptedToken);

      $to = $_POST['email'];
      $subject = 'Confirm Your Email';
      $senderEmail = 'no-reply@egma-group.com'; // Sender's email address
      $replyToEmail = 'no-reply@egma-group.com'; // Reply-to email address

      $headers = 'From: ' . $senderEmail . "\r\n" .
        'Reply-To: ' . $replyToEmail . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
        'X-Priority: 1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

      $message = '
        <html>
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <title>Email Verification</title>
              <style>
                  /* Add your custom CSS styles here */
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f9f9f9;
                      margin: 0;
                      padding: 0;
                  }
                  .container {
                      max-width: 600px;
                      margin: 0 auto;
                      padding: 20px;
                      background-color: #ffffff;
                      border: 1px solid #e5e5e5;
                      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                  }
                  h1 {
                      color: #007bff;
                      font-size: 24px;
                      margin-bottom: 10px;
                  }
                  p {
                      color: #666666;
                      font-size: 16px;
                      margin-bottom: 15px;
                  }
                  .btn {
                      display: inline-block;
                      background-color: #007bff;
                      color: #ffffff;
                      padding: 10px 20px;
                      text-decoration: none;
                      border-radius: 5px;
                      margin-top: 10px;
                  }
                  .btn:hover {
                      background-color: #0056b3;
                  }
              </style>
          </head>
          <body>
            <div class="container">
                <h1>Email Verification</h1>
                <p>Dear ' . $_POST['name'] . ',</p>
                <p>Thank you for registering on our website (<a href="https://egma-group.com">EGMA-GROUP</a>).</p>
                <p>Please click the button below to verify your email:</p>
                <a class="btn" href="' . $verificationLink . '">Verify Email</a>
                <p>If the button above doesn\'t work, you can also copy and paste the following link into your web browser:</p>
                <p><a href="' . $verificationLink . '">' . $verificationLink . '</a></p>
                <p>Once your email is verified, your account will be activated.</p>
                <p>If you did not register on our website, please ignore this email.</p>
                <p>Thank you!</p> <br>
                <div>
                  <p>EGMA GROUP</p>
                  <p>IRAQ-BAGHDAD</p>
                  <p>Customer Care Service </p>
                  <p><a href="tel:‭+9647809222758">Tel:‭+964 780 922 2758</a></p>
                  <p><a href="tel:+9647817070712">Tel:+964 781 707 0712</a></p>
                  <p><a href="">www.egma-group.com</a></p>
                </div>
            </div>
          </body>
        </html>
      ';

      $mailSent = mail($to, $subject, $message, $headers);
      ##################->End Email<-######################
      ##################->Start Email For Abdulah<-#####################
      $custId = $con->lastInsertId();

      $to = 'abdullah@egma-iq.com';
      $subject = 'New Account Created';
      $senderEmail = 'no-reply@egma-group.com'; // Sender's email address
      $replyToEmail = 'no-reply@egma-group.com'; // Reply-to email address

      $headers = 'From: ' . $senderEmail . "\r\n" .
        'Reply-To: ' . $replyToEmail . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
        'X-Priority: 1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

      $message = '
              <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>New Account Created</title>
                    <style>
                        /* Add your custom CSS styles here */
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f9f9f9;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            padding: 20px;
                            background-color: #ffffff;
                            border: 1px solid #e5e5e5;
                            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                        }
                        h1 {
                            color: #007bff;
                            font-size: 24px;
                            margin-bottom: 10px;
                        }
                        p {
                            color: #666666;
                            font-size: 16px;
                            margin-bottom: 15px;
                        }
                        .btn {
                            display: inline-block;
                            background-color: #007bff;
                            color: #ffffff;
                            padding: 10px 20px;
                            text-decoration: none;
                            border-radius: 5px;
                            margin-top: 10px;
                        }
                        .btn:hover {
                            background-color: #0056b3;
                        }
                    </style>
                </head>
                <body>
                  <div class="container">
                      <h1>New Account Created</h1>
                      <p>Customer With Name: ' . $_POST['name'] . ',</p>
                      <p>He has Created New Account, and he sills not verified this email Until now.</p>
                      <p>' . date("d-m-Y H:i") . '</p> <br>
                      <p>With Bset Wishes!</p>
                  </div>
                </body>
              </html>
            ';

      $mailSent = mail($to, $subject, $message, $headers);
      ##################->End Email For Abdulah<-######################


      $subscription = subscription($con, $_POST['email']);
      $data = [
        'message' => 'Register Successfully!',
        'type' => $verify
      ];
      http_response_code(200);
      echo json_encode($data);
    } else
      $err = "Error occurred";
  }
  if ($err != '') {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
    echo json_encode($data);
  }
}
#
##
### Login
if (isset($_POST['type']) && "login" == $_POST['type']) {
  $err = "";
  #
  ##
  ###Check Input Vilidation
  if (!isset($_POST['username']) || empty($_POST['username']))
    $err = "Please Enter The Username";
  #
  if (!isset($_POST['password']) || empty($_POST['password']))
    $err = "Please Enter Your Password";
  #
  if (empty($err)) {
    #
    $q = "SELECT * FROM customers where username=?";
    $d = getData($con, $q, [$_POST['username']]);
    #
    if (count($d) > 0) {
      $pass = $d[0]['password'];
      if (password_verify($_POST['password'], $pass)) {
        if ($d[0]['status'] == 1) {
          $_SESSION['c_login'] = 1;
          $_SESSION['cname'] = $d[0]['name'];
          $_SESSION['u_id'] = $d[0]['id']; //for login
          $_SESSION['user_id'] = $d[0]['id']; //for order
          $message = "Welcome " . $_POST['username'] . "!";
          $data = [
            'message' => $message,
            'type' => 0
          ];
          http_response_code(200);
          echo json_encode($data);
        } elseif ($d[0]['status'] == 2) {
          $data = [
            'message' => "Your Email Does Not Verify!",
            'type' => 1
          ];
          http_response_code(200);
          echo json_encode($data);
          ##################->Start Email<-#####################
          $custId = $d[0]['id'];
          $secretKey = 'egma-group.com';
          $timestamp = time();
          $verificationData = $custId . ',' . $timestamp;
          $encryptedToken = encryptData($verificationData, $secretKey);
          $verificationLink = 'http://egma-group.com/verify/confirm?token=' . urlencode($encryptedToken);

          $to = $d[0]['email'];
          $subject = 'Confirm Your Email';
          $senderEmail = 'no-reply@egma-group.com'; // Sender's email address
          $replyToEmail = 'no-reply@egma-group.com'; // Reply-to email address

          $headers = 'From: ' . $senderEmail . "\r\n" .
            'Reply-To: ' . $replyToEmail . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=UTF-8' . "\r\n" .
            'X-Priority: 1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

          $message = '
            <html>
              <head>
                  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                  <meta name="viewport" content="width=device-width, initial-scale=1">
                  <title>Email Verification</title>
                  <style>
                      /* Add your custom CSS styles here */
                      body {
                          font-family: Arial, sans-serif;
                          background-color: #f9f9f9;
                          margin: 0;
                          padding: 0;
                      }
                      .container {
                          max-width: 600px;
                          margin: 0 auto;
                          padding: 20px;
                          background-color: #ffffff;
                          border: 1px solid #e5e5e5;
                          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                      }
                      h1 {
                          color: #007bff;
                          font-size: 24px;
                          margin-bottom: 10px;
                      }
                      p {
                          color: #666666;
                          font-size: 16px;
                          margin-bottom: 15px;
                      }
                      .btn {
                          display: inline-block;
                          background-color: #007bff;
                          color: #ffffff;
                          padding: 10px 20px;
                          text-decoration: none;
                          border-radius: 5px;
                          margin-top: 10px;
                      }
                      .btn:hover {
                          background-color: #0056b3;
                      }
                  </style>
              </head>
              <body>
                <div class="container">
                    <h1>Email Verification</h1>
                    <p>Dear ' . $d[0]['name'] . ',</p>
                    <p>Thank you for registering on our website (<a href="https://egma-group.com">EGMA-GROUP</a>).</p>
                    <p>Please click the button below to verify your email:</p>
                    <a class="btn" href="' . $verificationLink . '">Verify Email</a>
                    <p>If the button above doesn\'t work, you can also copy and paste the following link into your web browser:</p>
                    <p><a href="' . $verificationLink . '">' . $verificationLink . '</a></p>
                    <p>Once your email is verified, your account will be activated.</p>
                    <p>If you did not register on our website, please ignore this email.</p>
                    <p>Thank you!</p> <br>
                    <div>
                      <p>EGMA GROUP</p>
                      <p>IRAQ-BAGHDAD</p>
                      <p>Customer Care Service </p>
                      <p><a href="tel:‭+9647809222758">Tel:‭+964 780 922 2758</a></p>
                      <p><a href="tel:+9647817070712">Tel:+964 781 707 0712</a></p>
                      <p><a href="">www.egma-group.com</a></p>
                    </div>
                </div>
              </body>
            </html>
          ';

          $mailSent = mail($to, $subject, $message, $headers);
          ##################->End Email<-######################
        } else
          $err = "Your account is currently suspended, please check with the site administrator";
      } else
        $err = "Incorrect username or password, please try again";
    } else
      $err = "Incorrect username or password, please try again";
  }
  if ($err != '') {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
    echo json_encode($data);
  }
}
#
##
### Add To Cart
if (isset($_POST['type']) && "addToCart" == $_POST['type']) {
  $err = "";
  #
  ##
  ###Check Input Vilidation
  if (!isset($_POST['item']) || empty($_POST['item']))
    $err = "Please Select Item";
  #
  if (!isset($_POST['qty']) || empty($_POST['qty']))
    $qty = 1;
  else $qty = $_POST['qty'];
  #
  if (!isset($_SESSION['order_id'])) {
    $_SESSION['order_id'] = time();
  }
  #
  if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = intval(time()) + 1;
  }

  if (empty($err)) {
    $success = '0';
    #
    $sql = "SELECT `id` FROM `basket` Where `item_id` =? and `order_id`=?";
    $row = getData($con, $sql, [$_POST['item'], $_SESSION['order_id']]);
    if (count($row) > 0) {
      $success = '2';
    } else {
      $query = "SELECT *, (SELECT `value` FROM `settings` WHERE `id`=1) as iqd 
      FROM `items` WHERE `id`=? AND qty >= ?";
      $res = getData($con, $query, [$_POST['item'], $qty]);
      if (count($res) > 0) {
        $price = $res[0]['price'] * $res[0]['iqd'];
        #
        $qur = "INSERT INTO `basket` (`item_id`, `userid`, `order_id`, `b_qty`, `price`) VALUES (?,?,?,?,?)";
        $qqq = setData($con, $qur, [$_POST['item'], $_SESSION['user_id'], $_SESSION['order_id'], $qty, $price]);
        if ($qqq > 0) {
          $success = '1';
        } else {
          $success = '3';
        }
      } else {
        $ava_qty = selectItem($con, 'items', 'qty', $_POST['item']);
        $err = "The Availabe Quantity is:" . $ava_qty;
      }
    }
    $data['success'] = $success;
  }
  if ($err != '') {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
  }
  echo json_encode($data);
}
#
##
###updateCart
if (isset($_POST['type']) && "updateCart" == $_POST['type']) {
  if (isset($_POST['rowId']) && isset($_POST['qty'])) {
    $rowId = $_POST['rowId'];
    $qty = $_POST['qty'];
    $query = "SELECT *, (SELECT `value` FROM `settings` WHERE `id`=1) as iqd 
    FROM `items` WHERE `id`=? AND qty >= ?";
    $res = getData($con, $query, [$rowId, $qty]);
    if (count($res) > 0) {
      $query = "UPDATE `basket` SET `b_qty` = ? WHERE `item_id` = ? AND order_id=?";
      $stmt = setData($con, $query, [$qty, $rowId, $_SESSION['order_id']]);
      if ($stmt > 0) {
        $response = ['success' => true, 'message' => 'Quantity updated successfully'];
      } else {
        $response = ['success' => false, 'message' =>  'Invalid Update'];
      }
    } else {
      $ava_qty = selectItem($con, 'items', 'qty', $rowId);
      $response = ['success' => false, 'message' => "The Availabe Quantity is:" . $ava_qty];
    }
  } else {
    $response = ['success' => false, 'message' => 'Invalid request'];
  }
  echo json_encode($response);
}
#
##
###deleteItemFromCart
if (isset($_POST['type']) && "deleteItemFromCart" == $_POST['type']) {
  if (isset($_POST['item'])) {

    $q = "DELETE FROM basket WHERE item_id=? AND order_id=?";
    $d = setData($con, $q, [$_POST['item'], $_SESSION['order_id']]);
    if ($d) {
      $success = 4;
    }
    echo json_encode(["success" => $success]);
  } else {
    $response = ['success' => false, 'message' => 'Invalid request'];
    echo json_encode($response);
  }
}
#
##
###CheckOut
if (isset($_POST['type']) && "checkout" == $_POST['type']) {
  //Chek if the user is login or not
  if (isset($_SESSION['c_login'])) {
    $_SESSION['user_id'] = $_SESSION['u_id'];
    $q_user = "SELECT * FROM customers WHERE id=?";
    $d_user = getData($con, $q_user, [$_SESSION['user_id']]);
    $res_user = $d_user[0];
    $email = $res_user['email'];
  } else {
    $email = $_POST['email'];
    if (!isset($_SESSION['user_id'])) {
      $_SESSION['user_id'] = intval(time()) + intval(rand(10, 10000));
    }
  }
  #
  if ($email != "") {
    $n = 1;
    $totalPrice = 0;
    $items_content = '';
    $query = "SELECT `item_id`, `order_id`, `b_qty`, `price`,
    (SELECT `name` FROM `items` WHERE `items`.`id`=`basket`.`item_id`) as item_name 
     FROM `basket` WHERE `order_id`=?";
    $res = getData($con, $query, [$_SESSION['order_id']]);
    foreach ($res as $row) {
      $totalPrice += ($row['b_qty'] * $row['price']);

      $sql = "INSERT INTO `order_info` (`order_id`, `userid`, `item_id`, `order_qty`, `item_price`) VALUES (?,?,?,?,?)";
      $stq = setData($con, $sql, [$_SESSION['order_id'], $_SESSION['user_id'], $row['item_id'], $row['b_qty'], $row['price']]);
      $stmt = "DELETE FROM `basket` WHERE `item_id`=? and `order_id` =?";
      $st = setData($con, $stmt, [$row['item_id'], $_SESSION['order_id']]);
      $sql_del2 = "UPDATE `items` set `qty` = `qty`-? where `id` =?";
      $row_del2 = setData($con, $sql_del2, [$row['b_qty'], $row['item_id']]);

      $items_content .= '<tr>
      <td>' . $n++ . '</td>
      <td>' . $row['item_name'] . '</td>
      <td>' . number_format($row['price']) . ' IQD</td>
      <td>' . $row['b_qty'] . '</td>
      <td><span class="badge bg-label-primary me-1">' . number_format($row['b_qty'] * $row['price']) . ' IQD</span></td>
      </tr>';
    }

    $qll = "INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `delivery`, `order_date`) VALUES (?,?,?,?,?)";
    $result = setData($con, $qll, [$_SESSION['order_id'], $_SESSION['user_id'], $totalPrice, $_POST['delivery'], date("Y-m-d")]);
    $query = "INSERT INTO `user_info` (`order_id`,`userid`, `name`, `city`, `email`, `phone`, `address`, `note`) VALUES (?,?,?,?,?,?,?,?)";
    if (isset($_SESSION['c_login'])) {
      ##################
      $row = setData($con, $query, [
        $_SESSION['order_id'], $_SESSION['user_id'], $res_user['name'], $res_user['city'],
        $res_user['email'], $res_user['phone'], $res_user['address'], ""
      ]);
    } else {
      $row = setData($con, $query, [
        $_SESSION['order_id'], $_SESSION['user_id'], $_POST['name'], $_POST['city'],
        $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['note']
      ]);
    }

    $delivery = '';
    if ($row > 0) {
      $subscription = subscription($con, $_POST['email']);
      #
      $success = 1;

      if ($_POST['delivery'] == 5000)
        $delivery = "Delivery inside Baghdad - نقل داخل بغداد (5000 IQD)";
      elseif ($_POST['delivery'] == 10000)
        $delivery = "Delivery inside Baghdad (fast) - نقل داخل بغداد (سريع) (10000 IQD)";
      elseif ($_POST['delivery'] == 8000)
        $delivery = "Delivery inside Baghdad - نقل خارج بغداد (8000 IQD)";


      ##########################################################################
      //Start Email Section
      $to = 'sales@egma-group.com'; // Admin's email address
      $subject = 'Order Details - Order #' . $_SESSION['order_id'];
      // Sender's email address (optional)
      $senderEmail = 'no-reply@egma-group.com'; // Sender's email address
      $replyToEmail = 'no-reply@egma-group.com'; // Reply-to email address
      $ccEmail = 'abdullah@egma-iq.com'; // CC email address

      $headers = 'From: ' . $senderEmail . "\r\n" .
        'Reply-To: ' . $replyToEmail . "\r\n" .
        'Cc: ' . $ccEmail . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
        'X-Priority: 1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

      $message = '
      <html>
      <head>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
          <style>
              body {
                  font-family: Arial, sans-serif;
                  background-color: #f9f9f9;
              }
              .container {
                  max-width: 600px;
                  margin: 0 auto;
                  padding: 20px;
                  background-color: #ffffff;
                  border: 1px solid #e5e5e5;
              }
              h1 {
                  color: #333333;
                  font-size: 24px;
                  margin-bottom: 10px;
              }
              p {
                  color: #666666;
                  font-size: 16px;
                  margin-bottom: 15px;
              }
              table {
                  width: 100%;
                  margin-bottom: 20px;
                  border-collapse: collapse;
              }
              table thead th {
                  background-color: #f5f5f5;
                  color: #333333;
                  font-weight: bold;
                  padding: 8px;
                  text-align: left;
                  border-top: 1px solid #e5e5e5;
                  border-bottom: 1px solid #e5e5e5;
              }
              table tbody td {
                  padding: 8px;
                  border-bottom: 1px solid #e5e5e5;
              }
              table tbody tr:last-child td {
                  border-bottom: none;
              }
          </style>
      </head>
      <body>
      <div class="container">
          <h1>Order Details - Order #' . $_SESSION['order_id'] . '</h1>
          <p>Dear Admin,</p>
          <p>You have received a new order with the following details:</p>
          <div>
              <table>
                  <tbody>
                      <tr>
                          <td><strong>Order ID:</strong></td>
                          <td>' . $_SESSION['order_id'] . '</td>
                      </tr>
                      <tr>
                          <td><strong>Customer Name:</strong></td>
                          <td>' . $_POST['name'] . '</td>
                      </tr>
                      <tr>
                          <td><strong>Total Price:</strong></td>
                          <td>' . number_format($totalPrice + ($_POST['delivery'] == '' ? 0 : $_POST['delivery'])) . ' IQD</td>
                      </tr>
                      <tr>
                          <td><strong>Order Date:</strong></td>
                          <td>' . date("d-m-Y H:i") . '</td>
                      </tr>
                      <tr>
                          <td><strong>Email:</strong></td>
                          <td>' . $_POST['email'] . '</td>
                      </tr>
                      <tr>
                          <td><strong>Phone Number:</strong></td>
                          <td>' . $_POST['phone'] . '</td>
                      </tr>
                      <tr>
                          <td><strong>Address:</strong></td>
                          <td>' . $_POST['address'] . '<br>' . $_POST['city'] . '</td>
                      </tr>
                      <tr>
                          <td><strong>Delivery Options:</strong></td>
                          <td>' . $delivery . '</td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div>
              <p>Items details:</p>
              <table>
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Item Name</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>End Price</th>
                      </tr>
                  </thead>
                  <tbody>
                      ' . $items_content . '
                  </tbody>
              </table>
          </div>
      </div>
      </body>
      </html>
      ';

      $mailSent = mail($to, $subject, $message, $headers);
      // Email End
      ##########################################################################
      #
      $_SESSION['order_id'] = time();
      #
      if (!isset($_SESSION['c_login']))
        $_SESSION['user_id'] = intval(time()) + 1;
      #
    }
    echo json_encode(["success" => $success]);
  } else {
    $response = ['success' => false, 'message' => 'Invalid request'];
    echo json_encode($response);
  }
}
#################################################################
#Delete Model
if (isset($_POST['opr_type']) && $_POST['opr_type'] === "deleteModel" && !empty($_POST['id'])) {
  $id = $_POST['id'];
  $response = array();

  try {
    $file_pdf = "";
    $file_name = selectItem($con, 'model', 'pic', $id);
    unlink("./admin/assets/img/product/" . $file_name);

    $file_pdf = selectItem($con, 'model', 'file_pdf', $id);
    if ($file_pdf != "")
      unlink("./admin/assets/img/product/" . $file_pdf);

    // Delete All Pics of Model Gallery
    $rq = "SELECT `id`, `model_id`, `image_path` FROM `model_images` WHERE model_id = ?";
    $rd = getData($con, $rq, [$id]);
    foreach ($rd as $res) {
      if ($res['image_path'] != "") {
        unlink("./admin/assets/img/product/" . $res['image_path']);
        $q = 'DELETE FROM `model_images` WHERE id=?';
        $d = setData($con, $q, [$res['id']]);
      }
    }

    // Update sequence For The products That's After this product
    $delupseq = updateSeqForDeleted($con, 'model', $id);

    // Delete Model
    $q = 'DELETE FROM `model` WHERE id=?';
    $d = setData($con, $q, [$id]);

    $response['status'] = 'success';
    $response['message'] = 'Model deleted successfully!';
  } catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'An error occurred while deleting the model: ' . $e->getMessage();
  }

  // Return the response as JSON
  header('Content-Type: application/json');
  echo json_encode($response);
}
#
##
### Delete Product
if (isset($_POST['opr_type']) && $_POST['opr_type'] === "deleteProduct" && !empty($_POST['id'])) {
  $id = $_POST['id'];
  $response = array();
  $skip = isset($_POST['skip']) ? $_POST['skip'] : false;

  try {
    if (!$skip) {
      // Check if it has any models
      $qs = "SELECT `id` FROM `model` WHERE `product_id`=?";
      $ds = getData($con, $qs, [$id]);

      if (!empty($ds)) {
        // Show warning using Swal.fire
        $response['status'] = 'warning';
        $response['message'] = 'This product has Some of models. Are you sure you want to proceed and delete it and all models that are Under it??';
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
      }
    }

    // Update sequence For The products That's After this product
    $delupseq = updateSeqForDeleted($con, 'products', $id);

    // Delete the product's associated models
    $q = 'DELETE FROM `model` WHERE product_id=?';
    $d = setData($con, $q, [$id]);

    // Delete the product
    $file_name = selectItem($con, 'products', 'pic', $id);
    $file_path = "./admin/assets/img/product/" . $file_name;
    if (file_exists($file_path) && ($file_name != null || $file_name != "")) {
      unlink($file_path);
    }
    #
    $q = 'DELETE FROM `products` WHERE id=?';
    $d = setData($con, $q, [$id]);

    $response['status'] = 'success';
    $response['message'] = 'Product and associated models deleted successfully!';
    header('Content-Type: application/json');
    echo json_encode($response);
  } catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'An error occurred while deleting the product: ' . $e->getMessage();
    header('Content-Type: application/json');
    echo json_encode($response);
  }
}
#
##
### Delete Item
if (isset($_POST['opr_type']) && $_POST['opr_type'] === "deleteItem" && !empty($_POST['id'])) {
  $id = $_POST['id'];
  $response = array();

  try {
    $file_pdf = "";
    $file_name = selectItem($con, 'items', 'pic', $id);
    unlink("./admin/assets/img/product/" . $file_name);

    // Delete All Pics of Item Gallery
    $rq = "SELECT `id`, `item_id`, `image_path` FROM `item_images` WHERE item_id = ?";
    $rd = getData($con, $rq, [$id]);
    foreach ($rd as $res) {
      if ($res['image_path'] != "") {
        unlink("./admin/assets/img/product/" . $res['image_path']);
        $q = 'DELETE FROM `item_images` WHERE id=?';
        $d = setData($con, $q, [$res['id']]);
      }
    }

    // Update sequence For The products That's After this product
    $delupseq = updateSeqForDeleted($con, 'items', $id);

    // Delete Model
    $q = 'DELETE FROM `items` WHERE id=?';
    $d = setData($con, $q, [$id]);

    $response['status'] = 'success';
    $response['message'] = 'Item deleted successfully!';
  } catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'An error occurred while deleting the Item: ' . $e->getMessage();
  }

  // Return the response as JSON
  header('Content-Type: application/json');
  echo json_encode($response);
}
#
##
### Delete Category
if (isset($_POST['opr_type']) && $_POST['opr_type'] === "deleteCategory" && !empty($_POST['id'])) {
  $id = $_POST['id'];
  $response = array();
  $skip = isset($_POST['skip']) ? $_POST['skip'] : false;

  try {
    if (!$skip) {
      // Check if it has any items
      $qs = "SELECT `id` FROM `items` WHERE `category`=?";
      $ds = getData($con, $qs, [$id]);

      if (!empty($ds)) {
        // Show warning using Swal.fire
        $response['status'] = 'warning';
        $response['message'] = 'This category has Some of items. Are you sure you want to proceed and delete it and all items that are Under it??';
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
      }
    }

    // Delete the category's associated items
    $q = 'DELETE FROM `items` WHERE category=?';
    $d = setData($con, $q, [$id]);

    // Delete the category
    $file_name = selectItem($con, 'categories', 'pic', $id);
    $file_path = "./admin/assets/img/category/" . $file_name;
    if (file_exists($file_path) && ($file_name != null || $file_name != "")) {
      unlink($file_path);
    }
    #
    $q = 'DELETE FROM `categories` WHERE id=?';
    $d = setData($con, $q, [$id]);

    $response['status'] = 'success';
    $response['message'] = 'category and associated items deleted successfully!';
    header('Content-Type: application/json');
    echo json_encode($response);
  } catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'An error occurred while deleting the category: ' . $e->getMessage();
    header('Content-Type: application/json');
    echo json_encode($response);
  }
}
#
##
### Move Sequence based on The New Sequence
if (isset($_POST['type']) && "moveSequence" == $_POST['type']) {
  $err = '';
  #
  if (isset($_POST['id']) && isset($_POST['new_seq'])) {
    $id = $_POST['id'];
    $newSeq = $_POST['new_seq'];
    $table = $_POST['table'];

    try {
      // Get the old sequence value for the item
      $query = "SELECT `sequence` FROM " . $table . " WHERE id = ?";
      $res = getData($con, $query, [$id]);
      $oldSeq = $res[0]['sequence'];

      // Update the sequence for the specified item
      $query = "UPDATE " . $table . " SET `sequence` = ? WHERE `id` = ?";
      $count = setData($con, $query, [$newSeq, $id]);

      if ($count > 0) {
        if ($newSeq > $oldSeq) {
          // Move the item down, so adjust the sequences of items in between (oldSeq + 1) and (newSeq)
          $query = "UPDATE " . $table . " SET `sequence` = `sequence` - 1 WHERE `id` <> ? AND `sequence` > ? AND `sequence` <= ?";
          setData($con, $query, [$id, $oldSeq, $newSeq]);
        } elseif ($newSeq < $oldSeq) {
          // Move the item up, so adjust the sequences of items in between (newSeq) and (oldSeq - 1)
          $query = "UPDATE " . $table . " SET `sequence` = `sequence` + 1 WHERE `id` <> ? AND `sequence` >= ? AND `sequence` < ?";
          setData($con, $query, [$id, $newSeq, $oldSeq]);
        }
        $data = ["success" => "Updated Successfully"];
      } else {
        $data = ['error' => "Can Not Update This Sequence"];
        http_response_code(400);
      }
    } catch (PDOException $e) {
      $data = ['error' => $e->getMessage()];
      http_response_code(400);
    }
    echo json_encode($data);
  }
}
#
##
### Redirect Offer
if (isset($_POST['type']) && "redirectOffer" == $_POST['type']) {
  $err = '';
  if (!isset($_POST['id']) || empty($_POST['id']))
    $err = "Please Redirect Valid Offer";
  #
  $oldOfferId = $_POST['id'];
  if (empty($err)) {
    $q = "SELECT `id`,`offer_id`,`title`, `start_date`, `end_date`, `note`, `by_emp` FROM `offer_info` Where `offer_id` =? and `status`=?";
    $d = getData($con, $q, [$oldOfferId, 5]);
    if (count($d) > 0) {
      $row = $d[0];
      $newOfferId = intval(time()) + intval(rand(10, 10000));
      $q = 'INSERT INTO `offer_info`(`offer_id`,`title`, `start_date`, `end_date`, `note`, `by_emp`, `status`) VALUES (?,?,?,?,?,?,?)';
      $d = setData($con, $q, [$newOfferId, $row['title'], date('Y-m-d'), $row['end_date'], $row['note'], $row['by_emp'], 3]);
      #
      $q_items = "SELECT `item_id`, `type`, `old_price`, `new_price` FROM `offer_items` WHERE `offer_id`=?";
      $d_items = getData($con, $q_items, [$oldOfferId]);
      if (count($d_items) > 0) {
        foreach ($d_items as $item) {
          $q_insert = 'INSERT INTO `offer_items`(`offer_id`, `item_id`, `type`, `old_price`, `new_price`) VALUES (?,?,?,?,?)';
          $d_insert = setData($con, $q_insert, [$newOfferId, $item['item_id'], $item['type'], $item['old_price'], $item['new_price']]);
        }
        $data = [
          'message' => 'Redirected Offer Now!',
          'newOfferId' => $newOfferId
        ];
        http_response_code(200);
      }
    } else {
      $err = "Please Redirect the Offer with the Status Completed";
    }
  }

  if (!empty($err)) {
    $data = [
      'error' => $err
    ];
    http_response_code(400);
  }
  echo json_encode($data);
}
#
##
###
die;
