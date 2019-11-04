<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectDepartment=mysqli_query($con,"SELECT department from department") or die('22');
    $department = array();
    while($row=mysqli_fetch_row($selectDepartment)){
        array_push($department, $row);
    }
    mysqli_close($con);
    echo json_encode($department);
?>