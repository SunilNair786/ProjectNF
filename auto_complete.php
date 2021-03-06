<?php
error_reporting(1);
ob_start();
session_start();
include("model/commonFunctions.php");
include("controller/userController.php");
include("controller/faxController.php");

$userContObj = new userController();
$faxObjCon = new faxController();

// if(isset($_REQUEST['keyword']) && !empty(isset($_REQUEST['keyword'])) ){		
// 	$autoVals = $userContObj->searchContact($_REQUEST['keyword']);
// 	print_r($autoVals);	
// }


if(isset($_GET['tagId']) && $_GET['tag_sec']=="TagsDelete"){
	$userContObj->deleteTag($_GET['tagId'],$_SESSION['user_id']);	
}

// update favorites
if(isset($_GET['fax_id']) && isset($_GET['fav_val']) && $_GET['fav_val'] != ""){	
	$faxObjCon->updateFavorites($_GET['fax_id'],$_GET['fav_val']);	
}

// update fax read count
if(isset($_GET['fax_id'])){
	$faxObjCon->updateReadCount($_GET['fax_id']);	
}

// updating seen or Unseen
if(isset($_GET['Sfax_id']) && $_GET['section'] == "seen")
{
	$faxObjCon->updatefaxSeenStatus($_GET['Sfax_id']);	
}

if(isset($_GET['email']) && $_GET['email'] !='' ){
	$verify = $userContObj->checkEmail($_GET['email']);	
	if($verify > 0){
		echo "Email id exists!.";			
	}else{
		echo "";
	}	
}

// adding tags to faxs
if($_GET['section']=="tagsAdd" && isset($_GET['tagfaxs']))
{
	$faxObjCon->updateFaxTags($_GET);
}

// adding tags to Outbox faxs
if($_GET['section']=="Outbox_tagsAdd" && isset($_GET['tagfaxs']))
{
	$faxObjCon->updateOutboxTags($_GET);
}

// checking for duplicate tags
if($_POST['Section'] == "tagsDup" && $_POST['tagNam'] != "")
{
	echo $rees = $faxObjCon->checktags($_POST);
}

// checking for duplicate groups
if($_POST['Section'] == "groupsDup" && $_POST['groupNam'] != "")
{
	echo $grpstot = $faxObjCon->checkgroupsNam($_POST);
}

// Inbox Delete
if($_GET['section'] == "inboxdel" && $_GET['inb_fax_id'] != "")
{
	$faxObjCon->deleteFax($_GET['inb_fax_id']);
}

// checking for Contact Names
if($_POST['Section'] == "grpContactCheck" && $_POST['ContName'] != "")
{
	echo $grpres = $faxObjCon->checkEmail($_POST);
}
?>