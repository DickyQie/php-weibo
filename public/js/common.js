
$(function(){
    /**点击@按钮，切换显示和隐藏**/
    $('.at-friend').click(function(){
        $('.interest-link').toggle();
    });

    /** 展开获取微博回复信息，关闭移除回复信息 **/
    $(".weibo_list_bottom .weibo_list_bottom_message").click(function(){
        var total = $(this).children('span').html();
        var comment_list = $(this).parent().siblings(".weibo_comment").children(".comment_list");
        if(comment_list.is(":hidden")){
            if(total > 0 ){
                var index = layer.msg('数据加载中', {icon: 16});//layer加载数据样式
                var pid = $(this).parent().attr('value');//获取微博id
                /**ajax获取评论5条以内数据数据**/
                $.post("getComment.php", {pid: pid}, function(jsdata) {
                    var data = jsdata;
                    $(data).each(function(){
                        var str = '';
                        str += '<div class="weibo_list weibo-comment" >';
                        str += '<div class="weibo_list_top">';
                        str += '<div class="weibo_list_head">';
                        str += '<a><img class ="avatar" src="' + this.avatar + '"></a></div>';
                        str += '<ul class="weibo-comment-ul">';
                        str += '<li><b>' + this.username + '</b></li>';
                        str += '<li><span>' + this.addtime + '</span></li>';
                        str += '<li><p>' + this.content + '</p></li>';
                        str += '</ul></div></div>';
                        comment_list.append(str);
                    });

                    if(total > 5){
                        var str_total = '';
                        str_total += '<div class="weibo_comment_more">';
                        str_total += '<a href="comment.php?post_id='+pid+'">后面还有'+ (total-5) +'条评论，点击查看全部></a></div>';
                        comment_list.append(str_total);
                    }
                    layer.close(index);//layer关闭加载样式
                }, "json");
            }
        }else{
            //移除回复内容
            comment_list.children().remove();
        }
        $(this).parent().siblings(".weibo_comment").slideToggle(200);
    });

    /** 展开与关闭 **/
    $(".weibo_list_bottom .weibo_list_bottom_message").click(function(){
        $(this).toggleClass("weibo_list_bottom_message_cur");
    });

    $(".my_friend_list button").click(function(){
        $(this).toggleClass("my_friend_btn_click");
    });

    $(".my_head_message .show_btn").click(function(){
        $(this).toggleClass("show_btn_on");
    });

    $(".weibo_list_top .weibo_list_head_collect").click(function(){
        $(this).toggleClass("weibo_list_head_collect_cur");
    });


    /** 转发 **/
    $('.forward').click(function(){
        var pid = $(this).parent().attr('value');
        //iframe层
        layer.open({
            type: 2,                            //弹出框
            title: '转发微博',                   //标题
            area:['700px','500px'],             //弹层宽高
            shade: 0.5,                         //背景透明度
            content: 'getForward.php?pid='+pid //iframe的url
        });
    });

    /**js实现收藏和取消收藏 **/
    $('.collect').click(function(){
        var post_id = $(this).parent().attr('value');
        var that    = $(this);
        $.post("collect.php",{post_id:post_id},function(re){
            if(re == 1){
                layer.msg('收藏成功',{time:2000});
                that.html('已收藏');
            }else{
                layer.msg('已取消收藏',{time:2000});
                that.html('收藏');
            }
        });
    });

    /** 我的收藏页取消收藏 **/
    $('.cancel-collect').click(function(){
        var post_id = $(this).attr('value');
        $.post("collect.php",{post_id:post_id},function(re){
            if(re == 1){
                layer.msg('操作失败');
            }else{
                layer.msg('已取消收藏',{time:2000});
                window.location.reload();
            }
        });
    });

    /** 点赞 **/
    $('.praise').click(function(){
        var post_id = $(this).parent().attr('value');
        var count   = $(this).children().text();
        var that    = $(this);
        $.post("praise.php",{post_id:post_id},function(re){
            if(re == 1){
                layer.msg('点赞成功！',{time:2000});
                count++;
                that.children().text(count);
            }else{
                layer.msg('您已经赞过啦！',{time:2000});
            }
        });
    });

    /** 搜索 **/
    $(function(){
        $('.search').click(function(){
            $('form').submit();
        });
    });

    /**关注/取消关注**/
    $('#follow,#cancel-follow').click(function(){
        var friend_id = $(this).attr('value');
        $.post("follow.php",{friend_id:friend_id},function(re){
            if(re == 1){
                layer.msg('关注成功',{time:2000});
            }else{
                layer.msg('已取消',{time:2000});
            }
            window.location.reload();
        });
    });

    /** 修改密码 **/
    $('#save-password').click(function(){
        var old_password  = $('#old_password').val();
        var new_password  = $('#new_password').val();
        var new_password2 = $('#new_password2').val();
        if(old_password == ''){
            layer.msg('原始密码不能为空');
            return false;
        }
        if(new_password == ''){
            layer.msg('新密码不能为空');
            return false;
        }
        if(new_password === old_password){
            layer.msg('新密码与原始密码不能相同');
            return false;
        }
        if(new_password !== new_password2){
            layer.msg('新密码与确认密码不一致');
            return false;
        }

        $.post("changePassword.php", {old_password:old_password,new_password:new_password}, function(data) {
            if (data == -1) {
                layer.msg('原始密码错误');
                return false;
            }
            if (data == 0) {
                layer.msg('更改密码失败');
                return false;
            }
            if (data == 1){
                layer.msg('更改成功');
                window.location.reload();
            }
        });
        return false;
    });

    //菜单切换
    $('.menu .item')
        .tab()
    ;

    /** 关闭弹层 **/
    $('.more-forward').click(function(){
        var post_id = $(this).attr('value');
        var index = parent.layer.getFrameIndex(window.name);
        parent.location.href = 'forward.php?post_id='+post_id;
        parent.layer.close(index); //关闭弹层
    });


});





/**
 * highslide展示图片效果
 */
$(function(){
    hs.graphicsDir = 'public/static/highslide/graphics/';
    hs.align = 'center';
    hs.transitions = ['expand', 'crossfade'];
    hs.wrapperClassName = 'dark borderless floating-caption';
    hs.fadeInOut = true;
    hs.dimmingOpacity = .75;

// Add the controlbar
    if (hs.addSlideshow) hs.addSlideshow({
        //slideshowGroup: 'group1',
        interval: 5000,
        repeat: false,
        useControls: true,
        fixedControls: 'fit',
        overlayOptions: {
            opacity: .6,
            position: 'bottom center',
            hideOnMouseOut: true
        }
    });
});


/**检测字数**/
function checknum(v, word) {
    var len = 140 - v.length;
    $('#sayword_' + word).text(len);
    if (len < 0) {
        $('#sayword_' + word).css({
            "color": "red"
        });
    }
}


/**选择好友**/
function chooseFriend(username){
    var content = $('textarea').val();
    content = content + '@'+username + ' ';
    $('#saybox_0').val(content);
    $('.interest-link').hide();
}

/**检测字数：大于0，小于140字**/
function checkWordsNumber(content){
    var len = content.length;
    var message = '';
    if (len == 0) {
        message = "发布内容不能为空！";
    }
    if (len > 140) {
        message = "发布内容不能超过140字！";
    }
    return message;
}

/**确认发布**/
function saysub(pid,type) {
    /**检测字数**/
    var content = $('#saybox_'+ pid).val();
    var check_result = checkWordsNumber(content);
    if(check_result){
        layer.msg(check_result);
        return false;
    }
    /**获取图片路径,拼接成字符串**/
    var pics = '';
    $('.img_common').each(function(){
        pics += $(this).attr('src') + ",";
    });
    if(pics){
        pics = pics.substring(0,pics.length-1);
    }

    /**微博类型**/
    if(type == 'comment'){
        type = 1;
    }else if(type == 'forward'){
        type = 2;
    }else{
        type = 0;
    }

    /**ajax提交**/
    $.post("ajaxAction.php", {pid:pid,type:type,content:content,pictures:pics}, function(data) {
        if (data == -1) {
            layer.msg('请先登录',{time:1000},function(){
                window.location.href = 'login.php';
            });
            return false;
        }
        layer.msg('发布成功',{time:1000},function(){
            var index = parent.layer.getFrameIndex(window.name);
            parent.location.reload();
            parent.layer.close(index); //再执行关闭
        });
    })
}
