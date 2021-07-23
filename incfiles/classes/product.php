<?php
class product
{
    // get list product
     function getList($start = 0, $limit, $id)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
        from `product` where `category_id` = '$id'
        order by `product_id` desc limit $start, $limit";
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
        else
        {
            echo'<div class="result_no">Chuyên mục không có bất kỳ sản phẩm nào !</div>';
        }

    }
    // category
    function getCategory($limit)
    {
        global $con;
        global $homeurl;
        $sql = "select * from `category` order by `category_id` asc limit $limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            while($res = mysqli_fetch_assoc($result))
            {
                echo'<div class="danhmuc">'.$res['category_name'].'</div>';
            }
        }
    }
    // get list album 4 layout
    function getAlbum($limit)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
        from `product` where `category_id` = '30'
        order by `product_id` desc limit $limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            echo'<div class="danhmuc"><a href="'.$homeurl.'/category/index.php?id=30">ALBUMS MỚI CẬP NHẬT</a></div>';
            echo'<section class="album">';
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
                echo'<div class="album_item">';
                echo'<a href="'.$homeurl.'/product/'.slugify($res['product_name']).'/'.$res['product_id'].'">';
                echo'<div class="album_image">
                      <img src="'.$homeurl.'/'.$image.'" alt="">
                      <span class="add-tocart" data-id="'.$res['product_id'].'">Thêm vào giỏ</span>
                  </div>';
                  echo' <div class="album_infor">
                    <div class="album_name">
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
                          echo'<span class="sold_out1">Sold out</span>';
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
                  </div>';
              echo'</a>';
              echo'</div>';
            }
            echo'</section>';
        }

    }
    // product bình chọn của khách hàng
    function rate($id)
    {
        global $con;
        global $homeurl;
        $sao = array();
        $sao1 = 0;
        $sao2 = 0;
        $sao3 = 0;
        $sao4 = 0;
        $sao5 = 0;
        $check = "SELECT `product_id` FROM `productreview` where `product_id` = '$id'";
        $demsao = 0.0;
        $chia = 0.0;
        $sao['star'] = 0;
        $rs = mysqli_query($con,$check);
        if(mysqli_num_rows($rs))
        {
        $sql = "SELECT `product_id`, `rate`, COUNT(`rate`) as `dem`, SUM(`rate`) as `tong` FROM `productreview`
        WHERE `product_id` = '$id'
        GROUP BY `product_id`, `rate`";
        $result = mysqli_query($con,$sql);
        while($res = mysqli_fetch_assoc($result))
            {
                $demsao += $res['tong'];
                $chia += $res['dem'];
                if($res['rate'] == 1)
                {
                    $sao1 = $res['dem'];
                }
                // sao 2
                if($res['rate'] == 2)
                {
                    $sao2 = $res['dem'];
                }
                // sao 3
                if($res['rate'] == 3)
                {
                    $sao3 = $res['dem'];
                }
                // sao 4
                if($res['rate'] == 4)
                {
                    $sao4 = $res['dem'];
                }
                // sao 5
                if($res['rate'] == 5)
                {
                    $sao5 = $res['dem'];
                }
            }
        $sao['luot'] = $chia;
        $sao['star'] = round($demsao/$chia,1);
        $sao['sao1'] = $sao1;
        $sao['sao2'] = $sao2;
        $sao['sao3'] = $sao3;
        $sao['sao4'] = $sao4;
        $sao['sao5'] = $sao5;
        $sao['pt1'] = $sao1/$chia*100;
        $sao['pt2'] = $sao2/$chia*100;
        $sao['pt3'] = $sao3/$chia*100;
        $sao['pt4'] = $sao4/$chia*100;
        $sao['pt5'] = $sao5/$chia*100;
        return $sao;
        // end loop
        }
        else
        {
            return false;
        }
    }
    // end function
    // get all products
    function getAll($start, $limit)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
        from `product` order by `product_id` desc limit $start, $limit";
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
                          <a href="edit.php?id='.$res['product_id'].'"><img src="'.$homeurl.'/images/icon/edit.png" title="chỉnh sửa"></a>
                          <a href="products.php?do=del&id='.$res['product_id'].'" onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này?\')"><img src="'.$homeurl.'/images/icon/del.png" title="Xóa"></a>
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
            echo'<div class="result_no">Không tìm thấy dữ liệu theo yêu cầu !</div>';
        }

    } // end function get all products
    // get list product
    function soldOut($start,$limit)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
        from `product` where `quantity` = '0'
        order by `product_id` desc limit $start, $limit";
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
                echo'<a href="'.$homeurl.'/product/?id='.$res['product_id'].'">';
                echo'<div class="product_image">
                      <img src="'.$homeurl.'/'.$image.'" alt="">
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
        else
        {
            echo'<div class="result_no">Chuyên có sản phẩm nào cháy hàng !</div>';
        }

    } // end function sould out
    // san pham ban chay nhat
    function mostProduct($limit)
    {
        global $con;
        global $homeurl;
        global $right;
        $sql = "SELECT `product_id`, sum(`quantity`) as `soluong` FROM `orderdetails`
        GROUP BY `product_id` ORDER BY `quantity` DESC LIMIT $limit";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            echo'<section class="product">';
            while($arr = mysqli_fetch_assoc($result))
            {
                $soluong = $arr['soluong'];
                $ss = "select `product_id`,`product_name`,`product_price`,`description`,`quantity`,`sale_id`,`category_id`,`idol_id`
                from `product` where `product_id` = '".$arr['product_id']."'";
                $res = mysqli_fetch_assoc(mysqli_query($con,$ss));
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
                          echo'
                          <div style="color:red;">Đã bán '.$soluong.' sản phẩm</div>
                          <div class="quantri">
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
            echo'<div class="result_no">Chuyên có sản phẩm nào cháy hàng !</div>';
        }

    } // end function sould out
    // function lọc sản phẩm
    function LocSanPham($sql)
    {
        global $con;
        global $homeurl;
        global $right;
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
                echo'<a href="'.$homeurl.'/product/?id='.$res['product_id'].'">';
                echo'<div class="product_image">
                      <img src="'.$homeurl.'/'.$image.'" alt="">
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
        else
        {
            echo'<div class="result_no">Không tìm thấy dữ liệu nào phù hợp !</div>';
        }

    }

} // end class
?>