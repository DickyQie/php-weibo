<?php
    require('library/Db.class.php');//连接数据库
    require("library/function.php");//自定义函数
    session_start();//开启session
    $user_id =  isset($_SESSION['user']['id'])?$_SESSION['user']['id']:"";
    if($user_id == '' ){
        echo -1;exit;
    }
    $db = new Db(); //实例化
    //获取用户名
    $username = isset($_SESSION['user']['username'])?$_SESSION['user']['username']:"";
    //接收post提交的父id
    $pid      = isset($_POST['pid']) ? $_POST['pid'] : 0;
    //去除html标识
    $content  = isset($_POST['content']) ? strip_tags($_POST['content']) : "";
    //获取图片
    $pictures = isset($_POST['pictures']) ? $_POST['pictures'] : "";
    //微博类型
    $type     = isset($_POST['type']) ? $_POST['type'] : 0;
    //回复微博
    if($type == 1){
        $parent_user_id = $db->single('select user_id from mr_post where id = :id',
                                       array('id'=>$pid));//回复id
    }
    $parent_user_id = isset($parent_user_id) ? $parent_user_id : 0 ;

    $addtime  = time();
    $sql      = "insert into mr_post (user_id,username,content,pictures,addtime,pid,post_type,parent_user_id)
                 values( :user_id , :username , :content , :pictures , :addtime , $pid , $type ,$parent_user_id)";
    $insert	  = $db->query($sql,array("user_id"=>$user_id,"username"=>$username,"content"=>$content,
                            "pictures"=>$pictures , "addtime"=>$addtime));
    $post_id  = $db->lastInsertId();
    /** $type 0：发微博；1：评论微博；2：转发微博**/
    switch ($type)
    {
        case 0:
            $db->query('update mr_user set posts_num = posts_num + 1 where id = :user_id',
                        array('user_id'=>$user_id));
      break;
        case 1:
            $db->query('update mr_post set comment_num = comment_num + 1 where id = :pid',
                        array('pid'=>$pid));
            break;
        case 2:
            $db->query('update mr_user set posts_num   = posts_num + 1   where id = :user_id',
                        array('user_id'=>$user_id));
            $db->query('update mr_post set forward_num = forward_num + 1 where id = :pid',
                        array('pid'=>$pid));
      break;
    }

    if(strstr($content,"@")){  //判断微博内容中是否含有“@”字符
        /** 写入at表 **/
        $reg = "/@([^@\s]+)/";                  //正则匹配，得到@的用户
        $match = array();
        preg_match_all($reg,$content,$match);   //得到@用户数组
        $users_array = array_unique($match[1]); //去掉重复用户名
        if($users_array){
            $count = count($users_array);         //@的用户总数
            /**查看@用户是否存在，如果存在写入at表**/
            for($i = 0;$i < $count; $i++){
                //mr_user表中查找用户id是否存在
                $select_sql = "select id from mr_user where username = '".$users_array[$i]."'";
                $user_id    = $db->single($select_sql,MYSQL_ASSOC);
                if($user_id){
                    //@信息写入到mr_at表
                    $insert_sql = "insert into mr_at (user_id,post_id) values ( :user_id , :post_id)";
                    $db->query($insert_sql,array('user_id'=>$user_id,'post_id'=>$post_id));
                }
            }
        }
    }



