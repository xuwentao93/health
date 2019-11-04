<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username = $_POST['username'];
    $password = $_POST['password'];

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $updatePassword = mysqli_query($con,"UPDATE user set password = '{$password}' where
    username = '{$username}'") or die("failed modify secret");

    echo "success";
    mysqli_close($con);
?>