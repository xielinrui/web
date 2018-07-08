<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:text/html;charset=utf8");
    //error_reporting(0);
    require_once 'output.php';
    $output = new output();
    if(isset($_POST['phone'])){
        $phone = $_POST['phone'];
        $mysqli=@new mysqli('localhost','root','KEXUEJIA123','cplusplus');
        if(mysqli_connect_errno()){
            $info=mysqli_connect_error();
            $output->jsonyun($info,400);
        }
        $sql="select `user_phone`,`user_sex`,`user_birthday`,`user_area`,`user_qianming`,`user_img` from user_property where `user_phone`='$phone'";
        if($result=$mysqli->query($sql)){
            $row=$result->fetch_array();
            if($row['user_phone']==null){
                $info = "玩家不存在";
                $mysqli->close();
                $output->jsonyun($info,400);
            }
        }else{
            $info=$mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }

        $info['phone'] = $row['user_phone'];
        $info['sex'] = $row['user_sex'];
        $info['birthday'] = $row['user_birthday'];
        $info['area'] = $row['user_area'];
        $info['qianming'] = $row['user_qianming'];
        $info['img'] = $row['user_img'];
        $sql="select count(*),`yanzheng_statu` from user_renzheng where `user_phone`='$phone'";
        if($result=$mysqli->query($sql)){
            $row1=$result->fetch_array();
        }else{
            $info=$mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }
        if($row1[0]==0){
            $info['renzheng'] = '您尚未申请实名认证';
        }else{
            if($row1['yanzheng_statu']==1){
                $info['renzheng'] = "实名认证已通过";
            }else{
                $info['renzheng'] = "实名认证尚未通过";
            }
        }

        $sql="select `user_xyd` from user_xinyudu where `user_phone`='$phone'";
        if($result=$mysqli->query($sql)){
            $row2=$result->fetch_array();
            $info['crent'] = $row2['user_xyd'];
        }else{
            $info=$mysqli->error;
            $mysqli->close();
            $output->jsonyun($info,400);
        }
        $mysqli->close();
        $output->jsonyun($info,200);
    }else{
        $info = "没有发来电话号码";
        $output->jsonyun($info,400);
    }