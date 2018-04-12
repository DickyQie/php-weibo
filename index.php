<?php
    require('library/Db.class.php');   //连接数据库
    require("library/function.php");   //引入自定义函数
    require('library/page.class.php'); //引入分页类
    is_login();
    $db = new Db();
    /**分页**/
    $showrow = 5; //一页显示的行数
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //当前的页,还应该处理非数字的情况
    $url = "?page={page}"; //分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']
    $sql = "select * from mr_post where  post_type != 1  order by addtime desc";
    //记录总条数
    $total = $db->single("select count(*) as count from mr_post where  post_type != 1 ");

    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
        $curpage = ceil($total / $showrow); //当前页数大于最后页数，取最后一页
    //获取数据
    $sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
    $post = $db->query($sql); //所有微博
    foreach($post as $vo){
        $vo['avatar']  = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$vo['user_id']));
        $status        = $db->single('select status from mr_collect where user_id = :uid and post_id = :pid',array('uid'=>$vo['user_id'],'pid'=>$vo['id']));
        $vo['collect'] = $status ? $status : 0;

        //图片数据格式由字符串转化为数组
        if($vo['pictures']){
            $vo['pictures'] = explode(',',$vo['pictures']);
        }

        //如果转发
        if(isset($vo['pid']) && $vo['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid = $vo['pid'];
            //查找父级
            $parent  = $db->row('select * from mr_post where id = '.$pid);
            do{
                //如果是转发内容，继续查找转发的父级
                if(isset($parent) && $parent['post_type'] == 2){
                    $content = '@'.$parent['username'].':'.$parent['content'].'//'.$content;
                    //查找父级
                    $parent  = $db->row('select * from mr_post where id = '.$parent['pid']);
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
            //去除结尾的“//”
            $sub['content'] = substr($content,0,-2);
            $vo['sub'] = $sub;
        }
        $lists[] = $vo;
    }
    include 'view/index-list.php';