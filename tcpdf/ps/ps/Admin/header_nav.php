<?php
$cuur_page = substr($_SERVER['SCRIPT_FILENAME'], strrpos($_SERVER['SCRIPT_FILENAME'], "/"), 250);

$se_trn_entry = '';
$trn_entry_pages = array("employee.php", "add_employee.php", "employee_personal_detials.php", "add_per_detials.php","per_detials_view.php","employee_contact.php","add_con_detials.php","con_detials_view.php","employee_emergency.php","add_emer_cntdetials.php","employee_immigration.php","add_imm_detials.php","imm_detials_view.php","employee_details.php","add_emply_detials.php","emply_detials_view.php","add_interview.php","interview_details.php","advertise.php", "add_adv_detials.php", "adv_detials_view.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_trn_entry = 'navselect'; 
}
$se_sale_entry = '';
$trn_entry_pages = array("advertise.php", "add_adv_detials.php", "adv_detials_view.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_sale_entry = 'navselect'; 
}

$se_labour_entry = '';
$trn_entry_pages = array("labour.php", "add-labour.php", "labour_view.php", "labour_category.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_labour_entry = 'navselect'; 
}

$se_cash_entry = '';
$trn_entry_pages = array("cash.php", "add-cash.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_cash_entry = 'navselect'; 
}

$se_work_entry = '';
$trn_entry_pages = array("work-progress.php", "work-progress-add.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_work_entry = 'navselect'; 
}

$se_planning_entry = '';
$trn_entry_pages = array("planning-expenditure.php", "planning-expenditure-add.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_planning_entry = 'navselect'; 
}

$se_reports_entry = '';
$trn_entry_pages = array("reports.php", "outstanding.php", "work_progress_report.php", "cash_all_report.php", "transaction_reports.php");
if(in_array(trim($cuur_page, "/"), $trn_entry_pages))
{
	$se_reports_entry = 'navselect'; 
}
?>	
    <nav>         
      <ul>
        <li><a href="index.php" >Home</a> </li>
        <li class="<?php echo $se_trn_entry; ?>"><a href="employee.php">Article</a></li>
       <?php /*?> <li class="<?php echo $se_labour_entry; ?>"><a href="labour.php">Labour</a></li>        
        <li class="<?php echo $se_cash_entry; ?>"><a href="cash.php">Cash</a></li>
        <li class="<?php echo $se_work_entry; ?>"><a href="work-progress.php">Work Progress</a></li>
        <li class="<?php echo $se_planning_entry; ?>"><a href="planning-expenditure.php">Planning</a></li>
        <li class="<?php echo $se_reports_entry; ?>"><a href="reports.php">Reports</a></li><?php */?>
        
        <li><a href="logout.php">Logout</a></li>        
      </ul>
    </nav>