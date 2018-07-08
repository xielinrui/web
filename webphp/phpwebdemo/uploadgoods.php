<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/23
 * Time: 15:10
 */

    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    //error_reporting(0);

    require 'output.php';
    require_once 'DataUtil.php';
    if(isset($_COOKIE['login'])){
        $output = new output();
        $phone = $_COOKIE['login'];
        if (isset($_POST['goodsname']))$goodsname = $_POST['goodsname'];
        if (isset($_POST['typename']))$typename = $_POST['typename'];
        if (isset($_POST['ershousell']))$ershousell = $_POST['ershousell'];
        if (isset($_POST['chuzumoney']))$ershousellmoney = $_POST['chuzumoney'];
        if (isset($_POST['descrition']))$descrition = $_POST['descrition'];
        if (isset($_POST['chuzumoney']))$chuzumoney = $_POST['chuzumoney'];
        date_default_timezone_set("PRC");
        $uploadtime = date("Y-m-d-H-i-s");
        $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
        if(mysqli_connect_errno()){
            $output->jsonyun(mysqli_connect_error(),400);
        }
        $typeid = DataUtil::typeNameToId($typename);
        if($typeid==0){
            $info = "失败";
            $output->jsonyun($info,400);
        }
        $sql = "insert into goods(`goods_name`,`type_id`,`ershou_sell`,`ershou_sell_money`,`user_phone`,`goods_description`,`upload_time`,`chuzu_money`) values('$goodsname','$typeid','$ershousell','$ershousellmoney','$phone','$descrition','$uploadtime','$chuzumoney') ";
        $result=$mysqli->query($sql);
        if(!$result){
            $info = $mysqli->error;
//            $mysqli->autocommit(true);
            $mysqli->close();
            $output->jsonyun($info,400);
        }
        $sql = "select `goods_id` from goods WHERE `goods_name`='$goodsname' AND `type_id`='$typeid' AND `user_phone`='$phone' AND `upload_time`='$uploadtime'";
        if($result=$mysqli->query($sql)){
            $row = $result->fetch_array();
            $info['goodsis'] = $row['goods_id'];
        }
        $info['tishi'] = "上传成功";
        $output->jsonyun($info,200);
    }else{
        $output = new output();
        $info = "请登录后再进行此操作";
        $output->jsonyun($info,400);
    }