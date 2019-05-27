<?php
//创建赞，评论，过客表，并插入数据，同时修改发布表的数据
$arr=array();
$arr["fbid"]= $_POST["fbid"];
$arr["openid"]= $_POST["openid"];
$arr["table"]= $_POST["table"];
$arr["content"]= $_POST["content"];
if($arr["openid"]){
	$con=mysqli_connect("localhost","s2442030","979249745","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		$sql="create table if not exists ".$arr["table"]." (".$arr["table"]."id  varchar(30) primary key ,fbid varchar(30), openid varchar(30),content varchar(200),cdate datetime,foreign key(fbid) references fabu(fbid),foreign key(openid) references user(openid))character set = utf8";
		//$arr["sql"]=$sql;
		mysqli_query($con,$sql);
		//只要不是评论表就不用再插入数据
		$bool=true;
		if("commentNum"!=$arr["table"]){
			$sql="select *from ".$arr["table"]." where openid='".$arr["openid"]."' and  fbid='".$arr["fbid"]."'";
			$result=mysqli_query($con,$sql);
			if(mysqli_fetch_assoc($result)){
				$bool=false;
			}
		}
		
		if($bool){
			$datetime=date("Y-m-d H:i:s");
			$sql="INSERT INTO ".$arr["table"]." VALUES ('".uniqid('',true)."','".$arr["fbid"]."','".$arr["openid"]."','".$arr["content"]."','".$datetime."')";
			mysqli_query($con,$sql);
			//修改发布表的数据
			$sql="SELECT ".$arr["table"]." FROM fabu WHERE fbid  like '".$arr["fbid"]."' ";
			$arr["sql"]=$sql;
			$result=mysqli_query($con,$sql);
			//得到评论数或赞数或看
			$row=mysqli_fetch_assoc($result);
			$row[$arr["table"]]++;
			$sql="update fabu set ".$arr["table"]."=".$row[$arr["table"]]." where fbid='".$arr["fbid"]."'";
			$arr["sql1"]=$sql;
			mysqli_query($con,$sql);
			mysqli_free_result($result);
		}
		mysqli_close($con);
		$arr["sql1"]=$sql;
	}
}
echo json_encode($arr);
?>