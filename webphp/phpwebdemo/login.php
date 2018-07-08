<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    // header('Access-Control-Allow-Headers:*');
	//error_reporting(0);
    require 'output.php';
    try {
        $myfile1 = fopen("log.txt", "w") or die("Unable to open file!");
        fwrite($myfile1, json_encode($_POST));
        $txt="jiange:";
        fwrite($myfile1, $txt);
        $txt=json_encode($_GET);
        fwrite($myfile1, $txt);
        fclose($myfile1);
    	$output = new output();
        if(isset($_COOKIE['login'])){
    		$info="您已经登录";
    		$output->jsonyun($info,400);
    	}
    	if(isset($_POST['phone'])&&$_POST['password']){
    		$phone=$_POST['phone'];
    		$mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
	    	if(mysqli_connect_errno()){
	    		$info=mysqli_connect_error();
	    		$output->jsonyun($info,400);
	    	}
    		$sql="select count(*),`status` from tmp_register where `phone`='$phone'";
            if($result=$mysqli->query($sql)){
                $row=$result->fetch_array();
    		}else{
    			$info=$mysqli->error;
    			$output->jsonyun($info,400);
    		}
    		if($row[0]==0||$row[1]==0){
    			$info="您尚未注册，请注册后再登录";
    			$output->jsonyun($info,400);
    		}
            $sql="select count(*) from logintmp where `phone`='$phone'";
            if($result=$mysqli->query($sql)){
                $row=$result->fetch_array();
            }else{
                $info=$mysqli->error;
                $output->jsonyun($info,400);
            }
            if($row[0]==1){
                $info="您已经登录，如果确定没登录，请点击登录出现问题验证身份";
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
                $sql="insert into logintmp(`phone`) values('$phone')";
                $result=$mysqli->query($sql);
                if(!$result){
                    $info="登录失败，请重试";
                    $output->jsonyun($info,400);
                }
                setcookie("login","$phone",time()+24*3600*100000);
    			$info="登录成功";
    			$output->jsonyun($info,200);
    		}else{
    			$info="密码错误";
    			$output->jsonyun($info,400);
    		}
    	}
    } catch (Exception $e) {
    	$output=new output();
    	$info=$e->getMessage();
    	$output->jsonyun($info,400);
    }

?>
