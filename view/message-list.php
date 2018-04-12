<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body>

<?php include_once("view/common/head.html"); ?> <!-- 引入头部菜单-->

<div class="main">
    <?php include_once("view/common/head.html");  ?> <!-- 引入头部-->
    <div class="left">
        <h4 class="weibo_list_title">我的消息</h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>您还没有消息哦！</p>
            </div>
        <?php }else { ?>
            <?php foreach ($lists as $v) { ?>
                <div class="weibo_list">
                    <div class="weibo_list_top">
                        <div class="weibo_list_head">
                            <a href="<?php echo "homepage.php?friend_id=".$v['user_id'] ?>">
                                <img class="avatar" src="<?php echo get_cover_path($v['avatar']) ?>"/>
                            </a>
                        </div>

                        <ul>
                            <li><b><?php echo $v['username'] ?></b></li>
                            <li><span><?php echo tranTime($v['addtime']); ?></span></li>
                            <li>
                                <p>
                                    <?php echo ubbReplace($v['content']); ?>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="weibo_list_top" style="background: #F2F2F5">
                        <ul>
                            <li><b><?php echo $v['post']['username'] ?></b></li>
                            <li><span><?php echo tranTime($v['post']['addtime']); ?></span></li>
                            <li>
                                <p>
                                    <?php echo ubbReplace($v['post']['content']); ?>
                                </p>
                            </li>
                            <!--微博图片开始-->
                            <?php  if($v['post']['pictures']){ ?>
                                <li>
                                    <div class="highslide-gallery">
                                        <?php foreach($v['post']['pictures'] as $pic){ ?>
                                            <a href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
                                                <img src="<?php echo $pic; ?>"  title="点击放大" />
                                            </a>
                                        <?php } ?>
                                </li>
                            <?php } ?>
                            <!--微博图片结束-->
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <!--分页开始-->
            <div class="showPage">
                <?php
                    $page = new page($total, $showrow, $curpage, $url, 2);
                    echo $page->myde_write();
                ?>
                <div class="cl"></div>
            </div>
            <!--分页结束-->
        <?php } ?>

    </div>
    <?php include_once("view/common/profile.php"); ?>
</div>
</body>
</html>