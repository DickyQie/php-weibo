<?php
    require("library/function.php");   //自定义函数
    require('library/Db.class.php');//连接数据库
    is_login(); //检测是否登陆
    $db      = new Db();
    $user_id = $_SESSION['user']['id'];
    $sex     = $_POST['sex'];
    $qq      = $_POST['qq'];
    $email   = $_POST['email'];
    $sql     = "UPDATE mr_user SET sex = :sex,qq = :qq,email = :email  WHERE id = :user_id";
    $update  =  $db->query($sql,array("user_id"=>$user_id,"sex"=>$sex,"qq"=>$qq,"email"=>$email));
    if($update !== false){
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('保存成功');window.location.href='setting.php';</script>";
    }else{
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('保存失败');window.location.href='setting.php';</script>";
    }

