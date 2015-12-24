<?php
class convertToPdf{	
	function createImageFrmPDF(){
		
		
	}
	
}

//$mpdf=new mPDF('c'); 
$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
$mpdf->mirrorMargins = 1;

$header = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="33%">Page<span style="font-size:14pt;margin-right:10px;">{PAGENO}</span></td>

</tr></table>
';
$headerE = '
<table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;"><tr>
<td width="33%"><span style="font-weight: bold;"></span></td>
<td width="33%" align="center"></td>
<td width="33%" style="text-align: right;">Page<span style="font-size:14pt;">{PAGENO}</span></td>
</tr></table>
';

$footer = '<div align="center"></div>';
$footerE = '<div align="center"></div>';


$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');

$mpdf->WriteHTML($html);

$mpdf->Output('uploads/sample1.pdf','F');
exit;

?>