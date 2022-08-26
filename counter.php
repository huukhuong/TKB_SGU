<?php
  require_once './Helpers/connection.php';

  $sql = "SELECT * FROM `count` WHERE `pageName`='schedule'";
  $query = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($query);

  echo '{"visitCount": ' . $row['countNum'] . '}';
?>