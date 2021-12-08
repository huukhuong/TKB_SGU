<?php 
    $file = "bodem.log";
    $act = fopen ($file, "r");
    $dem = fread ($act, filesize ($file) );
    fclose ($act);
    $dem++;
    $act = fopen ($file, "w");
    fwrite ($act, $dem);
    fclose ($act);
?>