<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';

    try {
    	$output = new output();
//        if(isset($_COOKIE['login'])){
//    		$info="您已经登录";
//    		$output->jsonyun($info,400);
//    	}
    	if(isset($_POST['phone'])&&$_POST['password']){
    		$phone=$_POST['phone'];
//    		$yanzhengma=$_POST['yanzhengma'];
    		$mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    	if(mysqli_connect_errno()){
	    		$info=mysqli_connect_error();
	    		$output->jsonyun($info,400);
	    	}
    		$sql="select count(*),`status` from tmp_register where `phone`='$phone'";
            if($result=$mysqli->query($sql)){
                $row=$result->fetch_array();
    		}else {
                $info = $mysqli->error;
                $output->jsonyun($info, 400);
            }
//            if($row[2]!=$yanzhengma){
//            	$info="验证码错误，请重新输入验证码";
//            	$output->jsonyun($info,400);
//			}
    		if($row[0]==0||$row[1]==0){
    			$info="您尚未注册，请注册后再登录";
    			$output->jsonyun($info,400);
    		}
    		$sql="select `user_password` from user where `user_phone`='$phone'";
    		if($result=$mysqli->query($sql)){
    			$row=$result->fetch_array();
    		}else{
    			$info=$mysqli->error;
    			$output->jsonyun($info,400);
    		}
    		$password=md5($_POST['password']);
    		if($password==$row[0]){
                $sql="select count(*) from logintmp where `phone`='$phone'";
            	if($result=$mysqli->query($sql)){
                	$row=$result->fetch_array();
            	}else{
                	$info=$mysqli->error;
                	$output->jsonyun($info,400);
           	    }
            	if($row[0]==1){
                	$sql="delete from logintmp where `phone`='$phone'";
		            $result=$mysqli->query($sql);
		            if(!$result){
		                $info="验证失败，请重试";
		                $output->jsonyun($info,400);
		            }else{
                        setcookie("login","123",time()-3600);
		            	$info="验证成功，您可以重新尝试登录";
		            	$output->jsonyun($info,200);
		            }
		        }else{
                    setcookie("login","123",time()-3600);
		        	$info="验证成功，您可以重新尝试登录";
		        	$output->jsonyun($info,200);
		        }
    		}else{
    			$info="密码错误，验证失败";
    			$output->jsonyun($info,400);
    		}
    	}
    } catch (Exception $e) {
    	$output=new output();
    	$info="验证失败，请重试";
    	$output->jsonyun($info,400);
    }

?>
