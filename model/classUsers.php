<?php
class users{

	public $cfObj="";
	public $db ="";
	
	public function __construct(){
		$this->cfObj = new commonFunctions();	
		
		// DB Connection
		$this->mC = new MongoClient();
		
		$this->db = $this->mC->nextfax;
	}

	// Checking the User Credentials
	public function checkAuth($post){				
		
		$collection = $this->db->nf_user;	

		$resultC = $collection->findOne(array("email_id" => $post['login_email'] , "password" =>md5($post['login_password']), "status" => 'A'));

		return $resultC;
	}

	// Get the Details Of the user
	public function getDetails($post){
		$collection = $this->db->nf_user;
		
		$resultVlas = $collection->findOne(array("email_id" => $_POST['login_email'] , "password" =>md5($_POST['login_password'])));

		return $resultVlas;
	}


	// Insert Contacts
	public function insertContRecord($post)
	{		
		$collection = $this->db->nf_user_contacts;

		$contact_values = array("user_id" => $_SESSION['user_id'] ,"group_id" => $_POST['GroupName'], "contact_name" => $_POST['contact_name'], "email" => $_POST['contact_email'], "phone" => $_POST['contact_phone'],"fax" => $_POST['contact_faxNo'],"contact_info" => $_POST['contact_info'],"status" => "A","created_date" => $this->cfObj->createDate(),"modified_date" => "");

		$collection->insert($contact_values);			
	}
	// Update Contacts
	public function updateContRecord($post){
		
		$collection = $this->db->nf_user_contacts;

		$upd_contact_values = array("group_id" => $post['GroupName'], "contact_name" => $post['contact_name'], "email" => $post['contact_email'], "phone" => $post['contact_phone'],"fax" => $post['contact_faxNo'],"contact_info" => $post['contact_info'],"modified_date" => $this->cfObj->createDate());

		$collection->update(array('_id' => new MongoId($post['hidd_contact_id'])), array('$set' => $upd_contact_values));		
	}
	// Delete Contact
	public function deleteContRecord($vals)
	{		
		$collection = $this->db->nf_user_contacts;
		
		$collection->remove(array('_id' => new MongoId($vals)));
	}



	// Insert Groups
	public function insertGrpRecord($post)
	{		
		$post['_id'] = new MongoId(); 

		$collection = $this->db->nf_user_groups;

		$group_values = array("_id"=>$post['_id'],"user_id" => $_SESSION['user_id'] ,"group_name" => $_POST['grpName'],"user_ids" => $post['hidd_values'],"status" => "A","created_date" => $this->cfObj->createDate(),"modified_date" => "");

		$collection->insert($group_values);			

		return 	$post['_id'];
	}
	// Update Group
	public function updateGrpRecord($post)
	{		
		$collection = $this->db->nf_user_groups;

		$Update_Group = array("group_name" => $post['grpName'],"user_ids" => $post['hidd_values'],"modified_date" => $this->cfObj->createDate());

		$collection->update(array('_id' => new MongoId($post['grpId'])), array('$set' => $Update_Group));		
	}
	//Delete Group
	public function deleteGrpRecord($post)
	{		
		$collection = $this->db->nf_user_groups;
		
		$collection->remove(array('_id' => new MongoId($post)));
	}
	
	//Search Contacts
	public function searchContact($search){
		/*$collection = $this->db->nf_user_contacts;					
	
		//var_dump($collection);		
		$regex = new MongoRegex("/Jav/");	
		$query = array('contact_name' => $regex);		
		
		//$users = $collection->find($where);
		$res =$collection->find(array("contact_name" => "Javeed"));
		var_dump($res);	*/
		
		$collection = $this->db->nf_user_contacts;

		//$contact_values = array("user_id" => '3' ,"group_id" => '2', "contact_name" => "Ramu", "email" => "ramu@lambdainnov.com", "phone" => "1236547890","fax" => "1236547890","contact_info" => "Ramu Contact Number","status" => "A","created_date" => $this->cfObj->createDate(),"modified_date" => "");

		//$collection->insert($contact_values);	
					
	}
	// Inserting Tags
	public function tagsInserting($post)
	{
		print_r($post);		
		$collection = $this->db->nf_company_tags;
		//echo "ewregjhf"; exit;

		$tags_values = array("user_id" => $_SESSION['user_id'],"company_id" => "1" ,"tag_name" => $post['tag_name'],"created_date" => $this->cfObj->createDate(),"modified_date" => "");
		//print_r($tags_values); exit;

		$collection->insert($tags_values);			
	}
	// Editing Tags
	public function TagsEdit($Mpost)
	{
		$collection = $this->db->nf_company_tags;

		$Update_tags = array("tag_name" => $Mpost['edit_tag_name'],"modified_date" => $this->cfObj->createDate());

		$collection->update(array('_id' => new MongoId($Mpost['hidd_tag_id'])), array('$set' => $Update_tags));		
	} 

	public function deleteTags($postVal,$userId){
		
		$collection = $this->db->nf_company_tags;
		
		$collection->remove(array('_id' => new MongoId($postVal),'user_id' => $userId));		
	}	
	
	// Inserting Notes
	public function insertNote($arrVal){
		
		$collection = $this->db->nf_user_notes;
		
		$notes_values = array("user_id" => $_SESSION['user_id'],"company_id" => "1" ,"note_title" => $arrVal['note_title'],"note_content" => $arrVal['note_content'],"created_date" => $this->cfObj->createDate(),"modified_date" => "");
		
		$collection->insert($notes_values);	
	}
	
	// Inserting Notes
	public function updateNote($arrVal){				
		
		$collection = $this->db->nf_user_notes;
		
		$updateNotes = array("company_id" => "1" ,"note_title" => $arrVal['note_title'],"note_content" => $arrVal['note_content'],"modified_date" => $this->cfObj->createDate());
		
		$collection->update(array("_id" => new MongoId($arrVal['note_id'])),array('$set' => $updateNotes));	
	}
	//Fetch All Notes
	public function fetchAllNotes(){
		
		$collection = $this->db->nf_user_notes;
		
		$resultC = $collection->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => 1));

		return $resultC;		
	}
	
	//Delete Notes
	public function deleteNote($deleteNote){
		
		$collection = $this->db->nf_user_notes;
		
		$collection->remove(array('_id' => new MongoId($deleteNote)));
	}
	
	//Fetch Count Notes
	public function fetchCountNotes($userId){
		
		$collection = $this->db->nf_user_notes;
		
		$resultC = $collection->find(array("user_id" => $userId))->count();	
		
		return $resultC;
	}
	
	public function insertUser($arr){
		
		$collection = $this->db->nf_user;
		
		$insUser = array("user_id" => $_SESSION['user_id'],"company_id" => "1" ,"first_name" => $arr['first_name'],"last_name" => $arr['last_name'],"email_id" => $arr['email'],"password" => md5($arr['password']),"description" => $arr['description'],"phone" => $arr['phone'],"fax" => $arr['fax'],"user_type" => 'EU',"status" => 'A',"created_date" => $this->cfObj->createDate(),"modified_date" => "");
		
		$collection->insert($insUser);			
	}
	
	public function updateUser($arr){
				
		$collection = $this->db->nf_user;		
		
		$editUser = array("company_id" => "1" ,"first_name" => $arr['first_name'],"last_name" => $arr['last_name'],"description" => $arr['description'],"phone" => $arr['phone'],"fax" => $arr['fax'],"modified_date" => $this->cfObj->createDate());
		
		$collection->update(array("_id" => new MongoId($arr['user_id'])),array('$set' => $editUser));				
	}
	
	
	public function searchUserDetails($searchWord){
		$regex =  new MongoRegex("/$searchWord/i");
		
		$collection = $this->db->nf_user_contacts;
		
		$resultC = $collection->find(array("contact_name" => $regex, "status" => 'A'));		
				
		return $resultC;
		
	}
	
	public function searchUserDetailsCount($searchWord){
		$regex =  new MongoRegex("/$searchWord/i");
		
		$collection = $this->db->nf_user_contacts;
		
		$resultC = $collection->find(array("contact_name" => $regex, "status" => 'A'))->count();		
				
		return $resultC;
		
	}
	
	//Delete Notes
	public function deleteUser($userId){
		
		$collection = $this->db->nf_user;
		
		$collection->remove(array('_id' => new MongoId($userId)));
	}
	
	public function checkEmail($emailId){
		
		$collection = $this->db->nf_user;
		
		$resultC = $collection->find(array("email_id" => $emailId))->count();		
				
		return $resultC;
		
	}
	
	public function userActiveDeactive($userId, $status){
		
		$collection = $this->db->nf_user;
		
		$updateInfo = array("status"=>$status);
		
		$restultC = $collection->update(array("_id" => new MongoId($userId)),array('$set' => $updateInfo));
		
		return $resultC;
	}
	
	public function changePassword($userId, $chgPwd){
	
		$collection = $this->db->nf_user;
		
		$updateInfo = array("password"=>$chgPwd);
		
		$restultC = $collection->update(array("_id" => new MongoId($userId)),array('$set' => $updateInfo));
		
		return $resultC;
	}
	
}
?>