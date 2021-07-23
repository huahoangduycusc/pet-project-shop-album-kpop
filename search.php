<?php
$rootpath = "";
require_once('incfiles/core.php');
$textl = "Tìm kiếm";
require_once('incfiles/head.php');
$s = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : false;
?>
<div class="danhmuc">Kết quả tìm kiếm cho <?php echo $s?></div>
<div class="timkiem">
    <form action="" method="GET">
        <input type="text" name="search" value="<?php echo $s;?>" placeholder="Tìm kiếm"> <button>Search</button>
    </form>
</div>
<div class="clear"></div>
<?php
if($s)
{
    $product = new product();
    $sql = "SELECT * FROM `product` WHERE `product_name` LIKE '%$s%' ORDER BY `product_id`
    DESC LIMIT $start, $limit";
    $product->LocSanPham($sql);
}
?>
<?php
    $duy = "SELECT `product_id` FROM `product` WHERE `product_name` LIKE '%$s%'";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'search.php?search='.$s.'&list'
                ];
    $page1 = new Pagination($config);
    ?>
    <?php
    if($s)
    {
        ?>
        <div><center><ul class="pagination"><?php echo $page1->getPagination();?></ul></center></div>
        <?php
    }
    ?>
<?php
require_once('incfiles/end.php');
?>