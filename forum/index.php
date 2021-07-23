<?php
require_once('../incfiles/core.php');
$textl = "Diễn đàn K-POP SHOP389 - Nơi lang tỏa niềm đam mê âm nhạc của bạn";
require_once('head.php');
include('func.php');
?>
<?php
$colors = array(
0 => "#808080",
1 => "rgb(245, 46, 105);",
2 => "rgb(30, 163, 240);",
3 => "rgb(255, 124, 49);",
4 => "rgb(158, 55, 255);",
5 => "rgb(255, 74, 225);",
6 => "rgb(53, 209, 100);",
7 => "#009900",
8 => "#0000FF",
9 => "#4C0099"
);
?>
<div class="box_home">Bài viết mới nhất</div>
<?php
$sql = "SELECT `forum_name` ,`topic_id`, `topic_name`, `topic_view`,`user_id` FROM `forum_topic` INNER JOIN `forum_chuyenmuc` 
ON `forum_topic`.`forum_id` = `forum_chuyenmuc`.`forum_id` ORDER BY `topic_time` DESC LIMIT 10";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result))
{
    include('../users/func.php');
    ?>
    <table class="table table-bordered" cellspacing="0"><tbody>
    <?php
    while($res = mysqli_fetch_assoc($result))
    {
        $nguoidung = getUser($res['user_id']);
        ?>
        <tr>
            <td class="tacgia">
                <div class="box_tacgia">
                    <span style="float:left;padding: 5px 5px 5px 0px;"><img class="avatar" src="<?php echo $homeurl.'/'.$nguoidung['photo'];?>" alt="" style="width: 40px;height: 40px;"></span>
                    <div class="topic_name"><span class="label" style="background-color: <?php echo $colors[rand(0,9)];?>"><?php echo $res['forum_name'];?></span><a href="view.php?id=<?php echo $res['topic_id'];?>" class="alert_link"><?php echo $res['topic_name'];?></a>
                        <?php echo chuy($res['topic_id']);?>
                        <div class="topic_author">bởi <a href="profile.php?id=<?php echo $res['user_id'];?>" class="alert_link"><?php echo $nguoidung['username'];?></a>
                        <?php echo reply($res['topic_id']);?>
                        <span><i>- Xem : <?php echo $res['topic_view'];?></i></span>
                        <?php echo like($res['topic_id']);?>
                    </div>
                    </div>
                <!-- topic name -->
                </div>
            <!-- box tac gia -->
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody></table>
    <?php
}
else
{
    echo'<div class="alert2 alert-warning">Chưa có bài viết mới nào !</div>';
}
?>
<br>
<div class="box_home">Chuyên mục diễn đàn</div>
<?php
$sql = "SELECT * FROM `forum_chuyenmuc` ORDER BY `forum_id` ASC LIMIT 20";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result))
{
    while($res = mysqli_fetch_assoc($result))
    {
        ?>
        <div class="box_chuyenmuc">
            <div class="box_chuyenmuc_name">
               <a href="chuyenmuc.php?id=<?php echo $res['forum_id'];?>"><?php echo $res['forum_name'];?></a>
            </div>
            <!-- chuyen muc name -->
            <div class="box_chuyemuc_mota">
                <?php echo $res['forum_desc'];?>
            </div>
            <!-- mo ta -->
            <?php
            // hien thi bai viet o day
            $sqll = "SELECT `topic_name`, `topic_id` FROM `forum_topic` WHERE `forum_id` = '".$res['forum_id']."' ORDER BY `topic_id` DESC LIMIT 2";
            $result1 = mysqli_query($con,$sqll);
            if(mysqli_num_rows($result1))
            {
                echo'<div class="box_chuyenmuc_topic">';
                while($arr = mysqli_fetch_array($result1))
                {
                    ?>
                        <div class="box_topic_name">
                            <a href="view.php?id=<?php echo $arr['topic_id'];?>"><i class="fas fa-comment-alt"></i> <?php echo $arr['topic_name'];?></a>
                            <?php echo chuy($arr['topic_id']);?>
                        </div>
                    <!-- topic xuat hien o day -->
                    <?php
                }
                echo'</div>';
            }
            ?>
        </div>
        <!-- end box  -->
        <?php
    }
}
?>
<?php
require_once('end.php');
?>