<?php
include_once('model/faxModel.class.php');
class faxController{

	public $faxObj;
	
	public function __construct(){
		$this->faxObj =  new faxModel();	
		$this->cfObj = new commonFunctions();	
	}		
	
	public function copyFiles($post,$files){		
		$faxdata = $this->faxObj->insertFax($post);
		return $faxdata;
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

	// Updating Outbox faxs Tags
	public function updateOutboxTags($Cpost)
	{
		$tags_fax = $this->faxObj->update_outbox_tags($Cpost);
		return $tags_fax;
	}

	// checking Tags for duplication
	public function checktags($Cpost)
	{
		$tags_dupl = $this->faxObj->check_tags_duplicate($Cpost);
		return $tags_dupl;
	}

	// checking Groups for duplication
	public function checkgroupsNam($Cpost)
	{
		$grpss_dupl = $this->faxObj->check_groups_duplicate($Cpost);
		return $grpss_dupl;
	}

	// checking Contact Names
	public function checkEmail($Cpost)
	{
		$group_cnt = $this->faxObj->check_contactName($Cpost);
		return $group_cnt;
	}

	// Deleting Outbox Faxs
	public function deleteOutboxFax($Cpost)
	{
		$outbox_fax = $this->faxObj->deleteOutbox_Fax($Cpost);
		return $outbox_fax;
	}
	
}

?>