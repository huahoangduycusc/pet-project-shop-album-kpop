<?php
sleep(2);
$rootpath = "";
require_once('incfiles/core.php');
$error = array(
    'error' => 'success',
    'username' => '',
    'password' => ''
);
$user = isset($_POST['user']) ? htmlspecialchars($_POST['user']) : false;
$pass = isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : false;
if(!$user && !$pass){
    die('{error: "bad request"}');
}
if($user && $pass)
{
    $sql = "select `user_id`,`username`, `email`, `password` from `users` where `username` = '$user' or `email` = '$user' limit 1";
                            $result = mysqli_query($con,$sql);
                            if(!mysqli_num_rows($result))
                            {
                                $error['username'] = "Tài khoản không tồn tại";
                            }
                            else
                            {
                                $res = mysqli_fetch_assoc($result);
                                $kq = password_verify($pass,$res['password']);
                                if(!$kq)
                                {
                                    $error['password'] = "Mật khẩu không chính xác";
                                }
                                else
                                {
                                        $_SESSION['sid'] = $res['user_id'];
                                        $_SESSION['spw'] = $pass;
                                }
                            }
}
die(json_encode($error));
?>