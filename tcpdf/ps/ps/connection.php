<?php
session_start();
	ob_start();
	error_reporting(0); 
	
//error_reporting(E_ALL & ~E_NOTICE);
$_SERVER['SERVER_ADDR'];

if($_SERVER['HTTP_HOST'] == "snehahastamsociety.org")// || 1==1
{
	//echo "inn";
$con = mysql_connect("localhost","snehahas_hastam","=T*9*GJhykJ=");
mysql_select_db("snehahas_hastam",$con);
}
else
{
	//echo "test";
$con = mysql_connect("localhost","root","");
mysql_select_db("studio",$con);
}
$PATH = "http://www.snehahastamsociety.org/";
$DOMAIN_NAME = "Sneha Hastam Development Society";
?>

