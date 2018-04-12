<!-- 头部 -->
<?php include("view/common/header.html");  ?>
<body>
<!-- 头部菜单 -->
<?php include_once("view/common/head.html"); ?>

<div class="main">
    <div class="left">
        <!-- 微博发送框 -->
        <?php include("view/common/send-weibo.php"); ?>
        <!--新增微博列表数据-->
        <h4 class="weibo_list_title" style="margin-top: 15px">我的微博</h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>您还没有微博哦！</p>
            </div>
        <?php }else {
            //微博列表
            include_once("view/common/weibo-list.php");
            //分页
            include_once("view/common/page.php");
        } ?>
    </div>
    <!-- 个人信息 -->
    <?php include_once("view/common/profile.php"); ?>
</div>
<!-- 底部信息 -->
<?php include_once("view/common/footer.php"); ?>
</body>
</html>