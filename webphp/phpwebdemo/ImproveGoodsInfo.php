<?php
header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
error_reporting(0);
require 'output.php';

try {
    $output=new output();
    if(isset($_COOKIE['login'])){
        if(isset($_POST['goodsid'])&&isset($_POST['goodsname'])&&isset($_POST['typename'])&&isset($_POST['ershousell'])&&isset($_POST['descrition'])&&isset($_POST['chuzumoney'])){
            $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
            if(mysqli_connect_errno()){
                $output->jsonyun(mysqli_connect_error(),400);
            }
            $goodsid = $_POST['goodsid'];
            $goodsname = $_POST['goodsname'];
            $typename = $_POST['typename'];
            $ershousell = $_POST['ershousell'];
            $chuzumoney = $_POST['chuzumoney'];
            $ershousellmoney = $_POST['chuzumoney'];
            $description =$_POST['descrition'];
            $phone=$_COOKIE['login'];
            date_default_timezone_set("PRC");
            $uploadtime = date("Y-m-d-H-i-s");
            $sql="update goods set `goods_name`='$goodsname',`ershou_sell`='$ershousell',`ershou_sell_money`='$ershousellmoney',`goods_description`='$description',`upload_time`='$uploadtime',`chuzu_money`='$chuzumoney' WHERE `goods_id`='$goodsid' AND `goods_status`='-1' ";
            $result=$mysqli->query($sql);
            if(!$result){
                $info=$mysqli->error;
                $output->jsonyun($info,400);
            }else{
                $info="更新成功";
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
