<?php
	class faxModel{
				
		public $cfObj="";
		public $db ="";
		public function __construct(){			
			$this->cfObj = new commonFunctions();	
			// DB Connection
			$this->mC = new MongoClient();
			$this->db = $this->mC->nextfax;
		}	

		// Insert Uploaded files 
		public function uploadIndvFile($file_size,$filename){
			$mgoId = new MongoId(); 
			
			$collection = $this->db->nf_user_fileuploads;

			$files_values = array("_id"=>$mgoId,"user_id" => $_SESSION['user_id'] ,"file_name" => $filename,"file_size" => $file_size,"created_date" => $this->cfObj->createDate());

			$collection->insert($files_values);	

			return 	$mgoId;
		}
		
		public function fetchFaxInfo($faxId){
			
			$collection = $this->db->nf_fax;	

			$resultC = $collection->findOne(array("_id" => new MongoId($faxId), "status" => 'A'));

			return $resultC;
		}
		
		

		// Insert Fax Messages
		/*public function insertFax($mPost)
		{			
		 	$mPost['_id'] = new MongoId(); 
			
			$collection = $this->db->nf_fax_message;

			$files_values = array("_id"=>$mPost['_id'],"from_id"=>$_SESSION['user_id'] ,"to_id" => $mPost['hidd_values'],"message_body" => $mPost['message_body'],"status" => "A","read" => "0","folder_id" => "","favorites" => "N","created_date" => $this->cfObj->createDate(),"modified_date" => "");

			$collection->insert($files_values);

			return 	$mPost['_id'];
			
		}*/
		
		public function insertFax($mPost){			
		 	$mPost['_id'] = new MongoId(); 
			
			$collection = $this->db->nf_fax;

			$files_values = array("_id"=>$mPost['_id'],"from_id"=>$_SESSION['user_id'] ,"message_subject" => $mPost['message_subject'],"message_body" => $mPost['message_body'],"file_name"=>'',"file_size"=>'','file_attach_id'=>$mPost['attachment_id'],"status" => "A","created_date" =>$this->cfObj->createDate(),"modified_date" => "");

			$collection->insert($files_values);

			return 	$mPost['_id'];
			
		}
		
		// Insert Fax ToIds
		public function insertToFaxIds($fromId,$toId,$faxId){			
		 	$collection = $this->db->nf_fax_users;
			
			$files_values = array("fax_id"=>$faxId,"from_id"=>$_SESSION['user_id'] ,"to_id" => $toId,"status" => "A","is_read" => "0","folder_id" => "","favorites" => "N","is_delete" => 0,"created_date" => $this->cfObj->createDate(),"modified_date" => "");

			$collection->insert($files_values);
			
		}

		// updating Favorites
		public function updFavorites($mFavId,$mFVal)
		{
			$collection = $this->db->nf_fax_users;

			$Update_fax_vals = array("favorites" => $mFVal,"modified_date" => $this->cfObj->createDate());

			$updateRes = $collection->update(array('_id' => new MongoId($mFavId)), array('$set' => $Update_fax_vals));	
			
			return 	$updateRes;		
		}
		
		public function updateReadCount($mFavId){
			
			$collection = $this->db->nf_fax_users;

			$Update_fax_vals = array("is_read" => 1,"modified_date" => $this->cfObj->createDate());

			$updateRes = $collection->update(array('_id' => new MongoId($mFavId)), array('$set' => $Update_fax_vals));	
			
			return 	$updateRes;		
		}

		// updating Read Status
		public function updateReadStat($mFavId)
		{
			$collection = $this->db->nf_user_fax;

			$Update_fax_vals = array("read" => "1");

			$collection->update(array('_id' => new MongoId($mFavId)), array('$set' => $Update_fax_vals));		
		}

		// Deleting Fax
		public function deleFaxs($mPost)
		{
			$collection = $this->db->nf_fax_users;
		
			$Update_fax_vals = array("is_delete" => "1");

			$collection->update(array('_id' => new MongoId($mPost)), array('$set' => $Update_fax_vals));	
		}
	}
	
?>