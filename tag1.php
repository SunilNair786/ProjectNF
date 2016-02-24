<?php
// for text files

// $section = file_get_contents('./readme.txt', true);
// var_dump($section);

// $myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
// echo fread($myfile,filesize("webdictionary.txt"));
// fclose($myfile);


// include('model/class.pdf2text.php');
// $a = new PDF2Text();
// $a->setFilename('documents/testpdf.pdf');
// $a->decodePDF();
// echo $a->output();

// for docx

// $striped_content = '';
// $content = '';

// $zip = zip_open("test.docx");

// if (!$zip || is_numeric($zip)) return false;

// while ($zip_entry = zip_read($zip)) {

// 	if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

// 	if (zip_entry_name($zip_entry) != "word/document.xml") continue;

// 	$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

// 	zip_entry_close($zip_entry);
// }// end while

// zip_close($zip);

// $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
// $content = str_replace('</w:r></w:p>', "\r\n", $content);
// $striped_content = strip_tags($content);

//echo $striped_content;


// for doc

// $fileHandle = fopen("sample.doc", "r");
// $line = @fread($fileHandle, filesize("sample.doc"));   
// $lines = explode(chr(0x0D),$line);
// $outtext = "";
// foreach($lines as $thisline)
//   {
// 	$pos = strpos($thisline, chr(0x00));
// 	if (($pos !== FALSE)||(strlen($thisline)==0))
// 	  {
// 	  } else {
// 		$outtext .= $thisline." ";
// 	  }
//   }
//  $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
// echo $outtext;
?>