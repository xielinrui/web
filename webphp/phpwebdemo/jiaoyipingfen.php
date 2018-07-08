<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/5/23
 * Time: 12:29
 */
header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
//error_reporting(0);
require 'output.php';
require_once 'DataUtil.php';
require_once 'duanxin.php';
if(isset($_COOKIE['login'])){
    $output = new output();
    if(isset($_POST['jiaoyiid']) && isset($_POST['shenfen'])) {
        $data = new DateTime();
        $jiaoyiid = $_POST['jiaoyiid'];
        $shenfen = $_POST['shenfen'];
        $phone = $_COOKIE['login'];
        if($shenfen == 1){
            $ownertozuer = $_POST['tozuer'];
        }else{
            $zuertoowner = $_POST['toowner'];
            $zuertogoods = $_POST['togoods'];
        }
        $mysqli = @new mysqli('localhost', 'root', 'KEXUEJIA123', 'cplusplus');
        if (mysqli_connect_errno()) {
            $info = mysqli_connect_error();
            $output->jsonyun($info, 400);
        }
        $mysqli->autocommit(false);
        //jiaoyi_application中判断是否存在goodsid、jiaoyi_faqiren_phone且jiaoyi_owner_status为0的条数
        if($shenfen==2){
            $sql = "update `jiaoyi_application` set `zuertoowner`='$zuertoowner',`zuertogoods`='$zuertogoods' WHERE `jiaoyi_id`='$jiaoyiid' AND `zuertoowner`=5 AND `zuertogoods`=5";
        }else{
            $sql = "update `jiaoyi_application` set `ownertozuer`='$ownertozuer' WHERE `jiaoyi_id`='$jiaoyiid' AND `ownertozuer`=5";
        }
        if($resule =$mysqli->query($sql)){
            $mysqli->commit();
            $mysqli->autocommit(true);
            $mysqli->close();
            $info = "评分成功";
            $output->jsonyun($info,200);
        }else{
            $info =$mysqli->error;
            $mysqli->rollback();
            $mysqli->autocommit(true);
            $mysqli->close();
            $output->jsonyun($info,400);
        }
    }else{
        $info = "参数不足";
        $output->jsonyun($info,400);
    }
}