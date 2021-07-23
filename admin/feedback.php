<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
$sql = "SELECT `fb_id` FROM `feedback`";
$total = mysqli_num_rows(mysqli_query($con,$sql));
$sql1 = "SELECT `fb_id` FROM `feedback` WHERE `seen` = '0'";
$seen = mysqli_num_rows(mysqli_query($con,$sql1));
include('../users/func.php');
?>
<div class="admin_layout">
    <div class="admin_left">
        <div class="admin_menu">Quản lý feedback</div>
        <div class="admin_list">
            <div class="admin_list_item">
                <a href="feedback.php">Tất cả Feedback (<?php echo $total;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="feedback.php?do=chuaxem">Feedback chưa xem (<?php echo $seen;?>)</a>
            </div>
        </div>
    </div>
<?php
switch($do)
{
    case 'chitiet':
            $sql = "SELECT * FROM `feedback` WHERE `fb_id` = '$id' limit 1";
            $result = mysqli_query($con,$sql);
            if(!mysqli_num_rows($result))
            {
                chuyenhuong();
            }
            $res = mysqli_fetch_assoc($result);
            $user = getUser($res['user_id']);
            include('send.php');
        ?>
        <div class="admin_right">
        <div class="admin_menu"><?php echo $res['title'];?></div>
        <div class="feedback">
            <span class="tacgia">Tác già bài viết <?php echo $user['username'].' ('.$user['fullname'].')';?></span>
            <?php echo $res['description'];?>
            <span class="chat_time">
                <?php echo $res['fb_date'];?>
            </span>
        </div>
        <br>
        <button class="button-right" id="phanhoi">Phản hồi</button>
        <form action="" method="post">
            <?php
            if(isset($_POST['gui']))
            {
                $tieude = $_POST['tds'];
                $msg = $_POST['nd'];
                if(!empty($tieude) || !empty($msg))
                {
                    sendGMail($tieude,$msg,$user['fullname'],$res['email']);
                }
            }
            ?>
            <div class="phanhoi" id="add">
                <div class="input">
                    <div class="input_box">
                        Email của tác giả
                    </div>
                    <div class="input_input">
                        <input type="text" name="email" value="<?php echo $res['email'];?>" readonly>
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Subject
                    </div>
                    <div class="input_input">
                        <input type="text" name="tds" placeholder="Tiêu đề mail sẽ gửi đi" required="required">
                    </div>
                </div>
                <!-- input -->
                <div class="input">
                    <div class="input_box">
                        Nội dung Mail
                    </div>
                    <div class="input_input">
                        <textarea name="nd" rows="7" placeholder="Nội dung phản hồi đến Mail" required="required"></textarea>
                    </div>
                </div>
                <div class="input">
                    <button class="button-right" name="gui" value="gui">Gửi</button>
                </div>
                <br>
                <!-- input -->
            </div>
            <!-- phanhoi div -->
        </form>
        <a href="feedback.php" class="btn-pink">Quay lại</a>
    </div>
</div>
<script>
    var cmt = document.getElementById("phanhoi");
    var flag = true;
    cmt.addEventListener('click',function()
    {
        var addcmt = document.getElementById("add");
        addcmt.classList.toggle('active');
        if(flag == true)
        {
            flag = false;
            cmt.innerHTML = "Đóng";
        }
        else
        {
            flag = true;
            cmt.innerHTML = "Phản hồi";
        }
    });
</script>
        <?php
        $sql = "UPDATE `feedback` SET `seen` = '1' WHERE `fb_id` = '$id' LIMIT 1";
        mysqli_query($con,$sql);
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'chuaxem':
        ?>
        <!-- Menu bên tay trái -->
    <div class="admin_right">
        <div class="admin_menu">Danh sách tất cả feedback chưa xem</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>FB ID</th> <th>Người gửi</th> <th>Tiêu đề</th> <th>Email</th> <th>Ngày gửi</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT * FROM `feedback` WHERE `seen` = '0' ORDER BY `fb_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    $user = getUser($res['user_id']);
                    ?>
                    <tr>
                        <td><?php echo $res['fb_id'];?></td>
                        <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $user['username'];?></a></td>
                        <td><?php echo $res['title'];?></td>
                        <td><?php echo $res['email'];?></td>
                        <td><?php echo $res['fb_date'];?></td>
                        <td class="panel">
                            <a href="?id=<?php echo $res['fb_id'];?>&do=chitiet">Xem thêm »</a>
                        </td>
                    </tr>
                    <?php
                }
            }
            else
            {
                echo'<div class="result_no">Chưa có bất kỳ feedback nào !</div>';
            }
            ?>
        </table>
        <?php
        $duy = "SELECT `fb_id` FROM `feedback` WHERE `seen` = '0'";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/feedback.php?do=chuaxem&list'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
}
?>
    <!-- Menu bên tay trái -->
    <div class="admin_right">
        <div class="admin_menu">Danh sách tất cả feedback</div>
        <table class="collection" cellspacing="0" cellpadding="0">
            <th>FB ID</th> <th>Người gửi</th> <th>Tiêu đề</th> <th>Email</th> <th>Ngày gửi</th> <th>Quản lý</th>
            <?php
            $sql = "SELECT * FROM `feedback` ORDER BY `fb_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    $user = getUser($res['user_id']);
                    ?>
                    <tr>
                        <td><?php echo $res['fb_id'];?></td>
                        <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $user['username'];?></a></td>
                        <td><?php echo $res['title'];?></td>
                        <td><?php echo $res['email'];?></td>
                        <td><?php echo $res['fb_date'];?></td>
                        <td class="panel">
                            <a href="?id=<?php echo $res['fb_id'];?>&do=chitiet">Xem thêm »</a>
                        </td>
                    </tr>
                    <?php
                }
            }
            else
            {
                echo'<div class="result_no">Chưa có bất kỳ feedback nào !</div>';
            }
            ?>
        </table>
        <?php
        $duy = "SELECT `fb_id` FROM `feedback`";
        $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                    $config = [
                        'total' => $demtrang,
                        'querys' => $id,
                        'limit' => $limit,
                        'url' => 'admin/feedback.php?do'
                    ];
        $page1 = new Pagination($config);
        ?>
        <?php
        if($demtrang > $limit)
        {
            echo'<div><center><ul class="pagination">'.$page1->getPagination().'</ul></center></div>';
        }
        ?>
    </div>
    <!-- Menu bên tay phải -->
</div>
<?php
require_once('../incfiles/end.php');
?>