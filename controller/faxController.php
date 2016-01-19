<?php

include_once('model/faxModel.class.php');

class faxController{

	public $faxObj;
	
	public function __construct(){
		$this->faxObj =  new faxModel();	
		$this->cfObj = new commonFunctions();	
	}		
	
	public function copyFiles($post,$files){		
		$upload_directory = 'upload_dir/files';
		$x=0;
		$userId = $_SESSION['user_id'];	
		$timeStamp = $this->cfObj->getTimeStamp();
		$newFileName = $userId."_".$timeStamp;	
		$uploadfile = '';
		foreach ( $_FILES['file']['name'] as $values ){  			   	
			$fullFileName = $newFileName.'_'.$x.'_'. $_FILES["file"]["name"][$x]; 
				move_uploaded_file($_FILES["file"]["tmp_name"][$x],$upload_directory.'/'.$fullFileName);	   	
		   		$uploadfile .= $this->faxObj->uploadIndvFile($files['file']['size'][$x],$fullFileName).",";
				
		   	$x++;  
		}
		if($uploadfile !=''){
			$post['attachment_id'] =  substr($uploadfile, 0 ,-1);
		}else{
			$post['attachment_id'] = '';
		}		
		$faxdata = $this->faxObj->insertFax($post);
		return $faxdata ;
	}
	
	public function fetchFaxInfo($faxId){
		$faxdata = $this->faxObj->fetchFaxInfo($faxId);
		return $faxdata;
	}
	
	
	public function insertToFaxIds($toId,$faxId){
		$fromId = $_SESSION['user_id'];	
		$faxdata = $this->faxObj->insertToFaxIds($fromId,$toId,$faxId);
	}

	// Changing Favorites
	public function updateFavorites($post_id,$fVal){
		$fav_Det = $this->faxObj->updFavorites($post_id,$fVal);
		return $fav_Det;
	}
	
	// Changing Favorites
	public function updateReadCount($post_id){
		$fav_Det = $this->faxObj->updateReadCount($post_id);
		return $fav_Det;
	}

	// Changing read status
	public function updatefaxSeenStatus($post_id){
		$read_stat = $this->faxObj->updateReadStat($post_id);
		return $read_stat;
	}

	// Deleting Fax
	public function deleteFax($Cpost)
	{
		$del_fax = $this->faxObj->deleFaxs($Cpost);
		return $del_fax;
	}


	// Saving Reply Messages
	public function sendReply($Cpost)
	{
		$reply_fax = $this->faxObj->reply_Msg_fax($Cpost);
		return $reply_fax;
	}

	// Updating faxs Tags
	public function updateFaxTags($Cpost)
	{
		$tags_fax = $this->faxObj->update_fax_tags($Cpost);
		return $tags_fax;
	}
	
}

?>