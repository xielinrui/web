<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	error_reporting(0);
    require 'output.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		$mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
    		if(mysqli_connect_errno()){
    			$output->jsonyun(mysqli_connect_error(),400);
    		}
    		if(isset($_FILES['myfile'])){
                if($_FILES['myfile']['error']>0){
                    $info=$_FILES['myfile']['errer'];
                    $output->jsonyun($info,400);
                    // exit();
                }
                $imgname = $_FILES['myfile']['name'];
                $tmp = $_FILES['myfile']['tmp_name'];
                $phone = $_COOKIE['login'];
                date_default_timezone_set("PRC");
                $day=date("Y-m-d-H-i-s");
                $filepath=$_SERVER['DOCUMENT_ROOT'].'/test/adminweb/photo/'.$phone.$day.'.jpg';//这里被限定死了其实不好，得获取它原本的后缀信息才是最好的
                $path='http://'.$_SERVER['HTTP_HOST'].'/test/adminweb/photo/'.$phone.$day.'.jpg';
                if(move_uploaded_file($tmp,$filepath)){
                    $sql="update user_property set user_img='$path' where user_phone='$phone'";
                    $result=$mysqli->query($sql);
                    if(!$result){
                    	$info=$mysqli->error;
                    	$output->jsonyun($info,400);
                    }else{
                    	$info="上传成功";
                    	$output->jsonyun($info,200);
                    }
                }else{
                    $info="上传失败,后台无法取得上传路径";
                    $output->jsonyun($info,400);
                }
            }
    	}else{
    		$info="您尚未登录，如果看到此页面请向后台管理员13452581923反映";
    		$output->jsonyun($info,400);
    	}
    } catch (Exception $e) {
    	$output=new output();
    	$info=$e->getMessage();
    	$output->jsonyun($info,400);
    }
?>
