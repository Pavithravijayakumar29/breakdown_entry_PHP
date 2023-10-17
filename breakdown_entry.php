<?php

error_reporting(0);

ob_start();

session_start();

require("config.inc.php"); 

require("Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 

$action = $_GET['action'];

$data = $_POST;



$ses_site=$_SESSION['sess_site_id'];

$user_id_ses=$_SESSION['sess_user_id'];

$ipaddress = $_SESSION['sess_ipaddress'];



////////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_breakdown_entry_no()

{

$date=date("Y");

$st_date=substr($date,2);

$month=date("m");	   

$datee=$st_date.$month;



$rs1=mysql_query("select breakdown_no from breakdown_entry order by id desc");

	if($res1=mysql_fetch_assoc($rs1))

	{

		$pur_array=explode('-',$res1['breakdown_no']);

	

	    $year1=$pur_array[1];

        $year2=substr($year1, 0, 2);

	    $year='20'.$year2;

		$enquiry_no=$pur_array[2];

	}

	if($enquiry_no=='')

		$enquiry_nos='BRDN-'.$datee.'-0001';

	elseif($year!=date("Y"))

		$enquiry_nos='BRDN-'.$datee.'-0001';

	else

	{

		$enquiry_no+=1;

		$enquiry_nos='BRDN-'.$datee.'-'.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT);

	}

	

	return 	$enquiry_nos;

}



		$stat=mysql_fetch_array(mysql_query("select * from site_creation where id='$_POST[site_name]'"));

 

//////////////////////////////////////////////////////////////////////////////////////////////////

switch ($action) {

	 case "SUBMIT":

	 $lock=mysql_query("LOCK TABLES breakdown_entry WRITE");

    $breakdown_no=get_breakdown_entry_no();

  
   $sql3 = "SELECT * FROM breakdown_entry WHERE random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and  breakdown_no='$_POST[breakdown_no]' ";

		$row = $db->query($sql3); 

		

		if($db->affected_rows === 0)

		{

    $Insql=mysql_query("insert into  breakdown_entry(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_time) values ('$_POST[random_no]','$_POST[random_sc]','$breakdown_no','$_POST[entry_date]','$_POST[site_name]','$_POST[shift_name]','$_POST[user_name]','$_POST[overall_tot]')");

		}
		else
		{
     $Insql=mysql_query("update breakdown_entry set entry_date='$_POST[entry_date]',site_name='$_POST[site_name]',shift_name='$_POST[shift_name]',user_name='$_POST[user_name]',overall_time='$_POST[overall_tot]' where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]'");
		}
		$unlock=mysql_query("UNLOCK TABLES");
    break;


    case "UPDATE":


   $Insql=mysql_query("update breakdown_entry set random_no='$_POST[random_no]',random_sc='$_POST[random_sc]',breakdown_no='$_POST[breakdown_no]',entry_date='$_POST[entry_date]',site_name='$_POST[site_name]',shift_name='$_POST[shift_name]',user_name='$_POST[user_name]',overall_time='$_POST[overall_tot]' where id='$_GET[update_id]'");

	

	 $Insql=mysql_query("update breakdown_entry_sub set entry_date='$_POST[entry_date]',site_name='$_POST[site_name]',shift_name='$_POST[shift_name]' where breakdown_no='$_POST[breakdown_no]'");

	

   break;

   case "UPDATE_APPROVAL":



 $Insql=mysql_query("update breakdown_entry set approved_date_time='$_POST[apprve_date_time]',approved_by='$_POST[apprve_by]',approved_status='$_POST[apprved_status]',remarks='$_POST[remarks]' where id='$_GET[update_app_id]'");

	

	

   break;

   

 	 case "delete":

   $pur_delete="delete from breakdown_entry where id='$_GET[delete_id]'";

   mysql_query($pur_delete);

  echo $pur_delete2="delete from breakdown_entry_sub where breakdown_no='$_GET[breakdown_no]' ";

   mysql_query($pur_delete2);

 
break;

   

	   case "ADD":

       
    $breakdown_no=get_breakdown_entry_no();

  
   $sql3 = "SELECT * FROM breakdown_entry WHERE random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and  breakdown_no='$_POST[breakdown_no]' ";
         $row = $db->query($sql3); 

		if($db->affected_rows === 0)
          {

    $Insql=mysql_query("insert into  breakdown_entry(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_time) values ('$_POST[random_no]','$_POST[random_sc]','$breakdown_no','$_POST[entry_date]','$_POST[site_name]','$_POST[shift_name]','$_POST[user_name]','$_POST[overall_tot]')");
         }
		else
		{
     $Insql=mysql_query("update breakdown_entry set entry_date='$_POST[entry_date]',site_name='$_POST[site_name]',shift_name='$_POST[shift_name]',user_name='$_POST[user_name]',overall_time='$_POST[overall_tot]' where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]'");
		}

      

	    $date12=$_POST['entry_date'];
	    $exp_date=explode("T",$date12);
	    $date1=$exp_date[0];
	    $time1=$exp_date[1];
	    $from = $_POST['from'];
	    $sft_start_time = $_POST['sft_start_time'];
	    $to = $_POST['to'];
	    $sft_end_time = $_POST['sft_end_time'];
	    
	    $sql3 = "SELECT * FROM breakdown_entry WHERE random_no!='$_POST[random_no]' and random_sc!='$_POST[random_sc]' and  site_name='$_POST[site_name]' and shift_name='$_POST[shift_name]' and date_format(entry_date,'%Y-%m-%d')='$date1'";

		$row = $db->query($sql3); 

		

		if($db->affected_rows === 0)

		{
       
       $value_date = mysql_fetch_array(mysql_query("select * from breakdown_entry_sub where random_no = '$_POST[random_no]' and random_sc = '$_POST[random_sc]' and breakdown_type = '$_POST[breakdown_type]' "));
 			
 			$to_time = explode(' ',$value_date[to_time]);
 			$from_date = explode('T', $_POST[from]);
 			// echo $to_time[1]."<br>";
 			// echo $from_date[1]."<br>";

if($to_time<=$from_date)
		{
    	//echo"hai";
       $Insql="insert into  breakdown_entry_sub(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,from_time,to_time,total_time,remarks,breakdown_type) values ('$_POST[random_no]','$_POST[random_sc]','$_POST[breakdown_no]','$_POST[entry_date]','$_POST[site_name]','$_POST[shift_name]','$_POST[from]','$_POST[to]','$_POST[total]','$_POST[remarks]','$_POST[breakdown_type]')";
    

 $mysql=mysql_query($Insql);

        }
        else
			echo "<span class=text-danger>You have Already Make an Entry for this duration</span>";
	
 }
 else

			echo "<span class=text-danger>You Already Make An Entry For ".date('d-m-Y',strtotime($_POST['entry_date']))."</span>";



	include("../breakdown_entry/breakdown_sublist.php");



    break;

	

	 case "EDIT":

	    $date12=$_POST['entry_date'];
	    $exp_date=explode("T",$date12);
	    $date1=$exp_date[0];
	      $time1=$exp_date[1];

	

	   	$sql = "SELECT * FROM breakdown_entry_sub WHERE site_name='$_POST[site_name]' and shift_name='$_POST[shift_name]' and date_format(entry_date,'%Y-%m-%d')='$date1'  and id!='$_GET[sub_id]' and breakdown_type='$_POST[breakdown_type]'";

		$row = $db->query($sql); 

		

		if($db->affected_rows === 0)

		{
  $Insql=mysql_query("update breakdown_entry_sub set breakdown_no='$_POST[breakdown_no]',entry_date='$_POST[entry_date]',site_name='$_POST[site_name]',shift_name='$_POST[shift_name]',from_time='$_POST[from]',to_time='$_POST[to]',remarks='$_POST[remarks]',total_time='$_POST[total]',breakdown_type='$_POST[breakdown_type]' where id='$_GET[sub_id]' ");

        }else

			echo "<span class=text-danger>Already Exit</span>";

     include("../breakdown_entry/breakdown_sublist.php");


	


$_GET['sub_id']='';

  break;



     	 case "delete_sub":

    
   $pur_delete="delete from breakdown_entry_sub where id='$_GET[delete_id]' ";

   mysql_query($pur_delete);

   

	include("../breakdown_entry/breakdown_sublist.php");



   break;





}

$db->close();



?>