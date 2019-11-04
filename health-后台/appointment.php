<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username = $_POST['username'];
    $month = $_POST['month'];
    $day = $_POST["day"];
    $time = $_POST["time"];
    $doctor = $_POST['doctor'];
    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectUsername = mysqli_query($con,"SELECT username from user left join message on
    message.number = user.number where name = '{$doctor}'") or die("fail");
    $row=mysqli_fetch_array($selectUsername);
    $doctorName = $row["username"];
    $selectNumber = mysqli_query($con,"SELECT number from user where username='{$username}'")
    or die("22");
    $row=mysqli_fetch_array($selectNumber);
    $number = $row['number'];
    $data = $month.$day.$time.$number;
    $updateTime = mysqli_query($con,"UPDATE appointment set time = concat(time,'{$data}')
    where username = '{$doctorName}'") or die("22");
    echo "ok";
    mysqli_close($con);
?>