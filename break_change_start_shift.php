<?php

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
echo $times=$_REQUEST[times];
$sub_id=$_REQUEST[sub_id];
$times1=explode('T',$times);
?>

 <input type="datetime-local" class="form-control numeric" name="from"  id="from" onChange="get_total_time_mach_only_break_down(from.value,to.value)"   value="<?php echo $times1[0]."T".$times1[1];  ?>">