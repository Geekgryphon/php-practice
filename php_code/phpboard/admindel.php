<?php
    header("Content-Type: text/html; charset=utf-8");
    require_once("connMysql.php");
    session_start();
    if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"] == "")){
       header("Location: index.php");
    }

    if(isset($_GET["logout"]) && ($_GET["logout"] == "true")){
        unset($_SESSION["loginMember"]);
        header("Location: index.php");
    }

    if(isset($_POST["action"]) && ($_POST["action"] == "delete")) {
        $sql_query = "DELETE FROM board WHERE boardid = " . $_POST["boardid"];
        header("Location: admin.php");
    }

    $query_RecBoard = "SELECT * FROM board WHERE boardid = " . $_GET["id"];
    $RecBoard = mysqli_query($query_RecBoard);
    $row_RecBoard=mysqli_fetch_assoc($RecBoard);
?>


<html>
    <head>
        <title>訪客留言版管理系統</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body bgcolor="#ffffff">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="700">
                        <tr>
                            <td><img background="images/admin_topbg.jpg" src="images/admin_r1_c1.jpg" name="admin_r1_c1" width="465" height="36" border="0" alt=""></td>
                            <td width="15"><img src="images/admin_r1_c8.jpg" name="admin_r1_c8" width="15" height="36" border="0" alt=""></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><img src="images/admin_r2_c1.jpg" name="admin_r2_c1" width="700" height="28" border="0" alt=""></td>
            </tr>
            <tr>
                <td background="images/admin_r3_c1.jpg">
                    <div id="mainRegion">
                        <form action="" name="form1" method="post">
                            <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
                                <tr valign="top">
                                    <td class="heading">刪除訪客留言版資料</td>
                                </tr>
                                <tr valign="top">
                                    <td>
                                        <p>
                                            <strong>標題</strong>:<?php echo $row_RecBoard["boardsubject"]; ?>
                                            <strong>姓名</strong>:<?php echo $row_RecBoard["boardname"]; ?>
                                            <strong>標題</strong>:<?php echo $row_RecBoard["boardsex"]; ?>
                                        </p>
                                        <p>
                                            <strong>郵件</strong>:<?php echo $row_RecBoard["boardmail"]; ?>
                                            <strong>網站</strong>:<?php echo $row_RecBoard["boardweb"]; ?>
                                        </p>
                                        <p><?php echo nl2br($row_RecBoard["boardcontent"]);?></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td align="center">
                                        <input type="hidden" name="boardid" id="boardid" value="<?php echo $row_RecBoard["boardid"]; ?>">
                                        <input type="hidden" name="action" id="action" value="delete">
                                        <input type="submit" name="button" id="button" value="確定刪除資料">
                                        <input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();">
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
                            <td width="15"><img src="images/admin_r4_c1.jpg" name="admin_r4_c1" width="15" height="31" border="0" alt=""></td>
                            <td background="images/botbg.jpg"><a href="?logout=true"><img src="images/logout.jpg" name="admin_r4_c2" width="77" height="31" border="0" alt="登出管理"></a></td>
                            <td align="right" valign="top" background="images/botbg.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved. </td>
                            <td width="15"><img src="images/admin_r4_c8.jpg" name="admin_r4_c8" width="15" height="31" border="0" alt=""></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>