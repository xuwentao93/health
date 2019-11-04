<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
    $username=$_POST['user'];
    $con=mysqli_connect('localhost','root','3b19d1576d') or die('数据库连接失败');
    $x=mysqli_select_db($con,'health') or die('11');
    //$z=mysqli_query($con,"SELECT number from ")
    $y=mysqli_query($con,"SELECT idnumber,name,tel,level,hospital,department from message left join user
    on message.number = user.number where user.username = '{$username}'") or die("22");
    $dbidnumber=null;
    $dbname=null;
    $dbtel=null;
    $dblevel=null;
    $dbhospital=null;
    $dbdepartment = null;
    while($row=mysqli_fetch_array($y)){
        $dbidnumber=$row['idnumber'];
        $dbname=$row['name'];
        $dbtel=$row['tel'];
        $dblevel=$row['level'];
        $dbhospital=$row['hospital'];
        $dbdepartment = $row['department'];
    }
        if($dblevel == null) echo json_encode([$dbidnumber,$dbname,$dbtel]);
        else echo json_encode([$dbidnumber,$dbname,$dbtel,$dblevel,$dbhospital,$dbdepartment]);
?>





