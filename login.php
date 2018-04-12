<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
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
                <button id="login" class="ui fluid large teal submit  button" >登录</button>
            </div>
            <div class="ui message">
                新用户? <a href="register.php">注册</a>
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
        //js验证用户名和密码
        if(username == ''){
            layer.msg('请填写用户名');
            return false;
        }
        if(password == ''){
            layer.msg('请填写密码');
            return false;
        }
        //js验证
        $.post("ajaxCheckLogin.php", {username: username,password:password}, function(data) {
            if (data == -1) {
                layer.msg('用户名或密码错误');
                return false;
            }
            if (data == 1){
                window.location.href = "index.php";
            }
        });
        return false;
    });
</script>
</body>
</html>