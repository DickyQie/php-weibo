<?php
    require('library/Db.class.php');    //连接数据库
    require("library/function.php");   //自定义函数
    require('library/page.class.php'); //分页类
    is_login();
    $db = new Db();
    $user_id = $_SESSION['user']['id'];
    //查找at的微博id
    $showrow = 5; //一页显示的行数
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //当前的页,还应该处理非数字的情况
    $url = "?page={page}"; //分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']
    $total = $db->single("select count(*) from mr_at where user_id = :user_id",array('user_id'=>$user_id));//记录总条数

    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow)){
        $curpage = ceil($total_rows / $showrow); //当前页数大于最后页数，取最后一页
    }
    $sql = "select * from mr_at where user_id = :user_id order by id desc";
    $sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
    $at_lists = $db->query($sql,array('user_id'=>$user_id));
    if(isset($at_lists)){
        //获取数据
        foreach($at_lists as $vo){
            $post   = $db->row('select * from mr_post where id = :id',array('id'=>$vo['post_id']));
            $avatar = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$post['user_id']));
            $post['avatar']  = $avatar;
            $status          = $db->single('select status from mr_collect where user_id = :uid and post_id = :pid',array('uid'=>$vo['user_id'],'pid'=>$vo['post_id']));
            $post['collect'] = $status ? $status : 0;

            //图片数据格式由字符串转化为数组
            if($post['pictures']){
                $post['pictures'] = explode(',',$post['pictures']);
            }
            //转发数
            $post['forward_count'] = $db->single('select count(*) from mr_post where post_type = 2 and pid = '.$post['id']);

            //评论数量
            $post['comment_count'] = $db->single('select count(*) from mr_post where post_type = 1 and pid = '.$post['id']);

            //点赞数量
            $post['praise_count']  = $db->single('select count(*) from mr_praise where post_id = '.$post['id']);

            $lists[] = $post;
        }

    }

    include "view/at-me.php";




