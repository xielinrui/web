<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		$info="您已经登录了，不能进行此项工作，如果看见了这个页面，请提交给后台管理员13452581923";
    		$output->jsonyun($info,400);
	    }
	    if(isset($_POST['yanzhengma'])&&isset($_POST['password'])&&isset($_POST['phone'])){
	    	$mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    	if(mysqli_connect_errno()){
	    		$info=mysqli_connect_error();
	    		$output->jsonyun($info,400);
	    	}
	    	$phone=$_POST['phone'];
	    	$sql="select count(*),`status`,`findmima` from tmp_register where `phone`='$phone'";
	    	if($result=$mysqli->query($sql)){
	    		$row=$result->fetch_array();
	    	}else{
	    		$info="服务器错误，请重试";
	    		$output->jsonyun($info,400);
	    	}
	    	if($row[0]==0||$row[1]==0){
	    		$info="您尚未注册，请重试";
	    		$output->jsonyun($info,400);
	    	}
	    	$yanzhengma=$_POST['yanzhengma'];
	    	if($row[2]==$yanzhengma){
	    		$password=md5($_POST['password']);
	    		$sql="update `user` set `user_password`='$password' where `user_phone`='$phone'";
	    		$result=$mysqli->query($sql);
	    		if(!$result){
	    			$info="修改失败，服务器崩了";
	    			$output->jsonyun($info,400);
	    		}else{
	    			
	    			$info="修改成功";
	    			$output->jsonyun($info,200);
	    		}
	    	}else{
	    		$info="验证码错误,请重试.";
	    		$output->jsonyun($info,400);
	    	}
    	}
    } catch (Exception $e) {
    	$output=new output();
    	$info=$e->getMessage();
    	$output->jsonyun($output);
    }
?>
