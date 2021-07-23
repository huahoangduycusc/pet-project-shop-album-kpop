<?php
require_once('../incfiles/core.php');
$q = $_REQUEST["q"];
$q = trim($q);
$q = htmlspecialchars($q);
$q = stripcslashes($q);
$q = htmlentities($q);
$hint = "";
if(strlen($q) < 10)
{
    $hint = "Mã gift không hợp lệ, vui lòng kiểm tra lại !";
}
else
{
    $timestamp = date("Y-m-d");
    $q = mysqli_escape_string($con,$q);
    $sql = "select * from `giftcode` where `giftcode` = '{$q}' limit 1";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        if(strtotime($timestamp) < strtotime($res['fromday']))
        { 
            $hint = "Bạn hiện chưa thể sử dụng gift code này vì chưa có hiệu lực !";
        }
        if(strtotime($timestamp) > strtotime($res['today']))
        { 
            $hint = "Gift code này đã hết hạn sử dụng, liên hệ BQT để biết thêm chi tiết !";
        }
        if($res['sudung'] != 0)
        { 
            $hint = "Mã quà tặng này đã được sử dụng !";
        }
        if(empty($hint))
        {

            $thanhcong = "Xin chúc mừng, bạn được giảm ".number_format($res['discount'])." VND từ mã quà tặng !";
            if(isset($_SESSION['giftcode'][$res['code_id']]))
            {

            }
            else
            {
                $_SESSION['giftcode'][$res['code_id']] = array(
                    "price" => $res['discount']
                );
            }
        }
    }
    else
    {
        $hint = "Mã gift code không tồn tại hoặc đã được sử dụng !";
    }
}
echo $hint == "" ? "<font color='green'>$thanhcong</font>" : $hint;
?>