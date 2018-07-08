<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/26
 * Time: 17:28
 */
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    //error_reporting(0);
    require 'output.php';
    require_once 'DataUtil.php';

    if(isset($_COOKIE['login'])){
        $output = new output();
        $phone = $_COOKIE['login'];
        $mysqli = @new mysqli('localhost', 'root', 'KEXUEJIA123', 'cplusplus');
        if (mysqli_connect_errno()) {
            $info = mysqli_connect_error();
            $output->jsonyun($info, 400);
        }
        $sql = "select `jiaoyi_id`,`jiaoyi_time`,`jiaoyi_address`,`jiaoyi_goods_id`,`jiaoyi_faqiren_phone`,`jiaoyi_status`,`jiaoyi_owner_status` from `jiaoyi_application` where `jiaoyi_owner_phone`='$phone' AND `jiaoyi_owner_status`='0' ORDER by `jiaoyi_time` DESC";
        if($result = $mysqli->query($sql)){
            $n = $result->num_rows;
            for($i = 0;$i<$n;$i++){
                $row = $result->fetch_array();
                $info[$i]['jiaoyiid'] = $row['jiaoyi_id'];
                $info[$i]['time'] = $row['jiaoyi_time'];
                $info[$i]['address'] = $row['jiaoyi_address'];
                $info[$i]['faqiren']  = $row['jiaoyi_faqiren_phone'];
                $info[$i]['jiaoyistatus'] = DataUtil::jiaoyiownerstatusToName($row['jiaoyi_status']);
                $info[$i]['jiaoyiownerstatus'] = DataUtil::jiaoyiownerstatusToName($row['jiaoyi_owner_status']);
                $goodsid = $row['jiaoyi_goods_id'];
                $info[$i]['goodsid'] = $goodsid;
                $sql1 = "select `goods_name`,`goods_img1`,`goods_img2`,`goods_img3` from goods where `goods_id`='$goodsid'";
                if($result1 = $mysqli->query($sql1)) {
                    $row1 = $result1->fetch_array();
                    if ($row1 != null) {
                        $info[$i]['goodsname'] = $row1['goods_name'];
                        $info[$i]['goodsimg1'] = $row1['goods_img1'];
                    }
                }
            }
            $mysqli->close();
            $output->jsonyun($info,200);
        }else{
            $info = $mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }
    }