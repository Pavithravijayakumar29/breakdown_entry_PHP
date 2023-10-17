<?php 

error_reporting(0);

ob_start();

session_start();

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
$random_no=$_REQUEST['random_no'];
$random_sc=$_REQUEST['random_sc'];

$count=mysql_num_rows(mysql_query("select * from breakdown_entry where  random_no='$random_no' and random_sc='$random_sc'"));
$data=mysql_fetch_array(mysql_query("select id from breakdown_entry where  random_no='$random_no' and random_sc='$random_sc'"));

$count1=mysql_num_rows(mysql_query("select * from breakdown_entry_sub where  random_no='$random_no' and random_sc='$random_sc'"));
echo $count."@@".$data['id']."@@".$count1;
?>