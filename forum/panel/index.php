<?php
$rootpath = '../../';
require_once('../../incfiles/core.php');
$textl = "Admin Panel - Quản lý diễn đàn";
require_once('../../forum/head.php');
if($right < 9)
{
    loadlai("forum");
}
?>
<!-- quyen han ban quan tris -->
<?php
switch($do)
{
     // danh sach thanh vien bi khoa
     case 'block':
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel</a> / Danh sách thành viên</div>
        <?php
        $sql = "SELECT `user_id`,`ngayhethan` FROM `blockuser` WHERE `ngayhethan` > ".time()." ORDER BY `block_id` DESC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            include('../../users/func.php');
            ?>
            <table class="table table-bordered" cellspacing="0"><tbody>
            <?php
            while($res = mysqli_fetch_assoc($result))
            {
                $nguoidung = getUser($res['user_id']);
                $ngethethan = date("H:i:s \\n\g\à\y d-m-Y",$res['ngayhethan']);
                ?>
                <tr>
                    <td class="tacgia">
                        <div class="box_tacgia">
                            <span style="float:left;padding: 5px 5px 5px 0px;"><img class="avatar" src="<?php echo $homeurl.'/'.$nguoidung['photo'];?>" alt="" style="width: 40px;height: 40px;"></span>
                            <div class="topic_name">Bị cấm đến hết <?php echo $ngethethan;?>
                                <div class="topic_author"><?php echo online($res['user_id']);?> <a href="<?php echo $homeurl;?>/forum/profile.php?id=<?php echo $res['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
                            </div>
                            </div>
                        <!-- topic name -->
                        </div>
                    <!-- box tac gia -->
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody></table>
            <?php
        }
        else
        {
            echo'<div class="alert2 alert-warning">Chưa có tài khoản nào đang bị khóa !</div>';
        }
        $duy = "SELECT `user_id` FROM `blockuser` WHERE `ngayhethan` > ".time()."";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
        $config = [
        'total' => $demtrang,
        'querys' => $id,
        'limit' => $limit,
        'url' => 'forum/panel/?do=block&id'
        ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
        ?>
            <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
        <?php
        }
        ?>
        <p>&#160;</p>
            <p><div class="text-center"><a href="index.php">Quay lại</a></div></p>
            <p>&#160;</p>
        <?php
        require_once('../../forum/end.php');
        exit;
    break;
     // danh sach ban quan tri
     case 'admin':
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel</a> / Danh sách Ban quản trị</div>
        <?php
        $sql = "SELECT `user_id`, `photo` FROM `users` WHERE `status` > 0 AND `right` = '9' ORDER BY `user_id` DESC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            include('../../users/func.php');
            ?>
            <table class="table table-bordered" cellspacing="0"><tbody>
            <?php
            while($res = mysqli_fetch_assoc($result))
            {
                $nguoidung = getUser($res['user_id']);
                ?>
                <tr>
                    <td class="tacgia">
                        <div class="box_tacgia">
                            <span style="float:left;padding: 5px 5px 5px 0px;"><img class="avatar" src="<?php echo $homeurl.'/'.$nguoidung['photo'];?>" alt="" style="width: 40px;height: 40px;"></span>
                            <div class="topic_name">
                                <div class="topic_author"><?php echo online($res['user_id']);?> <a href="<?php echo $homeurl;?>/forum/profile.php?id=<?php echo $res['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
                            </div>
                            </div>
                        <!-- topic name -->
                        </div>
                    <!-- box tac gia -->
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody></table>
            <?php
        }
        else
        {
            echo'<div class="alert2 alert-warning">Chưa có tài khoản nào !</div>';
        }
        $duy = "SELECT `user_id` FROM `users` WHERE `status` > 0 AND `right` = '9'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
        $config = [
        'total' => $demtrang,
        'querys' => $id,
        'limit' => $limit,
        'url' => 'forum/panel/?do=admin&id'
        ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
        ?>
            <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
        <?php
        }
        ?>
        <p>&#160;</p>
            <p><div class="text-center"><a href="index.php">Quay lại</a></div></p>
            <p>&#160;</p>
        <?php
        require_once('../../forum/end.php');
        exit;
    break;
    // danh sach thanh vien
    case 'member':
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel</a> / Danh sách thành viên</div>
        <?php
        $sql = "SELECT `user_id`, `photo` FROM `users` WHERE `status` > 0 AND `right` = '0' ORDER BY `user_id` DESC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            include('../../users/func.php');
            ?>
            <table class="table table-bordered" cellspacing="0"><tbody>
            <?php
            while($res = mysqli_fetch_assoc($result))
            {
                $nguoidung = getUser($res['user_id']);
                ?>
                <tr>
                    <td class="tacgia">
                        <div class="box_tacgia">
                            <span style="float:left;padding: 5px 5px 5px 0px;"><img class="avatar" src="<?php echo $homeurl.'/'.$nguoidung['photo'];?>" alt="" style="width: 40px;height: 40px;"></span>
                            <div class="topic_name">
                                <div class="topic_author"><?php echo online($res['user_id']);?> <a href="<?php echo $homeurl;?>/forum/profile.php?id=<?php echo $res['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
                            </div>
                            </div>
                        <!-- topic name -->
                        </div>
                    <!-- box tac gia -->
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody></table>
            <?php
        }
        else
        {
            echo'<div class="alert2 alert-warning">Chưa có tài khoản nào !</div>';
        }
        $duy = "SELECT `user_id` FROM `users` WHERE `status` > 0 AND `right` = '0'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
        $config = [
        'total' => $demtrang,
        'querys' => $id,
        'limit' => $limit,
        'url' => 'forum/panel/?do=member&id'
        ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
        ?>
            <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
        <?php
        }
        ?>
        <p>&#160;</p>
            <p><div class="text-center"><a href="index.php">Quay lại</a></div></p>
            <p>&#160;</p>
        <?php
        require_once('../../forum/end.php');
        exit;
    break;
    // them chuyen muc moi
    case 'add':
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel</a> / Thêm chuyên mục mới</div>
        <?php
        if(isset($_POST['add']))
        {
            $ten = htmlspecialchars($_POST['cm'],ENT_QUOTES);
            $mota = htmlspecialchars($_POST['mt'],ENT_QUOTES);
            $quyen = intval($_POST['quyen']);
            if(empty($ten) || empty($mota))
            {
                echo'<div class="alert2 alert-warning">Vui lòng không bỏ trống các trường bên dưới</div>';
            }
            else
            {
                $sql = "INSERT INTO `forum_chuyenmuc`(`forum_id`,`forum_name`,`forum_desc`,`forum_quyenhan`) 
                VALUES (NULL,'$ten','$mota','$quyen')";
                if(mysqli_query($con,$sql))
                {
                    loadlai("forum/panel/?do=forum");
                }
            }
        }
        ?>
        <form method="post" name="add">
            <div class="input_box">
                Tên chuyên mục
                <input type="text" class="form-control" name="cm" placeholder="Tên chuyên mục" required="required">
            </div>
            <div class="input_box">
                Mô tả
                <textarea name="mt" rows="5" class="form-control" required="required" placeholder="Mô tả chuyên mục"></textarea>
            </div>
            <p>&#160;</p>
            <div class="input_box">
                Quyền đăng
                <div class="box_input">
                    <input type="radio" name="quyen" value="0" checked="checked"> Tất cả thành viên có thể đăng bài
                    <input type="radio" name="quyen" value="9"> Chỉ có quản trị viên được phép đăng bài
                </div>
            </div>
            <p>&#160;</p>
            <button type="submit" name="add" value="add" class="btn btn-default">Cập nhật</button>
            <p>&#160;</p>
            <p><div class="text-center"><a href="?do=forum">Quay lại</a></div></p>
            <p>&#160;</p>
        </form>
        <?php
        require_once('../../forum/end.php');
        exit;
    break;
    // sua chuyen muc
    case 'edit':
        $sql = "SELECT * FROM `forum_chuyenmuc` WHERE `forum_id` = '$id' LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            loadlai("forum");
        }
        $res = mysqli_fetch_assoc($result);
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel</a> / Chỉnh sửa chuyên mục</div>
        <?php
        if(isset($_POST['add']))
        {
            $ten = htmlspecialchars($_POST['cm'],ENT_QUOTES);
            $mota = htmlspecialchars($_POST['mt'],ENT_QUOTES);
            $quyen = intval($_POST['quyen']);
            if(empty($ten) || empty($mota))
            {
                echo'<div class="alert2 alert-warning">Vui lòng không bỏ trống các trường bên dưới</div>';
            }
            else
            {
                $sql = "UPDATE `forum_chuyenmuc` SET `forum_name` = '$ten', `forum_desc` = '$mota', `forum_quyenhan` = '$quyen'
                WHERE `forum_id` = '$id' LIMIT 1";
                if(mysqli_query($con,$sql))
                {
                    echo'<div class="alert2 alert-success">Cập nhật thành công !</div>';
                }
            }
        }
        ?>
        <form method="post" name="add">
            <div class="input_box">
                Tên chuyên mục
                <input type="text" class="form-control" name="cm" placeholder="Tên chuyên mục" required="required" value="<?php echo $res['forum_name'];?>">
            </div>
            <div class="input_box">
                Mô tả
                <textarea name="mt" rows="5" class="form-control" required="required" placeholder="Mô tả chuyên mục"><?php echo $res['forum_desc'];?></textarea>
            </div>
            <p>&#160;</p>
            <div class="input_box">
                Quyền đăng
                <div class="box_input">
                    <input type="radio" name="quyen" value="0" <?php echo ($res['forum_quyenhan'] == 0) ? 'checked="checked"' : '';?>> Tất cả thành viên có thể đăng bài
                    <input type="radio" name="quyen" value="9" <?php echo ($res['forum_quyenhan'] == 9) ? 'checked="checked"' : '';?>> Chỉ có quản trị viên được phép đăng bài
                </div>
            </div>
            <p>&#160;</p>
            <button type="submit" name="add" value="add" class="btn btn-default">Chỉnh sửa</button>
            <p>&#160;</p>
            <p><div class="text-center"><a href="?do=forum">Quay lại</a></div></p>
            <p>&#160;</p>
        </form>
        <?php
        require_once('../../forum/end.php');
        exit;
    break;
    // xoa chuyen muc
    case 'del':
        $sql = "SELECT `forum_id` FROM `forum_chuyenmuc` WHERE `forum_id` = '$id' LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            loadlai("forum");
        }
        $sql = "DELETE FROM `forum_chuyenmuc` WHERE `forum_id` = '$id' LIMIT 1";
        if(mysqli_query($con,$sql))
        {
            loadlai("forum/panel/?do=forum");
        }
        exit;
    break;
    // quan ly dien dan
    case 'forum':
        ?>
<div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel</a> / Quản lý chuyên mục diễn đàn</div>
<form action="?do=add" name="update" method="post">
    <button type="submit" class="btn btn-default" name="update">Thêm mới</button>
</form>
        <?php
        $sql = "SELECT * FROM `forum_chuyenmuc` ORDER BY `forum_id` DESC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            while($res = mysqli_fetch_assoc($result))
            {
                ?>
                <div class="list1">
                    <a href="<?php echo $homeurl;?>/forum/chuyenmuc.php?id=<?php echo $res['forum_id'];?>"><b><?php echo $res['forum_name'];?></b></a>
                    <p><?php echo $res['forum_desc'];?></p>
                    <p style="float:right;padding-right:5px;">
                    <a href="?do=edit&id=<?php echo $res['forum_id'];?>">Chỉnh sửa</a> |
                    <a href="?do=del&id=<?php echo $res['forum_id'];?>" onclick="return confirm('Bạn có chắc là muốn xóa chuyên mục này?');">Xóa</a>
                    </p>
                </div>
                <?php
            }
        }
        $duy = "SELECT `forum_id` FROM `forum_chuyenmuc`";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
        $config = [
        'total' => $demtrang,
        'querys' => $id,
        'limit' => $limit,
        'url' => 'forum/panel/?do=forum&id'
        ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
        ?>
            <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
        <?php
        }
        ?>
        <p>&#160;</p>
            <p><div class="text-center"><a href="index.php">Quay lại</a></div></p>
            <p>&#160;</p>
        <?php
        require_once('../../forum/end.php');
        exit;
    break;
}
?>
<div class="box_home"><a href="<?php echo $homeurl;?>/forum/panel">Admin Panel - Quản lý diễn đàn</a></div>
<div class="list1"><a href="?do=forum"><i class="fas fa-long-arrow-alt-right"></i> Quản lý chuyên mục diễn đàn</a></div>
<div class="list1"><a href="?do=block"><i class="fas fa-long-arrow-alt-right"></i> Danh sách tài khoản bị cấm</a></div>
<div class="list1"><a href="?do=member"><i class="fas fa-long-arrow-alt-right"></i> Danh sách thành viên</a></div>
<div class="list1"><a href="?do=admin"><i class="fas fa-long-arrow-alt-right"></i> Danh sách BQT</a></div>
<?php
require_once('../../forum/end.php');
?>