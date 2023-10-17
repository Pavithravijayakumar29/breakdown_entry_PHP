<?php 
error_reporting(0);
ob_start();
session_start();  

require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
include_once("../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 
$company=get_company_name();
$sess_site_id=$_SESSION['sess_site_id'];
$site_name_head=get_site_name($_GET[site_name]);
$plant_name_head=get_plant_name($_GET[plant_name]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.top{ border-top: 1px solid #ccc;}
.bottom{ border-bottom: 1px solid #ccc;}
.top1{ border-top: 2px solid #ddd;}
.title{font-family:calibri; font-family:calibri; font-size:24px; color:#333; }
.address{font-family:calibri; font-family:calibri; font-size:18px; color:#333; }
.main{font-family:calibri; font-family:calibri; font-size:16px; font-weight:600; color:#333; }
.main2{font-family:calibri; font-family:calibri; font-size:16px; color:#333; font-weight:600;}
.data{font-family:calibri; font-family:calibri; font-size:16px; color:#111; }
</style>
</head>

<body>
<br />
<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
    <td width="114" rowspan="3"><img src="../image/logo_print.png" height="80" width="80" /></td>
    <td width="580" height="30" class="title" style=" font-weight:900; font-size:24px">&nbsp;<?php echo $company[0]; ?></td>
    <td width="156" align="right"></td>
</tr>
<tr>
    <td height="20" class="address">&nbsp;<?php echo $company[1]; ?></td>
    <td align="right" class="main"></td>
</tr>
<tr>
    <td height="20" class="address">&nbsp;<?php echo $company[3]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $company[4]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $company[5]; ?></td>
    <td align="right" class="main"></td>
</tr>
<tr>
    <td height="5" colspan="3" align="center" class="main"></td>
</tr>
<tr>
    <td height="25" colspan="3" align="center" class="main top1" valign="bottom"><strong>POWER CONSUMED (KWH)</strong></td>
</tr>
</table>

<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">
<tr><td colspan="7" height="10"></td></tr>
  <tr>
    <td width="43" height="25" scope="col">&nbsp;</td>
    <td width="129" align="left" class="main"><strong>&nbsp;From Month&nbsp;</strong></td>
    <td width="23" align="center" class="main">&nbsp;:</td>
    <td width="308" align="left" class="data"><?php if($_GET[from_date]!=''){ echo date('M-Y',strtotime($_GET[from_date]));}else{ echo date('M-Y');} ?></td>
    <td width="118" align="left" class="main"><strong>&nbsp;</strong></td>
    <td width="21" align="center" class="main">&nbsp;</td>
    <td width="208" align="left" class="data"></td>
  </tr>
  
 
<th>&nbsp;</th>
<th colspan="6" align="center">&nbsp;</th>
</tr>
</table>

<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
    <th width="4%" height="35" class="top main bottom">S.No</th>
    <th width="14%" class="top main bottom" align="left">&nbsp;Date</th>
    <th width="18%" class="top main bottom" align="left">&nbsp;Reading No </th>
    <th width="20%" class="top main bottom" align="left">&nbsp;Site Name </th>
    <th width="13%" class="top main bottom" align="left">&nbsp;Plant Name</th>
    <th width="12%" class="top main bottom" align="right">Total Reading&nbsp;</th>
    </tr>
  <?php 
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
$site_name=$_GET['site_name'];
$plant_name=$_GET['plant_name'];
  
$cur_mnth=date('Y-m');
  
			
					
   $s_no=0;
   $sql122="select * from   site_creation where site_status='1'  order by id ASC";
	 $rs122=mysql_query($sql122);
	 while($rsdatas=mysql_fetch_object($rs122))
     {
    $s_nos=$s_nos+1;
    $site_id=$rsdatas->id;
     $site_name=$rsdatas->site_name;
	?>
     <tr>
          <td colspan="9" style="background-color:#DCDCDC; color:" align="left" class=" main">&nbsp;<?php echo $site_name; ?></td>
    </tr>
 <?php
   
   $sql1="select reading_no as Invoice,site_name as site_name,plant_name as plant_name,reading_date as reading_date,total_reading as total_reading from   panel_reading_entry_sub where site_name='$site_id' and entry_date='$cur_mnth' 
   UNION
   select reading_no as Invoice,site_name as site_name,plant_name as plant_name,reading_date as reading_date,total_reading as total_reading from   genset_reading_entry_sub where site_name='$site_id' and entry_date='$cur_mnth'
   ";

	 $rs12=mysql_query($sql1);
	 while($rsdata=mysql_fetch_object($rs12))
     {
   $s_no=$s_no+1;
   $entry_date=$rsdata->entry_date ;
   $Invoice=$rsdata->Invoice ;
    $reading_no=$rsdata->reading_no ;
   $total_reading=$rsdata->total_reading ;
    $reading_date=$rsdata->reading_date ;
	$description=$rsdata->description ;	
   $plant_id=$rsdata->plant_name ;
	$plant_name=get_plant_name($plant_id);
     $site_id=$rsdata->site_name ;	
	$site_name=get_site_name($site_id);
   ?>
  <tr>
    <td align="left" height="27" class="data"><?php echo $s_no; ?></td>
    <td align="left" class="data">&nbsp;<?php echo date("d-m-Y",strtotime($reading_date)); ?></td>
    <td align="left" class="data">&nbsp;<?php echo $Invoice?></td>
    <td align="left" class="data">&nbsp;<?php echo $site_name?></td>
    <td align="left" class="data">&nbsp;<?php echo $plant_name;?></td>
    <td align="right" class="data"><?php echo number_format($total_reading,4);?>&nbsp;</td>
  </tr>
  
 <?php
  $tot_total_reading+=$total_reading;
  $tot_total_reading_site_wise+=$total_reading;

	 }
	 ?>
     <tr>
     <td colspan="5" style="" align="right" class=" main">&nbsp;Total</td>
     <td colspan="" style="" align="right" class=" main">&nbsp;<?php echo number_format($tot_total_reading_site_wise,4); ?></td>
  </tr>
     <?php 
	 $tot_total_reading_site_wise=0;
	 }?>

<tr>
<td height="30" colspan="4" class="top">&nbsp;</td>
<td width="13%" align="right" class=" top main">Total Reading&nbsp;</td>
<td width="12%" align="right" class=" top data"><?php echo number_format($tot_total_reading,4);?>&nbsp;</td>
</tr>

  <tr>
  <td height="25" colspan="7" align="right" class=" style10 style4 top data "> Printed Date&nbsp;:&nbsp;<?php echo date('d-m-Y'); ?></td>
  </tr>
</table>
</body>
</html>
