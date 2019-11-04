<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");
    $username = $_POST['username'];
    $password = $_POST["password"];
    $permission = $_POST['permission'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $number=mysqli_query($con,"SELECT max(number) from user");
    $dbnumber=null;
    $set =array();
    while($row=mysqli_fetch_row($number)) {
        array_push($set, $row);
      }
    $dbnumber=$set[0][0]+1;
    $user = mysqli_query($con,"INSERT into user (username,password,permission,number) values
     ('{$username}','{$password}','custom','{$dbnumber}')") or die("user error");
    echo $dbnumber;
    mysqli_close($con);
?>