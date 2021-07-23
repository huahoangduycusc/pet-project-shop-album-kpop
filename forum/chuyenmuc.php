<?php
error_reporting(0);
require_once('../incfiles/core.php');
require_once('head.php');
if($id == false)
{
    loadlai("/forum");
}
$sql = "SELECT `forum_name`, `forum_id`, `forum_quyenhan` FROM `forum_chuyenmuc` WHERE `forum_id` = '$id' LIMIT 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    loadlai("/forum");
}
include('../users/func.php');
include('func.php');
$res = mysqli_fetch_assoc($result);
switch($do)
{
    case 'post':
        if(!$user_id)
        {
            loadlai("forum");
        }
        if($right < $res['forum_quyenhan'])
        {
            loadlai("forum");
        }
    ?>
<div class="box_home">Diễn đàn K-POP / <?php echo $res['forum_name'];?> / Bài mới</div>
    <form method="post" name="dangbai" enctype="multipart/form-data">
        <?php
        if(isset($_POST['dangbai']))
        {
            $tieude = htmlspecialchars($_POST['tieude'],ENT_QUOTES);
            $msg = htmlspecialchars($_POST['msg'],ENT_QUOTES);
            $ghim = isset($_POST['ghim']) ? intval($_POST['ghim']) : 0;
            $chuy = isset($_POST['chuy']) ? intval($_POST['chuy']) : 0;
            $countfiles = count($_FILES['photo']['name']);
            $chuy1 = time()+3*3600*24;
            if(empty($tieude) || empty($msg))
            {
                echo'<div class="alert-default">
                <label>Tiêu đề bài viết không được bỏ trống.<br> Tiêu đề bài viết phải ít nhất 10 ký tự và tối đa là 70 ký tự !</label>
                <br>
                <label>Nội dung bài viết không được bỏ trống !</label>
                <br>
                <a href="">Trở lại</a>
                <br>
                    </div>
                <br>
            </div>';
                require_once('end.php');
                exit;
            }
            if(strlen($tieude) < 10 || strlen($tieude) > 70)
            {
                echo'<div class="alert-default">
                <label>Tiêu đề bài viết không được bỏ trống.<br> Tiêu đề bài viết phải ít nhất 10 ký tự và tối đa là 70 ký tự !</label>
                <br>
                <label>Nội dung bài viết không được bỏ trống !</label>
                <br>
                <a href="">Trở lại</a>
                <br>
                    </div>
                <br>
            </div>';
                require_once('end.php');
                exit;
            }
            $sql = "INSERT INTO `forum_topic`(`topic_id`,`topic_name`,`topic_time`,`topic_view`,`topic_chuy`,`topic_chuy_1`,`topic_ghim`,`forum_id`,`user_id`) 
            VALUES (NULL,'$tieude',".time().",'0','$chuy','$chuy1','$ghim','$id','$user_id')";
            if(mysqli_query($con,$sql))
            {
                $rid = mysqli_insert_id($con);
                $sql = "INSERT INTO `topic_comment`(`comment_id`,`message`,`comment_time`,`comment_trichdan`,`topic_id`,`user_id`,`type`) 
                VALUES (NULL,'$msg',".time().",'','$rid','$user_id','1')";
                if(mysqli_query($con,$sql))
                {
                    $cid = mysqli_insert_id($con);
                    $sql4 = "insert into `topic_theodoi`(`topic_id`,`user_id`) values ('$rid','$user_id')";
                    mysqli_query($con,$sql4);
                    mysqli_query($con,"UPDATE `users` SET `post` = `post`+1 WHERE `user_id` = '$user_id' LIMIT 1");
                     // tien hanh them anh
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
                    loadlai("forum/view.php?id=$rid");
                }
            }
        }
        ?>
            <div class="box_input">
                <input type="text" name="tieude" required="required" placeholder="Tiêu đề">
            </div>
            <div class="box_input">
                <textarea name="msg" rows="5" placeholder="Nội dung" required="required"></textarea>
            </div>
            <?php
            if($right >= 9)
            {
                ?>
                <div class="clear"></div>
                <div class="box_home">Công cụ quản trị viên</div>
                <div class="box_input">
                    <input type="radio" name="ghim" value="0" checked="checked"> Topic thường
                    <input type="radio" name="ghim" value="1"> Ghim topic
                </div>
                <p>&#160;</p>
                <div class="box_input">
                    <input type="radio" name="chuy" value="0" checked="checked"> Topic thường
                    <input type="radio" name="chuy" value="1"> Topic hot
                    <input type="radio" name="chuy" value="2"> Topic new
                </div>
                <p>&#160;</p>
                <?php
            }
            ?>
             <!-- form group -->
            <div class="file-group">
                <label>(Cần 100 bài viết để đăng được ảnh)</label>
                <?php
                if($user['post'] >= 100 || $right >=9)
                {
                    ?>
                    <input type="file" name="photo[]" class="form-control">
                    <input type="file" name="photo[]" class="form-control">
                    <input type="file" name="photo[]" class="form-control">
                    <?php
                }
                ?>
            </div>
            <div class="box_input">
                <button type="submit" name="dangbai" value="dangbai" class="btn btn-default">Gửi</button>
            </div>
    </form>
    <?php
    require_once('end.php');
    exit;
    break;
}
?>
<div class="box_home">Diễn đàn K-POP / <?php echo $res['forum_name'];?></div>
<?php
if($user_id)
{
    if($res['forum_quyenhan'] > $right)
    {
        ?>
        <div class="alert2 alert-warning"><p>&#160;</p><label>Bạn không đủ quyền hạn để đăng bài tại chuyên mục này !</label><p>&#160;</p></diV>
        <?php
    }
    else
    {
        ?>
        <div class="box_top">
        <form action="?id=<?php echo $id;?>&do=post" name="update" method="post">
            <button type="submit" class="btn btn-default" name="update">Bài mới</button>
        </form>
        </div>
        <?php
    }
    ?>
    
    <?php
}
?>
<?php
$sqll = "SELECT `topic_id`, `topic_name`, `user_id`, `topic_view` FROM `forum_topic` WHERE `forum_id` = '$id' AND `topic_ghim` = '1' ORDER BY `topic_id` DESC LIMIT 10";
$show = mysqli_query($con,$sqll);
if(mysqli_num_rows($show))
{
    echo'<div class="box_list_chuyenmuc">';
    while($arr = mysqli_fetch_assoc($show))
    {
        $nguoidung = getUser($arr['user_id']);
        ?>
        <div class="box_topic">
        <div class="topic_name">
            <a href="view.php?id=<?php echo $arr['topic_id'];?>" class="alert alert_link"><?php echo $arr['topic_name'];?></a>
            <?php echo chuy($arr['topic_id']);?>
         </div>
         <div class="topic_author">bởi <a href="profile.php?id=<?php echo $arr['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
         <?php echo reply($arr['topic_id']);?>
         <span>- Xem : <?php echo $arr['topic_view'];?></span>
        <?php echo like($arr['topic_id']);?>
        </div>
        </div>
        <?php
    }
    echo'</div>';
}
?>
<!-- =================Hien thi tat ca bai viet o day================= -->
<?php
$sql = "SELECT `topic_id`, `topic_name`, `user_id`, `topic_view` FROM `forum_topic` WHERE `forum_id` = '$id' AND `topic_ghim` = '0' ORDER BY `topic_time` DESC LIMIT $start,$limit";
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
                    <span style="float:left;padding: 5px 5px 5px 0px;"><img class="avatar" src="<?php echo $homeurl.'/'.$nguoidung['photo'];?>" alt="" style="width: 32px;height:32px;"></span>
                    <div class="topic_name"><a href="view.php?id=<?php echo $res['topic_id'];?>" class="alert_link"><?php echo $res['topic_name'];?></a>
                    <?php echo chuy($res['topic_id']);?>
                        <div class="topic_author">bởi <a href="profile.php?id=<?php echo $res['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
                        <?php echo reply($res['topic_id']);?>
                        <span>- Xem : <?php echo $res['topic_view'];?></span>
                        <?php echo like($res['topic_id']);?>
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
    echo'<div class="alert2 alert-warning">Trở thành người đầu tiên tạo bài viết tại chuyên mục này !</div>';
}
?>
<?php
    $duy = "SELECT * FROM `forum_topic` where `forum_id` = '$id' and `topic_ghim` = '0'";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'forum/chuyenmuc.php?id'
                ];
    $page1 = new Pagination($config);
    ?>
<div><center><ul class="pagination"><?php echo $page1->getPagination();?></ul></center></div>
<?php
require_once('end.php');
?>