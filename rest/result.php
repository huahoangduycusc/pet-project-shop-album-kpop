<?php
header("Content-Type:application/json");
require('../incfiles/core.php');
$result = mysqli_query($con,"SELECT a.`product_id`, a.`product_name`, a.`product_price`, a.`description`,a.`quantity`,b.`photo_name` FROM `product` a left JOIN `photo` b ON a.`product_id` = b.`product_id`
GROUP BY a.`product_id` ORDER BY a.`product_id` DESC");
if(mysqli_num_rows($result)>0)
{
    $duy = array();
    while($res = mysqli_fetch_array($result))
    {
        $duy[] = $res;
    }
echo json_encode($duy);
mysqli_close($con);
}
?>