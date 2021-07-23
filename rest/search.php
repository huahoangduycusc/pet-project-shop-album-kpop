<?php
require_once('../incfiles/core.php');
$textl = "TÌM KIẾM REST API";
require_once('../incfiles/head.php');
?>
<div class="center">
    <a href="json.php" class="btn-json">Danh sách</a>
    <a href="add.php" class="btn-json">Thêm mới</a>
</div>
<div class="form-json">
    <form action="" method="GET">
        <div class="input_json">
            <input type="text" name="s" placeholder="Tìm kiếm">
            <input type="submit" name="submit" value="Search">
        </div>
    </form>
</div>
<?php
if(isset($_GET['s']))
{
    $url = "http://localhost/shop389/rest/search_json.php?s=".$_GET['s']; //url của web service = rest
    $client = curl_init($url);	
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($client);
    $result = json_decode($response,true);
    echo'<section class="product">';
    if($result != null)
    {
        foreach($result as $key => $value)
        {
            echo'<div class="product_item">';
            echo'<a href="'.$homeurl.'/product/'.slugify($value[1]).'/'.$value[0].'">';
            echo'<div class="product_image">
                <img src="'.$homeurl.'/'.$value[5].'" alt="">
            </div>';
            echo'<div class="product_infor">
                <div class="product_name">
                    '.$value[1].'
                </div>';
                    echo'<div class="product_price">'.number_format($value[2]).' VND</div>';
                if($value[4] == 0)
                {
                    echo'<span class="sold_out">SOLD OUT</span>';
                }
                echo'
            </div>
        </a>';
        echo'</div>';
        }
    }
    echo'</div>';
}
?>
<?php
require_once('../incfiles/end.php');
?>