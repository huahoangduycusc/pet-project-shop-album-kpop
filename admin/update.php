<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
?>
<div class="page_title"><a href="">Trang chủ</a> > Admin Panel > <a href="">Thêm sản phẩm mới</a></div>
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
        $sql = "INSERT INTO `product` (`product_id`,`product_name`,`product_price`,`description`,`lastdate`,`quantity`,`sale_id`,
        `category_id`,`idol_id`,`supplier_id`) VALUES (NULL,'$name','$giatien','$mota','$timeSql','$soluong','$km','$chuyenmuc','$thantuong','$cungcap')";
        if(mysqli_query($con,$sql))
        {
            $rid = mysqli_insert_id($con);
            // tien hanh them anh
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
                        move_uploaded_file($_FILES['photo']['tmp_name'][$i],'../photo/product/'.$filename.'.'.$ext);
                        $sql = "INSERT INTO `photo`(`photo_id`,`photo_name`,`product_id`) VALUES (NULL,'photo/product/$filename.$ext','$rid')";
                        mysqli_query($con,$sql);
                    }
                    else
                    {
                    echo"<div class='error'>Định dạng ảnh không hợp lệ, ảnh phải có đuôi là .PNG, .JPG và .JPEG</div>";
                    }
                }
            }
            loadlai("admin/products.php");
        }
    }
    // khi error rong tuc la khong he có lỗi thì tiến hành insert dữ liệu
}
?>
<form method="post" action="" enctype="multipart/form-data">
<div class="input">
    <div class="input_box">Tên sản phẩm</div>
    <div class="input_input">
        <input type="text" placeholder="Tên sản phẩm" name="name" value="<?php echo isset($name) ? ''.$name.'' : '';?>" required="required">
    </div>
    <?php echo (isset($error['name'])) ? '<div class="error">'.$error['name'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Mô tả</div>
    <div class="input_input">
        <textarea name="description" placeholder="Mô tả chi tiết sản phẩm" rows="10"><?php echo isset($mota) ? ''.$mota.'' : '';?></textarea>
    </div>
    <?php echo (isset($error['mota'])) ? '<div class="error">'.$error['mota'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_input_col3">
       Giá tiền <input type="text" class="input_input_w3" name="price" value="<?php echo isset($giatien) ? ''.$giatien.'' : '';?>" required="required">
       <?php echo (isset($error['giatien'])) ? '<div class="error">'.$error['giatien'].'</div>' : '';?>
       Số lượng <input type="text" class="input_input_w3" name="qtt" value="<?php echo isset($soluong) ? ''.$soluong.'' : '';?>">
       <?php echo (isset($error['soluong'])) ? '<div class="error">'.$error['soluong'].'</div>' : '';?>
    </div>

</div>
<div class="input">
    <div class="input_box">Khuyến mãi</div>
    <div class="input_input">
        <select name="khuyenmai" class="select">
            <?php
            $sql = "select * from `saleoff`";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res=mysqli_fetch_assoc($result))
                {
                    echo'<option value="'.$res['sale_id'].'">'.$res['sale_name'].'</option>';
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
            $sql = "select * from `category` order by `category_id` asc";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res=mysqli_fetch_assoc($result))
                {
                    echo'<option value="'.$res['category_id'].'">'.$res['category_name'].'</option>';
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
            $sql = "select * from `idols` order by `idol_id` asc";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res=mysqli_fetch_assoc($result))
                {
                    echo'<option value="'.$res['idol_id'].'">'.$res['idol_name'].'</option>';
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
            $sql = "select * from `supplier` order by `supplier_id` asc";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res=mysqli_fetch_assoc($result))
                {
                    echo'<option value="'.$res['supplier_id'].'">'.$res['company_name'].'</option>';
                }
            }
            ?>
        </select>
    </div>
    <?php echo (isset($error['cc'])) ? '<div class="error">'.$error['cc'].'</div>' : '';?>
</div>
<div class="input">
    <div class="input_box">Hình ảnh sản phẩm</div>
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
<?php
require_once('../incfiles/end.php');
?>