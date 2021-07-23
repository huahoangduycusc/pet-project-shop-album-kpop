<?php
class idol extends product
{
    function getCollection($limit)
    {
        global $con;
        global $homeurl;
        $sql = "select `idol_id`, `idol_name` from `idols` order by `idol_id` asc limit $limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            echo'<div class="danhmuc">Artist Collection</div>
            <div class="collection_artist">';
            while($res = mysqli_fetch_assoc($result))
            {
                echo'<a href="'.$homeurl.'/collection/index.php?id='.$res['idol_id'].'">'.$res['idol_name'].'</a>';
            }
            echo'</div>';
        }
        else
        {
            echo'<div class="result_no">Chưa có sản phẩm nào!</div>';
        }
    }
    function displayItem($limit)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
        from `product` order by `product_id` desc limit $limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            echo'<section class="product">';
            while($res = mysqli_fetch_assoc($result))
            {
                $getImg = "select `photo_name` from `photo` where `product_id` = '".$res['product_id']."' limit 1";
                $img = mysqli_query($con,$getImg);
                if(mysqli_num_rows($img))
                {
                    $arr = mysqli_fetch_assoc($img);
                    $image = $arr['photo_name'];
                }
                else
                {
                    $image = '/photo/no-photo.png';
                }
                echo'<div class="product_item">';
                echo'<a href="'.$homeurl.'/product/'.slugify($res['product_name']).'/'.$res['product_id'].'">';
                echo'<div class="product_image">
                      <img src="'.$homeurl.'/'.$image.'" alt="">
                      <span class="add-tocart" data-id="'.$res['product_id'].'">Thêm vào giỏ</span>
                  </div>';
                  echo'<div class="product_infor">
                      <div class="product_name">
                          '.$res['product_name'].'
                      </div>';
                      if($this->rate($res['product_id']))
                      {
                          $rates = $this->rate($res['product_id']);
                          echo'<div class="product_rate">';
                          for($i=1;$i<=$rates['star'];$i++)
                          {
                              echo'<i class="fas fa-star sao"></i> ';
                          }
                          $fl = 5-$rates['star'];
                            for($i=0;$i<$fl;$i++)
                            {
                                echo'<i class="far fa-star sao"></i> ';
                            }
                          echo'<span>('.$rates['luot'].')</span>
                          </div>';
                      }
                      if(saleoff($res['product_id']))
                      {
                      
                      echo'<div class="product_price">'.number_format(khuyenmai($res['product_id'])).' VND</div>';
                      }
                      else
                      {
                        echo'<div class="product_price">'.number_format($res['product_price']).' VND</div>';
                      }
                      if($res['quantity'] == 0)
                      {
                          echo'<span class="sold_out">SOLD OUT</span>';
                      }
                      if(saleoff($res['product_id']))
                      {
                          echo'<div class="giamgia"><span class="discount">Sale Off</span> <span class="line">'.number_format($res['product_price']).' VND</span></div>';
                      }
                      if($right == 9)
                      {
                        echo'<div class="quantri">
                        <a href="'.$homeurl.'/admin/edit.php?id='.$res['product_id'].'"><img src="'.$homeurl.'/images/icon/edit.png" title="chỉnh sửa"></a>
                        <a href="'.$homeurl.'/admin/products.php?do=del&id='.$res['product_id'].'" onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này?\')"><img src="'.$homeurl.'/images/icon/del.png" title="Xóa"></a>
                        </div>';
                      }
                      echo'
                  </div>
              </a>';
              echo'</div>';
            }
            echo'</section>';
        }

    }
    function bangxephang($limit)
    {

    }
    function collection($id,$start,$limit)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
        from `product` where `idol_id` = '$id'
        order by `product_id` desc limit $start,$limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            echo'<div class="danhmuc">ARTIST COLLECTION</div>';
            echo'<section class="product">';
            while($res = mysqli_fetch_assoc($result))
            {
                $getImg = "select `photo_name` from `photo` where `product_id` = '".$res['product_id']."' limit 1";
                $img = mysqli_query($con,$getImg);
                if(mysqli_num_rows($img))
                {
                    $arr = mysqli_fetch_assoc($img);
                    $image = $arr['photo_name'];
                }
                else
                {
                    $image = '/photo/no-photo.png';
                }
                echo'<div class="product_item">';
                echo'<a href="'.$homeurl.'/product/?id='.$res['product_id'].'">';
                echo'<div class="product_image">
                      <img src="'.$homeurl.'/'.$image.'" alt="">
                      <span class="add-tocart" data-id="'.$res['product_id'].'">Thêm vào giỏ</span>
                  </div>';
                  echo' <div class="product_infor">
                    <div class="product_name">
                          '.$res['product_name'].'
                      </div>';
                      if($this->rate($res['product_id']))
                      {
                          $rates = $this->rate($res['product_id']);
                          echo'<div class="product_rate">';
                          for($i=1;$i<=$rates['star'];$i++)
                          {
                              echo'<i class="fas fa-star sao"></i> ';
                          }
                          $fl = 5-$rates['star'];
                            for($i=0;$i<$fl;$i++)
                            {
                                echo'<i class="far fa-star sao"></i> ';
                            }
                          echo'<span>('.$rates['luot'].')</span>
                          </div>';
                      }
                      if(saleoff($res['product_id']))
                      {
                      
                      echo'<div class="product_price">'.number_format(khuyenmai($res['product_id'])).' VND</div>';
                      }
                      else
                      {
                        echo'<div class="product_price">'.number_format($res['product_price']).' VND</div>';
                      }
                      if($res['quantity'] == 0)
                      {
                          echo'<span class="sold_out">SOLD OUT</span>';
                      }
                      if(saleoff($res['product_id']))
                      {
                          echo'<div class="giamgia"><span class="discount">Sale Off</span> <span class="line">'.number_format($res['product_price']).' VND</span></div>';
                      }
                      if($right == 9)
                      {
                        echo'<div class="quantri">
                        <a href="'.$homeurl.'/admin/edit.php?id='.$res['product_id'].'"><img src="'.$homeurl.'/images/icon/edit.png" title="chỉnh sửa"></a>
                        <a href="'.$homeurl.'/admin/products.php?do=del&id='.$res['product_id'].'" onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này?\')"><img src="'.$homeurl.'/images/icon/del.png" title="Xóa"></a>
                        </div>';
                      }
                      echo'
                  </div>
              </a>';
              echo'</div>';
            }
            echo'</section>';
        }
        else
        {
            echo'<div class="result_no">Chưa có sản phẩm nào!</div>';
        }
    }
}
?>