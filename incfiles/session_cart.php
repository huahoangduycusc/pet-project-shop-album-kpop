<?php
$giohang = 0;
$amount = 0;
$id_cart = "0";
$price_cart = 0;
$giamgia = 0;
if(isset($_SESSION['cart']))
{
    $cart = $_SESSION['cart'];
    $id_cart = "";
    foreach($cart as $key => $value)
    {
        $giohang += $value['quantity'];
        $amount += 1;
        $id_cart.= $key.",";
        $price_cart += (float)$value['quantity']*$value['price'];
    }
}
$id_cart = substr($id_cart,0,-1);
// dem order cua khach hang
$orders = 0;
if($user_id)
{
    $od = "select * from `order` where `user_id` = '$user_id'";
    $ods = mysqli_query($con,$od);
    $orders = mysqli_num_rows($ods);
}
// hien san pham ma khach hang de tung xem qua
$cart_view = "0";
if(isset($_SESSION['cart_view']))
{
    $cart_view = "";
    $view_cart = $_SESSION['cart_view'];
    foreach($view_cart as $key)
    {
        $cart_view .= $key.",";
    }
    $cart_view = substr($cart_view,0,-1);
}
// gift code
if(isset($_SESSION['giftcode']))
{
    $gifts = $_SESSION['giftcode'];
    foreach($gifts as $key => $value)
    {
        $giamgia = $value['price'];
    }
}
?>