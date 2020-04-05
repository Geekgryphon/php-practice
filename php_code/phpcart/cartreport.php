<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
if(isset($_POST["customername"]) && ($_POST["customername"] != "")) {
    require_once("mycart.php");
    session_start();
    $cart =& $_SESSION['cart'];
    if(!is_object($cart)) $cart = new myCart();
    
    $sql_query = "INSERT INTO order (total, deliverfee, grandtotal, customername, customeremail, customeraddress, customerphone, paytype ) VALUES (";
    $sql_query .= $cart->total.",";
    $sql_query .= $cart->grandtotal.",";
    $sql_query .= "'" . $_POST["customername"] . "',";
    $sql_query .= "'" . $_POST["customeremail"] . "',";
    $sql_query .= "'" . $_POST["customeraddress"] . "',";
    $sql_query .= "'" . $_POST["customerphone"] . "',";
    $sql_query .= "'" . $_POST["paytype"] . "')";
    mysqli_query($link,$sql_query);
    
    $o_pid = mysqli_insert_id();
    
    if($cart->itemcount > 0) {
        foreach($cart->get_contents() as $item) {
            $sql_query=" INSERT INTO orderdetail (orderid, productid, productname, unitprice, quantity) VALUES (";
            $sql_query .= $o_pid.",";
            $sql_query .= "'" . $item['info']."',";
            $sql_query .= $item['price'].",";
            $sql_query .= $item['qty'] .")";
            mysqli_query($link,$sql_query)
        }
    }
    
    $cname = $_POST["cusomername"];
    $cmail = $_POST["customeremail"];
    $ctel = $_POST["customerphone"];
    $caddress = $_POST["customeraddress"];
    $cpaytype = $_POST["paytype"];
    $total = $cart->grandtotal;
    $mailcontent = <<<msg
	親愛的 $cname 您好：
	感謝您的光臨
	本次消費詳細資料如下：
	--------------------------------------------------
	訂單編號： $o_pid 
	客戶姓名：$cname 
	電子郵件： $cmail 
	電話： $ctel 
	住址： $caddress 
	付款方式： $cpaytype 
	消費金額：	$total 
	--------------------------------------------------
	希望能再次為您服務 
	
	網路購物公司 敬上
msg;
    $mailFor="=?UTF-8?B?" . base64_encode("網路購物系統") . "?= <service@e-happ.com.tw>";
    $mailto = $_POST["customeremail"];
    $mailSubject="=?UTF-8?B?" . base64_encode("網路購物系統訂單通知") . "?=";
    $mailHeader = "From:" . $mailForm. "\r\n";
    $mailHeader.="Content-type:text/html; charset=UTF-8";
    if(!@mail($mailto,$mailSubject,nl2br($mailcontent),$mailHeader)) die("郵寄失敗!");
     $cart->empty_cart();
    
}
?>
<script language="javascript">
    alert("感謝您的購買，我們將盡快進行處理。");
    window.location.href="index.php";
</script>