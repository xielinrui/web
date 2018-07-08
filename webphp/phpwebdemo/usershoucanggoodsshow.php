<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/24
 * Time: 16:28
 */
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    // header('Access-Control-Allow-Headers:*');
    //error_reporting(0);
    require 'output.php';
    require_once 'DataUtil.php';
    if(isset($_COOKIE['login'])){
        $phone =$_COOKIE['login'];
        $output = new output();
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
                $j=0;
                for($i = 0;$i<$n;$i++){
                    $k = trim($arr[$i]);
                    if($k=='')continue;
                    if($k!=null){
                        $sql1 = "select * from `goods` where `goods_id`='$k'";
                        if($result1 = $mysqli->query($sql1)){
                            $row = $result1->fetch_array();
                            $info[$j]['goodsid'] = $row['goods_id'];
                            $info[$j]['goodsname'] = $row['goods_name'];
                            $info[$j]['goodsimg'] = $row['goods_img1'];
                            $info[$j]['goodsststus'] = DataUtil::statusIdToName($row['goods_status']);
                            $j++;
                        }else{
                            $info = $mysqli->error;
                            $mysqli->close();
                            $output->jsonyun($info,400);
                        }
                    }
                }
                $mysqli->close();
                $output->jsonyun($info,200);
            }
        }else{
            $info=$mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }
    }