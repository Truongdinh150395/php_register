<?php
session_start();
require('config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT `name`,`id` FROM `provincial`";
//thuc hien truy van
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="project">
    <meta name="author" content="truongdinh">
    <title>Registered</title>
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
                <h1>登録情報編集</h1>
            </div>
        </div>
        <!-- end nav -->

        <!-- content -->
       

        <div class="row">
            <div class="col-lg-8 m-auto">
                <form action="register.php" method="POST">
                    <!-- row one -->
                    <div class="content">
                        <div class="col-4 border-range">
                            <div class="range-left"><label>お名前（姓名)</label><span>必須</span></div>
                        </div>
                        <div class="col-8">
                            <div class="range-right">
                                <input type="text" class="form-control" name="firstName" value="<?php if (isset($_SESSION["oldInput"]["firstName"])) {
                                                                                                    echo $_SESSION["oldInput"]["firstName"];
                                                                                                } ?>" placeholder="セイ(山田)">
                                <input type="text" class="form-control input-name" name="lastName" value="<?php if (isset($_SESSION["oldInput"]["lastName"])) {
                                                                                                                echo $_SESSION["oldInput"]["lastName"];
                                                                                                            } ?>" placeholder="メイ(太郎)">
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
                                <input type="text" class="form-control input-email" value="<?php if (isset($_SESSION["oldInput"]["email"])) {
                                                                                                echo $_SESSION["oldInput"]["email"];
                                                                                            } ?>" name="email" placeholder="例）mail@example.com ">
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
                                <input type="text" class="form-control input-phone" name="code" value="<?php if (isset($_SESSION["oldInput"]["email"])) {
                                                                                                            echo $_SESSION["oldInput"]["email"];
                                                                                                        } ?>" placeholder="例) 0123456789 ">
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
                                            <option value="<?= $row['id'] ?>"><?= $row["name"]; ?></option>
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
                                <input type="text" class="form-control input-email" name="addressDistrict" value="<?php if (isset($_SESSION["oldInput"]["email"])) {
                                                                                                                        echo $_SESSION["oldInput"]["email"];
                                                                                                                    } ?>" placeholder="市区町村郡以下番地まで入力">
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
                                <input type="text" class="form-control input-email" name="addressHouse" value="<?php if (isset($_SESSION["oldInput"]["addressHouse"])) {
                                                                                                                    echo $_SESSION["oldInput"]["addressHouse"];
                                                                                                                } ?>" placeholder="建物名と部屋番号等を入力">
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
                                <input type="text" class="form-control input-password" name="phone" value="<?php if (isset($_SESSION["oldInput"]["phone"])) {
                                                                                                                echo $_SESSION["oldInput"]["phone"];
                                                                                                            } ?>" placeholder="ハイフン無しで入力">
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
                                <input type="password" class="form-control input-password" name="password" value="<?php if (isset($_SESSION["oldInput"]["pass"])) {
                                                                                                                        echo $_SESSION["oldInput"]["pass"];
                                                                                                                    } ?>" placeholder="英数字混在6文字以上">
                            </div>
                            <?php if (isset($_SESSION["name"]["passErr"])) { ?>
                                <p class="text-danger error">
                                    <?= $_SESSION["name"]["passErr"]; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 footer">
                        <button class="btn-submit" type="submit">Đăng Ký</button>
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
<?php unset($_SESSION["name"]);?>
<?php unset($_SESSION["success"]); ?>


</html>