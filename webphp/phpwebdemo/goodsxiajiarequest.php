<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/24
 * Time: 0:21
 */
header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
//error_reporting(0);
require_once 'DataUtil.php';
require 'output.php';
if(isset($_COOKIE['login'])){
    $output=new output();
    $phone = $_COOKIE['login'];
    if(isset($_POST['goodsid'])){
        $goodsid  = $_POST['goodsid'];
        $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
        if(mysqli_connect_errno()){
            $output->jsonyun(mysqli_connect_error(),400);
        }
        $sql = "update `goods` set `goods_status`='-1' WHERE `user_phone`='$phone' AND `goods_status`='1' AND `goods_id`='$goodsid'";
        $result = $mysqli->query($sql);
        if(!$result){
            $info=$mysqli->error;
            $output->jsonyun($info,400);
        }else{
            $info="下架成功";
            $output->jsonyun($info,200);
        }
    }else{
        $info = "参数不足";
        $output->jsonyun($info,400);
    }
}