<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username=$_POST['username'];

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $selectExamination=mysqli_query($con,"SELECT url,customCheck from examination where username
    = '{$username}'") or die('insertExamination failed!');
    $row = mysqli_fetch_array($selectExamination);
    echo json_encode([$row['url'],$row['customCheck']]);
    mysqli_close($con);
?>