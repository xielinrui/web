<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/26
 * Time: 20:49
 */
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    //error_reporting(0);
    require 'output.php';
    require 'duanxin.php';
    if(isset($_COOKIE['login'])){
        $output = new output();
        if(isset($_POST['jiaoyiid']) && isset($_POST['taidu'])){
            $phone = $_COOKIE['login'];
            $jiaoyiid = $_POST['jiaoyiid'];
            $taidu = $_POST['taidu'];
            $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
            if(mysqli_connect_errno()){
                $output->jsonyun(mysqli_connect_error(),400);
            }
//            $sql = "";
//            if($taidu == true ){
                $sql = "select `jiaoyi_goods_id`,`jiaoyi_faqiren_phone`,`jiaoyi_owner_phone` from `jiaoyi_application` where `jiaoyi_id`='$jiaoyiid'";
//            }else if($taidu == false){
//                $sql = "select `jiaoyi_faqiren_phone`,`jiaoyi_owner_phone` from `jiaoyi_application` where `jiaoyi_id`='$jiaoyiid'";
//            }
            if($result = $mysqli->query($sql)){
                $row = $result->fetch_array();
                if($row!=null){
                    if($row['jiaoyi_owner_phone']==$phone){
                        $goodsidd = $row['jiaoyi_goods_id'];
                        if($taidu==1){
                            $sql1 = "update `jiaoyi_application` set `jiaoyi_owner_status`=1 where `jiaoyi_id` = '$jiaoyiid'";
                            $sql2 = "update `goods` set `goods_status`=2 WHERE `goods_id`= '$goodsidd'";
                        }else{
                            $sql1 = "update `jiaoyi_application` set `jiaoyi_owner_status`=-1 where `jiaoyi_id` = '$jiaoyiid'";
                        }

                        $result1 = $mysqli->query($sql1);
                        if(!$result1){
                            $info = $mysqli->error;
                            $mysqli->close();
                            $output->jsonyun($info,400);
                        }else{
                            $info = "操作成功";
                            //TODO:如果出租者同意申请，那么直接修改物品状态。并加入交易情况到流水数据库。
                            if($taidu == 1){
                                $mysqli->query($sql2);
                                $faqiren = $row['jiaoyi_faqiren_phone'];
                                $duanxin = new duanxin();
                                $mobanhao = 114391;
                                $yanzhengma=$duanxin->faduanxinTwo($faqiren,$mobanhao);
                            }
                            $mysqli->close();
                            $output->jsonyun($info,200);
                        }
                    }else{
                        $info = "您不是出租者";
                        $output->jsonyun($info,400);
                    }
                }else{
                    $info = "您没有交易";
                    $mysqli->close();
                    $output->jsonyun($info,400);
                }
            }else{
                $info = "数据库错误";
                $mysqli->close();
                $output->jsonyun($info,400);
            }
        }else{
            $info = "参数不足";
            $output->jsonyun($info,400);
        }

    }