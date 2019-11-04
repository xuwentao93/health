<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectCheck=mysqli_query($con,"SELECT checkList from checkList") or die('22');
    $check = array();
     while($row=mysqli_fetch_row($selectCheck)){
         array_push($check, $row[0]);
     }
    mysqli_close($con);
    echo json_encode($check);
?>