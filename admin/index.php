<?php
session_start();
if (!isset($_SESSION['login'])) {
	header('location: ./login.php');
}
require_once '../Helpers/connection.php';

if (isset($_POST)) {
	$type = $_POST['type'];
  	if ($type == 'notification') {
      	$warning = $_POST['notiWarning'];
      	$danger = $_POST['notiDanger'];
      	$success = $_POST['notiSuccess'];
		$showWarning = $_POST['showWarning'] ? 1 : 0;
		$showDanger = $_POST['showDanger'] ? 1 : 0;
		$showSuccess = $_POST['showSuccess'] ? 1 : 0;
      	$extend = $_POST['extend'];
      	$sql = "UPDATE `notifications` SET 
        	`warning`='$warning', 
            `danger`='$danger', 
            `success`='$success', 
            `extend`='$extend', 
            `showDanger`=$showDanger, 
            `showWarning`=$showWarning, 
            `showSuccess`=$showSuccess";
//      	echo $sql;	
      	$query = mysqli_query($conn, $sql);
    }
  	elseif ($type == 'block') {
      $id = $_POST['id'];
      $sql = "INSERT INTO `blocks` VALUE($id, null)";
      $query = mysqli_query($conn, $sql);
    } elseif ($type == 'maintain') {
      $maintain = $_POST['maintain'] ? 1 : 0;
      $sql = "UPDATE `notifications` SET `maintain`=$maintain";
      mysqli_query($conn, $sql);
    }
}
$sql = "SELECT * FROM `notifications`";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
$maintain = $row['maintain'];
$warning = $row['warning'];
$danger = $row['danger'];
$success = $row['success'];
$extend = $row['extend'];
$showWarning = $row['showWarning'];
$showDanger = $row['showDanger'];
$showSuccess = $row['showSuccess'];

$sql = "SELECT blocks.id, students.name, blocks.time FROM blocks LEFT JOIN students ON blocks.id = students.id ORDER BY time DESC";
$query = mysqli_query($conn, $sql);
$blocks = array();
while($row = mysqli_fetch_assoc($query)) {
  $blocks[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
    <link rel="apple-touch-icon" sizes="57x57" href="./img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">
    <link rel="manifest" href="./img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
  
<body class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-12 bg-white my-5 p-5">
      	<h1 class="text-center">Quản lý bảo trì</h1>
        <form method="POST">
          <div class="custom-control custom-switch">
            <input type="hidden" name="type" value="maintain" />
            <input type="checkbox" class="custom-control-input" id="maintain" name="maintain" <?=$maintain ? 'checked' : ''?>>
            <label class="custom-control-label" for="maintain">Chế độ bảo trì</label>
          </div>
          <input type="submit" value="Lưu thay đổi" class="btn btn-primary mt-2"/>
        </form>
      </div>
      
      <div class="col-12 bg-white my-5 p-5">
        <h1 class="text-center">Quản lý block id</h1>
        <form method="POST">
          <input type="hidden" value="block" name="type" />
          <div class="form-group">
            <label>Block id</label>
    		<input class="form-control" name="id" required />
          </div>
          <input type="submit" class="btn btn-primary" value="Thêm id" />
        </form>
        <div style="overflow: auto;">
        <table class="table mt-2">
          <thead>
            <tr>
              <th>ID</th>
              <th scope="col">Họ tên</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              
  				foreach($blocks as $value) {
            ?>
              <tr>
                <td><?=$value['id']?></td>
                <th scope="row" style="min-width: 200px"><?=$value['name']?></th>
                <td style="min-width: 120px"><a class="btn btn-warning" href="./unBlock.php?id=<?=$value['id']?>">Gỡ block</a></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
          </div>
      </div>
      
       <div class="col-12 bg-white my-5 p-5">
        <h1 class="text-center">Quản lý thông báo</h1>
        <form method="POST">
          <input type="hidden" value="notification" name="type" />
          <div class="form-group">
            <label>Warning</label> <br />
            <input type="checkbox" name="showWarning" id="showWarning" <?=$showWarning ? 'checked' : ''?> />
            <label for="showWarning">Hiển thị</label>
    		<textarea class="form-control" name="notiWarning" rows="5"><?=$warning?></textarea>
          </div>
          
          <div class="form-group">
            <label>Danger</label> <br />
            <input type="checkbox" name="showDanger" id="showDanger" <?=$showDanger ? 'checked' : ''?> />
            <label for="showDanger">Hiển thị</label>
    		<textarea class="form-control" name="notiDanger" rows="5"><?=$danger?></textarea>
          </div>
          
          <div class="form-group">
            <label>Success</label> <br />
            <input type="checkbox" name="showSuccess" id="showSuccess" <?=$showSuccess ? 'checked' : ''?> />
            <label for="showSuccess">Hiển thị</label>
    		<textarea class="form-control" name="notiSuccess" rows="5"><?=$success?></textarea>
          </div>
          
          <div class="form-group">
            <label>Thông tin thêm</label> <br />
    		<textarea class="form-control" name="extend" rows="5" required><?=$extend?></textarea>
          </div>
          
          <input type="submit" class="btn btn-primary" value="Lưu" />
        </form>
      </div>
      
    </div>
  </div>
</body>