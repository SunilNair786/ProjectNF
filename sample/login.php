<?php
error_reporting(1);
include("../model/classUsers.php");
include("../model/commonFunctions.php");
$userObj = new users();
$cfObj = new commonFunctions();

$m = new MongoClient();

$db = $m->nextfax;

$collection = $db->nf_user;

$document = array("first_name" => "Hema","last_name" => "Sundar","email_id"=>"hemasundar@nextfax.com","password" => $cfObj->generatePassword('123456'),"description"=>"testing purpose","profile_pic"=>"","mobile"=>"564635453","fax"=>"","user_type"=>"EU","created_date"=>$cfObj->createDate(),"modified_date"=>"","status"=>"A");
$collection->insert($document);

//$collection->update(array("title"=>"firstName"), array('$set'=>array("first_name"=>'test')));

if($_POST['submit']=="SignUp")
{
	$Fname = $_POST['FName'];
	$FieldNames = array( "FirstName" => $_POST['FName'],"LastName" => "Lambda","email"=>"testing1@gmail.com","password" => "$var", "online" => true );
	$collection->insert($FieldNames);
}



if($_POST['submit']=="Login")
{
	$Chusers = $userObj->checkAuthentication();

	$email = $_POST['usermail'];
	$PWD = base64_encode($_POST['Upassword']);

	$resUser = $collection->find(array("email" => "$email" , "password" => "$PWD"));

	foreach ($resUser as $UserData) {
	    echo @$UserData["FirstName"] . "\n";
	}
}

$wwwe = $collection->find()->limit(10)->skip(15);

//echo json_encode($wwwe);

foreach ($wwwe as $rData) {
	    echo @$rData["_id"] . "\n";
	}
?>

<div align="left" style="position:absolute;">
	<form name="login" method="post">	
	    <table>
	    	<tr>
	    		<td>First Name</td>
	    		<td>: <input type="text" name="FName" placeholder="First Name" Required></td>
	    	</tr>
	    	<tr>
	    		<td>Last Name</td>
	    		<td>: <input type="text" name="LName" placeholder="Last Name" Required></td>
	    	</tr>
	        <tr>
	        	<td>Email</td>
	        	<td>: <input type="email" name="usermail" placeholder="yourname@email.com" required></td>
	        </tr>        
	        <tr>
	        	<td>Password</td>
	        	<td>: <input type="password" name="Upassword" placeholder="password" required></li></td>                        
	        </tr>
	        <tr>
	    		<td>Mobile</td>
	    		<td>: <input type="text" name="mobile" placeholder="Mobile No." Required></td>
	    	</tr>
	        <tr height="5"></tr>
	        <tr>
	        	<td></td>
	        	<td>&nbsp;&nbsp;<input type="submit" name="submit" value="SignUp"></td>
	        </tr>
	    </table>            
	</form>
</div>


<div align="center">
	<form name="login" method="post">	
	    <table>
	        <tr>
	        	<td>Email</td>
	        	<td><input type="email" name="usermail" placeholder="yourname@email.com" required></td>
	        </tr>        
	        <tr>
	        	<td>Password</td>
	        	<td><input type="password" name="Upassword" placeholder="password" required></li></td>                        
	        </tr>
	        <tr>
	        	<td colspan="2"><input type="submit" name="submit" value="Login"></td>
	        </tr>
	    </table>            
	</form>
</div>
