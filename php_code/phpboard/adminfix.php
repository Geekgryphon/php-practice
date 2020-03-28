<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
session_start();

if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"] == "")){
    header("Location: index.php");
}

if(isset($_POST["action"]) && ($_POST["action"] == "update")) {
    $query_update = "UPDATE board SET ";
    $query_update .= " boardname = '" . $_POST["boardname"] . "',";
    $query_update .= " boardsex = '" . $_POST["boardsex"] . "',";
    $query_update .= " boardsubject '" . $_POST["boardsubject"] . "',";
    $query_update .= " boardmail = '" . $_POST["boardmail"] . "',";
    $query_update .= " boardweb = '" . $_POST["boardweb"] . "',";
    $query_update .= " boardcontent '" . $_POST["boardcontent"] . "' ";
    $query_update .= " WHERE boardid = " .$_POST["boardid"];
    mysqli_query($query_update);
    header("Location: admin.php");
}

$query_RecBoard = " SELECT * from board WHERE boardid = " . $_GET["id"];
$RecBoard = mysqli_query($query_RecBoard);
$row_RecBoard = mysql_fetch_assoc($RecBoard);
?>


<html>
    <head>
        <title>訪客留言版管理系統</title>
        <meta http-equiv="Content-Type" content="text/html"; charset=utf-8>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body bgcolor="#ffffff">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table align="left" boarder="0" cellpadding="0" cellspacing="0" width="700">
                        <tr>
                            <td><img src="admin_r1_c1.jpg" name="admin_r1_c1" width="465" height="36" border="0" alt=""></td>
                            <td width="15"><img src="admin_r1_c8.jpg" name="admin_r1_c8" width="15" height="36" border="0" alt=""></td>
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
                        <form action="" method="post" name="form1" >
                            <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
                                <tr valign="top">
                                    <td colspan="2" class="heading">更新訪客留言版資料</td>
                                </tr>
                                <tr valign="top">
                                    <td>
                                        <p>標題<input type="text" name="boardsubject" id="boardsubject" value="<?php echo $row_RecBoard["boardsubejct"]?>"></p>
                                        <p>姓名<input type="text" name="boardname" id="boardname" value="<?php echo $row_RecBoard["boardname"]?>"></p>
                                        <p>性別
                                            <input type="radio" name="boardsex" id="radio" value="男" <?php if($row_R_RecBoard["boardsex"] == "男") {echo "checked";} ?>>
                                            <input type="radio" name="boardsex" id="radio2" value="女" <?php if($row_R_RecBoard["boardsex"] == "女") {echo "checked";} ?>>
                                        </p>
                                        <p>郵件<input type="text" name="boardmail" id="boardmail" value="<?php echo $row_RecBoard["boardmail"]?>"></p>
                                        <p>網站<input type="text" name="boardweb" id="boardweb" value="<?php echo $row_RecBoard["boardweb"]?>"></p>
                                    </td>
                                    <td align="right">
                                        <p><textarea name="boardcontent" id="boardcontent" cols="40" rows="10"></textarea></p>
                                        <p>
                                            <input type="hidden" id="boardid" value="<?php echo $row_RecBoard["boardid"]; ?>" name="boardid">
                                            <input type="hidden" name="action" id="action" value="update">
                                            <input type="submit" name="button" id="button" value="更新資料">
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
                            <td width="15"><img src="images/admin_r4_c1.jpg" name="admin_r4_c1" alt="" width="15" height="31" border="0"></td>
                            <td background="images/bothg.jpg"><a href="?logout=true"><img src="images/logout.jpg" name="admin_r4_c2" alt="登出管理" width="77" height="31" border="0"></a></td>
                            <td align="right" valign="top" background="images/botbg.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved.</td>
                            <td width="15"><img src="images/admin_r4_c8.jpg" name="admin_r4_c8" alt="" width="15" height="31" border="0"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>