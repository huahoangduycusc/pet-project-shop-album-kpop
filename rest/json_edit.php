<?php
header('Content-type: application/json');
require('../incfiles/core.php');
$giatien = isset($_GET['price']) ? $_GET['price'] : "";
$soluong = isset($_GET['soluong']) ? $_GET['soluong'] : "1";
$km = isset($_GET['km']) ? $_GET['km'] : "1";
$chuyenmuc = isset($_GET['chuyenmuc']) ? $_GET['chuyenmuc'] : "";
$thantuong = isset($_GET['idol']) ? $_GET['idol'] : "";
$cungcap = isset($_GET['cc']) ? $_GET['cc'] : "";
$sql = "UPDATE `product` SET `product_price` = '$giatien',`quantity` = '$soluong', `sale_id` = '$km',
`category_id` = '$chuyenmuc', `idol_id` = '$thantuong', `supplier_id` = '$cungcap' WHERE `product_id` = '$id' LIMIT 1";
if(mysqli_query($con,$sql))
{
    $json = array("status" => 1, "msg" => "Cập nhật thành công !");
}
else
{
    $json = array("status" => 0, "msg" => "Đã có lỗi xảy ra, vui lòng kiểm tra lại !");
}
echo json_encode($json);
?>