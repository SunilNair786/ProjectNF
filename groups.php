<?php include_once('includes/header.php'); ?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php'); ?>
<!-- main sidebar end -->
<?php
if($_POST['grp_submit'] == "Save")
{
	$cont_vals =explode(",",$_POST['hidd_values']);
	$cntVal = $userContObj->insertgroup($_POST); 

	for($ci = "0";$ci < count($cont_vals); $ci++)
	{
		$collection_cont = $db->nf_user_contacts;
		$grp_cont = $collection_cont->findOne(array('_id' => new MongoId($cont_vals[$ci]))); 
		$cont_ids = $grp_cont['_id'];
		if($grp_cont['group_id'] == "")
		{			
			$Update_cont_grp = array("group_id" => $cntVal);
		}
		else
		{			
			$all_valus = $grp_cont['group_id'].','.$cntVal;
			$Update_cont_grp = array("group_id" => $all_valus);
		}
		$updateRes = $collection_cont->update(array('_id' => new MongoId($cont_ids)), array('$set' => $Update_cont_grp));
	}
    header("location:groups.php"); 
    exit;
}

// edit Process
if($_POST['submit'] == "Update")
{
	$cont_vals = explode(",",$_POST['hidd_values']);
	$editGrps = $userContObj->updategroup($_POST);    	

	for($ci = "0";$ci < count($cont_vals); $ci++)
	{
		$collection_cont = $db->nf_user_contacts;
		$grp_cont = $collection_cont->findOne(array('_id' => new MongoId($cont_vals[$ci]))); 
		$cont_ids = $grp_cont['_id'];
		$grp_cont_ids = $grp_cont['group_id'];
		$edt_grp_id = $_POST['grpId'];
		$exists = strpos($grp_cont_ids, $edt_grp_id);
		if ($exists === false) {
			if($grp_cont['group_id'] == "")
			{
				$Update_cont_grp = array("group_id" => $edt_grp_id);
			}
			else
			{
				$all_valus = $grp_cont['group_id'].','.$edt_grp_id;
				$Update_cont_grp = array("group_id" => $all_valus);
			}
			$updateRes = $collection_cont->update(array('_id' => new MongoId($cont_ids)), array('$set' => $Update_cont_grp));
		}		
	}
    header("location:groups.php"); 
    exit;
}
// Delete Process
if($_REQUEST['action'] == "delete")
{
    $DelGrps = $userContObj->deletegroup($_GET['id']);   
    header("location:groups.php"); 
    exit;
}

$sessId = $_SESSION['user_id'];
?>

<style type="text/css">
.ui-widget-content
{
    z-index: 9999 !important;
}
</style>
<div id="page_content">
<div id="page_content_inner">
<div class="uk-width-large-8-10 uk-container-center">
		<h3 class="heading_b uk-margin-bottom">Groups</h3>

		<div class="md-card">
			<div class="md-card-content">
				<h3 class="heading_a">All  
					<a class="md-btn md-btn-success pull-right" href="#Groups_new" data-uk-modal="{center:true}">
						Create a Group
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
									$allgroups = $collection->find(array('user_id' => $_SESSION['user_id']))->sort(array("created_date" => -1));
									$allgroupsCount = $collection->find(array('user_id' => $_SESSION['user_id']))->count();

									if($allgroupsCount > 0)
									{

										foreach($allgroups as $indGroup)
										{
										?>
										<li>
			                            	<ul class="options">
												<li><a href="#Edit_Grp<?php echo $incc;?>" data-uk-modal="{center:true}" title="Edit"><i class="fa fa-edit"></i> </a></li> 		
												<li><a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'groups.php?action=delete&id=<?php echo $indGroup['_id'];?>'; return false;}" title="Delete"><i class="fa fa-trash"></i></a></li>				
											</ul>
											<span class="md-card-list-item-date"><?php $dates=strtotime($indGroup['created_date']); echo date("j M",$dates); ?></span>
											<div class="md-card-list-item-select">
												<input type="checkbox" name="groupCheck" data-md-icheck />
											</div>		
											<?php
							                $userId_arr = explode(',',$indGroup['user_ids']);
							                //print_r($userId_arr); exit;
							                $udetailemail = '';
							                $udetail = '';
	                    					$uIds = '';
							                for($i = 0; $i < sizeof($userId_arr); $i++)
							                {
							                	$ws = $userId_arr[$i];
							                	$collection_user = $db->nf_user;
							                	$collection_contact_user = $db->nf_user_contacts;
							                	$CoutUserDetail = $collection_user->find(array('_id' => new MongoId($userId_arr[$i])))->count();
							                	$CoutContaUser = $collection_contact_user->find(array('_id' => new MongoId($userId_arr[$i])))->count();
							                	if($CoutUserDetail > 0)
							                	{
							                		$UserDetail = $collection_user->findOne(array('_id' => new MongoId($userId_arr[$i])));
							                		$udetailemail .= $UserDetail['first_name']." ".$UserDetail['last_name']." (".$UserDetail['email_id']."), ";
			                                        $udetail .= $UserDetail['first_name']." ".$UserDetail['last_name'].",";
			                                        $uIds .= $UserDetail['_id'].",";
							                	}
							                	else
							                	{
							                		$ContactUser = $collection_contact_user->findOne(array('_id' => new MongoId($userId_arr[$i])));						                		
							                		$udetailemail .= $ContactUser['contact_name']." (".$ContactUser['email']."), ";
			                                        $udetail .= $ContactUser['contact_name'].",";
			                                        $uIds .= $ContactUser['_id'].",";
							                	}
							                }
							                ?>
											<div class="md-card-list-item-sender">
												<span><?php echo $indGroup['group_name']; ?></span>
											</div>										
											<br><?php echo substr($udetail,0,-1); ?>

											<div class="uk-modal" id="Edit_Grp<?php echo $incc;?>">
										        <div class="uk-modal-dialog">
										        <button class="uk-modal-close uk-close" type="button"></button>
										            <form name="EditnewGroup" method="post">
										                <div class="uk-modal-header">
										                    <h3 class="uk-modal-title">Group</h3>
										                </div>
										                <div class="uk-margin-medium-bottom">
										                    <label for="grpName">Group Name</label>
										                    <input type="text" class="md-input" name="grpName" id="grpName" value="<?php echo $indGroup['group_name']; ?>"pattern="[a-zA-z0-9 ]{0,50}" required title="Please Enter AlphaNumeric Only"/>
										                    <input type="hidden" name="grpId" id="grpId" value="<?php echo $indGroup['_id']; ?>"/>
										                    <input type="hidden" name="hidd_grpName" id="hidd_grpName" value="<?php echo $indGroup['group_name']; ?>"/>
										                </div>
										                <div class="uk-margin-medium-bottom">
										                    <label for="grpName">Contact Name</label>									                    
										                    <input type="text" class="md-input" name="contactName" id="contactName_<?php echo $incc;?>" value="<?php echo $udetailemail; ?>" required/>				
										                    <input type="hidden" name="hidd_labels" id="labels<?php echo $incc;?>" value="<?php echo $udetailemail;?>">   
										                    <input type="hidden" name="hidd_values" id="values<?php echo $incc;?>" value="<?php echo $uIds; ?>"> 	
										                    <?php $auto_edit_cont .= "#contactName_".$incc.',';?>		
										                </div>

										                <div class="uk-modal-footer">       
										                	<input type="button" class="uk-modal-close md-btn md-btn-flat md-btn-flat-primary pull-right" value="Cancel" />             
										                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Update" />
										                </div>
										            </form>
										        </div>
										    </div>
										</li>
										<?php $incc++; } 
									}
									//If Condition End
									else
									{?>
										<li>
											<div class="md-card-list">                
						                    	<center>
						                    		<img src="assets/img/group_icon.png" alt="No Faxs Found" height="150" width="200">
						                    		<br><br>Oops..! No Groups Found here....
						                    	</center>
					                    	</div>
										</li>
									<?php }
									// Else Condition End ?>
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
	            <form name="newGroup" id="newGroup"method="post" onsubmit="return checkcontacts();">
	                <div class="uk-modal-header">
	                    <h3 class="uk-modal-title">New Group</h3>
	                </div>
	                <div class="uk-margin-medium-bottom">
	                    <label for="grpName">Group Name</label>
	                    <input type="text" class="md-input" name="grpName" id="grpNameAdd" pattern="[a-zA-z0-9 ]{0,50}" required title="Please Enter AlphaNumeric Only"/>
	                </div>
	                <div class="uk-margin-medium-bottom">
	                    <label for="grpName">Contact Name</label>
	                    <input type="text" class="md-input" name="contactName" id="contactName" required/><br>
	                    <small>*Please Add people from your Contacts only.</small>
	                    <input type="hidden" name="hidd_labels" id="labels">   
                    	<input type="hidden" name="hidd_values" id="values">    
                    	<input type="hidden" name="grp_submit" value="Save">
	                </div>
	                <div class="uk-modal-footer">       
	                	<input type="button" class="uk-modal-close md-btn md-btn-flat md-btn-flat-primary pull-right" value="Cancel" />             
	                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="grp_submit" value="Save" />
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
	</script>
	 <!--  forms advanced functions -->
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
    <script src="assets/js/pages/forms_advanced.min.js"></script>
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

		// Auto complete for contact and user names
		$(function() {
            function split( val ) {
            return val.split( /,\s*/ );
            }
            function extractLast( term ) {
            return split( term ).pop();
            }

            var usedItems = [];
                 
            var projects = [
            <?php             
                $collection = $db->nf_user_contacts;
                $autoComp = $collection->find(array('user_id'=>$sessId));
                foreach ($autoComp as $keys) {?>
                {
                    value: "<?php echo $keys['_id'];?>",
                    label: "<?php echo $keys['contact_name'];?> (<?php echo $keys['fax'];?>)"
                }, 
                <?php } ?>
            // Showing Users
            <?php             
                /*$collection = $db->nf_user;
                $usersAutoComp = $collection->find();
                foreach ($usersAutoComp as $users_AutoComp) {?>
                    {
                        value: "<?php echo $users_AutoComp['_id'];?>",
                        label: "<?php echo $users_AutoComp['first_name'];?> <?php echo $users_AutoComp['last_name'];?> (<?php echo $users_AutoComp['email_id'];?>)"
                    },
                <?php }*/ ?>
            ];
                 
            $( "<?php echo $auto_edit_cont;?>#contactName" )         
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                	var newNonDuplicatetag = $.grep(projects, function(el){return $.inArray(el, usedItems) == -1});                 	
                // delegate back to autocomplete, but extract the last term
                response( $.ui.autocomplete.filter(
                newNonDuplicatetag, extractLast( request.term ) ) );//projects
                },

                //    source:projects,    
                focus: function() {
                // prevent value inserted on focus
                return false;
                },
                select: function( event, ui ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                //Avoid repeated value
                usedItems.push(ui.item.label);
                // add the selected item
                terms.push( ui.item.label );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                    
                    var selected_label = ui.item.label;
                    var selected_value = ui.item.value;
                    
                    var labels = $('#labels').val();
                    var values = $('#values').val();

                    var str =$(this).attr('id');
                    var ret = str.split("_");					
					var str2 = ret[1];					

                    var labels1 = $('#labels'+str2).val();
                    var values1 = $('#values'+str2).val();
                    
                    if(labels == "")
                    {
                        $('#labels').val(selected_label);
                        $('#values').val(selected_value);

                        $('#labels'+str2).val(labels1+selected_label);
                        $('#values'+str2).val(values1+selected_value);
                    }
                    else    
                    {
                        $('#labels').val(labels+","+selected_label);
                        $('#values').val(values+","+selected_value);

                        $('#labels'+str2).val(labels1+","+selected_label);
                        $('#values'+str2).val(values1+","+selected_value);
                    }   
                    
                return false;
                }
            });
        });


		// function validate() {
		//     var contactN = checkcontacts(),
		//         duplAdd = checkDuplicate();
		    
		//     return contactN && duplAdd;
		// }

		// Duplicate Group Names
		function checkDuplicate() 
		{				
			var taVal = document.getElementById('tag_name').value;						
			
			$.ajax({
			url:"auto_complete.php",
			type:"POST",
			data: {"tagNam" : taVal,"Section" : "tagsDup"},
			success:function(html){                	
					if(html > 0)
					{
						alert("Tag already Existed please change Tag Name");
						document.getElementById('tag_name').focus();                   		
						//return true;                		
					}
					else
					{
						document.forms['newTag'].submit();
					}
				}
			});		
			return false;		
		}

		function checkDuplicateEdit(proctyp)
		{
			var taVal = document.getElementById('edit_tag_name_'+proctyp).value;	
			if(taVal.length <= 20)
			{				
				$.ajax({
					url:"auto_complete.php",
	                type:"POST",
	                data: {"tagNam" : taVal,"Section" : "tagsDup"},
	                success:function(html){                	
	                	if(html > 0)
	                	{
	                		alert("Tag already Existed please change Tag Name");
	                		document.getElementById('edit_tag_name_'+proctyp).focus();                   		
	                		return true;                		
	                	}
	                	else
	                	{
	                		document.forms['editTag'+proctyp].submit();
	                	}
	                }
				});		
				return true;
			}
			else
			{
				alert('Please Enter Only 20 Characters');
				document.getElementById('edit_tag_name_'+proctyp).focus();    
			}
			return false;
		}

		// Check Contact Names Exist		
	    function checkcontacts()
	    {
	    	var taVal = document.getElementById('contactName').value;	
	    	var hidItems = document.getElementById('labels').value;	

	    	if(hidItems == "")
	    	{
				$.ajax({
					url:"auto_complete.php",
	                type:"POST",
	                data: {"ContName" : taVal,"Section" : "grpContactCheck"},
	                success:function(html){                	
	                	if(html > 0)
	                	{
	                		//document.forms['newGroup'].submit();
	                	}
	                	else
	                	{
	                		alert("Contact Name Does not exist");
	                		document.getElementById('contactName').focus();                   		
	                		return true;                		
	                	}
	                }
				});		
				return false;
			}

			// check for duplicate group Name
			var grpVal = document.getElementById('grpNameAdd').value;						
			
			$.ajax({
			url:"auto_complete.php",
			type:"POST",
			data: {"groupNam" : grpVal,"Section" : "groupsDup"},
			success:function(html){                	
					if(html > 0)
					{
						alert("Group Name already Existed please change Group Name");
						document.getElementById('grpNameAdd').focus();                   								
					}
					else
					{
						document.forms['newGroup'].submit();						
						return false;	
					}
				}
			});	
			return false;				
	    }
    </script> <!-- ionrangeslider -->
    <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <?php /*<script src="assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
    <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>*/?>
</body>
</html>