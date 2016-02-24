<?php
include("../connection.php"); 
if($_POST['save'] == "Submit")
{
	//if($_POST['uname'] != "")
	//{
		$extqry = '';
		if($_FILES['uploadFile']['error'] == 0)
		{
			$fname = time()."_".$_FILES['uploadFile']['name'];
			if(move_uploaded_file($_FILES['uploadFile']['tmp_name'], '../article_image/'.$fname))
			{
				$extqry = " art_image = '".$fname."', ";
			}
			
			$insert = "INSERT INTO add_articles SET art_title = '".$_POST['tit']."',  ".$extqry." art_desc='".$_POST['cmt']."',art_date='".date("Y-m-d")."'";
					//die();
					}

		if(mysql_query($insert))
		{
			$_SESSION['msg'] = "Record added successfully";
			header("Location: users.php");
			exit();
		}
	//}
	//else
	//{
		//exit("User Empty");
	//}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="add_articles.php" enctype="multipart/form-data">
<?php
if($_SESSION['msg'] != "")
{
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}
$cats = mysql_query("SELECT * FROM article_category");

?>
  <table width="800" border="0" cellpadding="5" cellspacing="5" >
    <tr>
      <td width="100">Title</td>
      <td width="10">:</td>
      <td width="600"><label>
        <input type="text" name="tit" id="tit" maxlength="10"  />
        <span class="error">*</span> </label>
      </td>
    </tr>
	<tr>
      <td width="100">Category</td>
      <td width="10">:</td>
      <td width="600"><label>
        <select name="cat" id="cat">
			<option value=''>Select Category</option>
			<?php while($cats_result = mysql_fetch_assoc($cats)){
				?><option value='<?php echo $cats_result['art_id'] ;?>'><?php echo $cats_result['art_name'] ;?></option><?php
			}
			 ?>
		</select>
        <span class="error">*</span> </label>
      </td>
    </tr>
    <tr>
      <td>File Upload</td>
      <td>:</td>
      <td><input type="file" name="uploadFile" title="Select Your File From System"></td>
    </tr>
    <tr>
      <td height="35">Comment</td>
      <td>:</td>
      <td><label>
        <textarea name="cmt" id="cmt" cols="45" rows="5"></textarea>
      </td>
    </tr>
    <tr>
    <td><input type="submit" value="Submit"  title="Click On Submit Button" name="save"></td>
  </tr>
  </table>
</form>
</body>
</html>
