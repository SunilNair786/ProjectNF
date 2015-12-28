<?php include_once('includes/header.php');?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php');?>
<!-- main sidebar end -->
<?php
if($_POST['submit'] == "Save")
{
    $cntVal = $userContObj->insertContact($_POST);   
    header('location:contact.php'); 
    exit;
}

// Update Contact
if($_POST['submit'] == "Update")
{
    $updateCon = $userContObj->updateContact($_POST);    
    header('location:contact.php'); 
    exit;
}

// Delete Contact
if($_REQUEST['action'] == "delete")
{
    $deleteCo = $userContObj->deleteContact($_GET['id']);    
    header('location:contact.php'); 
    exit;
}

if(isset($_GET['searchParam'])){	
	$searchUser = $userContObj->searchUserDetails($_GET['searchParam']);	
	$searchUserCnt = $userContObj->searchUserDetailsCount($_GET['searchParam']);	
	
}
?>
<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-width-large-8-10 uk-container-center">
            <h3 class="heading_b uk-margin-bottom">Contact List</h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-vertical-align">
                                <div class="uk-vertical-align-middle">
                                    <ul id="contact_list_filter" class="uk-subnav uk-subnav-pill uk-margin-remove">
                                        <li class="uk-active" data-uk-filter=""><a href="contact.php">All</a></li>
                                        <?php 
                                        $collection = $db->nf_user_groups; 
                                        $allgroups1 = $collection->find();
                                        foreach($allgroups1 as $allgroups12){?>
                                            <li data-uk-filter="<?php echo $allgroups12['group_name']; ?>"><a href="contact.php"><?php echo $allgroups12['group_name']; ?></a></li>
                                        <?php } ?>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
								<form name='searchFrm' action='contact.php' />
									<label for="contact_list_search">Find user</label>
									<input class="md-input" type="text" name ="searchParam" id="searchParam" onkeypress="return searchContact(event)" />
								</form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-5 hierarchical_show" id="contact_list">       

                <?php 
				
				if($searchUserCnt > 0 ){	
					$allContactList = $searchUser;			
					
				}else{
					$Cinc = 1;
					$collection = $db->nf_user_contacts; 
					$allContactList = $collection->find(array("user_id" =>$_SESSION['user_id']))->sort(array("created_date" => -1));
				}	
			   
				if(isset($_GET['searchParam']) && $searchUserCnt  == 0 ){
					echo "<p style='color:red'>No contacts found.</p>";
				}else if ($searchUserCnt  > 1 ){
					
					foreach($allContactList as $contactList){
						$collection = $db->nf_user_groups; 
						$allContactLists1 = $collection->findOne(array('_id' => new MongoId($contactList['group_id'])));
				?>	
					<div data-uk-filter="<?php echo $allContactLists1['group_name']; ?>,<?php echo $contactList["contact_name"];?>">
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
										<img class="md-card-head-avatar" src="assets/img/avatars/avatar_08.png" alt=""/>
									</div>
									<h3 class="md-card-head-text uk-text-center">
										<?php echo $contactList["contact_name"];?>
										<span class="uk-text-truncate">
											<?php echo $allContactLists1['group_name']; ?>                                                  
										</span>
									</h3>
								</div>
								<div class="md-card-content">
									<ul class="md-list">
										<li style="height:70px;">
											<div class="md-list-content">
												<span class="md-list-heading">Info</span>
												<span class="uk-text-small uk-text-muted"><?php echo $contactList["contact_info"];?></span>
											</div>
										</li>
										<li>
											<div class="md-list-content">
												<span class="md-list-heading">Email</span>
												<span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $contactList["email"];?></span>
											</div>
										</li>
										<li>
											<div class="md-list-content">
												<span class="md-list-heading">Phone</span>
												<span class="uk-text-small uk-text-muted"><?php echo $contactList["phone"];?></span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					<?php $Cinc++;  	
						}
				
				}else{	
					foreach($allContactList as $contactList){
						
						// for Group Name
						$collection = $db->nf_user_groups; 
						$allContactLists1 = $collection->findOne(array('_id' => new MongoId($contactList['group_id'])));
				?>

						<div data-uk-filter="<?php echo $allContactLists1['group_name']; ?>,<?php echo $contactList["contact_name"];?>">
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
										<img class="md-card-head-avatar" src="assets/img/avatars/avatar_08.png" alt=""/>
									</div>
									<h3 class="md-card-head-text uk-text-center">
										<?php echo $contactList["contact_name"];?>
										<span class="uk-text-truncate">
											<?php echo $allContactLists1['group_name']; ?>                                                  
										</span>
									</h3>
								</div>
								<div class="md-card-content">
									<ul class="md-list">
										<li style="height:70px;">
											<div class="md-list-content">
												<span class="md-list-heading">Info</span>
												<span class="uk-text-small uk-text-muted"><?php echo $contactList["contact_info"];?></span>
											</div>
										</li>
										<li>
											<div class="md-list-content">
												<span class="md-list-heading">Email</span>
												<span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $contactList["email"];?></span>
											</div>
										</li>
										<li>
											<div class="md-list-content">
												<span class="md-list-heading">Phone</span>
												<span class="uk-text-small uk-text-muted"><?php echo $contactList["phone"];?></span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					<?php $Cinc++; 
					} 
				}	
				?>


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
            <form name="newContact" method="post">
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">New Contact</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_name">Full Name</label>
                    <input type="text" class="md-input" name="contact_name" id="contact_name" required/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_email">Email</label>
                    <input type="text" class="md-input" name="contact_email" id="contact_email" required/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="Group_name">Group Name</label>
                    <select name="GroupName" class="md-input" required>
                        <option value=""></option>
                        <?php
                        $collection = $db->nf_user_groups; 
                        $allGrpList = $collection->find()->sort(array("created_date" => -1));
                        foreach($allGrpList as $all_GrpList){ ?>
                            <option value="<?php echo $all_GrpList['_id']; ?>"><?php echo $all_GrpList['group_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_phone">Phone No</label>
                    <input type="text" class="md-input" name="contact_phone" id="contact_phone" required/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_faxNo">Fax No</label>
                    <input type="text" class="md-input" name="contact_faxNo" id="contact_faxNo" />
                </div>
                <div class="uk-margin-large-bottom">
                    <label for="contact_info">Info</label>
                    <textarea name="contact_info" id="contact_info" cols="30" rows="6" class="md-input"></textarea>
                </div>
                <div class="uk-modal-footer">                    
                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Save" />
                </div>
            </form>
        </div>
    </div>
    <!-- End New Contact -->


    <?php 
    $Cinc1 = 1;
    $collection = $db->nf_user_contacts; 
    $allContactList1 = $collection->find()->sort(array("created_date" => -1));?>
    <script type="text/javascript"> 
     var ii = 1;
    </script>

    <?php foreach($allContactList1 as $contactList1){?>
    <!-- Edit Contact List-->
    <div class="uk-modal" id="Edit_contact_<?php echo $Cinc1;?>">
        <div class="uk-modal-dialog">
        <button class="uk-modal-close uk-close" type="button"></button>
            <form name="newContact" method="post">
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title"><?php echo $contactList1['name']; ?></h3>
                    <input type="hidden" name="hidd_contact_id" id="hidd_contact_id" value="<?php echo $contactList1['_id']; ?>"/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_name">Full Name</label>
                    <input type="text" class="md-input" name="contact_name" id="contact_name" value="<?php echo $contactList1['contact_name']; ?>" required/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_email">Email</label>
                    <input type="text" class="md-input" name="contact_email" id="contact_email" value="<?php echo $contactList1['email']; ?>" required/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="Group_name">Group Name</label>
                    <select name="GroupName" id="GroupName<?php echo $Cinc1; ?>" class="md-input" required>
                        <option value=""></option>
                        <?php
                        $collection = $db->nf_user_groups; 
                        $allGrpList = $collection->find()->sort(array("created_date" => -1));
                        foreach($allGrpList as $all_GrpList){ ?>
                            <option value="<?php echo $all_GrpList['_id']; ?>"><?php echo $all_GrpList['group_name']; ?></option>
                        <?php } ?>
                    </select>
                    <script type="text/javascript">                        
                    for(var i=0;i<document.getElementById('GroupName'+ii).length;i++)
                    {                        
                        if(document.getElementById('GroupName'+ii).options[i].value=="<?php echo $contactList1['group_id']; ?>")
                        {
                            document.getElementById('GroupName'+ii).options[i].selected=true;
                        }
                    }
                    ii++;
                    </script>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_phone">Phone No</label>
                    <input type="text" class="md-input" name="contact_phone" id="contact_phone" value="<?php echo $contactList1['phone']; ?>" required/>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="contact_faxNo">Fax No</label>
                    <input type="text" class="md-input" name="contact_faxNo" id="contact_faxNo" value="<?php echo $contactList1['fax']; ?>" />
                </div>
                <div class="uk-margin-large-bottom">
                    <label for="contact_info">Info</label>
                    <textarea name="contact_info" id="contact_info" cols="30" rows="6" class="md-input"><?php echo $contactList1['contact_info']; ?></textarea>
                </div>
                <div class="uk-modal-footer">                    
                    <input type="button" class="uk-modal-close md-btn md-btn-flat md-btn-flat-primary pull-right" value="Cancel" />             
                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Update" />
                </div>
            </form>
        </div>
    </div>
    <?php $Cinc1++; } ?>
    <!-- End Edit Contact List-->


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

    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $body
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if( $switcher.hasClass('switcher_active') ) {
                    if (
                        ( !$(e.target).closest($switcher).length )
                        || ( e.keyCode == 27 )
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }


        // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });


        // toggle boxed layout

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            // toggle mini sidebar
            $boxed_layout_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });


        });
		
		function searchContact(e) {			
			if (e.keyCode == 13) {				
				var searchKey = document.getElementById("searchParam").value;			
				document.searchFrm.submit();
			}
		}
    </script>
</body>
</html>