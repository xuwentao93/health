<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");
    $name = $_POST['name'];
    $username= $_POST['username'];
    $conclusion = $_POST['conclusion'];
    $doctor = $_POST['doctor'];
    $illness = $_POST['illness'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    
    $url=$username.$year.$mouth.$day.$hour.$minute.".txt";
    $fileCustom=fopen("custom/$url","w") or die("新建文件失败");
    $txt = "时间：".$year."/".$month."/".$day."   ".$hour.":".$minute."   &nbsp&nbsp&nbsp主治医生：".$doctor."\r\n<br/>";
    $txt = $txt."病情：$illness\r\n<br/>";
    for($i=0;$i<count($conclusion);$i++){
        if(!$conclusion[$i][name]) continue;
        $txt = $txt."药名：".$conclusion[$i][name]."   &nbsp&nbsp&nbsp用量：".$conclusion[$i][dosage];
        $txt = $txt."   &nbsp&nbsp&nbsp次数: ".$conclusion[$i][time]."   &nbsp&nbsp&nbsp单价：".$conclusion[$i][price];
        $txt = $txt."   &nbsp&nbsp&nbsp数量：".$conclusion[$i][number]."  &nbsp&nbsp&nbsp总价：".$conclusion[$i][mount]."\r\n<br/>";
    }
    fwrite($fileCustom,$txt);

    $fileDoctor=fopen("doctor/$url","w") or die("新建文件失败");
    $txt2 = "时间：".$year."/".$month."/".$day."   ".$hour.":".$minute."   &nbsp&nbsp&nbsp病人：".$name."\r\n<br/>";
    $txt2 = $txt2."   &nbsp&nbsp&nbsp病情：$illness\r\n<br/>";
    for($i=0;$i<count($conclusion);$i++){
        if(!$conclusion[$i][name]) continue;
        $txt2 = $txt2."药名：".$conclusion[$i][name]."   &nbsp&nbsp&nbsp用量：".$conclusion[$i][dosage];
        $txt2 = $txt2."   &nbsp&nbsp&nbsp次数: ".$conclusion[$i][time]."   &nbsp&nbsp&nbsp单价：".$conclusion[$i][price];
        $txt2 = $txt2."   &nbsp&nbsp&nbsp数量：".$conclusion[$i][number]."  &nbsp&nbsp&nbsp总价：".$conclusion[$i][mount]."\r\n<br/>";
    }
    fwrite($fileDoctor,$txt2);

     $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
     $connectHealth=mysqli_select_db($con,'health') or die('11');
    $insertSick=mysqli_query($con,"INSERT into sick (custom,doctor,url) values 
    ('{$username}','{$doctor}','{$url}');") or die('插入病人表失败');

    $deleteCheck = mysqli_query($con,"DELETE from customCheck where username = '{$username}'")
    or die("deleteCheck failed!");
    $selectNumber = mysqli_query($con,"SELECT number from user where username = '{$username}'")
    or die("selectUser failed!");
    $row = mysqli_fetch_array($selectNumber);
    $number = $row['number'];
    $selectTime = mysqli_query($con,"SELECT time from appointment where username
    = '{$doctor}'") or die("selectTime wrong!");
    $row = mysqli_fetch_array($selectTime);
    $time = $row['time'];

    $dbtime = array();
    $length = strlen($time) / 21;
    for($i=0;$i<$length;$i++){
        if($number == substr($time, $i * 21 + 15, 6)){
            $dbtime = substr($time, 0, $i * 21).substr($time, $i * 21 + 21);
            break;
        }
    }
    $updateTime = mysqli_query($con,"UPDATE appointment set time = '{$dbtime}' where
    username = '{$doctor}'") or die("22");
    mysqli_close($con);
    echo json_encode($dbtime);
?>