<?php
/**
 * Created by PhpStorm.
 * User: laodiao
 * Date: 2018/4/24
 * Time: 0:21
 */
header('Access-Control-Allow-Origin:*');
header("Content-Type:text/html;charset=utf8");
//error_reporting(0);
require_once 'DataUtil.php';
require 'output.php';
if (isset($_COOKIE['login'])){
    if(isset($_POST['page'])&&isset($_POST['showtype'])){
        $output = new output();
        $page = $_POST['page']-1;
        $phone = $_COOKIE['login'];
        $goodsstatus = $_POST['showtype'];
        $mysqli = @new mysqli('localhost','root','KEXUEJIA123','cplusplus');
        if(mysqli_connect_errno()){
            $output->jsonyun(mysqli_connect_error(),400);
        }
        if($goodsstatus<=3){
            $sql = "select `goods_id`,`goods_name`,`ershou_sell`,`ershou_sell_money`,`goods_description`,`goods_img1`,`goods_img2`,`goods_img3`,`chuzu_money` from goods WHERE `user_phone`='$phone' AND `goods_status`='$goodsstatus' order by upload_time desc";
            $beishu = 4;
            $tiao = $page*($beishu);
            if($result=$mysqli->query($sql)){
                $cnt = 0;
                $i = 0;
                while($row = $result->fetch_array()){
                    if($cnt>=$tiao && $cnt<$tiao+$beishu){
                        $info[$i]['goodsid'] = $row['goods_id'];
                        $info[$i]['goodsname'] = $row['goods_name'];
                        $info[$i]['ershousell'] = $row['ershou_sell'];
                        $info[$i]['ershousellmoney'] = $row['ershou_sell_money'];
                        $info[$i]['description'] = $row['goods_description'];
                        $info[$i]['goodsimg1'] = $row['goods_img1'];
                        $info[$i]['goodsimg2'] = $row['goods_img2'];
                        $info[$i]['goodsimg3'] = $row['goods_img3'];
                        $info[$i]['chuzumoney'] = $row['chuzu_money'];
                        $i++;
                        $cnt++;
                    }else{
                        $cnt++;
                        if($cnt>=$tiao+$beishu){
                            break;
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
        }else{
            $sql = "select `goods_id`,`goods_name`,`ershou_sell`,`ershou_sell_money`,`goods_description`,`goods_img1`,`goods_img2`,`goods_img3`,`chuzu_money` from goods INNER JOIN jiaoyi_application ON goods.goods_id=jiaoyi_application.jiaoyi_goods_id WHERE `jiaoyi_faqiren_phone`='$phone' ORDER BY jiaoyi_application.jiaoyi_time DESC ";
            $beishu = 4;
            $tiao = $page*($beishu);
            if($result=$mysqli->query($sql)){
                $cnt = 0;
                $i = 0;
                while($row = $result->fetch_array()){
                    if($cnt>=$tiao && $cnt<$tiao+$beishu){
                        $info[$i]['goodsid'] = $row['goods_id'];
                        $info[$i]['goodsname'] = $row['goods_name'];
                        $info[$i]['ershousell'] = $row['ershou_sell'];
                        $info[$i]['ershousellmoney'] = $row['ershou_sell_money'];
                        $info[$i]['description'] = $row['goods_description'];
                        $info[$i]['goodsimg1'] = $row['goods_img1'];
                        $info[$i]['goodsimg2'] = $row['goods_img2'];
                        $info[$i]['goodsimg3'] = $row['goods_img3'];
                        $info[$i]['chuzumoney'] = $row['chuzu_money'];
                        $i++;
                        $cnt++;
                    }else{
                        $cnt++;
                        if($cnt>=$tiao+$beishu){
                            break;
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

    }
}
