<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	error_reporting(0);
    require 'output.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		if(isset($_POST['sex'])&&isset($_POST['birthday'])&&isset($_POST['area'])&&isset($_POST['qianming'])){
    			$mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    		if(mysqli_connect_errno()){
	    			$output->jsonyun(mysqli_connect_error(),400);
	    		}
    			$sex=$_POST['sex'];
    			$birthday=$_POST['birthday'];
    			$area=$_POST['area'];
    			$qianming=$_POST['qianming'];
    			$phone=$_COOKIE['login'];
    			$sql="update user_property set `user_sex`='$sex',`user_birthday`='$birthday',`user_area`='$area',`user_qianming`='$qianming' where `user_phone`='$phone'";
    			$result=$mysqli->query($sql);
    			if(!$result){
    				$info=$mysqli->error;
    				$output->jsonyun($info,400);
    			}else{
    				$info="完善成功";
    				$output->jsonyun($info,200);
    			}
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
