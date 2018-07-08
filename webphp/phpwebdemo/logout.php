<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
            $mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
            if(mysqli_connect_errno()){
                $info=mysqli_connect_error();
                $output->jsonyun($info,400);
            }
            $phone=$_COOKIE['login'];
            $sql="delete from logintmp where `phone`='$phone'";
            $result=$mysqli->query($sql);
            if(!$result){
                $info="登出失败，请重试";
                $output->jsonyun($info,400);
            }
            setcookie("login","123",time()-3600);
			$info="登出成功";
			$output->jsonyun($info,200);    		
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