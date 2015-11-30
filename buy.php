
<!--
 name:Venkataraghava Purimetla
 uta id: 1001113130
http://omega.uta.edu/~vxp3130/project3/buy.php
 -->

<? 
 session_start();
 ?>
<html>
<head><title>Buy Products</title></head>

<body>
<b class="blue">Shopping Basket:</b></p>


<?php
//empty basket
 error_reporting(E_ALL);
ini_set('display_errors','Off');
if($_GET['clear'] == '1')
{
session_unset();
}
?>

<?php
// delete from cart
 error_reporting(E_ALL);
ini_set('display_errors','Off');
$check=$_GET;
if($check)
{
$deletion = $_GET['delete'];
$_SESSION['cart'] = array_values($_SESSION['cart']);
$count_cartitems = count($_SESSION['cart']);
for($i = 0;$i<$count_cartitems;$i++){
if($_SESSION['cart'][$i]['id'] == $deletion)
{
unset($_SESSION['cart'][$i]);
break;
}
}
}
?>

<?php
//put into cart
 error_reporting(E_ALL);
ini_set('display_errors','Off');
 $check=$_GET;
 $asd = $_GET['buy'];
 foreach($_SESSION['suk'] as $cart)
 {
 if($cart['id'] == $asd){
 $_SESSION['cart'][] = array('id'=>(string)$cart['id'],'name'=>(string) $cart[name],'fullDescription'=>(string) $cart[fullDescription],'sourceURL'=> (string) $cart[sourceURL],'minPrice' => (string) $cart[minPrice]);
break;
 }
 }
 $total = "0";
echo '<table border="1">';
if($asd){
 echo'<tr>';
echo'<th>PRODUCT</th>';
echo'<th>NAME</th>';
echo'<th>DESCRIPTION</th>';
echo'<th>PRICE</th>';
echo'<th>ACTION</th>';
echo'</tr>';
}
echo '<tbody>';
 foreach($_SESSION['cart'] as $cartitems)
 {
		echo '<tr>';
		echo '<td><img src='.$cartitems['sourceURL'].'/></td>';
        echo '<td>' .$cartitems['name'] . '</td>';
        echo '<td>' .$cartitems['fullDescription'] . '</td>';
        echo '<td>' .$cartitems['minPrice'] . '</td>';
		echo '<td><a href="buy.php?delete=' . $cartitems['id'] . '">Delete</a></td>';
		echo '</tr>';
		$total = $total + $cartitems['minPrice'];
 }
 if($total !=0){
 echo'<tr>';
 echo'<td colspan="2"></td>';
echo'<td align="right"><b>TOTAL:</b></td>';
 echo'<td>'.$total."$".'</td>';
 echo '</tr>';
 }
 echo '</tbody>';
 echo '</table>';

?>

<form action="buy.php" method="GET">
<input type="hidden" name="clear" value="1"/>

<input type="submit" value="Empty Basket"/>
</form>
<p/>
<form action="buy.php" method="GET">
<fieldset style="background-color:#afbdd4"><legend style="background-color:#afbdd4">Find products:</legend>

<?php
// display drop down menu
 error_reporting(E_ALL);
ini_set('display_errors','Off');
$xmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/CategoryTree?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&showAllDescendants=true');
$xml = new SimpleXMLElement($xmlstr);
$option1=$xml->category->name;
$id1=$xml->category['id'];
echo"<label>Category:";echo'<select name="category">';
echo'<optgroup label="'.$option1.'">';
echo'<option value="'.$id1.'">';echo"$option1";echo"</option>";
echo"<h2>"; 
echo"</optgroup>";
echo"</h2>";
echo"</br>";
foreach ($xml->category->categories->category as $data){
$option2=$data->name;
$id2=$data['id'];
echo'<optgroup label="'.$option2.'">';
echo'<option value="'.id2.'">'; echo"<b>"; echo"$option2"; echo"</b>"; echo"</option>";
echo"</br>";
echo"</optgroup>";
foreach($data->categories->category as $data1){
$option3=$data1->name;
$id3=$data1['id'];
echo'<option value="'.$id3.'">';echo"$option3";echo"</option>";
echo"</br>";
}
echo"</br>";
}
echo"</label>";
echo"</select>";
?>

<label>Search keywords: <input type="text" name="search"/><label>
<input type="submit" value="Search" "/>
</fieldset>
</form>
<p/>


<?php
// search using keyword and category
 error_reporting(E_ALL);
ini_set('display_errors','Off');
$get = urlencode($_GET['search']);
$category = $_GET['category'];
$xmlstr = file_get_contents('http://sandbox.api.shopping.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId='.$category.'&keyword='.$get.'&numItems=20');
$xml = new SimpleXMLElement($xmlstr);
echo'<table border="1">';
echo'<tbody>';
if($get){
echo'<tr>';
echo'<th>PRODUCT</th>';
echo'<th>NAME</th>';
echo'<th>PRICE</th>';
echo'<th>BEST OFFERS</th>';
echo'<th>DESCRIPTION</th>';
echo'</tr>';
}
foreach($xml->categories->category->items->product as $a)
{
echo'<tr>';
echo'<td>';echo'<a href="buy.php?buy='.$a['id'].'">';echo"<img src=".$a->images->image->sourceURL.">";echo"</td>";
echo'<td align="left">';echo"$a->name";echo"</td>";
echo"<td>";echo"$a->minPrice$";echo"</td>";
echo"<td>";echo'<a href="'.$a->productOffersURL.'">';echo"click here for more offers";echo"</td>";
echo"<td>";echo"$a->fullDescription";echo"</td>";echo'</tr>';

$_SESSION['suk'][] = array( 'id' =>(string) $a['id'],'name' => (string) $a->name,'fullDescription' => (string) $a->fullDescription,'sourceURL' => (string) $a->images->image[0]->sourceURL,'minPrice' => (string) $a->minPrice);
$_SESSION['minpPrice'][] = array( 'minPrice' => (string) $a->minPrice );


}
echo'</tbody>';
echo'</table>';
?>
</body>
</html>
