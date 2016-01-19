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


if(isset($_GET['tagId'])){
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
?>