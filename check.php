<?php
$rootpath = "";
require_once('incfiles/core.php');
include('admin/send.php');
$q = $_REQUEST["q"];
$q = trim($q);
$q = htmlspecialchars($q);
$q = mysqli_real_escape_string($con,$q);
$hint = "";
$sql = "SELECT `email` FROM `users` WHERE `email` = '$q' LIMIT 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    $hint = "Không tìm thấy email nào phù hợp !";
}
else
{
    $newpassword = giftcode(9);
    $matkhau = password_hash($newpassword,PASSWORD_DEFAULT);
    $msg = "<body><h2>SHOP389 - ADMIN</h2><br> Đây là mật khẩu mới của bạn $newpassword<br>P/s: Đây là email tự động !</body>";
    $tieude = "RESET PASSWORD TÀI KHOẢN TRÊN SHOP389";
    $sql = "UPDATE `users` SET `password` = '$matkhau' WHERE `email` = '{$q}' LIMIT 1";
    mysqli_query($con,$sql);
    $thanhcong = "Xác nhận thành công, chúng tôi đã gửi đến Email $q của bạn một mật khẩu mới, vui lòng kiểm tra hộp thư !";
    sendGMail($tieude,$msg,$q,$q);
}
echo $hint == "" ? "<font color='green'>$thanhcong</font>" : $hint;
?>