<?php
if (isset($_GET['id'])) {
  	$id = $_GET['id'];
	require_once '../Helpers/connection.php';
  	$sql = "DELETE FROM `blocks` WHERE `id`='$id'";
 	mysqli_query($conn, $sql);
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
?>