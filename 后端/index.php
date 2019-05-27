
<?php
header("content-type:text/html;charset=utf-8"); 
$con=mysqli_connect("localhost","s2442030","979249745","test"); 

  
  if(!$con){  
    echo'数据库打开失败'.mysqli_connect_error()."<br/>";
  } else{
    //echo'数据库打开成功';
	mysqli_query($con,"SET NAMES UTF8");
  }
  
  //$sql="INSERT INTO `test` (`id`, `name`) VALUES ('11', '张三')";
  //mysqli_query($con,$sql);
  $sql="select * from test ";
  $r=mysqli_query($con,$sql);


$row=mysqli_fetch_array($r);
	    echo "id=".$row["id"];
		echo "name=".$row["name"];

  
  mysqli_free_result($r);
  mysqli_close($con);
?>

