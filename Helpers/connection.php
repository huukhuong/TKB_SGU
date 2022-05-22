<?php

    define('HOST', 'localhost');
    define('USERNAME', 'byjwhotg_huukhuong');
    define('PASSWORD', '25102001k');
    define('DATABASE', 'byjwhotg_tkb');

    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, "utf8");