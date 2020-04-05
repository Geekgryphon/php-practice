<?php
  header("Content-Type: text/html; charset=utf-8");
  require_once('connMysql.php');
  session_start();

  if(isset($_SEESION["loginMember"]) && ($_SESSION["loginMember"] != "")) {
   header("Location: index.php");
  }

  if($_SESSION["memberLevel"] == "member") {
   header("Location: member_center.php");
  }

  if(isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
      unset($_SESSION["loginMember"]);
      unset($_SESSION["memberLevel"]);
      header("Location: index.php");
  }

  if(isset($_GET["action"]) && ($_GET["action"]=="delete")) {
      $query_delMember = "DELETE FROM memberdata WHERE m_id =".$_GET["id"];
      mysqli_query($link,$query_delMember);
      header("Location: member_admin.php");
  }

  $query_RecAdmin = "SELECT * FROM memberdata WHERE m_username='". $_SEESION["loginMember"] . "'";
  $RecAdmin = mysqli_query($link,$query_RecAdmin);
  $row_RecAdmin = mysqli_fetch_assoc($RecAdmin);

  $pageRow _records = 5;
  $num_pages = 1;

  if(isset($_GET['page'])) {
      $num_pages = $_GET['page'];
  }

  $startRow_records = ($num_pages - 1) * $pageRow_records;
  $query_RecMember = "SELECT * FROM memberdata WHERE m_level <> 'admin' ORDER BY m_jointime DESC ";
  $query_limit_RecMember = $query_RecMember." LIMIT ". $startRow_records . ", ".$pageRow_records;
    
  $RecMember = mysqli_query($link, $query_limit_RecMember);
  $all_RecMember = mysqli_query($link,$query_RecMember);
  $total_records = mysqli_num_rows($link,$all_RecMember);
  $total_pages = ceil($total_records/$pageRow_records);
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>網站會員系統</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script language="javascript">
            function deletesure() {
                if(confirm('\n您確定要刪除這個會員嗎?\n刪除後無法恢復!\n')) return true;
                return false;
            }
        </script>
    </head>
    <body>
        <table width="780" border="0" align="center" cellpadding="4" cellspacing="0">
            <tr>
                <td class="tdbline"><img src="images/mlogo.png" alt="會員系統" width="164" height="67"></td>
            </tr>
            <tr>
                <td class="tdbline">
                    <table width="100%" border="0" cellspacing="0" cellpadding="10">
                       <tr valign="top">
                          <td class="tdrline"><p class="title">會員資料列表</p>
                           <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#F0F0F0">
                             <tr>
                               <th width="10%" bgcolor="#CCCCCC">&nbsp;</th>
                               <th width="20%" bgcolor="#CCCCCC">姓名</th>
                               <th width="20%" bgcolor="#CCCCCC">帳號</th>
                               <th width="20%" bgcolor="#CCCCCC">加上時間</th>
                               <th width="20%" bgcolor="#CCCCCC">上次登入</th>
                               <th width="10%" bgcolor="#CCCCCC">登入</th>
                             </tr>
                             <?php while($row_RecMember=mysqli_fetch_assoc($RecMember)) { ?>
                             <tr>
                               <td width="10%" align="center" bgcolor="#FFFFFF"><p><a href="member_adminupdate.php?id=<?php echo $row_RecMember["m_id"]; ?>">修改</a><br><a href="?action=delete&id=<?php echo $row_RecMember["m_id"];?>" onClick="return deletesure();">刪除</a></p></td>
                               <td width="20%" align="center" bgcolor="#FFFFFF"><p><?php echo $row_RecMember["m_name"]; ?></p></td>
                               <td width="20%" align="center" bgcolor="#FFFFFF"><p><?php echo $row_RecMember["m_username"]; ?></p></td>
                               <td width="20%" align="center" bgcolor="#FFFFFF"><p><?php echo $row_RecMember["m_jointime"]; ?></p></td>
                               <td width="20%" align="center" bgcolor="#FFFFFF"><p><?php echo $row_RecMember["m_logintime"]; ?></p></td>
                               <td width="10%" align="center" bgcolor="#FFFFFF"><p><?php echo $row_RecMember["m_login"]; ?></p></td>
                             </tr>
                             <?php }?> 
                          </table>
                          <hr size="1" />
                          <table width="98%" border="0" align="center" cellpadding="4" cellspacing="0">
                              <tr>
                                <td valign="middle"><p>資料筆數:<?php echo $total_records; ?></p></td>
                                <td align="right">
                                    <p>
                                        <?php if($num_pages > 1) { ?>
                                        <a href="?page=1">第一頁</a> | <a href="?page=<?php echo $num_pages-1; ?>">上一頁</a> |
                                        <?php } ?> 
                                        <?php if($num_pages < $total_pages) { ?>
                                        <a href="?page=<?php echo $num_pages+1;?>">下一頁</a> | <a href="?page=<?php echo $total_pages; ?>">最末頁</a>
                                        <?php } ?>
                                    </p>
                                </td>
                              </tr>
                         </table>
                            <p>&nbsp;</p>
                          </td>
                           <td width="200">
                               <div class="boxtl"></div>
                               <div class="boxtr"></div>
                               <div class="regbox">
                                   <p class="heading"><strong>會員系統</strong></p>
                                   <p><strong><?php echo $row_RecAdmin["m_name"];?></strong>您好。<br>
                                   本次登入的時間為<br>
                                   <?php echo $row_RecAdmin["m_logintime"];?>
                                   </p>
                                   <p align="center"><a href="member_adminupdate.php?id=<?php echo $row_RecAdmin["m_id"];?>">修改資料</a> | 
                                   <a href="?logout=true">登出系統</a>
                                   </p>
                               </div>
                                <div class="boxbl"></div>
                                <div class="boxbr"></div>
                           </td>
                       </tr>
                    </table>
                </td>
            </tr>
            <tr>
              <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved.
            </td>
          </tr>
        </table>
    </body>
</html>