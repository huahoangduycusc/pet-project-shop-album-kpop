<?php
require_once('../incfiles/core.php');
if($id == false)
{
    chuyenhuong();
}
$textl = getRow($id);
require_once('../incfiles/head.php');
$sql = "SELECT * FROM `product` a INNER JOIN `category` b ON a.category_id = b.category_id WHERE a.product_id = '$id' limit 1";
$result = mysqli_query($con,$sql);
if(!mysqli_num_rows($result))
{
    chuyenhuong();
}
else
{
    $res = mysqli_fetch_assoc($result);
}
$product = new product();
$rate = $product->rate($id);
$chucvu = array(
    0 => '<span class="chucvu-member">- Khách hàng</span>',
    9 => '<span class="chucvu-admin">- Quản trị viên</span>'
);
?>
<script>
$(document).ready(function()
{   
    var next = 12;
    $("#load_more").click(function()
    {
         next = next+5;
        $("#comments").load("load.php",{
           NextPost: next,
           idProduct: <?php echo $id;?>
        });
        //alert(next);
    });
});
</script>
<div class="product_tieude">
                <a href="<?php echo $homeurl;?>">Trang chủ</a> > 
                <a href="<?php echo $homeurl;?>/category/index.php?id=<?php echo $res['category_id'];?>"><?php echo $res['category_name']; ?></a> > 
                <a href="#"><?php echo $res['product_name'];?></a>
            </div>
            <?php
            if($right == 9)
            {
                echo'<div style="float:left;">
                <a href="'.$homeurl.'/admin/edit.php?id='.$res['product_id'].'"><img src="'.$homeurl.'/images/icon/edit.png" title="chỉnh sửa" width="20px;"></a>
                <a href="'.$homeurl.'/admin/products.php?do=del&id='.$res['product_id'].'" onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này?\')"><img src="'.$homeurl.'/images/icon/del.png" title="Xóa" width="20px;"></a>
                </div>';
            }
            ?>
            <div class="body_layout">
                <div class="body_left">
                    <div class="product_chitiet">
                        <div class="product_thumbial">
                            <?php echo getThumbial($id);?>
                        </div>
                        <div class="product_list_album">
                            <?php echo getPhoto($id,6);?>
                        </div>
                    </div>
                </div>
                <div class="body_right">
                    <div class="sanpham_ten">
                        <?php echo $res['product_name'];?>
                    </div>
                    <?php
                    if($rate)
                    {
                    ?>
                    <div class="sanpham_binhchon">
                        <?php
                        for($i=1;$i<=$rate['star'];$i++)
                        {
                            echo'<i class="fas fa-star sao"></i> ';
                        }
                        $fl = 5-$rate['star'];
                        for($i=0;$i<$fl;$i++)
                        {
                            echo'<i class="far fa-star sao"></i> ';
                        }
                        echo $rate['luot'].' lượt đánh giá';
                        ?>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if(saleoff($id))
                    {
                        $sale = saleoff($id);
                        echo'<div class="sanpham_gia"><span class="khuyenmai">KHUYẾN MÃI '.$sale['discount'].'%</span> Giá chỉ còn '.number_format(khuyenmai($id)).' VND</div>';
                        echo'<div class="sanpham_gia">
                        <div class="khuyenmai_ct"><b style="color:red;">'.$sale['sale_name'].'</b>
                        <br>Từ ngày <b>'.$sale['fromday'].'</b> đến hết ngày <b>'.$sale['today'].'</b>
                        <br>
                        '.nl2br($sale['sale_content']).'
                        </div></div>';
                        $giatien = khuyenmai($id);
                    }
                    else
                    {
                      echo'<div class="sanpham_gia">'.number_format($res['product_price']).' VND</div>';
                      $giatien = $res['product_price'];
                    }
                    ?>
                    <div class="sanpham_gia">
                        <?php echo ($res['quantity']) > 0 ? 'Mặt hàng này còn '.$res['quantity'].'' : '<span class="hethang">Đã hết hàng</span>';?>
                    </div>
                    <form action="" method="POST" class="form-buy">
                        <?php
                            if(isset($_POST['cart']))
                            {
                                //echo'<script>alert(\'hello\');</script>';
                                $qtt = abs(intval($_POST['qtt']));
                                $error = array();
                                if($qtt < 1)
                                {
                                    chuyenhuong();
                                }
                                if($qtt > $res['quantity'])
                                {
                                    $error['hethang'] = "Xin lỗi hiện tại mặt hàng này đã hết, quý khách vui lòng thử lại sau !";
                                }
                                else
                                {
                                    if(isset($_SESSION['cart'][$id]))
                                    {

                                        if($_SESSION['cart'][$id]['quantity'] >= $res['quantity'])
                                        {
                                            $error['hethang'] = "Xin lỗi hiện tại mặt hàng này đã hết, quý khách vui lòng thử lại sau !";
                                        }
                                        else
                                        {
                                            $_SESSION['cart'][$id]['quantity']+=$qtt;
                                            loadlai("product/index.php?id=$id");
                                    exit;
                                        }
                                    }
                                    else
                                    {
                                        $_SESSION['cart'][$id] = array(
                                            "quantity" => $qtt,
                                            "price" => $giatien
                                        );
                                        loadlai("product/index.php?id=$id");
                                    exit;
                                    }
                                }
                            }
                            ?>
                            <!-- mua ngay -->
                            <?php
                            if(isset($_POST['buynow']))
                            {
                                //echo'<script>alert(\'hello\');</script>';
                                $qtt = abs(intval($_POST['qtt']));
                                $error = array();
                                if($qtt < 1)
                                {
                                    chuyenhuong();
                                }
                                if($qtt > $res['quantity'])
                                {
                                    $error['hethang'] = "Xin lỗi hiện tại mặt hàng này đã hết, quý khách vui lòng thử lại sau !";
                                }
                                else
                                {
                                    loadlai("product/buynow.php?id=$id&soluongsp=$qtt");
                                }
                            }
                            ?>
                        <div class="sanpham_mua">
                            Số lượng <br><br>
                            <input type="button" class="sanpham_cong" value="-" id="minus">
                            <input type="text" value="1" class="soluong" name="qtt" id="qtt" readonly>
                            <input type="button" class="sanpham_tru" value="+" id="plus">
                        </div>
                        <div class="sanpham_dathang">
                            <button name="cart" value="them" class="dathang"><?php echo ($res['quantity'] > 0) ? 'Thêm vào giỏ hàng' : 'Mặt hàng này đã hết'; ?></button>
                            <?php echo (isset($error['hethang'])) ? '<div class="error">'.$error['hethang'].'</div>' : '';?>
                            <button class="mua" name="buynow">Mua ngay</button>
                        </div>
                    </form>
                    <div class="sanpham_more">
                        <div class="more_infor">
                        <button class="tab clickme" onclick="openCity('chitiet')" id="hienthi">Chi tiết</button>
                        <button class="tab" onclick="openCity('about')" id="hienthi1">Về chúng tôi</button>
                        <button class="tab" onclick="openCity('review')" id="hienthi2">Review</button>
                        </div>
                        <div class="more_content">
                            <div id="chitiet" class="viewtab">
                                <h3>Chi tiết sản phẩm</h3>
                                <?php echo nl2br($res['description']);?>
                              </div>
                              
                              <div id="about" class="viewtab" style="display:none">
                                <h3>About us</h3>
                                389 Shop, là cửa hàng, chợ KPOP chính thức. Chúng tôi mang theo hàng hóa của các nhóm nhạc K-pop giật gân: EXO, Super Junior, Girls 'Generation, BLACKPINK, BTS và hơn thế nữa.
                                <br> <br>
                                Chúng tôi tự hào đã hợp tác với nhà lãnh đạo số 1 của Hàn Quốc để cung cấp cho bạn trang phục và phụ kiện K-Pop để truyền bá văn hóa và nghệ sĩ Hàn Quốc trên toàn cầu. 
                               <br><br>
                               <b>Nhiệm vụ của chúng tôi là làm cho người hâm mộ FAN KPOP trên toàn thế giới dễ dàng hơn để mua hàng hóa nghệ sĩ yêu quý đích thực!</b>
                              
                              </div>
                              
                              <div id="review" class="viewtab" style="display:none">
                                <h3>Đánh giá của khách hàng</h3>
                                <div class="review_rate">
                                    <div class="binhchon">
                                    <span class="rate">
                                    <span><?php if($rate) echo $rate['star']; else echo'0.0';?></span> out of 5.0
                                    </span>
                                    <span class="rate_sao">
                                    <?php
                                     for($i=1;$i<=$rate['star'];$i++)
                                     {
                                         echo'<i class="fas fa-star pink"></i>';
                                     }      
                                    ?>
                                    </span>
                                    <span class="rate_luot">
                                    <?php
                                    if($rate)
                                    {
                                        echo $rate['luot'].' lượt đánh giá';
                                    }
                                    ?>
                                    </span>
                                    </div>
                                    <div class="binhchon_start">
                                    <span class="star">5 stars</span>
                                    <span class="star">4 stars</span>
                                    <span class="star">3 stars</span>
                                    <span class="star">2 stars</span>
                                    <span class="star">1 star</span>
                                    </div>
                                    <div class="binhchon_rate">
                                        <span class="process" style="width:<?php echo $rate['pt5']+0;?>%"></span>
                                        <span class="process" style="width:<?php echo $rate['pt4']+0;?>%"></span>
                                        <span class="process" style="width:<?php echo $rate['pt3']+0;?>%"></span>
                                        <span class="process" style="width:<?php echo $rate['pt2']+0;?>%"></span>
                                        <span class="process" style="width:<?php echo $rate['pt1']+0;?>%"></span>
                                    </div>
                                    <div class="binhchon_start">
                                    <span class="star"><?php echo $rate['sao5']+0;?></span>
                                    <span class="star"><?php echo $rate['sao4']+0;?></span>
                                    <span class="star"><?php echo $rate['sao3']+0;?></span>
                                    <span class="star"><?php echo $rate['sao2']+0;?></span>
                                    <span class="star"><?php echo $rate['sao1']+0;?></span>
                                    </div>

                                    <div class="binhchon_add">
                                    <a href="#commemt" id="clickadd" class="pink">Đánh giá</a>
                                    </div>
                                </div>
                                <?php
                                if($user_id)
                                {
                                ?>
                                <form action="#binhchon" method="post">
                                    <?php
                                    if(isset($_POST['gui']))
                                    {
                                        $sao = abs(intval($_POST['sao']));
                                        $td = htmlspecialchars($_POST['td']);
                                        $nd = htmlspecialchars($_POST['nd']);
                                        if($sao < 1)
                                        {
                                            $sao = 1;
                                        }
                                        if($sao > 5)
                                        {
                                            $sao = 5;
                                        }
                                        if(!empty($sao) || !empty($td) || !empty($nd))
                                        {
                                            if($user_id)
                                            {
                                                $sql = "INSERT INTO `productreview`(`review_id`,`title`,`message`,`rate`,`review_date`,`product_id`,`user_id`)
                                                VALUES (NULL,'$td','$nd','$sao',".time().",'$id','$user_id')";
                                                if(mysqli_query($con,$sql))
                                                {
                                                    loadlai("product/index.php?id=$id");
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                <div class="review_comment" id="commemt">
                                    <div class="review_selected">
                                    <select name="sao" required="required">
                                        <option value="">Đánh giá sản phẩm</option>
                                        <option value="1">1 sao - Kém</option>
                                        <option value="2">2 sao - Trung bình</option>
                                        <option value="3">3 sao - Khá</option>
                                        <option value="4">4 sao - Tốt</option>
                                        <option value="5">5 sao - Rất tốt</option>
                                    </select>
                                    </div>
                                    <div class="review_title">
                                        <input type="text" name="td" placeholder="Tiêu đề" required="required">
                                    </div>
                                    <div class="review_title">
                                        <textarea name="nd" rows="5" placeholder="Nội dung" required="required"></textarea>
                                    </div>
                                    <div class="review_title">
                                        <button class="button-right" name="gui" value="gui">Gửi</button>
                                    </div>
                                    
                                </div>
                                </form>
                                <?php
                                }
                                ?>
                                <!-- Phần hiển thị đánh giá của khách hàng -->
                                <?php
                                $sql = "SELECT * FROM `productreview` WHERE `product_id` = '$id' ORDER BY `review_id` DESC LIMIT $start, $limit";
                                $result = mysqli_query($con,$sql);
                                $rows = mysqli_num_rows(mysqli_query($con,"SELECT `review_id` FROM `productreview` WHERE `product_id` = '$id'"));
                                if(mysqli_num_rows($result))
                                {
                                    include('../users/func.php');
                                    ?>
                                    <div id="comments">
                                    <?php
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
                                    echo'</div>';
                                    if($rows > $limit)
                                    {
                                        echo'<button class="btn_center" id="load_more">Xem thêm</button>';
                                    }
                                }
                                else
                                {
                                    echo'<div class="success">Trở thành người đầu tiên bình chọn sản phẩm này!</div>';
                                }
                                ?>
                            </div>
                        </div>
<!-- Phan xoa comment -->
<?php
$uid = isset($_GET['uid']) ? abs(intval($_GET['uid'])) : false;
switch($do)
{
    case 'del':
        $sql = "SELECT `review_id` FROM `productreview` WHERE `review_id` = '$uid' LIMIT 1";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            mysqli_query($con,"DELETE FROM `productreview` WHERE `review_id` = '$uid'");
            loadlai("product/index.php?id=$id");
        }
        else
        {
            chuyenhuong();
        }
        exit;
    break;
}
?>
                    </div>
                </div>
            </div>
<div class="danhmuc">sản phẩm cùng chuyên mục</div>
<?php
$sql = "SELECT `category_id` FROM `product` WHERE `product_id` = '$id' limit 1";
$result = mysqli_query($con,$sql);
$res = mysqli_fetch_assoc($result);
$product->getList(0,5,$res['category_id']);
?>
<script src="<?php echo $homeurl;?>/js/xemanh.js"></script>
<script>
    function openCity(cityName) {
      var i;
      var x = document.getElementsByClassName("viewtab");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      document.getElementById(cityName).style.display = "block";
    }
</script>
<script>
    var plus = document.getElementById("plus");
    var qtt = document.getElementById("qtt");
    var soluong = 0;
    soluong = parseInt(qtt.value);
    plus.addEventListener('click',function()
    {
        soluong = soluong + 1;
        document.getElementById("qtt").value = soluong;
    });
    var minus = document.getElementById("minus");
    minus.addEventListener('click',function(){
        if(soluong > 1)
        {
            soluong = soluong - 1;
            document.getElementById("qtt").value = soluong;
        }
    });
</script>
<script>
    var cmt = document.getElementById("clickadd");
    cmt.addEventListener('click',function()
    {
        var addcmt = document.getElementById("commemt");
        addcmt.classList.toggle('active');
    });
</script>
<script>
    var button1 = document.getElementById("hienthi");
    var button2 = document.getElementById("hienthi1");
    var button3 = document.getElementById("hienthi2");
    button1.addEventListener('click',function()
    {
        this.classList.add("clickme");
        button2.classList.remove("clickme");
        button3.classList.remove("clickme");
    });
    button2.addEventListener('click',function()
    {
        this.classList.add("clickme");
        button1.classList.remove("clickme");
        button3.classList.remove("clickme");
    });
    button3.addEventListener('click',function()
    {
        this.classList.add("clickme");
        button1.classList.remove("clickme");
        button2.classList.remove("clickme");
    });
</script>
<?php
require_once('../incfiles/end.php');
?>