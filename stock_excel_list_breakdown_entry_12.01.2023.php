<?php
ini_set('max_execution_time', '0');
error_reporting(0);
ob_start();
session_start(); 
include_once("../model/config.inc.php"); 
include_once("../model/Database.class.php");
include_once("../include/common_function.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$user_type_ids=$_SESSION['user_type_ids'];
$session_user_name=$_SESSION['sess_user_name'];
$session_password=$_SESSION['password'];
$user_types=$_SESSION['user_types'];
$sess_site_id=$_SESSION['sess_site_id'];

function  get_group_id($id){
	$sql=mysql_fetch_array(mysql_query("select group_id from item_creation where id='$id'"));
	return $sql['group _id'];
} ?>
<?php

if($_REQUEST[from_date]!='' && $_REQUEST[to_date]!='' && $_REQUEST[type]=='7'){
  
  $from_date = "entry_date>='$_REQUEST[from_date]'";
 $to_date = "entry_date<='$_REQUEST[to_date]'";
 $site = $_REQUEST['site_name'];
 $break_entry = $_REQUEST['breakdown_type'];

  $filename = "Breakdown Entry" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv");
   // header("Content-Type:application/vnd.ms-excel");

  $out = fopen("php://output", 'w');
  $fields = array('SNO', 'DATE', 'SITE NAME', 'PLANT NAME', 'SHIFT NAME','BREAKDOWN NO','BREAKDOWN ENTRY','FROM TIME','TO TIME','TOTAL TIME','REMARKS');
   fputcsv($out, $fields, ',', '"');

if($sess_site_id=='All' || $sess_site_id=='') 
{
   
   if($site=="" && $break_entry=="")
   {
      
      $aa = mysql_query("SELECT * from breakdown_entry where $from_date and $to_date") ;
   }
   else if($site!="" && $break_entry=="")
   {
        $aa = mysql_query("SELECT * from breakdown_entry where $from_date and $to_date and site_name='$site' ") ;
   }
   else
   {
        $aa = mysql_query("SELECT * from breakdown_entry_sub where $from_date and $to_date and site_name='$site' and breakdown_type = '$break_entry' ") ;
   }
}
else 
{
     if($site=="" && $break_entry=="")
   {
      
      $aa = mysql_query("SELECT * from breakdown_entry where $from_date and $to_date and site_name in ($sess_site_id)") ;
   }
   else if($site!="" && $break_entry=="")
   {
       
        $aa = mysql_query("SELECT * from breakdown_entry where $from_date and $to_date and site_name='$site' ") ;
   }
   else
   {
       
        $aa = mysql_query("SELECT * from breakdown_entry_sub where $from_date and $to_date and site_name='$site' and breakdown_type = '$break_entry' ") ;
   }
}
  while($bb = mysql_fetch_assoc($aa)) {
  $result = mysql_query("select * from breakdown_entry_sub where random_no='$bb[random_no]' and random_sc='$bb[random_sc]'  ") ;
  while($row = mysql_fetch_assoc($result)) {
    $s=$s+1;
    $date=date('d-m-Y',strtotime($bb['entry_date']));
    $site=get_site_name($bb['site_name']);
    $break_no=$bb['breakdown_no'];
    $break_entry=get_breakdown_type($row['breakdown_type']);
    /* $from_time_edit=explode(' ',$fetch_list21['from_time']);
    $to_time_edit=explode(' ',$fetch_list21['to_time']);
    $from_time=$from_time_edit[0].'T'.$from_time_edit[1];
        $to_time=$to_time_edit[0].'T'.$to_time_edit[1];*/

    $from_time=$row['from_time'];
    $to_time=$row['to_time'];
    $total_time=$row['total_time'];
    $remark=$row['remarks'];
   $plant_name=$bb['plant_name'];
   $party_names=mysql_fetch_array(mysql_query("select plant from  plant_creation where id='$plant_name'"));
     
   $shift_name=$bb['shift_name'];
   $sql_sh=mysql_fetch_array(mysql_query("select shift_name from shift_creation where shift_id='$shift_name'"));
    
    $lineData = array($s,$date,$site,$party_names[plant],$sql_sh[shift_name],$break_no,$break_entry,$from_time,$to_time,$total_time,$remark);
 
    fputcsv($out, $lineData, ',', '"');
  }
  }
   
 
  fclose($out);
  exit;
  
}
?>
   <script>
  window.close();
  </script>