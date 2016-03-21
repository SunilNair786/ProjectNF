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

// delete Outbox Faxs
if(isset($_GET['action']) && ($_GET['action'] == "delete") && isset($_GET['faxsId']) && ($_GET['faxsId']!="" ))
{   
    $faxObjCon->deleteOutboxFax($_GET['faxsId']);
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
    min-width: 135px;     
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
                    $CntallOutfaxs = $collection_fax->find(array("from_id" => $sessId,"created_date" => array('$gt' => $startDate),"status" => "A","outbox" => "Y"))->count();   
                    $allOutfaxs = $collection_fax->find(array("from_id" => $sessId,"created_date" => array('$gt' => $startDate),"status" => "A","outbox" => "Y"))->sort(array("created_date" => -1));   

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
                                    $faxInfo = $collection->find(array('fax_id' => $allOut_faxs['_id']));                                    
                                    foreach ($faxInfo as $fax_Info) {        
                                        if(strlen($fax_Info['to_id']) == "24")
                                        {
                                            $CoutUserDetail = $collection_user->find(array('_id' => new MongoId($fax_Info['to_id'])))->count();
                                            $outUserDetail = $collection_user->findOne(array('_id' => new MongoId($fax_Info['to_id'])));     
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
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail,0,-2);?>','<?php echo substr($uIds,0,-1);?>','<?php echo $allOut_faxs['message_subject'];?>','<?php echo $allOut_faxs['message_body'];?>')" title="Resend"><i class="fa fa-paper-plane"></i></a>      
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
                                                        <?php if($allOut_faxs['outbox_fax_tag'] == $all_tags['_id']){?>
                                                            <a title="tag" onClick="addingtags('<?php echo $allOut_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>           
                                                            <span onClick="addingtags('<?php echo $allOut_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a title="click to add this tag" onClick="addingtags('<?php echo $allOut_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>          
                                                        <?php } ?>
                                                    </li>
                                                <?php }
                                                } else {?>      
                                                    <li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div> 
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
                                    <span><?php echo substr($allOut_faxs['message_subject'],'0','20'); ?></span>
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

                            <?php } ?>
                        </ul>
                    </div>
					<?php } ?>


    <!-- Outbox Yesterday Messages -->
                    <?php
                    $startDate1 = date('Y-m-d 00:00:00',strtotime("-1 days"));
                    $endDate1 = date('Y-m-d 23:59:59',strtotime("-1 days"));
                    //$collection = $db->nf_fax_users; 
                    $CntyesterdOutfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $startDate1,'$lte' => $endDate1),"status" => "A","outbox" => "Y"))->count();
                    $yesterdOutfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $startDate1,'$lte' => $endDate1),"status" => "A","outbox" => "Y"))->sort(array("created_date" => -1));   
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
                            if($yesterdOut_faxs['from_grp'] != "")
                            { 
                                $usrGrpIds1 = explode(',',$yesterdOut_faxs['from_grp']);
                                for($se = "0";$se < count($usrGrpIds1); $se++)
                                {
                                    $gropInfo1 = $db->nf_user_groups->find(array('_id' => new MongoId($usrGrpIds1[$se]))); 
                                    foreach ($gropInfo1 as $grop1_Info) {  
                                        $udetailemail = '';
                                        $udetail = '';
                                        $uIds = '';  
                                        $grpDisp1 .= $grop1_Info['group_name'].',';                                        

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
                                                $urdetail1 .= $outUserDetail1['first_name']." ".$outUserDetail1['last_name'].",";
                                                $udetail1 .= $outUserDetail1['fax'].",";
                                                $uIds1 .= $outUserDetail1['_id'].",";
                                            }
                                            else
                                            {
                                                $udetailemail1 .= $contUserDetail1['contact_name']." (".$contUserDetail1['email']."), ";
                                                $urdetail1 .= $contUserDetail1['contact_name'].",";
                                                $udetail1 .= $contUserDetail1['fax'].",";
                                                $uIds1 .= $contUserDetail1['_id'].",";
                                            }
                                            
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $faxInfo1 = $collection->find(array('fax_id' => $yesterdOut_faxs['_id']));  
                                foreach ($faxInfo1 as $fax1_Info) {               
                                    if(strlen($fax1_Info['to_id']) == "24")
                                    {
                                        $CoutUserDetail1 = $collection_user->find(array('_id' => new MongoId($fax1_Info['to_id'])))->count();
                                        $outUserDetail1 = $collection_user->findOne(array('_id' => new MongoId($fax1_Info['to_id'])));     
                                        // In Contacts
                                        $UserDetailCount1 = $db->nf_user_contacts->find(array('_id' => new MongoId($fax1_Info['to_id'])))->count();
                                        $contUserDetail1 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax1_Info['to_id'])));
                                        if($CoutUserDetail1 > 0)  
                                        {
                                            //$udetail1 .= $outUserDetail1['first_name'].$outUserDetail1['last_name'].",";
                                            $udetailemail1 .= $outUserDetail1['first_name']." ".$outUserDetail1['last_name']." (".$outUserDetail1['email_id']."), ";
                                            $urdetail1 .= $outUserDetail1['first_name']." ".$outUserDetail1['last_name'].",";
                                            $udetail1 .= $outUserDetail1['fax'].",";
                                            $uIds1 .= $outUserDetail1['_id'].",";
                                        }
                                        else if($UserDetailCount1 > 0)
                                        {
                                            $udetailemail1 .= $contUserDetail1['contact_name']." (".$contUserDetail1['email']."), ";
                                            $urdetail1 .= $contUserDetail1['contact_name'].",";
                                            $udetail1 .= $contUserDetail1['fax'].",";
                                            $uIds1 .= $contUserDetail1['_id'].",";
                                        }

                                    }
                                    else
                                    {
                                        $udetailemail1 .=$fax1_Info['to_id'].",";
                                        $udetail1 .= $fax1_Info['to_id'].",";
                                        $uIds1 .= $fax1_Info['to_id'].",";
                                    }
                                }
                            }
                            ?>
                            <li>                                
                                <div class="md-card-list-item-menu margn" id="<?php echo $yesterdOut_faxs['_id'];?>">                                                                        
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail1,0,-2);?>','<?php echo substr($uIds1,0,-1);?>','<?php echo $yesterdOut_faxs['message_subject'];?>','<?php echo $yesterdOut_faxs['message_body'];?>')" title="Resend"><i class="fa fa-paper-plane"></i></a>
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
                                                        <?php if($yesterdOut_faxs['outbox_fax_tag'] == $all_tags['_id']){?>
                                                            <a title="tag" onClick="addingtags('<?php echo $yesterdOut_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>           
                                                            <span onClick="addingtags('<?php echo $yesterdOut_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a title="click to add this tag" onClick="addingtags('<?php echo $yesterdOut_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>          
                                                        <?php } ?>
                                                    </li>
                                                <?php }
                                                } else {?>      
                                                    <li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>                                     
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $yesterdOut_faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>                                                                             
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
                                        if($yesterdOut_faxs['from_grp'] != "")
                                        {
                                            echo substr($grpDisp1,0,-1);
                                        }
                                        else
                                        {
                                            echo substr($udetail1, 0, -1); 
                                        }                                        
                                        ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>
                                            <?php                                                                                      
                                            if($yesterdOut_faxs['from_grp'] != "")
                                            {
                                                echo substr($grpDisp1,0,-1);
                                            }
                                            else
                                            {
                                                echo substr($udetail1, 0, -1); 
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <span><?php echo substr($yesterdOut_faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        <?php echo $yesterdOut_faxs['message_body']; echo "<br><br>";
                                        /*if($yesterdOut_faxs['file_attach_id'] != "")
                                        {
                                            $img = 1;
                                            $attachments1 = explode(",",$yesterdOut_faxs['file_attach_id']);                                                          
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

                                        if($yesterdOut_faxs['saved_pdf_file'] != "")
                                        {?>                                                 
                                            <a href="#image_<?php echo $yesterdOut_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $yesterdOut_faxs['file_name'];?>" id="img_atch" width="100" height="50"> 
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
                                            <div class="uk-modal" id="image_<?php echo $yesterdOut_faxs['_id'];?>_popup">
                                                <div class="uk-modal-dialog" style="width:90%; height:90%;">        
                                                    <button class="uk-modal-close uk-close" type="button"></button>
                                                    <iframe src="upload_dir/savedpdfs/<?php echo $yesterdOut_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
                                                    <a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
                                                </div>
                                            </div>
                                            <!-- <a href="upload_dir/savedpdfs/<?php echo $yesterdOut_faxs['saved_pdf_file'];?>">View the attachment</a> -->     
                                        <?php } ?>
                                        <br>
                                        <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail1,0,-2);?>','<?php echo substr($uIds1,0,-1);?>','<?php echo $yesterdOut_faxs['message_subject'];?>','<?php echo $yesterdOut_faxs['message_body'];?>')" title="Resend"><button class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" type="button">Resend</button></a>   
                                    </div>                                    
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
                    
                    $CntlastMnthfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $M_startDate,'$lte' => $M_endDate),"outbox" => "Y","status"=>"A"))->count();   
                    $lastMnthfaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $M_startDate,'$lte' => $M_endDate),"outbox" => "Y","status"=>"A"))->sort(array("created_date" => -1));   
                    if($CntlastMnthfaxs > 0)
                    {
                    ?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">This Month</div>
                        <ul class="hierarchical_slide">
                            <?php
                            foreach ($lastMnthfaxs as $lastMnth_faxs) {                                    
                                // getting User and Contact Details
                                $udetailemail2 = '';
                                $udetail2 = '';
                                $uIds2 = '';
                                if($lastMnth_faxs['from_grp'] != "")
                                {
                                    $usrGrpIds2 = explode(',',$lastMnth_faxs['from_grp']);
                                    for($se = "0";$se < count($usrGrpIds2); $se++)
                                    {
                                        $gropInfo2 = $db->nf_user_groups->find(array('_id' => new MongoId($usrGrpIds2[$se]))); 
                                        foreach ($gropInfo2 as $grop2_Info) {  
                                            $udetailemail = '';
                                            $udetail = '';
                                            $uIds = '';  
                                            $grpDisp2 .= $grop2_Info['group_name'].',';
                                            
                                            $faxInfo2 = $collection->find(array('fax_id' => $lastMnth_faxs['_id']));    
                                            foreach ($faxInfo2 as $fax2_Info) {   
                                                if(strlen($fax2_Info['to_id']) == "24")
                                                {            
                                                    $CoutUserDetail2 = $collection_user->find(array('_id' => new MongoId($fax2_Info['to_id'])))->count();
                                                    $outUserDetail2 = $collection_user->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));     
                                                    // In Contacts
                                                    $UserDetailCount2 = $db->nf_user_contacts->find(array('_id' => new MongoId($fax2_Info['to_id'])))->count();
                                                    $contUserDetail2 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));
                                                    if($CoutUserDetail2 > 0)  
                                                    {
                                                        //$udetail1 .= $outUserDetail1['first_name'].$outUserDetail1['last_name'].",";
                                                        $udetailemail2 .= $outUserDetail2['first_name']." ".$outUserDetail2['last_name']." (".$outUserDetail2['email_id']."), ";
                                                        $urdetail2 .= $outUserDetail2['first_name']." ".$outUserDetail2['last_name'].",";
                                                        $udetail2 .= $outUserDetail2['fax'].",";
                                                        $uIds2 .= $outUserDetail2['_id'].",";
                                                    }
                                                    else if($UserDetailCount2 > 0)
                                                    {
                                                        $udetailemail2 .= $contUserDetail2['contact_name']." (".$contUserDetail2['email']."), ";
                                                        $urdetail2 .= $contUserDetail2['contact_name'].",";
                                                        $udetail2 .= $contUserDetail2['fax'].",";
                                                        $uIds2 .= $contUserDetail2['_id'].",";
                                                    }

                                                }
                                                else
                                                {
                                                    $udetailemail2 .=$fax2_Info['to_id'].",";
                                                    $udetail2 .= $fax2_Info['to_id'].",";
                                                    $uIds2 .= $fax2_Info['to_id'].",";
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $faxInfo2 = $collection->find(array('fax_id' => $lastMnth_faxs['_id']));    
                                    foreach ($faxInfo2 as $fax2_Info) {   
                                        if(strlen($fax2_Info['to_id']) == "24")
                                        {            
                                            $CoutUserDetail2 = $collection_user->find(array('_id' => new MongoId($fax2_Info['to_id'])))->count();
                                            $outUserDetail2 = $collection_user->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));     
                                            // In Contacts
                                            $UserDetailCount2 = $db->nf_user_contacts->find(array('_id' => new MongoId($fax2_Info['to_id'])))->count();
                                            $contUserDetail2 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax2_Info['to_id'])));
                                            if($CoutUserDetail2 > 0)  
                                            {
                                                //$udetail1 .= $outUserDetail1['first_name'].$outUserDetail1['last_name'].",";
                                                $udetailemail2 .= $outUserDetail2['first_name']." ".$outUserDetail2['last_name']." (".$outUserDetail2['email_id']."), ";
                                                $urdetail2 .= $outUserDetail2['first_name']." ".$outUserDetail2['last_name'].",";
                                                $udetail2 .= $outUserDetail2['fax'].",";
                                                $uIds2 .= $outUserDetail2['_id'].",";
                                            }
                                            else if($UserDetailCount2 > 0)
                                            {
                                                $udetailemail2 .= $contUserDetail2['contact_name']." (".$contUserDetail2['email']."), ";
                                                $urdetail2 .= $contUserDetail2['contact_name'].",";
                                                $udetail2 .= $contUserDetail2['fax'].",";
                                                $uIds2 .= $contUserDetail2['_id'].",";
                                            }

                                        }
                                        else
                                        {
                                            $udetailemail2 .=$fax2_Info['to_id'].",";
                                            $udetail2 .= $fax2_Info['to_id'].",";
                                            $uIds2 .= $fax2_Info['to_id'].",";
                                        }
                                    }
                                }
                            ?>
                            <li>                                
                                <div class="md-card-list-item-menu margn" id="<?php echo $lastMnth_faxs['_id'];?>">
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail2,0,-2);?>','<?php echo substr($uIds2,0,-1);?>','<?php echo $lastMnth_faxs['message_subject'];?>','<?php echo $lastMnth_faxs['message_body'];?>')" title="Resend"><i class="fa fa-paper-plane"></i></a>
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
                                                        <?php if($lastMnth_faxs['outbox_fax_tag'] == $all_tags['_id']){?>
                                                            <a title="tag" onClick="addingtags('<?php echo $lastMnth_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>           
                                                            <span onClick="addingtags('<?php echo $lastMnth_faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a title="click to add this tag" onClick="addingtags('<?php echo $lastMnth_faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>          
                                                        <?php } ?>
                                                    </li>
                                                <?php }
                                                } else {?>      
                                                    <li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>                                    
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $lastMnth_faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>                                                                             
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
                                        if($lastMnth_faxs['from_grp'] != "")
                                        {
                                            echo substr($grpDisp2,0,-1);
                                        }
                                        else
                                        {
                                            echo substr($udetail2, 0, -1); 
                                        } 
                                        ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>
                                            <?php                                                                                      
                                            if($lastMnth_faxs['from_grp'] != "")
                                            {
                                                echo substr($grpDisp2,0,-1);
                                            }
                                            else
                                            {
                                                echo substr($udetail2, 0, -1); 
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <span><?php echo substr($lastMnth_faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        <?php echo $lastMnth_faxs['message_body']; echo "<br><br>";
                                        /*if($lastMnth_faxs['file_attach_id'] != "")
                                        {
                                            $img = 1;
                                            $attachments2 = explode(",",$lastMnth_faxs['file_attach_id']);                                                          
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

                                        if($lastMnth_faxs['saved_pdf_file'] != "")
                                        {?>                                                 
                                            <a href="#image_<?php echo $lastMnth_faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $lastMnth_faxs['file_name'];?>" id="img_atch" width="100" height="50"> 
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
                                            <div class="uk-modal" id="image_<?php echo $lastMnth_faxs['_id'];?>_popup">
                                                <div class="uk-modal-dialog" style="width:90%; height:90%;">        
                                                    <button class="uk-modal-close uk-close" type="button"></button>
                                                    <iframe src="upload_dir/savedpdfs/<?php echo $lastMnth_faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
                                                    <a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
                                                </div>
                                            </div>
                                            <!-- <a href="upload_dir/savedpdfs/<?php echo $lastMnth_faxs['saved_pdf_file'];?>">View the attachment</a> -->     
                                        <?php } ?>
                                        <br>
                                        <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail2,0,-2);?>','<?php echo substr($uIds2,0,-1);?>','<?php echo $lastMnth_faxs['message_subject'];?>','<?php echo $lastMnth_faxs['message_body'];?>')" title="Resend"><button class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" type="button">Resend</button></a>  
                                    </div>                                    
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
                    
                    $CntOldmonthFaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $OldstartDate,'$lte' => $OldendDate),"status"=>"A","outbox" => "Y"))->count();
                    $OldmonthFaxs = $collection_fax->find(array("from_id"=>$_SESSION['user_id'],"created_date" => array('$gt' => $OldstartDate,'$lte' => $OldendDate),"status"=>"A","outbox" => "Y"))->sort(array("created_date" => -1));   
                    if($CntOldmonthFaxs > 0)
                    {
                    ?>
                    <div class="md-card-list">
                        <div class="md-card-list-header heading_list">Older Messages</div>
                        <ul class="hierarchical_slide">
                            <?php
                            foreach ($OldmonthFaxs as $CntOldmonth_Faxs) {                                    
                                // getting User and Contact Details
                                $udetailemail3 = '';
                                $udetail3 = '';
                                $uIds3 = '';
                                if($lastMnth_faxs['from_grp'] != "")
                                {
                                                $faxInfo3 = $collection->find(array('fax_id' => $CntOldmonth_Faxs['_id']));    
                                                foreach ($faxInfo3 as $fax3_Info) {  
                                                    if(strlen($fax3_Info['to_id']) == "24")
                                                    {              
                                                        $CoutUserDetail3 = $collection_user->find(array('_id' => new MongoId($fax3_Info['to_id'])))->count();
                                                        $outUserDetail3 = $collection_user->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));     
                                                        // In Contacts
                                                        $UserDetailCount3 = $db->nf_user_contacts->find(array('_id' => new MongoId($fax3_Info['to_id'])))->count();
                                                        $contUserDetail3 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));
                                                        if($CoutUserDetail3 > 0)  
                                                        {
                                                            //$udetail1 .= $outUserDetail1['first_name'].$outUserDetail1['last_name'].",";
                                                            $udetailemail3 .= $outUserDetail3['first_name']." ".$outUserDetail3['last_name']." (".$outUserDetail3['email_id']."), ";
                                                            $urdetail3 .= $outUserDetail3['first_name']." ".$outUserDetail3['last_name'].",";
                                                            $udetail3 .= $outUserDetail3['fax'].",";
                                                            $uIds3 .= $outUserDetail3['_id'].",";
                                                        }
                                                        else if($UserDetailCount3 > 0)
                                                        {
                                                            $udetailemail3 .= $contUserDetail3['contact_name']." (".$contUserDetail3['email']."), ";
                                                            $urdetail3 .= $contUserDetail3['contact_name'].",";
                                                            $udetail3 .= $contUserDetail3['fax'].",";
                                                            $uIds3 .= $contUserDetail3['_id'].",";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $udetailemail3 .=$fax3_Info['to_id'].",";
                                                        $udetail3 .= $fax3_Info['to_id'].",";
                                                        $uIds3 .= $fax3_Info['to_id'].",";
                                                    }
                                                }
                                }
                                else
                                {
                                    $faxInfo3 = $collection->find(array('fax_id' => $CntOldmonth_Faxs['_id']));    
                                    foreach ($faxInfo3 as $fax3_Info) {  
                                        if(strlen($fax3_Info['to_id']) == "24")
                                        {              
                                            $CoutUserDetail3 = $collection_user->find(array('_id' => new MongoId($fax3_Info['to_id'])))->count();
                                            $outUserDetail3 = $collection_user->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));     
                                            // In Contacts
                                            $UserDetailCount3 = $db->nf_user_contacts->find(array('_id' => new MongoId($fax3_Info['to_id'])))->count();
                                            $contUserDetail3 = $db->nf_user_contacts->findOne(array('_id' => new MongoId($fax3_Info['to_id'])));
                                            if($CoutUserDetail3 > 0)  
                                            {
                                                //$udetail1 .= $outUserDetail1['first_name'].$outUserDetail1['last_name'].",";
                                                $udetailemail3 .= $outUserDetail3['first_name']." ".$outUserDetail3['last_name']." (".$outUserDetail3['email_id']."), ";
                                                $urdetail3 .= $outUserDetail3['first_name']." ".$outUserDetail3['last_name'].",";
                                                $udetail3 .= $outUserDetail3['fax'].",";
                                                $uIds3 .= $outUserDetail3['_id'].",";
                                            }
                                            else if($UserDetailCount3 > 0)
                                            {
                                                $udetailemail3 .= $contUserDetail3['contact_name']." (".$contUserDetail3['email']."), ";
                                                $urdetail3 .= $contUserDetail3['contact_name'].",";
                                                $udetail3 .= $contUserDetail3['fax'].",";
                                                $uIds3 .= $contUserDetail3['_id'].",";
                                            }
                                        }
                                        else
                                        {
                                            $udetailemail3 .=$fax3_Info['to_id'].",";
                                            $udetail3 .= $fax3_Info['to_id'].",";
                                            $uIds3 .= $fax3_Info['to_id'].",";
                                        }
                                    }
                                }      
                            ?>
                            <li>                                
                                <div class="md-card-list-item-menu margn" id="<?php echo $CntOldmonth_Faxs['_id'];?>">                                                                        
                                    <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail3,0,-2);?>','<?php echo substr($uIds3,0,-1);?>''<?php echo $CntOldmonth_Faxs['message_subject'];?>','<?php echo $CntOldmonth_Faxs['message_body'];?>')" title="Resend"><i class="fa fa-paper-plane"></i></a>
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
                                                        <?php if($CntOldmonth_Faxs['outbox_fax_tag'] == $all_tags['_id']){?>
                                                            <a title="tag" onClick="addingtags('<?php echo $CntOldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','aa12')"><?php echo $all_tags['tag_name'];?></a>           
                                                            <span onClick="addingtags('<?php echo $CntOldmonth_Faxs['_id'];?>','','emptytt')" style="float:right;cursor:pointer;color:red;">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a title="click to add this tag" onClick="addingtags('<?php echo $CntOldmonth_Faxs['_id'];?>','<?php echo $all_tags['_id'];?>','<?php echo $all_tags['tag_name'];?>')"><?php echo $all_tags['tag_name'];?></a>          
                                                        <?php } ?>
                                                    </li>
                                                <?php }
                                                } else {?>      
                                                    <li style="text-align:center;">No tags were added <br> to add <a href="tag.php">Click Here</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>                                     
                                    <a href="#" onClick="var q = confirm('Are you sure you want to delete selected record?'); if (q) { window.location='outbox.php?action=delete&faxsId=<?php echo $CntOldmonth_Faxs['_id'];?>'; return false;}" title="delete"><i class="fa fa-trash"></i></a>                                                                             
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
                                        echo substr($udetail3, 0, -1); 
                                        ?>
                                    </span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span>
                                            <?php                                                                                      
                                            echo substr($udetail3, 0, -1); 
                                            ?>
                                        </span>
                                    </div>
                                    <span><?php echo substr($CntOldmonth_Faxs['message_subject'],'0','20'); ?></span>
                                </div>
                                <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                        <?php echo $CntOldmonth_Faxs['message_body']; echo "<br><br>";
                                        /*if($CntOldmonth_Faxs['file_attach_id'] != "")
                                        {
                                            $img = 1;
                                            $attachments3 = explode(",",$CntOldmonth_Faxs['file_attach_id']);                                                          
                                            for($i = 0; $i< sizeof($attachments3); $i++)
                                            {
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
                                        if($CntOldmonth_Faxs['saved_pdf_file'] != "")
                                        {?>                                                 
                                            <a href="#image_<?php echo $CntOldmonth_Faxs['_id'];?>_popup<?php echo $img;?>" data-uk-modal="{center:true}">
                                                <!-- <img title="click to view attachment" src="upload_dir/files/<?php echo $CntOldmonth_Faxs['file_name'];?>" id="img_atch" width="100" height="50"> 
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
                                            <div class="uk-modal" id="image_<?php echo $CntOldmonth_Faxs['_id'];?>_popup">
                                                <div class="uk-modal-dialog" style="width:90%; height:90%;">        
                                                    <button class="uk-modal-close uk-close" type="button"></button>
                                                    <iframe src="upload_dir/savedpdfs/<?php echo $CntOldmonth_Faxs['saved_pdf_file'];?>" style="width:100%; height:100%;"></iframe>
                                                    <a id="addButton" class="green-button" href="add_note.html">Add a note</a>    
                                                </div>
                                            </div>
                                            <!-- <a href="upload_dir/savedpdfs/<?php echo $CntOldmonth_Faxs['saved_pdf_file'];?>">View the attachment</a> -->     
                                        <?php } ?>
                                        <br>
                                        <a href="#mailbox_new_message" data-uk-modal="{center:true}" onClick="fwdmsg('<?php echo substr($udetailemail3,0,-2);?>','<?php echo substr($uIds3,0,-1);?>','<?php echo $CntOldmonth_Faxs['message_subject'];?>','<?php echo $CntOldmonth_Faxs['message_body'];?>')" title="Resend"><button class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" type="button">Resend</button></a>  
                                    </div>                                    
                                </div>
                            </li>
                            <?php } ?>
                            
                        </ul>
                    </div>
                    <?php } ?>

    <!-- No Faxs  -->

                <?php if($CntallOutfaxs == "0" && $CntyesterdOutfaxs == "0" && $CntlastMnthfaxs == "0" && $CntOldmonthFaxs == "0"){?>
                    <div class="md-card-list">                
                        <center>
                            <img src="assets/img/fax.png" alt="No Faxs Found" height="150" width="200">
                            <br>Oops..! No faxs Found here....
                        </center>
                    </div>
                <?php } ?>

    <!-- No faxs End -->


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
            <form name='composeFrm' id="composeFrm" action='tcpdf/examples/example_001.php' enctype="multipart/form-data" method='post'>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <small style="float:right;margin-top:-6px;">To add a 
                        <span id="gg">Group</span><span id="uu" style="display:none;">User</span> <span id="grpshow" style="cursor:pointer;">click here</span>
                    </small>                    
                    <span id="usersmail">   
                        <label for="mail_new_to">To</label>
                        <input type="text" class="md-input" name="mail_new_to" id="mail_new_to" >       
                    </span>

                    <span id="groupsmail" style="display:none;">
                        <label for="mail_new_to">To</label>
                        <input type="text" class="md-input" name="mail_new_to" id="mail_new_to2" >      
                    </span>                 
                    
                    <input type="hidden" name="hidd_labels" id="labels">
                    
                    <input type="hidden" name="hidd_values" id="values">    

                </div>
                <input type="hidden" name="hidd_userid" id="hidd_userid" value="<?php echo $_SESSION['user_id']?>" />
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Subject</label>
                    <input name="message_subject" id="message_subject" class="md-input" required />
                </div>
                
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Message</label>
                    <textarea name="message_body" id="message_body" cols="30" rows="6" class="md-input" required></textarea>
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
            } else {            
                $('input#mail_new_to2').removeAttr('required');
                $('input#mail_new_to').attr('required',true);
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
            $groupsAutoComp = $collection_grp->find();
            foreach ($groupsAutoComp as $groups_AutoComp) {
                $allusrds = explode(',', $groups_AutoComp['user_ids']);
                $allCnames = "";
                for($i=0;$i < count($allusrds);$i++)
                {                   
                    $collection_cont = $db->nf_user_contacts;
                    $srchcontac = $collection_cont->findOne(array('_id'=>new MongoId($allusrds[$i])));
                    $allCnames .= $srchcontac['contact_name'].',';                  
                }
                ?>
            {
                value: "<?php echo $groups_AutoComp['user_ids'];?>",
                label: "<?php echo $groups_AutoComp['group_name'];?> (<?php echo $allCnames;?>)"
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
// Group Names End

    

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

        // Adding Tags to Outbox faxs
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
                    data: {"tagfaxs": tfaxid,"tagsId":tagId,"section":"Outbox_tagsAdd"},
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

        // Emptying the fields in compose form
        $('.uk-close').click(function(){
            $('#composeFrm')[0].reset();        
            $('.md-input-wrapper').removeClass('md-input-filled');      
        });
    </script>
   
</body>
</html>