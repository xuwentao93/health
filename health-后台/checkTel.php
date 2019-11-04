<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    $tel=$_POST['tel'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $y=mysqli_query($con,"SELECT tel from message where tel ='$tel'") or die(22);
    $dbtel=null;
    while($row=mysqli_fetch_array($y)){
        $dbtel=$row['tel'];
    }
    if($tel == $dbtel){
    echo json_encode('该手机号已被注册');
    }
    else echo "";
?>




