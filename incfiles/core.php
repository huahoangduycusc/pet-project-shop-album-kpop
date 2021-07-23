<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
include('db.php');
$rootpath = isset($rootpath) ? $rootpath : '../';
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
$do = isset($_GET['do']) ? htmlspecialchars($_GET['do']) : false;
$for = isset($_GET['for']) ? htmlspecialchars($_GET['for']) : false;
$quote = isset($_GET['quote']) ? abs(intval($_GET['quote'])) : false;
$page = isset($_GET['page']) ? abs(intval($_GET['page'])) : 1;
$textl = 'SHOP KPOP - Cửa hàng mua sắm trực tuyến - 389 HHD';
$homeurl = "/shop389";
$url = "";
spl_autoload_register('autoload');
function autoload($name) {

    global $rootpath;
    
    $file = $rootpath . 'incfiles/classes/' . $name . '.php';
    
    if (file_exists($file))
    
    require_once($file);
    
}
$core = new core() or die('Error: Core System');
unset($core);
$user_id = core::$user_id;
$user = core::$get_user;
$right = core::$rights;
$limit = 12;
$start = abs(intval($limit*$page)-$limit);
include('session_cart.php');
class Pagination
{
    /**
     * Biến config chứa tất cả các cấu hình
     *
     * @var array
     */
    private $config = [
        'total' => 0, // tổng số mẩu tin
        'limit' => 10, // số mẩu tin trên một trang
        'full' => true, // true nếu hiện full số page, flase nếu không muốn hiện false
        'querystring' => 'page', // GET id nhận page
        'querys' => 1,
        'url' => 'url'
    ];

    /**
     * khởi tạo
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        // kiểm tra xem trong config có limit, total đủ điều kiện không
        if (isset($config['limit']) && $config['limit'] < 0 || isset($config['total']) && $config['total'] < 0) {
            // nếu không thì dừng chương trình và hiển thị thông báo.
            die('limit và total không được nhỏ hơn 0');
        }
        // Kiểm tra xem config có querystring không
        if (!isset($config['querystring'])) {
            //nếu không để mặc định là page
            $config['querystring'] = 'page';
        }
        if (!isset($config['querys'])) {
            //nếu không để mặc định là page
            $config['querys'] = 'list';
        }
        $this->config = $config;
    }

    /**
     * Lấy ra tổng số trang
     *
     * @return int
     */
    private function gettotalPage()
    {
        return ceil($this->config['total'] / $this->config['limit']);
    }

    /**
     * Lấy ra trang hiện tại
     *
     * @return int
     */
    private function getCurrentPage()
    {
        // kiểm tra tồn tại GET querystring và có >=1 không
        if (isset($_GET[$this->config['querystring']]) && (int)$_GET[$this->config['querystring']] >= 1) {
            // Nếu có kiểm tra tiếp xem nó có lớn hơn tổn số trang không.
            if ((int)$_GET[$this->config['querystring']] > $this->gettotalPage()) {
                // nếu lớn hơn thì trả về tổng số page
                return (int)$this->gettotalPage();
            } else {
                // còn không thì trả về số trang
                return (int)$_GET[$this->config['querystring']];
            }

        } else {
            // nếu không có querystring thì nhận mặc định là 1
            return 1;
        }
    }

    /**
     * lấy ra trang phía trước
     *
     * @return string
     */
    private function getPrePage()
    {
        global $homeurl;
        // nếu trang hiện tại bằng 1 thì trả về null
        if ($this->getCurrentPage() === 1) {
            return;
        } else {
            // còn không thì trả về html code
            return '<li><a href="'.$homeurl.'/'.$this->config['url'].'='.$this->config['querys'].'&' . $this->config['querystring'] . '=1">«</a></li>';
        }
    }

    /**
     * Lấy ra trang phía sau
     *
     * @return string
     */
    private function getNextPage()
    {
        global $homeurl;
        // nếu trang hiện tại lơn hơn = totalpage thì trả về rỗng
        if ($this->getCurrentPage() >= $this->gettotalPage()) {
            return;
        } else {
            // còn không thì trả về HTML code
            return '<li><a href="'.$homeurl.'/'.$this->config['url'].'='.$this->config['querys'].'&' . $this->config['querystring'] . '=' . ($this->gettotalPage()) . '">»</a></li>';
        }
    }

    /**
     * Hiển thị html code của page
     *
     * @return string
     */
    public function getPagination()
    {
        global $homeurl;
        // tạo biến data rỗng
        if($this->gettotalPage() > 1)
        {
        $data = '';

            for ($i = ($this->getCurrentPage() - 2) > 0 ? ($this->getCurrentPage() - 1) : 1; $i <= (($this->getCurrentPage() + 2) > $this->gettotalPage() ? $this->gettotalPage() : ($this->getCurrentPage() + 2)); $i++) {
                if ($i === $this->getCurrentPage()) {
                    $data .= '<li class="active"><a href="">' . $i . '</a></li>';
                } else {
                    $data .= '<li><a href="'.$homeurl.'/'.$this->config['url'].'='.$this->config['querys'].'&' . $this->config['querystring'] . '=' . $i . '">' . $i . '</a></li>';
                }
            }
        return '' . $this->getPrePage() . $data . $this->getNextPage() . '';
        }
    }
}
// tao 1 thong bao alert javascript
function notificate($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
// tao gift code cho mục đích giảm giá hoặc phiếu quà tặng
function giftcode($len=5, $abc="*&aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789@?!+-#") {
    $letters = str_split($abc);
    $str = "";
    for ($i=0; $i<=$len; $i++) {
        $str .= $letters[rand(0, count($letters)-1)];
    };
    $seri = time(); // tao 1 day so kieu int thoi gian de tranh trung lap ma gift
    $str .= $seri; // noi chuoi
    return $str;
};
// chuyen huong khi truy cap vao 1 trang khong ton tai
function chuyenhuong()
{
    global $homeurl;
    echo "<html><script>document.location.href='$homeurl';</script></html>";
    exit;
}
// lay ten san pham de gan vao thanh địa chỉ
function getRow($id)
    {
        global $con;
        $sql = "select `product_name` from `product` where `product_id` = '$id' limit 1";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result))
        {
            $name = mysqli_fetch_assoc($result);
            $tit = $name['product_name'];
        }
        else
        {
            $tit = "Not found";
        }
        return $tit;
    }
// get photo of product id
function getPhoto($id,$limit)
{
    global $con;
    global $homeurl;
    $sql = "select `photo_name` from `photo` where `product_id` = '$id' order by `photo_id` asc limit $limit";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $i = 0;
        while($res = mysqli_fetch_assoc($result))
        {
            if($i == 0)
            {
                echo '<img src="'.$homeurl.'/'.$res['photo_name'].'" class="preview">';
            }
            else
            {
                echo '<img src="'.$homeurl.'/'.$res['photo_name'].'">';
            }
            $i++;
        }
    }
}
// lay anh dai dien cho san pham
function getThumbial($id)
{
    global $con;
    global $homeurl;
    $sql = "select `photo_name` from `photo` where `product_id` = '$id' order by `photo_id` asc limit 1";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        echo '<img src="'.$homeurl.'/'.$res['photo_name'].'" class="hightlight">';
    }
}
// chuyen huong trang bang js
function loadlai($url)
{
    global $homeurl;
    echo "<html><script> document.location.href='$homeurl/$url';</script></html>";
    exit;
}
// lay anh san pham
function getAnh($id)
{
    global $con;
    $sql = "select `photo_name` from `photo` where `product_id` = '$id' order by `photo_id` asc limit 1";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        return $res['photo_name'];
    }
}
// lay url hien tai cua nguoi dung
function getCurURL()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL = "https://";
    } else {
      $pageURL = 'http://';
    }
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
// chuyen huong
function location($url)
{
    echo "<html><script>document.location.href='$url';</script></html>";
    exit;
}
// time
$timeSql = date("Y-m-d h:i:s");
include('functions.php');
// lay ten nguoi dung thong qua id
function nick($id)
{
    global $con;
    $sql = "SELECT `username`,`fullname`,`user_id`,`photo` FROM `users` where `user_id` = '$id' limit 1";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        return $res;
    }
    else
    {
        return false;
    }
}
?>