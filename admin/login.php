<?php
session_start();
if (isset($_SESSION['login'])) {
	header('location: ./');
}
if ($_POST['username']) {
	require_once '../Helpers/connection.php';

	$username = $_POST['username'];
  	$password = $_POST['password'];
  	$password = md5($password);
  	$sql = "SELECT * FROM `accounts` WHERE `username`='$username' AND `password`='$password'";
  	$query = mysqli_query($conn, $sql);
	$number_of_result = mysqli_num_rows($query);
  	echo $number_of_result;
  	if ($number_of_result > 0) {
      	header('location: ./');
    	$_SESSION['login'] = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>
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
		<div class="row pt-5 justify-content-center">
			<div class="col-md-6 col-12 p-3 bg-white">
				<form method="POST">
                  <div class="form-group">
                      <label for="email1">Username</label>
                      <input class="form-control" id="username" name="username" placeholder="Enter username">
                  </div>
                  <div class="form-group">
                      <label for="password">Password</label>
                      <input class="form-control" id="password" name="password" placeholder="Enter password" type="password">
                  </div>
                  <input type="submit" value='login' class="btn btn-primary" />
               </form>
			</div>
		</div>
	</div>
</body