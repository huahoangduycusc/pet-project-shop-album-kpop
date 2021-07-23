<?php
sleep(2);
$rootpath = "";
require_once('incfiles/core.php');
$error = array(
    'error' => 'success',
    'msg' => '',
);
$user = isset($_POST['user']) ? htmlspecialchars($_POST['user']) : false;
$pass = isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : false;
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : false;
$fname = isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : false;
$regex = "/[^a-zA-Z0-9]+/";
$flag = true;
$mode = true;
if($user && $pass && $email && $fname)
{
    if(mb_strlen($user) < 5 || mb_strlen($user) > 20)
    {
        $error['msg'] = "Tài khoản phải từ 6 đến 20 ký tự !";
        $flag = false;
    }
    else if(preg_match($regex,$user))
    {
        $error['msg'] = "Tên tài khoản không hợp lệ, vui lòng không sử dụng ký tự đặc biệt hoặc chữ có dấu";
        $flag = false;
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['msg'] = "Địa chỉ Email không hợp lệ";
        $flag = false;
    }
    if($flag)
    {
        $sql = "select * from `users` where `username` = '$user'";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            $error['msg'] = "Tên tài khoản đã tồn tại, vui lòng sử dụng tên tài khoản khác !";
            $mode = false;
        }
        $sql = "select * from `users` where `email` = '$email'";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            $error['msg'] = "Địa chỉ email đã tồn tại, vui lòng sử dụng email khác !";
            $mode = false;
        }
    }
    if($flag && $mode)
    {
        $mk = password_hash($pass,PASSWORD_DEFAULT);
        $gender = 1;
        $sql = "INSERT INTO `users`(`user_id`,`username`,`password`,`fullname`,`gender`,`address`,`phone`,`email`,`dob`,`mob`,`yob`,`status`,`right`,`photo`,`post`)
        VALUES (NULL,'$user','$mk','$fname','1','trống','','$email',1,1,1930,0,0,0,0)";
        if(mysqli_query($con,$sql))
        {
            $rid = mysqli_insert_id($con);
            $_SESSION['sid'] = $rid;
            $_SESSION['spw'] = $pass;
            if($gender == 1)
            {
                mysqli_query($con,"UPDATE `users` SET `photo` = 'photo/users/male.png' WHERE `user_id` = '$rid' LIMIT 1");
            }
            else
            {
                mysqli_query($con,"UPDATE `users` SET `photo` = 'photo/users/female.png' WHERE `user_id` = '$rid' LIMIT 1");
            }
        }
        else
        {
            $error['msg'] = "Có lỗi xảy ra khi đăng ký, vui lòng liên hệ BQT để biết thêm chi tiết";
        }
    }
}
die(json_encode($error));
?>