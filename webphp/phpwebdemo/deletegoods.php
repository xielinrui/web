<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
error_reporting(0);
require 'output.php';

try {
    $output=new output();
    if(isset($_COOKIE['login'])){
        if(isset($_POST['goodsid'])){
            $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
            if(mysqli_connect_errno()){
                $output->jsonyun(mysqli_connect_error(),400);
            }
            $goodsid = $_POST['goodsid'];
            $phone=$_COOKIE['login'];
            date_default_timezone_set("PRC");
            $uploadtime = date("Y-m-d-H-i-s");
            $sql="delete from `goods` WHERE `goods_id`='$goodsid' AND `user_phone`='$phone'";
            $result=$mysqli->query($sql);
            if(!$result){
                $info=$mysqli->error;
                $output->jsonyun($info,400);
            }else{
                $info="删除成功";
                $output->jsonyun($info,200);
            }
        }
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
