<?php include_once('includes/header.php'); ?>
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
    header("location:outbox.php");
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
                    $startDate = date('Y-m-d 00:00:00');                            
                    //$endDate = date('Y-m-d H:i:s');
                    $collection = $db->nf_fax_users;
                    $collection_fax = $db->nf_fax;  
                    $collection_user = $db->nf_user;    
                    $sessId = $_SESSION['user_id'];
                    $CntallOutfaxs = $collection_fax->find(array("from_id" => $sessId,"created_date" => array('$gt' => $startDate),"status" => "A"))->count();   
                    $allOutfaxs = $collection_fax->find(array("from_id" => $sessId,"created_date" => array('$gt' => $startDate),"status" => "A"));   

                    if($CntallOutfaxs > 0){
                    ?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Today</div>
                        <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>
                        <ul class="hierarchical_slide">
                            <?php                            
                            foreach ($allOutfaxs as $allOut_faxs) {  	
                                // getting User and Contact Details
                                $udetailemail = '';
                                $udetail = '';
                                $uIds = '';
                                $faxInfo = $collection->find(array('fax_id' => $allOut_faxs['_id']));                                    
                                foreach ($faxInfo as $fax_Info) {               
                                    $CoutUserDetail = $collection_user->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();
                                    $outUserDetail = $collection_user->findOne(array('_id' => new MongoId($fax_Info['to_id'])));     
                                    // In Contacts
                                    $UserDetailCount = $db->nf_user_contacts->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();          
                                    $contUserDetail = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax_Info['to_id'])));          
                                    if($CoutUserDetail > 0)  
                                    {
                                        $udetailemail .= $outUserDetail['first_name']." ".$outUserDetail['last_name']." (".$outUserDetail['email_id']."), ";
                                        $udetail .= $outUserDetail['first_name']." ".$outUserDetail['last_name'].",";
                                        $uIds .= $outUserDetail['_id'].",";
                                    }
                                    else if($UserDetailCount > 0)
                                    {   
                                        $udetailemail .= $contUserDetail['contact_name']." (".$contUserDetail['email']."), ";
                                        $udetail .= $contUserDetail['contact_name'].",";
                                        $uIds .= $contUserDetail['_id'].",";
                                    }
                                }
                            ?>    
                            <li>                                
                                <div class="md-card-list-item-menu margn">                                                                        
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail,0,-2);?>','<?php echo substr($uIds,0,-1);?>','<?php echo $allOut_faxs['message_subject'];?>','<?php echo $allOut_faxs['message_body'];?>')"><i class="fa fa-paper-plane"></i></a>                                    
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $allOut_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a>                                                                             
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
                                        echo substr($udetail, 0, -1); 
                                        //echo $uIds;                                    
                                        ?>                                        
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>
                                            <?php                                                                                      
                                            echo substr($udetail, 0, -1); 
                                            //echo $uIds;
                                            ?>
                                        </span>
                                    </div>
                                    <span><?php echo substr($allOut_faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content"><?php echo $allOut_faxs['message_body'];?></div>                                    
                                </div>
                            </li>

                            <?php } ?>
                        </ul>
                    </div>
					<?php } ?>


    <!-- Outbox Yesterday Messages -->
                    <?php
                    $startDate1 = date('Y-m-d 00:00:00',strtotime("-1 days"));
                    $endDate1 = date('Y-m-d 23:59:59',strtotime("-1 days"));
                    //$collection = $db->nf_fax_users; 
                    $CntyesterdOutfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $startDate1,'$lte' => $endDate1),"status" => "A"))->count();   
                    $yesterdOutfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $startDate1,'$lte' => $endDate1),"status" => "A"));   
                    if($CntyesterdOutfaxs > 0)
                    {
                    ?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Yesterday</div>
                        <ul class="hierarchical_slide">
                            <?php                            
                            foreach ($yesterdOutfaxs as $yesterdOut_faxs) {                                        
                                    // getting User and Contact Details
                                    $udetailemail1 = '';
                                    $udetail1 = '';
                                    $uIds1 = '';
                                    $faxInfo1 = $collection->find(array('fax_id' => $yesterdOut_faxs['_id']));  
                                    foreach ($faxInfo1 as $fax1_Info) {               
                                        $CoutUserDetail1 = $collection_user->find(array('_id' => new MongoId($fax1_Info['to_id'])))->count();
                                        $outUserDetail1 = $collection_user->findOne(array('_id' => new MongoId($fax1_Info['to_id'])));     
                                        // In Contacts
                                        $UserDetailCount1 = $db->nf_user_contacts->find(array('_id' => new MongoId($fax1_Info['to_id'])))->count();
                                        $contUserDetail1 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax1_Info['to_id'])));
                                        if($CoutUserDetail1 > 0)  
                                        {
                                            //$udetail1 .= $outUserDetail1['first_name'].$outUserDetail1['last_name'].",";
                                            $udetailemail1 .= $outUserDetail1['first_name']." ".$outUserDetail1['last_name']." (".$outUserDetail1['email_id']."), ";
                                            $udetail1 .= $outUserDetail1['first_name']." ".$outUserDetail1['last_name'].",";
                                            $uIds1 .= $outUserDetail1['_id'].",";
                                        }
                                        else if($UserDetailCount1 > 0)
                                        {
                                            $udetailemail1 .= $contUserDetail1['contact_name']." (".$contUserDetail1['email']."), ";
                                            $udetail1 .= $contUserDetail1['contact_name'].",";
                                            $uIds1 .= $contUserDetail1['_id'].",";
                                        }
                                    }
                            ?>
                            <li>                                
                                <div class="md-card-list-item-menu margn">                                                                        
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail1,0,-2);?>','<?php echo substr($uIds1,0,-1);?>','<?php echo $yesterdOut_faxs['message_subject'];?>','<?php echo $yesterdOut_faxs['message_body'];?>')"><i class="fa fa-paper-plane"></i></a>                                    
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $yesterdOut_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a>                                                                             
                                </div>
                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($yesterdOut_faxs['created_date'])); ?></span>
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
                                        echo substr($udetail1, 0, -1); 
                                        ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>
                                            <?php                                                                                      
                                            echo substr($udetail1, 0, -1); 
                                            ?>
                                        </span>
                                    </div>
                                    <span><?php echo substr($yesterdOut_faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content"><?php echo $yesterdOut_faxs['message_body'];?></div>                                    
                                </div>
                            </li>
                            <?php  
                            } ?>
                        </ul>
                    </div>
                    <?php } ?>

    <!-- Outbox Month Faxs -->
                    <?php
                    $M_startDate = date('Y-m-d 00:00:00',strtotime("-30 days"));
                    $M_endDate = date('Y-m-d 23:59:59',strtotime("-2 days"));
                    
                    $CntlastMnthfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $M_startDate,'$lte' => $M_endDate)))->count();   
                    $lastMnthfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $M_startDate,'$lte' => $M_endDate)));   
                    if($CntlastMnthfaxs > 0)
                    {
                    ?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">This Month</div>
                        <ul class="hierarchical_slide">
                            <?php
                            foreach ($lastMnthfaxs as $lastMnth_faxs) {    
                                $faxInfo2 = $collection->find(array('fax_id' => $lastMnth_faxs['_id']));          
                            ?>
                            <li>                                
                                <div class="md-card-list-item-menu margn">                                                                        
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $lastMnth_faxs['message_subject'];?>','<?php echo $lastMnth_faxs['message_body'];?>')"><i class="fa fa-paper-plane"></i></a>                                    
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $lastMnth_faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a>                                                                             
                                </div>
                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($lastMnth_faxs['created_date'])); ?></span>
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
                                        foreach ($faxInfo2 as $fax2_Info) {               
                                            $CoutUserDetail2 = $collection_user->find(array('_id' => new MongoId($fax2_Info['to_id'])))->count();
                                            $outUserDetail2 = $collection_user->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));     
                                            if($CoutUserDetail2 > 0)  
                                            {
                                                echo $outUserDetail2['first_name'].$outUserDetail2['last_name'].",";
                                            }
                                            else
                                            {                                                    
                                                $contUserDetail2 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));          
                                                echo $contUserDetail2['contact_name'].",";
                                            }
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span><?php                                              
                                        foreach ($faxInfo as $fax2_Info) {               
                                            $CoutUserDetail2 = $collection_user->find(array('_id' => new MongoId($fax2_Info['to_id'])))->count();
                                            $outUserDetail2 = $collection_user->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));     
                                            if($CoutUserDetail2 > 0)  
                                            {
                                                echo $outUserDetail2['first_name'].$outUserDetail2['last_name'].",";
                                            }
                                            else
                                            {                                                    
                                                $contUserDetail2 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));          
                                                echo $contUserDetail2['contact_name'].",";
                                            }
                                        }
                                        ?></span>
                                    </div>
                                    <span><?php echo substr($lastMnth_faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content"><?php echo $lastMnth_faxs['message_body'];?></div>                                    
                                </div>
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                    <?php } ?>



    <!-- Older messages -->

                    <?php
                    $OldstartDate = date('Y-m-d 00:00:00',strtotime("-100 years"));
                    $OldendDate = date('Y-m-d 23:59:59',strtotime("-30 days"));
                    
                    $CntOldmonthFaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $OldstartDate,'$lte' => $OldendDate)))->count();   
                    $OldmonthFaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $OldstartDate,'$lte' => $OldendDate)));   
                    if($CntOldmonthFaxs > 0)
                    {
                    ?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Older Messages</div>
                        <ul class="hierarchical_slide">
                            <?php
                            foreach ($OldmonthFaxs as $CntOldmonth_Faxs) {    
                                $faxInfo3 = $collection->find(array('fax_id' => $CntOldmonth_Faxs['_id']));          
                            ?>
                            <li>                                
                                <div class="md-card-list-item-menu margn">                                                                        
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo $CntOldmonth_Faxs['message_subject'];?>','<?php echo $CntOldmonth_Faxs['message_body'];?>')"><i class="fa fa-paper-plane"></i></a>                                    
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $CntOldmonth_Faxs['_id'];?>'; return false;}"><i class="fa fa-trash"></i></a>                                                                             
                                </div>
                                <span class="md-card-list-item-date"><?php echo date('j M',strtotime($CntOldmonth_Faxs['created_date'])); ?></span>
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
                                        foreach ($faxInfo3 as $fax3_Info) {    
                                            $CoutUserDetail3 = $collection_user->find(array('_id' => new MongoId($fax3_Info['to_id'])))->count();
                                            $outUserDetail3 = $collection_user->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));     
                                            if($CoutUserDetail3 > 0)  
                                            {
                                                echo $outUserDetail3['first_name'].$outUserDetail3['last_name'].",";
                                            }
                                            else
                                            {                                                    
                                                $contUserDetail3 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));          
                                                echo $contUserDetail3['contact_name'].",";
                                            }
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span><?php                                              
                                        foreach ($faxInfo3 as $fax3_Info) {               
                                            $CoutUserDetail3 = $collection_user->find(array('_id' => new MongoId($fax3_Info['to_id'])))->count();
                                            $outUserDetail3 = $collection_user->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));     
                                            if($CoutUserDetail3 > 0)  
                                            {
                                                echo $outUserDetail3['first_name'].$outUserDetail3['last_name'].",";
                                            }
                                            else
                                            {                                                    
                                                $contUserDetail3 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));          
                                                echo $contUserDetail3['contact_name'].",";
                                            }
                                        }
                                        ?></span>
                                    </div>
                                    <span><?php echo substr($CntOldmonth_Faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content"><?php echo $CntOldmonth_Faxs['message_body'];?></div>                                    
                                </div>
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                    <?php } ?>


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
            <form name='composeFrm' id="composeFrm" action='outbox.php' enctype="multipart/form-data" method='post'>
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

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
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


        // Auto Complete for compose message                
        // $( document ).ready(function() {
        //  $("#mail_new_to").keyup(function() {
        //      var keyword = $("#mail_new_to").val();
        //      if(keyword != ''){
        //          $.get( "auto_complete.php", { keyword: keyword } )
        //           .done(function( data ) {
        //              alert(data);
        //            });
        //      }
        //  });
        // });
        
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
    

        // check / Uncheck Favorites
        function gFavorites(FID,Fval)
        {
            $.ajax({
                url:"auto_complete.php",
                type:"GET",
                data: {"fax_id": FID,"fav_val":Fval},
                success:function(html){    
                    if(Fval == 'Y')      
                    {
                        alert('Successfully added to favorites'); 
                        $('#favs_sec_'+FID).load(location.href + " #favs_sec_"+FID);
                    }
                    else
                    {
                        alert('Successfully removed from favorites');      
                        $('#favs_sec_'+FID).load(location.href + " #favs_sec_"+FID);
                    }                    
                }
            });        
        }

        // Forwarded Message
        function fwdmsg(fax_to,fax_ids,fax_subj,fax_body)
        {
            document.getElementById('values').value=fax_ids;
            document.getElementById('labels').value=fax_to;                  
            document.getElementById('mail_new_to').value=fax_to+',';
            document.getElementById('message_subject').value = fax_subj;            
            document.getElementById('message_body').value = fax_body;
            //$('#message_body').append("sdasawdd");            
            // var obj = document.getElementById('message_body');
            // var txt = document.createTextNode(fax_body);
            // obj.appendChild(txt);
            $('.md-input-wrapper').addClass('md-input-filled');         
        }
    </script>
   
</body>
</html>