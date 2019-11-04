<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $hospital = $_POST['hospital'];
    $department = $_POST['department'];

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectDoctor=mysqli_query($con,"SELECT name from message where 
    hospital = '{$hospital}' and department = '{$department}'") or die('22');
    $doctor = array();
    while($row=mysqli_fetch_row($selectDoctor)){
        array_push($doctor, $row);
    }
    mysqli_close($con);
    echo json_encode($doctor);
?>