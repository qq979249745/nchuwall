<?php
$arr=array();
$user= $_POST["user"];
$imgPath=NUll;
$fbid=uniqid('',true);
$code = $_FILES['file'];//获取小程序传来的图片
if(is_uploaded_file($_FILES['file']['tmp_name'])) {  
    //把文件转存到你希望的目录（不要使用copy函数）  
    $uploaded_file=$_FILES['file']['tmp_name'];  
	$arr["uploaded_file"]= $uploaded_file;
    //我们给每个用户动态的创建一个文件夹  
    $user_path=$_SERVER['DOCUMENT_ROOT']."/images";  
	$arr["user_path"]= $user_path;
    //判断该用户文件夹是否已经有这个文件夹  
    if(!file_exists($user_path)) {  
        mkdir($user_path);  
    }  
 
    //$move_to_file=$user_path."/".$_FILES['file']['name'];  
    $file_true_name=$_FILES['file']['name'];  
	$arr["file_true_name"]= $file_true_name;
	$imgPath=$fbid.substr($file_true_name,strrpos($file_true_name,"."));
    $move_to_file=$user_path."/".$imgPath;//strrops($file_true,".")查找“.”在字符串中最后一次出现的位置  
    //echo "$uploaded_file   $move_to_file";  
	$arr["move_to_file"]= $move_to_file;
    if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {  
       $arr["upload"]= "ok";
	   $arr["user"]=$user;
	   echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    } else {  
       $arr["upload"]= "fail";
    }  
} 
