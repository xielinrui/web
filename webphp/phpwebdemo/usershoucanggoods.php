<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/24
 * Time: 16:01
 */

    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    // header('Access-Control-Allow-Headers:*');
    //error_reporting(0);
    require 'output.php';
    if (isset($_COOKIE['login'])){
        if(isset($_POST['goodsid'])){
            $output = new output();
            $phone = $_COOKIE['login'];
            $goodsid = $_POST['goodsid'];
            $mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
            if(mysqli_connect_errno()){
                $info=mysqli_connect_error();
                $output->jsonyun($info,400);
            }
            $sql = "select `user_shoucang` from `user_property` where `user_phone`='$phone'";
            if($result=$mysqli->query($sql)){
                $row = $result->fetch_array();
                if($row!=NULL){
                    $str = $row['user_shoucang'];
                    $arr = explode(",",$str);
                    $n = sizeof($arr);
                    for($i=0;$i<$n;$i++){
                        if($arr[$i]==$goodsid){
                            $info = "您已经收藏过了";
                            $mysqli->close();
                            $output->jsonyun($info,400);
                        }
                    }
                    $arr[$n] = $goodsid;
                    $tmpstr = implode(",",$arr);
                    $sql = "update `user_property` set `user_shoucang`='$tmpstr' where `user_phone`='$phone'";
                    $resultk = $mysqli->query($sql);
                    if(!$resultk){
                        $info = $mysqli->error;
                        $mysqli->close();
                        $output->jsonyun($info,400);
                    }
                    $info = "收藏成功";
                    $mysqli->close();
                    $output->jsonyun($info,200);
                }else{
                    $info = "失败";
                    $mysqli->close();
                    $output->jsonyun($info,400);
                }
            }else{
                $info = $mysqli->error;
                $mysqli->close();
                $output->jsonyun($info,400);
            }
        }
    }
