<?php
    require('library/Db.class.php');   //连接数据库
    require("library/function.php");   //引入自定义函数
    require('library/page.class.php'); //引入分页类
    is_login();
    $db        = new Db();                  //实例化数据库类
    $user_id   = $_SESSION['user']['id'];   //获取用户id
    $friend_id = $_POST['friend_id'];       //获取好友id
    $addtime   = time();
    /**查看mr_friends表是否有该好友信息**/
    $friend     = $db->row('select * from mr_friends where user_id = :user_id and friend_id = :friend_id',
                            array('user_id'=>$user_id,'friend_id'=>$friend_id));
    if(!$friend){   //没有该好友信息
        $sql    = 'insert into mr_friends (user_id,friend_id,status,addtime) value (:user_id,:friend_id,1,:addtime)';
        $db->query($sql,array('user_id'=>$user_id,'friend_id'=>$friend_id,'addtime'=>$addtime));
        if( $db->lastInsertId() ){
            //关注数+1
            $db->query('update mr_user set follows_num = follows_num + 1 where id = :user_id',array('user_id'=>$user_id));
            //好友粉丝数+1
            $db->query('update mr_user set fans_num = fans_num + 1 where id = :friend_id',array('friend_id'=>$friend_id));
        }
        echo 1;
    }else{  //存在该好友信息
        if($friend['status'] == 0){ //已取消关注该好友的情况，重新关注
            $sql = 'update mr_friends set status = 1,addtime = :addtime where id = :id';
            $res = $db->query($sql,array('id'=>$friend['id'],'addtime'=>$addtime));
            if($res){
                //关注数+1
                $db->query('update mr_user set follows_num = follows_num + 1 where id = :user_id',array('user_id'=>$user_id));
                //好友粉丝数+1
                $db->query('update mr_user set fans_num = fans_num + 1 where id = :friend_id',array('friend_id'=>$friend_id));
            }
            echo 1;
        }else{  //已经关注该好友时，取消关注
            $sql = 'update mr_friends set status = 0,addtime = :addtime where id = :id ';
            $res = $db->query($sql,array('id'=>$friend['id'],'addtime'=>$addtime));
            if($res){
                //关注数量-1
                $db->query('update mr_user set follows_num = follows_num - 1 where id = :user_id',array('user_id'=>$user_id));
                //好友粉丝-1
                $db->query('update mr_user set fans_num = fans_num - 1 where id = :friend_id',array('friend_id'=>$friend_id));
            }
            echo 0;
        }
    }


