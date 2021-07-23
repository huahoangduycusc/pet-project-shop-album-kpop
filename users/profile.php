<?php
require_once('../incfiles/core.php');
include('func.php');
$user = getUser($id);
if(!$user || !$user_id)
{
    chuyenhuong();
}
$textl = 'Trang cá nhân của '.$user['username'];
require_once('../incfiles/head.php');
// 1 la gioi tinh nam, 2 la gioi tinh nu
?>
<div class="page_title"><a href="">Trang chủ</a> > Profile > <a href="#"><?php echo $user['fullname'];?></a></div>
    <?php
    switch($do)
    {
        case 'setting':
        if($user_id != $id && $right < 9)
        {
            echo'<div class="profile"><font color="red">Bạn không có đủ quyền hạn để thực hiện chức năng này!</font></div>';
            require_once('../incfiles/end.php');
            exit;
        }
        $namsinh = date("Y");
    ?>
<form action="" method="post" enctype="multipart/form-data" id="submit_update">
    <?php
    if(isset($_POST['setting']))
    {

        $name = htmlspecialchars($_POST['name']);
        $gender = htmlspecialchars($_POST['gender']);
        $dc = htmlspecialchars($_POST['diachi']);
        $sdt = htmlspecialchars($_POST['sdt']);
        $mail = htmlspecialchars($_POST['mail']);
        $dob = htmlspecialchars($_POST['dob']);
        $mob = htmlspecialchars($_POST['mob']);
        $yob = htmlspecialchars($_POST['yob']);
        $chucvu = isset($_POST['chucvu']) ? intval($_POST['chucvu']) : 0;
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
            loadlai("users/profile.php?id=$id");
        }
    }
    ?>
<div class="profile">
<input type="hidden" name="usertoken" value="<?php echo $id;?>">
    <div class="anhdaidien">
        <img src="<?php echo $homeurl;?>/<?php echo $user['photo'];?>" class="profile_avatar">
    </div>
    <table width="100%" cellspacing="0" class="profile-infor">
        <tr>
            <td class="left">Họ và tên</td>
            <td class="right"><input type="text" name="name" value="<?php echo $user['fullname'];?>"></td>
        </tr>
        <tr>
            <td class="left">Giới tính</td>
            <td class="right">
                <select name="gender">
                    <option value="1" <?php if($user['gender'] == 1) echo 'selected="selected"';?>>Nam</option>
                    <option value="2" <?php if($user['gender'] == 2) echo 'selected="selected"';?>>Nữ</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="left">Địa chỉ</td>
            <td class="right"><textarea rows="7" name="diachi"><?php echo $user['address'];?></textarea></td>
        </tr>
        <tr>
            <td class="left">Số điện thoại</td>
            <td class="right"><input type="text" name="sdt" value="<?php echo $user['phone'];?>"></td>
        </tr>
        <tr>
            <td class="left">Email</td>
            <td class="right"><input type="text" name="mail" value="<?php echo $user['email'];?>"></td>
        </tr>
        <tr>
            <td class="left">Năm sinh</td>
            <td class="right">
                <select name="dob" style="width:50px;">
                    <?php
                    for($i=1;$i<=31;$i++)
                    {
                    ?>
                    <option value="<?php echo $i;?>" <?php if($user['dob'] == $i) echo 'selected="selected"';?>"><?php echo $i;?></option>
                    <?php
                    }
                    ?>
                </select>
                <select name="mob" style="width:50px;">
                    <?php
                    for($i=1;$i<=12;$i++)
                    {
                    ?>
                    <option value="<?php echo $i;?>" <?php if($user['mob'] == $i) echo 'selected="selected"';?>"><?php echo $i;?></option>
                    <?php
                    }
                    ?>
                </select>
                <select name="yob" style="width:70px;">
                    <?php
                    for($i=1930;$i<=$namsinh;$i++)
                    {
                    ?>
                    <option value="<?php echo $i;?>" <?php if($user['yob'] == $i) echo 'selected="selected"';?>"><?php echo $i;?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="left">Ảnh đại diện</td>
            <td class="right"><input type="file" name="avatar"></td>
        </tr>
        <?php
        if($right == 9)
        {
        ?>
        <tr>
            <td class="left">Chức vụ</td>
            <td class="right">
                <select name="chucvu" class="chucvu">
                    <option value="0" <?php if($user['right'] == 0) echo 'selected="selected"';?>>Khách hàng</option>
                    <option value="9" <?php if($user['right'] == 9) echo 'selected="selected"';?>>Quản trị viên</option>
                </select>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <br>
    <?php
    if($user_id == $id)
    {
        echo'<button class="button-right" name="setting" value="chinh sua">Thiết lập</button>';
    }
    elseif($right == 9 && $user_id != $id)
    {
        echo'<button class="button-right" name="setting" value="chinh sua">Chỉnh sửa</button>';
    }
    echo'<a class="btn-pink" href="profile.php?id='.$id.'">Quay lại</a>';
    ?>
</div>
</form>
<script src="<?php echo $homeurl;?>/users/setting.js"></script>
    <?php
            require_once('../incfiles/end.php');
            exit;
        break;
        case 'del':
            if($right < 9)
            {
                chuyenhuong();
            }
            ?>
<form action="" method="post">
<div class="profile">
    <?php
    if(isset($_POST['del']))
    {
        $sql = "DELETE FROM `users` where `user_id` = '$id' limit 1";
        if(mysqli_query($con,$sql))
        {
            echo'<div class="success">Xóa người dùng thành công !</div>';
        }
    }
    ?>
    Bạn có thực sự muốn xóa người dùng <font color="red">"<?php echo $user['username'];?>"</font> này?
    <br>
    <button class="button-right" name="del" value="chinh sua">Xác nhận</button>
</div>
</form>
    <?php
    require_once('../incfiles/end.php');
    exit;
        break;
    }
    ?>
<div class="profile">
    <div class="anhdaidien">
        <img src="<?php echo $homeurl;?>/<?php echo $user['photo'];?>" class="profile_avatar">
    </div>
    <table width="100%" cellspacing="0" class="profile-infor">
        <tr>
            <td class="left">ID</td>
            <td class="right"><?php echo $user['user_id'];?></td>
        </tr>
        <tr>
            <td class="left">Họ và tên</td>
            <td class="right"><?php echo $user['fullname'];?></td>
        </tr>
        <tr>
            <td class="left">Giới tính</td>
            <td class="right"><?php echo ($user['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
        </tr>
        <tr>
            <td class="left">Địa chỉ</td>
            <td class="right"><?php echo $user['address'];?></td>
        </tr>
        <tr>
            <td class="left">Số điện thoại</td>
            <td class="right"><?php echo $user['phone'];?></td>
        </tr>
        <tr>
            <td class="left">Email</td>
            <td class="right"><?php echo $user['email'];?></td>
        </tr>
        <tr>
            <td class="left">Năm sinh</td>
            <td class="right"><?php echo $user['dob'];?>-<?php echo $user['mob'];?>-<?php echo $user['yob'];?></td>
        </tr>
    </table>
    <br>
    <?php
    if($right == 9)
    {
        echo'<a class="btn-pink" href="?do=del&id='.$id.'">Xóa</a>';
    }
    if($user_id == $id)
    {
        echo'<a class="btn-pink" href="?do=setting&id='.$id.'">Thiết lập</a>';
    }
    elseif($right == 9 && $user_id != $id)
    {
        echo'<a class="btn-pink" href="?do=setting&id='.$id.'">Chỉnh sửa</a>';
    }
    ?>
</div>
<?php
require_once('../incfiles/end.php');
?>