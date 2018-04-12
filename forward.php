<?php
    require('library/Db.class.php');//连接数据库
    require("library/function.php");   //自定义函数
    require('library/page.class.php'); //分页类
    is_login(); //判断是否登录
    $db = new Db(); //实例化PDO操作类
    /** 查找微博原文 **/
    $post_id    = $_GET['post_id']; //获取post_id
    $post_info  = $db->row("SELECT * FROM mr_post  where id = :post_id",array('post_id'=>$post_id)); //查找post_id的微博内容
    $avatar     = get_user_avatar($post_info['user_id']); //获取用户头像
    $post_info['avatar'] = $avatar; //头像赋值
    //收藏
    $status    = $db->single('select status from mr_collect where user_id = :user_id and post_id = :post_id',array('user_id'=>$post_info['user_id'],'post_id'=>$post_info['id']));
    $post_info['collect'] = $status ? $status : 0;
    //图片数据格式由字符串转化为数组
    if($post_info['pictures']){
        $post_info['pictures'] = explode(',',$post_info['pictures']);
    }
    //如果转发
    if(isset($post_info['pid']) && $post_info['post_type'] == 2){
        $parent  = array();
        $content = '';
        $pid     = $post_info['pid'];
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
        $post_info['sub'] = $sub;
    }


    /** 查找该微博的回复 **/
    $showrow = 5; //一页显示的行数
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //当前的页,还应该处理非数字的情况
    $url = "?page={page}&post_id=".$post_id; //分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']

    $total = $db->single('select count(*) from mr_post where pid = :post_id and post_type = 2',array('post_id'=>$post_id));
    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow)) {
        $curpage = ceil($total_rows / $showrow); //当前页数大于最后页数，取最后一页
    }

    //获取所有回复数据
    $sql  = "SELECT * FROM mr_post where pid = :post_id and post_type = 2 ORDER BY addtime DESC";
    $sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
    $forward = $db->query($sql,array('post_id'=>$post_id));
    foreach($forward as $vo){
        $vo['avatar']  = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$vo['user_id']));
        $lists[]       = $vo;
    }
    include 'view/forward-list.php';


