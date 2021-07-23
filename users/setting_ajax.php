<?php
sleep(1);
require_once('../incfiles/core.php');
$result = array();
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : false;
        $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : false;
        $dc = isset($_POST['diachi']) ? htmlspecialchars($_POST['diachi']) : false;
        $sdt = isset($_POST['sdt']) ? htmlspecialchars($_POST['sdt']) : false;
        $mail = isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : false;
        $dob = isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : false;
        $mob = isset($_POST['mob']) ? htmlspecialchars($_POST['mob']) : false;
        $yob = isset($_POST['yob']) ? htmlspecialchars($_POST['yob']) : false;
        $id = isset($_POST['usertoken']) ? intval($_POST['usertoken']) : 0;
        $chucvu = isset($_POST['chucvu']) ? intval($_POST['chucvu']) : 0;
        $sql = "UPDATE `users` SET `fullname` = '$name', `gender` = '$gender', `address` = '$dc', `phone` = '$sdt',
        `email` = '$mail', `dob` = '$dob', `mob` = '$mob', `yob` = '$yob', `right` = '$chucvu' WHERE `user_id` = '$id' limit 1";
        if(mysqli_query($con,$sql))
        {
            $result['title'] = "Thành công";
            $result['msg'] = "Cập nhật dữ liệu thành công";
            if($_FILES['avatar']['name'] != "")
            {
                $filename = date("ymdHis");
                $path = $_FILES['avatar']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION); // lấy đuôi ảnh
                $validextensions = array("jpeg", "jpg", "png"); // mảng chứa đuôi ảnh hợp lệ
                if (in_array($ext, $validextensions)) // tìm đuôi phù hợp
                {
                    move_uploaded_file($_FILES['avatar']['tmp_name'],'../photo/users/'.$filename.'.'.$ext);
                    $sql = "UPDATE `users` SET `photo` = 'photo/users/$filename.$ext' WHERE `user_id` = '$id' LIMIT 1";
                    mysqli_query($con,$sql);
                    $result['title'] = "Tải ảnh và dữ liệu";
                    $result['msg'] = "Cập nhật dữ liệu và ảnh profile thành công";
                }
                else
                {
                    $result['title'] = "Lỗi định dạng";
                    $result['msg'] = "Định dạng ảnh mà bạn gửi lên không hợp lệ !";
                }
            }
        }
die(json_encode($result));
?>