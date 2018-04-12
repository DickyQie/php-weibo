<?php
    require('library/Db.class.php');   //连接数据库
    require("library/function.php");   //引入自定义函数
    require('library/page.class.php'); //引入分页类
    is_login();     //判断是否登录
    $db = new Db(); //实例化数据库操作类
    $user_id = $_SESSION['user']['id']; //获取当前用户id
    $post_id = $_POST['post_id'];       //获取微博id
    /** 判断用户是否已经收藏该微博 **/
    $collect    = $db->row('select * from mr_collect where user_id = :user_id and post_id = :post_id',
                            array('user_id'=>$user_id,'post_id'=>$post_id));
    if(!$collect){   //未收藏，本次首测收藏，写入mr_collect表
        $sql    = 'insert into mr_collect (user_id,post_id,status) value (:user_id,:post_id,1)';
        $insert = $db->query($sql,array("user_id"=>$user_id,"post_id"=>$post_id));
        echo 1;
    }else{
        $sql = 'update mr_collect set status = :status where user_id = :user_id and post_id = :post_id';
        if($collect['status'] == 0){ //之前已取消收藏，再次收藏，写入mr_collect表
            $db->query($sql,array('status'=>1,'user_id'=>$user_id,'post_id'=>$post_id));
            echo 1;
        }else{                      //已经收藏
            $sql = 'update mr_collect set status = 0 where id = :id';
            $db->query($sql,array('id'=>$collect['id']));
            echo 0;
        }
    }

