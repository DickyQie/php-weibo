<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body>
<?php include_once("view/common/head.html"); ?> <!-- 引入头部-->

<div class="my_head my_head_other width_1000">
    <div class="my_head_img">
        <img src="<?php echo get_cover_path($friend_info['avatar']) ?>">
    </div>
    <h4><?php echo $friend_info['username'] ?></h4>
    <div class="my_head_message">
        <ul class="fl">
            <li>注册于：<?php echo date('Y-m-d',$friend_info['addtime']) ?></li>
            <li><span>QQ：<?php echo $friend_info['qq'] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>邮箱：<?php echo $friend_info['email'] ?></span></li>
        </ul>

        <?php if($_SESSION['user']['id'] == $_GET['friend_id']){ ?>
            <button  class="show_btn">
                <a href="setting.php">
                    个人主页
                </a>
            </button>
        <?php }elseif(is_follow($_GET['friend_id']) == true){ ?>
            <button id="cancel-follow" class="show_btn" value="<?php echo $friend_info['id'] ?>">
                取消关注
            </button>
        <?php }else { ?>
            <button id="follow" class="show_btn" value="<?php echo $friend_info['id'] ?>">
                关注
            </button>
        <?php } ?>

        <div class="my_info_list fr">
            <div class="fr">
                <ul>
                    <li><span><?php echo $friend_info['follows_num']; ?></span></li>
                    <li>关注</li>
                </ul>
                <ol></ol>
                <ul>
                    <li>
                        <span><?php echo $friend_info['fans_num']; ?></span>
                    </li>
                    <li>粉丝</li>
                </ul>
                <ol></ol>
                <ul>
                    <li><span><?php echo $friend_info['posts_num']; ?></span></li>
                    <li>微博</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="main">
    <div class="left">
        <!--新增微博列表数据-->
        <h4 class="weibo_list_title">他的微博</h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>还没有微博哦！</p>
            </div>
        <?php }else {
            include_once("view/common/weibo-list.php");
            //分页
            include("view/common/page.php");
        } ?>

    </div>
    <!-- 个人信息 -->
    <?php include("view/common/profile.php"); ?>
</div>

<?php include("view/common/footer.php"); ?>
</body>
</html>