<?php
    $sql    = 'select * from mr_user where id = :user_id';
    $user   = $db->row($sql,array('user_id'=>$_SESSION['user']['id']));
?>
<div class="profile">
    <!--    新增右侧个人部分-->
    <div class="my_info">
        <img class="my_info_head" height="90px" width="90px" src="<?php echo get_cover_path($user['avatar']) ?>">
        <h4><?php echo $user['username'] ?></h4>
        <div class="my_info_list">
            <ul>
                <a href="friends.php">
                    <li><span><?php echo $user['follows_num'] ?></span></li>
                    <li>关注</li>
                </a>
            </ul>
            <ol></ol>
            <ul>
                <a href="myFans.php">
                    <li><span><?php echo $user['fans_num'] ?></span></li>
                    <li>粉丝</li>
                </a>
            </ul>
            <ol></ol>
            <ul>
                <a href="myPost.php">
                    <li><span><?php echo $user['posts_num'] ?></span></li>
                    <li>微博</li>
                </a>
            </ul>
        </div>
    </div>

    <!--明天图书推荐开始-->
    <div class="mr_book">
        <h4>明日热销图书</h4>
        <div class="mr_boox_list">
            <a href="http://www.mingribook.com/">
            <img src="public/images/mr_book_PHP.png">
            <ul>
                <li>PHP开发案例讲座</li>
                <li><span>出版时间：2016年8月</span></li>
                <li><p>￥26.9</p></li>
            </ul>
            </a>
        </div>
        <div class="mr_boox_list">
            <a href="http://www.mingribook.com/">
            <img src="public/images/mr_book_Android.png">
            <ul>
                <li>Android从入门到精通</li>
                <li><span>出版时间：2016年8月</span></li>
                <li><p>￥59.8</p></li>
            </ul>
            </a>
        </div>
        <div class="mr_boox_list">
            <a href="http://www.mingribook.com/">
            <img src="public/images/mr_book_JAVA.png">
            <ul>
                <li>Java从入门到精通</li>
                <li><span>出版时间：2016年8月</span></li>
                <li><p>￥59.8</p></li>
            </ul>
            </a>
        </div>
    </div>
    <!--明天图书推荐结束-->
</div>