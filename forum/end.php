<?php
// set online khi nguoi dung dang nhap
if($user_id)
{
    mysqli_query($con,"UPDATE `users` SET `status` = '".time()."' WHERE `user_id` = '$user_id' LIMIT 1");
}
?>
</div>
    <!-- container div -->
<div class="footer">
    <div class="text-center">
        Diễn đàn giải trí KPOP, nơi thảo luận chia sẻ âm nhạc của các bạn trẻ có chung niềm đam mê với âm nhạc KPOP.
        <br>
        Hãy tham gia và kết bạn với mọi người ngay hôm nay
        <br>
        &copy; 2020 Bản quyền thuộc về SHOP389
    </div>
</div>
</body>
</html>