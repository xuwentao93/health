<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $y=mysqli_query($con,"SELECT username,tel,name,idnumber,hospital,level,department from doctorregist") or die('22');
    $set=array();
    while($row=mysqli_fetch_row($y)){
        array_push($set, $row);
    }
    echo json_encode($set);
    mysqli_close($con);
?>