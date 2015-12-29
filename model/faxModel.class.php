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
		public function uploadIndvFile($file_size,$filename)
		{
			$collection = $this->db->nf_user_fileuploads;

			$files_values = array("user_id" => $_SESSION['user_id'] ,"file_name" => $filename,"file_size" => $file_size,"created_date" => $this->cfObj->createDate());

			$collection->insert($files_values);									
		}

		// Insert Fax Messages
		public function insertFax($mPost)
		{			
			
			$collection = $this->db->nf_user_fax;

			$files_values = array("from_id"=>$_SESSION['user_id'] ,"to_id" => $mPost['hidd_values'],"message_body" => $mPost['message_body'],"status" => "A","read" => "0","folder_id" => "","favorites" => "N","created_date" => $this->cfObj->createDate(),"modified_date" => "");

			$collection->insert($files_values);									
		}

		// updating Favorites
		public function updFavorites($mFavId,$mFVal)
		{
			$collection = $this->db->nf_user_fax;

			$Update_fax_vals = array("favorites" => $mFVal,"modified_date" => $this->cfObj->createDate());

			$collection->update(array('_id' => new MongoId($mFavId)), array('$set' => $Update_fax_vals));		
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
			$collection = $this->db->nf_user_fax;
		
			$collection->remove(array('_id' => new MongoId($mPost)));
		}
	}
	
?>