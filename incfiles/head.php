<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $textl;?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="<?php echo $homeurl;?>/theme/style.css">
    <link rel="icon" href='<?php echo $homeurl?>/favicon.png' type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?php echo $homeurl;?>/favicon.png" />
    </head>
<body>
    <header>
        <div class="overlay"></div>
        <nav class="sidebar">
            <div class="close"><i class="fas fa-times"></i></div>
            <ul class="nav-list">
            <li class="nav-item">
                    <a href="" class="nav-link">Trang chủ</a>
                </li>
                <?php
                if($right == 9)
                {
                ?><li class="nav-item">
                    <div class="dropdown">
                        <a href="" class="nav-link dropdown-toggle" me="me4">QUẢN LÝ <i class="fas fa-angle-down down"></i></a>
                        <ul class="nav-list dropdown-content" id="me4">
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/orders.php" class="nav-link">Hóa đơn</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/customer.php" class="nav-link">Người dùng</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/category.php" class="nav-link">Danh mục</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/collection.php" class="nav-link">Collection Idol</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/products.php" class="nav-link">Sản phẩm</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/feedback.php" class="nav-link">Feedback</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/admin/supplier.php" class="nav-link">Nhà cung cấp</a></li>
                        </ul>
                    </div>
                </li>
                <?php
                }
                ?>
                <?php
                if($user_id)
                {
                ?><li class="nav-item">
                    <div class="dropdown">
                        <a href="" class="nav-link dropdown-toggle" me="me">PROFILE <i class="fas fa-angle-down down"></i></a>
                        <ul class="nav-list dropdown-content" id="me">
                            <li class="nav-item"><a href="<?php echo $homeurl.'/users/profile.php?id='.$user_id;?>" class="nav-link">Trang cá nhân</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/users/order.php" class="nav-link">Đơn đặt hàng</a></li>
                            <li class="nav-item"><a href="<?php echo $homeurl;?>/users/feedback.php" class="nav-link">Viết Feedback</a></li>
                        </ul>
                    </div>
                </li>
                <?php
                }
                ?>
                <li class="nav-item">
                    <div class="dropdown">
                        <a href="" class="nav-link dropdown-toggle" me="me1">Nghệ sĩ <i class="fas fa-angle-down down"></i></a>
                        <ul class="nav-list dropdown-content" id="me1">
                            <?php
                            $nghesi = "select `idol_id`, `idol_name` from `idols` order by `idol_id` asc limit 10";
                            $ns = mysqli_query($con,$nghesi);
                            if(mysqli_num_rows($ns))
                            {
                                while($idol = mysqli_fetch_assoc($ns))
                                {
                                    echo'<li class="nav-item"><a href="'.$homeurl.'/collection/index.php?id='.$idol['idol_id'].'" class="nav-link">'.$idol['idol_name'].'</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a href="" class="nav-link dropdown-toggle" me="me2">CATEGORY <i class="fas fa-angle-down down"></i></a>
                        <ul class="nav-list dropdown-content" id="me2">
                        <?php
                            $nghesi = "select `category_id`, `category_name` from `category` order by `category_id` asc limit 10";
                            $ns = mysqli_query($con,$nghesi);
                            if(mysqli_num_rows($ns))
                            {
                                while($idol = mysqli_fetch_assoc($ns))
                                {
                                    echo'<li class="nav-item"><a href="'.$homeurl.'/category/index.php?id='.$idol['category_id'].'" class="nav-link">'.$idol['category_name'].'</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </li>
                <?php
                if(!$user_id)
                {
                echo'<li class="nav-item"><a href="'.$homeurl.'/dangnhap.php" class="nav-link">đăng nhập</a></li>
                <li class="nav-item"><a href="'.$homeurl.'/dangky.php" class="nav-link">đăng ký</a></li>';
                }
                ?>
                <li class="nav-item"><a href="<?php echo $homeurl;?>/aboutus.php" class="nav-link">About us</a></li>
                <li class="nav-item"><a href="<?php echo $homeurl;?>/rest/json.php" class="nav-link">Web REST API</a></li>
            </ul>
        </nav>
        <div class="main-content-header">
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
                <i class="fas fa-times"></i>
            </div>
            <div class="logo-center">
                <a href="<?php echo $homeurl;?>"><img src="<?php echo $homeurl;?>/images/logo.png" alt=""></a>
            </div>
            <div class="header-content">
                <?php
                    if($user_id)
                    {
                        echo'<div class="login"><a href="'.$homeurl.'/exit.php"><i class="fas fa-sign-out-alt"></i></a></div>';
                    }
                    ?>
                    <div class="cart"><a href="<?php echo $homeurl;?>/product/cart.php"><i class="fas fa-cart-plus"></i> <span id="cartsl"><?php echo $giohang;?></span></a></div>
                    <?php
                     if(!$user_id)
                     {
                         echo'<div class="login" id="login"><a href="#login"><i class="fas fa-user"></i></a></div>';
                     }
                     ?>
                     <div class="cart" id="timkiem"><a href="#search"><i class="fas fa-search"></i></a></div>
            </div>
        </div>
    </header>
    <div class="modal-bg">
        <div class="modal">
            <div class="modal-body">
                <h2>Đăng nhập</h2>
                <div id="showerror" style="text-align:center;color:red;font-size:16px;"></div>
               <form action="" method="post" id="submit_login">
                    <input type="text" name="user" id="user" placeholder="Tên tài khoản hoặc email" required="required">
                    <input type="password" name="password" id="password" placeholder="Mật khẩu" required="required">
                    <button type="submit" name="login" value="login" id="loginbtn">Đăng nhập</button>
               </form>
                <span class="modal-close">X</span>
                <div class="forgot"><a href="<?php echo $homeurl;?>/dangnhap.php">Quên mật khẩu?</a></div>
                <div class="forgot">Chưa có tài khoản? <a href="<?php echo $homeurl;?>/dangky.php" id="dangkys">Đăng ký</a></div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal-bg-1">
        <div class="modal">
            <div class="modal-body">
                <h2>Đăng Ký</h2>
                <div id="showerror1" style="text-align:center;color:red;font-size:16px;"></div>
               <form action="" method="post" id="submit_register">
                    <input type="text" name="user" id="username" placeholder="Tên tài khoản hoặc email" required="required">
                    <input type="password" name="pass" id="pass" placeholder="Mật khẩu" required="required">
                    <input type="text" name="email" id="email" placeholder="Email" required="required">
                    <input type="text" name="fname" id="fname" placeholder="Họ tên" required="required">
                    <button type="submit" name="login" value="Đăng ký" id="res">Đăng ký</button>
               </form>
                <span class="modal-close">X</span>
                <div class="forgot">Bạn đã có tài khoản? <a href="<?php echo $homeurl;?>/dangky.php" id="dangnhaps">Đăng nhập</a></div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="search">
        <div class="search-bg">
            <div class="search-close" id="ss"><i class="fas fa-times"></i></div>
            <h2>Tìm kiếm</h2>
            <form action="<?php echo $homeurl?>/search.php" method="get">
                <div class="search-input">
                    <input type="text" name="search" placeholder="Bạn đang tìm gì?">
                    <button class="search1">Search</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // dang nhap
    $('#submit_login').submit(function(){
        var username = $('#user').val();
        var password = $('#password').val();
        $('#showerror').html('Đang xử lý...');
        $('#loginbtn').html("Loading..");
        $.ajax({
                url : '/shop389/login_ajax.php',
                type : 'post',
                dataType : 'json',
                data : {
                    user : username,
                    pass : password
                },
                success : function(result){
                    $('#loginbtn').html("Đăng nhập");
                    $('#showerror').html('');
                    if (!result.hasOwnProperty('error') || result['error'] != 'success')
                    {
                        alert('Có vẻ như bạn đang hack website của tôi');
                        return false;
                    }
                    var html = '';
                    if ($.trim(result.username) != ''){
                        html += result.username + '<br/>';
                    }
                    if ($.trim(result.password) != ''){
                        html += result.password + '<br/>';
                    }
                    if (html != ''){
                        $('#showerror').append(html);
                    }
                    else {
                        // Thành công
                        $('#loginbtn').html("Đang chuyển hướng");
                        window.location.href= "/shop389/index.php";
                    }
                },
                error : function(){
                    alert("Something wrong");
                    $('#loginbtn').html("Đăng nhập");
                }
            });
        return false;
    });
    // dang ky
    $('#submit_register').submit(function(){
        // dang ky
        var user = $('#username').val();
        var password = $('#pass').val();
        var email = $('#email').val();
        var fname = $('#fname').val();
        $('#showerror1').html('Đang xử lý ..');
        $('#res').html("Loading ...");
        $.ajax({
                url : '/shop389/register_ajax.php',
                type : 'post',
                dataType : 'json',
                data : {
                    user : user,
                    pass : password,
                    email : email,
                    fname : fname
                },
                success : function(result){
                    $('#showerror1').html('');
                    $('#res').html("Đăng ký");
                    if (!result.hasOwnProperty('error') || result['error'] != 'success')
                    {
                        alert('Có vẻ như bạn đang hack website của tôi');
                        return false;
                    }
                    var html = '';
                    if ($.trim(result.msg) != ''){
                        html += result.msg + '<br/>';
                    }
                    if (html != ''){
                        $('#showerror1').append(html);
                    }
                    else {
                        // Thành công
                        $('#res').html("Đang chuyển hướng");
                        $('#showerror1').append('Đăng ký tài khoản thành công');
                        window.location.href= "/shop389/index.php";
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                    $('#res').html("Đăng ký");
                }
            });
        return false;
    });
    </script>
    <script>
    var timkiem = document.querySelector("#timkiem");
var search = document.querySelector(".search");
timkiem.addEventListener('click',function()
{
    search.classList.toggle("search_active");
});
// close search
var s_close = document.querySelector("#ss");
s_close.addEventListener('click',function()
{
    search.classList.toggle("search_active");
});</script>
<div class="message-container">
    <div class="message-popup">
        <div class="popup-header" id="popup-header">thông báo</div>
        <div class="popup-content" id="popup-content">text</div>
        <div class="popup-action"><button id="close-popup">Ok</button></div>
    </div>
</div>
<!-- loader -->
<div class="loader-body">
    <div class="loader">
        <div class="loader-inner">
        </div>
    </div>
</div>
    <div class="body">
        <div class="body_content">
            