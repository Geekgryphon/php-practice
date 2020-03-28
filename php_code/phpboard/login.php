<?php
    header("Content-Type: text/html; charset=utf-8");
    session_start();
    if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")){
        require_once("connMysql.php");
        $sql_query = " SELECT * FROM admin ";
        $result = mysqli_query($sql_query);
        $row_result=mysql_fetch_assoc($result);
        $username = $row_result['username'];
        $passwd = $row_result["passwd"];
        if(($_POST["username"]==$username) && ($_POST["passwd"] == $passwd)){
            $_SESSION["loginMember"] = $username;
            header("Location: admin.php");
        }else{
            header("Location: index.php");
        }
    }else{
        header("Location: admin.php");
    }
?>


<html>
    <head>
        <title>訪客留言版</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body bgcolor="#ffffff">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="700">
                        <tr>
                            <td><img src="images/board_r1_c1.jpg" name="board_r1_c1" width="465" height="36" border="0" alt=""></td>
                            <td><a href="index.php"><img src="images/read.jpg" name="board_r1_c5" width="110" height="36" border="0" alt="瀏覽留言"></a></td>
                            <td><a href="post.php"><img src="images/post.jpg" name="board_r1_c7" width="110" height="36" border="0" alt="我要留言"></a></td>
                            <td width="15"><img src="images/board_r1_c8.jpg" name="board_r1_c8" width="15" height="36" border="0" alt=""></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><img src="images/board_r2_c1.jpg" name="board_r2_c1" width="700" height="28" border="0" alt=""></td>
            </tr>
            <tr>
                <td background="images/board_r3_c1.jpg">
                    <div id="mainRegion">
                       <form action="" method="post" name="form1">
                        <table border="0" align="center" cellpadding="4" cellspacing="0">
                           <tr valign="top">
                              <td colspan="2" align="center" class="heading">登入管理</td>
                           </tr>
                           <tr valign="top">
                               <td width="80" align="center"><img src="images/login.gif" alt="我要留言" width="80" height="80"></td>
                               <td valign="middle">
                                  <p>管理帳號<input type="text" name="username" id="username"></p>
                                  <p>管理密碼<input type="password" name="passwd" id="passwd"></p>>
                                  <p align="center">
                                      <input type="submit" name="button" id="button" value="管理登入">
                                      <input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();">
                                  </p> 
                               </td>
                           </tr>
                        </table>
                       </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="700">
                        <tr>
                            <td width="15"><img src="images/board_r4_c1.jpg" name="board_r4_c1" width="15" height="31" border="0" alt=""></td>
                            <td align="center" valign="top" background="images/botbg.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved. </td>
                            <td width="15"><img src="images/board_r4_c8.jpg" name="board_r4_c8" width="15" height="31" border="0" alt=""></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>