<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
$products = new product();
?>
<div class="admin_layout">
    <div class="admin_left">
        <div class="admin_menu">Lọc sản phẩm theo</div>
        <div class="admin_list">
            <div class="admin_list_item">
                <a href="products.php">Tất cả các sản phẩm</a>
            </div>
            <div class="admin_list_item">
                <a href="products.php?do=most">Sản phẩm bán chạy nhất</a>
            </div>
            <div class="admin_list_item">
                <a href="products.php?do=soldout">Sản phẩm hết hàng</a>
            </div>
            <?php
            $sql = "SELECT * FROM `category` ORDER BY `category_id` ASC LIMIT 10";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    ?>
                    <div class="admin_list_item">
                        <a href="products.php?do=category&id=<?php echo $res['category_id'];?>">Chuyên mục <?php echo $res['category_name'];?></a>
                    </div>
                    <?php
                }
            }
            ?>

        </div>
    </div>
    <?php
    switch($do)
    {
        case 'del':
            $sql = "SELECT * FROM `product` WHERE `product_id` = '$id'";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                chuyenhuong();
            }
            // cau lenh sau se xoa hinh anh cua san pham tren thu muc server khi ma san pham bi xoa
            $sql = "SELECT `photo_name` FROM `photo` WHERE `product_id` = '$id'";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    unlink("../".$res['photo_name']."");
                }
            }
            $sql = "DELETE FROM `product` WHERE `product_id` = '$id'";
            if(mysqli_query($con,$sql))
            {
                loadlai("admin/products.php");
            }
            exit;
        break;
        case 'khuyenmai':
            switch($for)
            {
                case 'view':
                    $sql = "SELECT * FROM `saleoff` WHERE `sale_id` = '$id' LIMIT 1";
                    $result = mysqli_query($con,$sql);
                    if(!mysqli_num_rows($result))
                    {
                        chuyenhuong();
                    }
                    $res = mysqli_fetch_assoc($result);
                    ?>
                <div class="admin_right">
                    <div class="admin_menu"><?php echo $res['sale_name'];?></div>
                        <div class="feedback">
                            Bắt đầu từ ngày 
                            <b style="color:red;"><?php echo $res['fromday'];?></b> đến hết ngày 
                            <b style="color:red;"><?php echo $res['today'];?></b>
                            <br><br>
                            Khuyến mãi giảm <b style="color:blue;"><?php echo $res['discount'];?>%</b>
                            <br><br>
                            <?php echo nl2br($res['sale_content']);?>

                        </div>
                        <br>
                        <form action="" method="post">
                            <?php
                            if(isset($_POST['cn']))
                            {
                                $radio = isset($_POST['radio']) ? abs(intval($_POST['radio'])) : false;
                                $msg = "";
                                if(!empty($radio))
                                {
                                    if($radio == 1) // bang 1 tuc la khuyen mai ap dung cho tat ca san pham
                                    {
                                        $sql = "UPDATE `product` SET `sale_id` = '$id'";
                                        $msg = "Tất cả sản phẩm !";
                                    }
                                    elseif($radio == 2) // bang 2 thi ap dung theo chuyen muc
                                    {
                                        $category = intval($_POST['category']);

                                        $sql = "UPDATE `product` SET `sale_id` = '$id' WHERE `category_id` = '$category'";
                                        $ars = mysqli_fetch_assoc(mysqli_query($con,"SELECT `category_name` FROM `category` WHERE `category_id` = '$category'"));
                                        $msg = "Chuyên mục sản phẩm ".$ars['category_name'];
                                    }
                                    else // con lai neu bang 3 thi theo collection idol
                                    {
                                        $idol = intval($_POST['idol']);
                                        $sql = "UPDATE `product` SET `sale_id` = '$id' WHERE `idol_id` = '$idol'";
                                        $ars = mysqli_fetch_assoc(mysqli_query($con,"SELECT `idol_name` FROM `idols` WHERE `idol_id` = '$idol'"));
                                        $msg = "Collection Idol ".$ars['idol_name'];

                                    }
                                    if(mysqli_query($con,$sql))
                                    {
                                        echo'<div class="success">Cập nhật khuyến mãi thành công cho '.$msg.'</div>';
                                    }
                                }
                            }
                            ?>
                        <div class="input">
                            <div class="input_box">
                                <h3>Áp dụng khuyến mãi này cho</h3>
                            </div>
                            <div class="input_input">
                                <label class="radio">Toàn bộ sản phẩm
                                    <input type="radio" name="radio" value="1">
                                    <span class="checkradio"></span>
                                </label>
                            </div>
                            <!-- input radio -->
                            <div class="input_input">
                                <label class="radio">Theo chuyên mục sản phẩm
                                    <input type="radio" name="radio" value="2" onclick="appear();">
                                    <span class="checkradio"></span>
                                </label>
                            </div>
                             <!-- select choose -->
                            <div class="input_input">
                                <select name="category" class="select" id="cate" style="margin-left:1.5rem;">
                                    <?php
                                    $sql = "SELECT * FROM `category`";
                                    $result = mysqli_query($con,$sql);
                                    if(mysqli_num_rows($result))
                                    {
                                        while($res=mysqli_fetch_assoc($result))
                                        {
                                            echo'<option value="'.$res['category_id'].'">'.$res['category_name'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <!-- input radio -->
                            <div class="input_input">
                                <label class="radio">Theo Collection Idol
                                    <input type="radio" name="radio" value="3" onclick="appear();">
                                    <span class="checkradio"></span>
                                </label>
                            </div>
                             <!-- select choose -->
                             <div class="input_input">
                                <select name="idol" class="select" id="idol" style="margin-left:1.5rem;">
                                    <?php
                                    $sql = "SELECT * FROM `idols`";
                                    $result = mysqli_query($con,$sql);
                                    if(mysqli_num_rows($result))
                                    {
                                        while($res=mysqli_fetch_assoc($result))
                                        {
                                            echo'<option value="'.$res['idol_id'].'">'.$res['idol_name'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <!-- input radio -->
                        </div>
                        <div class="input">
                            <button class="button-right" name="cn" value="capnhat">Cập nhật</button>
                        </div>
                        </form>
                        <br>
                        <a href="products.php?do=khuyenmai" class="btn-pink">Quay lại</a>
                    </div>
                </div>
                    <!-- end div layout -->
                    <?php
                    require_once('../incfiles/end.php');
                    exit;
                break;
                case 'del':
                    $sql = "SELECT `sale_id` FROM `saleoff` WHERE `sale_id` = '$id' LIMIT 1";
                    $result = mysqli_query($con,$sql);
                    if(!mysqli_num_rows($result))
                    {
                        chuyenhuong();

                    }
                    $res = mysqli_fetch_assoc($result);
                    if($res['sale_id'] == 1)
                    {
                        echo'<div class="admin_right">
                                <div class="admin_menu">CẢNH BÁO</div>
                            <div class="feedback">
                                <b style="color:red;">Bạn không thể xóa khuyến mãi mặc định này</b>
                            </div>
                            <br>
                            <a href="products.php?do=khuyenmai" class="btn-pink">Quay lại</a>
                            </div>
                        </div>';
                    }
                    else
                    {
                        $sql = "DELETE FROM `saleoff` WHERE `sale_id` = '$id'";
                        if(mysqli_query($con,$sql))
                        {
                            loadlai("admin/products.php?do=khuyenmai");
                        }
                    }
                    require_once('../incfiles/end.php');
                    exit;
                break;
                case 'edit':
                    $sql = "SELECT * FROM `saleoff` WHERE `sale_id` = '$id' LIMIT 1";
                    $result = mysqli_query($con,$sql);
                    if(!mysqli_num_rows($result))
                    {
                        chuyenhuong();

                    }
                    $res = mysqli_fetch_assoc($result);
                    if($res['sale_id'] == 1)
                    {
                        echo'<div class="admin_right">
                                <div class="admin_menu">CẢNH BÁO</div>
                            <div class="feedback">
                                <b style="color:red;">Bạn không thể chỉnh sửa khuyến mãi mặc định này</b>
                            </div>
                            <br>
                            <a href="products.php?do=khuyenmai" class="btn-pink">Quay lại</a>
                            </div>
                        </div>';
                        require_once('../incfiles/end.php');
                        exit;
                    }
                    ?>
                <div class="admin_right">
                    <div class="admin_menu"><?php echo $res['sale_name'];?></div>
                    <form action="" method="post">
                    <?php
                        if(isset($_POST['gui']))
                        {
                            $ten = htmlspecialchars($_POST['km'], ENT_QUOTES);
                            $nd = htmlspecialchars($_POST['nd'], ENT_QUOTES);
                            $fday = $_POST['fday'];
                            $tday = $_POST['tday'];
                            $giam = abs(intval($_POST['giam']));
                            if(!empty($ten) || !empty($nd) and !empty((int)$fday) and !empty((int)$tday))
                            {
                                $sql = "UPDATE `saleoff` SET `sale_name` = '$ten',`sale_content` = '$nd',`fromday` = '$fday',`today` = '$tday',
                                `discount` = '$giam' WHERE `sale_id` = '$id' LIMIT 1";
                                if(mysqli_query($con,$sql))
                                {
                                    loadlai("admin/products.php?do=khuyenmai&for=edit&id=$id");
                                }
                            }
                        }
                        ?>
                        <div class="input">
                        <div class="input_box">
                            Tên khuyến mãi
                        </div>
                        <div class="input_input">
                            <input type="text" name="km" required="required" value="<?php echo $res['sale_name'];?>">
                        </div>
                    </div>
                    <!-- input -->
                    <div class="input">
                        <div class="input_box">
                            Nội dung khuyến mãi
                        </div>
                        <div class="input_input">
                            <textarea name="nd" rows="7" required="required"><?php echo $res['sale_content'];?></textarea>
                        </div>
                    </div>
                    <!-- input -->
                    <div class="input">
                        <div class="input_box">
                            Bắt đầu từ ngày
                        </div>
                        <div class="input_input">
                            <input type="date" name="fday" value="<?php echo $res['fromday'];?>">
                        </div>
                    </div>
                    <!-- input -->
                    <div class="input">
                        <div class="input_box">
                            Đến hết ngày
                        </div>
                        <div class="input_input">
                            <input type="date" name="tday" value="<?php echo $res['today'];?>">
                        </div>
                    </div>
                    <!-- input -->
                    <div class="input">
                        <div class="input_box">Giảm</div>
                        <div class="input_input">
                            <select name="giam" class="select" required="required">
                            <?php
                            for($i=5;$i<=100;$i+=5)
                            {
                                echo'<option value="'.$i.'"'; if($res['discount'] == $i) echo 'selected="selected"';echo'>Giảm '.$i.' %</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="input">
                        <button class="button-right" name="gui" value="gui">Gửi</button>
                    </div>
                    </form>
                    <br>
                    <a href="products.php?do=khuyenmai" class="btn-pink">Quay lại</a>
                 </div>
                </div> 
                <!-- end div chia layout -->
                    <?php
                    require_once('../incfiles/end.php');
                    exit;
                break;
            }
            ?>
        <div class="admin_right">
            <div class="admin_menu">quản lý chương trình khuyến mãi</div>
            <table class="collection" cellspacing="0" cellpadding="0">
            <th>Tên</th> <th>Từ ngày</th> <th>Đến ngày</th> <th>Giảm</th> <th>Panel</th>
            <?php
            $sql = "SELECT * FROM `saleoff` ORDER BY `sale_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    ?>
                    <tr>
                        <td><a href="products.php?do=khuyenmai&for=view&id=<?php echo $res['sale_id'];?>"><?php echo $res['sale_name'];?></a></td>
                        <td><?php echo $res['fromday'];?></td>
                        <td><?php echo $res['today'];?></td>
                        <td><?php echo $res['discount'];?>%</td>
                        <td class="panel">
                            <a href="?do=khuyenmai&for=edit&id=<?php echo $res['sale_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                            <a href="?do=khuyenmai&for=del&id=<?php echo $res['sale_id'];?>" onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này? Tất cả sản phẩm sẽ trở về giá thường?')"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
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
        <button class="button-right" id="themmoi">Thêm mới</button>
        <form action="" method="post">
            <?php
            if(isset($_POST['gui']))
            {
                $ten = htmlspecialchars($_POST['km'], ENT_QUOTES);
                $nd = htmlspecialchars($_POST['nd'], ENT_QUOTES);
                $fday = $_POST['fday'];
                $tday = $_POST['tday'];
                $giam = abs(intval($_POST['giam']));
                if(!empty($ten) || !empty($nd) || !empty($fday) || !empty($tday) || !empty($giam))
                {
                    $sql = "INSERT INTO `saleoff`(`sale_id`,`sale_name`,`sale_content`,`fromday`,`today`,`discount`) 
                    VALUES (NULL,'$ten','$nd','$fday','$tday','$giam')";
                    if(mysqli_query($con,$sql))
                    {
                        loadlai("admin/products.php?do=khuyenmai");
                    }
                }
            }
            ?>
            <div class="phanhoi" id="add">
                <div class="input">
                    <div class="input_box">
                        Tên khuyến mãi
                    </div>
                    <div class="input_input">
                        <input type="text" name="km" required="required" placeholder="Tên chương trình khuyến mãi">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Nội dung khuyến mãi
                    </div>
                    <div class="input_input">
                        <textarea name="nd" rows="7" placeholder="Nội dung chi tiết khuyến mãi" required="required"></textarea>
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Bắt đầu từ ngày
                    </div>
                    <div class="input_input">
                        <input type="date" name="fday">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Đến hết ngày
                    </div>
                    <div class="input_input">
                        <input type="date" name="tday">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">Giảm</div>
                    <div class="input_input">
                        <select name="giam" class="select" required="required">
                        <?php
                        for($i=5;$i<=100;$i+=5)
                        {
                            echo'<option value="'.$i.'">Giảm '.$i.' %</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="input">
                    <button class="button-right" name="gui" value="gui">Lưu</button>
                </div>
                <br>
                <!-- input -->
            </div>
            <!-- phanhoi div -->
        </form>
        <a href="products.php" class="btn-pink">Quay lại</a>
        <?php
        $duy = "SELECT `sale_id` FROM `saleoff`";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/products.php?do=khuyenmai&list'
                    ];
        $page1 = new Pagination($config);
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
        </div>
    </div>
<script>
    var cmt = document.getElementById("themmoi");
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
            exit;
        break;
        case 'ship':
            switch($for)
            {
                case 'del':
                    $sql = "SELECT * FROM `shipmethod` WHERE `ship_id` = '$id' LIMIT 1";
                    $result = mysqli_query($con,$sql);
                    if(!mysqli_num_rows($result))
                    {
                        chuyenhuong();
                    }
                    $res = mysqli_fetch_assoc($result);
                    if($res['ship_id'] == 1)
                    {
                        echo'<div class="admin_right">
                                <div class="admin_menu">CẢNH BÁO</div>
                            <div class="feedback">
                                <b style="color:red;">Bạn không xóa phương thức nhận hàng mặc định này</b>
                            </div>
                            <br>
                            <a href="products.php?do=ship" class="btn-pink">Quay lại</a>
                            </div>
                        </div>';
                        require_once('../incfiles/end.php');
                        exit;
                    }
                    else
                    {
                        $sql = "DELETE FROM `shipmethod` WHERE `ship_id` = '$id'";
                        if(mysqli_query($con,$sql))
                        {
                            loadlai("admin/products.php?do=ship");
                        }
                    }
                    require_once('../incfiles/end.php');
                    exit;
                break;
                case 'edit':
                    $sql = "SELECT * FROM `shipmethod` WHERE `ship_id` = '$id' LIMIT 1";
                    $result = mysqli_query($con,$sql);
                    if(!mysqli_num_rows($result))
                    {
                        chuyenhuong();
                    }
                    $res = mysqli_fetch_assoc($result);
                    if($res['ship_id'] == 1)
                    {
                        echo'<div class="admin_right">
                                <div class="admin_menu">CẢNH BÁO</div>
                            <div class="feedback">
                                <b style="color:red;">Bạn không chỉnh sửa phương thức nhận hàng mặc định này</b>
                            </div>
                            <br>
                            <a href="products.php?do=ship" class="btn-pink">Quay lại</a>
                            </div>
                        </div>';
                        require_once('../incfiles/end.php');
                        exit;
                    }
                    ?>
                    <div class="admin_right">
                    <div class="admin_menu"><?php echo $res['ship_name'];?></div>
                    <form action="" method="post">
                    <?php
                        if(isset($_POST['capnhat']))
                        {
                            $ten = htmlspecialchars($_POST['pt'], ENT_QUOTES);
                            $gia = abs(intval($_POST['gia']));
                            if(!empty($ten) || !empty($gia))
                            {
                                $sql = "UPDATE `shipmethod` SET `ship_name` = '$ten',`ship_price` = '$gia' WHERE `ship_id` = '$id' LIMIT 1";
                                if(mysqli_query($con,$sql))
                                {
                                    loadlai("admin/products.php?do=ship&for=edit&id=$id");
                                }
                            }
                        }
                        ?>
                        <div class="input">
                            <div class="input_box">
                                Tên phương thức
                            </div>
                            <div class="input_input">
                                <input type="text" name="pt" required="required" value="<?php echo $res['ship_name'];?>">
                            </div>
                        </div>
                        <div class="input">
                            <div class="input_box">
                                Giá
                            </div>
                            <div class="input_input">
                                <input type="number" name="gia" required="required" value="<?php echo $res['ship_price'];?>">
                            </div>
                        </div>
                        <div class="input">
                            <button class="button-right" name="capnhat" value="capnhat">Cập nhật</button>
                        </div>
                    <!-- end intput div -->
                    <br>
                    <a href="products.php?do=ship" class="btn-pink">Quay lại</a>
                </div>
                    <!-- end div right -->
            </div>
            <!-- end div layout -->
                    <?php
                    require_once('../incfiles/end.php');
                    exit;
                break;
            }
            ?>
            <div class="admin_right">
            <div class="admin_menu">quản lý phương thức chuyển hàng</div>
            <table class="collection" cellspacing="0" cellpadding="0">
            <th>SHIP ID</th> <th>Tên phương thức</th> <th>Giá vận chuyển</th><th>Panel</th>
            <?php
            $sql = "SELECT * FROM `shipmethod` ORDER BY `ship_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    ?>
                    <tr>
                        <td><?php echo $res['ship_id'];?></td>
                        <td><a href="products.php?do=ship&for=view&id=<?php echo $res['ship_id'];?>"><?php echo $res['ship_name'];?></a></td>
                        <td><?php if($res['ship_price'] > 0) echo number_format($res['ship_price']).' VND'; else echo '<font color="red">Miễn phí</font>';?></td>
                        <td class="panel">
                            <a href="?do=ship&for=edit&id=<?php echo $res['ship_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                            <a href="?do=ship&for=del&id=<?php echo $res['ship_id'];?>" onclick="return confirm('Bạn có chắc muốn xóa phương thức chuyển hàng này? Tất cả sản phẩm sẽ trở về phương thức mặc định?')"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
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
        <button class="button-right" id="themmoi">Thêm mới</button>
        <form action="" method="post">
            <?php
            if(isset($_POST['gui']))
            {
                $ten = htmlspecialchars($_POST['pt'], ENT_QUOTES);
                $gia = abs(intval($_POST['gia']));
                if(!empty($ten) || !empty($gia))
                {
                    $sql = "INSERT INTO `shipmethod`(`ship_id`,`ship_name`,`ship_price`) 
                    VALUES (NULL,'$ten','$gia')";
                    if(mysqli_query($con,$sql))
                    {
                        loadlai("admin/products.php?do=ship");
                    }
                }
            }
            ?>
            <div class="phanhoi" id="add">
                <div class="input">
                    <div class="input_box">
                        Tên phương thức chuyển hàng
                    </div>
                    <div class="input_input">
                        <input type="text" name="pt" required="required" placeholder="Tên phương thức vận chuyển">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Giá vận chuyển
                    </div>
                    <div class="input_input">
                        <input type="number" name="gia" required="required" placeholder="Giá vận chuyển">
                    </div>
                </div>
                <div class="input">
                    <button class="button-right" name="gui" value="gui">Lưu</button>
                </div>
                <br>
                <!-- input -->
            </div>
            <!-- phanhoi div -->
        </form>
        <a href="products.php" class="btn-pink">Quay lại</a>
            <?php
            $duy = "SELECT `ship_id` FROM `shipmethod`";
            $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                        $config = [
                            'total' => $demtrang,
                            'querys' => $id,
                            'limit' => $limit,
                            'url' => 'admin/products.php?do=ship&list'
                        ];
            $page1 = new Pagination($config);
            if($demtrang > $limit)
            {
                echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
            }
            ?>
        </div>
        <!-- end div admin right -->
    </div>
        <!-- end div layout -->
<script>
    var cmt = document.getElementById("themmoi");
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
            exit;
        break;
    }
    ?>
    <!-- menu left -->
    <div class="admin_right">
        <div class="admin_menu">quản lý sản phẩm</div>
        <div class="admin_list">
            <div class="admin_list_item">
                <a href="update.php">Thêm sản phẩm mới</a>
            </div>
            <div class="admin_list_item">
                <a href="products.php?do=khuyenmai">Quản lý các chương trình khuyến mãi</a>
            </div>
            <div class="admin_list_item">
                <a href="products.php?do=ship">Quản lý phương thức chuyển hàng</a>
            </div>
            <div class="admin_list_item">
                <a href="giftcode.php">Quản lý mã quà tặng (Giftcode)</a>
            </div>
        </div>
    </div>
</div>
<?php
switch($do)
{
    case 'category':
        $sql = "SELECT * FROM `category` WHERE `category_id` = '$id'";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            chuyenhuong();
        }
        $res = mysqli_fetch_assoc($result);
        ?>
        <div class="danhmuc">CATEGORY <?php echo $res['category_name'];?></div>
        <?php echo $products->getList($start,$limit,$id);?>
        <?php
        $duy = "SELECT `product_id` FROM `product` WHERE `category_id` = '$id'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/products.php?do=category&id'
                    ];
        $page1 = new Pagination($config);
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'soldout':
        echo'<div class="danhmuc">sản phẩm sold out</div>';
        echo $products->soldOut($start,$limit);
        $duy = "SELECT `product_id` FROM `product` WHERE `quantity` = '0'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/products.php?do=soldout&list'
                    ];
        $page1 = new Pagination($config);
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'most':
        echo'<div class="danhmuc">sản phẩm bán chạy nhất</div>';
        echo $products->mostProduct(10);
        require_once('../incfiles/end.php');
        exit;
    break;

}
?>
<div class="danhmuc">tất cả sản phẩm</div>
<?php
echo $products->getAll($start,$limit);
?>
        <?php
        $duy = "SELECT `product_id` FROM `product`";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/products.php?do'
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