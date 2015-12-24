<?php include_once('includes/header.php'); ?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php'); ?>
<!-- main sidebar end -->
<?php
if($_POST['submit'] == "Save")
{
    $cntVal = $userContObj->insertgroup($_POST);    
    header("location:groups.php"); 
    exit;
}

// edit Process
if($_POST['submit'] == "Update")
{
    $editGrps = $userContObj->updategroup($_POST);    
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
?>
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
									            <form name="newGroup" method="post">
									                <div class="uk-modal-header">
									                    <h3 class="uk-modal-title">Group</h3>
									                </div>
									                <div class="uk-margin-medium-bottom">
									                    <label for="grpName">Group Name</label>
									                    <input type="text" class="md-input" name="grpName" id="grpName" value="<?php echo $indGroup['group_name']; ?>" required/>
									                    <input type="hidden" name="grpId" id="grpId" value="<?php echo $indGroup['_id']; ?>"/>
									                    <input type="hidden" name="hidd_grpName" id="hidd_grpName" value="<?php echo $indGroup['group_name']; ?>"/>
									                </div>
									                <div class="uk-modal-footer">       
									                	<input type="button" class="uk-modal-close md-btn md-btn-flat md-btn-flat-primary pull-right" value="Cancel" />             
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
	            <form name="newGroup" method="post">
	                <div class="uk-modal-header">
	                    <h3 class="uk-modal-title">New Group</h3>
	                </div>
	                <div class="uk-margin-medium-bottom">
	                    <label for="grpName">Group Name</label>
	                    <input type="text" class="md-input" name="grpName" id="grpName" required/>
	                </div>
	                <div class="uk-modal-footer">       
	                	<input type="button" class="uk-modal-close md-btn md-btn-flat md-btn-flat-primary pull-right" value="Cancel" />             
	                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Save" />
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
    </script> <!-- ionrangeslider -->
    <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>

    <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>
</body>
</html>