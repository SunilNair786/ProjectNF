
<?php include_once('includes/header.php'); ?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php'); ?>
<!-- main sidebar end -->
<?php

if(isset($_REQUEST['default_action']) && $_REQUEST['default_action'] == 'addUser' ){
	echo "I m here";
	$arrUser['first_name'] = $_POST['first_name'];
	$arrUser['last_name'] = $_POST['last_name'];
	$arrUser['email'] = $_POST['email'];
	$arrUser['password'] = $_POST['password'];	
	$arrUser['phone'] = $_POST['phone'];
	$arrUser['fax'] = $_POST['fax'];
	$arrUser['description'] = $_POST['description'];	
	$userContObj->insertUser($arrUser);
	
}
?>
<div id="page_content">
	<div id="page_content_inner">
<div class="uk-width-large-8-10 uk-container-center">
		<h3 class="heading_b uk-margin-bottom">Users</h3>

		<div class="md-card">
			<div class="md-card-content">
				<h3 class="heading_a">All  
					<a class="md-btn md-btn-success pull-right" href="#Groups_new" data-uk-modal="{center:true}">
						Create  User
					</a>
				</h3>
				<div class="uk-grid" data-uk-grid-margin>
					<div class="uk-width-large-1">
						
						<div class="md-card-list-wrapper" id="mailbox">                
							<div class="md-card-list">
								<ul class="hierarchical_slide">
									<?php 
									$incc = 1;
									$collection = $db->nf_user_groups; 
									$allgroups = $collection->find()->sort(array("created_date" => -1));

									foreach($allgroups as $indGroup)
									{
									?>
									<li>
		                            	<ul class="options">
											<li><a href="#Edit_Grp<?php echo $incc;?>" data-uk-modal="{center:true}"><i class="fa fa-edit"></i> </a></li> 		
											<li><a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'groups.php?action=delete&id=<?php echo $indGroup['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a></li>				
										</ul>
										<span class="md-card-list-item-date"><?php $dates=strtotime($indGroup['created_date']); echo date("j M",$dates); ?></span>
										<div class="md-card-list-item-select">
											<input type="checkbox" name="groupCheck" data-md-icheck />
										</div>										
										<div class="md-card-list-item-sender">
											<span><?php echo $indGroup['group_name']; ?></span>
										</div>										

										<div class="uk-modal" id="Edit_Grp<?php echo $incc;?>">
									        <div class="uk-modal-dialog">
									        <button class="uk-modal-close uk-close" type="button"></button>
									            <form>
										<div class="uk-form-row">
												<label for="register_username">Change Username</label>
												<input class="md-input" type="text" id="register_username" name="register_username" />
										</div>
										 
										<div class="uk-form-row">
												<label for="register_password_repeat">Change Password</label>
												<input class="md-input" type="text" id="register_password_repeat" name="register_password_repeat" />
										</div>
										<div class="uk-form-row">
												<label for="register_email">Change E-mail</label>
												<input class="md-input" type="text" id="register_email" name="register_email" />
										</div>
										 
								
									                <div class="uk-modal-footer">  								                	           
									                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Update" />
									                </div>
									            </form>
									        </div>
									    </div>
									</li>
									<?php $incc++; } ?>

								</ul>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="uk-width-medium-1-4">
            
        </div>

        <!-- Create New Group -->
	    <div class="uk-modal" id="Groups_new">
	        <div class="uk-modal-dialog">
	        <button class="uk-modal-close uk-close" type="button"></button>
	             <form name='userReg' method='post' action='usermanagement.php' >
				 <input type='hidden' name='default_action' id='default_action' value='addUser' />
										<div class="uk-form-row">
												<label for="register_username">First Name</label>
												<input class="md-input" type="text" id="first_name" name="first_name" required//>
										</div>
										<div class="uk-form-row">
												<label for="register_username">Last Name</label>
												<input class="md-input" type="text" id="last_name" name="last_name" required />
										</div>
										<div class="uk-form-row">
												<label for="register_email">E-mail</label>
												<input class="md-input" type="text" id="email" name="email" required />
										</div>
										<div class="uk-form-row">
												<label for="register_password">Password</label>
												<input class="md-input" type="password" id="password" name="password" required />
										</div>
										<div class="uk-form-row">
												<label for="register_email">Phone Number</label>
												<input class="md-input" type="text" id="phone" name="phone" required />
										</div>
										<div class="uk-form-row">
												<label for="register_email">Fax</label>
												<input class="md-input" type="text" id="fax" name="fax"  required/>
										</div>
										<div class="uk-form-row">
												<label for="register_email">User Description</label>
												<textarea class="md-input" type="text" id="descrption" name="descrption"  required/></textarea>
												<span style='color:red;' id='error_content'></span>												
										</div>
										
										<div class="uk-margin-medium-top">
										 <input type="button" class="md-btn md-btn-primary md-btn-block md-btn-large btns" name="btnSubmit" value="Sign Up"  onclick='javascript:formSubmit();' />
											
										</div>
								</form>
	        </div>
	    </div>
	    <!-- End New Group -->
	</div>
    
    </div>
</div>

	<!-- google web fonts -->
	<script>
		WebFontConfig = {
			google: {
				families: [
					'Source+Code+Pro:400,700:latin',
					'Roboto:400,300,500,700,400italic:latin'
				]
			}
		};
		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})();
	</script>

	<!-- common functions -->
	<script src="assets/js/common.min.js"></script>
	<!-- uikit functions -->
	<script src="assets/js/uikit_custom.min.js"></script>
	<!-- altair common functions/helpers -->
	<script src="assets/js/altair_admin_common.min.js"></script>


	<script>
		$(function() {
			// enable hires images
			altair_helpers.retina_images();
			// fastClick (touch devices)
			if(Modernizr.touch) {
				FastClick.attach(document.body);
			}
		});
	</script>


	<div id="style_switcher">
		<div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
		<div class="uk-margin-medium-bottom">
			<h4 class="heading_c uk-margin-bottom">Colors</h4>
			<ul class="switcher_app_themes" id="theme_switcher">
				<li class="app_style_default active_theme" data-app-theme="">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_a" data-app-theme="app_theme_a">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_b" data-app-theme="app_theme_b">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_c" data-app-theme="app_theme_c">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_d" data-app-theme="app_theme_d">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_e" data-app-theme="app_theme_e">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_f" data-app-theme="app_theme_f">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
				<li class="switcher_theme_g" data-app-theme="app_theme_g">
					<span class="app_color_main"></span>
					<span class="app_color_accent"></span>
				</li>
			</ul>
		</div>
		<div class="uk-visible-large uk-margin-medium-bottom">
			<h4 class="heading_c">Sidebar</h4>
			<p>
				<input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
				<label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
			</p>
		</div>
		<div class="uk-visible-large">
			<h4 class="heading_c">Layout</h4>
			<p>
				<input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
				<label for="style_layout_boxed" class="inline-label">Boxed layout</label>
			</p>
		</div>
	</div>

	
	 <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>
  
    <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>

    <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>
	<script src="assets/js/common_nf.js"></script>
	<script>
		
	function formSubmit(){
		document.getElementById("error_content").innerHTML = '';
		var email = document.getElementById('email').value;
		var phone = document.getElementById('phone').value;
		if(!ValidateEmail(email)){
			return false;
		}
		if(!isNormalInteger(phone)){
			alert("Please enter proper phone number.")
			return false;
		}else{
			if( phone.length > 10){
				alert("Phone length should not greather than 10 digits")
				return false;
			}
		}
		var descrption = trimAll(document.getElementById('descrption').value);
		if(descrption ==''){				
			document.getElementById("error_content").innerHTML = 'Please enter description.';
			return false;
		}
		//document.userReg.submit();
		var frm = document.userReg;
		frm.action = 'usermanagement.php';
		frm.submit();		
	}

</script>
</body>
</html>