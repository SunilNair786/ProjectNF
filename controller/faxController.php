<?php

include_once('model/faxModel.class.php');

class faxController{

		public $faxObj;
		
		public function __construct(){
			$this->faxObj =  new faxModel();	
			$this->cfObj = new commonFunctions();	
		}		
		
		public function copyFiles($post,$files){
			echo "<pre>";
			//print_r($post);			
			echo $upload_directory = 'upload_dir/files';
			$x=0;
			$userId = $_SESSION['user_id'];	
			$timeStamp = $this->cfObj->getTimeStamp();
			$newFileName = $userId."_".$timeStamp;	
			foreach ( $_FILES['file']['name'] AS $key => $value ){  			   	
				echo $fullFileName = $newFileName.'_'.$x.'_'. $_FILES["file"]["name"][$x]; 
			   	move_uploaded_file($_FILES["file"]["tmp_name"][$x],$upload_directory.'/'.$fullFileName);	   	
			   		$uploadfile = $this->faxObj->uploadIndvFile($files['file']['size'][$x],$fullFileName);
			   	$x++;  
			}				

			$faxdata = $this->faxObj->insertFax($post);
		}
	
}

?>