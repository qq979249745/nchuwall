<?php
////返回赞，评论，过客表中的数据
$arr=array();
$arr["fbid"]= $_POST["fbid"];
$arr["table"]= $_POST["table"];

if($arr["fbid"]){
	$con=mysqli_connect("localhost","s2442030","979249745","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		$sql="SELECT * FROM ".$arr["table"].",(select openid, avatarUrl,nickName,gender from user ) as a WHERE ".$arr["table"].".openid=a.openid and fbid='".$arr["fbid"]."'";
		$arr["sql"]=$sql;
		$result=mysqli_query($con,$sql);

		$arr1=array();
		$i=1;
		while($row=mysqli_fetch_assoc($result)){
			$arr1[$i++]=$row;
		}
		mysqli_free_result($result);
		mysqli_close($con);
		echo json_encode($arr1,JSON_UNESCAPED_UNICODE);
	}
}

?>