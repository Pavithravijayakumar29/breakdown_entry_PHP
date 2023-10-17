<?php 

error_reporting(0);

ob_start();

session_start();

require_once("../model/config.inc.php"); 

require_once("../model/Database.class.php"); 

include_once("../include/common_function.php"); 



$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 



 $ipaddress = $_SESSION['sess_ipaddress'];

 $ses_site=$_SESSION['sess_site_id'];

 $ses_site_name=get_site_name($_SESSION['sess_site_id']);


$date=date("Y");

$st_date=substr($date,2);

$month=date("m");	   

$datee=$st_date.$month; 
$date=date("Y");

$month=date("m");

$year=date("d");

$hour=date("h");

$minute=date("i");

$second=date("s");

$random_sec = date('dmyhis');

$random_no1 = date('his');

$random_no = rand(00000, 99999);
$site_name=$_GET[site_name];
$sql_qr=mysql_fetch_array(mysql_query("select invoice_head from site_creation where id='$site_name'"));
$site_head=$sql_qr[invoice_head];


	$rs1=mysql_query("select breakdown_no from   breakdown_entry where site_name='$site_name' and breakdown_no like '%$site_head%' order by id desc");
	if($res1=mysql_fetch_assoc($rs1))

	{

		$pur_array=explode('-',$res1['breakdown_no']);

	

	   	 $year1=$pur_array[2];

        $year2=substr($year1, 0, 2);

	    $year='20'.$year2;
$enquiry_no=$pur_array[3];

	}

	if($enquiry_no=='')
{
		$enquiry_nos='BRDN-'.$site_head."-".$datee.'-0001';
 //$ran_no='BRDN'.$site_head.$datee."0001".$random_no.$random_no1;

}
	elseif($year!=date("Y"))
{
		$enquiry_nos='BRDN-'.$site_head."-".$datee.'-0001';
 //$ran_no='BRDN'.$site_head.$datee."0001".$random_no.$random_no1;

}
	else

	{

		$enquiry_no+=1;

		$enquiry_nos='BRDN-'.$site_head."-".$datee.'-'.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT);
 	
//$ran_no='BRDN'.$site_head.$datee.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT).$random_no.$random_no1;

}

if($edit_id1!='')

{

  $enquiry_num= $enquiry_nosss;

}

?>

<div class="col-sm-2">
					<input type="hidden" readonly name="breakdown_no" id="breakdown_no" class="text_box" style="font-size:12px" value="<?php  echo $enquiry_nos;?>" /><strong> <span style="color:#FF0000;"><strong><?php  echo $enquiry_nos;?></strong></span>
 
   </div>