<?php
ob_start();
session_start();
include("model/commonFunctions.php");
include("controller/userController.php");
$userContObj = new userController();

if(isset($_REQUEST['keyword']) && !empty(isset($_REQUEST['keyword'])) ){		
	$autoVals = $userContObj->searchContact($_REQUEST['keyword']);
	print_r($autoVals);	
}


if(isset($_GET['tagId'])){
	$userContObj->deleteTag($_GET['tagId'],$_SESSION['user_id']);	
}

?>