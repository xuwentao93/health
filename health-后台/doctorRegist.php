<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");
    $username=$_POST['username'];
    $password=$_POST['password'];
    $name=$_POST['name'];
    $id=$_POST['id'];
    $tel=$_POST['tel'];
    $hospital=$_POST['hospital'];
    $department=$_POST['department'];
    $level=$_FILES['level'];
    echo json_encode($level);
    $url=$_POST["url"]; 
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $doctorRegist=mysqli_query($con,"INSERT into doctorregist 
    (username,password,name,idnumber,tel,hospital,level,department) values
    ('{$username}','{$password}','{$name}','{$id}','{$tel}','{$hospital}','{$url}','{$department}');")
    or die('22');
    move_uploaded_file($_FILES["level"]["tmp_name"],
    "./img/" . $_FILES["level"]["name"]) or die("img saved failed!");
    echo "success";
    mysqli_close($con);
?>