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
			
			$upload_directory = '../upload_dir/files/';
			$x=0;
			$userId = $_SESSION['user_id'];	
			$timeStamp = $this->cfObj->getTimeStamp();
			echo $newFileName = $userId."_".$timeStamp;			 exit;
			foreach ( $_FILES['file']['name'] AS $key => $value ){  
			   //Move file to server directory
			   move_uploaded_file($_FILES["file"]["tmp_name"][$x], $upload_directory.'/'.$newFileName.'_'.$x.'_'. $_FILES["file"]["name"][$x]);	   
				if($_FILES["file"]["type"][$x] == 'image/png'){
					//Create pdf file from images.	
						
				}		   
			   $x++;  
			}	
		}
	
}

?>