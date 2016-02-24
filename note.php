<!-- main header -->
<?php include_once('includes/header.php')?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php')?>

<!-- main sidebar end -->
<?php

	if(isset($_POST['note_title']) && !empty($_POST['note_title'])){		
		$noteInfo = array();
		$noteInfo['note_title'] = $_POST['note_title'];
		$noteInfo['note_content'] = $_POST['note_content'];	
		
		if(isset($_POST['default_action']) && $_POST['default_action'] == 'update' ){		
		
			$noteInfo['note_id'] = 	$_POST['note_id'];
			$userContObj->updateNote($noteInfo);
		}else{				
			$userContObj->insertNote($noteInfo);
		}
		header("location:note.php");	
	}	
	$arrAllNotes = $userContObj->fetchAllNotes();
	$countAllNotes = $userContObj->fetchCountNotes($_SESSION['user_id']);
	
	if(isset($_GET['delFlag'])){
		$noteId = $_GET['noteId'];
		$userContObj->deleteNote($noteId);	
		header("location:note.php");			
	}
?>
 
 <style>
 .md-list md-list-outside notes_list li{position:relative;}
 .activedelete{position: absolute;
    right: -39px;
    top: 12px;
    width: 20%;}
 </style>
<div id="page_content">
        <div id="page_content_inner">

            <div class="uk-width-medium-8-10 uk-container-center reset-print">

                <div class="uk-grid uk-grid-collapse" data-uk-grid-margin>
                    <div class="uk-width-large-3-10 hidden-print uk-visible-large">
                        <div class="md-list-outside-wrapper">
                            <ul class="md-list md-list-outside notes_list" id="notes_list">
            
                                <li class="heading_list uk-text-danger">Notes</li>
                                <?php
									
									if($countAllNotes > 0){
										
										$inti = 0;
										foreach($arrAllNotes as $key=>$value){	
										
								?>
								<li>
                                    <a href="#" class="md-list-content note_link" data-note-id="<?php echo $inti; ?>">
                                        <span class="md-list-heading uk-text-truncate"><?php echo $value['note_title'];?></span>
										<input type='hidden' id='note_content_hidden' name='note_content_hidden' class='note_content_hid_class' value="<?php echo $value['note_content'	];?>"/>
										<input type='hidden' id='note_id_hid_class' name='note_content_hidden' class='note_id_hid_class' value="<?php echo $value["_id"];?>"/>
                                        <span class="uk-text-small uk-text-muted"><?php $dates=strtotime($value['created_date']); echo date("j M Y",$dates); ?></span>
                                    </a>
<div class="md-card-dropdown activedelete" >                                          
                                            <i class="md-icon material-icons "  onclick='javscript:deleteNote("<?php echo $value["_id"];?>");'>&#xE872;</i> 
                                        </div>
                                </li>
								                                        
								<?php 	
											$inti++;
										}
									}else{
								?>		
										<li>
											<span class="md-list-heading uk-text-truncate" style="padding-left:100px;">No notes found.</span>
										</li>
										
								<?php
									}
								?>
                            </ul>
                        </div>
                    </div>
                    <div class="uk-width-large-7-10">
                        <div class="md-card md-card-single">
                            <form name='noteFrm' action="note.php" method='post'>
							<input type='hidden' name='default_action' id='default_action' value = 'update' />
                                <div class="md-card-toolbar hidden-print">
                                    <div class="md-card-toolbar-actions">
                                        <i class="md-icon material-icons" onclick='javscript:saveNote();'>&#xE161;</i>

                                    </div>
                                    <input name="note_title" id="note_title" class="md-card-toolbar-input" type="text" value="" placeholder="Add title" required />
									<span style='color:red;' id='error_title'></span>
                                </div>
                                <div class="md-card-content">
                                    <textarea  required   name="note_content" id="note_content" class="textarea_autosize md-input autosize_init" cols="30" rows="12" placeholder="Add content" style="overflow-x: hidden; word-wrap: break-word; height: 308.909px; overflow-y: visible;" ></textarea>
									<input type='hidden' name='note_id' id='note_id' value="" />
									<span style='color:red;' id='error_content'></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-danger" href="#" id="note_add">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>

    <div id="sidebar_secondary">
        <div class="sidebar_secondary_wrapper uk-margin-remove"></div>
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

    <!-- page specific plugins -->

    <!--  notes functions -->
    <script src="assets/js/pages/page_notes.min.js"></script>
    
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
		function saveNote(){
			document.getElementById("error_title").innerHTML = '';
			document.getElementById("error_content").innerHTML = '';
			var note_title = document.getElementById('note_title').value;
			var note_content = trimAll(document.getElementById('note_content').value);
			var note_id = document.getElementById('note_id').value;
			
			if(note_id !=''){
				document.getElementById('default_action').value = 'update';
			}else{
				document.getElementById('default_action').value = 'add';
			}
			
			
			if(note_title ==''){				
				document.getElementById("error_title").innerHTML = 'Please enter message title.';
				return false;
			}
			if(note_content ==''){				
				document.getElementById("error_content").innerHTML = 'Please enter message.';
				return false;
			}
			frm = document.noteFrm;
			frm.action = 'note.php';
			frm.submit();
		}
		
		
		function deleteNote(noteId){						
			if(confirm('Do you want delete the notes?')){				
				document.getElementById('default_action').value = 'delete';
				frm = document.noteFrm;
				frm.action = 'note.php?delFlag=1&noteId='+noteId;
				frm.submit();
			}else{
				return false;
			}	
		}
    </script>
	
	 
</body>
</html>