<?php
error_reporting(1);
ob_start();
session_start();

include("model/commonFunctions.php");
include("controller/userController.php");
$userContObj = new userController();

if($_POST['submits'] == "Sign In")
{
	$countVal = $userContObj->userLogin($_POST);

	if($countVal>0 && $_SESSION['user_id']!="")
	{
		header("location:index.php");exit;
	}
	else
	{		
		header("location:login.php?err=done");exit;
	}
}

if($_SESSION['user_id']!="")
{
    header("location:index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Remove Tap Highlight on Windows Phone IE -->
		<meta name="msapplication-tap-highlight" content="no"/>

		<link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

		<title>Next Fax - Login</title>

		<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

		<!-- uikit -->
		<link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css"/>

		<!-- altair admin login page -->
		<link rel="stylesheet" href="assets/css/login_page.min.css" />
		<style type="text/css">
		*{
			border-radius: 0 !important;
		}
		body{
			margin: 0;
			padding: 0;
		}
		.login_page a {
			color: #000;
			text-decoration: underline;
		}
		.md-card {
			background: #fff;
			position: relative;
			box-shadow: 0 1px 3px rgba(0,0,0,.12),0 5px 20px rgba(0,0,0,.1);
			border: none;
		}
		.next-text{
			color: #708391;
			font-size: 2.5em;
			font-weight: lighter;
			text-transform: uppercase;
			line-height: 0.5em;
		}
		.next-text b{
			font-weight: 400;
		}
		.next-text small{
			font-size: 11px;
			letter-spacing: 1px;
		}
		.btns{
			background: #637685;
			color: white !important;
			border-radius:0px;
			padding: 10px;
			font-size: 25px !important;
			font-weight: 100 !important;
			text-decoration: none !important;
		}
		.md-btn-primary, .md-btn-primary:active, .md-btn-primary:focus, .md-btn-primary:hover {
			background: #708391;
			color: #fff;
		}
		.md-btn:active, .md-btn:focus, .md-btn:hover, .uk-button-dropdown.uk-open>.md-btn{
		    box-shadow: 0 10px 20px rgba(0,0,0,.0),0 6px 6px rgba(0,0,0,.0);
		}
		.icheckbox_md.checked, .icheckbox_md.hover.checked {
			background: #637685;
			border-color: #637685;
		}
		</style>

</head>
<body class="login_page">

		<div class="login_page_wrapper">
				<div class="md-card" id="login_card">
						<div class="md-card-content large-padding" id="login_form">
							<div class="login_heading">
								<div class="user_avatars next-text">ne<b>x</b>t fa<b>x</b> <br>
									<small>Caption here</small>
								</div>
								<?php if($_GET['err']=="done"){?>
								<span style="color:red;position:absolute;margin-left:-100px;" id="errorMsg">Please Enter Valid Credentials</span>
								<?php } ?>
							</div>
							<form name="loginForm" method="post">
									<div class="uk-form-row">
											<label for="login_email">Email</label>
											<input class="md-input" type="email" id="login_email" name="login_email" required />
									</div>
									<div class="uk-form-row">
											<label for="login_password">Password</label>
											<input class="md-input" type="password" id="login_password" name="login_password" required />
									</div>
									<div class="uk-margin-medium-top">
											<input type="submit" name="submits" class="md-btn md-btn-primary md-btn-block md-btn-large btns" value="Sign In">
									</div>
                                    
									<div class="uk-margin-top">
											<a href="#" id="password_reset_show" class="uk-float-right">Forgot Password?</a>
											<span class="icheck-inline">
												<!-- <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck />
												<label for="login_page_stay_signed" class="inline-label">Stay signed in</label> -->
											</span>
									</div>
							</form>
						</div>						
						<div class="md-card-content large-padding" id="login_password_reset" style="display: none">
								<button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
								<h2 class="heading_a uk-margin-large-bottom">Reset password</h2>
								<form>
										<div class="uk-form-row">
												<label for="login_email_reset">Your email address</label>
												<input class="md-input" type="text" id="login_email_reset" name="login_email_reset" />
										</div>
										<div class="uk-margin-medium-top">
												<a href="index.html" class="md-btn md-btn-primary md-btn-block btns">Reset password</a>
										</div>
								</form>
						</div>
						<div class="md-card-content large-padding" id="register_form" style="display: none">
								<button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
								<h2 class="heading_a uk-margin-medium-bottom">Create an account</h2>
								<form>
										<div class="uk-form-row">
												<label for="register_username">Username</label>
												<input class="md-input" type="text" id="register_username" name="register_username" />
										</div>
										<div class="uk-form-row">
												<label for="register_password">Password</label>
												<input class="md-input" type="password" id="register_password" name="register_password" />
										</div>
										<div class="uk-form-row">
												<label for="register_password_repeat">Repeat Password</label>
												<input class="md-input" type="password" id="register_password_repeat" name="register_password_repeat" />
										</div>
										<div class="uk-form-row">
												<label for="register_email">E-mail</label>
												<input class="md-input" type="text" id="register_email" name="register_email" />
										</div>
										<div class="uk-margin-medium-top">
												<a href="index.html" class="md-btn md-btn-primary md-btn-block md-btn-large btns">Sign Up</a>
										</div>
								</form>
						</div>
				</div>
				
		</div>
        <div class="uk-margin-top uk-text-center">
            <a id="signup_form_show" href="#" style="color: #1e88e5;text-decoration:none;">Create an account</a>
        </div>

		<!-- common functions -->
		<script src="assets/js/common.min.js"></script>
		<!-- altair core functions -->
		<script src="assets/js/altair_admin_common.min.js"></script>

		<!-- altair login page functions -->
		<script src="assets/js/pages/login.min.js"></script>
		<script type="text/javascript">
			$(window).load(function(){
					var windheight = $(window).height()/ 4;
					// alert(windheight);
					$('.login_page_wrapper').css('margin-top' , windheight + 'px');
				}
			)
		</script>
</body>
</html>