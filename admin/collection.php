<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
?>
<?php
switch($do)
{
    case 'add':
?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="collection.php">Collection Idol</a> > Thêm mới</div>
<form method="post" action="" enctype="multipart/form-data">
<?php
if(isset($_POST['update']))
{
    $name = htmlspecialchars($_POST['idol_name']);
    $photo = $_FILES['photo'];
    $error = array();
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên của sản phẩm";
    }
    if(empty($photo['name']))
    {
        $error['photo'] = "Vui lòng tải lên ảnh đại diện cho Collection Idol";
    }
    else
    {
        $filename = date("ymdHis");
        $path = $_FILES['photo']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
        $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
        if (!in_array($ext, $validextensions))
        {
            $error['photo'] = "Định dạng ảnh không hợp lệ, ảnh phải có đuôi là .PNG, .JPG và .JPEG";
        }
        else
        {
            move_uploaded_file($_FILES['photo']['tmp_name'],'../photo/idols/'.$filename.'.'.$ext);
        }
    }
    if(empty($error))
    {
        $sql = "INSERT INTO `idols`(`idol_id`,`idol_name`,`idol_photo`) VALUES (NULL,'$name','photo/idols/$filename.$ext')";
        if(mysqli_query($con,$sql))
        {
            echo'<div class="success">Thêm mới Collection Idol thành công !</div>';
        }

    }

}
?>
<div class="input">
    <div class="input_box">Tên Idol</div>
    <div class="input_input">
        <input type="text" name="idol_name" value="<?php echo isset($name) ? ''.$name.'' : '';?>">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Ảnh đại diện</div>
    <div class="input_input">
        <input type="file" name="photo">
    </div>
    <?php echo (isset($error['photo'])) ? '<div class="error">'.$error['photo'].'</div>' : '';?>
</div>
<div class="input">
    <button class="button" name="update" value="update">Thêm mới</button>
    </div>
</div>
</form>
    <?php
    require_once('../incfiles/end.php');
    exit;
    break;
    case 'del':
        $sql = "select `idol_name` from `idols` where `idol_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            echo'<div class="error">Không tìm thấy ID cần xóa trong hệ thống ! <a href="collection.php" class="button">Quay lại</a></div>';
            require_once('../incfiles/end.php');
            exit;
        }
        else
        {
            $res = mysqli_fetch_assoc($result);
        }
    ?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="collection.php">Collection Idol</a> > Xóa Collection</div>
    <?php
    if(isset($_POST['xoa']))
    {   
        $sql = "DELETE from `idols` where `idol_id` = '$id'";
        mysqli_query($con,$sql);
        echo'<div class="success">Xóa thành công ! <a href="collection.php" class="button">Quay lại</a></div>';
        require('../incfiles/end.php');
        exit;
    }
    ?>
    <form method="post" action="">
        <div class="list1">
            Bạn có thực sự muốn xóa Collection <b><?php echo (isset($res['idol_name'])) ? ''.$res['idol_name'].'' : '';?></b>, việc này
            đồng nghĩa với việc các sản phẩm có liên quan đến <b><?php echo (isset($res['idol_name'])) ? ''.$res['idol_name'].'' : '';?></b> 
            cũng sẽ bị xóa khỏi hệ thống?
            <br>
            <button class="button-right" name="xoa" value="xoa">Xóa</button>
        </div>
    </form>
    <?php
    require_once('../incfiles/end.php');
    exit;
    break;
    case 'edit':
        $sql = "select * from `idols` where `idol_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            echo'<div class="error">Không tìm thấy ID cần sửa trong hệ thống ! <a href="collection.php" class="button">Quay lại</a></div>';
            require_once('../incfiles/end.php');
            exit;
        }
        else
        {
            $res = mysqli_fetch_assoc($result);
        }
    ?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="collection.php">Collection Idol</a> > Sửa Collection</div>
<form method="post" action="" enctype="multipart/form-data">
<?php
if(isset($_POST['edit']))
{
    $name = htmlspecialchars($_POST['idol_edit']);
    $photo = $_FILES['photo'];
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên của sản phẩm";
    }
    if(empty($error))
    {
        if($photo['name'] == "")
        {
        $sql = "UPDATE `idols` SET `idol_name` = '$name' WHERE `idol_id` = '$id' limit 1";
        }
        else
        {
            $filename = date("ymdHis");
            $path = $_FILES['photo']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
            $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
            if (!in_array($ext, $validextensions))
            {
                $error['photo'] = "Định dạng ảnh không hợp lệ, ảnh phải có đuôi là .PNG, .JPG và .JPEG";
            }
            else
            {
                move_uploaded_file($_FILES['photo']['tmp_name'],'../photo/idols/'.$filename.'.'.$ext);
                $sql = "UPDATE `idols` SET `idol_name` = '$name', `idol_photo` = 'photo/idols/$filename.$ext' WHERE `idol_id` = '$id' limit 1";
            }
        }
        if(mysqli_query($con,$sql))
        {
            echo'<div class="success">Chỉnh sửa Collection Idol thành công ! <a href="collection.php" class="button">Quay lại</a></div>';
        }

    }

}
?>
<div class="input">
    <div class="input_box">Tên Idol</div>
    <div class="input_input">
        <input type="text" name="idol_edit" value="<?php echo $res['idol_name'];?>">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Ảnh đại diện</div>
    <div class="input_image">
        <img src="<?php echo $homeurl.'/'.$res['idol_photo'];?>" alt="">
    </div>
</div>
<div class="input">
    <div class="input_box">Thêm mới ảnh đại diện (Tùy chọn)</div>
    <div class="input_input">
        <input type="file" name="photo">
    </div>
    <?php echo (isset($error['photo'])) ? '<div class="error">'.$error['photo'].'</div>' : '';?>
</div>
<div class="input">
    <button class="button" name="edit" value="update">Chỉnh sửa</button>
    </div>
</div>
</form>
    <?php
    require('../incfiles/end.php');
    exit;
        break;
    }
    ?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="collection.php">Collection Idol</a></div>
<table width="100%" class="collection" cellspacing="0">
<th>STT</th>    <th>Tên</th>    <th>Photo</th>  <th>Panel</th>
<?php
$sql = "SELECT * FROM `idols` ORDER BY `idol_id` asc limit $start, $limit";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result))
{
    while($res = mysqli_fetch_assoc($result))
    {
        ?>
        <tr>
            <td><?php echo $res['idol_id'];?></td>
            <td><a href="<?php echo $homeurl.'/collection/index.php?id='.$res['idol_id'];?>"><?php echo $res['idol_name'];?></a></td>
            <td class="photo"><img src="<?php echo $homeurl.'/'.$res['idol_photo'];?>" title="<?php echo $res['idol_name'];?>"></td>
            <td class="panel">
                <a href="?do=edit&id=<?php echo $res['idol_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                <a href="?do=del&id=<?php echo $res['idol_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
            </td>
        </tr>
        <?php
    }
}
else
{
    echo'<div class="result_no">Chưa có Collection của bất kỳ IDOL nào !</div>';
}
?>
</table>
<?php
    $duy = "SELECT * FROM `idols`";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'admin/collection.php?do='
                ];
    $page1 = new Pagination($config);
    ?>
<?php
if($demtrang > $limit)
{
    echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
}
?>
<div style="text-align:center;"><a href="?do=add" class="button">Thêm mới</a></div>
<?php
require_once('../incfiles/end.php');
?>