<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $name = $_POST['name'];
    $month = $_POST["month"];
    $day = $_POST["day"];
    $date = $month.$day;
    $date = intval($date);
    

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');

    $selectUsername = mysqli_query($con,"SELECT username from user left join message on
    message.number = user.number where name = '{$name}'") or die("fail");
    $row=mysqli_fetch_array($selectUsername);
    $username = $row["username"];
    $selectAppointment=mysqli_query($con,"SELECT leaveDay from appointment where username='{$username}'")
    or die('22');
    $leave = null;
    while($row=mysqli_fetch_array($selectAppointment)){
        $leave = $row["leaveDay"];
    }
    if($leave == null) {
        die("ok");
    }
    $startDate = $leave[0].$leave[1].$leave[2].$leave[3];
    $startDate = intval($startDate);
    $overDate = $leave[4].$leave[5].$leave[6].$leave[7];
    $overDate = intval($overDate);
    if($date >= $startDate || $date <= $overDate) {
        echo "leave";
    }
    else {
        echo "ok";
    };
    mysqli_close($con);
    
?>