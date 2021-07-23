<?php
require_once('../incfiles/core.php');
$textl = "Admin Panel - Quản lý hệ thống";
require_once('../incfiles/head.php');
if($right < 9)
{
    chuyenhuong();
}
$sql = "SELECT `user_id` FROM `users` WHERE `right` = '0'";
$total = mysqli_num_rows(mysqli_query($con,$sql));
$sql1 = "SELECT `user_id` FROM `users` WHERE `right` = '9'";
$total1 = mysqli_num_rows(mysqli_query($con,$sql1));
$sql2 = "SELECT `user_id` FROM `users`";
$total2 = mysqli_num_rows(mysqli_query($con,$sql2));
$sql3 = "SELECT `user_id` FROM `users` WHERE `gender` = '1'";
$total3 = mysqli_num_rows(mysqli_query($con,$sql3));
$sql4 = "SELECT `user_id` FROM `users` WHERE `gender` = '2'";
$total4 = mysqli_num_rows(mysqli_query($con,$sql4));
?>
<div class="admin_layout">
    <div class="admin_left">
        <div class="admin_menu">Quản lý người dùng</div>
        <div class="admin_list">
            <div class="admin_list_item">
                <a href="customer.php">Danh sách tất cả người dùng (<?php echo $total2;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="customer.php?do=view&for=khachhang">Danh sách khách hàng (<?php echo $total;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="customer.php?do=view&for=admin">Danh sách quản trị viên (<?php echo $total1;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="customer.php?do=view&for=nam">Danh sách người dùng là nam (<?php echo $total3;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="customer.php?do=view&for=nu">Danh sách người dùng là nữ (<?php echo $total4;?>)</a>
            </div>
            <div class="admin_list_item">
                <a href="customer.php?do=search">Tìm kiếm người dùng</a>
            </div>
        </div>
    </div>
<?php
switch($do)
{
    case 'search':
        ?>
        <div class="admin_right">
            <div class="admin_menu">Tìm kiếm người dùng</div>
            <form action="" method="post">
            <?php
            if(isset($_POST['tim']))
            {
                $choice = abs(intval($_POST['radio']));
                $khachhang = htmlspecialchars($_POST['ctm']);
                if($choice == 1)
                {
                    $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` 
                    WHERE `fullname` LIKE '%$khachhang%' ORDER BY `user_id` DESC LIMIT $start, $limit";
                }
                else
                {
                    $khachhang = intval($khachhang);
                    $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` 
                    WHERE `user_id` = '$khachhang' LIMIT 1";
                }
                $result = mysqli_query($con,$sql);
                if(mysqli_num_rows($result))
                {
                    ?>
                    <table width="100%" class="collection" cellspacing="0">
                    <th>ID</th>    <th>User</th>     <th>Name</th>      <th>Gender</th>     <th>Email</th>      <th>Panel</th>
                    <?php
                    while($res = mysqli_fetch_assoc($result))
                    {
                        ?>
                            <tr>
                                <td><?php echo $res['user_id'];?></td>
                                <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['username'];?></a></td>
                                <td><?php echo $res['fullname'];?></td>
                                <td style="width:10px;"><?php echo ($res['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
                                <td><?php echo $res['email'];?></td>
                                <td class="panel">
                                    <input type="checkbox" name="u[]" value="<?php echo $res['user_id'];?>">
                                </td>
                            </tr>
                        <?php
                    }
                    ?>
                    </table>
                    <br>
                    <?php
                }
                else
                {
                    echo'<div class="result_no">Không tìm thấy dữ liệu nào phù hợp !</div>';
                }
            }
            ?>
            <br>
            <div class="input_input">
                <label class="radio">Tìm theo tên khách hàng
                    <input type="radio" name="radio" value="1" checked="checked">
                    <span class="checkradio"></span>
                </label>
            </div>
            <div class="input_input">
                <label class="radio">Tìm theo ID khách hàng
                    <input type="radio" name="radio" value="2">
                    <span class="checkradio"></span>
                </label>
            </div>
            <div class="input_input">
                <input type="text" name="ctm" required="required"> <button class="button-right" name="tim" value="tim">Tìm</button>
            </div>
            </form>
        </div>
    </div>
        <?php
        require_once('../incfiles/end.php');
        exit;
    break;
    case 'view':
        switch($for)
        {
            case 'khachhang':
                ?>
            <div class="admin_right">
                <div class="admin_menu">Danh sách khách hàng trên hệ thống</div>
                    <form action="" method="post">
                        <?php
                        if(isset($_POST['del']))
                        {
                            $cbox = isset($_POST['u']) ? count($_POST['u']) : 0;
                            if($cbox > 0)
                            {
                                $ids = $_POST['u'];
                                foreach($ids as $key => $values)
                                {
                                    $sql = "DELETE FROM `users` WHERE `user_id` = '$values'";
                                    mysqli_query($con,$sql);
                                }
                                loadlai("admin/customer.php");
                            }
                        }
                        ?>
                    <table width="100%" class="collection" cellspacing="0">
                    <th>ID</th>    <th>User</th>     <th>Name</th>      <th>Gender</th>     <th>Email</th>      <th>Panel</th>
                    <?php
                    $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` WHERE `right` = '0' ORDER BY `user_id` DESC LIMIT $start, $limit";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($res = mysqli_fetch_assoc($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $res['user_id'];?></td>
                                <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['username'];?></a></td>
                                <td><?php echo $res['fullname'];?></td>
                                <td style="width:10px;"><?php echo ($res['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
                                <td><?php echo $res['email'];?></td>
                                <td class="panel">
                                    <input type="checkbox" name="u[]" value="<?php echo $res['user_id'];?>">
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        echo'<div class="result_no">Chưa có bất kỳ khách hàng nào !</div>';
                    }
                    ?>
                    </table>
                    <br>
                    <button class="button-right" name="del" value="del">Xóa</button>
                    <a href="#" id="check" class="btn-pink">Check all</a>
                    </form>
                 <?php
                $duy = "SELECT * FROM `users` WHERE `right` = '0'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'admin/customer.php?do=view&for=khachhang&list'
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
        </div>
                <?php
                require_once('../incfiles/end.php');
                exit;
            break;
            case 'admin':
                ?>
                <div class="admin_right">
                <div class="admin_menu">Danh sách quản trị viên trên hệ thống</div>
                    <form action="" method="post">
                        <?php
                        if(isset($_POST['del']))
                        {
                            $cbox = isset($_POST['u']) ? count($_POST['u']) : 0;
                            if($cbox > 0)
                            {
                                $ids = $_POST['u'];
                                foreach($ids as $key => $values)
                                {
                                    $sql = "DELETE FROM `users` WHERE `user_id` = '$values'";
                                    mysqli_query($con,$sql);
                                }
                                loadlai("admin/customer.php");
                            }
                        }
                        ?>
                    <table width="100%" class="collection" cellspacing="0">
                    <th>ID</th>    <th>User</th>     <th>Name</th>      <th>Gender</th>     <th>Email</th>      <th>Panel</th>
                    <?php
                    $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` WHERE `right` = '9' ORDER BY `user_id` DESC LIMIT $start, $limit";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($res = mysqli_fetch_assoc($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $res['user_id'];?></td>
                                <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['username'];?></a></td>
                                <td><?php echo $res['fullname'];?></td>
                                <td style="width:10px;"><?php echo ($res['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
                                <td><?php echo $res['email'];?></td>
                                <td class="panel">
                                    <input type="checkbox" name="u[]" value="<?php echo $res['user_id'];?>">
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        echo'<div class="result_no">Chưa có bất kỳ quản trị viên nào !</div>';
                    }
                    ?>
                    </table>
                    <br>
                    <button class="button-right" name="del" value="del">Xóa</button>
                    <a href="#" id="check" class="btn-pink">Check all</a>
                    </form>
                 <?php
                $duy = "SELECT * FROM `users` WHERE `right` = '9'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'admin/customer.php?do=view&for=admin&list'
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
        </div>
                <?php
                require_once('../incfiles/end.php');
                exit;
            break;
            case 'nam':
                ?>
                <div class="admin_right">
                <div class="admin_menu">Danh sách người dùng là nam</div>
                    <form action="" method="post">
                        <?php
                        if(isset($_POST['del']))
                        {
                            $cbox = isset($_POST['u']) ? count($_POST['u']) : 0;
                            if($cbox > 0)
                            {
                                $ids = $_POST['u'];
                                foreach($ids as $key => $values)
                                {
                                    $sql = "DELETE FROM `users` WHERE `user_id` = '$values'";
                                    mysqli_query($con,$sql);
                                }
                                loadlai("admin/customer.php");
                            }
                        }
                        ?>
                    <table width="100%" class="collection" cellspacing="0">
                    <th>ID</th>    <th>User</th>     <th>Name</th>      <th>Gender</th>     <th>Email</th>      <th>Panel</th>
                    <?php
                    $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` WHERE `gender` = '1' ORDER BY `user_id` DESC LIMIT $start, $limit";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($res = mysqli_fetch_assoc($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $res['user_id'];?></td>
                                <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['username'];?></a></td>
                                <td><?php echo $res['fullname'];?></td>
                                <td style="width:10px;"><?php echo ($res['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
                                <td><?php echo $res['email'];?></td>
                                <td class="panel">
                                    <input type="checkbox" name="u[]" value="<?php echo $res['user_id'];?>">
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        echo'<div class="result_no">Chưa có bất kỳ người dùng là nam nào !</div>';
                    }
                    ?>
                    </table>
                    <br>
                    <button class="button-right" name="del" value="del">Xóa</button>
                    <a href="#" id="check" class="btn-pink">Check all</a>
                    </form>
                 <?php
                $duy = "SELECT * FROM `users` WHERE `gender` = '1'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'admin/customer.php?do=view&for=nam&list'
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
        </div>
                <?php
                require_once('../incfiles/end.php');
                exit;
            break;
            case 'nu':
                ?>
                <div class="admin_right">
                <div class="admin_menu">Danh sách người dùng là nữ</div>
                    <form action="" method="post">
                        <?php
                        if(isset($_POST['del']))
                        {
                            $cbox = isset($_POST['u']) ? count($_POST['u']) : 0;
                            if($cbox > 0)
                            {
                                $ids = $_POST['u'];
                                foreach($ids as $key => $values)
                                {
                                    $sql = "DELETE FROM `users` WHERE `user_id` = '$values'";
                                    mysqli_query($con,$sql);
                                }
                                loadlai("admin/customer.php");
                            }
                        }
                        ?>
                    <table width="100%" class="collection" cellspacing="0">
                    <th>ID</th>    <th>User</th>     <th>Name</th>      <th>Gender</th>     <th>Email</th>      <th>Panel</th>
                    <?php
                    $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` WHERE `gender` = '2' ORDER BY `user_id` DESC LIMIT $start, $limit";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result))
                    {
                        while($res = mysqli_fetch_assoc($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $res['user_id'];?></td>
                                <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['username'];?></a></td>
                                <td><?php echo $res['fullname'];?></td>
                                <td style="width:10px;"><?php echo ($res['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
                                <td><?php echo $res['email'];?></td>
                                <td class="panel">
                                    <input type="checkbox" name="u[]" value="<?php echo $res['user_id'];?>">
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        echo'<div class="result_no">Chưa có bất kỳ người dùng là nữ nào !</div>';
                    }
                    ?>
                    </table>
                    <br>
                    <button class="button-right" name="del" value="del">Xóa</button>
                    <a href="#" id="check" class="btn-pink">Check all</a>
                    </form>
                 <?php
                $duy = "SELECT * FROM `users` WHERE `gender` = '2'";
                $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                            $config = [
                                'total' => $demtrang,
                                'querys' => $id,
                                'limit' => $limit,
                                'url' => 'admin/customer.php?do=view&for=nu&list'
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
        </div>
                <?php
                require_once('../incfiles/end.php');
                exit;
            break;
        }
    break;
}
?>
    <div class="admin_right">
        <div class="admin_menu">Danh sách tất cả người dùng</div>
            <form action="" method="post">
                <?php
                if(isset($_POST['del']))
                {
                    $cbox = isset($_POST['u']) ? count($_POST['u']) : 0;
                    if($cbox > 0)
                    {
                        $ids = $_POST['u'];
                        foreach($ids as $key => $values)
                        {
                            $sql = "DELETE FROM `users` WHERE `user_id` = '$values'";
                            mysqli_query($con,$sql);
                        }
                        loadlai("admin/customer.php");
                    }
                }
                ?>
            <table width="100%" class="collection" cellspacing="0">
            <th>ID</th>    <th>User</th>     <th>Name</th>      <th>Gender</th>     <th>Email</th>      <th>Panel</th>
            <?php
            $sql = "SELECT `user_id`,`username`,`fullname`,`gender`,`email` FROM `users` ORDER BY `user_id` DESC LIMIT $start, $limit";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
            {
                while($res = mysqli_fetch_assoc($result))
                {
                    ?>
                    <tr>
                        <td><?php echo $res['user_id'];?></td>
                        <td><a href="<?php echo $homeurl.'/users/profile.php?id='.$res['user_id'];?>"><?php echo $res['username'];?></a></td>
                        <td><?php echo $res['fullname'];?></td>
                        <td style="width:10px;"><?php echo ($res['gender'] == 1) ? 'Nam' : 'Nữ';?></td>
                        <td><?php echo $res['email'];?></td>
                        <td class="panel">
                            <input type="checkbox" name="u[]" value="<?php echo $res['user_id'];?>">
                        </td>
                    </tr>
                    <?php
                }
            }
            else
            {
                echo'<div class="result_no">Chưa có người dùng nào !</div>';
            }
            ?>
            </table>
            <br>
            <button class="button-right" name="del" value="del">Xóa</button>
            <a href="#" id="check" class="btn-pink">Check all</a>
            </form>
<?php
    $duy = "SELECT * FROM `users`";
    $demtrang = mysqli_num_rows(mysqli_query($con,$duy));
                $config = [
                    'total' => $demtrang,
                    'querys' => $id,
                    'limit' => $limit,
                    'url' => 'admin/customer.php?do'
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
</div>
<script>
var checks = document.getElementById("check");
checks.addEventListener('click',function()
{
    var boxes = document.getElementsByName("u[]");
        flag = true;
        for(var i=0;i<boxes.length;i++)
        {
            boxes[i].checked = true;
        }
});
</script>
<?php
require_once('../incfiles/end.php');
?>