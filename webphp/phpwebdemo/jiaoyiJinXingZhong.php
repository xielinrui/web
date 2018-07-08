<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/27
 * Time: 22:00
 */
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
//    error_reporting(0);
    require 'output.php';
    if (isset($_COOKIE['login'])){
        $output = new output();
        if(isset($_POST['constant_time'])&&isset($_POST['yiwancheng'])&&isset($_POST['goodsid'])){
            $yiwancheng = $_POST['yiwancheng'];
            $constanttime = $_POST['constant_time'];
            $goodsid = $_POST['goodsid'];
            if($yiwancheng == 1){
                //交易成功
                $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
                if(mysqli_connect_errno()){
                    $output->jsonyun(mysqli_connect_error(),400);
                }
                $mysqli->autocommit(false);
                $sql = "update `jiaoyi_application` set `jiaoyi_status`=1,`constant_time`='$constanttime' where `jiaoyi_goods_id`='$goodsid'";
                $result = $mysqli->query($sql);
                if(!$result){
                    $info = $mysqli->error;
                    $mysqli->rollback();
                    $mysqli->autocommit(true);
                    $mysqli->close();
                    $output->jsonyun($info,400);
                }
                $sql = "update goods set `goods_status`=2 where `goods_id`='$goodsid'";
                $result = $mysqli->query($sql);
                if(!$result){
                    $info = $mysqli->error;
                    $mysqli->rollback();
                    $mysqli->autocommit(false);
                    $mysqli->close();
                    $output->jsonyun($info,400);
                }else{
                    $info = "交易情况填写成功，系统将在交易即将到期的时候提醒双发";
                    $mysqli->close();
                    $output->jsonyun($info,200);
                }
            }else{
                //交易失败
                $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
                if(mysqli_connect_errno()){
                    $output->jsonyun(mysqli_connect_error(),400);
                }
                $mysqli->autocommit(false);
                $sql = "update `jiaoyi_application` set `jiaoyi_status`=-1,`constant_time`='$constanttime' where `jiaoyi_goods_id`='$goodsid'";
                $result = $mysqli->query($sql);
                if(!$result){
                    $info = $mysqli->error;
                    $mysqli->rollback();
                    $mysqli->autocommit(true);
                    $mysqli->close();
                    $output->jsonyun($info,400);
                }else{
                    $info = "更新成功";
                    $mysqli->rollback();
                    $mysqli->autocommit(true);
                    $mysqli->close();
                    $output->jsonyun($info,200);
                }

            }
        }else{
            $info = "请求有误";
            $output->jsonyun($info,400);
        }
    }
