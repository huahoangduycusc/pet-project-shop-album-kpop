<?php
error_reporting(0);
require_once('../incfiles/core.php');
require_once('head.php');
if($id == false)
{
    loadlai("/forum");
}
$sql = "SELECT `forum_name`,`topic_id`, `topic_name`, `user_id`,`forum_chuyenmuc`.`forum_id` FROM `forum_topic` INNER JOIN `forum_chuyenmuc` 
ON `forum_topic`.`forum_id` = `forum_chuyenmuc`.`forum_id` WHERE `forum_topic`.`topic_id` = '$id' LIMIT 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    loadlai("/forum");
}
include('../users/func.php');
$res = mysqli_fetch_assoc($result);
if($page == 1)
{
    $limit = 16;
    $start = ($limit*$page)-$limit;
}
else
{
    $limit = 15;
    $start = ($limit*$page)-$limit+1;

}
$dema=(isset($dema))? $dema: $start;
// phan cap chuc vu
$thediv = array(
    0 => '<div class="box_chucvu_mem">',
    1 => '<div class="box_chucvu_mem">',
    2 => '<div class="box_chucvu_mem">',
    3 => '<div class="box_chucvu_mem">',
    4 => '<div class="box_chucvu_mem">',
    9 => '<div class="box_chucvu_admin">'
);
$bqt = array(
    0 => '',
    3 => ' - Mod',
    4 => ' - SMod',
    9 => ' - Admin'
);
include('func.php');
?>
<div class="box_home"><a href="index.php">Diễn đàn K-POP</a> / <a href="chuyenmuc.php?id=<?php echo $res['forum_id'];?>"><?php echo $res['forum_name'];?></a> / <?php echo $res['topic_name'];?></div>
<!-- Dong nay thuc khi like va unlike -->
<?php
switch($do)
{
    // hien thi danh sach nguoi thich bai viet
    case 'likelist':
            $cmt = isset($_GET['cmt']) ? intval($_GET['cmt']) : false;
            $sql = "select * from `topic_like` where `comment_id` = '$cmt'";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                //loadlai("forum");
            }
            echo'<div class="list1" style="padding:4px;">';
            while($res = mysqli_fetch_assoc($result))
            {
                $from = getUser($res['user_id']);
                echo'<a href="'.$homeurl.'/forum/profile.php?id='.$res['user_id'].'">'.$from['username'].'</a>,';
            } 
            echo'</div></div>';
            require_once('end.php');
            exit;
        break;
    case 'like':
        $sql = "select * from `topic_comment` where `topic_id` = '$id' and `comment_id` = '$quote' limit 1";
                $result = mysqli_query($con,$sql);
                if(!mysqli_num_rows($result))
                {
                    loadlai("forum/view.php?id=$id");
                }
        $arr = mysqli_fetch_assoc($result);
        $sql1 = "select * from `topic_like` where `user_id` = '$user_id' and `comment_id` = '$quote' limit 1";
        $result = mysqli_query($con,$sql1);
        if(!mysqli_num_rows($result))
        {
            $them = "INSERT INTO `topic_like`(`like_id`,`comment_id`,`user_id`) VALUES (NULL,'$quote','$user_id')";
            mysqli_query($con,$them);
            loadlai("forum/view.php?id=$id");
        }
        else
        {
            $them = "delete from `topic_like` where `comment_id` = '$quote' and `user_id` = '$user_id'";
            mysqli_query($con,$them);
            loadlai("forum/view.php?id=$id");
        }
    exit;
    break;
    case 'next':
        $sql1 = "SELECT `comment_id`, `message`, `user_id`, `type` FROM `topic_comment` WHERE `comment_id` = '$quote' LIMIT 1";
        $result = mysqli_query($con,$sql1);
        if(!mysqli_num_rows($result))
        {
            loadlai("forum/");
        }
        $res = mysqli_fetch_assoc($result);
        if($res['type'] == 1)
        {
            loadlai("forum");
        }
        $from = getUser($res['user_id']);
        ?>
        <form method="post" name="trich" enctype="multipart/form-data">
            <?php
            if(isset($_POST['trich']))
            {
                $msg = htmlspecialchars($_POST['msg'],ENT_QUOTES);
                $countfiles = count($_FILES['photo']['name']);
                if(strlen($msg) < 10)
                {
                    echo'<div class="alert-default">
                    <label>Nội dung bình luận phải tối thiểu ít nhất có 10 ký tự !</label>
                    <br>
                    <label>Khoảng cách giữa các bình luận là 20 giây !</label>
                    <br>
                    <label>Vui lòng đợi đủ thời gian trước khi gửi 1 bình luận mới !</label>
                    <br>
                    <a href="">Trở lại bài viết</a>
                    <br>
                    </div>
                    <br>
                    </div>';
                    require_once('end.php');
                    exit;
                }
                $text = '<div class="quote"><div class="user">Trích dẫn bài viết của <a href="profile.php.php?id='.$res['user_id'].'">'.$from['username'].'</a></div>
                <div class="quote2">'.$res['message'].'</div></div>';
                $sql = "INSERT INTO `topic_comment`(`comment_id`,`message`,`comment_time`,`comment_trichdan`,`topic_id`,`user_id`,`type`) 
                VALUES (NULL,'$msg',".time().",'$text','$id','$user_id','0')";
                if(mysqli_query($con,$sql))
                {
                    $cid = mysqli_insert_id($con);
                    mysqli_query($con,"UPDATE `users` SET `post` = `post` +1 WHERE `user_id` = '$user_id' LIMIT 1");
                    mysqli_query($con,"UPDATE `forum_topic` SET `topic_time` = ".time()." WHERE `topic_id` = '$id' LIMIT 1");
                    for($i=0;$i<$countfiles;$i++)
                    {
                        if($_FILES['photo']['name'][$i] != "" && $user['post'] >= 100)
                        {
                            $filename = date("ymdHis");
                            $filename .= $i;
                            $path = $_FILES['photo']['name'][$i];
                            $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
                            $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
                            if (in_array($ext, $validextensions)) // tìm đuôi phù hợp
                            {
                                move_uploaded_file($_FILES['photo']['tmp_name'][$i],'photo/'.$filename.'.'.$ext);
                                $sql = "INSERT INTO `comment_photo`(`photo_id`,`photo_name`,`comment_id`) VALUES (NULL,'forum/photo/$filename.$ext','$cid')";
                                mysqli_query($con,$sql);
                            }
                            else
                            {
                                echo'<div class="alert-default">
                                    <label>Tiêu đề bài viết không được bỏ trống.<br> Tiêu đề bài viết phải ít nhất 10 ký tự và tối đa là 70 ký tự !</label>
                                    <br>
                                    <label>Nội dung bài viết không được bỏ trống !</label>
                                    <br>
                                    <label>Định dạng ảnh không hợp lệ, ảnh phải có đuôi là .PNG, .JPG và .JPEG</label>
                                    <br>
                                    <a href="">Trở lại</a>
                                    <br>
                                        </div>
                                    <br>
                                </div>';
                                    require_once('end.php');
                                    exit;
                            }
                        }
                    }
                    if($user_id != $res['user_id'])
                    {
                        $msg = '<a href="'.$homeurl.'/forum/view.php?id='.$id.'">'.$from['username'].' vừa trích dẫn bài viết của bạn</a>';
                        $sql = "insert into `thongbao`(`message`,`daxem`,`user_id`,`thoigian`) values ('$msg','0','".$res['user_id']."',".time().")";
                        mysqli_query($con,$sql);
                    }
                    loadlai("forum/view.php?id=$id");
                }
            }
            ?>
        <div class="form-group">
            <label>Trích dẫn bài viết của <?php echo $from['username'];?></label>
            <div class="input">
                <textarea name="msg" rows="5" placeholder="Nội dung" required="required"></textarea>
            </div>
        </div>
        <!-- form group -->
        <div class="file-group">
            <label>(Đủ 100 bài viết để tải lên hình ảnh)</label>
            <?php
            if($user['post'] >= 100)
            {
            ?>
            <input type="file" name="photo[]" class="form-control">
            <input type="file" name="photo[]" class="form-control">
            <input type="file" name="photo[]" class="form-control">
            <?php
            }
            ?>
        </div>
        <div class="input">
            <button type="submit" name="trich" value="binhluan" class="btn btn-default">Gửi</button>
        </div>
        <br>
        </form>
        <?php
        require_once('end.php');
        exit;
    break;
}
?>
<div class="box_list_parent">
<?php
    $duy = "SELECT * FROM `topic_comment` where `topic_id` = '$id'";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'forum/view.php?id'
                ];
    $page1 = new Pagination($config);
    ?>
    <form method="post" name="updatePOST">
        <!-- khi nguoi dung an nut gui anh -->
        <?php
        if(isset($_POST['guianh']))
        {
            loadlai("forum/trich.php?id=$id");
        }
        ?>
        <!-- khi nguoi dung nhan nut binh luan -->
        <?php
        if(isset($_POST['binhluan']))
        {
            $msg = htmlspecialchars($_POST['msg'],ENT_QUOTES);
            if(strlen($msg) < 10)
            {
                echo'<div class="alert-default">
                <label>Nội dung bình luận phải tối thiểu ít nhất có 10 ký tự !</label>
                <br>
                <label>Khoảng cách giữa các bình luận là 20 giây !</label>
                <br>
                <label>Vui lòng đợi đủ thời gian trước khi gửi 1 bình luận mới !</label>
                <br>
                <a href="">Trở lại bài viết</a>
                <br>
                </div>
                <br>
                </div>';
                require_once('end.php');
                exit;
            }
            $sql = "INSERT INTO `topic_comment`(`comment_id`,`message`,`comment_time`,`comment_trichdan`,`topic_id`,`user_id`,`type`) 
            VALUES (NULL,'$msg',".time().",'','$id','$user_id','0')";
            if(mysqli_query($con,$sql))
            {
                mysqli_query($con,"UPDATE `users` SET `post` = `post` +1 WHERE `user_id` = '$user_id' LIMIT 1");
                mysqli_query($con,"UPDATE `forum_topic` SET `topic_time` = ".time()." WHERE `topic_id` = '$id' LIMIT 1");
                // kiem tra xem nhung ai theo doi bai viet nay
                $tdoi = "select * from `topic_theodoi` where `topic_id` = '$id' and `user_id` != '$user_id'";
                $tdoi1 = mysqli_query($con,$tdoi);
                if(mysqli_num_rows($tdoi1))
                {
                    // co nhung ai theo doi
                    // lap qua tung dong
                    while($res = mysqli_fetch_assoc($tdoi1))
                    {
                        $from = getUser($res['user_id']);
                        $texts = '<a href="'.$homeurl.'/forum/view.php?id='.$id.'">'.$user['username'].' bình luận bài viết mà bạn theo dõi</a>';
                        $sql = "insert into `thongbao`(`message`,`daxem`,`user_id`,`thoigian`) values ('$texts','0','".$res['user_id']."',".time().")";
                        mysqli_query($con,$sql);
                    }
                }
                loadlai("forum/view.php?id=$id");
            }
        }
        ?>
        <!-- Kiem tra nguoi dung co theo doi chua -->
        <?php
        if(isset($_POST['watch']))
        {
            if(!$user_id)
            {
                loadlai("forum");
            }
            $sql = "select * from `topic_theodoi` where `user_id` = '$user_id' and `topic_id` = '$id' limit 1";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                $res = mysqli_fetch_assoc($result);
                $sql = "delete from `topic_theodoi` where `theodoi_id` = '".$res['theodoi_id']."' limit 1";
                if(mysqli_query($con,$sql))
                {
                    loadlai("forum/view.php?id=$id");
                }
            }
            else
            {
                $sql = "insert into `topic_theodoi`(`topic_id`,`user_id`) values ('$id','$user_id')";
                if(mysqli_query($con,$sql))
                {
                    loadlai("forum/view.php?id=$id");
                }
            }
        }
        // follow bai viet
        ?>
        <div class="box_phantrang"><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
        <?php
        $sql = "SELECT * FROM `topic_comment` WHERE `topic_id` = '$id' ORDER BY `comment_id` ASC LIMIT $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            $i = 0;
            while($arr = mysqli_fetch_assoc($result))
            {
                $us = getUser($arr['user_id']);
                ?>
                <table class="table2" cellpadding="0" cellspacing="0" width="99%" border="0" style="table-layout:fixed;word-wrap: break-word;">
                    <tbody>
                    <tr>
                        <td width="50px;" style="vertical-align: top;height: 100px;">
                            <span style="padding-top:8px;">
                                <img class="avatar" src="<?php echo $homeurl.'/'.$us['photo'];?>" width="34px;" style="width: 100%;height:43px;width:43px;">
                            </span>
                            <div style="text-align:center;height:8px;vertical-align: top;"><span style="font-size: 10px;">Bài:<?php echo $us['post'];?></span></div>
                        </td>
                        <td class="box_list_b">
                            <div class="box_comment">
                                <?php echo $thediv[$us['right']];?>
                                    <?php echo online($arr['user_id']);?>
                                    <a href="profile.php?id=<?php echo $arr['user_id'];?>" title="<?php echo $us['fullname'];?>"><?php echo $us['username'];?></a>
                                    <?php echo $bqt[$us['right']];?>
                                    <?php
                                    if(($start+$i) == 0)
                                    {
                                        if($user_id)
                                        {
                                            echo'<span style="float: right;padding-right: 3px;">'.($right > 0 ? ' <a href="del.php?do=block&id='.$arr['user_id'].'"><img src="images/block.png" style="padding-bottom:5px;padding-left:2px;"></a> 
                                            <a href="del.php?do=edit&topic='.$id.'&id='.$arr['comment_id'].'"><img src="images/edit.png" style="padding-bottom:5px;"></a> 
                                            <a href="del.php?do=post&topic='.$id.'&id='.$arr['comment_id'].'" onclick="return confirm(\'Bạn có chắc muốn xóa bài viết này?\')"><img src="images/xoa.png" style="padding-bottom:5px;height:19px;"></a></span>' : '').'</span>';
                                            $theodoi = "select * from `topic_theodoi` where `user_id` = '$user_id' and `topic_id` = '$id' limit 1";
                                            $rstheodoi = mysqli_query($con,$theodoi);
                                            if(mysqli_num_rows($rstheodoi))
                                            {   
                                            echo'<span style="float:right;margin-top:-3px;"><button class="btn btn-info btn-xs" name="watch" type="submit" value="submit">Bỏ theo dõi</button></span>';
                                            }
                                            else
                                            {
                                                echo'<span style="float:right;margin-top:-3px;"><button class="btn btn-info btn-xs" name="watch" type="submit" value="submit">Theo dõi</button></span>';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        echo' <span style="float: right;padding-right: 3px;"># '.($dema+$i).'
                                        '.($right > 0 ? '<a href="del.php?do=block&id='.$arr['user_id'].'"><img src="images/block.png" style="padding-bottom:5px;"></a> 
                                        <a href="del.php?do=edit&topic='.$id.'&id='.$arr['comment_id'].'"><img src="images/edit.png" style="padding-bottom:5px;"></a> 
                                        <a href="del.php?do=post&topic='.$id.'&id='.$arr['comment_id'].'" onclick="return confirm(\'Bạn có chắc muốn xóa bình luận này này?\')"><img src="images/xoa.png" style="padding-bottom:5px;height:19px;"></a> 
                                        </span>' : '');
                                    }
                                    ?>
                                </div>
                                <!-- div color mem -->
                                <div class="ndung_bviet">
                                    <?php
                                    if(!empty($arr['comment_trichdan']))
                                    {
                                        echo $arr['comment_trichdan'];
                                    }
                                    ?>
                                    <?php echo nl2br($arr['message']);?>
                                    <?php echo hinhanh($arr['comment_id']);?>
                                </div>
                                <!-- ndung bviet div -->
                                <div class="box_time_bviet"><?php echo thoigian($arr['comment_time']);?>
                                <?php
                                if($user_id)
                                {
                                    $sqllike = "select * from `topic_like` where `user_id` = '$user_id' and `comment_id` = '".$arr['comment_id']."' limit 1";
                                    $like = mysqli_query($con,$sqllike);
                                ?>
                                    <?php
                                    if($start+$i != 0)
                                    {
                                        echo'<a style="float: right;padding-right: 3px;" href="' . $_SERVER['PHP_SELF'] . '?id='.$id.'&quote='.$arr['comment_id'].'&do=next">
                                        <img src="images/quote.png" alt="like" height="17px"></a>';
                                    }
                                    ?>
                                    <?php
                                    if(!mysqli_num_rows($like))
                                    {
                                        echo'<a href="' . $_SERVER['PHP_SELF'] . '?id='.$id.'&quote='.$arr['comment_id'].'&do=like" style="float: right;padding-right: 3px;">
                                        <img src="images/like.png" alt="like" height="17px">
                                    </a>';
                                    }
                                    else
                                    {
                                        echo'<a href="' . $_SERVER['PHP_SELF'] . '?id='.$id.'&quote='.$arr['comment_id'].'&do=like" style="float: right;padding-right: 3px;">
                                        <img src="images/unlike.png" alt="like" height="17px">
                                    </a>';
                                    }
                                    ?>
                                <?php
                                }
                                // phai dang nhap moi hien trich dan va like
                                ?>
                                </div>
                                <?php
                                echo'<div style="padding: 3px;color:#333;" class="time_bviet">';
                                $like = mysqli_query($con,"select * from `topic_like` where `comment_id` = '".$arr['comment_id']."'");
                                $cach = array(
                                0 => '',
                                1 => ',',
                                2 => ','
                                );
                                $j = 0;
                                $tonglike = mysqli_num_rows($like);
                                $banlike = mysqli_query($con,"select * from `topic_like` where `comment_id` = '".$arr['comment_id']."' AND `user_id` = '$user_id'");
                                if($tonglike)
                                     {  
                                        echo'<span style="color:red;">♥</span>';
                                        if(mysqli_num_rows($banlike))
                                        {
                                            echo' Bạn';
                                        }
                                         while($res11 = mysqli_fetch_assoc($like))
                                         {
                                             $nicks = getUser($res11['user_id']);
                                             if($res11['user_id'] != $user_id)
                                            {
                                                echo $cach[$j].' <a href="profile.php?id='.$res11['user_id'].'">'.$nicks['username'].'</a>';
                                            }
                                            if($j==2)
                                         break;
                                            $j++;
                                         }
                                         $likes = $tonglike-3;
                                         if($likes >= 1)
                                         {
                                             echo' và '.$likes.' <a href="' . $_SERVER['PHP_SELF'] . '?do=likelist&id='.$id.'&cmt='.$arr['comment_id'].'">người khác</a> đã';
                                         }
                                        echo' thích bài viết này';
                                     }
                                     echo'
                                </div>';
                                ?>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php
                $i++;
            }
        }
        ?>
    </form>
    <div class="box_phantrang"><ul class="pagination"><?php echo $page1->getPagination();?></ul></div>
</div>
 <!-- list box parent -->
<?php
if($user_id)
{
    ?>
        <div class="box_new_comment">
            <form method="post" name="binhluan">
                <table cellpadding="0" cellspacing="0" width="99%" border="0" style="word-wrap: break-word;">
                    <tbody>
                        <tr>
                            <td width="50px;">
                                <span style="padding-top: 8px;"><img class="avatar" src="<?php echo $homeurl.'/'.$user['photo'];?>" style="width:50px;height:50px;max-width: 100%;"></span>
                            </td>
                            <td class="box_list_b">
                                <div class="ndung_bviet">
                                    <textarea name="msg" rows="4" class="textarea" placeholder="Bình luận gì đó..."></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <br>
                                <button name="binhluan" type="submit" value="submit" class="btn btn-default">Post</button>
                                <?php
                                if($user['post'] >= 100)
                                {
                                ?>
                                &#160;
                                <button name="guianh" type="submit" value="guianh" class="btn btn-default">Gửi ảnh</button>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    <?php
}
?>
<?php
mysqli_query($con,"UPDATE `forum_topic` SET `topic_view` = `topic_view` + 1 WHERE `topic_id` = '$id' LIMIT 1");
require_once('end.php');
?>