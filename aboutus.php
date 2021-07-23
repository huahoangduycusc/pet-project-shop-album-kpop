<?php
$rootpath = "";
require_once('incfiles/core.php');
$textl = "Về chúng tôi - SHOP389";
require_once('incfiles/head.php');
?>
<div class="container-card">
    <div class="about">
        <h2>Về chúng tôi</h2>
    </div>
    <div class="about-content">
    SHOP389 Chuyên cung cấp những mặt hàng chất lượng đến các bạn fan KPOP. 
    Ngoài việc cung cấp các mặt hàng SHOP389 tự hào vì còn là 1 sân chơi có ích cho các bạn fan KPOP, 
    hãy tham gia diễn đàn của chúng tôi và trải nghiệm.
    </div>
    <div class="about-layout">
        <div class="img-group">
            <img src="<?php echo $homeurl;?>/images/background/3.jpg" alt="">
            <img src="<?php echo $homeurl;?>/images/background/1.jpg" alt="">
            <img src="<?php echo $homeurl;?>/images/background/2.jpg" alt="">
            <img src="<?php echo $homeurl;?>/images/background/4.jpg" alt="">
        </div>
        <div class="about_mota">
            <span>Shop389</span>
            Những mặt hàng hot nhất của dàn sao KPOP, cửa hàng KPOP trực tuyến HOT nhất Việt nam.
            <br>
            Tham gia ngay diễn đàn của chúng tôi để có cơ hội nhân Mã quà tặng khi đặt hàng trên hệ thống.
        </div>
    </div>
<div class="contact-infor">
        <div class="card">
            <i class="card-icon far fa-envelope"></i>
            <p>Email@shop389.com</p>
        </div>

        <div class="card">
            <i class="card-icon fas fa-phone"></i>
            <p>+093339393939</p>
        </div>

        <div class="card">
            <i class="card-icon fas fa-map-marker-alt"></i>
            <p>Hậu giang, Vị Thanh, Việt Nam</p>
        </div>
</div>
</div>
<?php
require_once('incfiles/end.php');
?>