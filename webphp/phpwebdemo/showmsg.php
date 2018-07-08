<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	error_reporting(0);
    require 'output.php';
    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		$phone=$_COOKIE['login'];
    		$mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
    		if(mysqli_connect_errno()){
    			$output->jsonyun(mysqli_connect_error(),400);
    		}
    		$sql="select `user_nickname` from user where `user_phone`='$phone'";
    		if($result=$mysqli->query($sql)){
    			$row=$result->fetch_array();
    		}else{
    			$info=$mysqli->error;
    			$mysqli->jsonyun($info,400);
    		}
            $sql="select `user_xyd` from user_xinyudu where `user_phone`='$phone'";
            if($result=$mysqli->query($sql)){
                $row=$result->fetch_array();
            }else{
                $info=$mysqli->error;
                $mysqli->jsonyun($info,400);
            }
    		$rs['xinyudu']=$row[0];
    		$sql="select `user_sex`,`user_birthday`,`user_area`,`user_qianming`,`user_img` from user_property where `user_phone`='$phone'";
    		if($result=$mysqli->query($sql)){
    			$row=$result->fetch_array();
    		}else{
    			$info=$mysqli->error;
    			$mysqli->jsonyun($info,400);
    		}
    		$rs['sex']=$row[0];
    		$rs['birthday']=$row[1];
    		$rs['area']=$row[2];
    		$rs['qianming']=$row[3];
    		$rs['img']=$row[4];
    		$rs['code']=200;
    		exit(json_encode($rs, JSON_UNESCAPED_UNICODE));
    	}else{
    		$info="您尚未登录";
    		$output->jsonyun($info,400);
    	}
    } catch (Exception $e) {
    	$output-new output();
    	$info=$e->getMessage();
    	$output->jsonyun($info,400);
    }

?>