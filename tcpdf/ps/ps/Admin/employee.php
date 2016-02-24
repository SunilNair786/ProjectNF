<?php include_once("../connection.php");
if(empty($_SESSION['usr_id']))
{
	header("Location: login.php");
	exit();
}
$cats = mysql_query("SELECT * FROM article_category");
while($cats_result = mysql_fetch_assoc($cats)){
      $cats_result_array[$cats_result[art_id]] = $cats_result[art_name];

}
if($_REQUEST['d_id']){
$delquery=mysql_query("UPDATE add_articles set art_status ='N' where art_id=".$_REQUEST['d_id']."");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: <?php echo $DOMAIN_NAME_PAGE;?> Article List ::</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="https://www.google.com/fonts#UsePlace:use/Collection:Open+Sans:400,6000" type="text/css" />
<!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.validation.js"></script>
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
        
        <div class="clear"></div>
      </div>
      <article>
  
      	<?php //include_once("employee_left.php"); ?>
        <div id="purchase_list">
            <h1>Article List</h1>
        <?php
		if(isset($_SESSION['msg']))
		{
			echo '<div class="error_msg">'.$_SESSION['msg'].'</div>';
			$_SESSION['msg'] = '';
		}
		?>
        <div class="btn"><a href="add_employee.php">Add Article</a></div>
          <table width="130%" border="0"  cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <th width="8%" align="center" valign="middle" bgcolor="#d8d1e9">S.No.</th>
                <th width="12%" align="left" valign="middle" bgcolor="#d8d1e9">Title</th>
                <!-- <th width="21%" align="left" valign="middle" bgcolor="#d8d1e9">Last Name</span></th> -->
                <th width="21%" align="left" valign="middle" bgcolor="#d8d1e9">Image</span></th>
                <th width="21%" align="left" valign="middle" bgcolor="#d8d1e9">Category</span></th>
               <?php /*?> <th width="21%" align="left" valign="middle" bgcolor="#d8d1e9">Employment Status</span></th>
                <th width="17%" align="center" valign="middle" bgcolor="#d8d1e9">Purchased Date</th><?php */?>   
                <th width="21%" align="center" valign="middle" bgcolor="#d8d1e9">Action</th>
             
              </tr>
              <?php
              $sql_purchase = mysql_query("SELECT * FROM add_articles WHERE  art_status ='Y' ORDER BY art_id DESC");								
				if (mysql_num_rows ($sql_purchase))
				{
					$intSNo = 1;
					$i = 0;
					while ($arrUsersRow = mysql_fetch_array ($sql_purchase))
					{
						//$sql_updated_user = mysql_query("SELECT * FROM  sai_users WHERE usr_id = ".$arrUsersRow['acc_updated']."");
						//$updated_user_details = mysql_fetch_assoc($sql_updated_user);
															
			?>
              <tr class="<?=$class?>">
                <td align="center"><?=$intSNo?></td>
                <td align="left"><?=$arrUsersRow['art_title']?></td>
                <!-- <td align="left"><?=$arrUsersRow['art_desc']?></td> -->
                <td align="left"><img src="../article_image/<?php echo $arrUsersRow['art_image']; ?>" width="100" height="100" /></td>
                <td align="left"><?=$cats_result_array[$arrUsersRow['art_cat']]?></td>
                <?php /*?><td align="left">
                <?php
				if($arrUsersRow['e_status'] == 1){echo 'Enabled';}else{echo 'Disabled';}
				?>
				</td><?php */?>
                 <td align="center"><a href="add_employee.php?e_id=<?=$arrUsersRow['art_id']?>">Edit</a> 
                 <?php if($_SESSION['usr_id'] == 2)
				 {?>
                  / <a href="employee.php?d_id=<?=$arrUsersRow['art_id']?>">Delete</a>
                 <?php } ?></td>
                 
              </tr>
              <?php				  	
																
					$intSNo++;
				}
			}
			else
			{
				?>
              <tr bgcolor="#EDF7FC">
                <td height="20" colspan="8" align="center" valign="middle" bgcolor="#EDF7FC"><span class="text"><font color='red'><b>No Data Available</b></font></span></td>
              </tr>
		  	<?php
            }
          	?>
            </tbody>
          </table>
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
		