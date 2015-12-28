
<?php include_once('includes/header.php');?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php');?>
<!-- main sidebar end -->
<?php

if(isset($_REQUEST['default_action']) && $_REQUEST['default_action'] == 'addUser' ){

	$arrUser['first_name'] = $_POST['first_name'];
	$arrUser['last_name'] = $_POST['last_name'];
	$arrUser['email'] = $_POST['email'];
	$arrUser['password'] = $_POST['password'];	
	$arrUser['phone'] = $_POST['phone'];
	$arrUser['fax'] = $_POST['fax'];
	$arrUser['description'] = $_POST['description'];	
	$userContObj->insertUser($arrUser);	
}

if(isset($_REQUEST['flag']) && $_REQUEST['flag'] == 'edit' ){
	$arrUser['first_name'] = $_POST['edit_first_name'];
	$arrUser['last_name'] = $_POST['edit_last_name'];
	$arrUser['email'] = $_POST['edit_email'];	
	$arrUser['phone'] = $_POST['edit_phone'];
	$arrUser['fax'] = $_POST['edit_fax'];
	$arrUser['description'] = $_POST['edit_description'];	
	$arrUser['user_id'] = $_POST['user_id'];	
	$editUser = $userContObj->updateUser($arrUser);
}

?>
<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-width-large-8-10 uk-container-center">
            <h3 class="heading_b uk-margin-bottom">User Management</h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-vertical-align">
                                <div class="uk-vertical-align-middle">
                                    <ul id="contact_list_filter" class="uk-subnav uk-subnav-pill uk-margin-remove">
                                        <li class="uk-active" data-uk-filter=""><a href="#">All</a></li>
                                        <?php 
                                        $collection = $db->nf_user_groups; 
                                        $allgroups1 = $collection->find();
                                        foreach($allgroups1 as $allgroups12){?>
                                            <li data-uk-filter="<?php echo $allgroups12['group_name']; ?>"><a href="#"><?php echo $allgroups12['group_name']; ?></a></li>
                                        <?php } ?>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <label for="contact_list_search">Find user</label>
                            <input class="md-input" type="text" id="contact_list_search"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-5 hierarchical_show" id="contact_list">       

                <?php 
                $Cinc = 1;
                $collection = $db->nf_user; 
                $allContactList = $collection->find(array("user_id" =>$_SESSION['user_id'],'user_type' => 'EU'))->sort(array("created_date" => -1));
				
                foreach($allContactList as $contactList){					
                ?>   

                    <div data-uk-filter="">
                        <div class="md-card md-card-hover">
                            <div class="md-card-head">
                                <div class="md-card-head-menu" data-uk-dropdown="{pos:'bottom-right'}">
                                    <i class="md-icon material-icons">&#xE5D4;</i>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#Edit_contact_<?php echo $Cinc;?>" data-uk-modal="{center:true}">Edit</a></li>
											
                                            <li><a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'contact.php?action=delete&id=<?php echo $contactList['_id'];?>'; return false;}">Remove</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="uk-text-center">
                                   <a href="userprofile.php?user_id=<?php echo $contactList['user_id'];?>"> <img class="md-card-head-avatar" src="assets/img/avatars/avatar_08.png" alt=""/></a>
                                </div>
                                <a href="userprofile.php?user_id=<?php echo $contactList['user_id'];?>"> <h3 class="md-card-head-text uk-text-center">
                                    <?php echo $contactList["first_name"].' '.$contactList["last_name"];?>
                                    
                                </h3></a>
                            </div>
                            <div class="md-card-content">
                                <ul class="md-list">
                                    <li style="height:70px;">
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Info</span>
                                            <span class="uk-text-small uk-text-muted"><?php echo $contactList["description"];?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Email</span>
                                            <span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $contactList["email_id"];?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Phone</span>
                                            <span class="uk-text-small uk-text-muted"><?php echo $contactList["phone"];?></span>
                                        </div>
                                    </li>
									 <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">Fax</span>
                                            <span class="uk-text-small uk-text-muted"><?php echo $contactList["fax"];?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php $Cinc++; } ?>


            </div>
        </div>
    </div>
    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>

    <!-- Create New Contact -->
    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
        <button class="uk-modal-close uk-close" type="button"></button>
            <form name='userReg' method='post' action='usermanagement.php' >
            <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Create User</h3>
                </div>
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
												<textarea class="md-input" type="text" id="description" name="description"  required/></textarea>
												<span style='color:red;' id='error_content'></span>												
										</div>
										
										<div class="uk-margin-medium-top">
										 <input type="button" class="md-btn md-btn-primary md-btn-block md-btn-large btns" name="btnSubmit" value="Create User"  onclick='javascript:formSubmit();' />
											
										</div>
								</form>
        </div>
    </div>
    <!-- End New Contact -->
<form name="editUser" method='post'  id='editUser' >
 <?php 
                $Cinc = 1;
                $collection = $db->nf_user; 
                $allContactList = $collection->find(array("user_id" =>$_SESSION['user_id'],'user_type' => 'EU'))->sort(array("created_date" => -1));
				
                foreach($allContactList as $contactList){					
?>			

				<!-- Edit Contact List-->
				<div class="uk-modal" id="Edit_contact_<?php echo $Cinc;?>">
					<div class="uk-modal-dialog">
					<button class="uk-modal-close uk-close" type="button"></button>
						
						<input type='hidden' name='user_id' id='user_id' value ='<?php echo $contactList['_id'];?>' />
						
							<div class="uk-form-row">
							<div class="uk-modal-header">
                    <h3 class="uk-modal-title">Edit User</h3>
                </div>
									   <label for="register_username">First Name</label>
												<input class="md-input" type="text" id="edit_first_name" name="edit_first_name" value='<?php echo $contactList["first_name"]; ?>' required//>
										</div>
										<div class="uk-form-row">
												<label for="register_username">Last Name</label>
												<input class="md-input" type="text" id="edit_last_name" name="edit_last_name" value='<?php echo $contactList["last_name"]; ?>' required />
										</div>
										<div class="uk-form-row">
												<label for="register_email">E-mail</label>
												<input class="md-input" type="text" id="edit_email" name="edit_email" value='<?php echo $contactList["email_id"]; ?>' required />
										</div>										
										<div class="uk-form-row">
												<label for="register_email">Phone Number</label>
												<input class="md-input" type="text" id="edit_phone" name="edit_phone" required  value='<?php echo $contactList["phone"]; ?>'/>
										</div>
										<div class="uk-form-row">
												<label for="register_email">Fax</label>
												<input class="md-input" type="text" id="edit_fax" name="edit_fax" value='<?php echo $contactList["fax"]; ?>'  required/>
										</div>
										<div class="uk-form-row">
												<label for="register_email">User Description</label>
												<textarea class="md-input" type="text" id="edit_description" name="edit_description"  required/><?php echo $contactList["description"]; ?></textarea>
												
												<span style='color:red;' id='edit_error_content'></span>												
										</div>
							<div class="uk-modal-footer">                    
								<input type="button" class="uk-modal-close md-btn md-btn-flat md-btn-flat-primary pull-right" value="Cancel" />             
								<input type="button" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="editsubmit" value="Update"  onclick='javascript:updateFrm();' />
							</div>
						
					</div>
				</div>
	<?php
	$Cinc++;
	} ?>
	</form>
    <!-- End Edit Contact List-->


  

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->

    <!--  contact list functions -->
    <script src="assets/js/pages/page_contact_list.min.js"></script>
    
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
	<script src="assets/js/common_nf.js"></script>
    <script>
       
		function formSubmit(){
			document.getElementById("error_content").innerHTML = '';
			var email = trimAll(document.getElementById('email').value);
			alert(email);
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
			var description = trimAll(document.getElementById('description').value);
			if(descrption ==''){				
				document.getElementById("error_content").innerHTML = 'Please enter description.';
				return false;
			}
			//document.userReg.submit();
			var frm = document.userReg;
			frm.action = 'usermanagement.php';
			frm.submit();		
		}
		function updateFrm(){
			document.getElementById("edit_error_content").innerHTML = '';
			var alertMsg = document.getElementById('default_action').value;
			document.getElementById('default_action').value = 'updateUser'
			var email = trimAll(document.getElementById('edit_email').value);	
			var phone = document.getElementById('edit_phone').value;
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
			var description = trimAll(document.getElementById('edit_description').value);
			if(description ==''){				
				document.getElementById("edit_error_content").innerHTML = 'Please enter description.';
				return false;
			}
			//document.userReg.submit();
			var frm = document.editUser;
			frm.action = 'usermanagement.php?flag=edit';
			frm.submit();
		}
		
    </script>
</body>
</html>