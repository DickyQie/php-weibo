<!--引入qq表情插件-->
<script type="text/javascript" src="public/js/jquery.qqFace.js"></script>
<script>
    $(function(){
        $('.emotion').qqFace({
            id : 'facebox', //表情盒子的ID
            assign:'saybox_0', //给那个控件赋值
            path:'public/images/face/'	//表情存放的路径
        });
    });
</script>
<div class="send-weibo">
    <div class="ui form" style="overflow: auto">
        <div class="field">
            <div class="content-title" style="font-size: 16px; color: #d79f34; padding: 8px 0 4px 0;">
                随时随地，想发就发~~~
            </div>
            <div class="weibo-text">
                <textarea  name="content" id="saybox_0"   onkeyup="checknum(this.value, '0')"  rows="5" ></textarea>
            </div>
        </div>
    </div>
    <div class="send-action">
        <span>
            <a href="javascript:;">
                <span class="emotion" onclick="emotion()">
                    <i class="smile large icon"></i>表情
                </span>
            </a>
        </span>
        <span>
            <a class="at-friend"><i class="at large icon "></i>一下</a>
        </span>
        <span>
            <a id="btn" href="javascript:;"><i class="file image outline large icon"></i>图片</a>
        </span>

        <div class="release">
            <span class="countTxt">还可输入<em id="sayword_0" class="count">140</em>字</span>
            <button class="ui teal button" onclick="saysub(0)">发布 </button>
        </div>
    </div>
    <div class="interest-link" style="display: none">
        <div class="interest-search-link">好友列表</div>
        <div class="interest-scroll">
            <div id="friends" class="interest-scroll-content">
                <!--@好友列表-->
                <?php
                    $user_lists = $db->query('SELECT username FROM mr_user');
                    foreach ($user_lists as $v) { ?>
                    <div class="interest-search-txt">
                        <a href="javascript:;"  onclick="chooseFriend('<?php echo $v['username']?>')" >
                            <?php echo $v['username']?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="photo_upload_box_outside" id="photo_upload_box_outside" tabindex="2000">
    <div class="photo_upload_box">
        <a class="photo_upload_close"href="javascript:void(0);"onclick="photo_upload_close()"></a>
        <h1>本地上传</h1>
        <p class="upload_num">共<span id="uploaded_length">0</span>张，还能上传<span id="upload_other">9</span>张</p>
        <ul id="ul_pics" class="ul_pics clearfix">
            <li id="local_upload"><img src="public/images/local_upload.png" id="btn2"/></li>
        </ul>
        <div class="arrow_layer">
            <span class="arrow_top_area"><i class="arrow_top_bg"></i><em class="arrow_top"></em></span>
        </div>
    </div>
</div>

<!--多图上传-->
<script type="text/javascript" src="public/static/plupload/plupload.full.min.js"></script>
<script type="text/javascript">
    var upload_total = 9;//最多上传数量
    var uploader = new plupload.Uploader({//创建实例的构造方法
        runtimes: 'gears,html5,html4,silverlight,flash', //上传插件初始化选用那种方式的优先级顺序
        browse_button: ['btn', 'btn2'], // 上传按钮
        url: "upload.php", //远程上传地址
        flash_swf_url: 'public/static/plupload/Moxie.swf', //flash文件地址
        silverlight_xap_url: 'public/static/plupload/Moxie.xap', //silverlight文件地址
        filters: {
            max_file_size: '5mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
            mime_types: [//允许文件上传类型
                {title: "files", extensions: "jpg,png,gif,jpeg"}
            ]
        },
        multi_selection: true, //true:ctrl多文件上传, false 单文件上传
        init: {
            FilesAdded: function(up, files) { //文件上传前
                var length_has_upload = $("#ul_pics").children("li").length;
                if (files.length >= upload_total) { //超过上传总数量则隐藏
                    $("#local_upload").hide();
                }
                var li = '';
                plupload.each(files, function(file) { //遍历文件
                    if (length_has_upload <= upload_total) {
                        li += "<li class='li_upload' id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                    }
                    length_has_upload++;
                });
                $("#ul_pics").prepend(li);
                uploader.start();
            },
            UploadProgress: function(up, file) { //上传中，显示进度条
                var percent = file.percent;
                $("#" + file.id).find('.bar').css({"width": percent + "%"});
                $("#" + file.id).find(".percent").text(percent + "%");
            },
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                showPhotoUploadBox($('#btn'));
                var uploaded_length = $(".img_common").length;
                if (uploaded_length <= upload_total) {
                    var data = eval("(" + info.response + ")");//解析返回的json数据
                    $("#" + file.id).html("<input type='hidden'name='pic[]' value='" + data.pic + "'/><input type='hidden'name='pic_name[]' value='" + data.name + "'/>\n\
                <img class='img_common' src='" + data.pic + "'/><span class='picbg'></span><a class='pic_close' onclick=delPic('" + data.pic + "','" + file.id + "')></a>");
                }
                showUploadBtn();
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
    uploader.init();

    function delPic(pic, file_id) { //删除图片 参数1图片路径  参数2 随机数
        $.post("deletePic.php", {pic: pic}, function(data) {
            $("#" + file_id).remove();
            showUploadBtn();
        })
    }
    function showUploadBtn() { //是否显示上传按钮
        var uploaded_length = $(".img_common").length;
        $("#uploaded_length").text(uploaded_length);
        var other_length = (upload_total - uploaded_length) > 0 ? upload_total - uploaded_length : 0;
        $("#upload_other").text(other_length);
        var uploaded_length = $(".img_common").length;
        if (uploaded_length >= upload_total) {
            $("#local_upload").hide();
        } else {
            $("#local_upload").show();
        }
    }
    function showPhotoUploadBox(obj) { //显示上传弹出层
        var left = obj.offset().left;
        var top = obj.offset().top + 26;
        $("#photo_upload_box_outside").css({"left": left, "top": top}).show()
    }
    function photo_upload_close() { //关闭删除
        $("#photo_upload_box_outside").fadeOut(500, function() {
            $(".li_upload").remove();
        })
    }
</script>
