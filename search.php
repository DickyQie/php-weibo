<?php
    require('library/Db.class.php');//�������ݿ�
    require("library/function.php");   //�Զ��庯��
    require('library/page.class.php'); //��ҳ��
    is_login();
    $keyword = $_REQUEST['keyword'];
    $keyword = str_replace("%","/%",$keyword);
    $db      = new Db();
    /** ��ҳ **/
    $showrow = 5; //һҳ��ʾ������
    $curpage = empty($_GET['page']) ? 1 : $_GET['page']; //��ǰ��ҳ,��Ӧ�ô�������ֵ����
    $url = "?page={page}&keyword=".$keyword; //��ҳ��ַ������м������� ="?page={page}&q=".$_GET['q']

    $total = $db->single("select count(*) from mr_post where content like :keyword",array('keyword'=>"%$keyword%"));//��¼������

    if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))
        $curpage = ceil($total_rows / $showrow); //��ǰҳ���������ҳ����ȡ���һҳ
    //��ȡ����
    $sql  = "select * from mr_post where content like :keyword";
    $sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";

    $post = $db->query($sql,array('keyword'=>"%$keyword%"));

    foreach($post as $vo){
        $vo['avatar']  = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$vo['user_id']));
        $status        = $db->single('select status from mr_collect where user_id = :uid and post_id = :pid',array('uid'=>$vo['user_id'],'pid'=>$vo['id']));
        $vo['collect'] = $status ? $status : 0;

        //ͼƬ���ݸ�ʽ���ַ���ת��Ϊ����
        if($vo['pictures']){
            $vo['pictures'] = explode(',',$vo['pictures']);
        }
        //ת����
        $vo['forward_count'] = $db->single('select count(*) from mr_post where post_type = 2 and pid = '.$vo['id']);

        //��������
        $vo['comment_count'] = $db->single('select count(*) from mr_post where post_type = 1 and pid = '.$vo['id']);

        //��������
        $vo['praise_count']  = $db->single('select count(*) from mr_praise where post_id = '.$vo['id']);

        //���ת��
        if(isset($vo['pid']) && $vo['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid = $vo['pid'];
            $parent  = $db->row('select * from mr_post where id = '.$pid);//���Ҹ���
            do{
                if(isset($parent) && $parent['post_type'] == 2){
                    //���Ҹ���
                    $content = '@'.$parent['username'].':'.$parent['content'].'//'.$content;
                    $parent  = $db->row('select * from mr_post where id = '.$parent['pid']);//���Ҹ���
                    $flag = true;
                }else{
                    //ͼƬ���ݸ�ʽ���ַ���ת��Ϊ����
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
    include "view/search-list.php";
