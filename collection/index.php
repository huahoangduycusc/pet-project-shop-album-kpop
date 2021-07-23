<?php
require_once('../incfiles/core.php');
$textl = 'Collection Artist';
require_once('../incfiles/head.php');
if($id == false)
{
    chuyenhuong();
}
$sql = "select * from `idols` where `idol_id` = '$id' limit 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    chuyenhuong();
}
else
{
    $res = mysqli_fetch_assoc($result);
}
$from = isset($_GET['from']) ? abs(intval($_GET['from'])) : 0;
$to = isset($_GET['to']) ? abs(intval($_GET['to'])) : 0;
$muc = isset($_GET['muc']) ? abs(intval($_GET['muc'])) : 0;
$idol = new idol();
?>
<div class="collection">
    <img src="<?php echo $homeurl.'/'.$res['idol_photo'];?>" alt="">
</div>
<div class="page_title"><a href="<?php echo $homeurl;?>">Trang chủ</a> > <a href="index.php?id=<?php echo $res['idol_id'];?>"><?php echo $res['idol_name'];?></a></div>
<div class="danhmuc">Lọc sản phẩm</div>
<div class="input">
    <div class="input_input_option">
        <select name="loc" id="loc">
            <option from="0" to="0" value="0" <?php if($muc == 0) echo 'selected="selected"';?>>Tất cả</option>
            <option from="0" to="100000" value="1" <?php if($muc == 1) echo 'selected="selected"';?>>0 VND ~ 100.000 VND</option>
            <option from="100000" to="200000" value="2" <?php if($muc == 2) echo 'selected="selected"';?>>100.000 VND ~ 200.000 VND</option>
            <option from="200000" to="500000" value="3" <?php if($muc == 3) echo 'selected="selected"';?>>200.000 VND ~ 500.000 VND</option>
            <option from="1000000" to="0" value="4" <?php if($muc == 4) echo 'selected="selected"';?>>Trên 1.000.000 VND</option>
        </select>
    </div>
</div>
<?php
switch($do)
{
    case 'list':
        if($from !=0 || $to != 0)
        {
        $sql = "SELECT * FROM `product` WHERE `idol_id` = '$id' AND `product_price` >= '$from' AND `product_price` <= '$to' ORDER BY `product_id` 
        DESC LIMIT $start, $limit";
        }
        if($from == 0)
        {
        $sql = "SELECT * FROM `product` WHERE `idol_id` = '$id' AND `product_price` <= '$to' ORDER BY `product_id` 
        DESC LIMIT $start, $limit";
        }
        if($to == 0)
        {
        $sql = "SELECT * FROM `product` WHERE `idol_id` = '$id' AND `product_price` >= '$from' ORDER BY `product_id` 
        DESC LIMIT $start, $limit";
        }
        $idol->LocSanPham($sql);
        ?>
<script>
document.getElementById("loc").onchange = function(event) {
    let from = event.target.selectedOptions[0].getAttribute("from");
    let to = event.target.selectedOptions[0].getAttribute("to");
    let muc = this.value;
    if(muc == 0)
    {
        window.location.href = 'index.php?id=<?php echo $id;?>';
    }
    else
    {
        window.location.href = 'index.php?id=<?php echo $id;?>&do=list&from='+from+'&to='+to+'&muc='+muc;
    }
};
</script>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
}
?>
<!-- Section new product end -->
    <?php
    $idol->collection($id,$start,$limit);
    ?>
    <?php
    $duy = "SELECT * FROM `product` where `idol_id` = '$id'";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'collection/index.php?id'
                ];
    $page1 = new Pagination($config);
    ?>
<div><center><ul class="pagination"><?php echo $page1->getPagination();?></ul></center></div>
<?php
require_once('../incfiles/end.php');
?>
<script>
document.getElementById("loc").onchange = function(event) {
    let from = event.target.selectedOptions[0].getAttribute("from");
    let to = event.target.selectedOptions[0].getAttribute("to");
    let muc = this.value;
    window.location.href = 'index.php?id=<?php echo $id;?>&do=list&from='+from+'&to='+to+'&muc='+muc;
};
</script>