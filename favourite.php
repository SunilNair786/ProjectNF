<?php include_once('includes/header.php'); ?>
<!-- main header end -->
<!-- main sidebar -->
<?php include_once('includes/sidemenu.php'); ?>
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
    header("location:favourite.php");
}

// Delete Favorite Faxs
if(isset($_GET['action']) && ($_GET['action'] == "delete") && isset($_GET['faxsId']) && ($_GET['faxsId']!="" ))
{   
    $faxObjCon->deleteFax($_GET['faxsId']);
    header("location:favourite.php");
}

?>

<style>
/*for autocomplete css*/
.ui-widget-content
{
    z-index: 9999 !important;
}
.dropdown{
    min-width: 150px;     
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
</style>
<div id="page_content">
        <div id="page_content_inner">

            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-8-10 uk-container-center">                    
                    <?php 
                        $startDate = date('Y-m-d');                        

                        $collection_fax = $db->nf_fax_users; 
                        $collection_fax_details = $db->nf_fax;
                        $collection = $db->nf_user;           
                        $sessId = $_SESSION['user_id'];

                        $allfaxCount = $collection_fax->find(array("favorites" => "Y",'to_id' => "$sessId",'created_date' => array('$gt' => "$startDate"),'is_delete'=> 0))->count();   //'created_date' => array('$gt' => "$startDate"),  
                        $favFaxs = $collection_fax->find(array("favorites" => "Y",'to_id' => "$sessId",'created_date' => array('$gt' => "$startDate"),'is_delete'=> 0))->sort(array("created_date" => -1)); 

                        if($allfaxCount > 0){?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Today</div>
                        <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
                        <ul class="hierarchical_slide">                            
                            <?php   foreach ($favFaxs as $fav_Faxs) {        
                                    // User Details                                    
                                    $indUserDetails = $collection->findOne(array('_id' => new MongoId($fav_Faxs['from_id'])));
                                    // Fetch Data From fax
                                    $userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($fav_Faxs['fax_id'])));
                                ?>
                                <li>
                                    <div class="md-card-list-item-menu margn">
                                        <!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
                                        <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
                                        <!-- <a href="#" id="tagging"><i class="fa fa-tags"></i></a>                                                     
                                            <div class="dropdown">
                                                <div class="arrow-up"></div>
                                                <ul>
                                                    <?php 
                                                    $collection_tag = $db->nf_company_tags; 
                                                    $alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
                                                    foreach ($alltags as $all_tags) {?>
                                                        <li>                                                        
                                                        <?php if($fav_Faxs['fax_tag'] == $all_tags['_id']){?>
                                                            <a onClick="addingtags('<?php echo $fav_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>            
                                                            <span onClick="addingtags('<?php echo $fav_Faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a onClick="addingtags('<?php echo $fav_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>            
                                                        <?php } ?>
                                                        </li>
                                                    <?php }?>                                                       
                                                </ul>
                                            </div> -->
                                        <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'favorite.php?action=delete&faxsId=<?php echo $fav_Faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>                                         
                                        <!-- <span id="favs_sec_<?php echo $fav_Faxs['_id'];?>">
                                            <?php if($fav_Faxs['favorites'] == "N"){?>
                                                <a id="Fav_id" onClick="gFavorites('<?php echo $fav_Faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a>
                                            <?php } else { ?>
                                                <a id="Fav_id" onClick="gFavorites('<?php echo $fav_Faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
                                            <?php } ?> 
                                        </span> -->
                                    </div>
                                    <span class="md-card-list-item-date"><?php echo date('j M',strtotime($fav_Faxs['created_date'])); ?></span>
                                    <div class="md-card-list-item-select">
                                        <input type="checkbox" data-md-icheck />
                                    </div>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <span class="md-card-list-item-avatar md-bg-grey"><?php echo $indUserDetails['first_name'][0]."".$indUserDetails['last_name'][0];?></span>
                                    </div>
                                    <div class="md-card-list-item-sender">
                                        <span><?php echo ucfirst($indUserDetails['first_name'])." ".ucfirst($indUserDetails['last_name']);?></span>
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <div class="md-card-list-item-sender-small">
                                            <span><?php echo $indUserDetails['first_name'][0]."".$indUserDetails['last_name'][0];?></span>
                                        </div>                
                                        <span><?php echo substr($userFaxDetails['message_subject'],0,30);?></span>                        
                                    </div>
                                    <div class="md-card-list-item-content-wrapper">
                                        <div class="md-card-list-item-content">
                                            <?php echo $userFaxDetails['message_body']; echo "<br><br>";
                                            if($userFaxDetails['saved_pdf_file'] != "")
                                                {?>                                                 
                                                <a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                    <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> -->
                                                    <img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">
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
                                                </div>
                                                <?php $rplyUserDetails1 = $collection->findOne(array('_id' => new MongoId($reply1_faxs['from_id'])));   ?>
                                                <div class="md-card-list-item-avatar-wrapper">
                                                    <span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails1['first_name'][0].''.$rplyUserDetails1['last_name'][0]; ?></span>
                                                </div>
                                                <div class="md-card-list-item-sender">
                                                    <span><?php echo ucfirst($rplyUserDetails1['first_name']).' '.ucfirst($rplyUserDetails1['last_name']); ?></span>                                    
                                                </div>                                                                                                  
                                                <div class="md-card-list-item-content">
                                                    <?php echo html_entity_decode($reply1_faxs['message_body']); ?>                                             
                                                </div>
                                                <br><br><br>
                                            <?php } ?>                                              
                                        <!-- Reply Message Section End -->                                        
                                        <form class="md-card-list-item-reply" name="replyform" method="post">   
                                            <label for="mailbox_reply_1895">Reply to <span><?php echo $indUserDetails['email_id']; ?></span></label>       
                                            <input type="hidden" name="to_id" id="to_id" value="<?php echo $indUserDetails['_id'];?>">
                                            <input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">                                                
                                            <input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $yesterd_faxs['fax_id']; ?>">
                                            <textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>            
                                            <input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
                                        </form>  
                                    </div>
                                </li>
                                <?php } ?>                            
                        </ul>
                    </div>
                    <?php } ?>

    <!-- Yesterday Favorite Faxs -->

                <?php
                    $startDate = date('Y-m-d 00:00:00',strtotime("-1 days"));
                    $endDate = date('Y-m-d 23:59:59',strtotime("-1 days"));
                    
                    $yesterdfaxs = $collection_fax->find(array("favorites" => "Y",'to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),'is_delete'=>0))->sort(array("created_date" => -1));   
                    $allWeekCnt = $collection_fax->find(array("favorites" => "Y",'to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),"is_delete"=>0))->count(); 
                    if($allWeekCnt > 0 ){   
                ?>  

                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Yesterday</div>
                        <ul class="hierarchical_slide">
                            <?php                                               
                            foreach ($yesterdfaxs as $yesterd_faxs) {                                                   
                            // User Details                                    
                                $userDetails = $collection->findOne(array('_id' => new MongoId($yesterd_faxs['from_id'])));                                                 
                                // Fetch Fax subject information from nf_fax;                                
                                $userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($yesterd_faxs['fax_id'])));        
                            ?>
                            <li <?php if($yesterd_faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $yesterd_faxs['_id'];?>')"<?php } ?>>
                                <div class="md-card-list-item-menu margn">
                                    
                                    <!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>                                                            
                                    <!-- <a href="#" id="tagging"><i class="fa fa-tags"></i></a>                                                     
                                        <div class="dropdown">
                                            <div class="arrow-up"></div>
                                            <ul>
                                                <?php 
                                                $collection_tag = $db->nf_company_tags; 
                                                $alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
                                                foreach ($alltags as $all_tags) {?>
                                                <li>
                                                    <?php if($yesterd_faxs['fax_tag'] == $all_tags['_id']){?>
                                                        <a onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>
                                                        <span onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    <?php } else { ?>
                                                        <a onClick="addingtags('<?php echo $yesterd_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>            
                                                    <?php } ?>
                                                </li>
                                                <?php }?>                                                       
                                            </ul>
                                        </div> -->
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'favourite.php?action=delete&faxsId=<?php echo $yesterd_faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>   
                                    <!-- <span id="favs_sec_<?php echo $yesterd_faxs['_id'];?>">
                                        <?php if($yesterd_faxs['favorites'] == "N"){?>
                                            <a id="Fav_id" onClick="gFavorites('<?php echo $yesterd_faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a>
                                        <?php } else { ?>
                                            <a id="Fav_id" onClick="gFavorites('<?php echo $yesterd_faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
                                        <?php } ?> 
                                    </span>  -->                                                    
                                </div>
                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($yesterd_faxs['created_date'])); ?></span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                </div>
                                <div class="md-card-list-item-sender">
                                <span><?php echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>  
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                    </div>
                                    <span>
                                        <?php echo substr($userFaxDetails['message_subject'],'0','20'); ?>                                        
                                    </span>                                                         
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        <?php echo $userFaxDetails['message_body']; echo "<br><br>";
                                        if($userFaxDetails['saved_pdf_file'] != "")
                                            {?>                                                 
                                            <a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> -->
                                                <img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">
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
                                        $rfax_id1 = $yesterd_faxs['fax_id'];
                                        $replyfaxs1 = $collection_fax_reply->find(array('fax_id' => "$rfax_id1"))->sort(array("created_date" => -1));

                                        foreach ($replyfaxs1 as $reply1_faxs) {                                                 
                                        ?>
                                            <span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply1_faxs['created_date'])); ?></span>
                                            <div class="md-card-list-item-select">
                                                <!-- <input type="checkbox" data-md-icheck /> -->
                                            </div>
                                            <?php $rplyUserDetails1 = $collection->findOne(array('_id' => new MongoId($reply1_faxs['from_id'])));   ?>
                                            <div class="md-card-list-item-avatar-wrapper">
                                                <span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails1['first_name'][0].''.$rplyUserDetails1['last_name'][0]; ?></span>
                                            </div>
                                            <div class="md-card-list-item-sender">
                                                <span><?php echo ucfirst($rplyUserDetails1['first_name']).' '.ucfirst($rplyUserDetails1['last_name']); ?></span>                                    
                                            </div>                                                                                                  
                                            <div class="md-card-list-item-content">
                                                <?php echo html_entity_decode($reply1_faxs['message_body']); ?>                                             
                                            </div>
                                            <br><br><br>
                                        <?php } ?>                                              
                                    <!-- Reply Message Section End -->

                                    <form class="md-card-list-item-reply" name="replyform" method="post">   
                                        <label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>       
                                        <input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
                                        <input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">                                                
                                        <input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $yesterd_faxs['fax_id']; ?>">
                                        <textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>            
                                        <input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
                                    </form>                                                     

                                </div>
                            </li>
                                <?php   } // foreach ?>
                                    
                        </ul>
                        </div>
                <?php } // if loop $allfaxsWeekCnt ?>


    <!-- Monthly Faxes -->

                <?php 
                    $startDate = date('Y-m-d 00:00:00',strtotime("-30 days"));
                    $endDate = date('Y-m-d 23:59:59',strtotime("-2 days"));
                        
                    $amonthFaxs = $collection_fax->find(array('favorites' => "Y",'to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),'is_delete'=>0))->sort(array("created_date" => -1));   
                    $allMonthCnt = $collection_fax->find(array('favorites' => "Y",'to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),"is_delete"=>0))->count();  
                    if($allMonthCnt > 0 ){
                ?>

                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">This Month</div>
                        <ul class="hierarchical_slide">
                        <?php                               
                            foreach ($amonthFaxs as $amonth_Faxs) {                                                 
                                // User Details                                     
                                $userDetails = $collection->findOne(array('_id' => new MongoId($amonth_Faxs['from_id'])));                                  
                                // Fetch Fax subject information from nf_fax;
                                $userFaxDetails = $collection_fax_details->findOne(array('_id' =>new MongoId($amonth_Faxs['fax_id'])));                                                         
                        ?>
                            <li <?php if($amonth_Faxs['is_read'] == "0"){?>onClick="seenAjax('<?php echo $amonth_Faxs['_id'];?>')"<?php } ?>>
                                <div class="md-card-list-item-menu margn">
                                    
                                    <!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
                                    <!-- <a href="#" id="tagging"><i class="fa fa-tags"></i></a>                                                     
                                        <div class="dropdown">
                                            <div class="arrow-up"></div>
                                            <ul>
                                                <?php 
                                                $collection_tag = $db->nf_company_tags; 
                                                $alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
                                                foreach ($alltags as $all_tags) {?>
                                                    <li>
                                                        <?php if($amonth_Faxs['fax_tag'] == $all_tags['_id']){?>
                                                            <a onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>    
                                                            <span onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a onClick="addingtags('<?php echo $amonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>         
                                                        <?php } ?>
                                                    </li>
                                                <?php }?>                                                       
                                            </ul>
                                        </div> -->
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'favourite.php?action=delete&faxsId=<?php echo $amonth_Faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>
                                    <!-- <span id="favs_sec_<?php echo $amonth_Faxs['_id'];?>">
                                        <?php if($amonth_Faxs['favorites'] == "N"){?>
                                            <a id="Fav_id" onClick="gFavorites('<?php echo $amonth_Faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a>
                                        <?php } else { ?>
                                            <a id="Fav_id" onClick="gFavorites('<?php echo $amonth_Faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary" style="color:#94940C"></i> </a>
                                        <?php } ?> 
                                    </span> -->
                                </div>
                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($amonth_Faxs['created_date'])); ?></span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                    <span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                </div>
                                <div class="md-card-list-item-sender">
                                    <span><?php echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>  
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                    </div>
                                    <span><?php echo substr($userFaxDetails['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        <?php echo $userFaxDetails['message_body']; echo "<br><br>";
                                        if($userFaxDetails['saved_pdf_file'] != "")
                                            {?>                                                 
                                            <a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> -->
                                                <img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">
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
                                        $replyfaxs2 = $collection_fax_reply->find(array('fax_id' => "$rfax_id2"))->sort(array("created_date" => -1));

                                        foreach ($replyfaxs2 as $reply2_faxs) {                                                 
                                        ?>
                                            <span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply2_faxs['created_date'])); ?></span>
                                            <div class="md-card-list-item-select">
                                                <!-- <input type="checkbox" data-md-icheck /> -->
                                            </div>
                                            <?php $rplyUserDetails2 = $collection->findOne(array('_id' => new MongoId($reply2_faxs['from_id'])));   ?>
                                            <div class="md-card-list-item-avatar-wrapper">
                                                <span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails2['first_name'][0].''.$rplyUserDetails2['last_name'][0]; ?></span>
                                            </div>
                                            <div class="md-card-list-item-sender">
                                                <span><?php echo ucfirst($rplyUserDetails2['first_name']).' '.ucfirst($rplyUserDetails2['last_name']); ?></span>                                    
                                            </div>                                                                                                  
                                            <div class="md-card-list-item-content">
                                                <?php echo html_entity_decode($reply2_faxs['message_body']); ?>                                             
                                            </div>
                                            <br><br><br>
                                        <?php } ?>                                              
                                    <!-- Reply Message Section End -->

                                    <form class="md-card-list-item-reply" name="replyform" method="post">   
                                        <label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>       
                                        <input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
                                        <input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">                                                
                                        <input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $amonth_Faxs['fax_id']; ?>">
                                        <textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>            
                                        <input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
                                    </form> 

                                </div>
                            </li>
                        <?php } ?>
                            
                        </ul>
                    </div>
                <?php } ?>


    <!-- Older messages -->
                <?php 
                        $startDate = date('Y-m-d 00:00:00',strtotime("-100 years"));
                        $endDate = date('Y-m-d 23:59:59',strtotime("-30 days"));
                            
                        $OldmonthFaxs = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),'is_delete'=>0))->sort(array("created_date" => -1));   
                        $allCnt = $collection_fax->find(array('to_id' => "$sessId","created_date" => array('$gt' => $startDate,'$lte' => $endDate),"is_delete"=>0))->count();   
                        
                        if($allCnt > 0 ){
                    ?>
                        <div class="md-card-list">
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
                                    <div class="md-card-list-item-menu margn">
                                        
                                        <!-- <a href="#"><i class="fa fa-reply-all"></i> </a> -->
                                        <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $userFaxDetails['message_subject'];?>','<?php echo $userFaxDetails['message_body'];?>')" title="forward"><i class="fa fa-long-arrow-right"></i></a>
                                        <!-- <a href="#" id="tagging"><i class="fa fa-tags"></i></a>                                                     
                                            <div class="dropdown">
                                                <div class="arrow-up"></div>
                                                <ul>
                                                    <?php 
                                                    $collection_tag = $db->nf_company_tags; 
                                                    $alltags = $collection_tag->find(array("user_id" => $_SESSION['user_id']))->sort(array("created_date" => -1));
                                                    foreach ($alltags as $all_tags) {?>
                                                    <li>
                                                    <?php if($Oldmonth_Faxs['fax_tag'] == $all_tags['_id']){    ?>
                                                        <a onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>
                                                        <span onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    <?php } else { ?>
                                                        <a onClick="addingtags('<?php echo $Oldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>           
                                                    <?php } ?>
                                                    </li>
                                                    <?php }?>                                                       
                                                </ul>
                                            </div> -->
                                        <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location = 'favourite.php?action=delete&faxsId=<?php echo $Oldmonth_Faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>
                                        <!-- <span id="favs_sec_<?php echo $Oldmonth_Faxs['_id'];?>">
                                            <?php if($Oldmonth_Faxs['favorites'] == "N"){?>
                                                <a id="Fav_id" onClick="gFavorites('<?php echo $Oldmonth_Faxs['_id'];?>','Y')"><i class="fa fa-star"></i> </a>
                                            <?php } else { ?>
                                                <a id="Fav_id" onClick="gFavorites('<?php echo $Oldmonth_Faxs['_id']; ?>','N')"><i class="fa fa-star md-btn-flat-primary"></i> </a>
                                            <?php } ?> 
                                        </span> -->
                                    </div>
                                    <span class="md-card-list-item-date"><?php echo date('j M',strtotime($Oldmonth_Faxs['created_date'])); ?></span>
                                    <div class="md-card-list-item-select">
                                        <input type="checkbox" data-md-icheck />
                                    </div>
                                    <div class="md-card-list-item-avatar-wrapper">
                                        <span class="md-card-list-item-avatar md-bg-grey"><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                    </div>
                                    <div class="md-card-list-item-sender">
                                        <span><?php echo ucfirst($userDetails['first_name']).' '.ucfirst($userDetails['last_name']); ?></span>  
                                    </div>
                                    <div class="md-card-list-item-subject">
                                        <div class="md-card-list-item-sender-small">
                                            <span><?php echo $userDetails['first_name'][0].''.$userDetails['last_name'][0]; ?></span>
                                        </div>
                                        <span><?php echo substr($userFaxDetails['message_subject'],'0','20'); ?></span>
                                    </div>
                                    <div class="md-card-list-item-content-wrapper">
                                        <div class="md-card-list-item-content">
                                            <?php echo $userFaxDetails['message_body']; echo "<br><br>";
                                            if($userFaxDetails['saved_pdf_file'] != "")
                                                {?>                                                 
                                                <a href="#image_<?php echo $userFaxDetails['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                    <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $userFaxDetails['file_name'];?>" id="img_atch" width="100" height="50"> -->
                                                    <img title="click to view attachment" src="assets/img/attachmentpin.png" id="img_atch" width="50" height="25">
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
                                            $rfax_id3 = $Oldmonth_Faxs['fax_id'];
                                            $replyfaxs3 = $collection_fax_reply->find(array('fax_id' => "$rfax_id3"))->sort(array("created_date" => -1));

                                            foreach ($replyfaxs3 as $reply3_faxs) {                                                 
                                            ?>
                                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($reply3_faxs['created_date'])); ?></span>
                                                <div class="md-card-list-item-select">
                                                    <!-- <input type="checkbox" data-md-icheck /> -->
                                                </div>
                                                <?php $rplyUserDetails3 = $collection->findOne(array('_id' => new MongoId($reply3_faxs['from_id'])));   ?>
                                                <div class="md-card-list-item-avatar-wrapper">
                                                    <span class="md-card-list-item-avatar md-bg-grey"><?php echo $rplyUserDetails3['first_name'][0].''.$rplyUserDetails3['last_name'][0]; ?></span>
                                                </div>
                                                <div class="md-card-list-item-sender">
                                                    <span><?php echo ucfirst($rplyUserDetails3['first_name']).' '.ucfirst($rplyUserDetails3['last_name']); ?></span>                                    
                                                </div>                                                                                                  
                                                <div class="md-card-list-item-content">
                                                    <?php echo html_entity_decode($reply3_faxs['message_body']); ?>                                             
                                                </div>
                                                <br><br><br>
                                            <?php } ?>                                              
                                        <!-- Reply Message Section End -->

                                        <form class="md-card-list-item-reply" name="replyform" method="post">   
                                            <label for="mailbox_reply_1895">Reply to <span><?php echo $userDetails['email_id']; ?></span></label>       
                                            <input type="hidden" name="to_id" id="to_id" value="<?php echo $userDetails['_id'];?>">
                                            <input type="hidden" name="from_id" id="from_id" value="<?php echo $_SESSION['user_id'];?>">                                                
                                            <input type="hidden" name="reply_fax_id" id="reply_fax_id" value="<?php echo $Oldmonth_Faxs['fax_id']; ?>">
                                            <textarea class="md-input md-input-full" name="reply_message" id="reply_message" cols="30" rows="4" required></textarea>            
                                            <input type="submit" name="submit_reply" id="submit_reply" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" value="reply">
                                        </form> 
                                    </div>
                                </li>
                                <?php   } //} // foreach ?>

                                            
                            </ul>
                        </div>
                <?php   }   // if loop $allCnt ?>

                </div>
            </div>

        </div>
    </div>

    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE150;</i>
        </a>
    </div>

    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
            <form name='composeFrm' id="composeFrm" action='favorite.php' enctype="multipart/form-data" method='post'>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="mail_new_to">To</label>
                    <input type="text" class="md-input" name="mail_new_to" id="mail_new_to" required>                    
                    
                    <input type="hidden" name="hidd_labels" id="labels">
                    
                    <input type="hidden" name="hidd_values" id="values">    

                </div>
                
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Subject</label>
                    <input name="message_subject" id="message_subject" class="md-input" required />
                </div>
                
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Message</label>
                    <textarea name="message_body" id="message_body" cols="30" rows="6" class="md-input"></textarea>
                </div>
                <div id="mail_upload-drop" class="uk-file-upload">
                    <input id="Button1" type="button" value="Add File" onclick = "AddFileUpload()" class="uk-form-file md-btn" />
                    <div id = "FileUploadContainer">
                            <!--FileUpload Controls will be added here -->

                    </div>
                    <!--p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <a class="uk-form-file md-btn">choose file<input id="mail_upload-select" type="file"></a-->
                </div>
                <div id="mail_progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
                <div class="uk-modal-footer">
                    <!--a href="#" class="md-icon-btn"><i class="md-icon material-icons">&#xE226;</i></a!-->
                    <input type='submit' value='send' class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" name='submit'  />
                    <!--button type="button" >Send</button-->
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

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->

    <!--  mailbox functions -->
    <script src="assets/js/pages/page_mailbox.min.js"></script>
    
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

        // Adding And Removing Favorites
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
                        // $('#favs_sec_'+faxId).load(location.href + " #favs_sec_"+faxId);
                        // $('#favs_sec1_'+faxId).load(location.href + " #favs_sec1_"+faxId);
                        window.location.reload();
                    }                    
                }
            });        
        }

        var counterInt = 0;

        function AddFileUpload(){ 
               if(counterInt < 10){
                    var div = document.createElement('DIV');
                    div.innerHTML = '<i class="md-icon material-icons">&#xE226;</i>&nbsp;<input  id="file' + counterInt + '" name = "file[' + counterInt +
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
                window.location.reload();
            }
        }
    </script>
<style>
.color{background:#9c45ae !important;}
</style>
</body>
</html>