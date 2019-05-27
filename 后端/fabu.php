<?php
//创建发布表
$arr=array();
$arr["openid"]= $_POST["openid"];
$arr["biaoti"]= $_POST["biaoti"];
$arr["neirong"]= $_POST["neirong"];
$arr["niming"]= $_POST["niming"];

$fbid=uniqid('',true);
$imgPath="NULL";
$code = $_FILES['file'];//获取小程序传来的图片
if(is_uploaded_file($_FILES['file']['tmp_name'])&&"empty.png"!=$_FILES['file']['name']) {  
    //把文件转存到你希望的目录（不要使用copy函数）  
    $uploaded_file=$_FILES['file']['tmp_name'];  
    //我们给每个用户动态的创建一个文件夹  
    $user_path=$_SERVER['DOCUMENT_ROOT']."/images";  
    //判断该用户文件夹是否已经有这个文件夹  
    if(!file_exists($user_path)) { 
        mkdir($user_path);  
    }  
 
    //$move_to_file=$user_path."/".$_FILES['file']['name'];  
    $file_true_name=$_FILES['file']['name']; 
	$imgPath=$fbid.substr($file_true_name,strrpos($file_true_name,"."));
    $move_to_file=$user_path."/".$imgPath;                                                                  //strrops($file_true,".")查找“.”在字符串中最后一次出现的位置  
    //echo "$uploaded_file   $move_to_file";  
    if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {  
       $arr["upload"]= "ok";
    } else { 
       $arr["upload"]= "fail";
    } 
} 

if($arr["openid"]){
	$con=mysqli_connect("localhost","s2442030","979249745","test"); 
	if(!$con){  
		echo'数据库打开失败'.mysqli_connect_error();
	} else{
		mysqli_query($con,"SET NAMES UTF8");
		$sql="create table if not exists fabu (fbid  varchar(30)  primary key , openid varchar(30),biaoti varchar(20) ,neirong varchar(200),niming bool ,fbtime datetime,imgPath varchar(50), praiseNum int default 0,commentNum int default 0,watchNum int default 0,foreign key(openid) references user(openid))character set = utf8";
		$arr["sql"]=$sql;
		mysqli_query($con,$sql);
		$datetime=date("Y-m-d H:i:s");
		$sql="INSERT INTO fabu(`fbid`, `openid`, `biaoti`, `neirong`, `niming`, `fbtime`,`imgPath`) VALUES ('".$fbid."','".$arr["openid"]."','".$arr["biaoti"]."','".$arr["neirong"]."',".$arr["niming"].",'".$datetime."','".$imgPath."')";
		
		mysqli_query($con,$sql);
		mysqli_close($con);
		$arr["sql"]=$sql;
	}
}

echo json_encode($arr,JSON_UNESCAPED_UNICODE);