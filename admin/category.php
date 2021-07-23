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
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="category.php">Category</a> > Thêm mới</div>
<form method="post" action="">
<?php
if(isset($_POST['update']))
{
    $name = htmlspecialchars($_POST['cm_add']);
    $error = array();
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên của sản phẩm";
    }
    if(empty($error))
    {
        $sql = "INSERT INTO `category`(`category_id`,`category_name`) VALUES (NULL,'$name')";
        if(mysqli_query($con,$sql))
        {
            echo'<div class="success">Thêm mới Danh mục thành công !</div>';
        }

    }

}
?>
<div class="input">
    <div class="input_box">Tên danh mục</div>
    <div class="input_input">
        <input type="text" name="cm_add" value="<?php echo isset($name) ? ''.$name.'' : '';?>">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
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
        $sql = "select `category_name` from `category` where `category_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            echo'<div class="error">Không tìm thấy ID cần xóa trong hệ thống ! <a href="category.php" class="button">Quay lại</a></div>';
            require_once('../incfiles/end.php');
            exit;
        }
        else
        {
            $res = mysqli_fetch_assoc($result);
        }
    ?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="category.php">Category</a> > Xóa</div>
    <?php
    if(isset($_POST['xoa']))
    {   
        $sql = "DELETE from `category` where `category_id` = '$id'";
        mysqli_query($con,$sql);
        echo'<div class="success">Xóa thành công ! <a href="category.php" class="button">Quay lại</a></div>';
        require('../incfiles/end.php');
        exit;
    }
    ?>
    <form method="post" action="">
        <div class="list1">
            Bạn có thực sự muốn xóa danh mục <b><?php echo (isset($res['category_name'])) ? ''.$res['category_name'].'' : '';?></b>, việc này
            đồng nghĩa với việc các sản phẩm có liên quan đến <b><?php echo (isset($res['category_name'])) ? ''.$res['category_name'].'' : '';?></b> 
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
        $sql = "select * from `category` where `category_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            echo'<div class="error">Không tìm thấy ID cần sửa trong hệ thống ! <a href="category.php" class="button">Quay lại</a></div>';
            require_once('../incfiles/end.php');
            exit;
        }
        else
        {
            $res = mysqli_fetch_assoc($result);
        }
    ?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="category.php">Category</a> > Sửa tên</div>
<form method="post" action="">
<?php
if(isset($_POST['edit']))
{
    $name = htmlspecialchars($_POST['cm_add']);
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên Danh mục";
    }
    if(empty($error))
    {
        $sql = "UPDATE `category` SET `category_name` = '$name' WHERE `category_id` = '$id' limit 1";
        if(mysqli_query($con,$sql))
        {
           loadlai("admin/category.php");
        }

    }

}
?>
<div class="input">
    <div class="input_box">Tên Danh mục</div>
    <div class="input_input">
        <input type="text" name="cm_add" value="<?php echo $res['category_name'];?>">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
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
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="category.php">Category</a></div>
<table width="100%" class="collection" cellspacing="0">
<th>ID</th>    <th>Tên Chuyên mục</th>     <th>Panel</th>
<?php
$sql = "SELECT * FROM `category` ORDER BY `category_id` DESC LIMIT $start, $limit";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result))
{
    while($res = mysqli_fetch_assoc($result))
    {
        ?>
        <tr>
            <td><?php echo $res['category_id'];?></td>
            <td><a href="<?php echo $homeurl;?>/category/index.php?id=<?php echo $res['category_id'];?>"><?php echo $res['category_name'];?></a></td>
            <td class="panel">
                <a href="?do=edit&id=<?php echo $res['category_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                <a href="?do=del&id=<?php echo $res['category_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
            </td>
        </tr>
        <?php
    }
}
else
{
    echo'<div class="result_no">Chưa có bất kỳ danh mục sản phẩm nào !</div>';
}
?>
</table>
<?php
    $duy = "SELECT * FROM `category`";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'admin/category.php?do'
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