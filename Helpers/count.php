<?php 
    require_once './Helpers/connection.php';
    
    // $file = "bodem.log";
    // $act = fopen ($file, "r");
    // $dem = fread ($act, filesize ($file) );
    // fclose ($act);
    // $dem++;
    // $act = fopen ($file, "w");
    // fwrite ($act, $dem);
    // fclose ($act);

    $sql = "UPDATE `count` SET `countNum`=`countNum`+1 WHERE `pageName`='schedule'";
    $query = mysqli_query($conn, $sql);
    
?>