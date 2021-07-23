<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
$sql = "SELECT `code_id` FROM `giftcode`";
$total = mysqli_num_rows(mysqli_query($con,$sql));
$sql1 = "SELECT `code_id` FROM `giftcode` WHERE `sudung` = '0'";
$cd = mysqli_num_rows(mysqli_query($con,$sql1));
$sql2 = "SELECT `code_id` FROM `giftcode` WHERE `sudung` != '0'";
$dd = mysqli_num_rows(mysqli_query($con,$sql2));
include('../users/func.php');
?>
<div class="admin_layout">
    <div class="admin_left">
        <div class="admin_menu">Quản lý Giftcode</div>
        <div class="admin_list">
            <div class="admin_list_item">
                <a href="giftcode.php">Tất cả Giftcode (<?php echo $total;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="giftcode.php?do=chuasudung">Giftcode chưa sử dụng (<?php echo $cd;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="giftcode.php?do=dasudung">Giftcode đã sử dụng (<?php echo $dd;?>)</a>
            </div>
        </div>
    </div>
    <?php
switch($do)
{
    case 'del':
        $sql = "SELECT `code_id` FROM `giftcode` WHERE `code_id` = '$id' LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            chuyenhuong();
        }
        else
        {
            $sql = "DELETE FROM `giftcode` WHERE `code_id` = '$id'";
            if(mysqli_query($con,$sql))
            {
                loadlai("admin/giftcode.php");
            }
        }
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'edit':
        $sql = "SELECT * FROM `giftcode` WHERE `code_id` = '$id' LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            chuyenhuong();
        }
        $res = mysqli_fetch_assoc($result);
        ?>
        <div class="admin_right">
        <div class="admin_menu">CHỈNH SỬA GIFTCODE</div>
        <form action="" method="post">
            <?php
            if(isset($_POST['gui']))
            {
                $ma = $_POST['ma'];
                $tien = abs(intval($_POST['tien']));
                $fday = $_POST['fday'];
                $tday = $_POST['tday'];
                if(!empty($ma) || !empty($tien))
                {
                    $sql = "UPDATE `giftcode` SET `giftcode` = '$ma',`discount` = '$tien',`fromday` = '$fday', `today` = '$tday' WHERE `code_id` = '$id' LIMIT 1";
                    if(mysqli_query($con,$sql))
                    {
                        loadlai("admin/giftcode.php");
                    }
                }
            }
            ?>
                <div class="input">
                    <div class="input_box">
                        Mã Giftcode
                    </div>
                    <div class="input_input">
                        <input type="text" name="ma" value="<?php echo $res['giftcode']; ?>">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Trị giá (Được tính bằng VND)
                    </div>
                    <div class="input_input">
                        <input type="number" name="tien" value="<?php echo $res['discount'];?>" required="required">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Bắt đầu có hiệu lực
                    </div>
                    <div class="input_input">
                        <input type="date" name="fday" value="<?php echo date("Y-m-d",strtotime($res['fromday']));?>">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Hết hạn sử dụng
                    </div>
                    <div class="input_input">
                        <input type="date" name="tday" value="<?php echo date("Y-m-d",strtotime($res['today']));?>">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <button class="button-right" name="gui" value="gui">Cập nhật</button>
                </div>
                <br>
                <!-- input -->
        </form>
        <br>
        <a href="giftcode.php" class="btn-pink">Quay lại</a>
        </div>
        <!-- end div right -->
    </div>
    <!-- end div layout -->
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'chuasudung':
        ?>
        <div class="admin_right">
        <div class="admin_menu">Danh sách giftcode chưa sử dụng</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Mã</th> <th>Tặng</th> <th>Từ ngày</th> <th>Đến ngày</th> <th>Trạng thái</th> <th>Panel</th>
            <?php
            $sql = "SELECT * FROM `giftcode` WHERE `sudung` = '0' ORDER BY `code_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    ?>
                    <tr>
                        <td><?php echo $res['giftcode'];?></td>
                        <td><?php echo number_format($res['discount']);?>VND</td>
                        <td><?php echo date("Y-m-d",strtotime($res['fromday']));?></td>
                        <td><?php echo date("Y-m-d",strtotime($res['today']));?></td>
                        <td><font color="red">Chưa dùng</font></td>
                        <td class="panel">
                            <a href="?do=edit&id=<?php echo $res['code_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                            <a href="?do=del&id=<?php echo $res['code_id'];?>" onclick="return confirm('Bạn có chắc muốn xóa giftcode này?')"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
                        </td>
                    </tr>
                    <?php
                }
            }
            else
            {
                echo'<div class="result_no">Danh mục trống !</div>';
            }
            ?>
        </table>
        <?php
        $duy = "SELECT `code_id` FROM `giftcode` WHERE `sudung` = '0'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/giftcode.php?do=chuasudung&list'
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
    case 'dasudung':
        ?>
        <div class="admin_right">
        <div class="admin_menu">Danh sách giftcode đã sử dụng</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Mã</th> <th>Tặng</th> <th>Từ ngày</th> <th>Đến ngày</th> <th>Người dùng</th>
            <?php
            $sql = "SELECT * FROM `giftcode` WHERE `sudung` != '0' ORDER BY `code_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    $user = getUser($res['sudung']);
                    ?>
                    <tr>
                        <td><?php echo $res['giftcode'];?></td>
                        <td><?php echo number_format($res['discount']);?>VND</td>
                        <td><?php echo date("Y-m-d",strtotime($res['fromday']));?></td>
                        <td><?php echo date("Y-m-d",strtotime($res['today']));?></td>
                        <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['sudung'];?>"><?php echo $user['username'];?></a></td>
                    </tr>
                    <?php
                }
            }
            else
            {
                echo'<div class="result_no">Danh mục trống !</div>';
            }
            ?>
        </table>
        <?php
        $duy = "SELECT `code_id` FROM `giftcode` WHERE `sudung` != '0'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/giftcode.php?do=dasudung&list'
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
        <div class="admin_menu">Danh sách tất cả giftcode</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>Mã</th> <th>Tặng</th> <th>Từ ngày</th> <th>Đến ngày</th> <th>Sử dụng</th>   <th>Panel</th>
            <?php
            $sql = "SELECT * FROM `giftcode` ORDER BY `code_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    $user = getUser($res['sudung']);
                    ?>
                    <tr>
                        <td><?php echo $res['giftcode'];?></td>
                        <td><?php echo number_format($res['discount']);?>VND</td>
                        <td><?php echo date("Y-m-d",strtotime($res['fromday']));?></td>
                        <td><?php echo date("Y-m-d",strtotime($res['today']));?></td>
                        <td><?php if($res['sudung'] == 0) echo '<font color="red">chưa dùng</font>'; else echo'<a href="'.$homeurl.'/users/profile.php?id='.$res['sudung'].'">'.$user['username'].'</a>';?></td>
                        <td class="panel">
                            <a href="?do=edit&id=<?php echo $res['code_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                            <a href="?do=del&id=<?php echo $res['code_id'];?>" onclick="return confirm('Bạn có chắc muốn xóa giftcode này?')"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
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
        <br>
        <button class="button-right" id="phanhoi">Thêm mới</button>
        <form action="" method="post">
            <?php
            if(isset($_POST['gui']))
            {
                $ma = $_POST['ma'];
                $tien = abs(intval($_POST['tien']));
                $fday = $_POST['fday'];
                $tday = $_POST['tday'];
                if(!empty($ma) || !empty($tien))
                {
                    $sql = "INSERT INTO `giftcode`(`code_id`,`giftcode`,`discount`,`fromday`,`today`,`sudung`) VALUES (NULL,'$ma','$tien','$fday','$tday','0')";
                    if(mysqli_query($con,$sql))
                    {
                        loadlai("admin/giftcode.php");
                    }
                }
            }
            ?>
            <div class="phanhoi" id="add">
                <div class="input">
                    <div class="input_box">
                        Mã (Sẽ được tự động tạo ngẫu nhiên)
                    </div>
                    <div class="input_input">
                        <input type="text" name="ma" value="<?php echo giftcode(9); ?>" readonly>
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Trị giá (Được tính bằng VND)
                    </div>
                    <div class="input_input">
                        <input type="number" name="tien" placeholder="Trị giá" required="required">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Bắt đầu có hiệu lực
                    </div>
                    <div class="input_input">
                        <input type="date" name="fday" value="<?php echo date("Y-m-d");?>">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Hết hạn sử dụng
                    </div>
                    <div class="input_input">
                        <input type="date" name="tday" value="<?php echo date("Y-m-d");?>">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <button class="button-right" name="gui" value="gui">Tạo</button>
                </div>
                <br>
                <!-- input -->
            </div>
            <!-- phanhoi div -->
        </form>
        <a href="products.php" class="btn-pink">Quay lại</a>
        <?php
        $duy = "SELECT `code_id` FROM `giftcode`";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/giftcode.php?do'
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
<script>
    var cmt = document.getElementById("phanhoi");
    var flag = true;
    cmt.addEventListener('click',function()
    {
        var addcmt = document.getElementById("add");
        addcmt.classList.toggle('active');
        if(flag == true)
        {
            flag = false;
            cmt.innerHTML = "Đóng";
        }
        else
        {
            flag = true;
            cmt.innerHTML = "Thêm mới";
        }
    });
</script>
<?php
require_once('../incfiles/end.php');
?>