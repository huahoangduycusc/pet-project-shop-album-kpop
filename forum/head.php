<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $textl;?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="<?php echo $homeurl;?>/theme/forum.css">
</head>
<body>
    <div style="text-align:center;width:100%;max-width:900px;margin-left:auto;margin-right:auto;">
        <div style="text-align:left;font-size: 12px;padding:5px;color:#000;">
			<span style="vertical-align: middle;">Diễn đàn KPOP, khu vui chởi giải trí cho các bạn trẻ. Hãy tham gia và chia sẻ tình yêu của bạn
			</span>
		</div>
        <img style="max-width:900px;width:100%" width="100%" src="https://i.imgur.com/iGE07WE.png">
    </div>
    <div class="container">
        <div class="text-center">
            <ul class="nav">
                <li style="width:25%;"><a href="<?php echo $homeurl;?>/forum">Trang chủ</a></li>
                <li style="width:25%;"><a href="<?php echo $homeurl?>">Mua sắm</a></li>
                <li style="width:25%;" class="active"><a href="">Diễn đàn</a></li>
                <li style="width:25%;"><a href="http://facebook.com">Fanpage</a></li>
            </ul>
        </div>
        <!-- dem follow va thong bao cua user -->
        <?php
        if($user_id)
        {
            $foll = mysqli_num_rows(mysqli_query($con,"SELECT `theodoi_id` FROM `topic_theodoi` WHERE `user_id` = '$user_id'"));
            $thongb = mysqli_num_rows(mysqli_query($con,"SELECT `thongbao_id` FROM `thongbao` WHERE `user_id` = '$user_id' AND `daxem` = '0'"));
        }
        ?>
        <!-- menu  -->
        <div class="box_welcome text-center">
            <span>
                <?php 
                if($user_id)
                {
                ?>
                <a href="<?php echo $homeurl;?>/forum/exit.php?do=<?php echo getCurURL();?>" style="margin: 8px 3px 0px 0px" class="btn btn-danger" title="Thoát"><i class="fas fa-sign-out-alt"></i> Thoát</a>
                <a href="<?php echo $homeurl?>/forum/profile.php?for=notification" style="margin: 8px 3px 0px 0px" class="btn btn-danger" title="Thông báo của bạn"><i class="fas fa-globe-asia"></i> <?php echo $thongb;?></a>
                <a href="<?php echo $homeurl?>/forum/profile.php?for=follow" style="margin: 8px 3px 0px 0px" class="btn btn-danger" title="Theo dõi"> <i class="far fa-eye"></i> <?php echo $foll;?></a>
                <a href="<?php echo $homeurl?>/forum/profile.php" style="margin: 8px 3px 0px 0px" class="btn btn-danger" title="Trang cá nhân"><i class="fas fa-user"></i> <?php echo $user['username'];?></a>
                <?php
                    if($right >=9)
                    {
                        echo'<a href="'.$homeurl.'/forum/panel" style="margin: 8px 3px 0px 0px" class="btn btn-danger" title="Quản lý diễn đàn"><i class="fas fa-cogs"></i> Panel</a>';
                    }
                }
                else 
                { 
                ?>
                <a href="<?php echo $homeurl;?>/dangnhap.php" style="margin: 8px 3px 0px 0px" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Đăng nhập</a>
                <a href="<?php echo $homeurl;?>/dangky.php" style="margin: 8px 3px 0px 0px" class="btn btn-danger"><i class="fas fa-user"></i> Đăng ký</a>
                <?php
                }
                ?>
            </span>
        </div>
        <div class="clear"></div>
        <!-- menu dang nhap -->
<?php
function online($id)
{
    global $con;
    global $homeurl;
    $sql = "SELECT `status`,`fullname` FROM `users` WHERE `user_id` = '$id' LIMIT 1";
    $result = mysqli_query($con,$sql);
    $out = "";
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        if($res['status']+300 > time())
        {
            $out = '<img src="'.$homeurl.'/forum/images/online.png" style="vertical-align:middle;" title="'.$res['fullname'].' đang online">';
        }
        else
        {
            $out = '<img src="'.$homeurl.'/forum/images/offline.png" style="vertical-align:middle;" title="offline">';
        }
    }
    return $out;
}
// kiem tra nguoi dung co bi khoa nick hay khong
if($user_id)
{
    function block($id)
    {
        global $con;
        $sql = "SELECT `block_id`,`ngayhethan` FROM `blockuser` WHERE `user_id` = '$id' ORDER BY `ngayhethan` DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            $res = mysqli_fetch_assoc($result);
            if($res['ngayhethan'] > time())
            {
                loadlai("forum/block/index.php");
            }
            else
            {
                mysqli_query($con,"DELETE FROM `blockuser` WHERE `block_id` = '".$res['block_id']."' LIMIT 1");
            }
        }
    }
    block($user_id);
}
?>