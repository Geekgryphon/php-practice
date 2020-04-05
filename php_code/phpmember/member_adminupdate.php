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

  $redirectUrl = "member_center.php";
  if(isset($_POST["action"]) && ($_POST["action"] == "updaet")) {
      $query_update = "UPDATE memberdata SET ";
      if(($_POST["m_passwd"] != "") && ($_POST["m_passwd"] == $_POST["m_passwdrecheck"])) {
          $query_update .= " m_passwd '" . md5($_POST["m_passed"]) . "',";
      }
      $query_update .= " m_name = '" . $_POST["m_name"] "',";
      $query_update .= " m_sex = '" . $_POST["m_sex"] "',";
      $query_update .= " m_birthday = '" . $_POST["m_birthday"] "',";
      $query_update .= " m_email = '" . $_POST["m_email"] "',";
      $query_update .= " m_url = '" . $_POST["m_url"] "',";
      $query_update .= " m_phone = '" . $_POST["m_phone"] "',";
      $query_update .= " m_address = '" . $_POST["m_address"] "',";
      $query_update .= " WHERE m_id = " . $_POST["m_id"];
      mysqli_query($link,$query_update);
      header("Location: member_admin.php");
  }

    $query_RecAdmin = " SELECT * FROM memberdata WHERE m_username ='" . $_SESSION["loginMember"] . "'";
    $RecAdmin = mysqli_query($link,$query_RecAdmin);
    $row_RecAdmin = mysqli_fetch_assoc($link,$query_RecAdmin);

    $query_RecMember = " SELECT * FROM memberdata WHERE m_id ='" . $_GET["id"] . "'";
    $RecMember = mysqli_query($link, $query_RecMember);
    $row_RecMember = mysqli_fetch_assoc($link,$RecMember);

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>網站會員系統</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script language="javascript">
           function checkForm(){
               if(document.forJoin.m_passwd.value != "" || document.formJoin.m_passwdrecheck.value != "" ) {
                   if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdcheck.value)){
                       document.formJoin.m_passwd.focus();
                       return false;
                   }
               }
               
               if(document.formJoin.m_name.value=="") {
                   alert("請填寫姓名!");
                   document.formJoin.m_name.focus();
                   return false;
               }
               
               if(document.formJoin.m_birthday.value=="") {
                   alert("請填寫生日!");
                   return false;
               }
               
               if(document.formJoin.m_email.value=="") {
                   alert("請填寫電子郵件!");
                   document.formJoin.m_email.focus();
                   return false;
               }
               
               if(!checkmail(document.formJoin.m_email)){
                   document.formJoin.m_email.focus();
                   return false;
               }
               
               return confirm("確定送出嗎?");
           }
            
            function check_passwd(pw1,pw2) {
                if(pw1) {
                    alert("密碼不可以空白!");
                    return false;
                }
                
                for (var idx=0;idx<pw1.length;idx++){
                    if(pw1.charAt(idx) == '' || pw1.charAt(idx) == '\"') {
                        alert("密碼不可以含有空白或雙引號!\n");
                        return false;
                    }
                    if(pw1.length<5 || pw1.length>10) {
                        alert("密碼長度只能5到10個字母!\n");
                        return false;
                    }
                    if(pw1!=pw2) {
                        alert("密碼二次輸入不一樣,請重新輸入!\n");
                        return false;
                    }
                }
                
                return true;
            }
            
            function checkmail(myEmail){
                var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(filter.test(myEmail.value)) {
                    return true;
                }
                alert("電子郵件格式不正確");
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
                          <td class="tdrline">
                              <form action="" method="POST" name="formJoin" id="formJoin" onSubmit = "return checkForm();">
                                  <p class="title">修改資料</p>
                                  <div class="dataDiv">
                                      <p class="heading">帳號資料</p>
                                      <p>
                                          <strong>使用帳號</strong>:
                                          <?php echo $row_RecMember["m_username"];?>
                                      </p>
                                      <p>
                                          <strong>使用密碼</strong>:
                                          <input type="password" name="m_passwd" id="m_passwd" class="normalinput">
                                          <br>
                                      </p>
                                      <p>
                                          <strong>確認密碼</strong>:
                                          <input type="password" name="m_passwdrecheck" id="m_passwdrecheck" class="normalinput">
                                          <br>
                                          <span class="smalltext">若不修改密碼，請不要填寫。若要修改，請輸入密碼</span>
                                          <span class="smalltext">二次。<br></span>
                                      </p>
                                      <hr size="1" />
                                      <p class="heading">個人資料</p>
                                      <p><strong>真實姓名</strong>:
                                         <input type="text" name="m_name" class="normalinput" id="m_name" value="<?php echo $row_RecMember["m_name"]; ?>">
                                         <font color="#FF0000">*</font>
                                      </p>
                                      <p><strong>性   別</strong>:
                                         <input type="radio" name="m_sex" class="normalinput"  value="女" <?php if($row_RecMember["m_sex"]=="女") echo "checked"; ?>>女
                                         <input type="radio" name="m_sex" class="normalinput"  value="男" <?php if($row_RecMember["m_sex"]=="男") echo "checked"; ?>>男
                                         <font color="#FF0000">*</font>
                                      </p>
                                      <p><strong>生   日</strong>:
                                          <input type="text" name="m_birthday" class="normalinput" id="m_birthday" value="<?php echo $row_RecMember["m_birthday"]; ?>">
                                          <font color="#FF0000">*</font><br>
                                          <span class="smalltext">為西元格式(YYYY-MM-DD)。</span>
                                      </p>
                                      <p><strong>電子郵件</strong>:
                                          <input type="text" name="m_email" class="normalinput" id="m_email" value="<?php echo $row_RecMember["m_email"]; ?>">
                                          <font color="#FF0000">*</font><br>
                                      </p>
                                      <p><strong>個人網頁</strong>:
                                          <input type="text" name="m_url" class="normalinput" id="m_url" value="<?php echo $row_RecMember["m_url"]; ?>"><br>
                                          <span class="smalltext">請以「http://」 為開頭。</span>
                                      </p>
                                      <p><strong>電   話</strong>:
                                          <input type="text" name="m_phone" class="normalinput" id="m_phone" value="<?php echo $row_RecMember["m_phone"]; ?>"><br>
                                      </p>
                                      <p><strong>地   址</strong>:
                                          <input type="text" name="m_address" class="normalinput" id="m_address" value="<?php echo $row_RecMember["m_address"]; ?>" size="40">
                                      </p>
                                      <p><font color="#FF0000">*</font>表示為必填的欄位</p>
                                  </div>
                                  <hr size="1" />
                                  <p align="center">
                                      <input type="hidden" name="m_id" id="m_id" value="<?php echo $row_RecMember["m_id"]; ?>">
                                      <input type="hidden" name="action" id="action" value="update">
                                      <input type="submit" name="Submit2" value="修改資料">
                                      <input type="reset" name="Submit3" value="重設資料">
                                      <input type="button" name="Submit" value="回上一頁" onClick="window.history.back();">
                                  </p>
                              </form>
                          </td>
                           <td width="200">
                               <div class="boxtl"></div>
                               <div class="boxtr"></div>
                               <div class="regbox">
                                   <p class="heading"><strong>會員系統</strong></p>
                                   <p><strong><?php echo $row_RecAdmin["m_name"];?></strong>您好。</p>
                                   <p> 本次登入的時間為:<br>
                                       <?php echo $row_RecAdmin["m_logintime"];?>
                                   </p>
                                   <p align="center"><a href="member_center.php">會員中心</a> | 
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