<?php

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
// ''
  $shift_name=$_POST['shift_name'];

$time_get = mysql_fetch_array(mysql_query("select *,start_time,end_time from shift_creation where shift_id = '$shift_name' "));
$date_value = explode('T',$_POST['date_value']);


if($time_get['shift_name']=='Morning Shift')
{
	$date = $date_value[0];
}
elseif($time_get['shift_name']=='Night Shift')
{
	$date = date('Y-m-d', strtotime('+1 day', strtotime($date_value[0])));
}
?>
<!-- '' -->
  <input type="hidden" name="sft_start_time" id="sft_start_time" value="<?php echo $date_value[0].'T'.$time_get['start_time'];?>"/>
<input type="hidden" name="sft_end_time" id="sft_end_time" value="<?php echo $date.'T'.$time_get['end_time'];?>"/>