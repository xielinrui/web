<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/27
 * Time: 21:26
 */
header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
// header('Access-Control-Allow-Headers:*');
//error_reporting(0);
require 'output.php';
require_once 'DataUtil.php';
if(isset($_COOKIE['login'])){
    if(isset($_POST['goodsid'])){
        $phone = $_COOKIE['login'];
        $goodsid = $_POST['goodsid'];
        $output = new output();
        $mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
        if(mysqli_connect_errno()){
            $info=mysqli_connect_error();
            $output->jsonyun($info,400);
        }
        $sql = "select `user_xinzuche` from `user_property` where `user_phone`='$phone'";
        if($result=$mysqli->query($sql)){
            $row = $result->fetch_array();
            if($row!=NULL){
                $str = $row['user_xinzuche'];
                $arr = explode(",",$str);
                $n = sizeof($arr);
                $flag=0;
                for($i = 0;$i<$n;$i++){
                    $k = $arr[$i];
                    if($k!=null){
                        if($k == $goodsid){
                            $flag=1;
                            for($j=$i;$j<$n-1;$j++){
                                $arr[$j] = $arr[$j+1];
                            }
                            $arr[$n-1] = null;
                            break;
                        }
                    }
                }
                $tmpstr = implode(",",$arr);
                $sql = "update `user_property` set `user_xinzuche`='$tmpstr' where `user_phone`='$phone'";
                $resultk = $mysqli->query($sql);
                if(!$resultk){
                    $info = $mysqli->error;
                    $mysqli->close();
                    $output->jsonyun($info,400);
                }
                $info = "成功";
                $mysqli->close();
                $output->jsonyun($info,200);
            }else{
                $info = "失败";
                $mysqli->close();
                $output->jsonyun($info,400);
            }
        }else{
            $info=$mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }
    }
}