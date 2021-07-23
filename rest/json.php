<?php
require_once('../incfiles/core.php');
$textl = "WEB API REST PHP RETRIEVE PRODUCT";
require_once('../incfiles/head.php');
$url = "http://localhost/shop389/rest/result.php"; //url của web service = rest
$client = curl_init($url);	
curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($client);
$result = json_decode($response,true);
echo'<div class="center">
    <a href="search.php" class="btn-json">Tìm kiếm</a>
    <a href="add.php" class="btn-json">Thêm mới</a>
</div>';
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
            if($right == 9)
            {
                echo'<div class="quantri">
                <a href="'.$homeurl.'/rest/edit.php?id='.$value[0].'"><img src="'.$homeurl.'/images/icon/edit.png" title="chỉnh sửa"></a>
                </div>';
            }
            echo'
        </div>
    </a>';
    echo'</div>';
    }
}
echo'</div>';
require_once('../incfiles/end.php');
?>