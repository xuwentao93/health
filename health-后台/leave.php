<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username = $_POST['username'];
    $startMonth = $_POST['startMonth'];
    $startDay = $_POST['startDay'];
    $overMonth = $_POST['overMonth'];
    $overDay = $_POST['overDay'];
    
    $leave = $startMonth.$startDay.$overMonth.$overDay;

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $updateAppointment=mysqli_query($con,"UPDATE appointment set leaveDay='{$leave}'
    where username='{$username}'") or die('22');
    mysqli_close($con);
    
    echo "success";
?>