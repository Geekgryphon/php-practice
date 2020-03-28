<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
if(isset($_POST["action"]) && ($_POST["action"] == "add")) {
    $query_insert = "INSERT INTO board (boardname, boardsex, boardsubject, boardtime, boardmail, boardweb, boardcontent) values ( ";
    $query_insert .= "'" . $_POST["boardname"] . "',";
    $query_insert .= "'" . $_POST["boardsex"] . "',";
    $query_insert .= "'" . $_POST["boardsubject"] . "',";
    $query_insert .= "NOW(),";
    $query_insert .= "'" . $_POST["boardmail"] . "',";
    $query_insert .= "'" . $_POST["boardweb"] . "',";
    $query_insert .= "'" . $_POST["boardcontent"] . "',";
    mysqli_query($query_insert);
    header("Location: index.php");
}
?>
<html>
    <head>
        <title>訪客留言版</title>
        <meta http-equiv="Content-Type" content="text/html"; charset=utf-8>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script languate="javascript">
            function checkForm() {
                if(document.dormPost.boardsubject.value=""){
                    alert("請填寫標寫!");
                    document.formPost.boardsubject.focus();
                    return false:
                }

                if(document.formPost.boardname.value==""){
                    alert("請填寫姓名");
                    document.formPost.boardname.focus();
                    return false;
                }

                if(document.formPost.boardmail.value!=""){
                    if(!checkmail(document.formPost.boardmail)){
                        document.formPost.boardmail.focus();
                        return false;
                    }    
                }

                if(document.formPost.boardcontent.value=="") {
                    alert("請填寫留言內容!");
                    document.formPost.boardcontent.focus();
                    return false;
                }

                return confirm('確定送出嗎?');
            }
            
            function checkmail(myEmail){
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.) + ([a-zA-Z0-9]{2,4})+$/;
                if(filter.test(myEmail.value)){
                    return true;
                }
            }
        </script>
    </head>
    <body bgcolor="#ffffff">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table align="left" boarder="0" cellpadding="0" cellspacing="0" width="700">
                        <tr>
                            <td><img src="board_r1_c1.jpg" name="board_r1_c1" width="465" height="36" border="0" alt=""></td>
                            <td><a href="index.php"><img src="images/read.jpg" name="board_r1_c5" width="100" height="36" border="0" alt="瀏覽留言"></a></td>
                            <td><a href="post.php"><img src="images/post.jpg" name="board_r1_c7" width="100" height="36" border="0" alt="我要留言"></a></td>
                            <td width="15"><img src="board_r1_c8.jpg" name="board_r1_c8" width="15" height="36" border="0" alt=""></td>
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
                        <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
                            <table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
                                <tr valign="top">
                                    <td width="80" align="center"><img src="images/talk.gif" alt="我要留言" width="80" height="80"><span class="heading">留言</span></td>
                                    <td>
                                        <p>標題<input type="text" name="boardsubject" id="boardsubject"></p>
                                        <p>姓名<input type="text" name="boardname" id="boardname"></p>
                                        <p>性別
                                            <input type="radio" name="boardsex" id="radio" value="男" checked>
                                            <input type="radio" name="boardsex" id="radio2" value="女">
                                        </p>
                                        <p>郵件<input type="text" name="boardmail" id="boardmail"></p>
                                        <p>網站<input type="text" name="boardweb" id="boardweb"></p>
                                    </td>
                                    <td align="right">
                                        <p><textarea name="boardcontent" id="boardcontent" cols="40" rows="10"></textarea></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td colspan="3" align="center" valign="middle">
                                        <input type="hidden" id="action" value="add" name="action">
                                        <input type="submit" name="button" id="button" value="送出留言">
                                        <input type="reset" name="button2" id="button2" value="重設資料">
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
                            <td width="15"><img src="images/board_r4_c1.jpg" name="board_r4_c1" alt="" width="15" height="31" border="0"></td>
                            <td background="images/bothg.jpg"><a href="login.php"><img src="images/login.jpg" name="board_r4_c2" alt="登入管理" width="77" height="31" border="0"></a></td>
                            <td align="right" valign="top" background="images/botbg.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved.</td>
                            <td width="15"><img src="images/board_r4_c8.jpg" name="board_r4_c8" alt="" width="15" height="31" border="0"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>