<?php
require_once('../incfiles/core.php');
require_once('head.php');
if(empty($id) || $id == false)
{
    $id = $user_id;
}
if(!$user_id)
{
    loadlai("forum");
}
$sql = "SELECT `user_id` FROM `users` WHERE `user_id` = '$id' LIMIT 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    loadlai("forum");
}
$res = mysqli_fetch_assoc($result);
include('../users/func.php');
include('func.php');
$taikhoan = getUser($res['user_id']);
switch($for)
{
    // thong bao cua ban
    case 'notification':
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum">Diễn đàn KPOP</a> / Thông báo của bạn</div>
        <?php
        $sql = "SELECT * FROM `thongbao` WHERE `user_id` = '$user_id' ORDER BY `thongbao_id` DESC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
        while($res = mysqli_fetch_assoc($result))
        {
            ?>
            <div class="<?php echo ($res['daxem']) == 0 ? 'list2' : 'list1';?>">
            <?php echo $res['message'];?>
            <div class="box_time_bviet"><?php echo thoigian($res['thoigian']);?></div>
            </div>
            <?php
        }
        mysqli_query($con,"UPDATE `thongbao` SET `daxem` = '1' WHERE `user_id` = '$user_id'");
        }
        else
        {
            echo'<div class="alert2 alert-warning">Bạn chưa có thông báo nào !</div>';
        }
        $duy = "SELECT `thongbao_id` FROM `thongbao` WHERE `user_id` = '$user_id'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
        $config = [
        'total' => $demtrang,
        'querys' => $id,
        'limit' => $limit,
        'url' => 'forum/profile.php?for=notification&&id'
        ];
        $page1 = new Pagination($config);
        if($demtrang > $limit)
                {
                    ?>
                    <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
                    <?php
                }
                ?>
        <?php
        require_once('end.php');
        exit;
    break;
    case 'unwatch':
        $uid = isset($_GET['watch']) ? intval($_GET['watch']) : false;
        if(!$user_id)
            {
                loadlai("forum");
            }
            $sql = "select * from `topic_theodoi` where `user_id` = '$user_id' and `topic_id` = '$uid' limit 1";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                $res = mysqli_fetch_assoc($result);
                $sql = "delete from `topic_theodoi` where `theodoi_id` = '".$res['theodoi_id']."' limit 1";
                if(mysqli_query($con,$sql))
                {
                    loadlai("forum/profile.php?for=follow");
                }
            }
            else
            {
                loadlai("forum/profile.php?for=follow");
            }
        exit;
    break;
    case 'follow':
        ?>
        <div class="box_home"><a href="<?php echo $homeurl;?>/forum">Diễn đàn KPOP</a> / Theo dõi</div>
        <?php
        $sql = "SELECT `forum_topic`.`topic_id`, `forum_topic`.`topic_name`,`forum_topic`.`user_id`,`topic_theodoi`.`theodoi_id` FROM `forum_topic`
        INNER JOIN `topic_theodoi` ON `forum_topic`.`topic_id` = `topic_theodoi`.`topic_id`
        WHERE `topic_theodoi`.`user_id` = '$user_id' ORDER BY `topic_theodoi`.`theodoi_id` DESC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
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
                            <div class="topic_name">
                                <a href="view.php?id=<?php echo $res['topic_id'];?>" class="alert_link"><?php echo $res['topic_name'];?></a>
                                <div class="topic_author">bởi <a href="profile.php?id=<?php echo $res['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
                                <br>
                                <button class="btn btn-success btn-xs" onclick='location.href="profile.php?for=unwatch&watch=<?php echo $res['topic_id'];?>"' name="watch" type="submit" value="submit">Bỏ theo dõi</button>
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
            echo'<div class="alert2 alert-warning">Bạn chưa theo dõi bài viết nào !</div>';
        }
        $duy = "SELECT `theodoi_id` FROM `topic_theodoi` WHERE `user_id` = '$user_id'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'forum/profile.php?for=follow&&id'
                            ];
                $page1 = new Pagination($config);
                if($demtrang > $limit)
                {
                    ?>
                    <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
                    <?php
                }
                ?>
        <?php
        require_once('end.php');
        exit;
    break;
}
// khi nguoi dung an chinh sua thong tin ca nhan
switch($do)
{
    case 'setting':
        if($user_id != $id && $right < 9)
        {
            loadlai("forum");
        }
        $namsinh = date("Y");
        ?>
    <div class="box_avatar">
    <center><img class="avatar" src="<?php echo $homeurl.'/'.$taikhoan['photo'];?>" width="50px;" style="height:50px;max-width: 100%;"></center>
        </div>
        <form method="post" name="capnhat" enctype="multipart/form-data">
        <?php
        if(isset($_POST['capnhat']))
        {
            $name = htmlspecialchars($_POST['name']);
            $gender = htmlspecialchars($_POST['gender']);
            $dc = htmlspecialchars($_POST['diachi']);
            $sdt = htmlspecialchars($_POST['sdt']);
            $mail = htmlspecialchars($_POST['email']);
            $dob = htmlspecialchars($_POST['dob']);
            $mob = htmlspecialchars($_POST['mob']);
            $yob = htmlspecialchars($_POST['yob']);
            if($right >= 9)
            {
                $chucvu = isset($_POST['cv']) ? intval($_POST['cv']) : 0;
            }
            else
            {
                $chucvu = 0;
            }
            $sql = "UPDATE `users` SET `fullname` = '$name', `gender` = '$gender', `address` = '$dc', `phone` = '$sdt',
            `email` = '$mail', `dob` = '$dob', `mob` = '$mob', `yob` = '$yob', `right` = '$chucvu' WHERE `user_id` = '$id' limit 1";
            if(mysqli_query($con,$sql))
            {
                if($_FILES['avatar']['name'] != "")
                {
                    $filename = date("ymdHis");
                    $path = $_FILES['avatar']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
                    $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
                    if (in_array($ext, $validextensions)) // tìm đuôi phù hợp
                    {
                        move_uploaded_file($_FILES['avatar']['tmp_name'],'../photo/users/'.$filename.'.'.$ext);
                        $sql = "UPDATE `users` SET `photo` = 'photo/users/$filename.$ext' WHERE `user_id` = '$id' LIMIT 1";
                        mysqli_query($con,$sql);
                    }
                    else
                    {
                        //echo"<div class='error'>Định dạng ảnh không hợp lệ, ảnh phải có đuôi là .PNG, .JPG và .JPEG</div>";
                    }
                }
                loadlai("forum/profile.php?id=$id");
            }
        }
        ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered2">
                <tbody>
                    <tr>
                        <td class="left">ID</td>
                        <td class="right">
                            <span><?php echo $taikhoan['username'];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Tên thật</td>
                        <td class="right">
                            <input type="text" name="name" class="form-control" value="<?php echo $taikhoan['fullname'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Giới tính</td>
                        <td class="right">
                            <select name="gender" class="form-control">
                                <option value="1" <?php if($taikhoan['gender'] == 1) echo 'selected="selected"';?>>Nam</option>
                                <option value="2" <?php if($taikhoan['gender'] == 2) echo 'selected="selected"';?>>Nữ</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Ngày sinh</td>
                        <td class="right">
                        <select name="dob" style="width:50px;">
                            <?php
                            for($i=1;$i<=31;$i++)
                            {
                            ?>
                            <option value="<?php echo $i;?>" <?php if($taikhoan['dob'] == $i) echo 'selected="selected"';?>"><?php echo $i;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <select name="mob" style="width:50px;">
                            <?php
                            for($i=1;$i<=12;$i++)
                            {
                            ?>
                            <option value="<?php echo $i;?>" <?php if($taikhoan['mob'] == $i) echo 'selected="selected"';?>"><?php echo $i;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <select name="yob" style="width:70px;">
                            <?php
                            for($i=1930;$i<=$namsinh;$i++)
                            {
                            ?>
                            <option value="<?php echo $i;?>" <?php if($taikhoan['yob'] == $i) echo 'selected="selected"';?>"><?php echo $i;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Địa chỉ</td>
                        <td class="right">
                            <input type="text" name="diachi" class="form-control" value="<?php echo $taikhoan['address'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Điện thoại</td>
                        <td class="right">
                            <input type="text" name="sdt" class="form-control" value="<?php echo $taikhoan['phone'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Email</td>
                        <td class="right">
                            <input type="text" name="email" class="form-control" value="<?php echo $taikhoan['email'];?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Ảnh đại diện</td>
                        <td class="right">
                            <input type="file" name="avatar" class="form-control">
                        </td>
                    </tr>
                    <?php
                    if($right >= 9)
                    {
                        ?>
                        <tr>
                            <td class="left">Chức vụ diễn đàn</td>
                            <td class="right">
                                <select name="cv" class="form-control">
                                    <option value="0" <?php if($taikhoan['right'] == 0) echo 'selected="selected"';?>>Thành viên</option>
                                    <option value="9" <?php if($taikhoan['right'] == 9) echo 'selected="selected"';?>>Admin</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div style="text-align:center;width:100%;">
                <p>&#160;</p>
                <button type="submit" name="capnhat" value="capnhat" class="btn btn-default">Cập nhật</button>
                <p>&#160;</p>
            </div>
        </form>
        <?php
        require_once('end.php');
        exit;
    break;
    case 'search':
        switch($for)
        {
            case 1:
                $duy = "SELECT `topic_id` FROM `forum_topic` WHERE `user_id` = '$id'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'forum/profile.php?do=search&for=1&id'
                            ];
                $page1 = new Pagination($config);
                ?>
                <div class="box_home"><a href="<?php echo $homeurl;?>/forum">Diễn đàn KPOP</a> / Kết quả tìm kiếm</div>
                <div class="box_list_chuyenmuc">
                <?php
                if($demtrang > $limit)
                {
                    ?>
                    <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
                    <?php
                }
                ?>
                    <?php
                    $sql = "SELECT `forum_topic`.`topic_id`, `topic_name`,`forum_topic`.`user_id`,`topic_comment`.`message`, `forum_topic`.`topic_view`
                     FROM `forum_topic` 
                    LEFT JOIN `topic_comment` ON `forum_topic`.`topic_id` = `topic_comment`.`topic_id`
                    WHERE `topic_comment`.`type` = 1 AND `forum_topic`.`user_id` = '$id' ORDER BY `topic_id` DESC LIMIT $start,$limit";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($res = mysqli_fetch_assoc($result))
                        {
                            $nd = getUser($res['user_id']);
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading"><a href="view.php?id=<?php echo $res['topic_id'];?>"><?php echo $res['topic_name'];?></a>
                                    <div class="author">bởi <a href="profile.php?id=<?php echo $res['user_id'];?>"><?php echo $nd['username'];?></a>
                                <?php echo reply($res['topic_id']);?>
                                - Xem : <?php echo $res['topic_view'];?>
                                </div>
                                </div>
                                <div class="panel-body">
                                    <span><?php echo $res['message'];?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                   <?php
                    if($demtrang > $limit)
                    {
                        ?>
                        <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
                        <?php
                    }
                    ?>
                </div>
                 <!-- box list chuyen muc -->
                <?php
                require_once('end.php');
                exit;
            break;
            case 2:
                $duy = "SELECT `comment_id` FROM `topic_comment` WHERE `user_id` = '$id'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'forum/profile.php?do=search&for=2&id'
                            ];
                $page1 = new Pagination($config);
                ?>
                <div class="box_home"><a href="<?php echo $homeurl;?>/forum">Diễn đàn KPOP</a> / Kết quả tìm kiếm</div>
                <div class="box_list_chuyenmuc">
                    <?php
                    if($demtrang > $limit)
                    {
                        ?>
                        <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
                        <?php
                    }
                    ?>
                    <?php
                    $sql = "SELECT `topic_id`, `user_id`, `message`, `comment_time` FROM `topic_comment` 
                    WHERE `user_id` = '$id' AND `type` = 0 ORDER BY `comment_id` DESC LIMIT $start,$limit";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($res = mysqli_fetch_assoc($result))
                        {
                            $nd = getUser($res['user_id']);
                            ?>
                            <div class="panel panel-default duy-padding">
                                <table cellpadding="0" cellspacing="0" width="99%" border="0" style="table-layout:fixed;word-wrap: break-word;">
                                    <tbody>
                                        <tr>
                                            <td width="45px;" style="vertical-align:top;" class="box_list_c">
                                                <img src="<?php echo $homeurl.'/'.$nd['photo'];?>" width="45px;" style="height:45px;" class="avatar">
                                            </td>
                                            <td class="box_list_d">
                                                <div class="mem"><?php echo online($res['user_id']);?> <a href="profile.php?id=<?php echo $res['user_id'];?>"><?php echo $nd['username'];?></a></div>
                                                <div class="box_title_bviet">
                                                    <a href="view.php?id=<?php echo $res['topic_id'];?>" class="btn btn-xs btn-success">Xem bài viết</a>
                                                </div>
                                                <div class="ndung_bviet">
                                                    <?php echo nl2br($res['message']);?>
                                                </div>
                                                <div class="box_time_bviet">
                                                    <?php echo thoigian($res['comment_time']);?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <?php
                    if($demtrang > $limit)
                    {
                        ?>
                        <div><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
                        <?php
                    }
                    ?>
                </div>
                <!-- box list chuyen muc -->
                <?php
                require_once('end.php');
                exit;
            break;
        }
    break;
}
?>
<div class="box_home"><a href="<?php echo $homeurl;?>/forum">Diễn đàn KPOP</a> / <?php echo $taikhoan['username'];?></div>
<div class="box_avatar">
    <center><img class="avatar" src="<?php echo $homeurl.'/'.$taikhoan['photo'];?>" width="50px;" style="height:50px;max-width: 100%;"></center>
        </div>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered2">
            <tbody>
                <tr>
                    <td class="left" width="10%;">ID</td>
                    <td class="right">
                        <span><?php echo $taikhoan['username'];?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Tên thật</td>
                    <td class="right">
                    <span><?php echo $taikhoan['fullname'];?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Giới tính</td>
                    <td class="right">
                    <span><?php echo ($taikhoan['gender']) == 1 ? 'Nam' : 'Nữ';?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Ngày sinh</td>
                    <td class="right">
                    <span>
                        <?php echo $taikhoan['yob'];?>-<?php echo $taikhoan['mob'];?>-<?php echo $taikhoan['dob'];?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Địa chỉ</td>
                    <td class="right">
                    <span><?php echo $taikhoan['address'];?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Điện thoại</td>
                    <td class="right">
                    <span><?php echo $taikhoan['phone'];?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Email</td>
                    <td class="right">
                    <span><?php echo $taikhoan['email'];?></span>
                    </td>
                </tr>
                <tr>
                    <td class="left" width="10%;">Bài viết</td>
                    <td class="right">
                    <span><?php echo $taikhoan['post'];?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    <div style="text-align:center;width:100%;">
        <div class="group_btn">
            
            <?php
            if($right > $taikhoan['right'])
            {
                echo'<a href="del.php?do=block&id='.$taikhoan['user_id'].'" class="btn btn-default"><i class="fas fa-user-lock"></i> Khóa</a>';
            }
            if($user_id == $id || $right >= 9)
            {
            echo'<a href="?do=setting&id='.$id.'" class="btn btn-default"><i class="fas fa-cog"></i> Cài đặt</a>';
            }
            ?>
            <a href="?do=search&for=1&id=<?php echo $id;?>" class="btn btn-default"><i class="fas fa-search"></i> Bài viết</a>
            <a href="?do=search&for=2&id=<?php echo $id;?>" class="btn btn-default"><i class="fas fa-search"></i> Bình luận</a>
        </div>
    </div>
<?php
require_once('end.php');
?>