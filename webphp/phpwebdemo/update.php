<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';
    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		if(isset($_POST['nickname'])||isset($_POST['sex'])||isset($_POST['area'])||isset($_POST['qianming'])||isset($_POST['birthday'])){
	    		$mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    		if(mysqli_connect_errno()){
	    			$output->jsonyun(mysqli_connect_error(),400);
	    		}
	    		$phone=$_COOKIE['login'];
	    		$sql="select `user_nickname` from user where `user_phone`='$phone'";
	    		if($result=$mysqli->query($sql)){
	    			$row=$result->fetch_array();
	    		}else{
	    			$info="服务器错误，请联系后台管理员13452581923";
	    			$output->jsonyun($info,400);
	    		}
	    		$nickname=$row[0];
	    		$sql="select `user_sex`,`user_birthday`,`user_area`,`user_qianming` from user_property where `user_phone`='$phone'";
	    		if($result=$mysqli->query($sql)){
	    			$row=$result->fetch_array();
	    		}else{
	    			$info="服务器错误，请联系后台管理员13452581923";
	    			$output->jsonyun($info,400);
	    		}
	    		$sex=$row[0];
	    		$birthday=$row[1];
	    		$area=$row[2];
	    		$qianming=$row[3];
	    		if(isset($_POST['nickname'])&&($_POST['nickname']!="")){
	    			$nickname=$_POST['nickname'];
	    		}
	    		if(isset($_POST['qianming'])&&($_POST['qianming']!="")){
	    			$qianming=$_POST['qianming'];
	    		}
	    		if(isset($_POST['sex'])&&($_POST['sex']!="")){
	    			$sex=$_POST['sex'];
	    		}
	    		if(isset($_POST['birthday'])&&($_POST['birthday']!="")){
	    			$birthday=$_POST['birthday'];
	    		}
	    		if(isset($_POST['area'])&&($_POST['area']!="")){
	    			$area=$_POST['area'];
	    		}
	    		$sql="update user_property set `user_sex`='$sex',`user_birthday`='$birthday',`user_area`='$area',`user_qianming`='$qianming' where `user_phone`='$phone'";
	    		$result=$mysqli->query($sql);
	    		if(!$result){
	    			$info=$mysqli->error;
	    			$output->jsonyun($info,400);
	    		}
	    		$sql="update user set `user_nickname`='$nickname' where `user_phone`='$phone'";
	    		$result=$mysqli->query($sql);
	    		if(!$result){
	    			$info=$mysqli->error;
	    			$output->jsonyun($info,400);
	    		}
	    		$info="更新成功";
	    		$output->jsonyun($info,200);
    		}
    	}else{
    		$info="您尚未登录";
    		$output->jsonyun($info,400);
    	}
    } catch (Exception $e) {
    	$output=new output();
    	$info=$e->getMessage();
    	$output->jsonyun($info,400);
    }
?>
