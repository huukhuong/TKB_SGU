<?php

    define('HOST', 'localhost');
    define('USERNAME', '');
    define('PASSWORD', '');
    define('DATABASE', '');

    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, "utf8");
