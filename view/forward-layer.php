<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body style="background-color: #f2f2f2">
<!-- 引入头部菜单-->
<div class="main">
    <div class="left weibo_list_forward">
        <div class="weibo_list " style="box-shadow: 2px 2px 5px rgba(0,0,0,0);">
            <div class="weibo_comment" style="overflow: hidden; display: block;box-shadow: 2px 2px 5px rgba(0,0,0,0);">
                <!-- 微博回复框开始 -->
                <div class="send-weibo">
                    <div class="ui form" style="">
                        <div class="field">
                            <div class="weibo-text">
                                <textarea name="content" id="saybox_<?php echo $pid ?>" onkeyup="checknum(this.value, '0')" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="send-action">
                        <span style="color: #d79f34;">
                            最新转发~~~
                        </span>
                        <div class="release">
                            <span class="countTxt">还可输入<em id="sayword_0" class="count">140</em>字</span>
                            <button class="ui teal button" onclick="saysub(<?php echo $pid ?> , 'forward')">转发</button>
                        </div>
                    </div>
                </div>
                <!-- 微博回复框结束-->

                <!--转发数据开始-->
                <?php if(isset($lists)){ ?>
                    <div class="comment_list">
                        <!-- 示例数据 ,请在此更改样式-->
                        <?php foreach($lists as $v) { ?>
                            <div class="weibo_list">
                                <div class="weibo_list_top">
                                    <div class="weibo_list_head">
                                        <a href="<?php echo "homepage.php?friend_id=".$v['user_id'] ?>">
                                            <img class="avatar"   src="<?php echo get_cover_path($v['avatar']) ?>"  />
                                        </a>
                                    </div>
                                    <ul>
                                        <li><b><?php echo $v['username'] ?></b></li>
                                        <li><span><?php echo tranTime($v['addtime']); ?></span></li>
                                        <li><p><?php echo ubbReplace($v['content']); ?></p></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($total_forword > 2){ ?>
                        <div class="weibo_comment_more">
                            <a class="more-forward"  value="<?php echo $pid ?>">
                                查看所有<?php echo $total_forword ?>条转发
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!--转发数据结束-->
            </div>
        </div>
    </div>
</div>
</body>
</html>