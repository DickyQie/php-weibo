$(function () {
    window.onload=function(){
        var old_avatar  = "http://open.web.meitu.com/sources/images/1.jpg";
        var avatar      = $('.my_head_img img').attr('value');
        var avatar_url = "http://localhost/weibo/public/images/upload/head_image/"+avatar;
        if(!avatar_url){
            avatar_url = old_avatar;
        }

        /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
        xiuxiu.embedSWF("altContent",5,"100%","100%");
        //修改为您自己的图片上传接口
        xiuxiu.setUploadURL("http://localhost/weibo/imageUploadForm.php");
        xiuxiu.setUploadType(2);
        xiuxiu.setUploadDataFieldName("Filedata");
        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto(avatar_url);//修改为要处理的图片url
        };
        xiuxiu.onUploadResponse = function (data)
        {
            alert("上传成功");
            window.location.reload();
        }
    }
});

