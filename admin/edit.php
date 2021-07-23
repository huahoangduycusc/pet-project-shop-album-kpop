<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
$photo = isset($_GET['photo']) ? intval(abs($_GET['photo'])) : false;
if($right < 9)
{
    chuyenhuong();
}
if($id == false)
{
    chuyenhuong();
}
$sql = "SELECT * FROM `product` WHERE `product_id` = '$id' limit 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    chuyenhuong();
}
$res = mysqli_fetch_assoc($result);
?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="">Chỉnh sửa thông tin sản phẩm</a></div>
<a href="<?php echo $homeurl.'/admin/products.php';?>" class="btn-left">Trang quản lý</a> 
<a href="<?php echo $homeurl.'/product/index.php?id='.$id;?>" class="btn-left">Xem sản phẩm</a>
<?php
if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $mota = $_POST['description'];
    $mota = htmlspecialchars($mota, ENT_QUOTES);
    $name = htmlspecialchars($name, ENT_QUOTES);
    $giatien = abs(intval($_POST['price']));
    $soluong = abs(intval($_POST['qtt']));
    $km = abs(intval($_POST['khuyenmai']));
    $chuyenmuc = htmlspecialchars($_POST['chuyenmuc']);
    $thantuong = abs(intval($_POST['idol']));
    $cungcap = abs(intval($_POST['cungcap']));
    $countfiles = count($_FILES['photo']['name']);
    $error = array(); // tạo 1 array lưu trữ các lỗi
    if(empty($name))
    {
        $error['name'] = "Vui lòng nhập vào tên của sản phẩm";
    }
    if(empty($mota))
    {
        $error['mota'] = "Vui lòng nhập vào mô tả của sản phẩm";
    }
    if(empty($giatien))
    {
        $error['giatien'] = "Vui lòng nhập vào giá tiền của sản phẩm";
    }
    if(empty($soluong))
    {
        $error['soluong'] = "Vui lòng nhập số lượng sản phẩm được bán";
    }
    if(empty($km))
    {
        $error['km'] = "Chọn hình thức khuyến mãi";
    }
    if(empty($chuyenmuc))
    {
        $error['chuyenmuc'] = "Vui lòng chọn chuyên mục cho sản phẩm";
    }
    if(empty($thantuong))
    {
        $error['idol'] = "Vui lòng chọn Collection Idol";
    }
    if(empty($cungcap))
    {
        $error['cc'] = "Vui lòng chọn nhà cung cấp sản phẩm";
    }
    // khi error rong thi insert du lieu
    if(empty($error))
    {
        $sql = "UPDATE `product` SET `product_name` = '$name', `product_price` = '$giatien', `description` = '$mota', `lastdate` = '$timeSql',
        `quantity` = '$soluong', `sale_id` = '$km', `category_id` = '$chuyenmuc', `idol_id` = '$thantuong', `supplier_id` = '$cungcap' 
        WHERE `product_id` = '$id' LIMIT 1";
        if(mysqli_query($con,$sql))
        {
            // neu cau lenh chinh sua thanh cong
            for($i=0;$i<$countfiles;$i++)
            {
                // nhu nhu input file khong rong
                if($_FILES['photo']['name'][$i] != "")
                {
                    $filename = date("ymdHis"); // lay ten anh theo thoi gian
                    $filename .= $i; // cong them so thu tu de tranh bi trung ten
                    $path = $_FILES['photo']['name'][$i]; // lay ten anh
                    $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
                    $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
                    if (in_array($ext, $validextensions)) // tìm đuôi phù hợp
                    {
                        move_uploaded_file($_FILES['photo']['tmp_name'][$i],'../photo/product/'.$filename.'.'.$ext);
                        $sql = "INSERT INTO `photo`(`photo_id`,`photo_name`,`product_id`) VALUES (NULL,'photo/product/$filename.$ext','$id')";
                        mysqli_query($con,$sql);
                    }
                    else
                    {
                    echo"<div class='error'>Định dạng ảnh không hợp lệ, ảnh phải có đuôi là .PNG, .JPG và .JPEG</div>";
                    }
                }
            }
            loadlai("admin/edit.php?id=$id"); // chay duoc toi day nghia la da cap nhat thanh cong
        }
    }
    // khi error rong tuc la khong he có lỗi thì tiến hành insert dữ liệu
}
?>
<form method="post" action="" enctype="multipart/form-data">
<div class="input">
    <div class="input_box">Tên sản phẩm</div>
    <div class="input_input">
        <input type="text" placeholder="Tên sản phẩm" name="name" value="<?php echo $res['product_name'];?>" required="required">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Mô tả</div>
    <div class="input_input">
        <textarea name="description" placeholder="Mô tả chi tiết sản phẩm" rows="10" required="required"><?php echo $res['description'];?></textarea>
    </div>
    <?php echo (isset($error['mota'])) ? '<div class="error">'.$error['mota'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_input_col3">
       Giá tiền <input type="text" class="input_input_w3" name="price" value="<?php echo $res['product_price'];?>" required="required">
       <?php echo (isset($error['giatien'])) ? '<div class="error">'.$error['giatien'].'</div>' : '';?>
       Số lượng <input type="text" class="input_input_w3" name="qtt" value="<?php echo $res['quantity'];?>">
       <?php echo (isset($error['soluong'])) ? '<div class="error">'.$error['soluong'].'</div>' : '';?>
    </div>

</div>
<div class="input">
    <div class="input_box">Khuyến mãi</div>
    <div class="input_input">
        <select name="khuyenmai" class="select">
            <?php
            $sql1 = "select * from `saleoff`";
            $result1 = mysqli_query($con,$sql1);
            if(mysqli_num_rows($result1))
            {
                while($res1=mysqli_fetch_assoc($result1))
                {
                    echo'<option value="'.$res1['sale_id'].'"'; ; if($res['sale_id'] == $res1['sale_id']) echo 'selected="selected"';echo'>'.$res1['sale_name'].'</option>';
                }
            }
            ?>
        </select>
    </div>
    <?php echo (isset($error['km'])) ? '<div class="error">'.$error['km'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Chuyên mục sản phẩm</div>
    <div class="input_input">
        <select name="chuyenmuc" class="select">
            <option value="">Chọn danh mục</option>
            <?php
            $sql2 = "select * from `category` order by `category_id` asc";
            $result2 = mysqli_query($con,$sql2);
            if(mysqli_num_rows($result2))
            {
                while($res2=mysqli_fetch_assoc($result2))
                {
                    echo'<option value="'.$res2['category_id'].'"'; if($res['category_id'] == $res2['category_id']) echo 'selected="selected"';echo'>'.$res2['category_name'].'</option>';
                }
            }
            ?>
        </select>
    </div>
    <?php echo (isset($error['chuyenmuc'])) ? '<div class="error">'.$error['chuyenmuc'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Chuyên Collection IDOL</div>
    <div class="input_input">
        <select name="idol" class="select">
            <option value="">Chọn danh mục</option>
            <?php
            $sql3 = "select * from `idols` order by `idol_id` asc";
            $result3 = mysqli_query($con,$sql3);
            if(mysqli_num_rows($result3))
            {
                while($res3=mysqli_fetch_assoc($result3))
                {
                    echo'<option value="'.$res3['idol_id'].'"'; if($res['idol_id'] == $res3['idol_id']) echo 'selected="selected"';echo'>'.$res3['idol_name'].'</option>';
                }
            }
            ?>
        </select>
    </div>
    <?php echo (isset($error['idol'])) ? '<div class="error">'.$error['idol'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Chuyên nhà cung cấp</div>
    <div class="input_input">
        <select name="cungcap" class="select" required="required">
            <option value="">Chọn danh mục</option>
            <?php
            $sql4 = "select * from `supplier` order by `supplier_id` asc";
            $result4 = mysqli_query($con,$sql4);
            if(mysqli_num_rows($result4))
            {
                while($res4=mysqli_fetch_assoc($result4))
                {
                    echo'<option value="'.$res4['supplier_id'].'"'; if($res['supplier_id'] == $res4['supplier_id']) echo 'selected="selected"';echo'>'.$res4['company_name'].'</option>';
                }
            }
            ?>
        </select>
    </div>
    <?php echo (isset($error['cc'])) ? '<div class="error">'.$error['cc'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Hình ảnh sản phẩm</div>
    <div class="product_list_album">
                            <?php
                            $sql = "SELECT * FROM `photo` WHERE `product_id` = '$id'";
                            $result = mysqli_query($con,$sql);
                            if(mysqli_num_rows($result))
                            {
                                while($res = mysqli_fetch_assoc($result))
                                {
                                    echo'<img src="'.$homeurl.'/'.$res['photo_name'].'" style="opacity:1;"> 
                                    <a href="edit.php?do=del&id='.$id.'&photo='.$res['photo_id'].'" style="color:red;"> X </a>';
                                }
                            }
                            ?>
    </div>
    <br>
    <div class="input_box">Thêm hình mới nếu bạn muốn</div>
    <div class="input_input">
        <input type="file" name="photo[]">
    </div>
    <div class="input_input">
        <input type="file" name="photo[]">
    </div>
    <div class="input_input">
        <input type="file" name="photo[]">
    </div>
    <?php echo (isset($error['photo'])) ? '<div class="error">'.$error['photo'].'</div>' : '';?>
</div>
<div class="input">
    <button class="button" name="update" value="update">Cập nhật</button>
    </div>
</div>
</form>
<!-- xoa hinh anh san pham -->
    <?php
    switch($do)
    {
        case 'del':
            $sql = "SELECT * FROM `photo` WHERE `photo_id` = '$photo' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                loadlai("admin/edit.php?id=$id");
            }
            // cau lenh xoa anh
            $sql = "SELECT `photo_name` FROM `photo` WHERE `photo_id` = '$photo' LIMIT 1";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                $res = mysqli_fetch_assoc($result);
                unlink("../".$res['photo_name']."");
            }
            $sql = "DELETE FROM `photo` WHERE `photo_id` = '$photo'";
            if(mysqli_query($con,$sql))
            {
                loadlai("admin/edit.php?id=$id");
            }
            exit;
        break;
    }
    ?>
<?php
require_once('../incfiles/end.php');
?>