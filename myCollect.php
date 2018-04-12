<?php

    require('library/Db.class.php');//连接数据库
    require("library/function.php");   //自定义函数
    require('library/page.class.php'); //分页类

    is_login();
    $db = new Db();
    $user_id = $_SESSION['user']['id'];
    //查找收藏微博

    $showrow = 5; //一页显示的行数
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //当前的页,还应该处理非数字的情况
    $url     = "?page={page}"; //分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']
    $total   = $db->single("select count(*) from mr_collect where status = 1 and  user_id = :user_id ",array('user_id'=>$user_id));//记录总条数

    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow)){
        $curpage = ceil($total / $showrow); //当前页数大于最后页数，取最后一页
    }
    $sql  = "select * from mr_collect where status = 1 and  user_id = :user_id order by id desc";
    $sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
    $collect_lists = $db->query($sql,array('user_id'=>$user_id));

    if(isset($collect_lists)){
        //获取数据
        foreach($collect_lists as $vo){
            $post   = $db->row('select * from mr_post where id = :id',array('id'=>$vo['post_id']));
            $avatar = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$post['user_id']));
            $post['avatar']  = $avatar;
            $post['collect'] = 1; //已收藏
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

            //如果转发
            if(isset($post['pid']) && $post['post_type'] == 2){
                $parent  = array();
                $content = '';
                $pid     = $post['pid'];
                $parent  = $db->row('select * from mr_post where id = '.$pid);//查找父级
                do{
                    if(isset($parent) && $parent['post_type'] == 2){
                        //查找父级
                        $content = '@'.$parent['username'].':'.$parent['content'].'//'.$content;
                        $parent  = $db->row('select * from mr_post where id = '.$parent['pid']);//查找父级
                        $flag = true;
                    }else{
                        //图片数据格式由字符串转化为数组
                        if($parent['pictures']){
                            $parent['pictures'] = explode(',',$parent['pictures']);
                        }
                        $sub['parent'] = $parent;
                        $flag = false;
                    }
                }while($flag === true);
                $sub['content'] = substr($content,0,-2);
                $post['sub'] = $sub;
            }
            $lists[] = $post;
        }

    }
    include 'view/mycollect-list.php';

