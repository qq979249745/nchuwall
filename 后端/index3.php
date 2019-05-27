<?php
//$sql="update fabu set ping=1 where fbid=";
$arr=array();
$arr["fbid"]= $_POST["fbid"];
$arr["content"]= $_POST["content"];
if($arr["fbid"]){
	$con=mysqli_connect("localhost","s2442030","979249745","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		$sql="SELECT ".$arr["content"]." FROM fabu WHERE fbid  like '".$arr["fbid"]."' ";
		$arr["sql"]=$sql;
		$result=mysqli_query($con,$sql);
		
		$row=mysqli_fetch_assoc($result);
		$row[$arr["content"]]++;
		$sql="update fabu set ".$arr["content"]."=".$row[$arr["content"]]." where fbid='".$arr["fbid"]."'";
		$arr["sql1"]=$sql;
		mysqli_query($con,$sql);
		mysqli_free_result($result);
		mysqli_close($con);
		echo json_encode($arr,JSON_UNESCAPED_UNICODE);
	}
}

?>