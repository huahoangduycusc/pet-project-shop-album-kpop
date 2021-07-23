<?php
function getUser($id)
{
    global $con;
    $sql = "SELECT * FROM `users` where `user_id` = '$id' limit 1";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        return $res;
    }
    else
    {
        return false;
    }
}
?>