<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body>
<?php include_once("view/common/head.html"); ?> <!-- 引入头部-->

<div class="main">
    <div class="left">
        <h4 class="weibo_list_title">@我的微博</h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">还没有人@你哦！</div>
        <?php }else{
            //微博列表
            include_once("view/common/weibo-list.php");
            //分页
            include_once("view/common/page.php");
        } ?>
    </div>
    <?php include("view/common/profile.php"); ?>
</div>
<?php include("view/common/footer.php"); ?>
</body>
</html>