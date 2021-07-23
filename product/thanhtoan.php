
<?php
require_once('../incfiles/core.php');
$textl = "Thanh toán Hóa đơn";
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $textl;?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="<?php echo $homeurl;?>/theme/style.css">
    </head>
<body>
<div class="wrap">
    <?php
    if(!$user_id)
    {
        $url = getCurURL();
        loadlai("dangnhap.php?do=$url");
    }
    ?>
        <div class="cart_left">
            <form action="?" method="post" class="form-buy">
            <?php
            if(isset($_POST['dathang']))
            {
                $fname = htmlspecialchars($_POST['fname']);
                $phone = htmlspecialchars($_POST['phone']);
                $dc = htmlspecialchars($_POST['address']);
                $method = abs($_POST['phuongthuc']);
                $error = array();
                if(empty($dc))
                {
                    $error['dc'] = "Vui lòng điền vào địa chỉ";
                }
                if(empty($method))
                {
                    $error['method'] = "Vui lòng chọn phương thức thanh toán";
                }
                if(empty($phone))
                {
                    $error['phone'] = "Vui lòng nhập vào số điện thoại";
                }
                if(empty($fname))
                {
                    $error['fname'] = "Vui lòng nhập đầy đủ họ và tên";
                }
                $sql = "SELECT * FROM `shipmethod` WHERE `ship_id` = '$method' limit 1";
                $result = mysqli_query($con,$sql);
                if(!mysqli_num_rows($result))
                {
                    $error['method'] = "Vui lòng chọn phương thức vận chuyển";
                }
                if(empty($error))
                {
                $timestamp = date("Y-m-d H:i:s");
                $g = mysqli_fetch_assoc($result);
                $total_price = $g['ship_price']+$price_cart-$giamgia; // cong tien ship va tien tat ca san pham, tru tien ma qua tang neu co
                $sql = "INSERT INTO `order`(`order_id`,`fullname`,`phone`,`order_date`,`status`,`ship_address`,`total_price`,`user_id`,`method_ship_id`,`admin`,`lastupdate`)
                values (null,'$fname','$phone','$timestamp','0','$dc','$total_price','$user_id','$method','0','$timeSql')";
                    if(mysqli_query($con,$sql))
                    {
                        $rid = mysqli_insert_id($con);
                        $sql = "select * from `product` where `product_id` in (".$id_cart.")";
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result))
                        {
                            while($res = mysqli_fetch_assoc($result))
                            {
                                $sqll = "INSERT INTO `orderdetails` values (null,'".$res['product_id']."','$rid','".$_SESSION['cart'][$res['product_id']]['quantity']."','".$_SESSION['cart'][$res['product_id']]['price']."')";
                                mysqli_query($con,$sqll);
                                $sql = "UPDATE `product` set `quantity` = `quantity` -'".$_SESSION['cart'][$res['product_id']]['quantity']."' where `product_id` = '".$res['product_id']."' limit 1";
                                mysqli_query($con,$sql);
                            }
                        }
                        if(isset($_SESSION['cart']))
                        {
                            $cart = $_SESSION['cart'];
                            foreach($cart as $key => $value)
                            {
                                unset($_SESSION['cart'][$key]);
                            }
                        }
                        if(isset($_SESSION['giftcode']))
                        {
                            $gifts = $_SESSION['giftcode'];
                            foreach($gifts as $key => $value)
                            {
                                mysqli_query($con,"UPDATE `giftcode` SET `sudung` = '$user_id' WHERE `code_id` = '$key' LIMIT 1");
                            }
                        }
                        unset($_SESSION['giftcode']);
                        loadlai("users/order.php?id=$rid&do=chitiet");
                    }
                    else
                    {
                        mysqli_error($con);
                    }
                }
            }
            ?>
                <div class="logo_image">
                    <img src="<?php echo $homeurl;?>/images/logo.png" alt="">
                </div>
                <div class="thanhtoan">
                <a href="<?php echo $homeurl;?>/product/cart.php">Giỏ hàng</a> > <a href="">Thông tin giao hàng</a>
                </div>
                <div class="input">
                    <div class="input_box">
                       Họ và tên
                    </div>
                    <div class="input_input">
                        <input type="text" name="fname" placeholder="Họ và tên" required="required" value="<?php echo (isset($fname)) ? ''.$fname.'' : '';?>">
                    </div>
                    <?php echo isset($error['fname']) ? '<div class="error">'.$error['fname'].'</div>' : ''; ?>
                </div>
                <div class="input">
                    <div class="input_box">
                       Số điện thoại
                    </div>
                    <div class="input_input">
                        <input type="text" name="phone" placeholder="Số điện thoại" required="required" value="<?php echo (isset($phone)) ? ''.$phone.'' : '';?>">
                    </div>
                    <?php echo isset($error['phone']) ? '<div class="error">'.$error['phone'].'</div>' : ''; ?>
                </div>
                <div class="input">
                    <div class="input_box">
                        Địa chỉ giao hàng
                    </div>
                    <div class="input_input">
                        <textarea name="address" rows="6" placeholder="Địa chỉ giao hàng" required="required"><?php echo (isset($dc)) ? ''.$dc.'' : '';?></textarea>
                    </div>
                    <?php echo isset($error['dc']) ? '<div class="error">'.$error['dc'].'</div>' : ''; ?>
                </div>
                <div class="input">
                    <div class="input_box">Hình thức vận chuyển</div>
                    <div class="input_input">
                        <select name="phuongthuc" class="select" id="ship" required="required">
                        <option value="0">Chọn hình thức</option>
                            <?php
                            $sql = "select * from `shipmethod`";
                            $result = mysqli_query($con,$sql);
                            if(mysqli_num_rows($result))
                            {
                                while($res=mysqli_fetch_assoc($result))
                                {
                                    ?>
                                    <option value="<?php echo $res['ship_id'];?>" data-price="<?php echo $res['ship_price'];?>" onclick="getShip();"><?php echo $res['ship_name'];?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <?php echo isset($error['method']) ? '<div class="error">'.$error['method'].'</div>' : ''; ?>
                    </div>
                </div>
                <div class="input">
                    <a href="<?php echo $homeurl;?>/product/cart.php">< Trở về giỏ hàng</a>
                    <div class="text-right">
                        <button class="button-right" name="dathang" value="dathang">Tiến hành đặt hàng</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="cart_hide" id="cart_hide"><i class="fas fa-cart-plus"></i> Show Product Order <span class="text-right"><?php echo $price_cart;?> VND</span></div>
        <div class="cart-right">
            <div class="cart_line">
                <table class="sanpham_bang">
                <?php
                if(empty($id_cart))
                {
                    $id_cart = 0;
                }
                $sql = "select * from `product` where `product_id` in (".$id_cart.")";
                $result = mysqli_query($con,$sql);
                if(mysqli_num_rows($result))
                {
                    while($res = mysqli_fetch_assoc($result))
                    {
                         echo'<tr>
                         <td class="hinh_sp">
                             <img src="'.$homeurl.'/'.getAnh($res['product_id']).'" alt="">
                             <span class="sp_soluong">'.$_SESSION['cart'][$res['product_id']]['quantity'].'</span>
                         </td>
                         <td class="sp_ten">&#160; '.$res['product_name'].'</td>';
                        echo'
                        <td> '.number_format($_SESSION['cart'][$res['product_id']]['quantity']*$res['product_price']).'VND';
                        if(saleoff($res['product_id']))
                        {
                            $sale = saleoff($res['product_id']);
                            echo'<br><font color="red">'.number_format(khuyenmai($res['product_id'])*$_SESSION['cart'][$res['product_id']]['quantity']).'VND</font>';
                        }
                        echo'</td>
                     </tr>';
                    }
                }
                else
                {
                    chuyenhuong();
                }
                ?>
                </table>
            </div>
            <div class="cart_line">
                <div class="input_input">
                        <input type="text" id="code" placeholder="Mã quà tặng hoặc phiếu giảm giá" class="gift">
                        <button class="button-right" id="apply">Apply</button>
                </div>
                <div id="error" class="error"></div>
                <div id="success" class="success"></div>
            </div>
            <div class="cart_line">
                Tạm tính <span class="text-right"><?php echo number_format($price_cart);?> VND</span>
            </div>
            <div class="cart_line">
                Phí vận chuyển <span class="text-right"><span id="phivc">0</span> VND</span>
            </div>
            <div class="price_total">
                Thành tiền
                <span class="text-right"><span id="tt"><?php echo number_format($price_cart);?></span> VND</span>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    var gift = document.getElementById("apply");
    gift.addEventListener('click',function()
    {
        var code = document.getElementById("code").value;
        var error = document.getElementById("error");
        if(code.length == 0)
        {
            error.innerHTML = "Vui lòng nhập vào mã giftcode";
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
            xmlhttp.open("GET","giftcode.php?q="+code,true);
            xmlhttp.send();
        }
    });
</script>
    <script>
        var hide = document.querySelector("#cart_hide");
        var clicks = false;
        hide.addEventListener('click',function()
        {
            if(clicks == false)
            {
                hide.innerHTML = "<i class=\"fas fa-cart-arrow-down\"></i> Hide Product Order";
                clicks = true;
            }
            else
            {
                hide.innerHTML = "<i class=\"fas fa-cart-arrow-down\"></i> Show Product order";
                clicks = false;
            }
            var cart_right = document.querySelector(".cart-right");
            cart_right.classList.toggle("display");
        });
    </script>
<script>
document.getElementById("ship").onchange = function(event) {
    let get_val = event.target.selectedOptions[0].getAttribute("data-price");
    var number = new Intl.NumberFormat().format(get_val)
    document.getElementById("phivc").innerHTML = number;
    var phi = parseInt(get_val);
    var sotien = <?php echo $price_cart;?>;
    var tong = sotien + phi;
    if(Number.isNaN(tong))
    tong = <?php echo $price_cart;?>;
    document.getElementById("tt").innerHTML = new Intl.NumberFormat().format(tong)
}
</script>