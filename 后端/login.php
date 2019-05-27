<?php
//创建用户表
$openid=$_POST["openid"];
$avatarUrl=$_POST["avatarUrl"];
$nickName=$_POST["nickName"];
$gender=$_POST["gender"];
$arr=array();
if($openid){
	$con=mysqli_connect("localhost","s2442030","979249745","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		$sql="create table if not exists  user(openid varchar(30) primary key,cdatetime datetime, ddatetime datetime,avatarUrl varchar(150), nickName varchar(20),gender int) character set = utf8";
		mysqli_query($con,$sql);
		
		$datetime=date("Y-m-d H:i:s");
		$arr["date"]=$datetime;
		$sql="select * from user where openid='".$openid ."'";
		
		$result=mysqli_query($con,$sql);
		$arr["sql"]=$sql;
		
		$result=mysqli_fetch_assoc($result);
		$arr["result"]=$result;
		if($result!=null){
			$sql="UPDATE  user SET  ddatetime =  '".$datetime."' , avatarUrl='".$avatarUrl."' ,nickName='".$nickName."',gender=".$gender."  WHERE  openid='".$openid."'";
			mysqli_query($con,$sql);
			echo json_encode($result);
		}else{
			$sql="insert into user values('".$openid."' ,'".$datetime."',  '".$datetime."','".$avatarUrl."','".$nickName."',".$gender.")";
			mysqli_query($con,$sql);
			$arr["sql1"]=$sql;
			echo json_encode($arr);
		}
	mysqli_free_result($r);
	mysqli_close($con);
	}
	
}
else{
	$arr["openid"]=$openid;
	$arr["avatarUrl"]=$avatarUrl;
	$arr["nickName"]=$nickName;
	$arr["gender"]=$gender;
	echo json_encode($arr);
}
	
?>