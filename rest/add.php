<?php
require_once('../incfiles/core.php');
$textl = "Thêm dữ liệu bằng JSON REST PHP";
require_once('../incfiles/head.php');
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
        $url = "http://localhost/shop389/rest/json_update.php?name=$name&mota=$mota&price=$giatien&soluong=$soluong&km=$km&chuyenmuc=$chuyenmuc&idol=$thantuong&cc=$cungcap";
		
		$client = curl_init($url);	
		
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		
		$response = curl_exec($client);
		
        $result = json_decode($response);
        if($result->status == 1)
        {
            echo'<script>alert("'.$result->msg.'");</script>';
        }
        else
        {
            echo'<script>alert("'.$result->msg.'");</script>';
        }
    }
    // khi error rong tuc la khong he có lỗi thì tiến hành insert dữ liệu
}
?>
<form method="POST" action="">
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
    <button class="button" name="update" value="update">Cập nhật</button>
    </div>
</div>
</form>
<?php
require_once('../incfiles/end.php');
?>