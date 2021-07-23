<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
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
<a href="<?php echo $homeurl.'/rest/json.php';?>" class="btn-left">Danh sách</a> 
<a href="<?php echo $homeurl.'/product/index.php?id='.$id;?>" class="btn-left">Xem sản phẩm</a>
<?php
if(isset($_POST['update']))
{
    $giatien = abs(intval($_POST['price']));
    $soluong = abs(intval($_POST['qtt']));
    $km = abs(intval($_POST['khuyenmai']));
    $chuyenmuc = htmlspecialchars($_POST['chuyenmuc']);
    $thantuong = abs(intval($_POST['idol']));
    $cungcap = abs(intval($_POST['cungcap']));
    $error = array(); // tạo 1 array lưu trữ các lỗi
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
        $url = "http://localhost/shop389/rest/json_edit.php?id=$id&price=$giatien&soluong=$soluong&km=$km&chuyenmuc=$chuyenmuc&idol=$thantuong&cc=$cungcap";
		
		$client = curl_init($url);	
		
		curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
		
		$response = curl_exec($client);
		
        $result1 = json_decode($response);
        if($result1->status == 1)
        {
            echo'<script>alert("'.$result1->msg.'");</script>';
        }
        else
        {
            echo'<script>alert("'.$result1->msg.'");</script>';
        }
    }
    // khi error rong tuc la khong he có lỗi thì tiến hành insert dữ liệu
}
?>
<form method="post" action="">
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
    <button class="button" name="update" value="update">Cập nhật</button>
    </div>
</div>
</form>
<?php
require_once('../incfiles/end.php');
?>