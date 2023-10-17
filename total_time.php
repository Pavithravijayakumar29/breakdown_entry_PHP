<?php

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 

  $start_time=$_POST['start_time'];

 $end_time=$_POST['end_time'];

$shift_name=$_POST['shift_name'];

$st_time=strtotime($start_time);

$en_time=strtotime($end_time);
// echo  $st_time.'<br>';
// echo  $en_time.'<br>';
// echo ($st_time);
// echo ($en_time);
if($shift_name=='2')
{
   if($st_time<$en_time)
   {
        $total_time=date("H:i", strtotime("00:00") + ($en_time-$st_time));
   }
   else
   {
	    $total_time="0:00";  
   }
}
elseif($shift_name=='5'){

   if($st_time<$en_time)
   {
        $total_time=date("H:i", strtotime("00:00") + ($en_time-$st_time));
   }
   else
   {
        $total_time="0:00";  
   }
}
//   if($st_time>$en_time)
//   {
//   $total_time=date("H:i", strtotime("00:00") + ($en_time-$st_time));
//   }
//   else
//$total_time=   sprintf('%02d:%02d', (int) $tot_time, fmod($tot_time, 1) * 60); 

?>

  <input type="text" class="form-control numeric" style="text-align:right;" name="total" id="total"  value="<?php echo $total_time; ?>" readonly >