<?php
$arr=array();
$arr["fbid"]= $_POST["fbid"];
if($arr["fbid"]){
	$con=mysqli_connect("localhost","root","root","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		//$sql=" select * from (select * from fabu,user where fabu.openid=user.openid and  fbid  like '".$arr["fbid"]."' and fabu.openid like '".$arr["openid"]."' )as a left join (select fbid,content from praiseNum where openid='".$arr["self"]."')as b  on a.fbid=b.fbid order by a.fbtime desc";
		$sql="delete from praiseNum where fbid='".$arr["fbid"]."'";
		mysqli_query($con,$sql);
		$sql="delete from watchNum where fbid='".$arr["fbid"]."'";
		mysqli_query($con,$sql);
		$sql="delete from commentNum where fbid='".$arr["fbid"]."'";
		mysqli_query($con,$sql);
		$sql="delete from fabu where fbid='".$arr["fbid"]."'";
		//$sql="SELECT * FROM fabu,user WHERE fabu.openid=user.openid and  fbid  like '".$arr["fbid"]."' and fabu.openid like '".$arr["openid"]."' order by fbtime desc ";
		mysqli_query($con,$sql);
		
		mysqli_close($con);
		echo json_encode($arr,JSON_UNESCAPED_UNICODE);
	}
}
?>