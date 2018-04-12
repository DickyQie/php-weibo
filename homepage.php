<?php
    require('library/Db.class.php');//连接数据库
    require("library/function.php");   //自定义函数
    require('library/page.class.php'); //分页类

    is_login();
    $db = new Db();
    $friend_id   = $_GET['friend_id'];
    $friend_info = get_user_info($friend_id);
    /** 用户微博信息 **/
    $showrow = 5; //一页显示的行数
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //当前的页,还应该处理非数字的情况
    $url = "?page={page}&friend_id=".$friend_id; //分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']

    $total = $db->single("select count(*) from mr_post where  post_type != 1 and user_id = :friend_id",array('friend_id'=>$friend_id));//记录总条数

    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow)){
        $curpage = ceil($total_rows / $showrow); //当前页数大于最后页数，取最后一页
    }
    //获取数据
    $sql  = "SELECT * FROM mr_post where ( post_type != 1 and user_id = :friend_id) ORDER BY addtime DESC";
    $sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
    $row  = $db->query($sql,array('friend_id'=>$friend_id));

    foreach($row as $vo){
        $vo['avatar']  = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$vo['user_id']));
        $status        = $db->single('select status from mr_collect where user_id = :uid and post_id = :pid',array('uid'=>$_SESSION['user']['id'],'pid'=>$vo['id']));
        $vo['collect'] = $status ? $status : 0;
        //图片数据格式由字符串转化为数组
        if($vo['pictures']){
            $vo['pictures'] = explode(',',$vo['pictures']);
        }

        //转发数
        $vo['forward_count'] = $db->single('select count(*) from mr_post where post_type = 2 and pid = '.$vo['id']);

        //评论数量
        $vo['comment_count'] = $db->single('select count(*) from mr_post where post_type = 1 and pid = '.$vo['id']);

        //点赞数量
        $vo['praise_count']  = $db->single('select count(*) from mr_praise where post_id = '.$vo['id']);

        //如果转发
        if(isset($vo['pid']) && $vo['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid = $vo['pid'];
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
            $vo['sub'] = $sub;
        }

        $lists[] = $vo;
    }

    include "view/homepage-list.php";