<?php
include_once("../connection.php");
if($_POST['login'] == "Login")
{
	if($_POST['usr_email'] != "" && $_POST['usr_password'] != "")
	{
		 $qqry_select = "SELECT * FROM  admin WHERE admin_email = '".addslashes(trim($_POST['usr_email']))."' AND admin_pass = '".addslashes(trim($_POST['usr_password']))."' ";
		$qry_select = mysql_query($qqry_select);
		//echo 'count==='.$count = mysql_num_rows($qry_select);
		if(mysql_num_rows($qry_select) == 1)
		{
			echo $user = mysql_fetch_assoc($qry_select);
			$_SESSION['usr_id'] = $user['admin_id'];
			$_SESSION['usr_fname'] = $user['admin_name'];
			//die();
			header("Location: employee.php");
			exit();
		}
		else
		{
			$_SESSION['msg'] = "Please enter valid Email Address and Password";		
		}	
	}
	else
	{
		$_SESSION['msg'] = "Please enter Email Address and Password";
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $DOMAIN_NAME;?></title>
<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>

<body>
<header>
  <div id="warp_inner">
  
   <h1>Login</h1>
   
   
    
  </div>
</header>
<div class="clear"></div>

<div id="wrapbg">
 
  <div id="wrapper">
    
   
    <section>
   
      <article  style="width:560px;">
      
      <div id="logo"><a href="index.html"><img src="images/logoa.png"  alt="" /></a></div>
        <div id="login">
<?php
if($_SESSION['msg'] != "")
{
	echo '<div class="error_msg">'.$_SESSION['msg'].'</div>';
	$_SESSION['msg'] = '';
}
?>
<form action="login.php" enctype="multipart/form-data" name="login" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td class="bold aright">Email Address : </td>
      <td><input type="text" name="usr_email" id="usr_email" /></td>
    </tr>
    <tr>
      <td class="bold aright">Passowrd : </td>
      <td><input type="password" name="usr_password" id="usr_password" /></td>
    </tr>
    
    <tr>
      <td colspan="2" align="center"><input type="submit" name="login" class="btn" value="Login" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
 </form>
</div>

        <div class="clear"></div>
      </article>
     
      <div class="clear"></div>
    </section>
    <div class="clear"></div>
  </div>
  <!-- wrapper ends here -->
  <div class="clear"></div>
</div>
<!-- bgwrapper ends here -->
</body>
</html>
