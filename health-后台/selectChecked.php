<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username= $_POST['username'];

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectChecked=mysqli_query($con,"SELECT customCheck from customcheck where username
    ='{$username}'") or die('插入病人表失败');
    $row = mysqli_fetch_array($selectChecked);
    $check = $row['customCheck'];
    mysqli_close($con);
    echo json_encode($check);
?>