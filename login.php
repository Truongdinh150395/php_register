<?php
session_start();
unset($_SESSION["name"]);
if (isset($_SESSION['user'])) {
    header("location:index.php");
}
//connect to database
require('config.php');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="assets/css/login.css" <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Login</title>
</head>

<body>
    <?php
    //kiem tra nguoi dung nhan vao nut submit thi moi su ly
    if (isset($_POST["submit"])) {
        
        $email = $_POST["email"];
        $password = $_POST["password"];
        $pass = md5($password);
      
        $error  = array();
        if (empty($email)) {
            $error["emailErr"] = "Email khong duoc de trong";
        }
        if (empty($password)) {
            $error["passErr"] = "Pass khong duoc de trong";
        } else {
            if (strlen($password) < 6) {
                $error["passErr"] = " min 6";
            }
        }
        if (!empty($error)) {
            $_SESSION["oldInput"] = [
                "email" => $email,
                "password" => $password
            ];
        }
        $_SESSION["name"] = $error;
        //tao doi tuong prepare
        $stmt = $conn->prepare("select * from users where email = ? and password = ?");
        //gan gia tri vao tham so an
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); 

        if ($user) {  
            $_SESSION["user"] = $user;
            header("location:index.php");
        }
    }
    ?>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="login.php" method="POST">
                            <h3 class="text-center text-info">Đăng Nhập</h3>
                            <div class="form-group">
                                <label class="text-info">Email:</label><br>
                                <input type="text" name="email" value="<?php if (isset($_SESSION["oldInput"]["email"])) {
                                                                            echo $_SESSION["oldInput"]["email"];
                                                                        }  ?>" class="form-control">
                            </div>
                            <?php if (isset($_SESSION["name"]["emailErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["emailErr"]; ?>
                                </p>
                            <?php } ?>
                            <div class="form-group">
                                <label class="text-info">Password:</label><br>
                                <input type="password" name="password" value="<?php if (isset($_SESSION["oldInput"]["password"])) {
                                                                                    echo $_SESSION["oldInput"]["password"];
                                                                                }  ?>" class="form-control">
                            </div>
                            <?php if (isset($_SESSION["name"]["passErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["passErr"]; ?>
                                </p>
                            <?php } ?>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Đăng Nhập">
                                <!-- <a type="submit" onclick="update.php" class="btn btn-info btn-md" value="Đăng Ký"/> -->
                                <a href="create.php" class="btn btn-info btn-md">Đăng Ký</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- đóng kết nói DB -->
<?php

$conn->close();
?>

</html>