<?php
header('Content-type: application/json');
require('../incfiles/core.php');
$name = isset($_GET['name']) ? $_GET['name'] : "";
$mota = isset($_GET['mota']) ? $_GET['mota'] : "";
$giatien = isset($_GET['price']) ?$_GET['price'] : "";
$soluong = isset($_GET['soluong']) ? $_GET['soluong'] : "1";
$km = isset($_GET['km']) ? $_GET['km'] : "1";
$chuyenmuc = isset($_GET['chuyenmuc']) ? $_GET['chuyenmuc'] : "";
$thantuong = isset($_GET['idol']) ? $_GET['idol'] : "";
$cungcap = isset($_GET['cc']) ? $_GET['cc'] : "";
$sql = "INSERT INTO `product` (`product_id`,`product_name`,`product_price`,`description`,`lastdate`,`quantity`,`sale_id`,
`category_id`,`idol_id`,`supplier_id`) VALUES (NULL,'$name','$giatien','$mota','$timeSql','$soluong','$km','$chuyenmuc','$thantuong','$cungcap')";
if(mysqli_query($con,$sql))
{
    $rid = mysqli_insert_id($con);
    $sql = "INSERT INTO `photo`(`photo_id`,`photo_name`,`product_id`) VALUES (NULL,'photo/no-photo.png','$rid')";
    mysqli_query($con,$sql);
    $json = array("status" => 1, "msg" => "Thêm sản phẩm mới thành công !");
}
else
{
    $json = array("status" => 0, "msg" => "Đã có lỗi xảy ra, vui lòng kiểm tra lại !");
}
echo json_encode($json);
?>