<?php
require_once('../incfiles/core.php');
$textl = "Giỏ hàng của bạn ($giohang)";
require_once('../incfiles/head.php');
switch($do)
{
    
    case 'plus':
        if($id == false)
        {
            chuyenhuong();
        }
        $sql = "select * from `product` where `product_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            chuyenhuong();
        }
        $sanpham = mysqli_fetch_assoc($result);
        if($sanpham['quantity'] > $_SESSION['cart'][$id]['quantity'])
        {
        $_SESSION['cart'][$id]['quantity']++;
        }
        else
        {
            notificate("Sản phẩm hiện tại đã hết, quý khách không thể mua thêm !");
        }
        loadlai("product/cart.php");
        exit;
    break;
    case 'minus':
        if($id == false)
        {
            chuyenhuong();
        }
        $sql = "select * from `product` where `product_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            chuyenhuong();
        }
        if($_SESSION['cart'][$id]['quantity'] > 1)
        {
        $_SESSION['cart'][$id]['quantity']--;
        }
        loadlai("product/cart.php");
    break;
    case 'del':
        if($id == false)
        {
            header('Location: '.$homeurl.'/index.php');
            exit;
        }
        $sql = "select * from `product` where `product_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            chuyenhuong();
        }
        unset($_SESSION['cart'][$id]);
        loadlai("product/cart.php");
    break;
}
?>
<div class="cart-header">
                <h2>Giỏ hàng <span>(<?php echo $amount;?> sản phẩm)</span></h2>
            </div>
            <div class="cart-list">
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
                        $sup = "SELECT `company_name` FROM `supplier` where `supplier_id` = '".$res['supplier_id']."'";
                        $sle = mysqli_fetch_assoc(mysqli_query($con,$sup));
                        echo'<div class="list-cart">';
                        echo'<div class="list-cart-thumbial">
                            <img src="'.$homeurl.'/'.getanh($res['product_id']).'">
                        </div>';
                        echo'<div class="list-cart-infor">
                            <span class="name"><a href="'.$homeurl.'/product/index.php?id='.$res['product_id'].'">'.$res['product_name'].'</a></span>
                            <span>Cung cấp bởi '.$sle['company_name'].'</span>
                            <span><a href="?do=del&id='.$res['product_id'].'">Delete</a></span>
                        </div>';
                        if(saleoff($res['product_id']))
                        {
                            $sale = saleoff($res['product_id']);
                            echo'<div class="list-cart-price"><span style="color:red;">KHUYẾN MÃI '.$sale['discount'].'%</span> <span>'.number_format(khuyenmai($res['product_id'])).'VND</span> x '.$_SESSION['cart'][$res['product_id']]['quantity'].'</div>';
                        }
                        else
                        {
                            echo'<div class="list-cart-price"><span>'.number_format($res['product_price']).'VND</span> x <span id="data-id'.$res['product_id'].'">'.$_SESSION['cart'][$res['product_id']]['quantity'].'</span></div>';
                        }
                        echo'<div class="list-cart-qtt">
                                <div class="order-list">
                                        <input type="button" value="-" class="minus" id="minus" data-m="'.$res['product_id'].'">
                                        <input type="text" value="1" id="qtt" readonly>
                                        <input type="button" value="+" class="plus" id="plus" data-s="'.$res['product_id'].'">
                                </div>';
                        echo'</div>';
                    echo'</div>';
                    }
                }
                else
                {
                    echo'Chưa có sản phẩm nào !';
                }
                ?>
                <!--list cart-->
            </div>
            <?php
            $sql = "select * from `product` where `product_id` in (".$id_cart.")";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
            ?>
            <div class="cart-bill">
                <div class="cart-infor">
                    <div class="cart-money"><span class="left-bill">Tổng số tiền:</span> <span class="right-bill" id="tongtien"><?php echo number_format($price_cart);?>đ</span></div>
                    <div class="cart-billing"><span class="left-bill">Thành tiền:</span> <span class="right-bill"><h2 id="thanhtien"><?php echo number_format($price_cart);?>đ</h2></span></div>
                </div>
                <form action="<?php echo $homeurl;?>/product/thanhtoan.php" method="POST">
                    <button class="billing">
                        Tiến hành đặt hàng
                    </button>
                </form>
            </div>
            <?php
            }
            ?>
    <div class="clear"></div>
    <script src="<?php echo $homeurl;?>/product/cart.js"></script>
<?php
require_once('../incfiles/end.php');
?>