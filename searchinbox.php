<div class="uk-width-large-8-10 uk-container-center">
	<?php 			
	$collection_fax = $db->nf_fax_users; 
	$collection_fax_details = $db->nf_fax;
	$collection = $db->nf_user; 
	$sessId = $_SESSION['user_id'];

	// $db->users->find(array("name" => new MongoRegex("/Joe/")));

	// $db->users->find(array('$or' => array(array("a" => 1), array("b" => 2))));
	
	$searchfaxs = $collection_fax_details->find(array('$or' => array(array("message_subject" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("message_body" => new MongoRegex("/".$_REQUEST['name_2']."/i")))))->sort(array("created_date" => -1));	
	$searchfaxsCnt = $collection_fax_details->find(array('$or' => array(array("message_subject" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("message_body" => new MongoRegex("/".$_REQUEST['name_2']."/i")))))->count();	?>
	<div class="md-card-list" id="searcht">
        <!-- <div class="md-card-list-header heading_list">Today</div>                         -->
        <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
        <ul class="hierarchical_slide">

	<?php if($searchfaxsCnt > 0 ){	?>
    
           <?php	 
            $srch = 1;
			foreach ($searchfaxs as $search_faxs){ 			
				$Srchallfaxs = $collection_fax->find(array('fax_id'=>$search_faxs['_id'],'to_id' => "$sessId",'is_delete'=> 0))->sort(array("created_date" => -1));
				$Cntallfaxs = $collection_fax->find(array('fax_id'=>$search_faxs['_id'],'to_id' => "$sessId",'is_delete'=> 0))->sort(array("created_date" => -1))->count();
				if($Cntallfaxs > 0)
				{
					foreach($Srchallfaxs as $Srchall_faxs)
					{		
					// User Details										
					$userDetails = $collection->findOne(array('_id' => new MongoId($search_faxs['from_id'])));											
					// Fetch Fax subject information from nf_fax;
					$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($Srchall_faxs['fax_id'])));															
					?>           
				<li <?php if($Srchall_faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $Srchall_faxs['_id'];?>')"<?php } ?>>
					<div class="md-card-list-item-menu margn" id="<?php echo $search_faxs['_id'];?>">                                    
						<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
						<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
						<a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>														
							<div class="dropdown">
								<div class="arrow-up"></div>
							    <ul>
							    	<?php 
							    	$collection_tag = $db->nf_company_tags; 
							    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
							    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
							    	if($Cntsalltags > 0)
							    	{
							    		foreach ($alltags as $all_tags) {?>
							    		<li>

							    			<?php if($search_faxs['fax_tag'] == $all_tags['_id']){?>
							    				<a title="tag" onClick="addingtags('<?php echo $search_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>			
							    				<span onClick="addingtags('<?php echo $search_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
							    					<i class="fa fa-times"></i>
							    				</span>
							    			<?php } else { ?>
							    				<a title="click to add this tag" onClick="addingtags('<?php echo $search_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>			
							    			<?php } ?>
							    		</li>
							    	<?php }
							    	} else {?>		
							    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
							    	<?php } ?>
					            </ul>
				            </div>
						<!-- <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $search_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a> -->                                         
						<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { inboxdelete('<?php echo $search_faxs['_id'];?>','searcht'); return false;}" title="delete"><i class="fa fa-trash"></i></a>
						<span id="favs_sec_<?php echo $search_faxs['_id'];?>">
							<?php if($Srchall_faxs['favorites'] == "N"){?>
								<a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id'];?>','Y')" title="favorites"><i class="fa fa-star"></i> </a>
							<?php } else { ?>
								<a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id']; ?>','N')" title="favorites"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
							<?php } ?> 
						</span>
					</div>
					
					<span class="md-card-list-item-date"><?php echo date('j M',strtotime($search_faxs['created_date'])); ?></span>
					<div class="md-card-list-item-select">
						<input type="checkbox" data-md-icheck />
					</div>
					<div class="md-card-list-item-avatar-wrapper" <?php //echo $divClk; ?>>
						<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
					</div>
					<div class="md-card-list-item-sender" <?php //echo $divUsrNameClk; ?>>
						<span><?php echo $userDetails['fax']; //echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>      
					</div>
					<div class="md-card-list-item-subject" <?php //echo $divSujClk; ?>>
						<div class="md-card-list-item-sender-small">
							<span><?php echo $userDetails['fax']; //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
						</div>
						<span><?php echo substr($search_faxs['message_subject'],0,30);?>
							<span id="favs_sec1_<?php echo $search_faxs['_id'];?>" style="float:right;">
								<?php if($Srchall_faxs['favorites'] == "N"){?>
									<!-- <a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a> -->
								<?php } else { ?>
									<a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
								<?php } ?> 
							</span>
						</span>
					</div>		
					<div class="md-card-list-item-content-wrapper">
						<div class="md-card-list-item-content">
							<?php echo html_entity_decode($search_faxs['message_body']); echo "<br><br>";
							if($search_faxs['saved_pdf_file'] != "")
							{?>													
				    			<a href="#image_<?php echo $search_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
				    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $search_faxs['file_name'];?>" id="img_atch" width="100" height="50"> 
				    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
				    				<div class="file">
                                        <div class="file-icon" data-type="filename.mp3">
                                          <img src= "assets/img/fax.png" alt="fax.image">
                                        </div>
                                        <p class="title">File name.pdf</p>
                                        
                                        <div class="download-btn">
                                          <p>File name.pdf</p>                                                  
                                          <img class="pdf" src="assets/img/pdf.png" alt="pdf">
                                        </div>
                                    </div>
				    			</a>		
				    			<div class="uk-modal" id="image_<?php echo $search_faxs['_id'];?>_popup">
				    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
				    					<button class="uk-modal-close uk-close" type="button"></button>
				    					<iframe src="upload_dir/savedpdfs/<?php echo $search_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
				    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
				    				</div>
				    			</div>
				    			<!-- <a href="upload_dir/savedpdfs/<?php echo $search_faxs['saved_pdf_file'];?>">View the attachment</a> -->
							<?php } ?>		
						</div>

						<!-- Reply Messages Section start -->
							<?php 
							$collection_fax_reply = $db->nf_fax_replys; 
							$rfax_id = $Srchall_faxs['fax_id'];
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
									<?php echo html_entity_decode($reply_faxs['message_body']); ?>												
								</div>
								<br><br><br>
							<?php } ?> 												
						<!-- Reply Message Section End -->

						<form class="md-card-list-item-reply" name="replyform" method="post">	
							<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>		
							<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
							<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
							<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $search_faxs['fax_id']; ?>">
							<textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>			
							<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
							<img src="assets/img/attach_file_48.png" height="25" width="23" style="margin-top:12px; margin-bottom:-10px;">
						</form>
					</div>
				</li>	
		  	  <?php }//user foreach

		  	  	$totsfax += $Cntallfaxs;
		  	  	} //user if condition End
		  	  	$srch++; 
		  	} // foreach 	?>                           	           
        
	<?php }// if $allfaxsTodayCnt close 
	else
	{
		$Cntallfaxs = "0";
	}


	
	// Search In contact Names
	
	// if($searchfaxsCnt == "0")				
	// {					
		// echo $userDetails = $collection->find(array('$or' => array(array("first_name" => new MongoRegex("/^".$_REQUEST['name_2']."$/i")),array("last_name" => new MongoRegex("/^".$_REQUEST['name_2']."$/i")))))->count();
	
		$ContuserDetails = $collection->find(array('$or' => array(array("first_name" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("last_name" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("fax" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("email" => new MongoRegex("/".$_REQUEST['name_2']."/i")))))->sort(array("created_date" => -1));
		
		$ContuserDetailscnt = $collection->find(array('$or' => array(array("first_name" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("last_name" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("fax" => new MongoRegex("/".$_REQUEST['name_2']."/i")),array("email" => new MongoRegex("/".$_REQUEST['name_2']."/i")))))->count();
	//}

		if($ContuserDetailscnt > 0)
		{?>	
           <?php	 
            $srch = 1;
			foreach ($ContuserDetails as $search_faxs){ 	
				$Srchallfaxs = $collection_fax->find(array('from_id'=>$search_faxs['_id'],'to_id' => "$sessId",'is_delete'=> 0))->sort(array("created_date" => -1));
				$Cntallfaxs1 = $collection_fax->find(array('from_id'=>$search_faxs['_id'],'to_id' => "$sessId",'is_delete'=> 0))->sort(array("created_date" => -1))->count();
				if($Cntallfaxs1 > 0)
				{
					foreach($Srchallfaxs as $Srchall_faxs)
					{	
					// User Details										
					$userDetails = $collection->findOne(array('_id' => new MongoId($search_faxs['_id'])));											
					// Fetch Fax subject information from nf_fax;
					$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($Srchall_faxs['fax_id'])));						
					?> 
				<li <?php if($Srchall_faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $Srchall_faxs['_id'];?>')"<?php } ?>>
					<div class="md-card-list-item-menu margn" id="<?php echo $search_faxs['_id'];?>">                                    
						<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
						<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
						<a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>		
							<div class="dropdown">
								<div class="arrow-up"></div>
							    <ul>
							    	<?php 
							    	$collection_tag = $db->nf_company_tags; 
							    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
							    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
							    	if($Cntsalltags > 0)
							    	{
							    		foreach ($alltags as $all_tags) {?>
							    		<li>

							    			<?php if($search_faxs['fax_tag'] == $all_tags['_id']){?>
							    				<a title="tag" onClick="addingtags('<?php echo $search_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>			
							    				<span onClick="addingtags('<?php echo $search_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
							    					<i class="fa fa-times"></i>
							    				</span>
							    			<?php } else { ?>
							    				<a title="click to add this tag" onClick="addingtags('<?php echo $search_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>			
							    			<?php } ?>
							    		</li>
							    	<?php }
							    	} else {?>		
							    		<li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
							    	<?php } ?>
					            </ul>
				            </div>
						<!-- <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'inbox.php?action=delete&faxsId=<?php echo $search_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a> -->                                         
						<a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { inboxdelete('<?php echo $search_faxs['_id'];?>','searcht'); return false;}" title="delete"><i class="fa fa-trash"></i></a>
						<span id="favs_sec_<?php echo $search_faxs['_id'];?>">
							<?php if($Srchall_faxs['favorites'] == "N"){?>
								<a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id'];?>','Y')" title="favorites"><i class="fa fa-star"></i> </a>
							<?php } else { ?>
								<a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id']; ?>','N')" title="favorites"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
							<?php } ?> 
						</span>
					</div>
					
					<span class="md-card-list-item-date"><?php echo date('j M',strtotime($search_faxs['created_date'])); ?></span>
					<div class="md-card-list-item-select">
						<input type="checkbox" data-md-icheck />
					</div>
					<div class="md-card-list-item-avatar-wrapper" <?php //echo $divClk; ?>>
						<span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
					</div>
					<div class="md-card-list-item-sender" <?php //echo $divUsrNameClk; ?>>
						<span><?php echo $userDetails['fax']; //echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>      
					</div>
					<div class="md-card-list-item-subject" <?php //echo $divSujClk; ?>>
						<div class="md-card-list-item-sender-small">
							<span><?php echo $userDetails['fax']; //echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
						</div>
						<span><?php echo substr($userFaxDetails['message_subject'],0,30);?>
							<span id="favs_sec1_<?php echo $search_faxs['_id'];?>" style="float:right;">
								<?php if($Srchall_faxs['favorites'] == "N"){?>
									<!-- <a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a> -->
								<?php } else { ?>
									<a id="Fav_id" onClick="gFavorites('<?php echo $search_faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
								<?php } ?> 
							</span>
						</span>
					</div>		
					<div class="md-card-list-item-content-wrapper">
						<div class="md-card-list-item-content">
							<?php echo html_entity_decode($userFaxDetails['message_body']); echo "<br><br>";
							if($userFaxDetails['saved_pdf_file'] != "")
							{?>													
				    			<a href="#image_<?php echo $search_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
				    				<!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $search_faxs['file_name'];?>" id="img_atch" width="100" height="50"> 
				    				<img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">-->
				    				<div class="file">
                                        <div class="file-icon" data-type="filename.mp3">
                                          <img src= "assets/img/fax.png" alt="fax.image">
                                        </div>
                                        <p class="title">File name.pdf</p>
                                        
                                        <div class="download-btn">
                                          <p>File name.pdf</p>                                                  
                                          <img class="pdf" src="assets/img/pdf.png" alt="pdf">
                                        </div>
                                    </div>
				    			</a>		
				    			<div class="uk-modal" id="image_<?php echo $search_faxs['_id'];?>_popup">
				    				<div class="uk-modal-dialog" style="width:90%; height:90%;">		
				    					<button class="uk-modal-close uk-close" type="button"></button>
				    					<iframe src="upload_dir/savedpdfs/<?php echo $search_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
				    					<a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
				    				</div>
				    			</div>
				    			<!-- <a href="upload_dir/savedpdfs/<?php echo $search_faxs['saved_pdf_file'];?>">View the attachment</a> -->
							<?php } ?>		
						</div>

						<!-- Reply Messages Section start -->
							<?php 
							$collection_fax_reply = $db->nf_fax_replys; 
							$rfax_id = $Srchall_faxs['fax_id'];
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
									<?php echo html_entity_decode($reply_faxs['message_body']); ?>												
								</div>
								<br><br><br>
							<?php } ?> 												
						<!-- Reply Message Section End -->

						<form class="md-card-list-item-reply" name="replyform" method="post">	
							<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>		
							<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
							<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
							<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $search_faxs['fax_id']; ?>">
							<textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>			
							<input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
							<img src="assets/img/attach_file_48.png" height="25" width="23" style="margin-top:12px; margin-bottom:-10px;">
						</form>
					</div>
				</li>	
		  	  <?php }//user foreach

		  	  	} //user if condition End		  	  	
		  	  	$srch++; 
		  	} // foreach	?>                           	
        
	<?php 
	}
	else
	{
		$Cntallfaxs1 = "0";
	}
	// Search for userNames End


	// Search For Tag Names

		$collection_fax = $db->nf_fax_users; 
		$collection_fax_details = $db->nf_fax;
		$collection = $db->nf_user; 
		$collection_tag = $db->nf_company_tags; 
		$sessId = $_SESSION['user_id'];
		$grp_value = $_REQUEST['name_2'];

		$chktags = $collection_tag->find(array('tag_name' => new MongoRegex('/' .  $grp_value . '/i'),'user_id'=>$sessId))->count();
		$chktags_val = $collection_tag->findOne(array('tag_name' => new MongoRegex('/' .  $grp_value . '/i'),'user_id'=>$sessId));

		if($chktags > 0)
		{			
			// check tag into faxs
			$tag_ids = $chktags_val['_id'];
			$allfaxs = $collection_fax->find(array('to_id' => "$sessId",'fax_tag'=>"$tag_ids",'is_delete'=> 0))->sort(array("created_date" => -1));					
			$allTodayCnt = $collection_fax->find(array('to_id' => "$sessId",'fax_tag'=>"$tag_ids",'is_delete'=>0))->count();
			if($allTodayCnt > 0){?>

	           <?php 
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
						$userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($all_faxs['fax_id'])));	?>           

					<li <?php if($all_faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $all_faxs['_id'];?>')"<?php } ?>>
						<div class="md-card-list-item-menu margn" id="<?php echo $all_faxs['_id'];?>">                                    
							<!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
							<a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
							<a href="#" id="tagging" title="tags"><i class="fa fa-tags"></i></a>														
								<div class="dropdown">
									<div class="arrow-up"></div>
								    <ul>
								    	<?php 
								    	$collection_tag = $db->nf_company_tags; 
								    	$alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
								    	$Cntsalltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1))->count();
								    	if($Cntsalltags > 0)
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
								    	<?php } ?>
						            </ul>
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
										<?php echo html_entity_decode($reply_faxs['message_body']); ?>												
									</div>
									<br><br><br>
								<?php } ?> 												
							<!-- Reply Message Section End -->

							<form class="md-card-list-item-reply" name="replyform" method="post" enctype="multipart/form-data">	
								<label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>															
								<input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
								<input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">												
								<input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $all_faxs['fax_id']; ?>">
								<textarea class="md-input md-input-full xxs" name="reply_message" id="reply_message" cols="30" rows="4" required placeholder="Enter Your Message"></textarea>	
								 <!-- <div class="upload-file" style="display:none;">
								      <a href="#" class="title"></span> <span class="size"><span id="uploadFile"></span> </a>      
								      <span class="close"><span id="closeUpload">x</span></span>
								 </div> -->

								<div class="uploadFilesList"></div>
								 
								<label class="fileUpload">
								    <input id="uploadBtn" name="file[]" type="file" class="upload" multiple="multiple" />
								    <span class="uploadBtn"><img src="assets/img/attach_file_48.png" height="25" width="23" style="cursor:pointer;"></span>
								</label>

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
				<?php } //}// foreach	?>    

	        <?php } 
	    }
	    else
	    {
	    	$allTodayCnt = "0";
	    }?>

	<!-- Search For Tag Names End -->



	
	<?php if($searchfaxsCnt == "0" && $ContuserDetailscnt == "0" && $chktags =="0")
	{ ?>
    	<li>
    		<div class="md-card-list-item-subject">								
				<span>No Faxs Found for "<?php echo $_GET['name_2'];?>"</span>
			</div>
    	</li>            
	<?php } 
	else if($Cntallfaxs == "0" && $Cntallfaxs1 == "0" && $allTodayCnt == "0")
	{?>
		<li>
    		<div class="md-card-list-item-subject">		
				<span>No Faxs Found for "<?php echo $_GET['name_2'];?>".</span>
			</div>
    	</li>            
	<?php }?>
	</ul>
  </div>
</div>