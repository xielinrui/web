<?php
	/**
	* 输出为json格式
	*/
	class output
	{
		function __construct()
		{
			
		}
		public function jsonyun($info,$code)
		{
			$rs['info']=$info;
			$rs['code']=$code;
			exit(json_encode($rs, JSON_UNESCAPED_UNICODE));
		}
	}

?>