<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");
    $doctor = $_POST['doctor'];
    $page = $_POST['page'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $connectHealth=mysqli_select_db($con,'health') or die('11');
    $selectURL=mysqli_query($con,"SELECT url from sick where doctor ='{$doctor}';") or die('插入病人表失败');
    $url =array();
    while($row=mysqli_fetch_row($selectURL)) {
        array_push($url, $row);
    }
    $openSick=array();
    $readSick=array();
    for($i=0;$i<count($url);$i++){
        $doctorURL = "doctor/".$url[$i][0];
        $openSick[$i] = fopen($doctorURL,"r") or die("Unabel to open file!");
        $readSick[$i] =fread($openSick[$i],1000000);
    }
    $pageSize = ceil(count($readSick) / 2);
    $pageSick = array();
    array_push($pageSick, $readSick[$page*2]);
    array_push($pageSick, $readSick[$page*2 + 1]);
    array_push($pageSick,$pageSize);
    echo json_encode($pageSick);
    mysqli_close($con);
?>