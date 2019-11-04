<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    $name=$_POST['name'];
    $id=$_POST['id'];
    $tel = $_POST['tel'];
    $number = $_POST['number'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $y=mysqli_query($con,"INSERT into message (name,idnumber,tel,number) values ('{$name}','{$id}','{$tel}','{$number}');") or die('22');
     echo json_encode("success");
?>




