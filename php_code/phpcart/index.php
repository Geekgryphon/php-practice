<?php
  header("Content-Type: text/html; charset=utf-8");
  require_once("connMysql.php");
  $pageRow_records = 6;
  $num_pages = 1;

  if(isset($_GET['page'])){
      $num_pages = $_GET['page'];
  }

  $startRow_records = ($num_pages - 1) * $pageRow_records;
  
  if(isset($_GET["cid"]) && ($_GET["cid"]!="")) {
      $query_RecProduct = " SELECT * FROM product WHERE categoryid = " . $_GET["cid"] . " ORDER BY productid desc";
  }elseif(isset($_GET["keyword"]) && ($_GET["keyword"]!="")){
      $query_RecProduct = " SELECT * FROM product WHERE productname LIKE '%" . $_GET["keyword"] . "%' OR description LIK '%" . $_GET["keyword"] . "%' ORDER BY productid DESC";
  }elseif(isset($_GET["price1"]) && isset($_GET["price2"]) && ($_GET["price1"] <= $_GET["price2"])) {
      $query_RecProduct = " SELECT * FROM product WHERE productprice BETWEEN " . $_GET["price1"] . " AND " . $_GET["price2"] . " ORDER BY productid DESC";
  }else{
      $query_RecProduct = " SELECT * FROM product ORDER BY productid DESC";
  }

$query_limit_RecProduct = $query_RecProduct. " LIMIT " . $startRow_records. ", " . $pageRow_records;
$RecProduct = mysqli_query($link,$query_limit_RecProduct);
$all_RecProduct = mysqli_query($link,$query_RecProduct);
$total_records = mysqli_num_rows($all_RecProduct);
$total_pages = ceil($total_records/$pageRow_records);
$query_RecCategory = " SELECT category.categoryid,category.categoryname,category.categorysort,count(product.productid) as productNum FROM category left join product on category . categoryid = product . categoryid GROUP BY category.categoryid, category categoryname, category . categorysort ORDER BY category . categorysort ASC ";
$RecCategory = mysqli_query($query_RecCategory);

$query_RecTotal = "SELECT count(productid) as totalNum FROM product ";
$RecTotal = mysqli_query($query_RecTotal);
$row_RecTotal = mysqli_fetch_assoc($RecTotal);

function keepURL(){
    $keepURL = "" ;
    if(isset($_GET["keyword"])) $keepURL .="&keyword=" . urlencode($_GET["keyword"]);
    if(isset($_GET["price1"])) $keepURL .= "&price1=" . $_GET["price1"];
    if(isset($_GET["price2"])) $keepURL .= "&price2=" . $_GET["price2"];
    if(isset($_GET["cid"])) $keepURL .= "&cid=" . $_GET["cid"];
}

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
                <td width="80" align="center" background="images/mlogo.png" class="tdbline"></td>
            </tr>
            <tr>
               <td class="tdbline">
                   <table width="100%" border="0" cellspacing="0" cellpadding="10">
                       <tr valign="top">
                           <td width="200" class="tdrline">
                               <div class="boxt1"></div>
                                   <div class="boxtr"></div>
                                   <div class="categorybox">
                                   <p class="heading">
                                       <img src="images/16-cube-orange.png" width="16" height="16" align="absmiddle" alt=""> 產品搜尋
                                       <span class="smalltext">Search</span>
                                   </p>
                                   <form action="index.php" name="form1" method="get">
                                       <p>
                                           <input type="text" name="keyword" id="keyword" value="請輸入關鍵字" size="12" onClick="this.value='';">
                                           <input type="submit" id="button" value="查詢">
                                       </p>
                                   </form>
                                   <p class="heading">
                                       <img src="images/16-cube-orange.png" width="16" height="16" align="absmiddle" alt=""> 價格區間
                                       <span class="smalltext">Price</span>
                                   </p>
                                   <form action="index.php" id="form2" name="form2" method="get">
                                       <p>
                                           <input type="text" name="price1" id="price1" value="0" size="3">
                                           <input type="text" name="price2" id="price2" value="0" size="3">
                                           <input type="text" id="button2" value="查詢">
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
                                       <img src="images/16-cube-orange.png" width="16" height="16" align="absmiddle" alt="">產品目錄
                                       <span class="smalltext">Category</span>
                                   </p>
                                   <ul>
                                       <li><a href="index.php">所有產品<span class="categorycount">(<?php echo $row_RecTotal["totalNum"]; ?>)</span></a></li>
                                       <?php while($row_RecCategory=mysqli_fetch_assoc($RecCategory)) {?>
                                       <li><a href="index.php?cid=<?php echo $row_RecCategory["categoryid"]; ?>"><?php echo $row_RecCategory["categoryname"]; ?><span class="categorycount">(<?php echo $row_RecCategory["productNum"]; ?>)</span></a></li>
                                       <?php } ?>
                                   </ul>
                               </div>
                               <div class="boxbl"></div>
                               <div class="boxbr"></div>
                           </td>
                           <td>
                               <div class="subjectDiv"> <span class="heading"><img src="images/16-cube-green.png" width="16" height="16" align="absmiddle" alt=""></span>產品列表</div>
                               <div class="actionDiv"><a href="cart.php">我的購物車</a></div>
                               <?php while($row_RecProduct=mysqli_fetch_assoc($RecProduct)) { ?>
                               <div class="albumDiv">
                                   <div class="picDiv">
                                       <a href="product.php?id=<?php echo $row_RecProduct["productid"];?>">
                                           <?php if($row_RecProduct["productimages"]=="") { ?>
                                           <img src="images/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
                                           <?php }else{ ?>
                                           <img src="proimg/<?php echo $row_RecProduct["productimages"]; ?>" alt="<?php echo $row_RecProduct["productname"]; ?>" width="135" height="135" border="0" />
                                           <?php }?>
                                       </a>
                                   </div>
                                   <div class="albuminfo">
                                       <a href="product.php?id=<?php echo $row_RecProduct["productid"]; ?>"><?php echo $row_RecProduct["productname"]; ?></a><br />
                                       <span class="smalltext">特價 </span><span class="redword"><?php echo $row_RecProduct["productprice"]; ?></span><span class="smalltext">元</span>
                                   </div>
                               </div>
                               <?php } ?>
                               <div class="navDiv">
                                   <?php if($num_pages > 1) {  ?>
                                   <a href="?page=1<?php echo keepURL(); ?>">|&lt;</a> <a href="?page=<?php echo $num_pages-1; ?><?php echo keepURL(); ?>">|&lt;&lt;</a>
                                   <?php }else{ ?>
                                   |&lt; &lt;&lt;
                                   <?php } ?>
                                   <?php 
                                     for ($i=1;$i<=$total_pages;$i++){
                                         if($i==$num_pages){
                                             echo $i." ";
                                         }else{
                                             $urlstr = keepURL();
                                             echo "<a href=\"?page=$i$urlstr\">$i</a>";
                                         }
                                     }
                                   ?>
                                   <?php if($num_pages > $total_pages) {  ?>
                                   <a href="?page=<?php echo $num_pages+1; ?><?php echo keepURL(); ?>">|&gt;&gt;</a> <a href="?page=<?php echo $total_pages; ?><?php echo keepURL(); ?>">|&gt;|</a>
                                   <?php }else{ ?>
                                   &gt; &gt;&gt;|
                                   <?php } ?>
                               </div>
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
