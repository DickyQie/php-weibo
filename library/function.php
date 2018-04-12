<?php

/**
 * 调试
 * @param $data
 */
function debug($data){
    if($data){
        echo "<pre>";
        print_r($data);
    }else{
        echo "没有数据";
    }

}

function get_str($id = 0, $level = 0) {
    global $str;
    $sql = "select* FROM say where pid= $id";
    $result = mysql_query($sql); //查询pid的子类的分类  
    if ($result && mysql_affected_rows()) {//如果有子类  
        $level++;
        while ($row = mysql_fetch_array($result)) { //循环记录集  
            $str .= "<dd id='dd_" . $row['id'] . "' style='padding-left:" . ($level * 42) . "px'>
                    <div class='userPic30'>
                    <img src='http://www.sucaihuo.com/other/avatar/dir/" . $row['uid'] . ".jpg'>
                    </div>
                    <div class='userTalkFont2'>
                    <p>
                    <span class='org'>" . $row['uname'] . "</span>
                    " . ubbReplace($row['content']) . "
                    </p>
                    <h4>
                    " . tranTime($row['addtime']) . "
                    <a class='org' onclick=reply('" . $row['id'] . "')>回复</a>
                    </h4>
                    </div>
                    </dd>";
            get_str($row['id'], $level); //调用get_str()，将记录集中的id参数传入函数中，继续查询下级  
        }
    }
    return $str;
}

/***
 * 正则表达式将表情代码转换为表情
 * @param $str：要转换的字符串
 * @return mixed：转换后显示图片的字符串
 */
function ubbReplace($str) {
    $str = str_replace("<", '<；', $str);
    $str = str_replace(">", '>；', $str);
    $str = str_replace("\n", '>；br/>；', $str);
    $str = preg_replace("[\[em_([0-9]*)\]]", "<img src=\"public/images/face/$1.gif\" />", $str);
    return $str;
}

/**
 * 将时间转换成距离当前的时间，如：2分钟前
 * @param $time
 * @return bool|string
 */
function tranTime($time) {
    $rtime = date("m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ' . $rtime;
        else
            $str = '前天 ' . $rtime;
    }
    else {
        $str = $rtime;
    }
    return $str;
}

/**
 * 检测表单所有字段是否为空
 * @param $form_vars：字段数组
 * @return bool ：返回true 或 false
 */
function filled_out($form_vars){
    foreach ($form_vars as $key => $value){
        if((!isset($key)) || ($value == '') ){
            return false;
        }
    }
    return true;
}

/**
 * 检测是否登陆，如果没有登陆，调回首页
 */
function is_login(){
    session_start(); //开启session
    if(isset($_SESSION['user']['id']) && isset($_SESSION['user']['username'])){
        return true;
    }else{
        echo "<script>window.location.href = 'login.php'</script>";
    }
}

/**
 * 判断是否收藏
 * @param $post_id:微博id
 * @return int : 返回值
 */
function is_collect($post_id){
    return true;
//    $user_id = $_SESSION['user']['id'];
//    $sql     = "select * from mr_collect where status = 1 and user_id = ".$user_id." and post_id = ".$post_id ;
//    $db      =  new Db();
//    $collect = $db->single($sql,MYSQL_ASSOC);
//    if($collect){
//        return true;
//    }else{
//        return false;
//    }
}





/**
 * 获取头像
 * @param $head_image
 * @return string
 */
function get_cover_path($avatar){
    if($avatar){
        $path = 'public/images/upload/head_image/'.$avatar;
    }else{
        $path = 'public/images/avatar.jpg';
    }
    return $path;
}


function get_user_avatar($user_id){
    $db     = new Db();
    $sql    = 'select avatar from mr_user where id = '. $user_id;
    $avatar = $db->single($sql);

    return $avatar;
}

/**
 * 获取用户信息
 * @param $user_id：用户id
 * @return array：用户信息
 */
function get_user_info($user_id){
    $db     = new Db();
    $sql    = 'select * from mr_user where id = :user_id';
    $user   = $db->row($sql,array('user_id'=>$user_id));
    return $user;
}

function is_follow($friend_id){
    $user_id = $_SESSION['user']['id'];
    $sql = 'select status from mr_friends where user_id = :user_id and friend_id =:friend_id';
    $db  = new Db();
    $status = $db->single($sql,array('user_id'=>$user_id,'friend_id'=>$friend_id));
    if($status == 1){
        return true;
    }else{
        return false;
    }
}


function get_parent_info($pid){
    $db      = new Db();
    $parent  = $db->row('select * from mr_post where id = '.$pid);
    if(isset($parent) && $parent['post_type'] == 2){
        get_parent_info($parent['pid']);

    }

    $data = $parent;

    echo "<pre>";
    print_r($data);
    die;
    return $data;
}


function get_forward_info($pid){
    $parent  = array();
    $db      = new DB();
    $parent  = $db->row('select * from mr_post where id = '.$pid);
    $content = '';
    do{
        if(isset($parent) && $parent['post_type'] == 2){
            $parent  = get_post_info($parent['id']);
            $content = $parent['content']."//".$content;
            $flag = true;
        }else{
            $sub['parent'] = $parent;
            $flag = false;
        }
    }while($flag === true);

    $sub['content'] = $content;
    return $sub;
}

function get_post_info($id){
    $db    = new Db();
    $post  = $db->row('select * from mr_post where id = '.$id);

    return $post;
}

/***
 * 获取关注数
 */
function get_followed_number($user_id){

}

/***
 * 获取关注数
 */
function get_fans_number(){
    return 10;
}


function get_post_number($user_id){
    $db   = new Db();
    $sql  = 'select count(*) from mr_post where post_type != 1 and user_id = :uid';
    $post = $db->single($sql,array('uid'=>$user_id));
    return $post;
}