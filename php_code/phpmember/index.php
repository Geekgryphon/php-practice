<?php
  header("Content-Type: text/html; charset=utf-8");
  require_once('connMysql.php');
  session_start();
  if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")) {
      if($_SESSION["memberLevel"] == "member") {
          header("Location: member_center.php");
      }else{
          header("Location: member_admin.php");
      }
  }

  if(isset($_POST["username"]) && isset($_POST["passwd"])) {
      $query_RecLogin = " SELECT * FROM memberdata WHERE m_username = '" . $_POST["username"] . "'";
      $RecLogin = mysql_query($link,$query_RecLogin);
      $row_RecLogin = mysqli_fetch_assoc($RecLogin);
      $usernaem = $row_RecLogin["m_username"];
      $passwd = $row_ReLogin["m_username"];
      $level = $row_RecLogin["m_level"];
      
      if(md5($_POST["passwd"]) == $passwd){
          $query_RecLoginUpdate = "UPDATE memberdata set m_login = m_login+1, m_logintime = NOW() WHERE m_username = '" . $_POST["username"] . "'";
          mysqli_query($link,$query_RecLoginUpdate);
          $_SEESION["loginMember"] = $username;
          $_SESSION["memberLevel"] = $level;
          if(isset($_POST["rememberme"]) && ($_POST["rememberme"] == "ture")) {
              setcookie("remUser",$_POST["username"], time() + 365*24*60);
              setcookie("remPass", $_POST["passwd"], time()+365*24*60);
          }else{
              if(isset($_COOKIE["remUser"])) {
                 setcookie("remUser",$_POST["username"], time() - 100);
                 setcookie("remPass", $_POST["passwd"], time() - 100);
              }
          }
          if($_SESSION["memberLevel"] == "member"){
              header("Location: member_center.php");
          }
          else{
              header("Location: member_admin.php");
          }
      }else{
          header("Location: index.php?errMsg=1");
      }
  }
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>網站會員系統</title>
        <link rel="stylesheet" href="style.css" type="text/css">
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
                           <td class="tdrline">
                               <p class="title">歡迎光臨網站會員系統</p>
                               <p>感謝各位來到會員系統，所有的會員功能都必須經由登入後才能使用，請您在右方視窗中執行登入動作。</p>
                               <p class="heading">本會員系統擁有以下的功能:</p>
                               <ol>
                                   <li>免費加入會員。</li>
                                   <li>每個會員可修改本身資料。</li>
                                   <li>若是遺忘密碼，會員可由系統發出電子信函通知。</li>
                                   <li>管理者可以修改、刪除會員的資料。</li>
                               </ol>
                               <p class="heading">請各位會員遵守以下規則： </p>
                               <ol>
                                 <li> 遵守政府的各項有關法律法規。</li>
                                 <li> 不得在發佈任何色情非法， 以及危害國家安全的言論。</li>
                                 <li>嚴禁連結有關政治， 色情， 宗教， 迷信等違法訊息。</li>
                                 <li> 承擔一切因您的行為而直接或間接導致的民事或刑事法律責任。</li>
                                 <li> 互相尊重， 遵守互聯網絡道德；嚴禁互相惡意攻擊， 漫罵。</li>
                                 <li> 管理員擁有一切管理權力。</li>
                               </ol>
                           </td>
                            <td width="200">
                                <div class="boxtl"></div>
                                <div class="boxtr"></div>
                                <div class="regbox">
                                    <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"] == "1")) { ?>
                                    <div class="errDiv">登入帳號或密碼錯誤!</div>
                                    <?php } ?>
                                    <p class="heading">登入會員系統</p>
                                    <form name="form1" method="post" action="">
                                        <p>
                                            帳號:<br>
                                            <input type="text" name="username" class="logintextbox" id="username" value="<?php if(isset($_COOKIE["remUser"])) {echo $_COOKIE["remUser"];} ?>">
                                        </p>
                                        <p>
                                            密碼:<br>
                                            <input type="text" name="usernpasswdame" class="logintextbox" id="passwd" value="<?php if(isset($_COOKIE["remPass"])) {echo $_COOKIE["remPass"];} ?>">
                                        </p>
                                        <p align="cnter">
                                            <input type="submit" name="button" id="button" value="登入系統">
                                        </p>
                                    </form>
                                    <p align="center"><a href="admin_passmail.php">忘記密碼，補寄密碼信。</a></p>
                                    <hr size="1" />
                                    <p class="heading">還沒有會員帳號?</p>
                                    <p>註冊帳號免費又容易</p>
                                    <p align="right"><a href="member_join.php">馬上申請會員</a></p>
                                </div>
                                <div class="boxbl"></div>
                                <div class="boxbr"></div>
                            </td>
                       </tr>
                   </table>
               </td> 
            </tr>
            <tr>
                 <td align="center" background="images/album_r2_c1.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved.</td>
            </tr>
        </table>
    </body>
</html>