
<?php include_once('includes/header.php');
	if($_SESSION['userType'] != 'AU'){
		header("location:index.php");
	}
	$collection = $db->nf_user; 
	
	if(isset($_GET['user_id'])){
		$userInfo = $collection->findOne(array('_id' => new MongoId($_GET['user_id'])));			
	}else{
		header("location:index.php");
		exit;
	}
	
?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php');?>
<!-- main sidebar end -->

<div id="page_content">
    <div id="page_content_inner">
        <div class="uk-width-large-8-10 uk-container-center">
            <h3 class="heading_b uk-margin-bottom">User Profile</h3>
            <div class="md-card uk-margin-medium-bottom">
                 <div class="md-card">
                        <div class="user_heading">
                            <div data-uk-dropdown="{pos:'left-top'}" class="user_heading_menu" aria-haspopup="true" aria-expanded="false">
                                <i class="md-icon material-icons md-icon-light"></i>
                                <div class="uk-dropdown uk-dropdown-small uk-dropdown-left" style="min-width: 160px; top: 0px; left: -160px;">
                                    <ul class="uk-nav">
                                        <li><a href="usermanagement.php">Back to Users list</a></li>
                                        <li><a href="#">Action 2</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="user_heading_avatar">
                                <img alt="user avatar" src="assets/img/avatars/avatar_11.png" class="">
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate">Fiona DuBuque</span><span class="sub-heading">Land acquisition specialist</span></h2>
                                <ul class="user_stats">
                                    <li>
                                        <h4 class="heading_a">2391 <span class="sub-heading">Posts</span></h4>
                                    </li>
                                    <li>
                                        <h4 class="heading_a">120 <span class="sub-heading">Photos</span></h4>
                                    </li>
                                    <li>
                                        <h4 class="heading_a">284 <span class="sub-heading">Following</span></h4>
                                    </li>
                                </ul>
                            </div>
							
							
							<div class="md-fab-wrapper">
                                    <div class="md-fab md-fab-toolbar md-fab-small md-fab-accent" style="">
                                        <i class="material-icons"></i>
                                        <div class="md-fab-toolbar-actions">
                                            <button data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" id="user_edit_save" type="submit"><i class="material-icons md-color-white"></i></button>
                                             
                                            <button data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" id="user_edit_delete" type="submit"><i class="material-icons md-color-white"></i></button>
                                        </div>
                                    </div>
                                </div>
							 
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
                        <div class="user_content">
                            <div class="uk-sticky-placeholder" style="height: 46px;"><ul data-uk-sticky="{ top: 48, media: 960 }" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" class="uk-tab" id="user_profile_tabs" style="margin: 0px;">
                                <li class="uk-active" aria-expanded="true"><a href="#">About</a></li>
                                <!--li aria-expanded="false"><a href="#">Photos</a></li>
                                <li aria-expanded="false"><a href="#">Posts</a></li!-->
                            <li class="uk-tab-responsive uk-active uk-hidden" aria-haspopup="true" aria-expanded="false"><a>About</a><div class="uk-dropdown uk-dropdown-small"><ul class="uk-nav uk-nav-dropdown"></ul><div></div></div></li></ul></div>
                            <ul class="uk-switcher uk-margin" id="user_profile_tabs_content">
                                <li aria-hidden="false" class="uk-active">
                                    <?php echo $userInfo['description']; ?>                               <div data-uk-grid-margin="" class="uk-grid uk-margin-medium-top uk-margin-large-bottom">
                                        <div class="uk-width-large-1-2">
                                            <h4 class="heading_c uk-margin-small-bottom">Contact Info</h4>
                                            <ul class="md-list md-list-addon">
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons"></i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><?php echo $userInfo['email_id'];?></span>
                                                        <span class="uk-text-small uk-text-muted">Email</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons"></i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading">+<?php echo $userInfo['phone'];?></span>
                                                        <span class="uk-text-small uk-text-muted">Phone</span>
                                                    </div>
                                                </li>
                                               
                                            </ul>
                                        </div>
                                        <div class="uk-width-large-1-2">
                                            <h4 class="heading_c uk-margin-small-bottom">My groups</h4>
                                            <ul class="md-list">
                                                <li>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="#">Cloud Computing</a></span>
                                                        <span class="uk-text-small uk-text-muted">174 Members</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="#">Account Manager Group</a></span>
                                                        <span class="uk-text-small uk-text-muted">247 Members</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="#">Digital Marketing</a></span>
                                                        <span class="uk-text-small uk-text-muted">156 Members</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="#">HR Professionals Association - Human Resources</a></span>
                                                        <span class="uk-text-small uk-text-muted">104 Members</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                     
                                     
                                </li>
                                <li aria-hidden="true">
                                    <div data-uk-grid="{gutter: 4}" class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-check-display="" id="user_profile_gallery" style="position: relative; margin-left: -4px; height: 0px;">
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image01.jpg">
                                                <img alt="" src="assets/img/gallery/Image01.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image02.jpg">
                                                <img alt="" src="assets/img/gallery/Image02.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image03.jpg">
                                                <img alt="" src="assets/img/gallery/Image03.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image04.jpg">
                                                <img alt="" src="assets/img/gallery/Image04.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image05.jpg">
                                                <img alt="" src="assets/img/gallery/Image05.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image06.jpg">
                                                <img alt="" src="assets/img/gallery/Image06.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image07.jpg">
                                                <img alt="" src="assets/img/gallery/Image07.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image08.jpg">
                                                <img alt="" src="assets/img/gallery/Image08.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image09.jpg">
                                                <img alt="" src="assets/img/gallery/Image09.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image10.jpg">
                                                <img alt="" src="assets/img/gallery/Image10.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image11.jpg">
                                                <img alt="" src="assets/img/gallery/Image11.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image12.jpg">
                                                <img alt="" src="assets/img/gallery/Image12.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image13.jpg">
                                                <img alt="" src="assets/img/gallery/Image13.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image14.jpg">
                                                <img alt="" src="assets/img/gallery/Image14.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image15.jpg">
                                                <img alt="" src="assets/img/gallery/Image15.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image16.jpg">
                                                <img alt="" src="assets/img/gallery/Image16.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image17.jpg">
                                                <img alt="" src="assets/img/gallery/Image17.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image18.jpg">
                                                <img alt="" src="assets/img/gallery/Image18.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image19.jpg">
                                                <img alt="" src="assets/img/gallery/Image19.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image20.jpg">
                                                <img alt="" src="assets/img/gallery/Image20.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image21.jpg">
                                                <img alt="" src="assets/img/gallery/Image21.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image22.jpg">
                                                <img alt="" src="assets/img/gallery/Image22.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image23.jpg">
                                                <img alt="" src="assets/img/gallery/Image23.jpg" class="">
                                            </a>
                                        </div>
                                        <div data-grid-prepared="true" style="position: absolute; box-sizing: border-box; padding-left: 4px; padding-bottom: 4px;">
                                            <a data-uk-lightbox="{group:'user-photos'}" href="assets/img/gallery/Image24.jpg">
                                                <img alt="" src="assets/img/gallery/Image24.jpg" class="">
                                            </a>
                                        </div>
                                    </div>
                                    <ul class="uk-pagination uk-margin-large-top">
                                        <li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>
                                        <li class="uk-active"><span>1</span></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><span>…</span></li>
                                        <li><a href="#">20</a></li>
                                        <li><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>
                                    </ul>
                                </li>
                                <li aria-hidden="true">
                                    <ul class="md-list">
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Quia qui omnis deserunt quibusdam.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">17 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">17</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">771</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Fugit officia laudantium expedita aut.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">21 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">25</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">309</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Ullam est ut repellendus omnis voluptas eveniet tempora.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">27 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">18</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">495</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Quasi alias assumenda assumenda quam quia.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">18 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">8</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">764</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Quasi neque recusandae sit sit enim magni ducimus.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">06 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">17</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">494</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Unde assumenda est dolor maxime nesciunt.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">23 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">15</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">759</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Sed numquam veniam similique.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">28 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">19</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">940</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Illo dolorem accusantium eveniet quidem iusto.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">23 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">24</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">297</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Error sapiente enim veniam repellat blanditiis.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">08 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">20</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">417</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Et et similique odio amet fugit sequi laboriosam.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">24 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">14</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">870</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Tenetur sed et numquam voluptates ad delectus iusto.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">05 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">2</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">496</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Beatae non minima aut velit ipsum et.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">26 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">21</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">394</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Eos sit quod rerum officia iure voluptatem.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">04 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">19</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">950</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Ab quo voluptatem doloremque.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">17 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">8</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">289</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Distinctio adipisci eius dolore.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">09 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">12</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">832</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Voluptatem nihil harum soluta autem sit accusamus odit.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">21 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">6</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">408</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Praesentium ut deserunt expedita unde totam repellendus.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">14 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">4</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">997</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Et ipsa eius aut voluptates expedita officiis libero optio.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">12 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">26</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">861</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Ipsa temporibus et consequatur.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">18 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">5</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">572</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="md-list-content">
                                                <span class="md-list-heading"><a href="#">Et non et hic maiores omnis sint.</a></span>
                                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">28 Nov 2015</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">27</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">119</span>
                                                </span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
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
												<textarea class="md-input" type="text" id="descrption" name="descrption"  required/></textarea>
												<span style='color:red;' id='error_content'></span>												
										</div>
										
										<div class="uk-margin-medium-top">
										 <input type="button" class="md-btn md-btn-primary md-btn-block md-btn-large btns" name="btnSubmit" value="Sign Up"  onclick='javascript:formSubmit();' />
											
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
    </script>
</body>
</html>