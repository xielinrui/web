<?php 
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		if(isset($_POST['phone'])&&isset($_POST['xuehao'])&&isset($_POST['tongyi'])&&isset($_POST['name'])){
    			$mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
		    	if(mysqli_connect_errno()){
		    		$info=mysqli_connect_error();
		    		$output->jsonyun($info,400);
		    	}
			    $mysqli->autocommit(FALSE);
			    if($_COOKIE['login']!=$_POST['phone']){
	    			$info="电话号码错误";
	    			$mysqli->rollback();
	    			$mysqli->autocommit(TRUE);
	    			$mysqli->close();
	    			$output->jsonyun($info,400);
	    		}
	    		$phone=$_COOKIE['login'];
    			$sql="select count(*),`yanzheng_statu` from user_renzheng where `user_phone`='$phone'";
	            if($result=$mysqli->query($sql)){
	                $row=$result->fetch_array();
	    		}else{
	    			$info=$mysqli->error;
	    			$mysqli->rollback();
			    	$mysqli->autocommit(TRUE);
	    			$mysqli->close();
	    			$output->jsonyun($info,400);
	    			
	    		}

	    		$xuehao=$_POST['xuehao'];
	    		$tongyi=$_POST['tongyi'];
	    		$name=$_POST['name'];
	    		if($row[0]==0||$row[1]==0){
	    			if($row[0]==0){
	    				$sql="insert into user_renzheng(`user_phone`,`user_name`,`user_xuehao`,`user_tongyi`) values('$phone','$name','$xuehao','$tongyi')";
		    			$result=$mysqli->query($sql);
		    			if(!$result){
		    				$info=$mysqli->error;
		    				$mysqli->rollback();
					    	$mysqli->autocommit(TRUE);
					    	$mysqli->close();
		    				$output->jsonyun($info,400);
		    			}else{
		    				$info=$mysqli->error;
		    				$mysqli->commit();
		    				$mysqli->autocommit(TRUE);
		    				$info="您已成功提交申请，请耐心等待";
		    				$mysqli->close();
		    				$output->jsonyun($info,200);
		    				
		    			}
	    			}else{
	    				$mysqli->commit();
		    			$mysqli->autocommit(TRUE);
	    				$info="您已经提交认证申请，请勿重复提交。";
	    				$mysqli->close();
	    				$output->jsonyun($info,400);
	    				
	    			}
	    		}else{
	    			$mysqli->commit();
	    			$mysqli->autocommit(TRUE);
	    			$mysqli->close();
	    			$info="您已经通过实名认证,不用再次实名认证";
	    			$output->jsonyun($info,400);
	    		}
    		}
    	}else{
    		$info="您尚未登录，请重试";
    		$output->jsonyun($info,400);
    	}
    } catch (Exception $e) {
    	$mysqli->rollback();
    	$mysqli->autocommit(TRUE);
    	$output=new output();
    	$info=$e->getMessage();
    	$mysqli->close();
    	$output->jsonyun($info,400);
    	
    }
?>