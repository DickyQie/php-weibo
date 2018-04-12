<?php

require('library/Db.class.php');//连接数据库
require("library/function.php");   //自定义函数
require('library/page.class.php'); //分页类

is_login();
$db = new Db();
$user_id = $_SESSION['user']['id'];
//�����ղ�΢��

$showrow = 5; //һҳ��ʾ������
$curpage = empty($_GET['page']) ? 1 : $_GET['page']; //��ǰ��ҳ,��Ӧ�ô�������ֵ����
$url     = "?page={page}"; //��ҳ��ַ������м������� ="?page={page}&q=".$_GET['q']
$total   = $db->single("select count(*) from mr_praise where user_id = :user_id ",array('user_id'=>$user_id));//��¼������

if (!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow)){
    $curpage = ceil($total / $showrow); //��ǰҳ���������ҳ����ȡ���һҳ
}
$sql  = "select * from mr_praise where user_id = :user_id order by id desc";
$sql .= " LIMIT " . ($curpage - 1) * $showrow . ",$showrow;";
$praise_lists = $db->query($sql,array('user_id'=>$user_id));

if(isset($praise_lists)){
    foreach($praise_lists as $vo){
        $post   = $db->row('select * from mr_post where id = :id',array('id'=>$vo['post_id']));
        $avatar = $db->single('select avatar from mr_user where id = :user_id',array('user_id'=>$post['user_id']));
        $post['avatar']  = $avatar;
        $post['collect'] = 1; //���ղ�
        //ͼƬ���ݸ�ʽ���ַ���ת��Ϊ����
        if($post['pictures']){
            $post['pictures'] = explode(',',$post['pictures']);
        }
        //ת����
        $post['forward_count'] = $db->single('select count(*) from mr_post where post_type = 2 and pid = '.$post['id']);
        //��������
        $post['comment_count'] = $db->single('select count(*) from mr_post where post_type = 1 and pid = '.$post['id']);
        //��������
        $post['praise_count']  = $db->single('select count(*) from mr_praise where post_id = '.$post['id']);
        //���ת��
        if(isset($post['pid']) && $post['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid     = $post['pid'];
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
            $post['sub'] = $sub;
        }
        $lists[] = $post;
    }

}

include 'view/mypraise-list.php';

