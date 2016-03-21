<?php
ob_start();
session_start();
include("../../controller/faxController.php");
include("../../model/commonFunctions.php");
include('../../model/faxModel.class.php');
include '../../model/PDFMerger.php';

$pdf1 = new PDFMerger;
$cfObj = new commonFunctions();

$faxObjCon = new faxController();
$faxObj =  new faxModel();

// Database Connection
$mC = new MongoClient();
$db = $mC->nextfax;

if(isset($_REQUEST['submit'])){      	
    $toIds = $_POST['mail_new_to'];  //exit;
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

    // File uploading
    $upload_directory = '../../upload_dir/files';
	$x=0;
	$userId = $_SESSION['user_id'];	
	$timeStamp = $cfObj->getTimeStamp();
	$newFileName = $userId."_".$timeStamp;	
	$newsavedPdf = $userId."_".date("Ymd")."_".$timeStamp; 
	$uploadfile = '';
	foreach ( $_FILES['file']['name'] as $values ){  			   	
		$fullFileName = $newFileName.'_'.$x.'_'. $_FILES["file"]["name"][$x]; 
			move_uploaded_file($_FILES["file"]["tmp_name"][$x],$upload_directory.'/'.$fullFileName);	   	
	   		$uploadfile .= $faxObj->uploadIndvFile($_FILES['file']['size'][$x],$fullFileName).",";
			
	   	$x++;  
	}
	if($uploadfile !=''){
		$_POST['attachment_id'] =  substr($uploadfile, 0 ,-1);
	}else{
		$_POST['attachment_id'] = '';
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
    //header("location:outbox.php");
}
//print_r($_POST); exit;
require_once('tcpdf_include.php');
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
// Set some content to print
$html = '
<img src="../../assets/img/gallery/'.$sds.'" width="100" height="70">
<br><br>
Subject : '.$_POST['message_subject'].'.
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_POST['message_body'].'<br><br>
';

//Getting File Type and Contents
$collectionUp = $db->nf_fax;
$faxattachs = $collectionUp->findOne(array('_id' => new MongoId($faxId)));

if($faxattachs['file_attach_id'] != "")
{

	$userId_arr = explode(',',$faxattachs['file_attach_id']);
	foreach($userId_arr as $attachIds)
	{
		$collectionUpload = $db->nf_user_fileuploads;
        $files12 = $collectionUpload->findOne(array('_id' => new MongoId($attachIds)));
        $filename = "../../upload_dir/files/".$files12['file_name']."";
        
        $filType = explode(".", $files12['file_name']);
        if($filType[1] == "jpg" || $filType[1] == "jpeg" || $filType[1] == "png" || $filType[1] == "gif")
        {
			$html1 .= '<img src="../../upload_dir/files/'.$files12['file_name'].'"><br><br>';
        }
        // for text files
        /*else if($filType[1] == "txt")
        {
        	$myfile = fopen("../../upload_dir/files/".$files12['file_name']."", "r") or die("Unable to open file!");
			$html1 .= fread($myfile,filesize("../../upload_dir/files/".$files12['file_name'].""));
			$html1 .= '<br><br>';
			fclose($myfile);
        }*/
        // for doc and docx
        else if($filType[1] == "doc" || $filType[1] == "docx")
        {
        	// for doc        	
        	if($filType[1] == "doc")
        	{
        		$fileHandle = fopen($filename, "r");
				$line = @fread($fileHandle, filesize($filename));   
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

				$zip = zip_open($filename);

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
        }
        /*else if ($filType[1] == "pdf") {
        	include('../../model/class.pdf2text.php');
        	
			$a = new PDF2Text();
			$a->setFilename($filename);
			$a->decodePDF();
			$html1 .= $a->output();
        }*/
        
	}

}

// Print text using writeHTMLCell()
//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->WriteHTML($html, false, 0, true, 0);

$pdf->WriteHTML($html1, false, 0, true, 0);
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/savedpdfs/'.$newsavedPdf.'.pdf', 'F');
// ---------------------------------------------------------

// Updating the file uploads pdf name
$Update_fax_vals = array("saved_pdf_file" => $newsavedPdf.".pdf");
$updateRes = $collectionUp->update(array('_id' => new MongoId($faxId)), array('$set' => $Update_fax_vals));
// Close and output PDF document

if($faxattachs['file_attach_id'] != "")
{
	$userId_arr1 = explode(',',$faxattachs['file_attach_id']);
	$iff = 1;	
	foreach($userId_arr1 as $attachIds1)
	{
		$collectionUpload = $db->nf_user_fileuploads;
        $files121 = $collectionUpload->findOne(array('_id' => new MongoId($attachIds1)));
        $filType1 = explode(".", $files121['file_name']);         
        if($filType1[1] == "pdf")
        {
        	//echo $iff;
        	// if($iff == 1)
        	// {
        	// 	$pdf->Output($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/files/'.$newsavedPdf.'.pdf', 'F');
        	// 	echo $ssw = "files";	
        	// }
        	// else
        	// {
        	// 	echo $ssw = "savedpdfs";	
        	// }

			$pdf1->addPDF($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/savedpdfs/'.$newsavedPdf.'.pdf','all')
				->addPDF($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/files/'.$files121['file_name'], 'all')
				->merge('file', $_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/savedpdfs/'.$newsavedPdf.'.pdf');
		}
		else
		{
			
		}
		$iff++;
	}//foreach
	
	//unlink($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/files/'.$newsavedPdf.'.pdf');

}// if
else
{
	$pdf->Output($_SERVER['DOCUMENT_ROOT'].'nf/upload_dir/savedpdfs/'.$newsavedPdf.'.pdf', 'F');
}
	
$prvUrl = basename($_SERVER['HTTP_REFERER']);
header("location:../../".$prvUrl."");

//============================================================+
// END OF FILE
//============================================================+