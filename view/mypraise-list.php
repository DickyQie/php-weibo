<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body>

<?php include_once("view/common/head.html"); ?> <!-- 引入头部菜单-->

<div class="main">
    <?php include_once("view/common/head.html");  ?> <!-- 引入头部-->
    <div class="left">
        <h4 class="weibo_list_title">点赞的微博</h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>还没有点赞哦！</p>
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
<?php include_once("view/common/footer.php"); ?>
</body>
</html>