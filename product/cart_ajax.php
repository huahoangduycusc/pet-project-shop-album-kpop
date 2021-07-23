<?php
sleep(0.99);
require_once('../incfiles/core.php');
$result = array();
$result['msg'] = "";
$result['tong'] = "";
$type = isset($_GET['loai']) ? htmlspecialchars($_GET['loai']) : false;
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
if($type != 'cong' && $type != 'tru')
{
    $result['msg'] = "Chúng tôi phát hiện bạn cố ý hack website của chúng tôi";
    $result['title'] = "Cảnh báo";
}
else if($type == 'cong')
{
    $sql = "select * from `product` where `product_id` = '$id' limit 1";
    $kq = mysqli_query($con,$sql);
    if(!mysqli_num_rows($kq))
    {
        $result['msg'] = "Chúng tôi phát hiện bạn cố ý hack website của chúng tôi";
        $result['title'] = "Cảnh báo";
    }
    else
    {
        $sanpham = mysqli_fetch_assoc($kq);
        if($sanpham['quantity'] > $_SESSION['cart'][$id]['quantity'])
        {
            $_SESSION['cart'][$id]['quantity']++;
            $result['tong'] = number_format($price_cart+$sanpham['product_price']);
        }
        else
        {
            $result['msg'] = "Xin lỗi, số lượng hàng trong kho của sản phẩm này đã hết !";
            $result['title'] = "Hết hàng";
            $result['tong'] = number_format($price_cart);
        }
    }
}
else if($type == 'tru')
{
    $sql = "select * from `product` where `product_id` = '$id' limit 1";
    $kq = mysqli_query($con,$sql);
    if(!mysqli_num_rows($kq))
    {
        $result['msg'] = "Chúng tôi phát hiện bạn cố ý hack website của chúng tôi";
        $result['title'] = "Cảnh báo";
    }
    else
    {
        $sanpham = mysqli_fetch_assoc($kq);
        if($_SESSION['cart'][$id]['quantity'] > 1)
        {
            $_SESSION['cart'][$id]['quantity']--;
            $result['tong'] = number_format($price_cart-$sanpham['product_price']);
        }
        else
        {
            $result['msg'] = "Không thể giảm số lượng do đã đạt mức tối thiểu";
            $result['title'] = "Lỗi";
            $result['tong'] = number_format($price_cart);
        }
    }
}
die(json_encode($result));
?>