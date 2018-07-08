<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/26
 * Time: 16:28
 */
    header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
//error_reporting(0);
require 'output.php';
require_once 'DataUtil.php';
    require_once 'duanxin.php';
    if(isset($_COOKIE['login'])){
        $output = new output();
        if(isset($_POST['goodsid']) && isset($_POST['address'])) {
            $goodsid = $_POST['goodsid'];
            $data = new DateTime();
            $address = $_POST['address'];
            $phone = $_COOKIE['login'];
            $mysqli = @new mysqli('localhost', 'root', 'KEXUEJIA123', 'cplusplus');
            if (mysqli_connect_errno()) {
                $info = mysqli_connect_error();
                $output->jsonyun($info, 400);
            }
            $mysqli->autocommit(false);
            //jiaoyi_application中判断是否存在goodsid、jiaoyi_faqiren_phone且jiaoyi_owner_status为0的条数
            $sql = "select count(*) from `jiaoyi_application` where `jiaoyi_goods_id` = '$goodsid' and `jiaoyi_faqiren_phone`='$phone' and `jiaoyi_owner_status`=0";
            if($resule =$mysqli->query($sql)){
                $row = $resule->fetch_array();
                if($row[0]!=0){
                    $mysqli->rollback();
                    $mysqli->autocommit(true);
                    $mysqli->close();
                    $info = "您已经提交过该申请了,请勿重复提交";
                    $output->jsonyun($info,400);
                }else{
                    date_default_timezone_set("PRC");
                    $day=date("Y-m-d-H-i-s");
                    $sql  = "insert into jiaoyi_application(`jiaoyi_time`,`jiaoyi_address`,`jiaoyi_goods_id`,`jiaoyi_faqiren_phone`) values('$day','$address','$goodsid','$phone')";
                    $resule = $mysqli->query($sql);
                    if(!$resule){
                        $info = $mysqli->error;
                        $mysqli->rollback();
                        $mysqli->autocommit(true);
                        $mysqli->close();
                        $output->jsonyun($info,400);
                    }
                    //成功，向两个玩家发送短信通知交易地点和时间等。

                    $sql = "select `user_phone` from `goods` where `goods_id`='$goodsid'";
                    $owner = 0;
                    if($resule = $mysqli->query($sql)) {
                        $row = $resule->fetch_array();
                        $owner = $row[0];
                        $sql = "update `jiaoyi_application` set `jiaoyi_owner_phone`='$owner' where `jiaoyi_goods_id`='$goodsid'";
                        if ($resule = $mysqli->query($sql)) {
                            if ($owner != 0) {
                                //应该是通知短信
                                $duanxin = new duanxin();
                                $mobanhao = 113703;
                                $yanzhengma=$duanxin->faduanxinTwo($owner,$mobanhao);
                            }
                            $info = "成功，已通知出租者尽快处理您的交易申请";
                            $mysqli->commit();
                            $mysqli->autocommit(true);
                            $mysqli->close();
                            $output->jsonyun($info, 200);
                        } else {
                            $info = $mysqli->error;
                            $mysqli->rollback();
                            $mysqli->autocommit(true);
                            $mysqli->close();
                            $output->jsonyun($info, 400);
                        }
                    }
                }
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