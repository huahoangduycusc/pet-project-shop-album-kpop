<?php
$rootpath = "";
require_once('incfiles/core.php');
$textl = "Đăng ký tài khoản";
require_once('incfiles/head.php');
if($user_id)
{
    if(!empty($do))
    {
        location($do);
    }
    else
    {
    chuyenhuong();
    }
}
?>
<div class="page_title"><a href="">Trang chủ</a> > <a href="">Đăng nhập</a></div>
            <div class="body_layout">
                <div class="body_left">
                    <form action="" method="post">
                    <div class="page_tieude">
                        Đăng nhập
                    </div>
                    <?php
                    // check login
                    if(isset($_POST['login']))
                    {
                        $user = htmlspecialchars($_POST['user']);
                        $pass = htmlspecialchars($_POST['password']);
                        $error = array();
                        $flag = true;
                        if(empty($user))
                        {
                            $error['user'] = "Vui lòng điền vào tài khoản";
                            $flag = false;
                        }
                        if(empty($pass))
                        {
                            $error['pass'] = "Vui lòng điền vào mật khẩu";
                            $flag = false;
                        }
                        if($flag)
                        {
                            $sql = "select `user_id`,`username`, `email`, `password` from `users` where `username` = '$user' or `email` = '$user' limit 1";
                            $result = mysqli_query($con,$sql);
                            if(!mysqli_num_rows($result))
                            {
                                $error['user'] = "Tài khoản không tồn tại";
                            }
                            else
                            {
                                $res = mysqli_fetch_assoc($result);
                                $kq = password_verify($pass,$res['password']);
                                if(!$kq)
                                {
                                    $error['pass'] = "Mật khẩu không chính xác";
                                }
                                else
                                {
                                        $_SESSION['sid'] = $res['user_id'];
                                        $_SESSION['spw'] = $pass;
                                        if(!empty($do))
                                        {
                                            location($do);
                                        }
                                        else
                                        {
                                            chuyenhuong();
                                        }
                                }
                            }
                        }
                    }
                    ?>
                    <div class="input">
                        <div class="input_box">
                            Tên tài khoản
                        </div>
                        <div class="input_input">
                            <input type="text" name="user" placeholder="Tên tài khoản hoặc email" value="<?php echo isset($user) ? ''.$user.'' : ''?>">
                            <?php echo isset($error['user']) ? '<div class="error">'.$error['user'].'</div>' : ''; ?>
                        </div>
                    </div>
                    <div class="input">
                        <div class="input_box">
                            Mật khẩu
                        </div>
                        <div class="input_input">
                            <input type="password" name="password" placeholder="Mật khẩu" value="<?php echo isset($pass) ? ''.$pass.'' : ''?>">
                            <?php echo isset($error['pass']) ? '<div class="error">'.$error['pass'].'</div>' : ''; ?>
                        </div>
                    </div>
                    <div class="input">
                        <button class="button" name="login" value="dang nhap">Đăng nhập</button>
                    </div>
                    </form>
                </div>
                <div class="body_right">
                    <div class="page_tieude">
                        Reset your password
                    </div>
                    <div class="page_noidung">
                        Chúng tôi sẽ gửi một mật khẩu mới vào tài khoản email của bạn!
                        <div id="error" class="error"></div>
                    </div>
                    <div class="input">
                        <div class="input_box">
                            Email
                        </div>
                        <div class="input_input">
                            <input type="text" name="email" id="email">
                        </div>
                    </div>
                    <div class="input">
                        <button class="button" id="apply">Submit</button>
                    </div>
                    <div class="input">
                        <a href="" class="under">Thoát</a>
                    </div>
                </div>
            </div>
<script>
    var gift = document.getElementById("apply");
    gift.addEventListener('click',function()
    {
        var email = document.getElementById("email").value;
        var error = document.getElementById("error");
        if(email.length == 0)
        {
            error.innerHTML = "Vui lòng nhập vào tên email";
            return;
        }
        else
        {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if(this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("error").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","check.php?q="+email,true);
            xmlhttp.send();
        }
    });
</script>
<?php
require_once('incfiles/end.php');
?>