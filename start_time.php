<?php

require("../model/config.inc.php");

require("../model/Database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

$db->connect();

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$entry_date = $_REQUEST['entry_date'];
$random_no = $_REQUEST['random_no'];
$random_sc = $_REQUEST['random_sc'];
$breakdown_no = $_REQUEST['breakdown_no'];
$sub_id = $_REQUEST['sub_id'];

$from_date = strtotime($from);
$to_date = strtotime($to);
$entry_date_sh = explode('T', $_REQUEST['entry_date']);
$entry_date = $entry_date_sh[0];

if ($sub_id != '') {

	$start_time = mysql_fetch_array(mysql_query("select from_time,to_time from breakdown_entry_sub where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and id!='$_POST[sub_id]' order by id desc"));
} else {

	$start_time = mysql_fetch_array(mysql_query("select from_time,to_time from breakdown_entry_sub where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]'  order by id desc"));
}
$count = mysql_num_rows(mysql_query("select id from breakdown_entry_sub where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]'"));
$start_t = date('Y-m-d H:i', strtotime($start_time['from_time']));
$end_t = date('Y-m-d H:i', strtotime($start_time['to_time']));

$start_val = explode(' ', $start_t);
$start_date = strtotime($start_val[0] . "T" . $start_val[1]);
$end_val = explode(' ', $end_t);
$end_date = strtotime($end_val[0] . "T" . $end_val[1]);
$end = $end_val[0] . "T" . $end_val[1];
if ($count > 0) {
	///////////////////
	if ($end_date <= $from_date && $end_date <= $to_date && $from_date <= $to_date) {

		$final = "1";
	} else {
		$final = "0";
	}
	///////////////////
} else {
	$final = "1";
}

echo $data = $final . "@@" . $end;

//echo $data=$start_count."@@".$s_one."@@".$s_two."@@".$s_three."@@".$start_value['start_time']."@@".$start_value['end_time']."@@".$_POST['start_time'];  
?>
 <?php

	?>
