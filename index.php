<?php
$rootpath = "";
require_once('incfiles/core.php');
require_once('incfiles/head.php');
?>
<style>
        .mySlides {display: none}
        /* Slideshow container */
        .slideshow-container {
          max-width: 90%;
          position: relative;
          margin: 0 auto;
        }
        
        /* Next & previous buttons */
        .prev, .next {
          cursor: pointer;
          position: absolute;
          top: 50%;
          width: auto;
          padding: 5px;
          margin-top: -22px;
          color: white;
          font-weight: bold;
          font-size: 3rem;
          transition: 0.6s ease;
          border-radius: 0 3px 3px 0;
          user-select: none;
        }
        
        /* Position the "next button" to the right */
        .next {
          right: 0;
          border-radius: 3px 0 0 3px;
        }
        /* Caption text */
        .text {
          color: #f2f2f2;
          font-size: 2rem;
          padding: 8px 12px;
          position: absolute;
          bottom: 8px;
          width: 100%;
          text-align: center;
        }
        
        /* Number text (1/3 etc) */
        .numbertext {
          color: #f2f2f2;
          font-size: 12px;
          padding: 8px 12px;
          position: absolute;
          top: 0;
        }
        
        /* The dots/bullets/indicators */
        .dot {
          cursor: pointer;
          height: 10px;
          width: 10px;
          margin: 0 2px;
          background-color: rgb(0, 0, 0);
          border-radius: 50%;
          display: inline-block;
          transition: background-color 0.6s ease;
        }
        
        .active, .dot:hover {
          background-color: #717171;
        }
        
        /* Fading animation */
        .fade {
          -webkit-animation-name: fade;
          -webkit-animation-duration: 1.5s;
          animation-name: fade;
          animation-duration: 1.5s;
        }
        
        @-webkit-keyframes fade {
          from {opacity: .4} 
          to {opacity: 1}
        }
        
        @keyframes fade {
          from {opacity: .4} 
          to {opacity: 1}
        }
        
        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
          .prev, .next,.text {font-size: 11px}
        }
    </style>
<div class="slideshow-container">
    <div class="mySlides fade">
        <img src="images/background/3.jpg" style="width:100%">
        <div class="text">BLACKPINK</div>
    </div>
    <div class="mySlides fade">
          <img src="images/background/2.jpg" style="width:100%">
          <div class="text">BTS</div>
    </div>    
    <div class="mySlides fade">
        <img src="images/background/1.jpg" style="width:100%">
        <div class="text">T-ARA</div>
    </div>
    <div class="mySlides fade">
        <img src="images/background/4.jpg" style="width:100%">
        <div class="text">REV VELVET</div>
    </div>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
        <div style="text-align:center">
          <span class="dot" onclick="currentSlide(1)"></span> 
          <span class="dot" onclick="currentSlide(2)"></span> 
          <span class="dot" onclick="currentSlide(3)"></span> 
          <span class="dot" onclick="currentSlide(4)"></span>
        </div>
<div class="forum">
  <a href="<?php echo $homeurl;?>/forum" target="_blank" class="forum_alert"><i class="far fa-heart tim"></i> Tham Gia Diễn Đàn Ngay <i class="far fa-heart tim"></i></a>
</div>
  <?php
  $idol = new idol();
  $idol->getCollection(12);
  $idol->displayItem(10);
  $product = new product();
  $product->getAlbum(8);
  $sql = "select * from `category` where `category_id` != '30' order by `category_id` asc limit 15";
  $result = mysqli_query($con,$sql);
  if(mysqli_num_rows($result))
  {
    while($res = mysqli_fetch_assoc($result))
    {
      echo'<div class="danhmuc"><a href="'.$homeurl.'/category/index.php?id='.$res['category_id'].'">'.$res['category_name'].'</a></div>';
      $product->getList(0,10,$res['category_id']);
    }
  }
  ?>
  <?php
  $i = 1;
  $sql = "SELECT `product`.`idol_id`, `idols`.`idol_name`, `idols`.`idol_photo`, SUM(`orderdetails`.`quantity`) as `soluong` 
  FROM `orderdetails` LEFT JOIN `product` ON `orderdetails`.`product_id` = `product`.`product_id`
  LEFT JOIN `idols` ON `product`.`idol_id` = `idols`.`idol_id`
  GROUP BY `product`.`idol_id`
  ORDER BY SUM(`orderdetails`.`quantity`) DESC LIMIT 6";
  $result = mysqli_query($con,$sql);
  if(mysqli_num_rows($result))
  {
    $top = array(
      1 => '1St',
      2 => '2Nd',
      3 => '3Th',
      4 => '4Th',
      5 => '5Th',
      6 => '6Th'
    );
    ?>
<section class="bangxephang">
  <div class="danhmuc">BẢNG XẾP HẠNG</div>
  <div class="bxh">
    <?php
    while($res = mysqli_fetch_assoc($result))
    {
      $soluong = $res['soluong'];
      if($i==1)
      {
      ?>
      <div class="bxh_item">
          <div class="bxh_image">
              <img src="<?php echo $homeurl;?>/<?php echo $res['idol_photo'];?>" class="top" alt="">
          </div>
          <div class="bxh_infor">
              <span class="bxh_infor_top"><?php echo $top[$i];?></span>
              <span class="bxh_infor_name"><?php echo $res['idol_name'];?></span>
              <span class="bxh_diem"><?php echo $soluong;?><sup>đ</sup></span>
           </div>
      </div>
      <?php
      }
      else
      {
        ?>
        <div class="bxh_item">
          <div class="bxh_image">
              <img src="<?php echo $homeurl;?>/<?php echo $res['idol_photo'];?>" alt="">
          </div>
          <div class="bxh_infor">
              <span class="bxh_infor_top_1"><?php echo $top[$i];?></span>
              <span class="bxh_infor_name_1"><?php echo $res['idol_name'];?></span>
              <span class="bxh_diem1"><?php echo $soluong;?><sup>đ</sup></span>
           </div>
      </div>
        <?php
      }

      $i++;
    }
    ?>
  </div>
</section>
  <?php
  }

  ?>
<script>
        var slideIndex = 1;
        showSlides(slideIndex);
        function plusSlides(n) {
          showSlides(slideIndex += n);
        }
        function currentSlide(n) {
          showSlides(slideIndex = n);
        }
        function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("dot");
          if (n > slides.length) {slideIndex = 1}    
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
              slides[i].style.display = "none";  
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";  
          dots[slideIndex-1].className += " active";
        }
        </script>
<?php
require_once('incfiles/end.php');
?>