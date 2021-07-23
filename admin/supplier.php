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
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="supplier.php">Nhà cung cấp</a> > Thêm mới</div>
<form method="post" action="">
<?php
if(isset($_POST['update']))
{
    $name = htmlspecialchars($_POST['name_cc']);
    $dc = htmlspecialchars($_POST['dc_cc']);
    $phone = htmlspecialchars($_POST['phone_cc']);
    $error = array();
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên của nhà cung cấp";
    }
    if(empty($dc))
    {
        $error['dc'] = "Vui lòng nhập vào địa chỉ của nhà cung cấp";
    }
    if(empty($phone))
    {
        $error['phone'] = "Vui lòng nhập vào số điện thoại của nhà cung cấp";
    }
    if(empty($error))
    {
        $sql = "INSERT INTO `supplier`(`supplier_id`,`company_name`,`company_address`,`phone`) VALUES (NULL,'$name','$dc','$phone')";
        if(mysqli_query($con,$sql))
        {
            echo'<div class="success">Thêm mới nhà cung cấp thành công !</div>';
        }

    }

}
?>
<div class="input">
    <div class="input_box">Tên nhà cung cấp</div>
    <div class="input_input">
        <input type="text" name="name_cc" value="<?php echo isset($name) ? ''.$name.'' : '';?>">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Địa chỉ</div>
    <div class="input_input">
        <textarea name="dc_cc" rows="6"><?php echo isset($dc) ? ''.$dc.'' : '';?></textarea>
    </div>
    <?php echo (isset($error['dc'])) ? '<div class="error">'.$error['dc'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Số điện thoại</div>
    <div class="input_input">
        <input type="text" name="phone_cc" value="<?php echo isset($phone) ? ''.$phone.'' : '';?>">
    </div>
    <?php echo (isset($error['phone'])) ? '<div class="error">'.$error['phone'].'</div>' : '';?>
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
        $sql = "select * from `supplier` where `supplier_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(!mysqli_num_rows($result))
        {
            echo'<div class="error">Không tìm thấy ID cần xóa trong hệ thống ! <a href="supplier.php" class="button">Quay lại</a></div>';
            require_once('../incfiles/end.php');
            exit;
        }
        else
        {
            $res = mysqli_fetch_assoc($result);
        }
    ?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="supplier.php">Supplier</a> > Xóa</div>
    <?php
    if(isset($_POST['xoa']))
    {   
        $sql = "DELETE from `supplier` where `supplier_id` = '$id'";
        if(mysqli_query($con,$sql))
        {
            loadlai("admin/supplier.php");
        }
        require('../incfiles/end.php');
        exit;
    }
    ?>
    <form method="post" action="">
        <div class="list1">
            Bạn có thực sự muốn xóa Supllier <b><?php echo (isset($res['company_name'])) ? ''.$res['company_name'].'' : '';?></b>, việc này
            đồng nghĩa với việc các sản phẩm có liên quan đến <b><?php echo (isset($res['company_name'])) ? ''.$res['company_name'].'' : '';?></b> 
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
        $sql = "select * from `supplier` where `supplier_id` = '$id' limit 1";
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
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="supplier.php">Supplier</a> > Sửa thông tin</div>
<form method="post" action="">
<?php
if(isset($_POST['edit']))
{
    $name = htmlspecialchars($_POST['name_cc']);
    $dc = htmlspecialchars($_POST['dc_cc']);
    $phone = htmlspecialchars($_POST['phone_cc']);
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên nhà cung cấp";
    }
    if(empty($dc))
    {
        $error['dc'] = "Vui lòng nhập vào địa chỉ";
    }
    if(empty($phone))
    {
        $error['phone'] = "Vui lòng nhập vào số điện thoại liên lạc";
    }
    if(empty($error))
    {
        $sql = "UPDATE `supplier` SET `company_name` = '$name',`company_address` = '$dc', `phone` = '$phone' WHERE `supplier_id` = '$id' limit 1";
        if(mysqli_query($con,$sql))
        {
           loadlai("admin/supplier.php");
        }

    }

}
?>
<div class="input">
    <div class="input_box">Tên nhà cung cấp</div>
    <div class="input_input">
        <input type="text" name="name_cc" value="<?php echo $res['company_name'];?>">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Địa chỉ</div>
    <div class="input_input">
    <textarea name="dc_cc" rows="6"><?php echo $res['company_address'];?></textarea>
    </div>
    <?php echo (isset($error['dc'])) ? '<div class="error">'.$error['dc'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Số điện thoại</div>
    <div class="input_input">
        <input type="text" name="phone_cc" value="<?php echo $res['phone'];?>">
    </div>
    <?php echo (isset($error['phone'])) ? '<div class="error">'.$error['phone'].'</div>' : '';?>
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
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="supplier.php">Supplier</a></div>
<table width="100%" class="collection" cellspacing="0">
<th>Company</th>    <th>Address</th>     <th>Phone</th> <th>Panel</th>
<?php
$sql = "SELECT * FROM `supplier` ORDER BY `supplier_id` DESC LIMIT $start, $limit";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result))
{
    while($res = mysqli_fetch_assoc($result))
    {
        ?>
        <tr>
            <td><?php echo $res['company_name'];?></td>
            <td><?php echo $res['company_address'];?></td>
            <td><?php echo $res['phone'];?></td>
            <td class="panel">
                <a href="?do=edit&id=<?php echo $res['supplier_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/edit.png" alt=""></a>
                <a href="?do=del&id=<?php echo $res['supplier_id'];?>"><img src="<?php echo $homeurl;?>/images/icon/del.png" alt=""></a>
            </td>
        </tr>
        <?php
    }
}
else
{
    echo'<div class="result_no">Chưa có bất kỳ nhà cung cấp nào !</div>';
}
?>
</table>
<?php
    $duy = "SELECT * FROM `supplier`";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'admin/supplier.php?do'
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