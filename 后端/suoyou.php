<?php
$arr=array();
$arr["openid"]= $_POST["openid"];
$arr["fbid"]= $_POST["fbid"];
$arr["self"]=$_POST["self"];
$arr["start"]=$_POST["start"];
$arr["end"]=$_POST["end"];

if($arr["openid"]){
	$con=mysqli_connect("localhost","s2442030","979249745","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		//先创建赞表
		$sql="create table if not exists praiseNum (praiseNumid  varchar(30) primary key ,fbid varchar(30), openid varchar(30),content varchar(200),cdate datetime,foreign key(fbid) references fabu(fbid),foreign key(openid) references user(openid))character set = utf8";
		mysqli_query($con,$sql);
		//$sql=" select * from (select * from fabu,user where fabu.openid=user.openid and  fbid  like '".$arr["fbid"]."' and fabu.openid like '".$arr["openid"]."' )as a left join (select fbid,content from praiseNum where openid='".$arr["self"]."')as b  on a.fbid=b.fbid order by a.fbtime desc";
		$sql="select a.fbid, a.openid, a.biaoti, a.neirong, a.niming, a.fbtime,a.imgPath, a.praiseNum, a.commentNum, a.watchNum,a.content,b.avatarUrl, b.nickName, b.gender from(select a.fbid, a.openid, a.biaoti, a.neirong, a.niming, a.fbtime,a.imgPath, a.praiseNum, a.commentNum, a.watchNum,b.content from (select fbid, openid, biaoti, neirong, niming, fbtime,imgPath, praiseNum, commentNum, watchNum from fabu where fbid  like '".$arr["fbid"]."' and openid like '".$arr["openid"]."' order by fbtime desc limit ".$arr["start"].",".$arr["end"].")as a left join (select fbid,content from praiseNum where openid='".$arr["self"]."')as b  on a.fbid=b.fbid)as a,user as b where a.openid=b.openid   ";
		//$sql="SELECT * FROM fabu,user WHERE fabu.openid=user.openid and  fbid  like '".$arr["fbid"]."' and fabu.openid like '".$arr["openid"]."' order by fbtime desc ";
		$result=mysqli_query($con,$sql);
		$arr1=array();
		//$arr1["sql"]=$sql;
		$i=1;
		while($row=mysqli_fetch_assoc($result)){
			$arr1[$i++]=$row;
		}
		$arr1["length"]=--$i;
		mysqli_free_result($result);
		mysqli_close($con);
		echo json_encode($arr1,JSON_UNESCAPED_UNICODE);
	}
}