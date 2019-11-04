<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $doctor = $_POST['doctor'];
    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectUsername = mysqli_query($con,"SELECT username from user left join message on
    message.number = user.number where name = '{$doctor}'") or die("fail");
    $row=mysqli_fetch_array($selectUsername);
    $doctorName = $row["username"];
    $selectTime = mysqli_query($con,"SELECT time from appointment where username = '{$doctorName}'")
    or die("22");
    $row=mysqli_fetch_array($selectTime);
    $time = $row["time"];
    echo $time;
    mysqli_close($con);
?>