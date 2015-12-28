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

if($_GET['fax_id'] != "")
{	
	$faxObjCon->updateFavorites($_GET['fax_id'],$_GET['fav_val']);	
}

?>