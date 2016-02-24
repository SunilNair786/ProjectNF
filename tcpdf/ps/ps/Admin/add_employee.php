<?php include_once("../connection.php");
//echo phpinfo();
if(empty($_SESSION['usr_id']))
{
	header("Location: login.php");
	exit();
}
$cats = mysql_query("SELECT * FROM article_category");
if($_POST['save'] == "Submit" && $_POST['acc_id'] > 0)
{
	if($_POST['art_title'] != "")
	{
		
		$ext_qry = "";
		if($_FILES['art_image']['error'] == 0)
		{
			 $file_name = time()."_".$_FILES['art_image']['name'];
			
			if(move_uploaded_file($_FILES['art_image']['tmp_name'], "../article_image/".$file_name))
			{
				 $ext_qry = " art_image = '".$file_name."', ";
			}			
		}
		
	
		 $qry_add = "UPDATE add_articles SET art_title = '".addslashes(trim($_POST['art_title']))."',
											art_desc = '".addslashes(trim($_POST['art_desc']))."',
											art_url = '".addslashes(trim($_POST['art_url']))."',
											art_cat = '".addslashes(trim($_POST['art_cat']))."',
											".$ext_qry."
											art_date='".date("Y-m-d")."'
											
											WHERE art_id = '".addslashes($_POST['acc_id'])."' ";
								
		if(mysql_query($qry_add))
		{
			
		
			$_SESSION['msg'] = "Article updated successfully";
			header("Location: employee.php");
			exit();
		}
		else
		{
			$_SESSION['msg'] = "Error: Please try again";
		}
		
	 
	}
	else
	{
		$_SESSION['msg'] = "Please enter First Name";
	
	}
	exit();
}
if($_POST['save'] == "Submit")
{
	if($_POST['art_title'] != "")
	{
	
	
	
	$ext_qry = "";
	if($_FILES['art_image']['error'] == 0)
	{
		$file_name = time()."_".$_FILES['art_image']['name'];
		
		if(move_uploaded_file($_FILES['art_image']['tmp_name'], "../article_image/".$file_name))
		{
			$ext_qry = " art_image = '".$file_name."', ";
		}			
	}
	
	$qry_add = "INSERT INTO add_articles SET 	art_title = '".addslashes(trim($_POST['art_title']))."',
												art_desc = '".addslashes(trim($_POST['art_desc']))."',
												art_cat = '".addslashes(trim($_POST['art_cat']))."',
												art_url = '".addslashes(trim($_POST['art_url']))."',
												".$ext_qry."
												art_status = 'Y',
												
												art_date = '".date("Y-m-d")."' ";
	
		
		
												
		if(mysql_query($qry_add))
		{
			
			$_SESSION['msg'] = "Article added successfully";
			header("Location: employee.php");
			exit();
		}
		else
		{
			$_SESSION['msg'] = "Error: Please try again";
		}
		
	  
	}
	else
	{
		$_SESSION['msg'] = "Please enter First Name";
	
	}
	
}
if($_GET['e_id'] > 0)
{

	$qry_account = mysql_query("SELECT * FROM add_articles WHERE art_id= '".$_GET['e_id']."'");
	$account = mysql_fetch_assoc($qry_account);
	$h1tag = "Edit Article Details"; 
}
else
{
	$account = $_POST;
	$h1tag = "Add Article Details"; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: <?php echo $DOMAIN_NAME_PAGE.' '.$h1tag;?> ::</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />
<!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"> 
<script type="text/javascript" src="js/jquery.min.js"></script> 
<script type="text/javascript" src="js/jquery-ui.min.js"></script> 
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	
	$('.readonlyone input').attr('disabled', 'disabled');
	$('.readonlyone select').attr('disabled', 'disabled');
	
	//$('#acc_date').datepicker({dateFormat: 'yy-mm-dd'});	
	
	$("#addpurchasefrm").validate({
		rules: {
		art_title: { required:true },
			
			//acc_quantity: { required:true },
			//acc_unitprice: { required:true },
			art_cat: { required:true },
			acc_date: { required:true }
		},
		messages: {
			art_title: { 
				required:"Please Enter Title" 

				//email:"Please enter valid E-mail Address" 
			},
			
			//acc_unitprice: { 
				//required:"Please Enter Unit Price " 
				//email:"Please enter valid E-mail Address" 
		//	},
			//acc_amount: { 
//				required:"Please Enter amount", 
//				minlength:"Please Enter valid amount."  
//			},
			acc_date: { required:"please enter valid date" }
		},
		errorElement: "span"
	});	
	
	
	
	
});

	
</script>
<script type="text/javascript">
$(document).ready(function() {	
	$("#prdcat_id").autocomplete({
		source:'getname.php'
	});		
});
</script>
</head>
<body>
<?php include_once("header_logo.php"); ?>
<div class="clear"></div>
<div id="wrapbg">
  <div id="wrapper">
    <?php include_once("header_nav.php"); ?>
    <div class="clear"></div>
    <section>
      <div id="bar">
        <h1><?php echo $h1tag; ?></h1>
        <div class="clear"></div>
      </div>
      <article>
       
        <div id="addpurchase" style="width:710px;">
        <?php
		if($_SESSION['msg'] != "")
		{
			echo '<div class="error_msg">'.$_SESSION['msg'].'</div>';
			$_SESSION['msg'] = '';
		}
		?>
          <form action="add_employee.php" enctype="multipart/form-data" name="addpurchasefrm" method="post" id="addpurchasefrm" >
          <input type="hidden" name="acc_id" value="<?php echo $account['art_id']; ?>" />
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
           
              <tr>
                <td class="bold aright">Title : <span class="red14">* </span></td>
                <td>
                	
                    <input type="text" name="art_title" id="art_title"  value="<?php echo $account['art_title'];?>" /></td>
              </tr>
			  <tr>
			   <td class="bold aright">Category : <span class="red14">* </span></td>
			   <td>
				<select name="art_cat" id="art_cat">
					<option value=''>Select Category</option>
					<?php while($cats_result = mysql_fetch_assoc($cats)){
						if($cats_result['art_id']==$account['art_cat']){
								?><option value='<?php echo $cats_result['art_id'] ;?>' selected><?php echo $cats_result['art_name'] ;?></option><?php
						}else{
							?><option value='<?php echo $cats_result['art_id'] ;?>'><?php echo $cats_result['art_name'] ;?></option><?php
						}
						
					}
					 ?>
				</select>
				
			  </td>
			</tr>
              <!-- <tr>
                <td class="bold aright">Description : </td>
                <td>
                <textarea  name="art_desc" id="art_desc"><?php echo $account['art_desc']; ?></textarea>
               </td>
              </tr> -->
             
              <tr>
                <td class="bold aright">Image : </td>
                <td><input type="file" name="art_image" id="art_image" /></td>
              </tr>
              
              <!-- <tr>
                <td class="bold aright">Page URL: </td>
                <td><input type="text" name="art_url" id="art_url"  value="<?php echo $account['art_url'];?>" /></td>
              </tr> -->
            
              <tr>
                <td class="bold aright"></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" name="save" class="btn" value="Submit" /></td>
              </tr>
              
             
              
              
             
            </table>
          </form>
        </div>
        <div class="clear"></div>
      </article>
      <?php include_once("footer.php"); ?>
      <div class="clear"></div>
    </section>
    <div class="clear"></div>
  </div>
  <!-- wrapper ends here -->
  <div class="clear"></div>
</div>
<!-- bgwrapper ends here -->
</body>
</html>
