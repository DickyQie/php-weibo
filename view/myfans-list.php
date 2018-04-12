<!--引入头部-->
<?php include("view/common/header.html");  ?>
<body>

<?php include_once("view/common/head.html"); ?> <!-- 引入头部菜单-->

<div class="main">
    <!-- 引入头部菜单-->
    <?php include_once("view/common/head.html"); ?>

    <div class="left">
        <h4 class="weibo_list_title">粉丝<span><?php echo $total ?></span></h4>
        <div class="my_fans my_friend">
            <?php if (!isset($lists)) {
                echo "还没有粉丝哦！";
            }else{
                foreach($lists as $v){ ?>
                    <div class="my_fans_list">
                        <img class="fl" src="<?php echo get_cover_path($v['avatar']) ?>">
                        <ul class="fl">
                            <li><?php echo $v['username'] ?></li>
                            <li>
                                <span>关注</span><font><?php echo $v['follows_num'] ?></font><span>|</span>
                                <span>粉丝</span><font><?php echo $v['fans_num'] ?></font><span>|</span>
                                <span>微博</span><font><?php echo $v['posts_num'] ?></font>
                            </li>
                            <li><span>注册于：<?php echo date('Y-m-d',$v['addtime']) ?></span>
                                <span>QQ:<?php echo $v['qq'] ?></span>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <!--分页开始-->
                <div class="showPage">
                    <?php
                        if ($total > $showrow) {//总记录数大于每页显示数，显示分页
                            $page = new page($total, $showrow, $curpage, $url, 2);
                            echo $page->myde_write();
                        }
                    ?>
                    <div class="cl"></div>
                </div>
                <!--分页结束-->
            <?php } ?>
        </div>
    </div>
    <?php include("view/common/profile.php"); ?>
</div>
<?php include("view/common/footer.php"); ?>
</body>
</html>