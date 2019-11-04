<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    $username=$_POST['username'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $y=mysqli_query($con,"SELECT username from user where username ='$username'") or die(22);
    $dbusername=null;
    while($row=mysqli_fetch_array($y)){
        $dbusername=$row['username'];
    }
    if($username == $dbusername){
    echo json_encode('用户名已存在');
    }
    else echo $dbusername;
?>





