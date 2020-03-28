<?php
    $db_host = "localhost";
    $db_table = "phpboard";
    $db_username = "root";
    $db_password = "";

    $link = mysqli_connect($db_host,$db_username,$db_password,$db_table);

    if(!@$link)
        die("資料庫連接失敗!");
    if(!@mysqli_select_db($link,$db_table))
        die("資料庫選擇失敗");
    mysqli_query($link,"SET NAMES 'utf8' ");

?>