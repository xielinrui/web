<?php
	if(isset($_SERVER['HTTP_REFERER'])){
		$re=$_SERVER['HTTP_REFERER'];
		if($re!=""){
			echo "可以访问233";
		}
	}

?>