
<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body>
<!-- 引入头部菜单-->
<?php include_once("view/common/head.html"); ?>

<div class="main">
    <div class="left">
        <h4 class="weibo_list_title">搜索结果:所有包含“
            <span style="color:red"><?php echo $keyword;?></span>
            ”的微博
        </h4>
        <?php if(!isset($lists)){ ?>
            <div class="empty">
                <?php echo '没有包含该关键字的微博'; ?>
            </div>
        <?php }else{
            include_once("view/common/weibo-list.php");
            include_once("view/common/page.php");
        }?>
    </div>
    <?php include_once("view/common/profile.php"); ?>
</div>

<!-- 底部信息 -->
<?php include_once("view/common/footer.php"); ?>
</body>
</html>