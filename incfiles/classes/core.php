<?php
class core
{
    public static $user_id = false;
    public static $get_user = array();
    public static $rights = false;
    function __construct()
    {
        $this->session_start();
        $this->authorize();
    }
    private function authorize()
    {
        global $con;
        $user_id = false;
        $user_ps = false;
        $rights = false;
        if(isset($_SESSION['sid']) && isset($_SESSION['spw']))
        {
            $user_id = $_SESSION['sid'];
            $user_ps = $_SESSION['spw'];
        }
        elseif (isset($_COOKIE['cuid']) && isset($_COOKIE['cups']))
        {
            $user_id = htmlspecialchars(base64_decode($_COOKIE['cuid']));
            $_SESSION['sid'] = $user_id;
            $user_ps = $_COOKIE['cups'] ;
            $_SESSION['spw'] = $user_ps;
        }
        if($user_id && $user_ps)
        {
            $reg = "SELECT * FROM `users` where `user_id` = '$user_id' limit 1";
            $result =  mysqli_query($con,$reg);
            if(mysqli_num_rows($result))
            {
                $user_data = mysqli_fetch_assoc($result);
                $kq = password_verify($user_ps,$user_data['password']);
                if($kq)
                {
                    self::$user_id = $user_data['user_id'];
                    self::$get_user = $user_data;
                    self::$rights = $user_data['right'];
                }
                else
                {
                    $this->user_unset();
                }

            }
            else
            {
                $this->user_unset();
            }
        }
        else
        {
            $this->user_unset();
        }
    }
    private function user_unset()
    {
        self::$user_id = false;
        self::$get_user = false;
        self::$rights = false;
        unset($_SESSION['sid']);
        unset($_SESSION['spw']);
        setcookie('cuid','');
        setcookie('cups','');
    }
    private function session_start()
    {
        session_start();
    }
}
?>