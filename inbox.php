<?php include_once('includes/header.php');?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php');?>
<!-- main sidebar end -->
<?php
    $faxObjCon = new faxController();
	if(isset($_REQUEST['submit'])){	 
		$toIds = $_POST['mail_new_to']; 
		if(isset($toIds)){
			if(strpos($toIds, ',')){	
				$finalUserIds =  array();
			    $findMe =  $toIds[strlen(trim($toIds))-1]; 
				if($findMe == ','){
					$userIds = substr(trim($toIds),0,-1);	
				}else{
					$userIds = $toIds;	
				}			
				$arrToUserIds = explode(",",$userIds);			
				if(is_array($arrToUserIds)){
					foreach($arrToUserIds as $key=>$val){					
						if(is_numeric($val)){						
							$finalUserIds[] = $val;
						}
					}
				}else{
					if(is_numeric($arrToUserIds)){
						$finalUserIds[] = $arrToUserIds;
					}
				}			
			}else{			
				if(is_numeric($toIds)){
					$finalUserIds[] = $toIds;
				}			
			}  
		}

		if(isset($_POST['hidd_values']) && !empty($_POST['hidd_values'])){		
			$arrHidIds = explode(",",$_POST['hidd_values']);			
			$finalUserToIds = array_merge($finalUserIds,$arrHidIds);						
		}else{		
			$finalUserToIds = $finalUserIds;
		}
		$faxId = $faxObjCon->copyFiles($_POST,$_FILES);
		
		
		if(is_array($finalUserToIds)){				
			for($i=0;$i<count($finalUserToIds);$i++){
				$faxObjCon->insertToFaxIds($finalUserToIds[$i],$faxId);	
			}
		}else{
				$arrToId = $finalUserToIds;
				$faxObjCon->insertToFaxIds($arrToId,$faxId);	
		}
		header("location:inbox.php");
	}	

// if(isset($_GET['action']) && ($_GET['action'] == "delete") && isset($_GET['faxsId']) && ($_GET['faxsId']!="" ))
// {	
//     $faxObjCon->deleteFax($_GET['faxsId']);
//     header("location:inbox.php");
// }

if($_POST['submit_reply']=="reply")
{	
	// print_r($_FILES); 
	// print_r($_POST);exit;
	// $faxObjCon->sendReply($_POST);
 	// header("location:inbox.php");
}
?>

<style>
/*for autocomplete css*/
.ui-widget-content
{
    z-index: 9999 !important;
}
.dropdown{
    min-width: 167px;     
    display: none;
    position: absolute;
    z-index: 999;
    left: -35px;    
    top:10px;    
    box-shadow: 0 3px 6px rgba(0,0,0,.23);
}
.dropdown ul{
	background: #fff;
	list-style: none;
	height: 180px;
	overflow-y: scroll;
	position: relative;
	padding-left:0px !important;
}

.dropdown ul li{
	background-color: #fff;	
	padding: 5px;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 14px !important;	
}
.dropdown ul li:hover{
	background-color: #eee;		
}
.dropdown ul li a{	
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 14px !important;
}

.arrow-up {
	width: 0; 
	height: 0; 
	border-left: 10px solid transparent;
	border-right: 10px solid transparent;
	margin: 12px 0px -15px 70px;	
	border-bottom: 10px solid #eee;
}

a#tagging:hover + .dropdown , .dropdown:hover {
    display: block;
}

/* responsive */
#page_content_inner {
	padding: 24px 0 23px 200px !important;
}

@media (min-width: 1341px) {
    #page_content_inner {
        padding: 24px 0 23px 100px !important;
    } 
}

@media (min-width: 1400px) {
    #header_main .header_main_search_form {
        width:  50% !important;
    }
}

#header_main .header_main_search_form {
   /* margin: 10px !important;
    float: right !important;*/
}

.tagsss:hover
{
	background-color: #fff;
}

    
</style>

<div id="page_content">
    <div id="page_content_inner">
        <div class="md-card-list-wrapper" id="mailbox">

        <?php 
        // Search Functionality
        if($_REQUEST['name_2'] != "")
        {
        	include('searchinbox.php');
        }
        else
        {        	
        ?>
            <div class="uk-width-large-8-10 uk-container-center">
				<?php 
					$startDate = date('Y-m-d 00:00:00');  						   
					//$endDate = date('Y-m-d H:i:s');
					
					$collection_fax = $db->nf_fax_users; 
					$collection_fax_details = $db->nf_fax;
					$collection = $db->nf_user; 
					$sessId = $_SESSION['fax'];
					
					$allfaxs = $collection_fax->find(array('to_id' => "$sessId",'created_date' => array('$gt' => "$startDate"),'is_delete'=> 0))->sort(array("created_date" => -1));					
					$allTodayCnt = $collection_fax->find(array('to_id' => "$sessId",'created_date' => array('$gt' => $startDate),'is_delete'=>0))->count();		

					if($allTodayCnt > 0 ){		
				?>
                    <div class="md-card-list" id="today">
                        <div class="md-card-list-header heading_list">Today</div>                        
                        <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
                        <ul class="hierarchical_slide">
                           <?php	
                           		$repinc1 = 1;							
									foreach ($allfaxs as $all_faxs) { 	
									$is_read = $all_faxs['is_read'];
									if($is_read == 0 ){
										$divClk = "onClick=getDivClick(".$all_faxs['_id'].")";
										$divUsrNameClk = "onClick=getDivUserNameClick(".$all_faxs['_id'].")";
										$divSujClk = "onClick=getDivSubjectClick(".$all_faxs['_id'].")";
									}else{
										$divClk = "";
										$divUsrNameClk = "";
										$divSujClk = "";
									}
									
										// User Details										
										$userDetails = $collection->findOne(array('_id' => new MongoId($all_faxs['from_id'])));											
										// Fetch Fax subject information from nf_fax;
										$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($all_faxs['fax_id'])));															
										?>           
									<li <?php if($all_faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $all_faxs['_id'];?>')"<?php } ?>>
										<div class="md-card-list-item-menu margn" id="<?php echo $all_faxs['_id'];?>">                                    
											<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
											<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
											<a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>														
												<div class="dropdown">
													<div class="arrow-up"></div>
												    <ul class="Tagbox">
												    	<?php 
												    	$collection_tag = $db->nf_company_tags; 
												    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
												    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
												    	/*if($Cntsalltags > 0)
												    	{
												    		foreach ($alltags as $all_tags) {?>
												    		<li>
												    			<?php if($all_faxs['fax_tag'] == $all_tags['_id']){?>
												    				<a title="tag" onClick="addingtags('<?php echo $all_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>			
												    				<span onClick="addingtags('<?php echo $all_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
												    					<i class="fa fa-times"></i>
												    				</span>
												    			<?php } else { ?>
												    				<a title="click to add this tag" onClick="addingtags('<?php echo $all_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>			
												    			<?php } ?>
												    		</li>
												    	<?php }
												    	} else {?>		
												    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
												    	<?php }*/
												    	if($Cntsalltags > 0)
												    	{
												    		foreach ($alltags as $all_tags) {?>	
														    	<li>
														    	<?php //echo $all_faxs['fax_tag']."<br>".$all_tags['_id']; 
														    	$mnth = (string)$all_faxs["fax_tag"];
													    		$indvTag = (string)$all_tags["_id"];
													    		$aaa = strpos($mnth,$indvTag);	
													    		if($aaa !== false){?>
														    		<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>" checked>&nbsp;<?php echo $all_tags['tag_name'];?>
														    	<?php } else { ?>
														    		<!-- <a onClick="addingtags('<?php echo $all_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="click to add this"></a> -->
														    			<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>">&nbsp;
														    			<span><?php echo $all_tags['tag_name'];?></span>	
												    			<?php } ?>
												    			</li>
												    	<?php } 
												    	} else {?>		
												    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
												    	<?php } ?>
										            </ul>
										            <?php if($Cntsalltags > 0){?>
											            <span>
												    		<input type="hidden" name="Tag_fax_id" id="Tag_fax_id" value="<?php echo $all_faxs['_id'];?>">
											            	<input type="button" name="sub_tag" id="sub_tag" value="Apply" class="uk-float-left md-btn md-btn-flat tagsss" style="width:100%;margin-top:-15px;background-color:#ccc;">
											            </span>
											        <?php } ?>
									            </div>
											<!-- <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $all_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a> -->                                         
											<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { inboxdelete('<?php echo $all_faxs['_id'];?>','today'); return false;}" title="delete"><i class="fa fa-trash"></i></a>
											<span id="favs_sec_<?php echo $all_faxs['_id'];?>">
												<?php if($all_faxs['favorites'] == "N"){?>
													<a id="Fav_id" onClick="gFavorites('<?php echo $all_faxs['_id'];?>','Y')" title="favorites"><i class="fa fa-star"></i> </a>
												<?php } else { ?>
													<a id="Fav_id" onClick="gFavorites('<?php echo $all_faxs['_id']; ?>','N')" title="favorites"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
												<?php } ?> 
											</span>
										</div>
										
										<span class="md-card-list-item-date"><?php echo date('j M',strtotime($all_faxs['created_date'])); ?></span>
										<div class="md-card-list-item-select">
											<input type="checkbox" data-md-icheck />
										</div>
										<div class="md-card-list-item-avatar-wrapper" <?php echo $divClk; ?>>
											<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
										</div>
										<div class="md-card-list-item-sender" <?php echo $divUsrNameClk; ?>>
											<span><?php echo $userDetails['fax']; //echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>      
										</div>
										<div class="md-card-list-item-subject" <?php echo $divSujClk; ?>>
											<div class="md-card-list-item-sender-small">
												<span><?php echo $userDetails['fax']; //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
											</div>
											<span><?php echo substr($userFaxDetails['message_subject'],0,30);?>
												<span id="favs_sec1_<?php echo $all_faxs['_id'];?>" style="float:right;">
													<?php if($all_faxs['favorites'] == "N"){?>
														<!-- <a id="Fav_id" onClick="gFavorites('<?php echo $all_faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a> -->
													<?php } else { ?>
														<a id="Fav_id" onClick="gFavorites('<?php echo $all_faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
													<?php } ?> 
												</span>
											</span>
										</div>		
										<div class="md-card-list-item-content-wrapper">
											<div class="md-card-list-item-content">
												<?php echo html_entity_decode($userFaxDetails['message_body']); echo "<br><br>";
												if($userFaxDetails['saved_pdf_file'] != "")
												{?>													
									    			<a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
									    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> 
									    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
									    				<div class="file">
		                                                    <div class="file-icon" data-type="filename.mp3">
		                                                      <img src="assets/img/fax.png" alt="fax.png">
		                                                    </div>
		                                                    <p class="title">File name.pdf</p>
		                                                    
		                                                    <div class="download-btn">
		                                                      <p>File name.pdf</p>                                                  
		                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
		                                                    </div>
		                                                </div>
									    			</a>		
									    			<div class="uk-modal" id="image_<?php echo $userFaxDetails['_id'];?>_popup">
									    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
									    					<button class="uk-modal-close uk-close" type="button"></button>
									    					<iframe src="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
									    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
									    				</div>
									    			</div>
									    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->
												<?php } ?>		
											</div>

											<!-- Reply Messages Section start -->
												<?php 
												$collection_fax_reply = $db->nf_fax_replys; 
												$rfax_id = $all_faxs['fax_id'];
												$replyfaxs = $collection_fax_reply->find(array('fax_id' => "$rfax_id"))->sort(array("created_date" => -1));

												foreach ($replyfaxs as $reply_faxs) {													
												?>
													<span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply_faxs['created_date'])); ?></span>
													<div class="md-card-list-item-select">
														<!-- <input type="checkbox" data-md-icheck /> -->
														&nbsp;&nbsp;&nbsp;&nbsp;
													</div>
													<?php $rplyUserDetails = $collection->findOne(array('_id' => new MongoId($reply_faxs['from_id']))); 	?>
													<div class="md-card-list-item-avatar-wrapper">
														<span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails['first_name'][0].''.$rplyUserDetails['last_name'][0]; ?></span>
													</div>
													<div class="md-card-list-item-sender">
														<span><?php echo $rplyUserDetails['fax']; //echo ucfirst($rplyUserDetails['first_name']).' '.ucfirst($rplyUserDetails['last_name']); ?></span>
													</div>																									
													<div class="md-card-list-item-content">
														<?php echo html_entity_decode($reply_faxs['message_body']); 

														if($reply_faxs['saved_pdf_file'] != "")
														{?>													
											    			<a href="#image_<?php echo $reply_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
											    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> 
											    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
											    				<div class="file">
				                                                    <div class="file-icon" data-type="filename.mp3">
				                                                      <img src="assets/img/fax.png" alt="fax.png">
				                                                    </div>
				                                                    <p class="title">File name.pdf</p>
				                                                    
				                                                    <div class="download-btn">
				                                                      <p>File name.pdf</p>                                                  
				                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
				                                                    </div>
				                                                </div>
											    			</a>		
											    			<div class="uk-modal" id="image_<?php echo $reply_faxs['_id'];?>_popup">
											    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
											    					<button class="uk-modal-close uk-close" type="button"></button>
											    					<iframe src="upload_dir/savedpdfs/<?php echo $reply_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
											    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
											    				</div>
											    			</div>
											    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->
														<?php } ?>										
													</div>
													<br><br><br>
												<?php } ?> 												
											<!-- Reply Message Section End -->

											<form class="md-card-list-item-reply" name="replyform" method="post" enctype="multipart/form-data" action="sendFaxReply.php">	
												<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['fax'];//$userDetails['email_id']; ?></span></label>		
												<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
												<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
												<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $all_faxs['fax_id']; ?>">
												<?php 
												$reply_msg = explode(':',$userFaxDetails['message_subject']);
												if(count($reply_msg)==1)
												{
													$rpy_msg = $userFaxDetails['message_subject'];
												}
												else
												{
													$rpy_msg = $reply_msg[1];
												}?>
												<input type="hidden" name="reply_subject" id="reply_subject" value="<?php echo $rpy_msg; ?>">
												<textarea class="md-input md-input-full xxs" name="reply_message" id="reply_message" cols="30" rows="4" required placeholder="Enter Your Message"></textarea>
												 <!-- <div class="upload-file" style="display:none;">
												      <a href="#" class="title"></span> <span class="size"><span id="uploadFile"></span> </a>      
												      <span class="close"><span id="closeUpload">x</span></span>
												 </div> -->

												<!-- <div class="uploadFilesList_1<?php echo $repinc1;?>"></div>												 
												<label class="fileUpload">												    
												    <span class="uploadBtn"><img src="assets/img/attach_file_48.png" height="25" width="23" style="cursor:pointer;"></span>
												    <input id="uploadBtn_1<?php echo $repinc1;?>" name="file[]" type="file" class="upload" multiple="multiple" />
												</label> -->
												<!-- New Code File Upload -->
													<span class="uploadBtn">
														<img src="assets/img/attach_file_48.png" height="25" width="26" style="cursor:pointer;position:absolute;margin:17px 40px 0px">
								                		<input name="file[]" type="file" multiple="multiple" class="maxsize-5120" id="today-test<?php echo $repinc1;?>" accept="gif|jpg|jpeg|png|doc|docx|pdf|txt" style="opacity:0;margin-bottom:6px;"/>
								                	</span>	
								                	<?php $file_id = '#today-test'.$repinc1.',';
								                		  $alltodayIds .=$file_id; ?>
								                <!-- End File Code -->

												<br><br>
												<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
											</form>
											<style type="text/css">
											.fileUpload input.upload {
												position: absolute;	
												opacity: 0;
											}
											</style>
											<script type="text/javascript">
											/*document.getElementById("uploadBtn").onchange = function () {
												document.getElementById("uploadFile").innerHTML = this.value.replace(/^.*\\/, "");;
												$('.upload-file').show();
											};*/
											</script>
										</div>
									</li>	
							<?php $repinc1++;
								} //}// foreach	
                            ?>                           	
                            
                        </ul>
                    </div>
				<?php }// if $allfaxsTodayCnt close ?>


<!-- Yesterday Faxs -->

					<?php
                    $startDate = date('Y-m-d 00:00:00',strtotime("-1 days"));
                    $endDate = date('Y-m-d 23:59:59',strtotime("-1 days"));
                    	
                    $yesterdfaxs = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),'is_delete'=>0))->sort(array("created_date" => -1));   
					$allWeekCnt = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),"is_delete"=>0))->count();	

					if($allWeekCnt > 0 ){	
					?>	
						<div class="md-card-list" id="yesterday">
							<div class="md-card-list-header heading_list">Yesterday</div>
							<ul class="hierarchical_slide">
							<?php   
								$repinc2 = 1; 											
								foreach ($yesterdfaxs as $yesterd_faxs) {         
								// User Details		
									$userDetails = $collection->findOne(array('_id' => new MongoId($yesterd_faxs['from_id'])));													
									// Fetch Fax subject information from nf_fax;
									$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($yesterd_faxs['fax_id'])));		
								?>
							<li <?php if($yesterd_faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $yesterd_faxs['_id'];?>')"<?php } ?>>
								<div class="md-card-list-item-menu margn" id="<?php echo $yesterd_faxs['_id'];?>">
									
									<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
									<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>															
									<a href="#" id="tagging" title=""><i class="fa fa-tags"></i></a>			
										<div class="dropdown">
											<div class="arrow-up"></div>
										    <ul class="Tagbox">
										    	<?php 
										    	$collection_tag = $db->nf_company_tags; 
										    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
										    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
										    	/*if($Cntsalltags > 0)
										    	{
										    		foreach ($alltags as $all_tags) {?>
										    		<li>
										    			<?php if($yesterd_faxs['fax_tag'] == $all_tags['_id']){?>
										    				<a title="tagged" onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>
										    				<span onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
										    					<i class="fa fa-times"></i>
										    				</span>
										    			<?php } else { ?>
										    				<a title="click to add this tag" onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>			
										    			<?php } ?>
										    		</li>
										    	<?php }
										    	}else {?>		
										    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
										    	<?php }*/
										    	if($Cntsalltags > 0)
										    	{
										    		foreach ($alltags as $all_tags) {?>	
												    	<li>
												    	<?php //echo $yesterd_faxs['fax_tag']."<br>".$all_tags['_id']; 
												    	$mnth = (string)$yesterd_faxs["fax_tag"];
											    		$indvTag = (string)$all_tags["_id"];
											    		$sss = strpos($mnth,$indvTag);	
											    		if($sss !== false){?>
												    		<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>" checked>&nbsp;<?php echo $all_tags['tag_name'];?>
												    	<?php } else { ?>
												    		<!-- <a onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="click to add this"></a> -->
												    			<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>">&nbsp;
												    			<span><?php echo $all_tags['tag_name'];?></span>	
										    			<?php } ?>
										    			</li>
										    	<?php } 
										    	} else {?>		
										    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
										    	<?php } ?>
								            </ul>
								            <?php if($Cntsalltags > 0){?>
									            <span>
										    		<input type="hidden" name="Tag_fax_id" id="Tag_fax_id" value="<?php echo $yesterd_faxs['_id'];?>">
									            	<input type="button" name="sub_tag" id="sub_tag" value="Apply" class="uk-float-left md-btn md-btn-flat tagsss" style="width:100%;margin-top:-15px;background-color:#ccc;">
									            </span>
									        <?php } ?>
							            </div>
									<!-- <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $yesterd_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a>	 -->
									<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { inboxdelete('<?php echo $yesterd_faxs['_id'];?>','yesterday'); return false;}" title="delete"><i class="fa fa-trash"></i></a>
									<span id="favs_sec_<?php echo $yesterd_faxs['_id'];?>">
										<?php if($yesterd_faxs['favorites'] == "N"){?>
											<a id="Fav_id" onClick="gFavorites('<?php echo $yesterd_faxs['_id'];?>','Y')" title="favorites"><i class="fa fa-star"></i> </a>
										<?php } else { ?>
											<a id="Fav_id" onClick="gFavorites('<?php echo $yesterd_faxs['_id']; ?>','N')" title="favorites"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
										<?php } ?> 
									</span>														
								</div>
								<span class="md-card-list-item-date"><?php echo date('j M',strtotime($yesterd_faxs['created_date'])); ?></span>
								<div class="md-card-list-item-select">
									<input type="checkbox" data-md-icheck />
								</div>
								<div class="md-card-list-item-avatar-wrapper">
									<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
								</div>
								<div class="md-card-list-item-sender">
								<span><?php echo $userDetails['fax']; //echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>  
								</div>
								<div class="md-card-list-item-subject">
									<div class="md-card-list-item-sender-small">
										<span><?php echo $userDetails['fax']; //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
									</div>
									<span>
										<?php echo substr($userFaxDetails['message_subject'],'0','20'); ?>
										<span id="favs_sec1_<?php echo $yesterd_faxs['_id'];?>" style="float:right;">
											<?php if($yesterd_faxs['favorites'] == "N"){?>
												<!-- <a id="Fav_id" onClick="gFavorites('<?php echo $yesterd_faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a> -->
											<?php } else { ?>
												<a id="Fav_id" onClick="gFavorites('<?php echo $yesterd_faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
											<?php } ?> 
										</span>
									</span>															
								</div>
								<div class="md-card-list-item-content-wrapper">
									<div class="md-card-list-item-content">
										<?php echo $userFaxDetails['message_body']; echo "<br><br>";
										/*if($userFaxDetails['file_attach_id'] != "")
										{
											$img = 1;
											$attachments1 = explode(",",$userFaxDetails['file_attach_id']);		
											for($i = 0; $i< sizeof($attachments1); $i++)
											{
												$collection_attach = $db->nf_user_fileuploads; 
										    	$allattachments1 = $collection_attach->find(array("_id" => new MongoId($attachments1[$i])))->sort(array("created_date" => -1));										    	
										    	foreach($allattachments1 as $all_attachments1)
										    	{
										    		$ftype = explode(".",$all_attachments1['file_name']);
										    		if($ftype != "pdf")
										    		{?>
										    			<a href="#image_<?php echo $all_attachments1['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
										    				<img title="click to view image" src="upload_dir/files/<?php echo $all_attachments1['file_name'];?>" id="img_atch" width="100" height="50">
										    			</a>												    			
										    			<div class="uk-modal" id="image_<?php echo $all_attachments1['_id'];?>_popup<?php echo $img;?>">
										    				<div class="uk-modal-dialog" style="width:1000px; height:600px;">		
										    					<button class="uk-modal-close uk-close" type="button"></button>
										    					<img src="upload_dir/files/<?php echo $all_attachments1['file_name'];?>"/>
										    				</div>
										    			</div>
										    		<?php }else {?>
										    			<a href="upload_dir/files/<?php echo $all_attachments1['file_name'];?>">View the attachment</a>
										    		<?php }
										    		$img++;
										    	} 
											}
										}*/
										if($userFaxDetails['saved_pdf_file'] != "")
										{?>													
							    			<a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
							    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> 
							    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
							    				<div class="file">
                                                    <div class="file-icon" data-type="filename.mp3">
                                                      <img src="assets/img/fax.png" alt="">
                                                    </div>
                                                    <p class="title">File name.pdf</p>
                                                    
                                                    <div class="download-btn">
                                                      <p>File name.pdf</p>                                                  
                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
                                                    </div>
                                                </div>
							    			</a>												    			
							    			<div class="uk-modal" id="image_<?php echo $userFaxDetails['_id'];?>_popup">
							    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
							    					<button class="uk-modal-close uk-close" type="button"></button>
							    					<iframe src="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
							    				</div>
							    			</div>
							    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->		
										<?php } ?>
									</div>

									<!-- Reply Messages Section start -->
										<?php 
										$collection_fax_reply = $db->nf_fax_replys; 
										$rfax_id1 = $yesterd_faxs['fax_id'];
										$replyfaxs1 = $collection_fax_reply->find(array('fax_id' => "$rfax_id1"))->sort(array("created_date" => -1));

										foreach ($replyfaxs1 as $reply1_faxs) {													
										?>
											<span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply1_faxs['created_date'])); ?></span>
											<div class="md-card-list-item-select">
												<!-- <input type="checkbox" data-md-icheck /> -->
												&nbsp;&nbsp;&nbsp;&nbsp;
											</div>
											<?php $rplyUserDetails1 = $collection->findOne(array('_id' => new MongoId($reply1_faxs['from_id']))); 	?>
											<div class="md-card-list-item-avatar-wrapper">
												<span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails1['first_name'][0].''.$rplyUserDetails1['last_name'][0]; ?></span>
											</div>
											<div class="md-card-list-item-sender">
												<span><?php echo $rplyUserDetails1['fax']; //echo ucfirst($rplyUserDetails1['first_name']).' '.ucfirst($rplyUserDetails1['last_name']); ?></span>
											</div>																									
											<div class="md-card-list-item-content">
												<?php echo html_entity_decode($reply1_faxs['message_body']); 
												if($reply1_faxs['saved_pdf_file'] != "")
												{?>													
									    			<a href="#image_<?php echo $reply1_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
									    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> 
									    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
									    				<div class="file">
		                                                    <div class="file-icon" data-type="filename.mp3">
		                                                      <img src="assets/img/fax.png" alt="fax.png">
		                                                    </div>
		                                                    <p class="title">File name.pdf</p>
		                                                    
		                                                    <div class="download-btn">
		                                                      <p>File name.pdf</p>                                                  
		                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
		                                                    </div>
		                                                </div>
									    			</a>		
									    			<div class="uk-modal" id="image_<?php echo $reply1_faxs['_id'];?>_popup">
									    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
									    					<button class="uk-modal-close uk-close" type="button"></button>
									    					<iframe src="upload_dir/savedpdfs/<?php echo $reply1_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
									    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
									    				</div>
									    			</div>
									    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->
												<?php } ?>												
											</div>
											<br><br><br>
										<?php } ?> 												
									<!-- Reply Message Section End -->

									<form class="md-card-list-item-reply" name="replyform" method="post" enctype="multipart/form-data" action="sendFaxReply.php">	
										<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['fax'];//$userDetails['email_id']; ?></span></label>		
										<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
										<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
										<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $yesterd_faxs['fax_id']; ?>">
										<?php 
										$reply_msg = explode(':',$userFaxDetails['message_subject']);
										if(count($reply_msg)==1)
										{
											$rpy_msg = $userFaxDetails['message_subject'];
										}
										else{
											$rpy_msg = $reply_msg[1];
											}?>
										<input type="hidden" name="reply_subject" id="reply_subject" value="<?php echo $rpy_msg; ?>">
										<textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required placeholder="Enter Your Message"></textarea>			


										<!-- <div class="uploadFilesList_2<?php echo $repinc2;?>"></div>										 
										<label class="fileUpload">										    
										    <span class="uploadBtn"><img src="assets/img/attach_file_48.png" height="25" width="23" style="cursor:pointer;"></span>
										    <input id="uploadBtn_2<?php echo $repinc2;?>" name="file[]" type="file" class="upload" multiple="multiple" />
										</label> -->
										<!-- New Code File Upload -->
											<span class="uploadBtn">
												<img src="assets/img/attach_file_48.png" height="25" width="26" style="cursor:pointer;position:absolute;margin:17px 40px 0px">
						                		<input name="file[]" type="file" multiple="multiple" class="maxsize-5120" id="yesterd-test<?php echo $repinc2;?>" accept="gif|jpg|jpeg|png|doc|docx|pdf|txt"  style="opacity:0;margin-bottom:6px;"/>	
						                	</span>
						                		<?php $file_id1 = '#yesterd-test'.$repinc2.',';
						                			  $allyesterdIds .=$file_id1; ?>
						                <!-- End File Code -->

										<br><br>
										<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">									
									</form>												

								</div>
							</li>
								<?php $repinc2++;	
								} // foreach ?>
									
							</ul>
						</div>
				<?php } // if loop $allfaxsWeekCnt ?>		
							

    <!-- This Month Faxs -->
					<?php 
						$startDate = date('Y-m-d 00:00:00',strtotime("-30 days"));
						$endDate = date('Y-m-d 23:59:59',strtotime("-2 days"));
							
						$amonthFaxs = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),'is_delete'=>0))->sort(array("created_date" => -1));   
						$allMonthCnt = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),"is_delete"=>0))->count();	
						if($allMonthCnt > 0 ){
					?>
					<div class="md-card-list" id="month">
                        <div class="md-card-list-header heading_list">This Month</div>
                        <ul class="hierarchical_slide">
                        	<?php				
                        		$repinc = 1;
								foreach ($amonthFaxs as $amonth_Faxs) {            										
								// User Details										
									$userDetails = $collection->findOne(array('_id' => new MongoId($amonth_Faxs['from_id'])));	
									
									// Fetch Fax subject information from nf_fax;
									$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($amonth_Faxs['fax_id'])));															
							?>
								<li <?php if($amonth_Faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $amonth_Faxs['_id'];?>')"<?php } ?>>
									<div class="md-card-list-item-menu margn" id="<?php echo $amonth_Faxs['_id'];?>">
										
										<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
										<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
										<a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>														
											<div class="dropdown">
												<div class="arrow-up"></div>
											    <ul class="Tagbox">
											    	<?php 
											    	$collection_tag = $db->nf_company_tags; 
											    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
											    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
											    	/*if($Cntsalltags > 0)
											    	{
											    		foreach ($alltags as $all_tags) {?>
											    		<li>
											    			<?php if($amonth_Faxs['fax_tag'] == $all_tags['_id']){?>
											    				<a onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')" title="tagged"><?php echo $all_tags['tag_name'];?></a>	
											    				<span onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
											    					<i class="fa fa-times"></i>
											    				</span>
											    			<?php } else { ?>
											    				<a onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="click to add this"><?php echo $all_tags['tag_name'];?></a>			
											    			<?php } ?>
											    		</li>
											    	<?php }
											    	} else {?>		
											    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
											    	<?php }*/ 
											    	if($Cntsalltags > 0)
											    	{
											    		foreach ($alltags as $all_tags) {?>	
													    	<li>
													    	<?php //echo $amonth_Faxs['fax_tag']."<br>".$all_tags['_id']; 
												    		$mnth = (string)$amonth_Faxs["fax_tag"];
												    		$indvTag = (string)$all_tags["_id"];
												    		$asa = strpos($mnth,$indvTag);	
													    	if($asa !== false){?>
													    		<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>" checked>&nbsp;<?php echo $all_tags['tag_name'];?>
													    	<?php } else { ?>
													    		<!-- <a onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="click to add this"></a> -->
												    			<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>">&nbsp;
												    			<span><?php echo $all_tags['tag_name'];?></span>	
											    			<?php } ?>
											    			</li>
											    	<?php } 
											    	} else {?>		
											    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
											    	<?php } ?>
									            </ul><!--  style="position: fixed;top: 321px;right: 182px;z-index: 999;background-color: #ccc;width: 167px;box-shadow: 0 3px 6px rgba(0,0,0,.23);" -->
									            <?php if($Cntsalltags > 0){?>
										            <span>
											    		<input type="hidden" name="Tag_fax_id" id="Tag_fax_id" value="<?php echo $amonth_Faxs['_id'];?>">
										            	<input type="button" name="sub_tag" id="sub_tag" value="Apply" class="uk-float-left md-btn md-btn-flat tagsss" style="width:100%;margin-top:-15px;background-color:#ccc;">
										            </span>
										        <?php } ?>
								            </div>
										<!-- <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $amonth_Faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a> -->
										<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { inboxdelete('<?php echo $amonth_Faxs['_id'];?>','month'); return false;}" title="delete"><i class="fa fa-trash"></i></a>
										<span id="favs_sec_<?php echo $amonth_Faxs['_id'];?>">
											<?php if($amonth_Faxs['favorites'] == "N"){?>
												<a id="Fav_id" onClick="gFavorites('<?php echo $amonth_Faxs['_id'];?>','Y')" title="favorites"><i class="fa fa-star"></i> </a>
											<?php } else { ?>
												<a id="Fav_id" onClick="gFavorites('<?php echo $amonth_Faxs['_id']; ?>','N')" title="favorites"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
											<?php } ?> 
										</span>
									</div>
									<span class="md-card-list-item-date"><?php echo date('j M',strtotime($amonth_Faxs['created_date'])); ?></span>
									<div class="md-card-list-item-select">
										<input type="checkbox" data-md-icheck />
									</div>
									<div class="md-card-list-item-avatar-wrapper">
										<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
									</div>
									<div class="md-card-list-item-sender">
										<span><?php echo $userDetails['fax']; //echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>  
									</div>
									<div class="md-card-list-item-subject">
										<div class="md-card-list-item-sender-small">
											<span><?php echo $userDetails['fax']; //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
										</div>
										<span><?php echo substr($userFaxDetails['message_subject'],'0','20'); ?>
											<span id="favs_sec1_<?php echo $amonth_Faxs['_id'];?>" style="float:right;">
												<?php if($amonth_Faxs['favorites'] == "N"){?>
													<!-- <a id="Fav_id" onClick="gFavorites('<?php echo $amonth_Faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a> -->
												<?php } else { ?>
													<a id="Fav_id" onClick="gFavorites('<?php echo $amonth_Faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
												<?php } ?> 
											</span>
										</span>
									</div>
									<div class="md-card-list-item-content-wrapper">
										<div class="md-card-list-item-content">
											<?php echo $userFaxDetails['message_body']; echo "<br><br>";
											/*if($userFaxDetails['file_attach_id'] != "")
											{
												$img = 1;
												$attachments2 = explode(",",$userFaxDetails['file_attach_id']);		
												for($i = 0; $i< sizeof($attachments2); $i++)
												{
													$collection_attach = $db->nf_user_fileuploads; 
											    	$allattachments2 = $collection_attach->find(array("_id" => new MongoId($attachments2[$i])))->sort(array("created_date" => -1));
											    	foreach($allattachments2 as $all_attachments2)
											    	{
											    		$ftype = explode(".",$all_attachments2['file_name']);
											    		if($ftype != "pdf")
											    		{?>
											    			<a href="#image_<?php echo $all_attachments2['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
											    				<img title="click to view image" src="upload_dir/files/<?php echo $all_attachments2['file_name'];?>" id="img_atch" width="100" height="50">
											    			</a>												    			
											    			<div class="uk-modal" id="image_<?php echo $all_attachments2['_id'];?>_popup<?php echo $img;?>">
											    				<div class="uk-modal-dialog" style="width:1000px; height:600px;">		
											    					<button class="uk-modal-close uk-close" type="button"></button>
											    					<img src="upload_dir/files/<?php echo $all_attachments2['file_name'];?>"/>
											    				</div>
											    			</div>
											    		<?php }else {?>
											    			<a href="upload_dir/files/<?php echo $all_attachments2['file_name'];?>">View the attachment</a>
											    		<?php }
											    		$img++;
											    	} 
												}
											}*/

											if($userFaxDetails['saved_pdf_file'] != "")
											{?>			
								    			<a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
								    				<!-- <img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25"> -->
								    				<div class="file">
	                                                    <div class="file-icon" data-type="filename.mp3">
	                                                      <img src="assets/img/fax.png" alt="">
	                                                    </div>
	                                                    <p class="title">File name.pdf</p>
	                                                    
	                                                    <div class="download-btn">
	                                                      <p>File name.pdf</p>                                                  
	                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
	                                                    </div>
	                                                </div>
								    			</a>		
								    			<div class="uk-modal" id="image_<?php echo $userFaxDetails['_id'];?>_popup">
								    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
								    					<button class="uk-modal-close uk-close" type="button"></button>
								    					<iframe src="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
								    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a> 
								    				</div>
								    			</div>
								    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->	
											<?php } ?>
										</div>

										<!-- Reply Messages Section start -->
											<?php 
											$collection_fax_reply = $db->nf_fax_replys; 
											$rfax_id2 = $amonth_Faxs['fax_id'];
											$replyfaxs2 = $collection_fax_reply->find(array('fax_id' => "$rfax_id2",'to_id'=>"$sessId"))->sort(array("created_date" => -1));

											foreach ($replyfaxs2 as $reply2_faxs) {													
											?>
												<span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply2_faxs['created_date'])); ?></span>
												<div class="md-card-list-item-select">
													&nbsp;&nbsp;&nbsp;&nbsp;
												</div>
												<?php $rplyUserDetails2 = $collection->findOne(array('_id' => new MongoId($reply2_faxs['from_id']))); 	?>
												<div class="md-card-list-item-avatar-wrapper">
													<span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails2['first_name'][0].''.$rplyUserDetails2['last_name'][0]; ?></span>
												</div>
												<div class="md-card-list-item-sender">
													<span><?php echo $rplyUserDetails2['fax']; //echo ucfirst($rplyUserDetails2['first_name']).' '.ucfirst($rplyUserDetails2['last_name']); ?></span>
												</div><br><br>
												<div class="md-card-list-item-content">
													<?php echo html_entity_decode($reply2_faxs['message_body']); 
													if($reply2_faxs['saved_pdf_file'] != "")
													{?>													
										    			<a href="#image_<?php echo $reply2_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
										    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> 
										    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
										    				<div class="file">
			                                                    <div class="file-icon" data-type="filename.mp3">
			                                                      <img src="assets/img/fax.png" alt="fax.png">
			                                                    </div>
			                                                    <p class="title">File name.pdf</p>
			                                                    
			                                                    <div class="download-btn">
			                                                      <p>File name.pdf</p>                                                  
			                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
			                                                    </div>
			                                                </div>
										    			</a>		
										    			<div class="uk-modal" id="image_<?php echo $reply2_faxs['_id'];?>_popup">
										    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
										    					<button class="uk-modal-close uk-close" type="button"></button>
										    					<iframe src="upload_dir/savedpdfs/<?php echo $reply2_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
										    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
										    				</div>
										    			</div>
										    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->
													<?php } ?>													
												</div>
												<br><br><br>
											<?php } ?> 												
										<!-- Reply Message Section End -->

										<form class="md-card-list-item-reply" name="replyform" method="post" enctype="multipart/form-data" action="sendFaxReply.php">	
											<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>		
											<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
											<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
											<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $amonth_Faxs['fax_id']; ?>">
											<?php 
											$reply_msg = explode(':',$userFaxDetails['message_subject']);
											if(count($reply_msg)==1)
											{
												$rpy_msg = $userFaxDetails['message_subject'];
											}
											else{
												$rpy_msg = $reply_msg[1];
												}?>
											<input type="hidden" name="reply_subject" id="reply_subject" value="<?php echo $rpy_msg; ?>">
											<textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>	


											<!-- <div class="uploadFilesList_3<?php echo $repinc;?>"></div>										 
											<label class="fileUpload">											    
											    <span class="uploadBtn"><img src="assets/img/attach_file_48.png" height="25" width="23" style="cursor:pointer;"></span>
											    <input id="uploadBtn_3<?php echo $repinc;?>" name="file[]" type="file" class="upload" multiple="multiple" />
											</label> -->
											<!-- <div id = "ReplyUpload_<?php echo $amonth_Faxs['_id'];?>">
											</div>
											<input id="Button1" type="button" value="Add File" onclick = "ReplyFileUpload('<?php echo $amonth_Faxs['_id'];?>')" class="uk-form-file md-btn" /> -->
											<!-- New Code File Upload -->
											<span class="uploadBtn">
												<img src="assets/img/attach_file_48.png" height="25" width="26" style="cursor:pointer;position:absolute;margin:17px 40px 0px">
							                	<input name="file[]" type="file" multiple="multiple" class="maxsize-5120" id="month-test<?php echo $repinc;?>" accept="gif|jpg|jpeg|png|doc|docx|pdf|txt" style="opacity:0;margin-bottom:6px;" />
							                </span>	
												<?php $file_id2 = '#month-test'.$repinc.',';
									                $allmonthIds .= $file_id2; ?>	
							                <!-- End File Code -->
											<br><br>		
											<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
										</form>	

									</div>
								</li>
							<?php $repinc++;
								}	// foreach ?>
								
                        </ul>
                    </div>
					<?php }   // if loop $allfaxsWeekCnt ?>
                   
            


    <!-- Older messages -->
				<?php 
				$startDate = date('Y-m-d 00:00:00',strtotime("-100 years"));
				$endDate = date('Y-m-d 23:59:59',strtotime("-30 days"));
					
				$OldmonthFaxs = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),'is_delete'=>0))->sort(array("created_date" => -1));   
				$allCnt = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),"is_delete"=>0))->count();	
				
				if($allCnt > 0 ){
				?>
					<div class="md-card-list" id="Oldmonth">
						<div class="md-card-list-header heading_list">Older Messages</div>
						<ul class="hierarchical_slide">
						   <?php
						   	
							foreach ($OldmonthFaxs as $Oldmonth_Faxs) {            										
							// User Details										
								$userDetails = $collection->findOne(array('_id' => new MongoId($Oldmonth_Faxs['from_id'])));	
								
								// Fetch Fax subject information from nf_fax;
								$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($Oldmonth_Faxs['fax_id'])));															
							?>
							<li <?php if($Oldmonth_Faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $Oldmonth_Faxs['_id'];?>')"<?php } ?>>
								<div class="md-card-list-item-menu margn" id="<?php echo $Oldmonth_Faxs['_id'];?>">
									
									<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
									<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
									<a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>														
										<div class="dropdown">
											<div class="arrow-up"></div>
										    <ul class="Tagbox">
										    	<?php 
										    	$collection_tag = $db->nf_company_tags; 
										    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
										    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
										    	/*if($Cntsalltags > 0)
										    	{
										    		foreach ($alltags as $all_tags) {?>
										    		<li>
									    			<?php if($Oldmonth_Faxs['fax_tag'] == $all_tags['_id']){	?>
									    				<a onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')" title="tagged"><?php echo $all_tags['tag_name'];?></a>
									    				<span onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
									    					<i class="fa fa-times"></i>
									    				</span>
									    			<?php } else { ?>
									    				<a onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="tagged"><?php echo $all_tags['tag_name'];?></a>			
									    			<?php } ?>
										    		</li>
										    	<?php }
										    	}else {?>		
										    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
										    	<?php } */
										    	if($Cntsalltags > 0)
										    	{
										    		foreach ($alltags as $all_tags) {?>	
												    	<li>
												    	<?php //echo $Oldmonth_Faxs['fax_tag']."<br>".$all_tags['_id']; 
												    	$mnth = (string)$Oldmonth_Faxs["fax_tag"];
											    		$indvTag = (string)$all_tags["_id"];
											    		$ddd = strpos($mnth,$indvTag);	
											    		if($ddd !== false){?>
												    		<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>" checked>&nbsp;<?php echo $all_tags['tag_name'];?>
												    	<?php } else { ?>
												    		<!-- <a onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="click to add this"></a> -->
												    			<input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>">&nbsp;
												    			<span><?php echo $all_tags['tag_name'];?></span>	
										    			<?php } ?>
										    			</li>
										    	<?php } 
										    	} else {?>		
										    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
										    	<?php } ?>		
										    </ul>
										    <?php if($Cntsalltags > 0){?>
											    <span>
										    		<input type="hidden" name="Tag_fax_id" id="Tag_fax_id" value="<?php echo $Oldmonth_Faxs['_id'];?>">
									            	<input type="button" name="sub_tag" id="sub_tag" value="Apply" class="uk-float-left md-btn md-btn-flat tagsss" style="width:100%;margin-top:-15px;background-color:#ccc;">
									            </span>
									        <?php } ?>
										</div>
									<!-- <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $Oldmonth_Faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a> -->
									<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { inboxdelete('<?php echo $Oldmonth_Faxs['_id'];?>','Oldmonth'); return false;}" title="delete"><i class="fa fa-trash"></i></a>
									<span id="favs_sec_<?php echo $Oldmonth_Faxs['_id'];?>">
										<?php if($Oldmonth_Faxs['favorites'] == "N"){?>
											<a id="Fav_id" onClick="gFavorites('<?php echo $Oldmonth_Faxs['_id'];?>','Y')" title="favorites"><i class="fa fa-star"></i> </a>
										<?php } else { ?>
											<a id="Fav_id" onClick="gFavorites('<?php echo $Oldmonth_Faxs['_id']; ?>','N')" title="favorites"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
										<?php } ?> 
									</span>
								</div>
								<span class="md-card-list-item-date"><?php echo date('j M',strtotime($Oldmonth_Faxs['created_date'])); ?></span>
								<div class="md-card-list-item-select">
									<input type="checkbox" data-md-icheck />
								</div>
								<div class="md-card-list-item-avatar-wrapper">
									<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
								</div>
								<div class="md-card-list-item-sender">
									<span><?php echo $userDetails['fax']; //echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>  
								</div>
								<div class="md-card-list-item-subject">
									<div class="md-card-list-item-sender-small">
										<span><?php echo $userDetails['fax']; //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
									</div>
									<span>
										<?php echo substr($userFaxDetails['message_subject'],'0','20'); ?>
										<span id="favs_sec1_<?php echo $Oldmonth_Faxs['_id'];?>" style="float:right;">
											<?php if($Oldmonth_Faxs['favorites'] == "N"){?>
												<!-- <a id="Fav_id" onClick="gFavorites('<?php echo $Oldmonth_Faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a> -->
											<?php } else { ?>
												<a id="Fav_id" onClick="gFavorites('<?php echo $Oldmonth_Faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
											<?php } ?> 
										</span>
									</span>
								</div>
								<div class="md-card-list-item-content-wrapper">
									<div class="md-card-list-item-content">
										<?php echo $userFaxDetails['message_body']; echo "<br><br>";
										/*if($userFaxDetails['file_attach_id'] != "")
										{
											$attachments3 = explode(",",$userFaxDetails['file_attach_id']);		
											for($i = 0; $i< sizeof($attachments3); $i++)
											{
												$img = 1;
												$collection_attach = $db->nf_user_fileuploads; 
										    	$allattachments3 = $collection_attach->find(array("_id" => new MongoId($attachments3[$i])))->sort(array("created_date" => -1));										    	
										    	foreach($allattachments3 as $all_attachments3)
										    	{
										    		$ftype = explode(".",$all_attachments3['file_name']);
										    		if($ftype != "pdf")
										    		{?>
										    			<a href="#image_<?php echo $all_attachments3['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
										    				<img title="click to view image" src="upload_dir/files/<?php echo $all_attachments3['file_name'];?>" id="img_atch" width="100" height="50">
										    			</a>												    			
										    			<div class="uk-modal" id="image_<?php echo $all_attachments3['_id'];?>_popup<?php echo $img;?>">
										    				<div class="uk-modal-dialog" style="width:1000px; height:600px;">		
										    					<button class="uk-modal-close uk-close" type="button"></button>
										    					<img src="upload_dir/files/<?php echo $all_attachments3['file_name'];?>"/>
										    				</div>
										    			</div>
										    		<?php }else {?>
										    			<a href="upload_dir/files/<?php echo $all_attachments3['file_name'];?>">View the attachment</a>
										    		<?php }
										    		$img++;
										    	} 
											}
										}*/

										if($userFaxDetails['saved_pdf_file'] != "")
											{?>													
								    		<a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
							    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50">
							    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25"> -->
							    				<div class="file">
                                                    <div class="file-icon" data-type="filename.mp3">
                                                      <img src="assets/img/fax.png" alt="">
                                                    </div>
                                                    <p class="title">File name.pdf</p>
                                                    
                                                    <div class="download-btn">
                                                      <p>File name.pdf</p>                                                  
                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
                                                    </div>
                                                </div>
							    			</a>												    			
							    			<div class="uk-modal" id="image_<?php echo $userFaxDetails['_id'];?>_popup">
							    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
							    					<button class="uk-modal-close uk-close" type="button"></button>
							    					<iframe src="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
							    				</div>
							    			</div>
							    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->									    			
										<?php }?>
									</div>
									<!-- Reply Messages Section start -->
										<?php 
										$collection_fax_reply = $db->nf_fax_replys; 
										$rfax_id3 = $Oldmonth_Faxs['fax_id'];
										$replyfaxs3 = $collection_fax_reply->find(array('fax_id' => "$rfax_id3"))->sort(array("created_date" => -1));

										foreach ($replyfaxs3 as $reply3_faxs) {													
										?>
											<span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply3_faxs['created_date'])); ?></span>
											<div class="md-card-list-item-select">
												<!-- <input type="checkbox" data-md-icheck /> -->
												&nbsp;&nbsp;&nbsp;&nbsp;
											</div>
											<?php $rplyUserDetails3 = $collection->findOne(array('_id' => new MongoId($reply3_faxs['from_id']))); 	?>
											<div class="md-card-list-item-avatar-wrapper">
												<span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails3['first_name'][0].''.$rplyUserDetails3['last_name'][0]; ?></span>
											</div>
											<div class="md-card-list-item-sender">
												<span><?php echo $rplyUserDetails3['fax']; //echo ucfirst($rplyUserDetails3['first_name']).' '.ucfirst($rplyUserDetails3['last_name']); ?></span>
											</div>																									
											<div class="md-card-list-item-content">
												<?php echo html_entity_decode($reply3_faxs['message_body']); 
												if($reply3_faxs['saved_pdf_file'] != "")
													{?>													
										    			<a href="#image_<?php echo $reply3_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
										    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> 
										    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
										    				<div class="file">
			                                                    <div class="file-icon" data-type="filename.mp3">
			                                                      <img src="assets/img/fax.png" alt="fax.png">
			                                                    </div>
			                                                    <p class="title">File name.pdf</p>
			                                                    
			                                                    <div class="download-btn">
			                                                      <p>File name.pdf</p>                                                  
			                                                      <img class="pdf" src="assets/img/pdf.png" alt="pdf">
			                                                    </div>
			                                                </div>
										    			</a>		
										    			<div class="uk-modal" id="image_<?php echo $reply3_faxs['_id'];?>_popup">
										    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
										    					<button class="uk-modal-close uk-close" type="button"></button>
										    					<iframe src="upload_dir/savedpdfs/<?php echo $reply3_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
										    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
										    				</div>
										    			</div>
										    			<!-- <a href="upload_dir/savedpdfs/<?php echo $userFaxDetails['saved_pdf_file'];?>">View the attachment</a> -->
													<?php } ?>													
											</div>
											<br><br><br>
										<?php } ?> 												
									<!-- Reply Message Section End -->

									<form class="md-card-list-item-reply" name="replyform" method="post" enctype="multipart/form-data" action="sendFaxReply.php">	
										<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>		
										<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
										<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
										<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $Oldmonth_Faxs['fax_id']; ?>">
										<?php 
										$reply_msg = explode(':',$userFaxDetails['message_subject']);
										if(count($reply_msg)==1)
										{
											$rpy_msg = $userFaxDetails['message_subject'];
										}
										else{
											$rpy_msg = $reply_msg[1];
											}?>
										<input type="hidden" name="reply_subject" id="reply_subject" value="<?php echo $rpy_msg; ?>">
										<textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>			

										<!-- <div class="uploadFilesList_4"></div>										 
										<label class="fileUpload">										    
										    <span class="uploadBtn"><img src="assets/img/attach_file_48.png" height="25" width="23" style="cursor:pointer;"></span>
										    <input id="uploadBtn_4" name="file[]" type="file" class="upload" multiple="multiple" />
										</label> -->
										<!-- New Code File Upload -->
										<span class="uploadBtn">
											<img src="assets/img/attach_file_48.png" height="25" width="26" style="cursor:pointer;position:absolute;margin:17px 40px 0px">
						                	<input name="file[]" type="file" multiple="multiple" class="maxsize-5120" id="oldmnth-test<?php echo $repinc4;?>" accept="gif|jpg|jpeg|png|doc|docx|pdf|txt" style="opacity:0;margin-bottom:6px;" />	
						                </span>
											<?php $file_id4 = '#oldmnth-test'.$repinc4.',';
								                $allOldmonthIds .= $file_id4; ?>	
						                <!-- End File Code -->
										<br><br>
										<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
									</form>	
								</div>
							</li>
							<?php	} //} // foreach ?>

						</ul>
					</div>
				<?php 	}   // if loop $allCnt ?>

	<!-- No Faxs  -->

                <?php if($allTodayCnt == "0" && $allWeekCnt == "0" && $allMonthCnt == "0" && $allCnt == "0"){?>
                    <div class="md-card-list">                
                    	<center>
                    		<img src="assets/img/fax.png" alt="No Faxs Found" height="150" width="200">
                    		<br>Oops..! No faxs Found here....
                    	</center>
                    </div>
                <?php } ?>

    <!-- No faxs End -->

            </div>

        <?php } //Main Serach Else End?>
    
        </div>
    </div>
</div>


<!--<div class="md-fab-wrapper md-fab-speed-dial">
        <a data-uk-tooltip="{pos:'right'}"   href="#" class="md-fab md-fab-primary"><i class="material-icons">&#xE150;</i><i style="display:none" class="material-icons md-fab-action-close"></i></a>
        <div class="md-fab-wrapper-small">
            <a title="Download" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" href="#" class="md-fab md-fab-small"><i class="material-icons"></i></a>
            <a title="Flag" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" href="#" class="md-fab md-fab-small md-fab-warning"><i class="material-icons"></i></a>
            <a title="Upload" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" href="#" class="md-fab md-fab-small md-fab-danger"><i class="material-icons"></i></a>
            <a title="Send" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" href="#" class="md-fab md-fab-small md-fab-success"><i class="material-icons"></i></a>
        </div>
    </div>-->
    
    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}" title="Compose" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}">
            <i class="material-icons">&#xE150;</i>
        </a>
        <ul class="compose">       
        	<?php 
        	 	$ri =1;
				$collection_fax1 = $db->nf_fax_users; 			
				$recentFaxs = $collection_fax1->find(array('from_id' => $_SESSION['user_id']))->sort(array("created_date" => -1))->limit(3);		
				foreach($recentFaxs as $recent_Faxs){																	
					if($recent_Faxs['to_id'] != $_SESSION['user_id'] && strlen($recent_Faxs['to_id']) == "24")
					{
						// User Details		
						$RUserDetailsCnt = $collection->find(array('_id' => new MongoId($recent_Faxs['to_id'])))->count();
						if($RUserDetailsCnt > 0){		
							$RUserDetails = $collection->findOne(array('_id' => new MongoId($recent_Faxs['to_id'])));			
						?> 	
	            			<li class="clr<?php echo $ri;?>" name='dssd'><a href="#mailbox_new_message" title="<?php echo $RUserDetails['first_name']." ".$RUserDetails['last_name']; ?>" data-uk-modal="{center:true}" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" onClick="appdmail('<?php echo $RUserDetails['first_name']." ".$RUserDetails['last_name']; ?>','<?php echo $RUserDetails['email_id'];?>','<?php echo $RUserDetails['_id'];?>')"><?php echo ucfirst(substr($RUserDetails['email_id'],0,1)); ?></a></li>
	              <?php $ri++; }      
	              		else
	              		{
	              			$collection_cont = $db->nf_user_contacts;
	              			$RUserDetails = $collection_cont->findOne(array('_id' => new MongoId($recent_Faxs['to_id'])));
						?> 	
	            			<li class="clr<?php echo $ri;?>"><a href="#mailbox_new_message" title="<?php echo $RUserDetails['contact_name']; ?>" data-uk-modal="{center:true}" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" onClick="appdmail('<?php echo $RUserDetails['contact_name']; ?>','<?php echo $RUserDetails['email'];?>','<?php echo $RUserDetails['_id'];?>')"><?php echo ucfirst(substr($RUserDetails['email'],0,1)); ?></a></li>
	              <?php $ri++;
	              		}

	             	}
	             	else if($recent_Faxs['to_id'] != $_SESSION['user_id'])
	             	{ ?>
	             		<li class="clr<?php echo $ri;?>"><a href="#mailbox_new_message" title="<?php echo $recent_Faxs['to_id']; ?>" data-uk-modal="{center:true}" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" onClick="appdmail('','','<?php echo $recent_Faxs['to_id'];?>')"><?php echo ucfirst(substr($recent_Faxs['to_id'],0,1)); ?></a></li>
	             	<?php $ri++;
	             	}
            	}?>
            <!-- <li class="clr2"><a href="#" title="Javved Shaik" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}">J</a></li>
            <li class="clr3"><a href="#" title="mohd khalil" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}">K</a></li> -->
        </ul>
    </div>    
    <script type="text/javascript">
    function appdmail(usName,mailId,usId)
    {
    	document.getElementById('values').value=usId;
    	document.getElementById('labels').value=usName+'('+mailId+')';    	
    	//$('#mail_new_to').focus();
    	document.getElementById('mail_new_to').value=usName+'('+mailId+')'+',';    	    	
    	document.getElementById('mail_new_to').focus();
    	$('#mail_new_to').closest('div').addClass('md-input-filled');
    	return false;
    }   
    </script>     

    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
            <form name='composeFrm' id="composeFrm" action='tcpdf/examples/example_001.php' enctype="multipart/form-data" method='post'>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                	<small style="float:right;margin-top:-15px;font-size:85%;">To add a 
	                	<span id="gg" style="font-size:14px;"><b>Group</b></span><span id="uu" style="display:none;font-size:14px;"><b>User</b></span> <a id="grpshow" style="cursor:pointer;">click here</a>
	                </small>                	
                	<span id="usersmail">	                    
	                    <label for="mail_new_to">To</label>
	                    <!-- <input type="text" class="md-input" name="mail_new_to" id="mail_new_to" required="required" placeholder="User Name" autofocus >       -->
	                    <input type="text" class="md-input" name="mail_new_to" id="mail_to" required="required" placeholder="fax number" autofocus required >  	                    
	                </span>
	                <span id="groupsmail" style="display:none;">
	                	<label for="mail_new_to">To</label>
	                	<input type="text" class="md-input" name="mail_new_to2" id="mail_new_to2" placeholder="Group Name" >      
	                </span>	                
                    
                    <input type="hidden" name="hidd_labels" id="labels">
                    
                    <input type="hidden" name="hidd_values" id="values">   

                    <input type="hidden" name="hidd_grpIds" id="gropId">                        

                </div>
				
				<div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Subject</label>
                    <input name="message_subject" id="message_subject" class="md-input" required />
                </div>
				
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Message</label>
                    <textarea name="message_body" id="message_body" cols="30" rows="6" class="md-input xxs" placeholder="Enter your Message" required></textarea>
                    <!-- <div id = "FileUploadContainer">					
					</div> -->
					<!-- <input id="Button1" type="button" value="Add File" onclick = "AddFileUpload()" class="uk-form-file md-btn" /> -->					
					<!-- New Code File Upload -->
					<span class="uploadBtn">
						<img src="assets/img/attach_file_48.png" height="25" width="26" style="cursor:pointer;position:absolute;margin:17px 40px 0px">
	                	<input name="file[]" type="file" multiple="multiple" class="maxsize-5120" id="our-test" accept="gif|jpg|jpeg|png|doc|docx|pdf|txt" style="opacity:0;margin-bottom:6px;"/>	
	                </span>
	                <!-- End File Code -->
                </div>
                <style type="text/css">
                .xxs{border: none !important;}
                .xss:focus{border: none !important; background-color: #ccc;}
                </style>
                <?php /*<div id="mail_upload-drop" class="uk-file-upload">                						
					<!-- <input id="attachfile" type="button" value="Add File" onclick = "AddFileUpload()" class="uk-form-file md-btn" /> -->					
                    <!--p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" type="file"></a-->
                </div>*/?>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <!--a href="#" class="md-icon-btn"><i class="md-icon material-icons">&#xE226;</i></a!-->
						<!-- <input type='submit' value='send' class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name='submit'  /> -->
                    <!--button type="button" >Send</button-->
                    <input type="hidden" name="faxdetail" value="">
                    <button type="button"  onclick="validateEmail();" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary">Send</button>
                </div>
            </form>
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
      <!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	  <script>tinymce.init({ mode : "exact", elements : "message_body"});</script>-->
    <!-- common functions -->
	
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!--  mailbox functions -->
    <script src="assets/js/pages/page_mailbox.min.js"></script>

    <!-- code for file upload -->
    <script>
    	<?php $alluploadIds = $alltodayIds.$allyesterdIds.$allmonthIds.$allOldmonthIds;?>
		$(function(){			
			$('<?php echo $alluploadIds;?>#our-test').MultiFile({
				onFileChange: function(){
					console.log(this, arguments);
				}
			});
		});
	</script>
	<script src='assets/js/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>
     
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
            <!--<h4 class="heading_c">Sidebar</h4>
            <p>
                <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
                <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
            </p>-->
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

		
		// Check Fax NUmber in compose screen
		function validateEmail(){
			var mail_to=$("#mail_to").val();
			var mail_to_2=$("#mail_new_to2").val();

			if(mail_to=="" && mail_to_2==""){
			alert("Please enter Fax number");
			document.getElementById("mail_to").focus();
			  return false; 	
			}        		

			if(mail_to!=""){

				/*if(isNaN(mail_to)||mail_to.indexOf(" ")!=-1)
				{
				  alert("Enter valid fax number,seprated by comma");
				  document.getElementById("mail_to").focus();
				  return false; 
				}*/

				var nums= mail_to.split(",");

				for(var i=0;i<nums.length;i++){

					if(isNaN(nums[i]))
					{ 
					  	alert("Enter valid fax number,seprated by comma");
					  	document.getElementById("mail_to").focus();
					  	return false; 
					}				     
					if(nums[i].length!=10){ 
					    alert("Please check the fax number, fax number must be 10 digits");
						document.getElementById("mail_to").focus();
				  		return false;     	
					}
				}

			}

			var message_subject=$("#message_subject").val();
			if(message_subject==""){
				alert("Please enter subject");
				document.getElementById("message_subject").focus();
				return false;
			}

			var message_body=$("#message_body").val();
			if(message_body==""){
				alert("Please enter message");
				document.getElementById("message_body").focus();
			  	return false;
			}
			alert("success");
         	document.getElementById("composeFrm").submit();
      	}
      	// End Fax No in compose Screen

		
        var counterInt = 0;

		function AddFileUpload(){ 
		       if(counterInt < 10){
					var div = document.createElement('DIV');
					div.innerHTML = '<i class="md-icon material-icons" style="margin-left:35px;">&#xE226;</i>&nbsp;<input  id="file' + counterInt + '" name = "file[' + counterInt +
					']" type="file" /> '  +
					'<input  class="uk-form-file md-btn" id="Button' + counterInt + '" type="button" ' +
					'value="Remove" onclick = "RemoveFileUpload(this)" /> ';
					document.getElementById("FileUploadContainer").appendChild(div);
					counterInt++;
			   }else{
				   alert("You can attach, only 10 Files.");
				   
			   }
		}

		function RemoveFileUpload(div){
			document.getElementById("FileUploadContainer").removeChild(div.parentNode);
			counterInt--;
		}

        function gFavorites(faxId,fVal)
        {
            $.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"fax_id": faxId,"fav_val":fVal},
                success:function(html){    
                    if(fVal == 'Y')      
                    {
                        alert('Successfully added to favorites');                         
                        $('#favs_sec_'+faxId).load(location.href + " #favs_sec_"+faxId);
                        $('#favs_sec1_'+faxId).load(location.href + " #favs_sec1_"+faxId);
                    }
                    else
                    {
                        alert('Successfully removed from favorites');      
                        $('#favs_sec_'+faxId).load(location.href + " #favs_sec_"+faxId);
                        $('#favs_sec1_'+faxId).load(location.href + " #favs_sec1_"+faxId);
                    }                    
                }
            });        
        }

        function inboxdelete(infaxId,divId)
        {
            $.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"inb_fax_id": infaxId,"section":"inboxdel"},
                success:function(html){                                            
                    $('#fax_'+infaxId).hide();                    
                }
            });
        }

        function seenAjax(Fids)
        {            
            $.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"Sfax_id": Fids,"section":"seen"},
                success:function(html){         
                }
            }); 
        }

        
        // For Adding Tags to individual Tags
        $(".tagsss").click(function(){          	
        	var tag_faxid = $(this).parent().find("input[id='Tag_fax_id']").val();        	
            var favorite = [];
            $.each($(this).parent().parent().find('.Tagbox').find("input[name='addtag']:checked"), function(){            
                favorite.push($(this).val());
            });            
            //alert("My favourite sports are: " + favorite.join(", "));
            var sse = favorite.join(",");                     

        	$.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"tagfaxs": tag_faxid,"tagsId":sse,"section":"tagsAdd"},
                success:function(html){         
                	// if(tgName == "emptytt")
                	// {
                	//  	alert('Fax Removed from tag');                	
                	// }
                	// else
                	// {
                     	alert('Successfully tag Added to fax');                	
                    //}
                }
            });       
        });

     </script>
     <script type="text/javascript"><!--
	div = {
		show: function(elem) {
			document.getElementById(elem).style.visibility = 'visible';
		},
		hide: function(elem) {
			document.getElementById(elem).style.visibility = 'hidden';
		}
	}
--></script>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
	<script >
	// $( document ).ready(function() {
	// 	$("#mail_new_to").keyup(function() {
	// 		var keyword = $("#mail_new_to").val();
	// 		if(keyword != ''){
	// 			$.get( "auto_complete.php", { keyword: keyword } )
	// 			 .done(function( data ) {
	// 				alert(data);
	// 			  });
	// 		}
	// 	});
	// });

	// Show and hide groups input field in compose
	$('#grpshow').click(function(){    					
    	$('#usersmail').toggle();
    	$('#groupsmail').toggle();
    	$('#gg').toggle();
    	$('#uu').toggle();
    	$('input#mail_new_to2,input#mail_new_to,input#labels,input#values').val("");    
    	if ($('input#mail_new_to').attr('required')) {    		
	        $('input#mail_new_to').removeAttr('required');
	        $('input#mail_new_to2').attr('required',true);
	        $('input#mail_new_to2').focus();
	    } else {	    	
	    	$('input#mail_new_to2').removeAttr('required');
	        $('input#mail_new_to').attr('required',true);
	        $('input#mail_new_to').focus();
	    }
    });

    
    $(function() {
        function split( val ) {
        return val.split( /,\s*/ );
        }
        function extractLast( term ) {
        return split( term ).pop();
        }
             
        var projects = [
        <?php             
            $collection = $db->nf_user_contacts;
            $autoComp = $collection->find();
            foreach ($autoComp as $keys) {?>
                {
                    value: "<?php echo $keys['_id'];?>",
                    label: "<?php echo $keys['contact_name'];?> (<?php echo $keys['email'];?>)"
                },                
            <?php } ?>
        // Showing Users
        <?php             
            $collection = $db->nf_user;
            $usersAutoComp = $collection->find();
            foreach ($usersAutoComp as $users_AutoComp) {?>
                {
                    value: "<?php echo $users_AutoComp['_id'];?>",
                    label: "<?php echo $users_AutoComp['first_name'];?> <?php echo $users_AutoComp['last_name'];?> (<?php echo $users_AutoComp['email_id'];?>)"
                },
            <?php } ?>
        ];
             
        $( "#mail_new_to" )         
            .bind( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                response( $.ui.autocomplete.filter(
                projects, extractLast( request.term ) ) );
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
                // add the selected item
                terms.push( ui.item.label );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                    
                    var selected_label = ui.item.label;
                    var selected_value = ui.item.value;
                    
                    var labels = $('#labels').val();
                    var values = $('#values').val();
                    
                    if(labels == "")
                    {
                        $('#labels').val(selected_label);
                        $('#values').val(selected_value);
                    }
                    else    
                    {
                        $('#labels').val(labels+","+selected_label);
                        $('#values').val(values+","+selected_value);
                    }   
                    
                return false;
                }
            });
        }); 

// For group names
	$(function() {
        function split( val ) {
        return val.split( /,\s*/ );
        }
        function extractLast( term ) {
        return split( term ).pop();
        }
             
        var projects = [        
        // Showing groups
        <?php             
            $collection_grp = $db->nf_user_groups;
            $groupsAutoComp = $collection_grp->find(array('user_id' => $_SESSION['user_id']));
            foreach ($groupsAutoComp as $groups_AutoComp) {
            	$allusrds = explode(',', $groups_AutoComp['user_ids']);
            	$allCnames = "";
            	for($i=0;$i < count($allusrds);$i++)
            	{            		
            		$collection_cont = $db->nf_user_contacts;
            		$srchcontac = $collection_cont->findOne(array('_id'=>new MongoId($allusrds[$i])));
            		$allCnames .= $srchcontac['fax'].',';            		
            	}
            	?>
            {
                value: "<?php echo $groups_AutoComp['user_ids'];?>",
                label: "<?php echo $groups_AutoComp['group_name'];?> (<?php echo $allCnames;?>)",
                types: "<?php echo $groups_AutoComp['_id'];?>"
            },
            <?php } ?>
        ];
             
        $( "#mail_new_to2" )         
            .bind( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                response( $.ui.autocomplete.filter(
                projects, extractLast( request.term ) ) );
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
                // add the selected item
                terms.push( ui.item.label );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                    
                    var selected_label = ui.item.label;                    
                    var selected_value = ui.item.value;
                    
                    var labels = $('#labels').val();
                    var values = $('#values').val();
                    var grpidss = $('#gropId').val();                                        
                    
                    if(labels == "")
                    {
                        $('#labels').val(selected_label);
                        $('#values').val(selected_value);
                        $('#gropId').val(ui.item.types);
                    }
                    else    
                    {
                        $('#labels').val(labels+","+selected_label);
                        $('#values').val(values+","+selected_value);
                        $('#gropId').val(grpidss+","+ui.item.types);
                    }                      
                    
                return false;
                }
            });
        }); 
// Group Names End


		function getDivClick(faxId){
			$.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"fax_id": faxId},
                success:function(html){                                
                }
            });        
		}

		function getDivUserNameClick(faxId){
			$.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"fax_id": faxId},
                success:function(html){                                
                }
            });        
		}		
		function getDivSubjectClick(faxId){
			$.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"fax_id": faxId},
                success:function(html){                                
                }
            });        
		}

		// Forwarded Message
		function fwdmsg(fax_subj,fax_body)
		{
			document.getElementById('message_subject').value = fax_subj;			
			document.getElementById('message_body').value = fax_body;
			//$('#message_body').append("sdasawdd");			
			// var obj = document.getElementById('message_body');
		 	// var txt = document.createTextNode(fax_body);
		 	// obj.appendChild(txt);
		 	$('.md-input-wrapper').addClass('md-input-filled');		    
		}	

		// Adding Tags to faxs
		function addingtags(tfaxid,tagId,tgName)
		{
			if(tgName == "aa12")
			{
				alert('Already added to your tags list');
			}
			else
			{				
				$.ajax({
	                url:"auto_complete.php",
	                type:"GET",
	                data: {"tagfaxs": tfaxid,"tagsId":tagId,"section":"tagsAdd"},
	                success:function(html){         
	                	if(tgName == "emptytt")
	                	{
	                	 	alert('Fax Removed from tag');                	
	                	}
	                	else
	                	{
	                     	alert('Successfully Added to "'+tgName+'" tag');                	
	                    }
	                }
	            });   
	            //window.location.reload();
	            $('#'+tfaxid).load(location.href + " #"+tfaxid);                
                setInterval(function() 
                {
                    $('#'+tfaxid).removeClass('md-card-list-item-menu margn');
                    $('#'+tfaxid).removeClass('margn');                     
                }, 100);
	        }
		}

		$('.uk-close').click(function(){
			$('#composeFrm')[0].reset();		
			$('.md-input-wrapper').removeClass('md-input-filled');		
			$("#FileUploadContainer").html('');
		});		
	</script>
	<script>
		(function($){
		  function readFile(input,linkto) {
		    var template = '<div class="upload-file"><span class="title">FileName</span> <span class="size">(3Kb)</span><span class="removeUploadFile">X</span></div>';

		        if (input.files && input.files[0]) {
		        	for (var i = 0; i < input.files.length; i++) {
			        	var size = (input.files[i].size / 1024 < 1) ? 1 : parseInt(input.files[i].size / 1024 + 1);		            
				        var $template = $(template);
				        $template.find(".title").text(input.files[0].name);
				        $template.find(".size").text("(" + size + "Kb)" );
				        $template.find(".removeUploadFile").bind("click", function(e){
				        	e.preventDefault();
				        	$(this).parent().remove();
				        });		            
				        $($template).appendTo(".uploadFilesList_"+linkto);
				        console.log("Success");
		        	}		          
		        }
		    }

		    $(".upload").change(function() {
		    	console.log("Read");
		    	var str =$(this).attr('id');
				var ret = str.split("_");
				var str1 = ret[0];				
				var str2 = ret[1];				
		        readFile(this,str2);
		    });
		})(jQuery);

		function restComposeForm(){
			$("#FileUploadContainer").html('');
		}
	</script>
   	
</body>
</html>