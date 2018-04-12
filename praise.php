<?php
    require('library/Db.class.php');   //连接数据库
    require("library/function.php");   //引入自定义函数
    require('library/page.class.php'); //引入分页类
    is_login();     //判断是否登录
    $db = new Db(); //实例化数据库操作类
    $user_id = $_SESSION['user']['id']; //获取当前用户id
    $post_id = $_POST['post_id'];       //获取微博id

    /** 查看用户是否已经点赞 **/
    $praise    = $db->row('select * from mr_praise where user_id = :user_id and post_id = :post_id',
                           array('user_id'=>$user_id,'post_id'=>$post_id));
    if(!$praise){   //没有点赞
        $sql    = 'insert into mr_praise (user_id,post_id) value (:user_id,:post_id)';
        $insert = $db->query($sql,array("user_id"=>$user_id,"post_id"=>$post_id));
        //微博点赞数加1
        $db->query('update mr_post set praise_num   = praise_num + 1 where id = :post_id',array('post_id'=>$post_id));
        echo 1;
    }else{      //已经点赞
        echo 0;
    }

