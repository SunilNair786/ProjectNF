<?php include_once('includes/header.php'); ?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php'); ?>
<!-- main sidebar end -->
<?php
// add Tag
if($_POST['tag_submit'] == "Save")
{		
	$tagIns = $userContObj->TagInsert($_POST);   
	header('location:tag.php'); 
	exit;
}

// Edit Tag
if($_POST['tag_submit'] == "Update")
{	
	$Edit_tagIns = $userContObj->TagEditing($_POST);   
    header('location:tag.php'); 
    exit;	
}

?>
<div id="page_content">
	<div id="page_content_inner">
		<div class="uk-width-large-8-10 uk-container-center">
		<h3 class="heading_b uk-margin-bottom">Tags</h3>

		<div class="md-card-list-wrapper" id="mailbox">  

			<div class="md-card">
				<div class="md-card-content">
					<h3 class="heading_a">Advanced Selects  
						<!-- <button type="button" class="md-btn md-btn-success pull-right" onclick="UIkit.modal.prompt('Tag:', '', function(val){ UIkit.modal.alert('Your Tag is '+(val || 'Mr noname')+'!'); });">
							Create a Tag
						</button> -->		
						<a class="md-btn md-btn-success pull-right" id="add_tag1" style="float:right; display:none;">
							Create a Tag
						</a>
						<a class="md-btn md-btn-success pull-right" id="add_tag" href="#New_tag" data-uk-modal="{center:true}" style="float:right;">
							Create a Tag
						</a>
						<?php 
						$collection = $db->nf_company_tags; 
		                $Cntalltags = $collection->find(array("user_id" => $_SESSION['user_id']))->count(); 
		                if($Cntalltags > 0){?> 
							<i id="buttonStart" title="edit" class="fa fa-pencil" style="float:right; padding:10px; margin-right:15px; cursor:pointer;"></i>
						<?php } ?>						
						
					</h3>
					<div class="uk-grid" data-uk-grid-margin>
						<div class="uk-width-large-1">
							<!-- <select id="selec_adv_1" name="selec_adv_1" multiple>
								<option value="all" selected>All</option>
								<?php 
	                            $collection = $db->nf_company_tags; 
	                            $alltags = $collection->find(array("user_id" => $_SESSION['user_id']));                            
	                            foreach($alltags as $all_tags){?>
	                            	<option value="<?php echo $all_tags['_id']; ?>" selected><?php echo $all_tags['tag_name']; ?></option>
	                            <?php } ?>
							</select>	 -->	

							<div class="tagsshake neews" id="editing" style="display:none;">
								<?php 
								$hidTinc = 1;
		                        $collection = $db->nf_company_tags; 
		                        $alltags = $collection->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));                            
			                    foreach($alltags as $all_tags){?>
									<div class="saaas" id="<?php echo $all_tags['_id'];?>">
										<a href="#edit_tag_<?php echo $hidTinc;?>" data-uk-modal="{center:true}">
											<span <?php if($_GET['tagged']==$all_tags['_id']){?>style="color:#1A60CC"<?php } ?>>
												<?php echo $all_tags['tag_name']; ?>
											</span>
										</a>
										<?php if($_GET['tagged'] != $all_tags['_id']){?>
											<i class="closebtn" onclick="deleteTag1('<?php echo $all_tags['_id'];?>','none')"></i>
										<?php } else{ ?>
											<i class="closebtn" onclick="deleteTag1('<?php echo $all_tags['_id'];?>','own')"></i>
										<?php } ?>
									</div>								
								<?php $hidTinc++; } ?>
								<div class="clearfix"></div>
							</div>

							<div class="tagsshake" id="redirect">
								<?php 
		                        $collection = $db->nf_company_tags; 
		                        $alltags = $collection->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));                            
		                        foreach($alltags as $all_tags){?>
									<div>
										<a href="?tagged=<?php echo $all_tags['_id']; ?>">
											<span <?php if($_GET['tagged']==$all_tags['_id']){?>style="color:#1A60CC"<?php } ?>>
												<?php echo $all_tags['tag_name']; ?>
											</span>
										</a>
									</div>	
								<?php } ?>		
								<div class="clearfix"></div>
							</div>
							<!-- tags end -->
						</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
			</div>
			
		<?php 
			
			$collection_fax = $db->nf_fax_users; 
			$collection_fax_details = $db->nf_fax;
			$collection = $db->nf_user; 
			$sessId = $_SESSION['user_id'];
			
			// Search Code
			if($_GET['tagged']!="")
			{
				$searchTag = $_GET['tagged'];
			}
			else
			{
				$searchTag = "{".$ne.":".""."}";
			}
			
			$alltagfaxs = $collection_fax->find(array('to_id' => "$sessId",'fax_tag' => new MongoRegex("/".$searchTag."/i"),'is_delete'=> 0))->sort(array("created_date" => -1));					
			$allTodayCnt = $collection_fax->find(array('to_id' => "$sessId",'fax_tag' => new MongoRegex("/".$searchTag."/i"),'is_delete'=>0))->count();		

			// For Outbox Faxs
			$CntallOutfaxs = $collection_fax_details->find(array("from_id" => $sessId,'outbox_fax_tag' => new MongoRegex("/".$searchTag."/i"),"status" => "A","outbox" => "Y"))->count();   
            $allOutfaxs = $collection_fax_details->find(array("from_id" => $sessId,'outbox_fax_tag' => new MongoRegex("/".$searchTag."/i"),"status" => "A","outbox" => "Y"))->sort(array("created_date" => -1));               
		?>
            <div class="md-card-list">
                <!-- <div class="md-card-list-header heading_list">Today</div> -->           
                <div class="md-card-list-header-combined heading_list"><!-- md-card-list-header  -->
                	All Messages
	                <?php if($_GET['tagged'] != ""){?>
						<a class="pull-right" href="tag.php">
							<i class="fa fa-times"></i> Clear
						</a>
					<?php } ?>	
				</div>
                <ul class="hierarchical_slide">
                   <?php	
               		if($allTodayCnt > 0 ){		
               			// Inbox Faxs
						foreach ($alltagfaxs as $all_tagfaxs) { 	
						$is_read = $all_tagfaxs['is_read'];
						if($is_read == 0 ){
							$divClk = "onClick=getDivClick(".$all_tagfaxs['_id'].")";
							$divUsrNameClk = "onClick=getDivUserNameClick(".$all_tagfaxs['_id'].")";
							$divSujClk = "onClick=getDivSubjectClick(".$all_tagfaxs['_id'].")";
						}else{
							$divClk = "";
							$divUsrNameClk = "";
							$divSujClk = "";
						}
						
							// User Details										
							$userDetails = $collection->findOne(array('_id' => new MongoId($all_tagfaxs['from_id'])));	
							
							// Fetch Fax subject information from nf_fax;
							$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($all_tagfaxs['fax_id'])));															
							?>           
						<li <?php if($all_tagfaxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $all_tagfaxs['_id'];?>')"<?php } ?>>
							<div class="md-card-list-item-menu margn">                                    								
								<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $all_tagfaxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a>                                         
								<span id="favs_sec_<?php echo $all_tagfaxs['_id'];?>">
									<?php if($all_tagfaxs['favorites'] == "N"){?>
										<a id="Fav_id" onClick="gFavorites('<?php echo $all_tagfaxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a>
									<?php } else { ?>
										<a id="Fav_id" onClick="gFavorites('<?php echo $all_tagfaxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary"></i> </a>
									<?php } ?> 
								</span>
							</div>							
							
							<span class="md-card-list-item-date"><?php echo date('j M',strtotime($all_tagfaxs['created_date'])); ?></span>
							<div class="md-card-list-item-select">
								<input type="checkbox" data-md-icheck />
							</div>
							<div class="md-card-list-item-avatar-wrapper" <?php echo $divClk; ?>>
								<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
							</div>
							<div class="md-card-list-item-sender" <?php echo $divUsrNameClk; ?>>
								<span><?php echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>                                    
							</div>
							<div class="md-card-list-item-subject" <?php echo $divSujClk; ?>>
								<div class="md-card-list-item-sender-small">
									<span><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
								</div>
								<span>
									<?php echo substr($userFaxDetails['message_subject'],0,30);?>
									<span id="favs_sec1_<?php echo $amonth_Faxs['_id'];?>" style="float:right;">
										<?php if($all_tagfaxs['favorites'] == "Y") { ?>
											<a id="Fav_id" onClick="gFavorites('<?php echo $all_tagfaxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary"></i> </a>
										<?php } ?>
									</span>
								</span>
							</div>		
							<div class="md-card-list-item-content-wrapper">
								<div class="md-card-list-item-content">
									<?php echo html_entity_decode($userFaxDetails['message_body']); ?>												
								</div>

								<!-- Reply Messages Section start -->
									<?php 
									$collection_fax_reply = $db->nf_fax_replys; 
									$rfax_id = $all_tagfaxs['fax_id'];
									$replyfaxs = $collection_fax_reply->find(array('fax_id' => "$rfax_id"))->sort(array("created_date" => -1));

									foreach ($replyfaxs as $reply_faxs) {													
									?>
										<span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply_faxs['created_date'])); ?></span>
										<div class="md-card-list-item-select">
											<!-- <input type="checkbox" data-md-icheck /> -->
										</div>
										<?php $rplyUserDetails = $collection->findOne(array('_id' => new MongoId($reply_faxs['from_id']))); 	?>
										<div class="md-card-list-item-avatar-wrapper">
											<span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails['first_name'][0].''.$rplyUserDetails['last_name'][0]; ?></span>
										</div>
										<div class="md-card-list-item-sender">
											<span><?php echo ucfirst($rplyUserDetails['first_name']).' '.ucfirst($rplyUserDetails['last_name']); ?></span>                                    
										</div>																									
										<div class="md-card-list-item-content">
											<?php echo html_entity_decode($reply_faxs['message_body']); ?>												
										</div>
										<br><br><br>
									<?php } ?> 												
								<!-- Reply Message Section End -->

								<form class="md-card-list-item-reply" name="replyform" method="post">	
									<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>		
									<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
									<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
									<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $all_tagfaxs['fax_id']; ?>">
									<textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>			
									<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
								</form>
							</div>
						</li>	
					<?php }// foreach
						// Inbox Faxs End
					}//If condition


		// Outbox Faxs search
					if($CntallOutfaxs > 0 ){		
						     
                            foreach ($allOutfaxs as $allOut_faxs) {  	
                                // getting User and Contact Details
                                $udetailemail = '';
                                $udetail = '';
                                $urdetail = '';
                                $uIds = '';

                                if($allOut_faxs['from_grp'] != "")
                                {
                                    $usrGrpIds = explode(',',$allOut_faxs['from_grp']);
                                    for($se = "0";$se < count($usrGrpIds); $se++)
                                    {
                                        $gropInfo = $db->nf_user_groups->find(array('_id' => new MongoId($usrGrpIds[$se])));                                    
                                        foreach ($gropInfo as $grop_Info) {  
                                            $udetailemail = '';
                                            $udetail = '';
                                            $uIds = '';  
                                            $grpDisp .= $grop_Info['group_name'].',';    
                                            $faxInfo = $collection_fax->find(array('fax_id' => $allOut_faxs['_id']));      
                                            foreach ($faxInfo as $fax_Info) {  

                                                $CoutUserDetail = $collection->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();
                                                $outUserDetail = $collection->findOne(array('_id' => new MongoId($fax_Info['to_id'])));     
                                                // In Contacts
                                                $UserDetailCount = $db->nf_user_contacts->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();          
                                                $contUserDetail = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax_Info['to_id'])));          
                                                if($CoutUserDetail > 0)  
                                                {
                                                    $udetailemail .= $outUserDetail['first_name']." ".$outUserDetail['last_name']." (".$outUserDetail['email_id']."), ";
                                                    $urdetail .= $outUserDetail['first_name']." ".$outUserDetail['last_name'].",";
                                                    $udetail .= $outUserDetail['fax'].",";
                                                    $uIds .= $outUserDetail['_id'].",";
                                                }
                                                else if($UserDetailCount > 0)
                                                {   
                                                    $udetailemail .= $contUserDetail['contact_name']." (".$contUserDetail['email']."), ";
                                                    $urdetail .= $contUserDetail['contact_name'].",";
                                                    $udetail .= $contUserDetail['fax'].",";
                                                    $uIds .= $contUserDetail['_id'].",";
                                                }                                         
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $faxInfo = $collection_fax->find(array('fax_id' => $allOut_faxs['_id']));                                    
                                    foreach ($faxInfo as $fax_Info) {        
                                        if(strlen($fax_Info['to_id']) == "24")
                                        {
                                            $CoutUserDetail = $collection->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();
                                            $outUserDetail = $collection->findOne(array('_id' => new MongoId($fax_Info['to_id'])));     
                                            // In Contacts
                                            $UserDetailCount = $db->nf_user_contacts->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();          
                                            $contUserDetail = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax_Info['to_id'])));          
                                            if($CoutUserDetail > 0)  
                                            {
                                                $udetailemail .= $outUserDetail['first_name']." ".$outUserDetail['last_name']." (".$outUserDetail['email_id']."), ";
                                                $urdetail .= $outUserDetail['first_name']." ".$outUserDetail['last_name'].",";
                                                $udetail .= $outUserDetail['fax'].",";
                                                $uIds .= $outUserDetail['_id'].",";
                                            }
                                            else if($UserDetailCount > 0)
                                            {   
                                                $udetailemail .= $contUserDetail['contact_name']." (".$contUserDetail['email']."), ";
                                                $urdetail .= $contUserDetail['contact_name'].",";
                                                $udetail .= $contUserDetail['fax'].",";
                                                $uIds .= $contUserDetail['_id'].",";
                                            }
                                        }
                                        else
                                        {
                                            $udetailemail .=$fax_Info['to_id'].",";
                                            $udetail .= $fax_Info['to_id'].",";
                                            $uIds .= $fax_Info['to_id'].",";
                                        }
                                    }
                                }
                            ?>    
                            <li>                                
                                <div class="md-card-list-item-menu margn" id="<?php echo $allOut_faxs['_id'];?>">     
                                    <?php /*<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail,0,-2);?>','<?php echo substr($uIds,0,-1);?>','<?php echo $allOut_faxs['message_subject'];?>','<?php echo $allOut_faxs['message_body'];?>')" title="Resend"><i class="fa fa-paper-plane"></i></a>      
                                    <a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>                                                        
                                        <div class="dropdown">
                                            <div class="arrow-up"></div>
                                            <ul class="Tagbox">
                                                <?php 
                                                $collection_tag = $db->nf_company_tags; 
                                                $alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
                                                $Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
                                                if($Cntsalltags > 0)
                                                {
                                                    foreach ($alltags as $all_tags) {?>                                                    
                                                    <li>
                                                        <?php //echo $all_faxs['fax_tag']."<br>".$all_tags['_id']; 
                                                        $mnth = (string)$allOut_faxs["outbox_fax_tag"];
                                                        $indvTag = (string)$all_tags["_id"];
                                                        $aaa = strpos($mnth,$indvTag);  
                                                        if($aaa !== false){?>
                                                            <input type="checkbox" name="addtag" id="addtag" value="<?php echo $all_tags['_id'];?>" checked>&nbsp;<?php echo $all_tags['tag_name'];?>
                                                        <?php } else { ?>
                                                            <!-- <a onClick="addingtags('<?php echo $allOut_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')" title="click to add this"></a> -->
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
                                                    <input type="hidden" name="Tag_fax_id" id="Tag_fax_id" value="<?php echo $allOut_faxs['_id'];?>">
                                                    <input type="button" name="sub_tag" id="sub_tag" value="Apply" class="uk-float-left md-btn md-btn-flat tagsss" style="width:100%;margin-top:-15px;background-color:#ccc;">
                                                </span>
                                            <?php } ?>
                                        </div> */?>
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $allOut_faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>       
                                </div>
                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($allOut_faxs['created_date'])); ?></span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <img src="assets/img/avatars/avatar_07_tn.png" class="md-card-list-item-avatar" alt="" />
                                    <span class="md-card-list-item-avatar md-bg-grey"><?php //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span>                                    	
                                        <?php  
                                        //echo $udetailemail;   
                                        if($allOut_faxs['from_grp'] != "")
                                        {
                                            echo substr($grpDisp,0,-1);
                                        }
                                        else
                                        {
                                            echo substr($udetail, 0, -1); 
                                        }
                                        //echo $uIds;                                    
                                        ?>                                        
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>                                        	
                                            <?php   
                                            if($allOut_faxs['from_grp'] != "")
                                            {
                                                echo substr($grpDisp,0,-1);
                                            }
                                            else
                                            {                                                                                   
                                                echo substr($udetail, 0, -1); 
                                            }
                                            //echo $uIds;
                                            ?>
                                        </span>
                                    </div>
                                    <span>
                                    	<span style=""><b style="padding:2px 4px; background-color:#ccc;">outbox</b></span>
                                    	<?php echo substr($allOut_faxs['message_subject'],'0','20'); ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        <?php echo $allOut_faxs['message_body'];echo "<br><br>";
                                        $userId_arr = explode(',',$allOut_faxs['file_attach_id']);
                                        
                                        /*if($allOut_faxs['file_attach_id'] != "")
                                        {

                                            $userId_arr = explode(',',$allOut_faxs['file_attach_id']);                                            
                                            foreach($userId_arr as $attachIds)
                                            {
                                                $collectionUpload = $db->nf_user_fileuploads;
                                                $files12 = $collectionUpload->findOne(array('_id' => new MongoId($attachIds)));
                                                echo $files12['file_name'];

                                                $filType = explode(".", $files12['file_name']);
                                                echo $filType[1];
                                            }

                                        }

                                        if($allOut_faxs['file_attach_id'] != "")
                                        {
                                            $img = 1;
                                            $attachments = explode(",",$allOut_faxs['file_attach_id']);                                                          
                                            for($i = 0; $i< sizeof($attachments); $i++)
                                            {
                                                $collection_attach = $db->nf_user_fileuploads; 
                                                $allattachments = $collection_attach->find(array("_id" => new MongoId($attachments[$i])))->sort(array("created_date" => -1));                                                       
                                                foreach($allattachments as $all_attachments)
                                                {
                                                    $ftype = explode(".",$all_attachments['file_name']);
                                                    if($ftype != "pdf")
                                                    {?>
                                                        <a href="#image_<?php echo $all_attachments['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                            <img title="click to view image" src="upload_dir/files/<?php echo $all_attachments['file_name'];?>" id="img_atch" width="100" height="50">
                                                        </a>                                                                
                                                        <div class="uk-modal" id="image_<?php echo $all_attachments['_id'];?>_popup<?php echo $img;?>">
                                                            <div class="uk-modal-dialog" style="width:1000px; height:600px;">       
                                                                <button class="uk-modal-close uk-close" type="button"></button>
                                                                <img src="upload_dir/files/<?php echo $all_attachments['file_name'];?>"/>
                                                            </div>
                                                        </div>
                                                    <?php }else {?>
                                                        <a href="upload_dir/files/<?php echo $all_attachments['file_name'];?>">View the attachment</a>
                                                    <?php }
                                                    $img++;
                                                } 
                                            }
                                        }*/

                                        if($allOut_faxs['saved_pdf_file'] != "")
                                        {?>  
                                            <a href="#image_<?php echo $allOut_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
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
                                            <?php /*<a href="#image_<?php echo $allOut_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $allOut_faxs['file_name'];?>" id="img_atch" width="100" height="50"> -->
                                                <img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">
                                            </a>    */?>                                                           
                                            <div class="uk-modal" id="image_<?php echo $allOut_faxs['_id'];?>_popup">
                                                <div class="uk-modal-dialog" style="width:90%; height:90%;">        
                                                    <button class="uk-modal-close uk-close" type="button"></button>
                                                    <iframe src="upload_dir/savedpdfs/<?php echo $allOut_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
                                                    <a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
                                                </div>
                                            </div>
                                            <!-- <a href="upload_dir/savedpdfs/<?php echo $allOut_faxs['saved_pdf_file'];?>">View the attachment</a> -->      
                                        <?php } ?>
                                        <br>
                                        <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail,0,-2);?>','<?php echo substr($uIds,0,-1);?>','<?php echo $allOut_faxs['message_subject'];?>','<?php echo $allOut_faxs['message_body'];?>')" title="Resend"><button class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" type="button">Resend</button></a>   
                                    </div>                                    
                                </div>
                            </li>

                            <?php } 
					}
		// Outbox Faxs search End

					else if($allTodayCnt == 0 && $_GET['tagged'] != "")
					{?>
						<li>							
							<div class="md-card-list-item-subject" <?php echo $divSujClk; ?>>								
								<span style="text-align:center;font-weight:bold;">No Faxs Tagged</span>
								<div class="md-card-list">                
			                        <center>
			                            <img src="assets/img/fax.png" alt="No Faxs Found" height="150" width="200">
			                            <br>Oops..! No faxs Found here....
			                        </center>
			                    </div>
							</div>	     									
						</li>
					<?php 
					} 
					else 
					{ ?>
						<li>							
							<div class="md-card-list-item-subject">								
								<span style="text-align:center;font-weight:bold;">Please Select a Tag to show your faxes</span>
							</div>	 
							<div class="md-card-list">                
		                        <center>
		                            <img src="assets/img/fax.png" alt="No Faxs Found" height="150" width="200">
		                            <br>No faxs Found here....
		                        </center>
		                    </div>	     									
						</li>
					<?php } ?>       

                </ul>
            </div>

    	</div>
    	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		<script>
			$(document).ready(function(){
				$('input#tag_name').on('keyup',function(){
					var charCount = $(this).val().length;			
					if(charCount >= 21)
					{
						$(this).val($(this).val().substring(0, charCount-1));
					}
					$(".result").text(charCount + " of 20 characters");						
				});

				// Editing Tags		
				$('input[name=edit_tag_name]').on('keyup',function(){
					var charCount = $(this).val().length;			
					if(charCount >= 21)
					{
						$(this).val($(this).val().substring(0, charCount-1));
					}
					$(".result").text(charCount + " of 20 characters");			
				});
			});
		</script>
            

		<!-- Creating tag -->

		<div class="uk-modal" id="New_tag">
	        <div class="uk-modal-dialog">
	        	<button class="uk-modal-close uk-close" type="button"></button>
	            <form name="newTag" id="newTag" method="post" onsubmit="return checkDuplicate();">
	                <div class="uk-modal-header">
	                    <h3 class="uk-modal-title">Tag :</h3>	                    
	                </div>
	                <div class="uk-margin-medium-bottom">
	                    <!-- <label for="tag_name">Tag Name</label> -->
	                    <input type="text" class="md-input" name="tag_name" id="tag_name" placeholder="Enter your text.." autofocus required /><br><br>	     
	                    <input type="hidden" name="tag_submit" value="Save">
						<div class="result" style="float:right">0 of 20 characters</div>
	                </div>
	                <div class="uk-modal-footer">                    	                    
	                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="tag_submit" id="tag_submit" value="Save" />	                    
	                </div>
	            </form>
	        </div>
	    </div>
	    <!-- End Creating tag -->

	    <!-- Editing tags -->
	    <?php 
	    	$Tinc = 1;
           	$collection = $db->nf_company_tags; 
            $edit_tags1 = $collection->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));                            
            foreach($edit_tags1 as $edit_tags_indv){?>

			<div class="uk-modal" id="edit_tag_<?php echo $Tinc; ?>">
		        <div class="uk-modal-dialog">
		        	<button class="uk-modal-close uk-close" type="button"></button>
		            <form name="editTag<?php echo $Tinc;?>" id="editTag<?php echo $Tinc;?>" method="post" onsubmit="return checkDuplicateEdit(<?php echo $Tinc;?>);">
		                <div class="uk-modal-header">
		                    <h3 class="uk-modal-title">Tag :</h3>	     
		                    <input type="hidden" name="hidd_tag_id" value="<?php echo $edit_tags_indv['_id']; ?>"> 
		                </div>
		                <div class="uk-margin-medium-bottom">
		                    <!-- <label for="tag_name">Tag Name</label> -->
		                    <input type="text" class="md-input" name="edit_tag_name" id="edit_tag_name_<?php echo $Tinc;?>" value="<?php echo $edit_tags_indv['tag_name']; ?>" autofocus required />
		                    <div class="result" style="float:right"><?php echo strlen($edit_tags_indv['tag_name']);?> of 20 characters</div>
		                    <input type="hidden" name="tag_submit" value="Update">
		                </div>
		                <div class="uk-modal-footer">                    	                    
		                    <input type="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name="tag_submit" value="Update" />	                    
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
	<!--  mailbox functions -->
    <script src="assets/js/pages/page_mailbox.min.js"></script>

    <script src="assets/js/wiggleicon/jquery.classywiggle.min.js"></script>

    <script>
	$(document).ready(function() {		
	    var interval = null;
	    $('#buttonStart').click(function() {
	    	$('#redirect').toggle();	    	
	    	var isVisible = $("#editing").toggle().is(":visible");
	    	if (isVisible) {
	        	$('.saaas').ClassyWiggle('start');	        	
	        	$('#add_tag').hide();
	        	$('#add_tag1').show();
	        }
	        else
	        {
	        	$('div#wigglewrapper .saa').ClassyWiggle('stop');
	        	$('#add_tag1').hide();
	        	$('#add_tag').show();
	        	clearInterval(interval);
	        	$('#redirect').load(location.href + " #redirect");	        	
	        }
	    });
	});

	function deleteTag1(tagId,sect)
	{
		var sss = <?php echo $Cntalltags;?>;	
		$.ajax({
            url:"auto_complete.php",
            type:"GET",
            data: {"tagId": tagId,"tag_sec":"TagsDelete"},
            success:function(html){    
            	alert('Successfully Deleted');   
            	$('#'+tagId).hide();
            	if(sect == "own")
            	{
            		if(sss > 1)
            		{            		
            			window.location.href="tag.php?tagged=<?php echo $wws;?>";
            		}
            		else
            		{            			
            			window.location.href="tag.php";
            		}
            	}
            	else
            	{
            		if(sss > 1)
            		{
            			window.location.href="tag.php?tagged=<?php echo $wws;?>";
            		}
            		else
            		{
            			window.location.href="tag.php";
            		}
            	}
            }
        });
	}
	</script>


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


			// Select Dropdown Script
            $('#selec_adv_1').selectize({
	            options: [
	            		
	            	{id: "all" , title: 'All', url: '#jhghjgjhk' ,user_id:'alls'},
	            	<?php 
	            		$EdTinc = 1;
                       	$collection = $db->nf_company_tags; 
                        $alltags2 = $collection->find(array("user_id" => $_SESSION['user_id']));  
						$sessUserId = $_SESSION['user_id'];
						
                        foreach($alltags2 as $all_tags2){
							$userId =  $all_tags2["user_id"];	
							if($sessUserId == $userId){								
								$urlTag = "#edit_tag_$EdTinc";
								$EdTinc++;
							}else{
								$urlTag = '';
							}
					?>							 
	                		{id: "<?php echo $all_tags2['_id']?>" , title: '<?php echo $all_tags2["tag_name"]; ?>', url: '<?php echo $urlTag; ?>' ,user_id:'<?php echo $all_tags2["user_id"]; ?>'},
	                <?php  } ?>	                	                
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
	</script>
	 <!--  forms advanced functions -->
    <!--<script src="assets/js/pages/forms_advanced.min.js"></script>-->    
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
		function deleteTag(values){				
			if(confirm('Are you sure you want to remove ?')){
				$.get("auto_complete.php?tagId="+values, function(data, status){
					location.reload();
				});							     
			}else{
				//return false;
			}
		}

		// Duplicate Tags
		function checkDuplicate() 
		{				
			var taVal = document.getElementById('tag_name').value;						
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
						document.getElementById('tag_name').focus();                   		
						//return true;                		
					}
					else
					{
					document.forms['newTag'].submit();
					}
				}
				});		
				//return false;
			}
			else
			{
				alert('Please Enter Only 20 Characters');
				document.getElementById('tag_name').focus();    
			}
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

		// Adding favorites
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
    </script> <!-- ionrangeslider -->
    <?php /*<script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
    <!-- htmleditor (codeMirror) -->
    <script src="assets/js/uikit_htmleditor_custom.min.js"></script>
    <!-- inputmask-->
    <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>

    <!--  forms advanced functions -->
    <script src="assets/js/pages/forms_advanced.min.js"></script>*/?>
</body>
</html>