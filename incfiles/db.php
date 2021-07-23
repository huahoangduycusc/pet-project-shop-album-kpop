<?php
$serverName = "localhost";
$serverUser = "root";
$serverPass = "";
$serverDb = "shop389";
$con = mysqli_connect($serverName,$serverUser,$serverPass,$serverDb);
if(!$con)
{
    echo mysqli_connect_error();
}
?>