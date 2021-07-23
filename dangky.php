<?php
$rootpath = "";
require_once('incfiles/core.php');
$textl = "Đăng ký tài khoản";
require_once('incfiles/head.php');
if($user_id)
{
    chuyenhuong();
}
?>
<div class="page_title"><a href="<?php echo $homeurl;?>">Trang chủ</a> > <a href="#">Đăng ký tài khoản</a></div>
            <div class="body_layout">
                <div class="body_left">
                    <form action="?" method="post">
                    <div class="page_tieude">
                        Tạo tài khoản mới
                    </div>
                    <?php
                    if(isset($_POST['signin']))
                    {
                        $error = array();
                        $user = htmlspecialchars($_POST['user']);
                        $pass = htmlspecialchars($_POST['pass']);
                        $email = htmlspecialchars($_POST['email']);
                        $fname = htmlspecialchars($_POST['fname']);
                        $gender = abs(intval($_POST['gender']));
                        $user = mysqli_real_escape_string($con,$user);
                        $email = mysqli_real_escape_string($con,$email);
                        $regex = "/[^a-zA-Z0-9]+/";
                        if(empty($user))
                        {
                            $error['user'] = "Vui lòng nhập vào tài khoản";
                        }
                        if(empty($pass))
                        {
                            $error['pass'] = "Vui lòng nhập vào mật khẩu";
                        }
                        if(mb_strlen($user) < 5 || mb_strlen($user) > 20)
                        {
                            $error['user'] = "Tài khoản phải từ 6 đến 20 ký tự !";
                        }
                        if(preg_match($regex,$user))
                        {
                            $error['user'] = "Tên tài khoản không hợp lệ, vui lòng không sử dụng ký tự đặc biệt hoặc chữ có dấu";
                        }
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $error['email'] = "Địa chỉ Email không hợp lệ";
                        }
                        if(empty($fname))
                        {
                            $error['fname'] = "Vui lòng điền vào họ và tên !";
                        }
                        if(empty($error))
                        {
                            $sql = "select * from `users` where `username` = '$user'";
                            $result = mysqli_query($con,$sql);
                            if(mysqli_num_rows($result))
                            {
                                $error['user'] = "Tên tài khoản đã tồn tại, vui lòng sử dụng tên tài khoản khác !";
                            }
                            $sql = "select * from `users` where `email` = '$email'";
                            $result = mysqli_query($con,$sql);
                            if(mysqli_num_rows($result))
                            {
                                $error['email'] = "Địa chỉ email đã tồn tại, vui lòng sử dụng email khác !";
                            }
                        }
                        if(empty($error))
                        {
                            $mk = password_hash($pass,PASSWORD_DEFAULT);
                            $sql = "INSERT INTO `users`(`user_id`,`username`,`password`,`fullname`,`gender`,`address`,`phone`,`email`,`dob`,`mob`,`yob`,`status`,`right`,`photo`,`post`)
                            VALUES (NULL,'$user','$mk','$fname','$gender','trống','','$email',1,1,1930,0,0,0,0)";
                            if(mysqli_query($con,$sql))
                            {
                                $rid = mysqli_insert_id($con);
                                if($gender == 1)
                                {
                                    mysqli_query($con,"UPDATE `users` SET `photo` = 'photo/users/male.png' WHERE `user_id` = '$rid' LIMIT 1");
                                }
                                else
                                {
                                    mysqli_query($con,"UPDATE `users` SET `photo` = 'photo/users/female.png' WHERE `user_id` = '$rid' LIMIT 1");
                                }
                                echo'<div><b style="color:green;">Đăng ký tài khoản mới thành công !</b><br>
                                <a href="dangnhap.php">Click vào đây để đăng nhập</a></div>';
                            }
                            else
                            {
                                echo"<div class='error'>Xảy ra lỗi khi đăng ký, vui lòng thử lại sau !</div>";
                            }
                        }
                    }
                    ?>
                    <div class="input">
                        <div class="input_box">
                            Tên tài khoản
                        </div>
                        <div class="input_input">
                            <input type="text" name="user" placeholder="Tên tài khoản" value="<?php echo isset($user) ? ''.$user.'' : '';?>">
                        </div>
                        <?php echo isset($error['user']) ? '<div class="error">'.$error['user'].'</div>' : ''; ?>
                    </div>
                    <div class="input">
                        <div class="input_box">
                            Mật khẩu
                        </div>
                        <div class="input_input">
                            <input type="password" name="pass" placeholder="Mật khẩu" value="<?php echo isset($pass) ? ''.$pass.'' : '';?>">
                        </div>
                        <?php echo isset($error['pass']) ? '<div class="error">'.$error['pass'].'</div>' : ''; ?>
                    </div>
                    <div class="input">
                        <div class="input_box">
                            Email
                        </div>
                        <div class="input_input">
                            <input type="text" name="email" placeholder="Email" value="<?php echo isset($email) ? ''.$email.'' : '';?>">
                        </div>
                        <?php echo isset($error['email']) ? '<div class="error">'.$error['email'].'</div>' : ''; ?>
                    </div>
                    <div class="input">
                        <div class="input_box">
                            Họ tên
                        </div>
                        <div class="input_input">
                            <input type="text" name="fname" placeholder="Họ và tên" value="<?php echo isset($fname) ? ''.$fname.'' : '';?>">
                        </div>
                        <?php echo isset($error['fname']) ? '<div class="error">'.$error['fname'].'</div>' : ''; ?>
                    </div>
                    <div class="input">
                        <div class="input_box">Giới tính</div>
                        <div class="input_input">
                            <select name="gender" class="select">
                                <option value="1">Nam</option>
                                <option value="2">Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="input">
                        <button class="button" name="signin" value="dang ky">Đăng kí</button>
                    </div>
                    </form>
            </div>
                    <!-- Quen mat khau -->
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
                            <input type="email" id="email" required="required">
                        </div>
                    </div>
                    <!-- end input -->
                    <div class="input">
                        <button class="button" id="apply">Submit</button>
                    </div>
                    <div class="input">
                        <a href="<?php echo $homeurl;?>" class="under">Thoát</a>
                    </div>

                </div>
        </div>
        <!-- div layout -->
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