<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");

    $username = $_POST['username'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $month = intval($month);
    $day = intval($day);

    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectLeave=mysqli_query($con,"SELECT leaveDay from appointment where username = '{$username}'")
    or die('22');
    $leave = null;
    while ($row = mysqli_fetch_array($selectLeave)) {
        $leave = $row["leaveDay"];
    }
    $startMonth = $leave[0].$leave[1];
    $startDay = $leave[2].$leave[3];
    $overMonth = $leave[4].$leave[5];
    $overDay = $leave[6].$leave[7];
    $overMonth = intval($overMonth);
    $overDay = intval($overDay);
    if($leave == null) echo "no";
    else if($month>$overMonth || ($month==$overMonth && $day>$overDay)){
        $removeLeave = mysqli_query($con,"UPDATE appointment set leaveDay = null where 
        username = '{$username}'") or die("fail update leaveDay!");
        echo "no";
    }
    else if($month<$overMonth ||($month == $overMonth && $day <= $overDay)){
        $set=array();
        array_push($set,$startMonth);
        array_push($set,$startDay);
        array_push($set,$overMonth);
        array_push($set,$overDay);
        echo json_encode($set);
    }
    mysqli_close($con);
?>