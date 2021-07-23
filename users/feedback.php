<?php
require_once('../incfiles/core.php');
$textl = "Viết Feedback";
require_once('../incfiles/head.php');
if(!$user_id)
{
    chuyenhuong();
}
?>
<div class="page_title"><a href="">Trang chủ</a> > <a href="#">Viết Feedback</a></div>
<?php
if(isset($_POST['write']))
{
    $tieude = htmlspecialchars($_POST['tieude']);
    $msg = htmlspecialchars($_POST['msg']);
    $email = htmlspecialchars($_POST['em']);
    $tieude = mysqli_real_escape_string($con,$tieude);
    $msg = mysqli_real_escape_string($con,$msg);
    $email = mysqli_real_escape_string($con,$email);
    if(empty($tieude) || empty($msg) || empty($email))
    {
        echo'<div class="error">Không được bỏ trống các trường bên dưới !</div>';
    }
    else
    {
        $sql = "INSERT INTO `feedback`(`fb_id`,`title`,`description`,`email`,`fb_date`,`user_id`,`seen`) VALUES (NULL,'$tieude','$msg','$email','$timeSql','$user_id','0')";
        if(mysqli_query($con,$sql))
        {
            echo '<div class="success"><b>Bạn đã viết 1 Feedback đến Ban quản trị, cảm ơn bạn đã sử dụng dịch vụ !</b></div>';
        }
    }
}
?>
<form action="" method="post">
<div class="profile">
    <div class="list-box">
    Email
    </div>
    <div class="list-input">
        <input type="email" name="em" required="required" placeholder="Email của bạn">
    </div>
    <div class="list-box">
    Tiêu đề
    </div>
    <div class="list-input">
        <input type="text" name="tieude" required="required" placeholder="Tiêu đề">
    </div>
    <div class="list-box">
    Nội dung
    </div>
    <div class="list-input">
        <textarea name="msg" rows="10" required="required" placeholder="Nội dung cần gửi"></textarea>
    </div>
    <div class="list-box">
        <button class="button-right" name="write" value="gui">Gửi Ngay</button>
    </div>
</div>
</form>
<?php
require_once('../incfiles/end.php');
?>