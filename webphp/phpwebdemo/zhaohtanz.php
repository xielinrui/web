<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';
    require 'duanxin.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		$info="您已登录，不能进行短信找回密码";
    		$output->jsonyun($info,400);
    	}else{
    		
			$mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    	if(mysqli_connect_errno()){
	    		$info=mysqli_connect_error();
	    		$output->jsonyun($info,400);
	    	}
	    	if(isset($_POST['phone'])){
	    		$phone=$_POST['phone'];
	    		$sql="select count(*) from tmp_register where `phone`='$phone'";
	    		if($result=$mysqli->query($sql)){
	    			$row=$result->fetch_array();
	    		}else{
	    			$info=$mysqli->error;
	    			$output->jsonyun($info,400);
	    		}
	    		if($row[0]=='0'){
	    			$info="该手机号尚未注册，请直接注册";
	    			$output->jsonyun($info,400);
	    		}else{
	    			$sql="select `status` from tmp_register where `phone`='$phone'";
	    			if($result=$mysqli->query($sql)){
	    				$row=$result->fetch_array();
	    			}else{
	    				$info=$mysqli->error;
	    				$output->jsonyun($info,400);
	    			}
	    			if($row['status']=='1'){
	    				$duanxin=new duanxin();
		    			$mobanhao=60414;
		    			$yanzhengma=$duanxin->faduanxin($phone,$mobanhao);
		    			if($yanzhengma==0){
		    				$info="发送失败，请稍后重试";
		    				$output->jsonyun($info,400);
		    			}else{
		    				$sql="update tmp_register set `findmima`='$yanzhengma' where `phone`='$phone'";
		    				$result=$mysqli->query($sql);
		    				if(!$result){
		    					$info=$mysqli->error;
		    					$output->jsonyun($info,400);
		    				}else{
		    					$info="发送成功，请填写验证码表单，如果没有收到短信，请联系后台管理员13452581923";
		    					$output->jsonyun($info,200);
		    				}
		    			}
	    			}else{
	    				$info="该手机号尚未注册，请直接注册";
	    				$output->jsonyun($info,400);
	    			}
	    		}
	    	}
    	}
    	
    } catch (Exception $e) {
    	$output=new output();
    	$info=$e->getMessage();
    	$output->jsonyun($info,400);
    }
?>
