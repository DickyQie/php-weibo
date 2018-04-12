<?php
    require("library/function.php");   //自定义函数
    require('library/Db.class.php');//连接数据库
    is_login(); //检测是否登陆
    $db = new Db();
    $user_id = $_SESSION['user']['id'];
    $user = $db->row("select * from mr_user where id = :user_id",array('user_id'=>$user_id));
    include 'view/setting-list.php';



