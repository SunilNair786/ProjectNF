<!-- main header -->
<?php include_once('includes/header.php'); ?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php'); ?>
<!-- main sidebar end -->
<?php
// add Tag
if($_POST['submit'] == "Save")
{
	$tagIns = $userContObj->TagInsert($_POST);   
    header('location:tag.php'); 
    // exit;	
}

//  Tag
if($_POST['submit'] == "Update")
{
	$Edit_tagIns = $userContObj->TagEditing($_POST);   
    header('location:tag.php'); 
    // exit;	
}

?>
<div id="page_content">
	<div id="page_content_inner">
<div class="uk-width-large-8-10 uk-container-center">
		<h3 class="heading_b uk-margin-bottom">Tags</h3>

		<div class="md-card">
			<div class="md-card-content">
				<h3 class="heading_a">Advanced Selects  
					<!-- <button type="button" class="md-btn md-btn-success pull-right" onclick="UIkit.modal.prompt('Tag:', '', function(val){ UIkit.modal.alert('Your Tag is '+(val || 'Mr noname')+'!'); });">
						Create a Tag
					</button> -->					
					<a class="md-btn md-btn-success pull-right" href="#New_tag" data-uk-modal="{center:true}">
						Create a Tag
					</a>					
				</h3>
				<div class="uk-grid" data-uk-grid-margin>
					<div class="uk-width-large-1">
						<select id="selec_adv_1" name="selec_adv_1" multiple>
							<?php 
                            $collection = $db->nf_company_tags; 
                            $alltags = $collection->find();                            
                            foreach($alltags as $all_tags){?>
                            	<option value="<?php echo $all_tags['_id']; ?>" selected><?php echo $all_tags['tag_name']; ?></option>
                            <?php } ?>
						</select>						
					</div>
				</div>
			</div>
		</div>

		<!-- Creating tag -->
		<div class="uk-modal" id="New_tag">
	        <div class="uk-modal-dialog">
	        	<button class="uk-modal-close uk-close" type="button"></button>
	            <form name="newContact" method="post">
	                <div class="uk-modal-header">
	                    <h3 class="uk-modal-title">Tag :</h3>	                    
	                </div>
	                <div class="uk-margin-medium-bottom">
	                    <!-- <label for="tag_name">Tag Name</label> -->
	                    <input type="text" class="md-input" name="tag_name" id="tag_name" required />
	                </div>
	                <div class="uk-modal-footer">                    	                    
	                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Save" />	                    
	                </div>
	            </form>
	        </div>
	    </div>
	    <!-- End Creating tag -->

	    <!-- Editing tags -->
	    <?php 
	    	$Tinc = 1;
           	$collection = $db->nf_company_tags; 
            $edit_tags1 = $collection->find();                            
            foreach($edit_tags1 as $edit_tags_indv){?>

			<div class="uk-modal" id="edit_tag_<?php echo $Tinc; ?>">
		        <div class="uk-modal-dialog">
		        	<button class="uk-modal-close uk-close" type="button"></button>
		            <form name="newContact" method="post">
		                <div class="uk-modal-header">
		                    <h3 class="uk-modal-title">Tag :</h3>	     
		                    <input type="hidden" name="hidd_tag_id" value="<?php echo $edit_tags_indv['_id']; ?>"> 
		                </div>
		                <div class="uk-margin-medium-bottom">
		                    <!-- <label for="tag_name">Tag Name</label> -->
		                    <input type="text" class="md-input" name="edit_tag_name" id="edit_tag_name" value="<?php echo $edit_tags_indv['tag_name']; ?>" required />
		                </div>
		                <div class="uk-modal-footer">                    	                    
		                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="submit" value="Update" />	                    
		                </div>
		            </form>
		        </div>
		    </div>

		<?php $Tinc++; } ?>
	    <!-- End editing tags -->


		<div class="uk-width-medium-1-4">
            
        </div>
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
    <!--<script src="assets/js/pages/forms_advanced.min.js"></script>-->
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
				
			

            // Select Dropdown Script
            $('#selec_adv_1').selectize({
	            options: [
	            	<?php 
	            		$EdTinc = 1;
                       	$collection = $db->nf_company_tags; 
                        $alltags2 = $collection->find();                            
						$sessUserId = $_SESSION['user_id'];
						
                        foreach($alltags2 as $all_tags2){
							$userId =  $all_tags2["user_id"];	
							if($sessUserId == $userId){
								
								$urlTag = "#edit_tag_$EdTinc";
							}else{
								$urlTag = '';
							}
					?>							 
	                		{id: "<?php echo $all_tags2['_id']?>" , title: '<?php echo $all_tags2["tag_name"]; ?>', url: '<?php echo $urlTag; ?>' ,user_id:'<?php echo $all_tags2["user_id"]; ?>'},
	                <?php $EdTinc++; } ?>	                
	            ],
	            maxItems: null,
	            valueField: 'id',
	            labelField: 'title',
	            searchField: 'title',
	            create: false,
	            render: {
	                option: function(data, escape) {
	                    return  '<div class="option">' +
	                            '<span class="title">' + escape(data.title) + '</span>' +
	                            '</div>';
	                },
	                item: function(data, escape) {
						var urlVal = "javascript:deleteTag('"+escape(data.id)+"')";
						var userSesId =   "<?php echo $_SESSION['user_id'];?>" ;
						
						if(userSesId == data.user_id){
							
								var closeBtn = '</a>&nbsp;&nbsp;<a href="' + escape(data.url) + '" data-uk-modal="{center:true}"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp; <a href ='+urlVal+'>X</a>';
						}else{
							var closeBtn = '';
						}
						
						
	                    return '<div class="item"><a href="?tagged='+escape(data.id)+'">' + escape(data.title) + closeBtn +'</div>';
	                }
	            }
				/*,
	            onDropdownOpen: function($dropdown) {
	                $dropdown
	                    .hide()
	                    .velocity('slideDown', {
	                        begin: function() {
	                            $dropdown.css({'margin-top':'0'})
	                        },
	                        duration: 200,
	                        easing: easing_swiftOut
	                    })
	            },
	            onDropdownClose: function($dropdown) {
	                $dropdown
	                    .show()
	                    .velocity('slideUp', {
	                        complete: function() {
	                            $dropdown.css({'margin-top':''})
	                        },
	                        duration: 200,
	                        easing: easing_swiftOut
	                    })
	            }*/
	        });
			// End Select Dropdown
			
			
        });
		function deleteTag(values){				
				if(confirm('Are you sure you want to remove ?')){
					$.get("auto_complete.php?tagId="+values, function(data, status){
						location.reload();
					});							     
				}else{
					//return false;
				}
		}
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