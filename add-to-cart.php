<?php
sleep(1);
$rootpath = "";
require('incfiles/core.php');
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
$result = array();
$result['title'] = "Thông báo";
$flag = true;
if($id)
{
    $sql = "SELECT * FROM `product` a INNER JOIN `category` b ON a.category_id = b.category_id WHERE a.product_id = '$id' limit 1";
    $result1 = mysqli_query($con,$sql);
    if(!mysqli_num_rows($result1))
    {
        $result['title'] = "SẢN PHẨM KHÔNG TỒN TẠI";
        $result['msg'] = "Xin lỗi. Chúng tôi phát hiện bạn đang cố hack hệ thống của chúng tôi !";
    }
    else
    {
        $res = mysqli_fetch_assoc($result1);
        if($res['quantity'] < 1)
        {
            $result['title'] = "MẶT HÀNG NÀY TẠM HẾT";
            $result['msg'] = "Xin lỗi hiện tại mặt hàng này đã hết, quý khách vui lòng thử lại sau !";
        }
        else
        {
            if(isset($_SESSION['cart'][$id]))
            {
                if($_SESSION['cart'][$id]['quantity'] >= $res['quantity'])
                {
                    $result['title'] = "MẶT HÀNG NÀY TẠM HẾT";
                    $result['msg'] = "Xin lỗi hiện tại mặt hàng này đã hết, quý khách vui lòng thử lại sau !";
                }
                else
                {
                    $result['title'] = "THÔNG BÁO";
                    $result['msg'] = "Bạn đã thêm thành công món hàng này vào giỏ hàng";
                    $_SESSION['cart'][$id]['quantity']+=1;
                    $result['soluong'] = $giohang+1;
                }
            }
            else
            {
                $result['title'] = "THÔNG BÁO";
                $result['msg'] = "Bạn đã thêm thành công món hàng này vào giỏ hàng";
                $_SESSION['cart'][$id] = array(
                "quantity" => 1,
                "price" => $res['product_price']
                );
                $result['soluong'] = $giohang+1;
            }
        }
    }
}
die(json_encode($result));
?>