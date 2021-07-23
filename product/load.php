<?php
require_once('../incfiles/core.php');
$nextPost = abs(intval($_POST['NextPost']));
$idProduct = abs(intval($_POST['idProduct']));
$chucvu = array(
    0 => '<span class="chucvu-member">- Khách hàng</span>',
    9 => '<span class="chucvu-admin">- Quản trị viên</span>'
);
$sql = "SELECT * FROM `productreview` WHERE `product_id` = '$idProduct' ORDER BY `review_id` DESC LIMIT $nextPost";
$result = mysqli_query($con,$sql);
$dem = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `productreview` WHERE `product_id` = '$idProduct'"));
$dong = mysqli_num_rows($result);
if($dong)
    {
       include('../users/func.php');
       while($res = mysqli_fetch_assoc($result))
        {
            $user_chat = getUser($res['user_id']);
            ?>
            <div class="review_chat">
            <table width="99%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;word-wrap: break-word;">
                <tbody>
                <tr>
                    <td class="box_list_avatar" width="50px;">
                        <img src="<?php echo $homeurl;?>/<?php echo $user_chat['photo'];?>" class="avatar" alt="">
                    </td>
                    <td class="box_list_comment">
                        <a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>" class="user_chat"><?php echo $user_chat['username'];?></a> <?php echo $chucvu[$user_chat['right']];?>
                    <?php
                    if($user_id == $res['user_id'] || $right >= 9)
                    {
                    ?>
                   <span class="cmt_del"><a href="index.php?id=<?php echo $id.'&do=del&uid='.$res['review_id'];;?>" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">X</a></span>
                    <?php
                    }
                    ?>
                   <br>
                    <?php
                    for($i=1;$i<=$res['rate'];$i++)
                    {
                        echo'<i class="fas fa-star pink"></i>';
                    }
                    ?>
                   <br>
                   <b><?php echo $res['title'];?></b>
                   <br><br>
                    <?php echo $res['message'];?>
                    <span class="chat_time"><?php echo thoigian($res['review_date']);?></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
            <?php
                }
        }
?>