<!--引入头部-->
<?php include_once("view/common/header.html");  ?>
<body>

<?php include_once("view/common/head.html"); ?> <!-- 引入头部-->

<div class="main">
    <div class="left">
        <h4 class="weibo_list_title">原始微博</h4>
        <!--新增转发当前微博-->
        <div class="weibo_list">
            <div class="weibo_list_top">
                <div class="weibo_list_head">
                    <a>
                        <img class="avatar" src="<?php echo get_cover_path($post_info['avatar'])?>">
                    </a>
                </div>
                <ul>
                    <li><b><?php echo $post_info['username'] ?></b></li>
                    <li><span><?php echo tranTime($post_info['addtime']); ?></span></li>
                    <li><p><?php echo ubbReplace($post_info['content']); ?></p></li>
                    <!--转发微博图片开始-->
                    <?php  if($post_info['pictures']){ ?>
                        <li>
                            <div class="highslide-gallery">
                                <?php foreach($post_info['pictures'] as $pic){ ?>
                                    <a href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
                                        <img src="<?php echo $pic; ?>"  title="点击放大" />
                                    </a>
                                <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <!-- 转发显示区域-->
        <h4 class="weibo_list_title" style="margin-top: 10px">全部转发</h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">还没有转发哦！</div>
        <?php }else{ ?>
            <?php foreach ($lists as $v) { ?>
                <div class="weibo_list">
                    <div class="weibo_list_top">
                        <div class="weibo_list_head">
                            <a>
                                <img class="avatar" src="<?php echo get_cover_path($v['avatar']) ?>">
                            </a>
                        </div>
                        <ul>
                            <li><b><?php echo $v['username'] ?></b></li>
                            <li><span><?php echo tranTime($v['addtime']); ?></span></li>
                            <li><p><?php echo ubbReplace($v['content']); ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <!-- 分页 -->
            <?php include_once("view/common/page.php"); ?>
        <?php } ?>
    </div>
    <?php include_once("view/common/profile.php"); ?>
</div>
<?php include_once("view/common/footer.php"); ?>
</body>
</html>