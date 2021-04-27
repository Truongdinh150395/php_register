<?php session_start();?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="project">
    <meta name="author" content="truongdinh">
    <title>Danh Sach</title>
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<?php 
    require_once('config.php');
	//định nghĩa số bản ghi trên 1 trang
    $results_per_page = 10;
	$query = "select *from users";  
    $result = mysqli_query($conn, $query);  
    $number_of_result = mysqli_num_rows($result);  
	//Tổng số trang tất cả
    $number_of_page = ceil ($number_of_result / $results_per_page);
	 //xác định người dùng đang truy cập vào trang số mấy 
	 if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  
	//xác định số limit cho kết quả hiển thị 
	  $page_first_result = ($page-1) * $results_per_page;
	   //Lấy kq từ DB
	   $query = "SELECT * FROM users LIMIT " . $page_first_result . ',' . $results_per_page;  
	   $results = mysqli_query($conn, $query);
	if(isset($_POST["Logout"])) {
		session_destroy();
		header("location:login.php");
		exit;
	}
?> 
<h1 style="text-align: center;">Danh Sách Nhân Viên</h1>
	<form action="" method="POST">
		<button style="float: right;" class="btn btn-primary" name="Logout">出口(Logout)</button>
	</form>
<table class="table">
<?php if (isset($_SESSION["success"])) { ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION["success"];  ?>
            </div>
        <?php } ?>
	<thead>
		<tr>
            <th>ID</th>
            <th>Email</th>
			<th>Address</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($results)) { ?>
  
		<tr>
			<td><?php echo $row['id']; ?></td>
            <td><?php echo $row['email']; ?></td>
			<td><?php echo $row['address_house']; ?></td>
			<td>
				<a href="update.php?id=<?php echo $row['id']; ?>" class="edit_btn btn btn-primary" >Edit</a>
			</td>
			<td>
				<a href="delete.php?id=<?php echo $row['id']; ?>" name="btnDelete" class="del_btn btn btn-danger" onclick="return confirm('Are you sure want to delete this item???')">Delete</a>
			</td>
		</tr>
	<?php } ?>

	<?php 
		 for($page = 1; $page<= $number_of_page; $page++) {  
		echo '<a href = "index.php?page=' . $page . '">' . $page . ' </a>';  
		}  ?>
</table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php unset($_SESSION["success"]);?>