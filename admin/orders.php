<?php
require_once('../incfiles/core.php');
$textl = "Quản lý đơn đặt hàng của khách hàng";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
$trangthai = array(
    0 => '<font color="black">Đang chờ xử lý</font>',
    1 => '<font color="red">Đơn hàng đã bị hủy</font>',
    2 => '<font color="blue">Đã xác nhận</font>',
    3 => '<font color="green">Đã nhận hàng</font>'
);
$sql = "SELECT `order_id` FROM `order` WHERE `status` = '0'";
$choxuly = mysqli_num_rows(mysqli_query($con,$sql));
$sql1 = "SELECT `order_id` FROM `order` WHERE `status` = '2'";
$xacnhan = mysqli_num_rows(mysqli_query($con,$sql1));
$sql2 = "SELECT `order_id` FROM `order` WHERE `status` = '3'";
$final = mysqli_num_rows(mysqli_query($con,$sql2));
$sql3 = "SELECT `order_id` FROM `order`";
$total = mysqli_num_rows(mysqli_query($con,$sql3));
$sql4 = "SELECT `order_id` FROM `order` WHERE `status` = '1'";
$huy = mysqli_num_rows(mysqli_query($con,$sql4));
?>
<div class="admin_layout">
    <div class="admin_left">
        <div class="admin_menu">Quản lý đơn hàng</div>
        <div class="admin_list">
            <div class="admin_list_item">
                <a href="orders.php">Tất cả đơn hàng (<?php echo $total;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="orders.php?do=choxuly">Đơn hàng chờ xử lý (<?php echo $choxuly;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="orders.php?do=dahuy">Đơn hàng đã hủy (<?php echo $huy;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="orders.php?do=xacnhan">Đơn hàng đã xác nhận (<?php echo $xacnhan;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="orders.php?do=thanhcong">Đơn hàng thành công (<?php echo $final;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="orders.php?do=search">Tìm kiếm order của khách hàng</a>
            </div>
        </div>
    </div>
<!-- Xem chi tiet hoa don -->
<?php
switch($do)
{
    case 'search':
        ?>
        <div class="admin_right">
            <div class="admin_menu">Tìm kiếm order của khách hàng</div>
            <br>
            <form action="" method="post">
            <?php
            if(isset($_POST['tim']))
            {
                $choice = abs(intval($_POST['radio']));
                $khachhang = htmlspecialchars($_POST['ctm']);
                if($choice == 1)
                {
                    $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` 
                    FROM `order` WHERE `fullname` LIKE '%$khachhang%' ORDER BY `order_id` DESC LIMIT $start, $limit";
                }
                else
                {
                    $khachhang = intval($khachhang);
                    $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` 
                    FROM `order` WHERE `user_id` = '$khachhang' ORDER BY `order_id` DESC LIMIT $start, $limit";
                }
                $result = mysqli_query($con,$sql);
                if(mysqli_num_rows($result))
                {
                    ?>
                    <table class="collection" cellspacing="0" cellpadding="0">
            <th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Quản lý</th>
                    <?php
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
                                <a href="orders.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table>
                    <br>
                    <?php
                }
                else
                {
                    echo'<div class="result_no">Không tìm thấy dữ liệu nào liên quan đến khách hàng này !</div>';
                }
            }
            ?>
            <div class="input_input">
                <label class="radio">Tìm theo tên khách hàng
                    <input type="radio" name="radio" value="1" checked="checked">
                    <span class="checkradio"></span>
                </label>
            </div>
            <div class="input_input">
                <label class="radio">Tìm theo ID khách hàng
                    <input type="radio" name="radio" value="2">
                    <span class="checkradio"></span>
                </label>
            </div>
            <div class="input_input">
                <input type="text" name="ctm" required="required"> <button class="button-right" name="tim" value="tim">Tìm</button>
            </div>
            </form>
        </div>
    </div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'chitiet':
        $sqll = "SELECT * FROM `order` INNER JOIN `shipmethod` ON `order`.method_ship_id = `shipmethod`.ship_id WHERE `order_id` = '{$id}' limit 1;";
        $tk = mysqli_query($con,$sqll);
        if(!mysqli_num_rows($tk))
        {
            chuyenhuong();
        }
        $arr = mysqli_fetch_assoc($tk);
        $admin = nick($arr['admin']);
        include('../users/func.php');
        $customer = getUser($arr['user_id']);
        $sql = "SELECT `product_id`, `quantity`, `price` FROM `orderdetails` WHERE `order_id` = '".$arr['order_id']."';";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            ?>
            <div class="admin_right">
            <div class="admin_menu">đơn hàng của <?php echo $customer['fullname'];?></div>
            <div class="donhang">
                <h3>Chi tiết hóa đơn của khách hàng <a href="<?php echo $homeurl.'/users/profile.php?id='.$arr['user_id'];?>"><?php echo $customer['fullname'];?></a></h3>
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
                    <tr>
                        <td class="hoadon-column">Người duyệt đơn hàng</td> <td class="hoadon-chitiet"><?php if(!$admin) echo '<b style="color:red;">Chưa có người duyệt đơn hàng này</b>'; else ?> <a href="<?php echo $homeurl;?>/users/profile.php?id=<?php echo $arr['admin'];?>"><?php echo $admin['username'];?> <?php echo $admin['fullname'];?></a></td>
                    </tr>
                    <tr>
                        <td class="hoadon-column">Lần cuối cập nhật là</td> <td class="hoadon-chitiet"><?php echo $arr['lastupdate'];?></td>
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
            <form action="" method="post">
                <?php
                if(isset($_POST['xacnhan']))
                {
                    $type = abs(intval($_POST['phuongthuc']));
                    $sql = "UPDATE `order` SET `status` = '$type', `admin` = '$user_id',`lastupdate` = '$timeSql' WHERE `order_id` = '$id' limit 1";
                    mysqli_query($con,$sql);
                    if($type == 1)
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
                            loadlai("admin/orders.php?id=$id&do=chitiet");
                        }
                    }
                    else
                    {
                        loadlai("admin/orders.php?id=$id&do=chitiet");
                    }
                    
                }
                ?>
            <div class="input">
                    <div class="input_box">Xác thực đơn hàng</div>
                    <div class="input_input">
                        <select name="phuongthuc" class="select" required="required">
                        <option value="">Lựa chọn của bạn</option>
                        <option value="0" <?php if($arr['status'] == 0) echo 'selected="selected"';?>>Đang chờ xử lý</option>
                        <option value="1" <?php if($arr['status'] == 1) echo 'selected="selected"';?>>Hủy đơn hàng này</option>
                        <option value="2" <?php if($arr['status'] == 2) echo 'selected="selected"';?>>Xác nhận đơn hàng này</option>
                        <option value="3" <?php if($arr['status'] == 3) echo 'selected="selected"';?>>Xác thực đã giao hàng</option>
                        </select>
                        <?php echo isset($error['method']) ? '<div class="error">'.$error['method'].'</div>' : ''; ?>
                    </div>
                </div>
                <br>
                <button class="button-right" name="xacnhan" value="xacnhan">Xác nhận</button>
            </form>
            <a href="orders.php" class="btn-pink">Quay lại</a>
        </div>
        </div>
        <?php
        }
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'choxuly':
        ?>
        <div class="admin_right">
        <div class="admin_menu">Danh sách đơn đặt hàng chờ xử lý</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` FROM `order` WHERE `status` = '0' ORDER BY `order_id` DESC LIMIT $start, $limit";
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
                            <a href="orders.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
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
        $duy = "SELECT `order_id` FROM `order` WHERE `status` = '0'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/orders.php?do=choxuly&u'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'dahuy':
        ?>
        <div class="admin_right">
        <div class="admin_menu">Danh sách đơn đặt hàng đã hủy</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` FROM `order` WHERE `status` = '1' ORDER BY `order_id` DESC LIMIT $start, $limit";
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
                            <a href="orders.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
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
        $duy = "SELECT `order_id` FROM `order` WHERE `status` = '1'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/orders.php?do=dahuy&u'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'xacnhan':
    ?>
<div class="admin_right">
        <div class="admin_menu">Danh sách đơn đặt hàng chờ xử lý</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` FROM `order` WHERE `status` = '2' ORDER BY `order_id` DESC LIMIT $start, $limit";
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
                            <a href="orders.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
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
        $duy = "SELECT `order_id` FROM `order` WHERE `status` = '2'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/orders.php?do=xacnhan&u'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'thanhcong':
        ?>
<div class="admin_right">
        <div class="admin_menu">Danh sách đơn đặt hàng thành công</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` FROM `order` WHERE `status` = '3' ORDER BY `order_id` DESC LIMIT $start, $limit";
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
                            <a href="orders.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
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
        $duy = "SELECT `order_id` FROM `order` WHERE `status` = '3'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/orders.php?do=thanhcong&u'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
}
?>
    <!-- Menu bên tay trái -->
    <div class="admin_right">
        <div class="admin_menu">Danh sách tất cả đơn đặt hàng</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Order ID</th> <th>Họ tên</th> <th>Ngày đặt hàng</th> <th>Tổng</th> <th>Trạng thái</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT `order_id`,`fullname`,`order_date`,`total_price`,`status`,`user_id` FROM `order` ORDER BY `order_id` DESC LIMIT $start, $limit";
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
                            <a href="orders.php?id=<?php echo $res['order_id'];?>&do=chitiet">Xem thêm »</a>
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
        $duy = "SELECT `order_id` FROM `order`";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/orders.php?do'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
<?php
require_once('../incfiles/end.php');
?>