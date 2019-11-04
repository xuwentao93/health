<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username=$_POST['username'];
    $customCheck=$_POST['check'];
    $url=$_POST["url"]; 

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $insertExamination=mysqli_query($con,"INSERT into examination (username,customCheck,url) 
    values('{$username}','{$customCheck}','{$url}');")
    or die('insertExamination failed!');
    move_uploaded_file($_FILES["checkImg"]["tmp_name"],
    "./examination/" . $_FILES["checkImg"]["name"]) or die("img saved failed!");
    echo "success";
    mysqli_close($con);
?>