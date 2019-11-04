<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    header("content-type:text/html;charset=utf-8");
    $username = $_POST['username'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    $y=mysqli_query($con,"SELECT * from doctorregist where username='$username'") or die('22');
    while($row=mysqli_fetch_array($y)){
        $dbidnumber=$row['idnumber'];
        $dbpassword = $row['password'];
        $dbname=$row['name'];
        $dbtel=$row['tel'];
        $dblevel="普通医生";
        $dbhospital=$row['hospital'];
        $dbdepartment=$row['department'];
    }
    $number=mysqli_query($con,"SELECT max(number) from user");
    $dbnumber=null;
    $set =array();
    while($row=mysqli_fetch_row($number)) {
        array_push($set, $row);
      }
    $dbnumber=$set[0][0]+1;
    $user = mysqli_query($con,"INSERT into user (username,password,permission,number) values
     ('{$username}','{$dbpassword}','doctor','{$dbnumber}')") or die("user error");
    $msg =mysqli_query($con,"INSERT into message 
    (tel,name,number,level,hospital,idnumber,department) values
     ('{$dbtel}','{$dbname}','{$dbnumber}','普通医生','{$dbhospital}','{$dbidnumber}','{$dbdepartment}')")
      or die("message err");
    $appointment = mysqli_query($con,"INSERT into appointment (username) values ('{$username}')") 
    or die("appintment error");
    echo "success";
    mysqli_close($con);
?>