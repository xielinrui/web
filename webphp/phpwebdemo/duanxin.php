<?php
    //namespace Qcloud\Sms;
	//header('Access-Control-Allow-Origin:*');
   // header("Content-Type:text/html;charset=utf8");
	error_reporting(0);
    //require 'output.php';
    require 'qcloudsms_phpmaster/src/SmsSingleSender.php';

    /**
    * 
    */
    class duanxin
    {	
    	function __construct()
    	{


    	}
    	public function faduanxinTwo($phone,$mobanhao){
            $output =new output();
            $appid=1400051279;
            $appkey="113ec86386e08b6e3eea8c06473866c3";
            $templId=$mobanhao;
            $phoneNumber2=$phone;
            $sender = new SmsSingleSender($appid, $appkey);
            $parm = array();
            $result = $sender->sendWithParam("86", $phoneNumber2, $templId,$parm, "信租", "", "");
            // var_dump($result);
            $obj = json_decode($result);
            $suss=1;
            $suss=$obj->result;
            if($suss!=0){
                return 0;
            }else{
                return $suss;
            }
        }
    	public function faduanxin($phone,$mobanhao)
    	{
   			try {
   				$output = new output();
    			$appid=1400051279;
                $appkey="113ec86386e08b6e3eea8c06473866c3";
                $val="";
                for($i=0;$i<4;$i++){
                    $k=rand(0,9);
                    $val.=$k;
                }
                $templId=$mobanhao;
                $phoneNumber2=$phone;
                $sender = new SmsSingleSender($appid, $appkey);

                $params[0]=$val;
                $params[1]="3";
                //$params = ["$val", "3"];
                // 假设模板内容为：测试短信，{1}，{2}，{3}，上学。
                 $result = $sender->sendWithParam("86", $phoneNumber2, $templId,
                     $params, "信租", "", "");
                 // var_dump($result);
                $obj = json_decode($result);            
                $suss=1;
                $suss=$obj->result;
                if($suss!=0){
                	return 0;
                }else{
                	return $val;
                }
   			} catch (Exception $e) {
   				$info=$e->getMessage();
   				$output->jsonyun($info,400);
   			}
    	}
    }
?>