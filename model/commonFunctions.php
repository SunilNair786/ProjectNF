<?php
/*
	Common class file,for commonly used in the development.
*/
class commonFunctions
{
	//Function for Create Date
	function createDate(){	
		$createDate = date("Y-m-d H:i:s");
		return $createDate;		
	}

	//Function for Modified Date
	function modifiedDate(){
		$modifiedDate = date("Y-m-d H:i:s");
		return $modifiedDate;		
	}

	//Function for Generate New Password
	function generatePassword($password){			
		if(isset($password)){
			$newPassword=md5($password);
			return $newPassword;
		}else{
			return null;
		}	
	}
	//Function for Generate New Timestamp value
	function getTimeStamp(){
		$date = new DateTime();
		return $date->getTimestamp();
	}
}	
?>