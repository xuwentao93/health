<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    $username=$_POST['username'];
    $password=$_POST['password'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $y=mysqli_query($con,"SELECT * from user where username = '{$username}'") or die(22);
    $dbusername=null;
    $dbpassword=null;
    $permission=null;
    while($row=mysqli_fetch_array($y)){
        $dbusername=$row['username'];
        $dbpassword=$row['password'];
        $permission=$row['permission'];
    }
    if($password != $dbpassword){
    echo json_encode('wrong');
    }
    else{
        echo json_encode([$username,$permission]);
    }
?>





