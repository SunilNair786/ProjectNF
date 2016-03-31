<?php
session_start();
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/
$siteurl=$_SERVER['DOCUMENT_ROOT']."/nf";
include($siteurl."/controller/faxController.php");
include($siteurl."/model/commonFunctions.php");
include ($siteurl."/model/PDFMerger.php");

$pdf1 = new PDFMerger;
$cfObj = new commonFunctions();

$faxObjCon = new faxController();
$faxObj =  new faxModel();

// Database Connection
$mC = new MongoClient();
$db = $mC->nf;



if($_POST['submit_reply']=="reply")
{	
	

     require_once('tcpdf/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  
// set document information
// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('TCPDF Example 001');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData('../../../assets/img/gallery/Image01.jpg', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', "Sample", array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Remove Header
$pdf->setPrintHeader(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// set image
// $pdf->Image('../../assets/img/gallery/Image01.jpg',20,50,80);

$sds = "Image01.jpg";
$reply_subject="Reply subject";
// Set some content to print
$html = '<img src="assets/img/gallery/'.$sds.'" width="100" height="70"><br><br>Subject : '.$reply_subject.'.<br>
<br>Message:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_POST['reply_message'].'<br><br>';



//echo "<pre>";print_r($_FILES); echo "</pre>";
	//echo "<pre>";print_r($_POST);echo "</pre>";
	$upload_directory = 'upload_dir/files';
	$userId = $_SESSION['user_id'];	
	$timeStamp = $cfObj->getTimeStamp();
	$newFileName = $userId."_".$timeStamp;	
	$newsavedPdf = $userId."_".date("Ymd")."_".$timeStamp; 
	$uploadfile = '';
    $html1="";


	$to_id=$_POST['to_id'];
	$from_id=$_POST['from_id'];
	$collection = $db->nf_user;
	// User Details										
	$userDetails = $collection->findOne(array('_id' => new MongoId($to_id)));
	$userDetails2 = $collection->findOne(array('_id' => new MongoId($from_id)));
	$to_faxid=$userDetails['fax'];
	$from_faxid=$userDetails2['fax'];

	$_POST['to_id']=$to_faxid;

	//$faxObjCon->sendReply($_POST);

	
	for($x=0;$x<count($_FILES['file']['name']);$x++){ 
		
		$file_name = $_FILES['file']['name'][$x];
		$fullFileName = $newFileName.'_'.$x.'_'. $file_name; 
		move_uploaded_file($_FILES['file']['tmp_name'][$x],$upload_directory.'/'.$fullFileName);
		$uploadfile .= $faxObj->uploadIndvFile($_FILES['file']['size'][$x],$fullFileName).",";
		$filType = explode(".", $fullFileName);

		 if($filType[1] == "jpg" || $filType[1] == "jpeg" || $filType[1] == "png" || $filType[1] == "gif")
        {
            $html1 .= '<img src="upload_dir/files/'.$fullFileName.'"><br><br>';
        }
              // for doc and docx
        else if($filType[1] == "doc" || $filType[1] == "docx")
        {
            // for doc          
            if($filType[1] == "doc")
            {
                $fileHandle = fopen($upload_directory.'/'.$fullFileName, "r");
                $line = @fread($fileHandle);   
                $lines = explode(chr(0x0D),$line);
                $outtext = "";
                foreach($lines as $thisline)
                {
                    $pos = strpos($thisline, chr(0x00));
                    if (($pos !== FALSE)||(strlen($thisline)==0))
                    {
                    } 
                    else 
                    {
                        $outtext .= $thisline." ";
                    }
                }
                $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
                $html1 .= $outtext.'<br><br>';
                
            }
            else //for docx
            {
                $striped_content = '';
                $content = '';

                $zip = zip_open($upload_directory.'/'.$fullFileName);

                if (!$zip || is_numeric($zip)) return false;

                while ($zip_entry = zip_read($zip)) {

                    if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

                    if (zip_entry_name($zip_entry) != "word/document.xml") continue;

                    $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                    zip_entry_close($zip_entry);
                }// end while

                zip_close($zip);

                $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
                $content = str_replace('</w:r></w:p>', "\r\n", $content);
                $html1 .= strip_tags($content).'<br><br>';
            }
        }else if($filType[1] == "txt"){
            $filecontent = file_get_contents($upload_directory.'/'.$fullFileName);
            $html1 .= strip_tags($filecontent).'<br><br>';
        }
			
		

	} // for loop


	if($uploadfile !=''){
		$_POST['attachment_id'] =  substr($uploadfile, 0 ,-1);
	}else{
		$_POST['attachment_id'] = '';
	}
	$_POST['message_body']=$_POST['reply_message']; 
	$_POST['message_subject']="Reply:".$_POST['reply_subject'];
	$_POST['saved_pdf_file']=$newsavedPdf.".pdf";
    $faxId = $faxObjCon->copyFiles($_POST,$_FILES);
    

//echo $html1;
$pdf->WriteHTML($html, false, 0, true, 0);

$pdf->WriteHTML($html1, false, 0, true, 0);
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/savedpdfs/'.$newsavedPdf.'.pdf', 'F');

$_POST['saved_pdf_file']=$newsavedPdf.".pdf";

$faxObjCon->sendReply($_POST);
$faxObjCon->insertToFaxIds($_POST['to_id'],$faxId);    


//echo "<pre>";print_r($_POST); echo "</pre>";
//echo $to_faxid;
//echo "<br>";
//echo $newsavedPdf.'.pdf';
// Updating the file uploads pdf name
/*$collectionUp = $db->nf_fax_replys;
$Update_fax_vals = array("saved_pdf_file" => $newsavedPdf.".pdf");
$updateRes = $collectionUp->update(array('to_id' => $to_faxid), array('$set' => $Update_fax_vals));*/

    
    /*if(is_array($finalUserToIds)){              
        for($i=0;$i<count($finalUserToIds);$i++){            
            $faxObjCon->insertToFaxIds($finalUserToIds[$i],$faxId); 
        }
    }else{        
            $arrToId = $finalUserToIds;
            $faxObjCon->insertToFaxIds($arrToId,$faxId);    
    }*/

    $prvUrl = basename($_SERVER['HTTP_REFERER']);
    header("location:".$prvUrl."");
	
}//if condition



?>