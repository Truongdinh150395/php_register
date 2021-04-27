<?php
session_start();
//connect database
require('config.php');

$error  = array();
//validate
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstName = $_POST['firstName'];
  $lastName = $_POST["lastName"];
  $fullName =  $firstName . $lastName;
  $email =  $_POST['email'];
  $code = $_POST['code'];
  $addressProvincial = $_POST['addressProvincial'];
  $addressDistrict = $_POST['addressDistrict'];
  $addressHouse = $_POST['addressHouse'];
  $phone = $_POST['phone'];
  $pass = $_POST['password'];
  $password = md5($pass);

  if (empty($email)) {
    $error["emailErr"] = "メー__を入力してください";
  } else 
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error["emailErr"] = "Email format ";
  }else {
  $duplicate = mysqli_query($conn,"SELECT * FROM `users` WHERE `email` = '$email' ");
 
  if(mysqli_num_rows($duplicate) > 0) {
      $error["emailErr"] = "Email already exists";
  }
}
  if (empty($firstName)) {
    $error["firstNameErr"] = "お名前__を入力してください";
  }
  if (empty($lastName)) {
    $error["lastNameErr"] = "お名前__を入力してください";
  }
  if (empty($phone)) {
    $error["phoneErr"] = "電話番号__を入力してください";
  } else if (!preg_match('/^[0-9]{10}+$/', $phone)) {
    $error["phoneErr"] = "Phone format";
  }
  if (empty($addressHouse)) {
    $error["addressHouseErr"] = "住所__を入力してください";
  }
  if (empty($addressDistrict)) {
    $error["addressDistrictErr"] = "住所__を入力してください";
  }
  if (empty($addressProvincial)) {
    $error["addressProvincialErr"] = "住所__を入力してください";
  }
  if (empty($pass)) {
       $error["passErr"] = "パスワード__を入力してください";
     } else {
         if (strlen($pass) < 6) {
      $error["passErr"] = " min 6";
    }
 } 
}
if (!empty($error)) {
  
  $_SESSION["oldInput"] = [
    "email" => $email,
    "firstName" => $firstName,
    "lastName" => $lastName,
    "code" => $code,
    "addressProvin" => $addressProvincial,
    "addressDistrict" => $addressDistrict,
    "addressHouse" => $addressHouse,
    "phone" => $phone,
    "pass" => $pass

  ];
  $_SESSION["name"] = $error;
  header("location:create.php");
  exit();
}
// $pass = md5($_POST['password']);
//create connect

if ($conn->connect_error) {
  die("connect fail:" . $conn->connect_error);
}
echo "Connected successfully";
//begin transaction
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ALL;

$conn->begin_transaction();

try {
  $stmt = $conn->prepare("INSERT INTO users(firstname,lastname,email,code,address_provin,address_distri,address_house,phone,password) VALUES(?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param('sssssssss', $firstName, $lastName, $email, $code, $addressProvincial, $addressDistrict, $addressHouse, $phone, $password);
  $stmt->execute();
  $_SESSION["success"] = "Created successfully__(登録情報を登録しました。)";
  $conn->commit();
  header("location:index.php");
} catch (Exception $e) {
  $conn->rollback();
 
} 
$stmt->close();
$conn->close();
