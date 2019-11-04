<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $custom = $_POST['custom'];
    $check = $_POST['check'];
    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $insertCheck=mysqli_query($con,"INSERT into customCheck (username,customCheck) values 
    ('{$custom}','{$check}')") or die('22');
    mysqli_close($con);
?>