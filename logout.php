<?php

    session_start();
    unset($_SESSION['user']);//清除session

    $result_dest = session_destroy(); //销毁session
    if($result_dest){
        echo "<script>window.location.href='login.php'</script>";
    }else{
        echo "退出失败";
    }

?>

