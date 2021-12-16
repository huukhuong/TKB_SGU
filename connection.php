<?php

    define('HOST', 'localhost');
    define('USERNAME', 'huukhuon_root');
    define('PASSWORD', '25102001k');
    define('DATABASE', 'huukhuon_tkb');

    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, "utf8");