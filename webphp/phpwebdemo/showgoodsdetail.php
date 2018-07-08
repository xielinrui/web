<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/24
 * Time: 10:15
 */
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    //error_reporting(0);
    require_once 'DataUtil.php';
    require 'output.php';

    if (isset($_POST['goodsid'])){
        $isSave = 0;
        $userxyd = 0;
        if(isset($_COOKIE['login'])){
            $phone = $_COOKIE['login'];
        }
        $goodsid = $_POST['goodsid'];
        $output = new output();
        $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
        if(mysqli_connect_errno()){
            $output->jsonyun(mysqli_connect_error(),400);
        }
        $sql = "select * from goods where `goods_id`='$goodsid'";
        if($resule = $mysqli->query($sql)){
            $row = $resule->fetch_array();
            if(isset($_COOKIE['login'])){
                $phone = $_COOKIE['login'];
                $sql1 = "select `user_shoucang` from `user_property` where `user_phone`='$phone'";
                if($result1=$mysqli->query($sql1)) {
                    $row1 = $result1->fetch_array();
                    if ($row1 != NULL) {
                        $str1 = $row1['user_shoucang'];
                        $arr1 = explode(",", $str1);
                        $n = sizeof($arr1);
                        for ($i = 0; $i < $n; $i++) {
                            if ($arr1[$i] == $goodsid) {
                                $isSave = 1;
                                break;
                            }
                        }
                    }
                }
                $sql2 = "select `user_xyd` from `user_xinyudu` WHERE `user_phone`='$phone'";
                if($resule2 = $mysqli->query($sql2)){
                    $row2 = $resule2->fetch_array();
                    $userxyd = $row2['user_xyd'];
                }
            }

            $info = array(
                'goodsid' => $row['goods_id'],
                'goodsname' => $row['goods_name'],
                'typename' => DataUtil::typeIdToName($row['type_id']),
                'ershousell' => $row['ershou_sell'],
                'ershousellmoney' => $row['ershou_sell_money'],
                'ownerphone' => $row['user_phone'],
                'goods_description' => $row['goods_description'],
                'goods_img1' => $row['goods_img1'],
                'goods_img2' => $row['goods_img2'],
                'goods_img3' => $row['goods_img3'],
                'goods_status' => DataUtil::statusIdToName($row['goods_status']),
                'upload_time' => $row['upload_time'],
                'shenhetongguo_time' => $row['shenhetongguo_time'],
                'xiajia_time' => $row['xiajia_time'],
                'shangjia_time' => $row['shangjia_time'],
                'goods_pingfen' => $row['goods_pingfen'],
                'chuzu_money' => $row['chuzu_money'],
                'isSave' => $isSave,
                'userxyd' => $userxyd,
            );
            $mysqli->close();
            $output->jsonyun($info,200);
        }else{
            $info = $mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }
    }