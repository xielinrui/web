<?php

	/**
	* mysqli服务层
	*/
	class exmysqli extends mysqli
	{
		var $exmysqli;
		function __construct($host,$name,$password,$database)
		{
			$output=new output();
			$this->$exmysqli=@new mysqli($host,$name,$password,$database);
			if(mysqli_connect_errno()){
				$info=mysqli_connect_error();
				$output->jsonyun($info,400);
			}
		}
		public function notjieguoji($sql)
		{
			$result=$this->$exmysqli->query($sql);
			if(!$result){
				$row[0]=-1;
				$row[1]=$this->$exmysqli->error;
			}else{
				$row[0]=$result->affected_rows;
			}
			return $row;
		}//返回影响的条数
		public function jieguoji($sql)
		{
			$ans['code']=200;
			if($result=$this->$exmysqli->query($sql)){
				$row=$result->fetch_array();
				$ans['row']=$row;
			}else{
				$ans['code']=400;
			}
			return $ans;
		}
	}
?>