<?php
	header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
	//error_reporting(0);
    require 'output.php';

    try {
    	$output=new output();
    	if(isset($_COOKIE['login'])){
    		$mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
    		if(mysqli_connect_errno()){
    			$output->jsonyun(mysqli_connect_error(),400);
    		}
    		$mysqli->autocommit(FALSE);
    		if(isset($_FILES['myfile'])){
            	
                if($_FILES['myfile']['error']>0){
                    $info=$_FILES['myfile']['errer'];
    				$mysqli->autocommit(TRUE);
    				$mysqli->close();
                    $output->jsonyun($info,400);
                    // exit();
                }
                $imgname = $_FILES['myfile']['name'];
                $tmp = $_FILES['myfile']['tmp_name'];
                $phone = $_COOKIE['login'];
                date_default_timezone_set("PRC");
                $day=date("Y-m-d-H-i-s");
                $filepath=$_SERVER['DOCUMENT_ROOT'].'/test/adminweb/local/'.$phone.$day.'.jpg';//这里被限定死了其实不好，得获取它原本的后缀信息才是最好的
                $path='http://'.$_SERVER['HTTP_HOST'].'/test/adminweb/local/'.$phone.$day.'.jpg';
                if(move_uploaded_file($tmp,$filepath)){
                    $sql="update user_renzheng set `user_yikatong`='$path' where user_phone='$phone'";
                    $result=$mysqli->query($sql);
                    if(!$result){
                    	$info=$mysqli->error;
                    	$mysqli->rollback();
				    	$mysqli->autocommit(TRUE);
				    	$mysqli->close();
                    	$output->jsonyun($info,400);
                    }else{
                    	$info="上传成功";
                    	$mysqli->commit();
                    	$mysqli->autocommit(TRUE);
				    	$mysqli->close();
                    	$output->jsonyun($info,200);
                    }
                }else{
                	$mysqli->rollback();
			    	$mysqli->autocommit(TRUE);
			    	$mysqli->close();
                    $info="上传失败,后台无法取得上传路径";
                    $output->jsonyun($info,400);
                }
            }
    	}else{
    		$info="您尚未登录";
    		$output->jsonyun($info,400);
    	}
    } catch (Exception $e) {
    	$output=new output();		    	
    	$info=$e->getMessage();
    	$mysqli->rollback();
		$mysqli->autocommit(TRUE);
    	$mysqli->close();
    	$output->jsonyun($info,400);
    }
?>
