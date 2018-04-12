<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>注册</title>
    <!--引入css样式文件-->
    <link rel="stylesheet" type="text/css" href="public/css/semantic.css" />
    <link rel="stylesheet" type="text/css" href="public/css/login.css" />
    <script type="text/javascript" src="public/js/jquery.js"></script>
    <script type="text/javascript" src="public/static/layer/layer.js"></script>
</head>
<body>

<div class="header" title="头部">
    <img src="public/images/login_logo.png">
</div>

<div class="main">
    <div class="left">
        <div class="login-bg">
            <img src="public/images/login_banner.png">
        </div>
    </div>
    <div class="content">
        <!-- 用户输入区开始 -->
        <div class="ui big form">
            <div class="ui stacked segment blue">
                <div class="field">
                    <div class="ui icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" placeholder="用户名">
                    </div>
                </div>
                <div class="field">
                    <div class="ui icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="密码">
                    </div>
                </div>
                <div class="field">
                    <div class="ui icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password2" placeholder="确认密码">
                    </div>
                </div>
                <button id="login" class="ui fluid large teal submit  button" >注册</button>
            </div>
            <div class="ui message">
                已有账号，直接 <a  href="login.php">登录</a>
            </div>
        </div>
        <!-- 推荐输入区结束 -->

        <!-- 推荐用户开始 -->
        <div class="recommend">
            <div class="ui horizontal divider">
                <h4 class="ui teal">推荐用户</h4>
            </div>
            <div class="ui tiny images">
                <img class="ui medium circular image" src="public/images/steve_01.png">
                <img class="ui medium circular image" src="public/images/steve_02.png">
                <img class="ui medium circular image" src="public/images/steve_03.png">
                <img class="ui medium circular image" src="public/images/steve_04.png">
                <img class="ui medium circular image" src="public/images/steve_05.png">
                <img class="ui medium circular image" src="public/images/steve_06.png">
                <img class="ui medium circular image" src="public/images/steve_07.png">
                <img class="ui medium circular image" src="public/images/steve_08.png">
                <img class="ui medium circular image" src="public/images/steve_09.png">
            </div>
        </div>
        <!-- 推荐用户结束 -->
    </div>
</div>
<div class="clear"></div>
<div class="footer">
    Copyright@2016吉林省明日科技有限公司
</div>

<script>
    $('#login').click(function(){
        var username  = $("input[name='username']").val();
        var password  = $("input[name='password']").val();
        var password2 = $("input[name='password2']").val();
        //js验证用户名和密码
        if(username == ''){
            layer.msg('请填写用户名');
            return false;
        }
        if(password == ''){
            layer.msg('请填写密码');
            return false;
        }
        if(password !== password2){
            layer.msg('两次输入密码不一致');
            return false;
        }
        //js验证
        $.post("ajaxRegister.php", {username: username,password:password}, function(data) {
            if (data == -1) {
                layer.msg('用户名已存在');
                return false;
            }
            if (data == 1){
                layer.msg('注册成功',{time:1000},function(){
                    window.location.href = "index.php";
                });
            }else{
                layer.msg('注册失败');
                return false;
            }
        });
        return false;
    });
</script>
</body>
</html>