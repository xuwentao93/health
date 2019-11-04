<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $doctor = $_POST['doctor'];
    $time = $_POST['time'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectTime = mysqli_query($con,"SELECT time from appointment where username = '{$doctor}'")
    or die("time error");
    $row=mysqli_fetch_array($selectTime);
    $timeList = $row["time"];
    $length = strlen($timeList) / 21;
    $number = null;
    $have = 0;
    for($i=0;$i<$length;$i++){
        if($time == substr($timeList, $i * 21 + 4, 11) &&
         $month == substr($timeList, $i * 21, 2) &&
         $day == substr($timeList, $i * 21 + 2, 2)){
            $number = substr($timeList, $i *21 + 15, 6);
            $have++;
            break;
        }
    }
    if($have == 0) die("none");
    $selectUser = mysqli_query($con,"SELECT username from user where number = '{$number}'")
    or die("user error");
    $row=mysqli_fetch_array($selectUser);
    $username = $row['username'];
    $selectInfo = mysqli_query($con,"SELECT name from message where number = '{$number}'")
    or die("number error");
    $row=mysqli_fetch_array($selectInfo);
    $name = $row['name'];
    $set = array();
    array_push($set,$username);
    array_push($set,$name);
    echo json_encode($set);
    mysqli_close($con);
?>