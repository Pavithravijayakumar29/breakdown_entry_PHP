<?php 

error_reporting(0);

ob_start();

session_start();

require_once("../model/config.inc.php"); 

require_once("../model/Database.class.php"); 

include_once("../include/common_function.php"); 



$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 


$current_time=date('H:i');
$default_time="08:00";
$cur_t=strtotime($current_time);
$def_t=strtotime($default_time);
$e_date=explode('T',$_POST[entry_date]);
$entry_date=$e_date[0];
$current_date=date('Y-m-d');
$prev_date = date('Y-m-d', strtotime("-1 days"));
$pre_d=strtotime($prev_date);
$cur_d=strtotime($current_date);
$ent_d=strtotime($entry_date);

if(($ent_d<=$cur_d)){
	
		$date=$entry_date;
		$val='0';
	}else{
	$val='1';
$date=date('Y-m-d').'T'.date('H:i');
}
echo $change=$date."@@".$val;
?>