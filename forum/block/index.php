<?php
$rootpath = '../../';
require_once('../../incfiles/core.php');
$textl = "Tài khoản của bạn đang bị khóa";
require_once('../../forum/headban.php');
function block($id)
    {
        global $con;
        $sql = "SELECT `lydo`, `ngayhethan` FROM `blockuser` WHERE `user_id` = '$id' ORDER BY `ngayhethan` DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            $res = mysqli_fetch_assoc($result);
            if($res['ngayhethan'] < time())
            {
                loadlai("forum");
            }
        }
        else
        {
            loadlai("forum");
        }
    }
    block($user_id);
?>
<div class="box_home">Tài khoản của bạn đang bị khóa</div>
<?php
$sql = "SELECT `lydo`, `ngayhethan` FROM `blockuser` WHERE `user_id` = '$user_id' ORDER BY `ngayhethan` DESC LIMIT 1";
$result = mysqli_query($con,$sql);
$res = mysqli_fetch_assoc($result);
$ngethethan = date("H:i d-m-Y",$res['ngayhethan']);
?>
<div class="alert2 alert-danger">
    <ul>
        <li>Tài khoản của bạn đang bị khóa, bạn không thể truy cập diễn đàn trong thời gian này.</li>
        <?php if($res['ngayhethan'] == 2147483647)
        {
            echo'<li>Tài khoản của bạn đã bị khóa vô thời hạn.</li>';
        }
        else
        {
            echo'<li>Bạn bị khóa đến hết ngày '.$ngethethan.'</li>';
        }
        ?>
        <li>Lý do : <?php echo $res['lydo'];?></li>
    </ul>
</div>
<?php
require_once('../../forum/end.php');
?>