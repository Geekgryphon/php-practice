<?php
    $db_host = "localhost";
    $db_table = "phpboard";
    $db_username = "root";
    $db_password = "";

    $link = mysqli_connect($db_host,$db_username,$db_password,$db_table);

    // @ Error Control Operators 之後產生的錯誤訊息會被忽略
    // =& 指定位址

    if(!@$link)
        die("資料庫連接失敗!");
    if(!@mysqli_select_db($link,$db_table))
        die("資料庫選擇失敗");
    mysqli_query($link,"SET NAMES 'utf8' ");

?>