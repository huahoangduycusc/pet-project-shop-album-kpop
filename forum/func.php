<?php
require_once('../incfiles/core.php');
// dem like cua moi bai viet
function like($id)
{
    global $con;
    $out = "";
    $sql = "SELECT `forum_topic`.`topic_id`, COUNT(`topic_like`.`like_id`) as 'like' FROM `forum_topic` 
    INNER JOIN `topic_comment` ON `forum_topic`.`topic_id` = `topic_comment`.`topic_id` 
    INNER JOIN `topic_like` ON `topic_comment`.`comment_id` = `topic_like`.`comment_id`
    WHERE `topic_comment`.`type` = '1' AND `forum_topic`.`topic_id` = '$id'
    GROUP BY `forum_topic`.`topic_id`";
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        $likes = "<span style='color:rgb(255, 52, 69);margin-right:1px;'>".$res['like']."</span>";
        $out = '[<i class="fas fa-heart red"></i>'.$likes.']';
    }
    return $out;
}
// dem so like cua bai viet neu co
function reply($id)
{
    global $con;
    $out = "";
    $sql = "SELECT `topic_comment`.`topic_id`, COUNT(`topic_comment`.`comment_id`) as 'reply' FROM `topic_comment` 
    INNER JOIN `forum_topic` ON `forum_topic`.`topic_id` = `topic_comment`.`topic_id`
    WHERE `topic_comment`.`type` = '0' AND `forum_topic`.`topic_id` = '$id'
    GROUP BY `topic_comment`.`topic_id`";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        $reply = $res['reply'];
        $out.= "<i> Trả lời : $reply</i>";
    }
    else
    {
        $out.= "";
    }
    return $out;
}
// hien icon hot new
function chuy($id)
{
    global $con;
    global $homeurl;
    $out = "";
    $sql = "SELECT `topic_chuy`, `topic_chuy_1` FROM `forum_topic` 
    WHERE `topic_id` = '$id' LIMIT 1";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        $res = mysqli_fetch_assoc($result);
        if($res['topic_chuy_1'] > time())
        {
            if($res['topic_chuy'] == 1)
            {
                $out = "<img src='$homeurl/forum/images/hot.gif'>";
            }
            else if($res['topic_chuy'] == 2)
            {
                $out = "<img src='$homeurl/forum/images/new.gif'>";
            }
        }
    }
    return $out;
}
// hien thi anh cua bai viet
function hinhanh($ids)
{
    global $con;
    global $homeurl;
    global $right;
    global $id;
    $out = "";
    $sql = "SELECT `photo_name`,`photo_id` FROM `comment_photo` WHERE `comment_id` = '$ids' ORDER BY `photo_id` ASC LIMIT 10";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result))
    {
        while($res = mysqli_fetch_assoc($result))
        {
            $out .= "<img src=\"$homeurl/".$res['photo_name']."\">";
            if($right >=9)
            {
                $out.= '<p><a href="'.$homeurl.'/forum/del.php?do=photo&id='.$res['photo_id'].'&topic='.$id.'">(Xóa)</a></p>';
            }
        }
    }
    $kq = "<center>$out</center>";
    return $kq;
}
?>