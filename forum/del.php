<?php
require_once('../incfiles/core.php');
$textl = "Quản lý";
require_once('head.php');
if($right < 9)
{
    loadlai("forum");
}
$topic = isset($_GET['topic']) ? intval($_GET['topic']) : false;
    switch($do)
    {
        // khóa tài khoản vi phạm
        case 'block':
            $sql = "SELECT `user_id` FROM `users` WHERE `user_id` = '$id' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                loadlai("forum");
            }
            // khong the tu khoa chinh minh
            if($user_id == $id)
            {
                loadlai("forum");
            }
            include("../users/func.php");
            $from = getUser($id);
            ?>
            <div class="box_home"><a href="index.php">Diễn đàn K-POP</a> / Khóa tài khoản - <?php echo $from['username'];?></div>
            <form method="post" name="khoa">
            <?php
            if(isset($_POST['khoa']))
            {
                $thoihan = isset($_POST['thoihan']) ? intval($_POST['thoihan']) : 0;
                $phut = isset($_POST['phut']) ? abs(intval($_POST['phut'])) : 0;
                $gio = isset($_POST['gio']) ? abs(intval($_POST['gio'])) : 0;
                $ngay = isset($_POST['ngay']) ? abs(intval($_POST['ngay'])) : 0;
                $hientai = time();
                $phut = $phut*60;
                $gio = $gio*3600;
                $ngay = $ngay*3600*24;
                $lydo = htmlspecialchars($_POST['lydo'],ENT_QUOTES);
                if($thoihan == 0)
                {
                    if(empty($phut) && empty($gio) && empty($ngay))
                    {
                        echo'<div class="alert2 alert-warning">Vui lòng nhập vào thời gian khóa tài khoản</div>';
                    }
                    else
                    {
                        $hientai = $hientai+$phut+$gio+$ngay;
                        $ngethethan = date("Y-m-d H:i:s",$hientai);
                        $sql = "INSERT INTO `blockuser`(`block_id`,`lydo`,`ngayhethan`,`user_id`) 
                        VALUES (NULL,'$lydo','$hientai','$id')";
                        if(mysqli_query($con,$sql))
                        {
                            echo'<div class="alert2 alert-success">
                            <ul>
                            <li>Khóa tài khoản thành công</li>
                            <li>Tài khoản '.$from['username'].' đã bị cấm truy cập</li>
                            <li>Bị cấm đề hết ngày : '.$ngethethan.'</li>
                            </ul>
                            </div>
                            <p><center><a href="'.$homeurl.'/forum">Quay lại diễn đàn</a></center></p>
                            <p>&#160;</p>';
                            require_once('end.php');
                            exit;
                        }
                    }
                }
                else
                {
                        $hientai = 2147483647;
                        $sql = "INSERT INTO `blockuser`(`block_id`,`lydo`,`ngayhethan`,`user_id`) 
                        VALUES (NULL,'$lydo','$hientai','$id')";
                        if(mysqli_query($con,$sql))
                        {
                            echo'<div class="alert2 alert-success">
                            <ul>
                            <li>Khóa tài khoản thành công</li>
                            <li>Tài khoản '.$from['username'].' đã bị cấm truy cập</li>
                            <li>Người dùng đã bị khóa vĩnh viễn</li>
                            </ul>
                            </div>
                            <p><center><a href="'.$homeurl.'/forum">Quay lại diễn đàn</a></center></p>
                            <p>&#160;</p>';
                            require_once('end.php');
                            exit;
                        }
                }
            }
            ?>
            <label>Khóa tài khoản</label>
            <div class="box_avatar">
            <center><img class="avatar" src="<?php echo $homeurl.'/'.$from['photo'];?>" width="50px;" style="height:50px;max-width: 100%;"></center>
            </div>
            <div class="input_box">
            <input type="radio" name="thoihan" value="0" checked="checked" style="height:17px;width:17px;"><b> *. Thời hạn: </b>
            <br>
            <div class="input_grup">
                Phút <input type="number" name="phut" class="input_small">
                Giờ <input type="number" name="gio" class="input_small">
                Ngày <input type="number" name="ngay" class="input_small">
            </div>
            </div>
            <div class="input_box">
            <input type="radio" name="thoihan" value="1" style="height:17px;width:17px;"><b> *. Vô thời hạn: </b>
            <div class="input_grup">Tài khoản sẽ bị cấm truy cập vào diễn đàn vô thời hạn.</div>
            </div>
            <div class="input_box">
            <b>*. Lý do:</b>
            <textarea name="lydo" rows="5" required="required" class="form-control"><?php echo (isset($lydo)) ? "$lydo": "";?></textarea>
            </div>
            <p>&#160;</p>
            <div class="input">
            <button class="btn btn-default" name="khoa" value="khoa">Khóa</button>
            <p>&#160;</p>
            </div>
            </form>
            <?php
            $sql = "SELECT `user_id` FROM `blockuser` WHERE ";
            require_once('end.php');
            exit;
        break;
        // xóa bình luận
        case 'post':
            $sql = "SELECT `topic_id`, `forum_id` FROM `forum_topic` WHERE `topic_id` = '$topic' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                loadlai("forum");
            }
            $sql1 = "SELECT `type` FROM `topic_comment` WHERE `comment_id` = '$id' LIMIT 1";
            $result1 = mysqli_query($con,$sql1);
            if(!mysqli_num_rows($result1))
            {
                loadlai("forum");
            }
            $arr = mysqli_fetch_assoc($result1);
            if($arr['type'] == 0)
            {
                $sql = "DELETE FROM `topic_comment` WHERE `comment_id` = '$id' LIMIT 1";
                if(mysqli_query($con,$sql))
                {
                    loadlai("forum/view.php?id=$topic");
                }
            }
            else
            {
                $res = mysqli_fetch_assoc($result);
                $sql = "DELETE FROM `forum_topic` WHERE `topic_id` = '$topic' LIMIT 1";
                if(mysqli_query($con,$sql))
                {
                    loadlai("forum/chuyenmuc.php?id=".$res['forum_id']);
                }
            }
            require_once('end.php');
            exit;
        break;
        // chỉnh sửa bình luận
        case 'edit':
            $sql = "SELECT `topic_id` FROM `forum_topic` WHERE `topic_id` = '$topic' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                loadlai("forum");
            }
            $sql = "SELECT `message`,`user_id` FROM `topic_comment` WHERE `comment_id` = '$id' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                loadlai("forum");
            }
            $res = mysqli_fetch_assoc($result);
            include('../users/func.php');
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
                $sql = "UPDATE `topic_comment` SET `message` = '$msg' WHERE `comment_id` = '$id' LIMIT 1";
                if(mysqli_query($con,$sql))
                {
                    for($i=0;$i<$countfiles;$i++)
                    {
                        if($_FILES['photo']['name'][$i] != "")
                        {
                            $filename = date("ymdHis");
                            $filename .= $i;
                            $path = $_FILES['photo']['name'][$i];
                            $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
                            $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
                            if (in_array($ext, $validextensions)) // tìm đuôi phù hợp
                            {
                                move_uploaded_file($_FILES['photo']['tmp_name'][$i],'photo/'.$filename.'.'.$ext);
                                $sql = "INSERT INTO `comment_photo`(`photo_id`,`photo_name`,`comment_id`) VALUES (NULL,'forum/photo/$filename.$ext','$id')";
                                mysqli_query($con,$sql);
                            }
                            else
                            {
                                echo'<div class="alert-default">
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
                    loadlai("forum/view.php?id=$topic");
                }
            }
            ?>
            <div class="box_home"><a href="index.php">Diễn đàn K-POP</a> / Chỉnh sửa bài viết</div>
            <div class="form-group">
                <label>Chỉnh sửa bài viết của <?php echo $from['username'];?></label>
                <div class="input">
                    <textarea name="msg" rows="5" placeholder="Nội dung" required="required"><?php echo $res['message']?></textarea>
                </div>
            </div>
            <!-- form group -->
            <div class="file-group">
                <label>(Đủ 100 bài viết để tải lên hình ảnh)</label>
                <input type="file" name="photo[]" class="form-control">
                <input type="file" name="photo[]" class="form-control">
                <input type="file" name="photo[]" class="form-control">
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
        // xóa hình ảnh
        case 'photo':
            $sql = "SELECT `topic_id` FROM `forum_topic` WHERE `topic_id` = '$topic' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                loadlai("forum");
            }
            // cau lenh xoa anh
            $sql = "SELECT `photo_name` FROM `comment_photo` WHERE `photo_id` = '$id' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                $res = mysqli_fetch_assoc($result);
                unlink("../".$res['photo_name']."");
            }
            $sql = "DELETE FROM `comment_photo` WHERE `photo_id` = '$id'";
            if(mysqli_query($con,$sql))
            {
                loadlai("forum/view.php?id=$topic");
            }
            exit;
        break;
    }
?>