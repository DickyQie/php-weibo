<?php

    require('library/Db.class.php');//引入数据库类文件
    require("library/function.php");   //引入自定义函数库
    is_login(); //判断是否登录

    $db  = new Db();    //实例化数据库类
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $user_id = $_SESSION['user']['id'];

    $password = $db->single("select password from mr_user where id = :user_id",array("user_id"=>$user_id));

    //更新密码
    if($old_password == $password){  //判断输入两次新密码是否一致
        $sql     = "update mr_user set password = :newPassword where Id = :userid";
        $update  =  $db->query($sql,array("newPassword"=>$new_password,"userid"=>$user_id));
        if($update){
            echo 1;
        }else{
            echo 0;
        }
    }else{
            echo -1;
    }
