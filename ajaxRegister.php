<?php
    require('library/Db.class.php');//连接数据库
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    //判断用户名是否存在
    $db   = new Db();
    $sql  = "select username from mr_user where username = :username";
    $name = $db->row($sql,array('username'=>$username));
    if($name){
        echo -1;
        exit;
    }
    $addtime  = time();//当前时间戳
    //写入user表
    $insert_sql = "insert into mr_user ( username , password ,addtime ) VALUE ( :username ,:password ,$addtime)";
    $insert_id  = $db->query($insert_sql,array('username'=>$username,'password'=>md5($password)));
    if($insert_id){
        echo 1;
    }else{
        echo 0;
    }

