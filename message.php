<?php
    require('library/Db.class.php');//连接数据库
    require("library/function.php");   //自定义函数
    require('library/page.class.php'); //分页类
    is_login();
    $db      = new Db();
    $user_id = $_SESSION['user']['id'];
    $showrow = 3; //一页显示的行数
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //当前的页,还应该处理非数字的情况
    $url = "?page={page}"; //分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']
    $sql = "SELECT * FROM mr_post where parent_user_id = :user_id ORDER BY addtime DESC";
    $total = $db->single("select count(*) from mr_post where parent_user_id = :user_id",array('user_id'=>$user_id));
    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow)){
        $curpage = ceil($total_rows / $showrow); //当前页数大于最后页数，取最后一页
    }
    //获取数据
    $sql    .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
    $message = $db->query($sql,array('user_id'=>$user_id));

    foreach($message as $vo){
        $row = $db->row('select * from mr_post where id = :pid',array('pid'=>$vo['pid']));
        //$row['avatar'] = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$row['user_id']));
        //图片数据格式由字符串转化为数组
        if($row['pictures']){
            $row['pictures'] = explode(',',$row['pictures']);
        }
        $vo['avatar']  = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$vo['user_id']));
        $vo['post']    = $row;
        $lists[] = $vo;
    }
    include 'view/message-list.php';
?>

