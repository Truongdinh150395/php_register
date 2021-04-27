<?php
session_start();
require_once('config.php');
  //click link href a
  $id = isset($_GET["id"])? $_GET["id"] : "";

  if($id) {
    $sql = "DELETE FROM `users` WHERE `id` =?";
    $stmt = $conn ->prepare($sql);
    $stmt->bind_param('i',$id);
    $stmt ->execute();
    $_SESSION["success"] = "Xóa Thành Công__(登録情報を登録しました。)";
    header("location:index.php");
    die();
}
?>