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

$site_name_head=get_site_name($_GET['site_name']);

$breakdown_type=$_GET['breakdown_type'];
$site=$_REQUEST['site'];

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
  
<tr><td  width="121" rowspan="3"></td>

    <td width="103" rowspan="3"><img src="../image/logo_print.png" height="80" width="80" /></td>

    <td width="491" height="30" class="title" style=" font-weight:900; font-size:24px">&nbsp;<?php echo $company[0]; ?></td>

    <td width="135" align="right"></td>


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
    <td height="25" colspan="3" align="center" class="main top1" valign="bottom"><strong>BREAKDOWN ENTRY</strong></td>

</tr>

</table>



<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">

<tr><td colspan="7" height="10"></td></tr>

  <tr>

    <td width="43" height="25" scope="col">&nbsp;</td>

    <td width="129" align="left" class="main"><strong>&nbsp;From Date&nbsp;</strong></td>

    <td width="23" align="center" class="main">&nbsp;:</td>

    <td width="308" align="left" class="data"><?php if($_GET['from_date']!=''){ echo date('d-m-Y',strtotime($_GET['from_date']));}else{ echo date('d-m-Y');} ?></td>

    <td width="118" align="left" class="main"><strong>To Date&nbsp;</strong></td>

    <td width="21" align="center" class="main">&nbsp;:</td>

    <td width="208" align="left" class="data"><?php if($_GET['to_date']!='') {echo date('d-m-Y',strtotime($_GET['to_date']));} else{ echo date('d-m-Y');}  ?></td>

  </tr>

   <tr>

    <td width="43" height="25" scope="col">&nbsp;</td>

    <td width="129" align="left" class="main"><strong>&nbsp;Site Name</strong></td>

    <td width="23" align="center" class="main">&nbsp;:</td>

    <td width="308" align="left" class="data"> <?php 

if($_GET[site_name]!=''){

                  $value=explode(',',$_GET[site_name]);
                   for($i=0;$i<count($value);$i++){
                    

                    echo get_site_name($value[$i]);
                   
                    if($i<(count($value)-1)) {
                    echo ",";
                   }

                   }
 }else{echo "All";}
?></td>


<td width="118" align="left" class="main"><strong>Plant Name</strong></td>

    <td width="21" align="center" class="main">&nbsp;:</td>

    <td width="208" align="left" class="data"><?php if($sess_site_id=='All')

{ if($_GET['plant_name']!=''){

                  $list_name=explode(',',$_GET['plant_name']);
                   for($j=0;$j<count($list_name);$j++){
                    
                      $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$list_name[$j]'"));
                     echo  $party_names['plant'];
                  
                   
                    if($j<(count($list_name)-1)) {
                    echo ",";

                   }

                   }
 }else{echo "All";}}

 else{ 
  /*$party_names_1=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE site_id='$sess_site_id'"));
                     echo  $party_names_1['plant'];*/
     if($_GET[plant_name]!=''){
       $list_name=explode(',',$_GET[plant_name]);
                   for($j=0;$j<count($list_name);$j++){
                    
                      $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$list_name[$j]'"));
                     echo  $party_names['plant'];
                  
                   
                    if($j<(count($list_name)-1)) {
                    echo ",";

                   }

                   }
     }else{echo "ALL";}

}?>

  </tr>

 <tr>

    <td width="43" height="25" scope="col">&nbsp;</td>
  <td width="129" align="left" class="main"><strong>&nbsp;Type</strong></td>

    <td width="23" align="center" class="main">&nbsp;:</td>

    <td width="308" align="left" class="data"> <?php /*if($_GET[breakdown_type]=='Mechanical Section'){ echo "Mechanical Section";} elseif($_GET[breakdown_type]=='Operational Section') { echo "Operational Section";}  elseif($_GET[breakdown_type]=='Electrical Section') { echo "Electrical Section";}*/
    $sql12=mysql_fetch_array(mysql_query("select * from  breakdown_type_creation where  breakdown_id='$_GET[breakdown_type]' order by breakdown_id asc"));
if($_GET[breakdown_type]!=''){
    if($_GET[breakdown_type]==$sql12[breakdown_id]){ 
      echo $sql12[breakdown_type];
    }
    else{echo "ALL";}
  }
    else{echo "ALL";}?></td>
<!-- 
       <td width="129" align="left" class="main"><strong>&nbsp;Status</strong></td>

    <td width="23" align="center" class="main">&nbsp;:</td>

    <td width="308" align="left" class="data"> <?php if($_GET[status]=='' || $_GET[status]=='0'){ echo "Pending";} else { echo   "Verified"; } ?> -->

<?php if($site=='site'){?>
    <td width="118" align="left" class="main"><strong>Status</strong></td>

    <td width="21" align="center" class="main">&nbsp;:</td>

    <td width="208" align="left" class="data"><?php if($_GET[status]=='' || $_GET[status]=='0'){ echo "Pending";} else { echo   "Verified"; } ?>
</td>
<?php } ?>

  </tr>

 

<tr>

<th>&nbsp;</th>

<th colspan="6" align="center">&nbsp;</th>

</tr>

</table>



<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">

    <tr>

    <th width="5%" height="35" class="top main bottom">S.No</th>

    <th width="12%" class="top main bottom" align="center">&nbsp;Date</th>

    <th width="23%" class="top main bottom" align="left">&nbsp;Breakdown No </th>

    <th width="18%" class="top main bottom" align="left">&nbsp;Site Name </th>

        <th width="17%" class="top main bottom" align="left">&nbsp;Plant Name </th>


    <th width="15%" class="top main bottom" align="left">&nbsp;Shift Name</th>

    <th width="10%" class="top main bottom" align="right">Total Time&nbsp;</th>

    

    </tr>

  <?php 

$from_date=$_GET['from_date'];

$to_date=$_GET['to_date'];

$site_name=$_GET['site_name'];

$plant_name=$_GET['plant_name'];


$status=$_GET['status'];


$breakdown_type=$_GET['breakdown_type'];

$current_date=date('Y-m-d');

  

if($_REQUEST['site']=='site')
{
if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}

if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}
else
{
    if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}

if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

//if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}

$all_value10 = $from_date1."@".$to_date1."@".$site_name1."@".$breakdown_type1."@".$status1."@".$plant_name1;;



$all_array10 = explode('@',$all_value10);

  

foreach($all_array10 as $value10)

{ 

if($value10!='')

{

  $get_query131 .= $value10." AND ";

}

}
if($sess_site_id=='All')
        {


  $sql1="select *,a.id as main_id from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' group by a.breakdown_no order by a.id asc";
}
else
{

 $sql1="select *,a.id as main_id from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($sess_site_id) group by a.breakdown_no order by a.id asc";
}
$rows1 = $db->fetch_all_array($sql1);

foreach($rows1 as $record)

{

 $site_id=$record['site_name']; 

 

 $site_name=get_site_name($site_id);

 
  $breakdown_no=$record['breakdown_no']; 

  $random_no=$record['random_no']; 

  $random_sc=$record['random_sc']; 
  $breakdown_type=$record['breakdown_type'];
  $shift_name=get_shift_name($record['shift_name']);
  $overall_time=$record['overall_time'];

      $plant_name1=$record['plant_name'];
  $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$plant_name1'"));
  $plant_id11= $party_names['plant'];


  ?>

    <tr>

    <td align="left" height="27" class="data"><?php echo $s_no=$s_no+1; ?></td>

    <td align="left" class="data">&nbsp;<?php echo date("d-m-Y",strtotime($record['entry_date'])); ?></td>

    <td align="left" class="data">&nbsp;<?php echo $breakdown_no?></td>

    <td align="left" class="data">&nbsp;<?php echo $site_name?></td>
    <td ><?php if($plant_id11!=''){echo $plant_id11;}else{ echo "---";} ?>&nbsp;</td>


    <td align="left" class="data">&nbsp;<?php echo $shift_name;?></td>

    <td align="right" class="data"><?php echo $overall_time;?>&nbsp;</td>

   

  </tr>

  

 <?php

  

   }?>






  <tr>

  <td height="25" colspan="9" align="right" class=" style10 style4 top data "> Printed Date&nbsp;:&nbsp;<?php echo date('d-m-Y'); ?></td>

  </tr>

</table>

</body>

</html>

