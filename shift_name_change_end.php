<?php

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
// ''
$date_value = explode('T',$_POST['date_value']);
$shift=mysql_fetch_array(mysql_query("select *,end_time from shift_creation  where shift_id='$_POST[shift_time]' "));

if($shift['shift_name']=='Morning Shift')
{
	$date = $date_value[0];
}
elseif($shift['shift_name']=='Night Shift')
{
	$date = date('Y-m-d', strtotime('+1 day', strtotime($date_value[0])));
}
?>
 <input type="datetime-local" class="form-control numeric" name="to"  id="to" onChange="get_total_time_mach_only_break_down(from.value,to.value)"   value="<?php echo $date.'T'.$shift['end_time'];  ?>">