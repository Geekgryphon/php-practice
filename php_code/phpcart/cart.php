<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
require_once("mycart.php");
session_start();

$cart =& $_SESSION['cart'];
if(!is_object($cart)) $cart = new myCart():

if(isset($_POST["cartaction"]) && ($_POST["cartaction"] == "update")) {
    if(isset($_POST["update"])) {
        $i = count($_POST["updateid"]);
        for($j=0;$j<$i;$j++){
            $cart->edit_item($_POST['update'][$j],$_POST['qty'][$j]);
        }
    }
    header("Location: cart.php");
}

if(isset($_GET["cartaction"]) && ($_GET["cartaction"] == "remove")) {
    $rid = intval($_GET['delid']);
    $cart->del_item($rid);
    header("Location: cart.php");
}

if(isset($_GET["cartaction"]) && ($_GET["cartaction"] == "empty" )) {
    $cart->empty_cart();
    header("Location: cart.php");
}

$query_RecCategory = " SELECT  category.categoryid, category.categoryname, category.categorysort, count(product. productid) as productNum FROM category LEFT JOIN product ON category . categoryid = product.categoryid GROUP BY category.categoryname, category. categorysort ORDER BY category . categorysort ASC ";
$RecCategory = mysqli_query($link,$query_RecTotal);
$row_RecTotal = mysql_fetch_assoc($RecTotal);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>網路購物系統</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
        <table width="780" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
                <td height="80" align="center" background="images/mlogo.png" class="tdbline"></td>
            </tr>
            <tr>
                <td class="tdbline">
                    <table width="100%" border="0" cellspacing="0" cellpadding="10" >
                        <tr valign="top">
                            <td width="200" class="tdrline">
                                <div class="boxtl"></div>
                                <div class="boxtr"></div>
                                <div class="categorybox">
                                    <p class="heading">
                                        <img src="images/16-cube-orange.png" width="16" height="16" alt="absmiddle"> 產品搜尋 
                                        <span class="smalltext">Search</span>
                                    </p>
                                    <form action="index.php" method="get" name="form1">
                                        <p>
                                            <input type="text" name="keyword" id="keyword" value="請輸入關鍵字" size="12" onClick="this.value='';">
                                            <input type="submit" id="button" value="查詢">
                                        </p>
                                    </form>
                                    <p class="heading">
                                        <img src="images/16-cube-orange.png" width="16" height="16" alt="absmiddle"> 價格區間 
                                        <span class="smalltext">Price</span>
                                    </p>
                                    <form action="index.php" method="get" name="form2" id="form2">
                                        <p>
                                            <input type="text" name="price1" id="price1" value="0" size="3">
                                            -
                                            <input type="text" name="price2" id="price2" value="0" size="3">
                                            <input type="submit" id="button2" value="查詢">
                                        </p>
                                    </form>
                                </div>
                                <div class="boxbl"></div>
                                <div class="boxbr"></div>
                                <hr width="100%" size="1" />
                                <div class="boxtl"></div>
                                <div class="boxtr"></div>
                                <div class="categorybox">
                                     <p class="heading">
                                        <img src="images/16-cube-orange.png" width="16" height="16" alt="absmiddle"> 產品目錄 
                                        <span class="smalltext">Category</span>
                                    </p>
                                    <ul>
                                        <li><a href="index.php?">所有產品<span class="categorycount">(<?php echo $row_Rec$row_RecTotal["totalNum"];?>)</span></a></li>
                                        <?PHP while($row_RecCategory=mysqli_fetch_assoc($link,$RecCategory)){ ?>
                                        <li><a href="index.php?cid=<?php echo $row_RecCategory["categoryid"]; ?>"><?php echo $row_RecCategory["categoryname"]; ?><span class="categorycount">(<?php echo $row_RecCategory["productNum"]; ?>)</span></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="boxbl"></div>
                                <div class="boxbr"></div>
                            </td>
                            <td>
                                <div class="subjectDiv">
                                    <span class="heading">
                                        <img src="images/16-cube-green.png" width="16" height="16" alt="absmiddle"> 購物車內容
                                    </span>
                                </div>
                                <div class="normalDiv">
                                    <?php if($cart->itemcount > 0)  {?>
                                        <form action="" method="post" name="cartform" id="cartform">
                                            <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
                                                <tr>
                                                    <th bgcolor="#ECE1E1"><p>刪除</p></th>
                                                    <th bgcolor="#ECE1E1"><p>產品名稱</p></th>
                                                    <th bgcolor="#ECE1E1"><p>數量</p></th>
                                                    <th bgcolor="#ECE1E1"><p>單價</p></th>
                                                    <th bgcolor="#ECE1E1"><p>小計</p></th>
                                                </tr>
                                                <?php foreach($cart->get_contents() as $item) { ?>
                                                    <tr>
                                                        <td align="center" bgcolor="#F6F6F6" class="tdbline"><p><a href="?cartaction=remove&delid=<?php echo $item['id']; ?>">移除</a></p></td>
                                                        <td bgcolor="#F6F6F6" class="tdbline"><p><?php echo $item['info'];?></p></td>
                                                        <td align="center" bgcolor="#F6F6F6" class="tdbline">
                                                            <p>
                                                                <input type="hideen" name="updataid[]" id="updateid[]" value="<?php echo $item[id];?>">
                                                                <input type="text" name="qty[]" id="qty[]" value="<?php echo $item['qty']; ?>" size="1">
                                                            </p>
                                                        </td>
                                                        <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item['price']); ?></p></td>
                                                        <td align="center" bgcolor="#F6F6F6" class="tdbline"><p>$ <?php echo number_format($item['subtotal']); ?></p></td>
                                                    </tr>
                                                <?php } ?>
                                                    <tr>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>運費</p></td>
                                                        <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>$ <?php echo number_format($cart->deliverfee); ?></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>總計</p></td>
                                                        <td valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p>&nbsp;</p></td>
                                                        <td align="center" valign="baseline" bgcolor="#F6F6F6"><p class="redword">$ <?php echo number_format($cart->grandtotal); ?></p></td>
                                                    </tr>
                                            </table>
                                            <hr width="100%" size="1" />
                                            <p align="center">
                                                <input type="hidden" name="cartaction" id="cartaction" value="update">
                                                <input type="submit" name="updatebtn" id="button3" value="更新購物車">
                                                <input type="button" name="emptybtn" id="button5" value="清空購物車" onClick="window.location.href='?cartaction=empty'">
                                                <input type="button" name="button" id="button6" value="前往結帳" onClick="window.location.href='checkout.php';">
                                                <input type="button" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">
                                            </p>
                                        </form>
                                </div>
                                <?php }else{ ?>
                                    <div class="infoDiv">目前購物車是空的。</div>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="30" align="center" background="images/album_r2_c1.jpg" class="trademark">© 2008 eHappy Studio All Rights Reserved.</td>
            </tr>
        </table>
    </body>
</html>