<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	error_reporting(0);
    require 'output.php';

    try{
    	$output = new output();
		if(isset($_COOKIE['login'])){
	    	$info="您已经登录了，尚不能进行注册";
	    	$output->jsonyun($info,400);
	    }else{
	    	if(isset($_POST['yanzhengma'])&&isset($_POST['phone'])){
	    		$mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    		if(mysqli_connect_errno()){
	    			$output->jsonyun(mysqli_connect_error(),400);
	    		}
	    		$phone=$_POST['phone'];
	    		$sql="select `yanzhengma` from tmp_register where `phone`='$phone'";
	    		if($result=$mysqli->query($sql)){
	    			$row=$result->fetch_array();
	    		}else{
	    			$output->jsonyun($mysqli->error,400);
	    		}
	    		$yanzhengma=$_POST['yanzhengma'];
	    		if($row['yanzhengma']!=$yanzhengma){
	    			$info="您的验证码不正确";
	    			$output->jsonyun($info,400);
	    		}else{
	    			$nickname=$_POST['nickname'];
	    			$password=md5($_POST['password']);
	    			$sql="insert into user(`user_phone`,`user_nickname`,`user_password`) values('$phone','$nickname','$password')";
	    			$result=$mysqli->query($sql);
	    			if(!$result){
	    				$output->jsonyun($mysqli->error,400);
	    			}else{
	    				$flag=1;
	    				$sql="update tmp_register set `status`='$flag' where `phone`='$phone'";
	    				$result=$mysqli->query($sql);
	    				if(!$result){
	    					$output->jsonyun($mysqli->error,400);
	    				}else{
	    					$sql="insert into user_property(`user_phone`) values('$phone')";
	    					$mysqli->query($sql);
	    					$sql="insert into user_xinyudu(`user_phone`) values('$phone')";
	    					$mysqli->query($sql);
	    					$info="注册成功";
	    					$output->jsonyun($info,200);
	    				}
	    			}
	    		}
	    	}
	    }
    }catch(Exception $e){
	    $output->jsonyun($e->getMessage(),400);
    }
?>
