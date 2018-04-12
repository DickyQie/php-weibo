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
                <li>
                    <p>
                        <?php
                        if($v['post_type'] == 2){
                            echo $v['content'].'//'.$v['sub']['content'];
                        }else{
                            echo ubbReplace($v['content']);
                        }
                        ?>
                    </p>
                </li>
                <!--微博图片开始-->
                <?php  if($v['pictures']){ ?>
                    <li>
                        <div class="highslide-gallery">
                            <?php foreach($v['pictures'] as $pic){ ?>
                                <a href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
                                    <img src="<?php echo $pic; ?>"  title="点击放大" />
                                </a>
                            <?php } ?>
                    </li>
                <?php } ?>
                <!--微博图片结束-->
            </ul>
        </div>

        <?php if($v['post_type'] == 2 ){ ?>
            <div class="weibo_list_top" style="background: #F2F2F5">
                <ul>
                    <li><b><?php echo $v['sub']['parent']['username'] ?></b></li>
                    <li><span><?php echo tranTime($v['sub']['parent']['addtime']) ?></span></li>
                    <li>
                        <p>
                            <?php echo ubbReplace($v['sub']['parent']['content']) ?>
                        </p>
                    </li>
                    <!--转发微博图片开始-->
                    <?php  if($v['sub']['parent']['pictures']){ ?>
                        <li>
                            <div class="highslide-gallery">
                                <?php foreach($v['sub']['parent']['pictures'] as $pic){ ?>
                                    <a href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
                                        <img src="<?php echo $pic; ?>"  title="点击放大" />
                                    </a>
                                <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <div class="weibo_list_bottom" value="<?php echo $v['id'] ?>" >
            <!--收藏-->
            <a class="collect" href="javascript:;">
                <?php
                    if($v['collect'] == 1){
                        echo "已收藏";
                    }else{
                        echo "收藏";
                    }
                ?>
            </a>
            <!--转发-->
            <a class="forward" href="javascript:;">转发
                ( <?php echo $v['forward_num'] ?> )
            </a>
            <!--评论-->
            <a class="weibo_list_bottom_message">评论
                ( <span> <?php echo $v['comment_num'] ?> </span> )
            </a>
            <!--点赞-->
            <a class="praise" href="javascript:;">点赞
                ( <span> <?php echo $v['praise_num'] ?> </span> )
            </a>
        </div>
        <div class="weibo_comment">
            <!-- 微博回复框开始 -->
            <div class="send-weibo">
                <div class="ui form" style="overflow: auto">
                    <div class="field">
                        <div class="weibo-text">
                            <textarea  name="content" id="saybox_<?php echo $v['id'] ?>" onkeyup="checknum(this.value, <?php echo $v['id'] ?>)"  rows="5" ></textarea>
                        </div>
                    </div>
                </div>
                <div class="send-action">
                        <span style="color: #d79f34;">
                            评论~~~
                        </span>
                    <div class="release">
                        <span class="countTxt">还可输入<em id="sayword_<?php echo $v['id'] ?>" class="count">140</em>字</span>
                        <button class="ui teal button" onclick="saysub(<?php echo $v['id'] ?> , 'comment')">发布 </button>
                    </div>
                </div>
            </div>
            <!-- 微博回复框结束-->

            <!--评论显示数据开始-->
            <div class="comment_list"></div>
            <!--评论显示每条数据结束-->
        </div>
    </div>
<?php } ?>
