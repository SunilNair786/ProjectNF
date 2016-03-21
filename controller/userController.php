<?php
include("model/classUsers.php");

class userController
{
	public $userClsObj;
	public function __construct(){
		$this->userClsObj = new users();			
	}

	public function userLogin($post){	 
		$cVal = $this->userClsObj->checkAuth($post);

		if($cVal>0)
		{
			$resDetail = $this->userClsObj->getDetails($post);

			$_SESSION['user_id'] = $resDetail['_id'];
			$_SESSION['firstName'] = $resDetail['first_name'];
			$_SESSION['lastName'] = $resDetail['last_name'];
			$_SESSION['userEmail'] = $resDetail['email_id'];
			$_SESSION['userType'] = $resDetail['user_type'];
			$_SESSION['fax'] = $resDetail['fax'];
		}

		return $cVal;
	}

	// Insert the contact.
	public function insertContact($postV){
		$contactVal = $this->userClsObj->insertContRecord($postV);
		return $contactVal;
	}
	// Updating Contacts
	public function updateContact($postC){
		$UpdcontactVal = $this->userClsObj->updateContRecord($postC);
		return $UpdcontactVal;
	}
	// Delete Contact
	public function deleteContact($postC){
		$deleteContact = $this->userClsObj->deleteContRecord($postC);
		return $deleteContact;
	}


	// Inserting Groups
	public function insertgroup($postV){
		$grpVal = $this->userClsObj->insertGrpRecord($postV);
		return $grpVal;
	}

	// Updating Groups
	public function updategroup($post)
	{
		$editGrpVal = $this->userClsObj->updateGrpRecord($post);
		return $editGrpVal;
	}

	//Deleting Groups
	public function deletegroup($post)
	{
		$delGrpVal = $this->userClsObj->deleteGrpRecord($post);
		return $delGrpVal;
	}
	// Searching a contact from the list

	/*public function searchContact($contactName){
		$serachContact = $this->userClsObj->searchContact($contactName);	
	}*/



	// Creating Tags
	public function TagInsert($post)
	{
		$insTagval = $this->userClsObj->tagsInserting($post);
		return $insTagval;
	}
	//Editing Tags
	public function TagEditing($Cpost)
	{
		$editTagval = $this->userClsObj->TagsEdit($Cpost);
		return $editTagval;
	}
	
	//delete Tags
	public function deleteTag($postVal,$userId){
		$deleteTags = $this->userClsObj->deleteTags($postVal,$userId);
		return $deleteTags;
	}
	
	// Function for Inserting the Notes
	public function insertNote($arr){
		$insNote = $this->userClsObj->insertNote($arr);
	}
	
	// Function for Inserting the Notes
	public function updateNote($arr){
		$insNote = $this->userClsObj->updateNote($arr);
	}
	
	//Function for fetch allnotes
	public function fetchAllNotes(){
		$fetchAll = $this->userClsObj->fetchAllNotes();
		return $fetchAll;
	}
	
	public function deleteNote($noteId){
		$deleteNote = $this->userClsObj->deleteNote($noteId);
	}
	
	public function fetchCountNotes($userId){		
		$fetchCount  = $this->userClsObj->fetchCountNotes($userId);		
		return $fetchCount;
	}
	
	// Inser new User 
	public function insertUser($arr){		
		$newUser  = $this->userClsObj->insertUser($arr);		
		return $newUser;
	}
	
	// Edit new User 
	public function updateUser($arr){				
		$newUser  = $this->userClsObj->updateUser($arr);			
		return $newUser;
	}
	
	//Search User 
	public function searchUserDetails($strUser){		
		$userDetails  = $this->userClsObj->searchUserDetails($strUser);		
		return $userDetails;
	}
	
	// Search User Count
	public function searchUserDetailsCount($strUser){		
		$userDetails  = $this->userClsObj->searchUserDetailsCount($strUser);		
		return $userDetails;
	}
    
	// Search User Count
	public function checkEmail($emailId){		
		$userDetails  = $this->userClsObj->checkEmail($emailId);		
		return $userDetails;
	}	
	
	public function deleteUser($userId){
		$delUser  = $this->userClsObj->deleteUser($userId);		
		return $delUser;
	}

	public function userActiveDeactive($userId,$status){
		$delUser  = $this->userClsObj->userActiveDeactive($userId,$status);		
		return $delUser;
	}	
		
	public function changePassword($userId,$chgPwd){
		$delUser  = $this->userClsObj->changePassword($userId,$chgPwd);		
		return $delUser;
	}

	
}

?>