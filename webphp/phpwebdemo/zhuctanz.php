<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	error_reporting(0);
    require 'output.php';
    require 'duanxin.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		$info="您已登录，不能进行短信注册";
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
//	    			var_dump($result);
	    			$row=$result->fetch_array();
//	    			var_dump($row);
	    		}else{
	    			$info=$mysqli->error;
	    			$output->jsonyun($info,400);
	    		}
	    		if($row[0]=='0'){
	    			$duanxin=new duanxin();
	    			$mobanhao=59199;
	    			$yanzhengma=$duanxin->faduanxin($phone,$mobanhao);
	    			if($yanzhengma==0){
	    				$info="发送失败，请稍后重试";
	    				$output->jsonyun($info,400);
	    			}else{
	    				$sql="insert into tmp_register(`phone`,`yanzhengma`) values('$phone','$yanzhengma')";
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
	    			$sql="select `status` from tmp_register where `phone`='$phone'";
	    			if($result=$mysqli->query($sql)){
	    				$row=$result->fetch_array();
	    			}else{
	    				$info=$mysqli->error;
	    				$output->jsonyun($info,400);
	    			}
	    			if($row['status']=='1'){
	    				$info="该电话已经注册了，不能继续进行注册";
	    				$output->jsonyun($info,400);
	    			}else{
	    				$duanxi = new duanxin();
	    				$mobanhao =59199;
	    				$yanzhengma = $duanxi->faduanxin($phone,$mobanhao);
	    				if($yanzhengma==0){
	    					$info="发送失败，请稍后重试";
	    					$output->jsonyun($info,400);
	    				}else{
	    					$sql="update tmp_register set `yanzhengma`='$yanzhengma' where `phone`='$phone'";
	    					$result=$mysqli->query($sql);
	    					if(!$result){
	    						$info=$mysqli->error;
	    						$output->jsonyun($info,400);
	    					}else{
	    						$info="发送成功，请填写验证码表单，如果没有收到短信，请联系后台管理员13452581923";
	    						$output->jsonyun($info,200);
	    					}
	    				}
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
