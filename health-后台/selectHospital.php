<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $city = $_POST['city'];
    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectHospital=mysqli_query($con,"SELECT hospital from message where hospital like '$city%'") 
    or die('22');
    $hospital = array();
    while($row=mysqli_fetch_row($selectHospital)){
        array_push($hospital, $row);
    }
    mysqli_close($con);
    echo json_encode($hospital);
?>