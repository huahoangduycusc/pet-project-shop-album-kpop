<?php
require_once('../incfiles/core.php');
$textl = "Đơn hàng của bạn";
require_once('../incfiles/head.php');
if(!$user_id)
{
    chuyenhuong();
}
$trangthai = array(
    0 => '<font color="black">Đang chờ xử lý</font>',
    1 => '<font color="red">Đơn hàng đã bị hủy</font>',
    2 => '<font color="blue">Đã xác nhận</font>',
    3 => '<font color="green">Đã nhận hàng</font>'
);
?>
<!-- Xem chi tiet hoa don -->
<?php
switch($do)
{
    case 'chitiet':
        $sqll = "SELECT * FROM `order` INNER JOIN `shipmethod` ON `order`.method_ship_id = `shipmethod`.ship_id WHERE `order_id` = '{$id}' AND `user_id` = '$user_id' limit 1;";
        $tk = mysqli_query($con,$sqll);
        if(!mysqli_num_rows($tk))
        {
            chuyenhuong();
        }
        $arr = mysqli_fetch_assoc($tk);
        $sql = "SELECT `product_id`, `quantity`, `price` FROM `orderdetails` WHERE `order_id` = '".$arr['order_id']."';";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            ?>
            <div class="page_title"><a href="<?php echo $homeurl;?>">Trang chủ</a> > <a href="">User</a> > <a href="order.php">Đơn đặt hàng</a></div>
            <div class="donhang">
                <h3>Chi tiết hóa đơn của khách hàng <a href="<?php echo $homeurl.'/users/profile.php?id='.$arr['user_id'];?>"><?php echo $arr['fullname'];?></a></h3>
                <table class="banghoadon" cellspacing="0">
                    <tr>
                        <td class="hoadon-column">Order ID</td> <td class="hoadon-chitiet"><?php echo $arr['order_id'];?></td>
                    <tr>
                    <tr>
                        <td class="hoadon-column">Họ và tên</td> <td class="hoadon-chitiet"><?php echo $arr['fullname'];?></td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Số điện thoại</td> <td class="hoadon-chitiet"><?php echo $arr['phone'];?></td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Ngày đặt hàng</td> <td class="hoadon-chitiet"><?php echo $arr['order_date'];?></td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Địa chỉ giao hàng</td> <td class="hoadon-chitiet"><?php echo $arr['ship_address'];?></td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Phương thức vận chuyển</td> <td class="hoadon-chitiet"><?php echo $arr['ship_name'];?></td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Chi phí vận chuyển</td> <td class="hoadon-chitiet"><?php echo number_format($arr['ship_price']);?> VND</td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Trạng thái đơn hàng</td> <td class="hoadon-chitiet"><?php echo $trangthai[$arr['status']];?></td>
                    </tr>
                </table>
            </div>
            <table width="100%" class="collection" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
            <th>Product</th> <th>Tên sản phẩm</th> <th>Số lượng</th> <th>Giá</th>
            <?php
            while($res = mysqli_fetch_assoc($result))
            {
            ?>
                <tr>
                    <td width="80px;" class="img_product"><a href="<?php echo $homeurl.'/product/index.php?id='.$res['product_id'];?>">
                    <img src="<?php echo $homeurl.'/'.getAnh($res['product_id']);?>"></a>
                    </td>
                    <td>
                    <a href="<?php echo $homeurl.'/product/index.php?id='.$res['product_id'];?>"><?php echo getRow($res['product_id']);?></a>
                    </td>
                    <td><?php echo $res['quantity'];?></td>
                    <td><?php echo number_format($res['price']*$res['quantity']);?> VND</td>
                </tr>
            <?php
            }
            echo'<tr><td colspan="4" class="thongke">Tổng số tiền: '.number_format($arr['total_price']).' VND <span>(Đã bao gồm phí ship)</span></td></tr>';
            ?>
            </table>
            <br>
            <a href="order.php?id=<?php echo $id;?>&do=huy" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')" class="pink-left">Hủy đơn hàng này</a>
            <a href="order.php" class="btn-pink">Quay lại</a>
        <?php
        }
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'huy':
        $sqll = "SELECT `order_id`,`status` FROM `order` WHERE `order_id` = '{$id}' AND `user_id` = '$user_id' limit 1;";
        $tk = mysqli_query($con,$sqll);
        if(!mysqli_num_rows($tk))
        {
            chuyenhuong();
        }
        $arr = mysqli_fetch_assoc($tk);
        if($arr['status'] != 0 && $arr['status'] != 1)
        {
            echo'<div class="error">Đơn hàng này đã được kiểm duyệt, quý khách không thể hủy hóa đơn này !</div>';
        }
        else
        {
            $sql = "SELECT `product_id`, `quantity` FROM `orderdetails` WHERE `order_id` = '".$arr['order_id']."';";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    $sql = "UPDATE `product` SET `quantity` = `quantity` +'".$res['quantity']."' WHERE `product_id` = '".$res['product_id']."' limit 1";
                    mysqli_query($con,$sql);
                }
                $sql = "DELETE FROM `order` WHERE `order_id` = '$id'";
                if(mysqli_query($con,$sql))
                {
                    loadlai("users/order.php");
                }
            }
        }
}
?>
<div class="page_title"><a href="<?php echo $homeurl;?>">Trang chủ</a> > User > <a href="order.php">Đơn hàng của bạn</a></div>
<table width="100%" class="collection" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
<th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Chi tiết</th>
<?php
$sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` FROM `order` WHERE `user_id` = '$user_id' ORDER BY `order_id` DESC LIMIT $start, $limit";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result))
{
    while($res = mysqli_fetch_assoc($result))
    {
        ?>
        <tr>
            <td><?php echo $res['order_id'];?></td>
            <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['fullname'];?></a></td>
            <td><?php echo $res['order_date'];?></td>
            <td style="width:10px;"><?php echo number_format($res['total_price']);?> VND</td>
            <td><?php echo $trangthai[$res['status']];?></td>
            <td class="panel">
                <a href="order.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
            </td>
        </tr>
        <?php
    }
}
else
{
    echo'<div class="result_no">Chưa có bất kỳ đơn đặt hàng nào !</div>';
}
?>
</table>
<?php
    $duy = "SELECT `order_id` FROM `order` WHERE `user_id` = '$user_id'";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'users/order.php?do'
                ];
    $page1 = new Pagination($config);
    ?>
<?php
if($demtrang > $limit)
{
    echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
}
?>
<?php
require_once('../incfiles/end.php');
?>