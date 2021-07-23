<?php
$rootpath = "";
require_once('incfiles/core.php');
setcookie('cuid', '');
setcookie('cups', '');
unset($_SESSION['sid']);
unset($_SESSION['spw']);
chuyenhuong();
?>