<?php
error_reporting(0);
require_once('../incfiles/core.php');
$textl = "Trả lời bài viết - Gửi ảnh";
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
$res = mysqli_fetch_assoc($result);
?>
<div class="box_home"><a href="index.php">Diễn đàn K-POP</a> / <a href="view.php?id=<?php echo $res['topic_id'];?>"><?php echo $res['topic_name'];?></a>
/ Trả lời</div>
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
                    <a href="">Trở lại</a>
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
                    loadlai("forum/view.php?id=$id");
                }
            }
            ?>
        <div class="form-group">
            <label>Gửi ảnh</label>
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
?>