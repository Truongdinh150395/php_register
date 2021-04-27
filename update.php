<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location:login.php");
} 
// conect DB
require('config.php');

$sql = "SELECT `name`,`id` FROM `provincial`";
$result = mysqli_query($conn, $sql);

//lay id khi click vao the "a" ben index;
$id = isset($_GET["id"])? $_GET["id"] : "";

$query = "select * from users where id = ? ";
$stmt = $conn->prepare($query);
$stmt->bind_param('i',$id);
$stmt->execute();
 $results = $stmt->get_result();
$user = $results->fetch_assoc(); 


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="project">
    <meta name="author" content="truongdinh">
    <title>Update</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>
    <div class="container-fluid">
        <!-- top -->
        <div class="row ">
            <div class="col-lg-12 p-lg-1 bg-light"></div>
        </div>
        <!--end top -->

        <!-- header -->
        <div class="row">
            <div class="col-lg-12 p-lg-3 text-center">
                <h2>Orange Cloud 7</h2>
            </div>
        </div>
        <!--end header  -->

        <!-- nav -->
        <div class="row">
            <div class="col-lg-12 p-lg-4 nav-bg-color text-center text-light">
                <h1>情報を編集する</h1>
            </div>
        </div>
        <!-- end nav -->

        <!-- content -->
        <div class="row">
            <!-- code update DB -->
            <?php

            if (isset($_POST["btnUpdate"])) {

                $firstName = $_POST['firstName'];
                $lastName = $_POST["lastName"];
                $email =  $_POST['email'];
                $code = $_POST['code'];
                $addressProvincial = $_POST['addressProvincial'];
                $addressDistrict = $_POST['addressDistrict'];
                $addressHouse = $_POST['addressHouse'];
                $phone = $_POST['phone'];
                $pass = $_POST['password'];
                // //md5 lại password
                $password = md5($pass);

                $error  = array();
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($email)) {
                        $error["emailErr"] = "メー__を入力してください";
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error["emailErr"] = "Email format ";
                    } else {
                        $duplicate = mysqli_query($conn,"SELECT * FROM `users` WHERE `email` = '$email' ");
                       
                        if(mysqli_num_rows($duplicate) > 0) {
                            $error["emailErr"] = "Email already exists";
                        }
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
                    if (empty($firstName)) {
                        $error["firstNameErr"] = "お名前__を入力してください";
                    }
                    if (empty($lastName)) {
                        $error["lastNameErr"] = "お名前__を入力してください";
                    }
                }
               
                if (!empty($error)) {
                    $_SESSION["name"] = $error;
                        //lưu thông tin đăng nhập cũ 
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
                    header("location:update.php?id=".$id);
                    exit();
                }
                //begin transaction
                $conn->begin_transaction();
                try {
                     
                    $sql = "UPDATE `users` SET `email`=?,`code`=?,`address_provin`=?,`address_distri`=?,`address_house`=?,`phone`=?,`firstname`=?,`lastname`=?,`password`=? WHERE  `id` =?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ssissssssi', $email, $code, $addressProvincial, $addressDistrict, $addressHouse, $phone, $firstName, $lastName,$password, $id);
                    $stmt->execute();
                    $_SESSION["success"] = "Cập Nhật Thành Công!__(登録情報を登録しました。)";
                    $conn->commit();
                } catch (mysqli_sql_exception $e) {
                   $conn->rollback();    
                }
                if(isset($_SESSION["oldInput"])) {
                    unset($_SESSION["oldInput"]);
            
                }
                if(isset($_SESSION["name"])) {
                    unset($_SESSION["name"]);
                }
                //update lai thong tin nguoi dung moi                 
                $_SESSION['user'] = [
                    'id' => $_SESSION["user"]["id"],
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => $email,
                    'code' => $code,
                    'address_provin' => $addressProvincial,
                    'address_distri' => $addressDistrict,
                    'address_house' => $addressHouse,
                    'phone' => $phone,
                    'password' => $password
                ];
                
                header("location:index.php");
               
            }
            //click btn_logout
            if (isset($_POST["btnLogout"])) {
                session_destroy();
                header("location:login.php");
                die();
            }
          
            ?>
            <div class="col-lg-8 m-auto">
                <form action="" method="POST">
                    <!-- row one -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>お名前（姓名)</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">

                                <input type="text" class="form-control" name="firstName"
                                 value="<?= isset($_SESSION['oldInput']['firstName']) ? $_SESSION['oldInput']['firstName'] : $user['firstname']?>" 
                                 placeholder="セイ(山田)">
                                <input type="text" class="form-control input-name" name="lastName" value="<?= isset($_SESSION['oldInput']['lastName']) ? $_SESSION['oldInput']['lastName'] : $user['lastname']?>" placeholder="メイ(太郎)">
                            </div>
                            <?php if (isset($_SESSION["name"]["firstNameErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["firstNameErr"]; ?>
                                </p>
                            <?php  } ?>
                            <?php if (isset($_SESSION["name"]["lastNameErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["lastNameErr"]; ?>
                                </p>
                            <?php  } ?>
                        </div>
                    </div>
                    <!-- row three -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>メールアドレス</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">

                                <input type="text" class="form-control input-email" value="<?= isset($_SESSION['oldInput']['email']) ? $_SESSION['oldInput']['email'] : $user['email']?>" name="email" placeholder="例）mail@example.com ">
                            </div>

                            <?php if (isset($_SESSION["name"]["emailErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["emailErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- row four -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>郵便番号</label></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">
                                <input type="text" class="form-control input-phone" name="code" value="<?= isset($_SESSION['oldInput']['code']) ? $_SESSION['oldInput']['code'] : $user['code']?>" placeholder="例) 0123456789 ">
                            </div>
                        </div>
                    </div>
                    <!-- row five -->
                    <div class=" content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>住所（都道府県)</label><span>必須</span></div>
                        </div>

                        <div class="col-8">
                            <div class="range-right">
                                <select class="form-select" name="addressProvincial">
                                    <option value="" selected>該当する都道府県を選択</option>
                                    <?php if (mysqli_num_rows($result) > 0) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <option <?php if ($_SESSION["user"]["address_provin"] == $row["id"]) {
                                                        echo "selected";} ?>
                                                         value="<?= $row['id'] ?>"><?= $row["name"]; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php if (isset($_SESSION["name"]["addressProvincialErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["addressProvincialErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- row six -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>住所（市区町村郡以下)</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">
                                <input type="text" class="form-control input-email" name="addressDistrict" value="<?= isset($_SESSION['oldInput']['addressDistrict']) ? $_SESSION['oldInput']['addressDistrict'] : $user['address_distri']?>" placeholder="市区町村郡以下番地まで入力">
                            </div>
                            <?php if (isset($_SESSION["name"]["addressDistrictErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["addressDistrictErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <!--row sevent  -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>住所（建物・部屋)</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">
                                
                                <input type="text" class="form-control input-email" name="addressHouse" value="<?= isset($_SESSION['oldInput']['addressHouse']) ? $_SESSION['oldInput']['addressHouse'] : $user['address_house']?>" placeholder="建物名と部屋番号等を入力">
                            </div>
                           
                            <?php if (isset($_SESSION["name"]["addressHouseErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["addressHouseErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- row eight -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>電話番号</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">
                                <input type="text" class="form-control input-password" name="phone" value="<?= isset($_SESSION['oldInput']['phone']) ? $_SESSION['oldInput']['phone'] : $user['phone']?>" placeholder="ハイフン無しで入力">
                            </div>
                            <?php if (isset($_SESSION["name"]["phoneErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["phoneErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- row night -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>パスワード</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">
                                <input type="password" class="form-control input-password" placeholder="........" name="password" value="">
                            </div>
                            <?php if (isset($_SESSION["name"]["passErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["passErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 footer">
                        <button class="btn-submit" name="btnUpdate" type="submit">更新(cap nhat)</button>
                        <button class="btn-submit" name="btnLogout">出口(Logout)</button>
                        <!-- <button class="btn-submit" name="btnDelete" onclick="return confirm('Are you sure you want to delete this item')">出口(Delete)</button> -->
                    </div>
                </form>
            </div>
        </div>
        <!-- end content -->
    </div>

    <script src=" https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

<?php unset($_SESSION["oldInput"]); ?> 

</html>