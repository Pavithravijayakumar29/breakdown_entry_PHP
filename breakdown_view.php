	
   <link rel="stylesheet" type="text/css" href="jquery-ui-1.8.17.custom.css">
    <link rel="stylesheet" type="text/css" href="main.css">

    <!--<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
    <script type="text/javascript" src="jspdf.debug.js"></script> -->
<!-- 	<div id="content2" style="background: #fff;padding: 15px;width: 80%;margin: 0 ;position: relative;overflow: hidden;margin-top: 15px;"> -->
	<?php 

	error_reporting(0);

	require("../model/config.inc.php"); 

	require("../model/Database.class.php"); 

	include_once("../include/common_function.php");

	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

	$db->connect(); 

	$company=get_company_name();

	function total_bd_times($times) {

    // loop throught all the times
    foreach ($times as $time) {
    
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}

	?>

	

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml">

	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	

	<title>Untitled Document</title>

	<style type="text/css">

	.style10{ border-top: dotted 1px; border-top-color:#999;}

	.style1{font-weight:bold; text-align:right;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}

	.style2{font-weight:normal;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}

	.style3{color:#F00;}

	.style4{font-weight:normal;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;}

	.style5 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-weight: bold;

	font-size: 14px;

	}

	.top{ border-top: 1px dotted #999;}

	.bottom{ border-bottom: 1px dotted #999;}

	.title{font-family:calibri; font-family:calibri; font-size:28px; color:#333; }

	.address{font-family:calibri; font-family:calibri; font-size:20px; color:#333; }

	.main{font-family:calibri; font-family:calibri; font-size:18px; font-weight:600; color:#666; }

	.data{font-family:calibri; font-family:calibri; font-size:15px; color:#333; }</style>

	</head>

	

	<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

  

  

  <tr><td  width="195" rowspan="3"></td>

    <td width="102" rowspan="3"><img src="../image/logo_print.png" height="80" width="80" /></td>

    <td width="689" height="30" class="title" style=" font-weight:900; font-size:24px">&nbsp;<?php echo $company[0]; ?></td>

    <td width="19" align="right"></td>


</tr>

<tr>

    <td height="20" class="address">&nbsp;<?php echo $company[1]; ?></td>

    <td align="right" class="main"></td>

</tr>

<tr>

    <td height="20" class="address">&nbsp;<?php echo $company[3]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <?php echo $company[4]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $company[5]; ?></td>

    <td align="right" class="main"></td>

</tr>

<tr>

    <td height="5" colspan="3" align="center" class="main top"></td>

</tr>


  <tr><td colspan="2" align="center"></td></tr>

  </table>
	

	 
	<center>

	</center>
	<style>
		.logo_header
		{
			margin:auto;
			width:50% !important;	
		}
	</style>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">

	<tr>

	<th scope="col">&nbsp;</th>

	<th width="25%" align="left" scope="col">&nbsp;</th>

	

	<th  align="center" scope="col" colspan="3" class="main"><strong>Breakdown Entry View &nbsp;</strong></th>

	<th  align="left"scope="col">&nbsp;</th>

	</tr>

	<tr>

	<th scope="col">&nbsp;</th>

	<th width="25%" align="left" scope="col">&nbsp;</th>

	<th  align="left"scope="col">&nbsp;</th>

	<th  align="center"scope="col" colspan="3">&nbsp;</th>

	<th  align="left"scope="col">&nbsp;</th>

	

	</tr>

	<tr>

	<th width="9%" height="33" scope="col">&nbsp;</th>

	<?php 

	$date=date("Y");

$st_date=substr($date,2);

$month=date("m");	   

$datee=$st_date.$month;

$sess_user_id=$_SESSION['sess_user_id'];

 $session_user_name=$_SESSION['sess_user_name'];

 $user_type_ids=$_SESSION['user_type_ids'];

 $user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];



$sql = "SELECT * FROM   breakdown_entry  where id='$_GET[main_id]' ";

$rows = $db->fetch_all_array($sql);

foreach($rows as $record)

{

	$random_nos = $record['random_no'];

	$random_scs = $record['random_sc'];

	$breakdown_no = $record['breakdown_no'];

	$entry_date  = $record['entry_date'];

	$site_name_edit = get_site_name($record['site_name']);

	$shift_name_edit =get_shift_name($record['shift_name']);

  $user_name_edit = $record['user_name'];

	 $staff_name=get_staff_name($user_name_edit);

$plant_name1=$record['plant_name'];
  $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$plant_name1'"));
  $plant_id11= $party_names['plant'];
  
}

	?>

	

	<td align="left" width="25%" class="main" scope="col"><strong>&nbsp;Breakdown No</strong></td>

	<td width="5%" class="main"  align="center"scope="col">&nbsp;:</td>

	<td width="21%" class="data"  align="left"scope="col"><?php echo $breakdown_no;?></td>

	
 
	<td width="18%"class="main" align="left"scope="col"><strong>&nbsp;Date </strong></td>

	<td width="8%" class="main" scope="col" align="center">&nbsp;:</td>

	<td width="14%" class="data" align="left" scope="col"><?php echo date('d-m-Y',strtotime($entry_date))?></td>

	</tr>

	

	<tr>

	<td width="9%" class="style2"  align="center"scope="col">&nbsp;</td>

	

	<td align="left" width="25%" class="main" scope="col"><strong>&nbsp;Site Name </strong></td>

	<td width="5%" class="main"  align="center"scope="col">&nbsp;:</td>

	<td width="21%" class="data"  align="left"scope="col"><?php echo $site_name_edit;?></td>

	

	<td width="18%" class="main" align="left"scope="col"><strong>&nbsp;Plant Name</strong></td>

	<td width="8%" class="main" scope="col" align="center">&nbsp;:</td>

	<td width="14%" class="data" align="left" scope="col"> <?php   if($plant_id11!='') {echo $plant_id11;  }else  { echo "---" ;}?></td>

	</tr>

	<tr>

	<td width="9%" height="30"  align="center" class="style2"scope="col">&nbsp;</td>

	

	<td align="left" width="25%" class="main" scope="col"><strong>&nbsp;Shift Name </strong></td>

	<td width="5%" class="main"  align="center"scope="col">&nbsp;:</td>

	<td width="21%" class="data"  align="left"scope="col"><?php echo $shift_name_edit; ?></td>

	

	<td width="18%" class="main" align="left"scope="col"><strong>&nbsp;Staff Name</strong></td>

	<td width="8%" class="main" scope="col" align="center">&nbsp;:</td>

	<td width="45%" class="data" align="left" scope="col"><?php echo $staff_name;?></td>

	</tr>

	

	<tr>

	<th scope="col">&nbsp;</th>

	<th colspan="6" align="center" scope="col">&nbsp;</th>

	</tr>

	<tr>

	<th scope="col">&nbsp;</th>

	<td colspan="6" align="center" scope="col" class="style2"><strong></strong></td>

	</tr>

	</table>

	

	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

	<tr>

	<th width="7%" height="34" class="" >&nbsp;</th>

	<th width="5%" height="34" class="style10 main " align="left" >S.No</th>


	<th width="14%" class="style10 main " align="left"  >Breakdown Type&nbsp; </th>

	<th width="13%" class="style10 main " align="left"  >Machinery Type&nbsp; </th>
	
	<th width="13%" class="style10 main " align="left"  >Equipment Type&nbsp; </th>

	<th width="9%" class="style10 main " align="right"  >From Time &nbsp; </th>

	<th width="8%"  class="style10 main " align="right" >To Time&nbsp;</th>

	<th width="10%"  class="style10 main " align="right" >Total Time&nbsp;&nbsp;&nbsp;&nbsp;</th>

	<th width="9%" class="style10 main " align="left"  >Remarks&nbsp; </th>
	
	

	</tr>

	<tr>

	<td width="7%" height="" class=" " ></td>

	<td colspan="8" align="center" class="style10 style4"></td>

	<td width="3%" height="" class=" " ></td>

	

	</tr>

	

	<tr>

	<?php 

	

	$i=0;
       
    	$get_query_sub=mysql_query("select * from  breakdown_entry_sub where (breakdown_no='$_POST[breakdown_no]' or breakdown_no='$_GET[breakdown_no]') and (random_no='$_POST[random_no]' or random_no='$_GET[random_no]') and (random_sc='$_POST[random_sc]' or random_sc='$_GET[random_sc]') order by entry_date desc");
						while($fetch_list2=mysql_fetch_array($get_query_sub))
							{
						$i=$i+1;
					    $sub_id=$fetch_list2['id'];
						 $entry_date=$fetch_list2['entry_date'];
						 $from_time=$fetch_list2['from_time'];
						 $to_time=$fetch_list2['to_time'];
						  $remarks=$fetch_list2['remarks'];
						  $breakdown_no=$fetch_list2['breakdown_no'];
						 $total_time=$fetch_list2['total_time'];
             $breakdown_type=$fetch_list2['breakdown_type'];
    //         $machinery_type=get_mechinary_name($fetch_list2['machinery_type']);
	// 		// others & empty entry display
    // $equipment_type=$fetch_list2['equipment_type'];
	// if ($equipment_type == '0') {
	// 	$equipment = 'Others';
	//   } else {
	// 	$equipment = get_plant_equipment_name($equipment_type) or $equipment="--";
	//   }

// earthmover
	 $machinery_type = $fetch_list2['machinery_type'];
// others 31
	 if ($machinery_type == '0'){
		$machinery = 'Others';
	  }else{
		$machinery =  get_mechinary_name($machinery_type);
	  }
// 
        if($breakdown_type == '9')
        {
			// for machinery 25-05-23
			$machinery_name =mysql_fetch_array(mysql_query("select id, equipment_type from equip_type  where id = '$fetch_list2[machinery_type]'"));

          $equipment_type = $fetch_list2['equipment_type'];
          //displaying others option 
          if ($equipment_type == '0') {
            $equipment = 'Others';
          } else {
				// for equip 25-05-23
            $equipement_name =mysql_fetch_array(mysql_query("select id, vehicle_no from vehicle_entry  where id = '$fetch_list2[equipment_type]'"));
            
          }
          
        }
        $equipment_type = $fetch_list2['equipment_type'];
        if ($equipment_type == '0') {
          $equipment = 'Others';
        } else {
        $equipment = get_plant_equipment_name($equipment_type);
        }
	?>
 
	<th width="7%" height="34" class=" " ></th>

	

	<td align="center" height="32" class="data " align="left"><?php echo $i;?></td>

	<td align="left" class="data " ><?php echo get_breakdown_type($breakdown_type);?>&nbsp;</td>
	<!-- 27/3/23 machinery and equipment display -->
	<?php if ($breakdown_type != '9' && $breakdown_type != '7' && $breakdown_type != '8' && $breakdown_type != '13') { ?>
		<td align="left" class="data ">&nbsp;  <?php if($machinery_type!=''){echo get_mechinary_name($machinery_type);} else {echo $machinery_type='--';} ?></td>
            <td align="left" class="data ">&nbsp;<?php if($equipment_type!=''){echo get_plant_equipment_name($equipment);} else {echo $equipment_type ='--';}  ?></td>
          <?php } else if($breakdown_type == '9'){?>
            <!-- earthmover  -->
            <td align="left" class="data ">&nbsp;  <?php echo $machinery_name['equipment_type'] ;?></td>
            <td align="left" class="data ">&nbsp; <?php  if($equipment_type == '0'){echo "Others";}else{ echo $equipement_name['vehicle_no'];}?></td>
          <?php }
          else{
         
          ?>
		  <!-- 31 -->
            <td align="left" class="data ">&nbsp; <?php echo ($machinery);            
             ?></td>
              <td align="left" class="data ">&nbsp; <?php echo ($equipment);            
             ?></td>
          <?php } ?>
	<!-- <td align="left"class="data " >
		earthmover -->
	<!-- <?php echo $machinery_name['vehicle_no'] ;?>
	<?php echo get_mechinary_name($machinery_type);?></td>  -->
	<!-- <td align="left" class="data " ><?php if($machinery_type!=''){echo $machinery_type['vehicle_no'];}else{ echo "--";}?>&nbsp;</td> -->
<!-- displaying others option in view -->
<!-- <td align="left" class="data " ><?php if($equipment_type!=''){echo $equipment_type;}else{ echo "--";}?>&nbsp;</td>  -->
<!-- earthmover -->
	 <!-- <td align="left"class="data " >
		<?php echo $equipement_name['equipment_type'] ;?>
		<?php echo ($equipment); ?></td>  -->
            
	  <!-- <?php if ($equipment_type !=''){
		$equipment_type1='others';
	 }else{
		$equipment_type1='--';
	 } ?>
	 <?php echo ($equipment_type1);?>  -->
	 
	<!-- <td align="left"class="data " ><?php if($equipment_type_id =='0'){ echo $equipment_type_id= 'Others'; }elseif($equipment_type = get_plant_equipment_name($equipment_type_id)){echo $equipment_type;}?>&nbsp;</td>  -->
	<td align="right" class="data " ><?php echo date('h:i A',strtotime($from_time));?>&nbsp;</td>
	<!-- if($equipment_type_id =='0'){echo $equipment_type = 'others' $equipment_type = get_plant_equipment_name($equipment_type_id);}elseif($equipment_type !=''){ echo $equipment_type; }else{echo "--";} -->
	<!-- if($equipment_type_id =='0'){$equipment_type = 'others';}else{$equipment_type = get_plant_equipment_name($equipment_type_id) or $equipment_type="--";} -->
	<td align="right" class="data " ><?php echo date('h:i A',strtotime($to_time));?>&nbsp;</td>

	<td align="right" class="data " ><?php echo $total_time;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

	<td align="left" class="data " ><?php echo $remarks;?>&nbsp;</td>

    

	
	

	</tr>

	<?php
   $tot[]=$total_time;
          $t_time_tot= total_bd_times($tot);

	}?>

	<!-- total amount colspan -->
	<tr>

  <td  width="7%" height="34" class="" ></td>

  <!-- <td align="right" colspan="6" width="7%" height="34" class="data top" ></td> -->
<!--  -->
  <td align="right" colspan="6" class="data    top " >Total Time</td>
  
  <td align="right"  class="data    top " ><?php echo $t_time_tot;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <!--  -->
  <td align="right" colspan="" class="data    top " ></td>
  <td width="3%"  height="" class=" " ></td>

  </tr>
	

	<tr>

	<th width="7%" height="34" class=" " ></th>

	<!-- <td align="right" colspan="6" class="style10 main"></td> -->

	<td align="right" colspan="6" class="style10 style23">&nbsp;</td>

	

	<td align="right" class="style10 style23">&nbsp;</td>
	<!--  -->
	<td align="right" colspan="" class="data    top " ></td>
	<td align="right" class=" ">&nbsp;</td>

	</tr>

	

	</table>

	</body>

	</html>
<!-- </div> -->
<!------------------------------------------------------------------------------------------------------------->
 

<script>

$(document).ready(function() {
 var pdf = new jsPDF('p', 'pt', 'a4');
        var options = {};
        var pdf = new jsPDF('p', 'pt', 'a4');
        pdf.addHTML($("#content2"), 20, 20, options, function() {
            pdf.save('Daily Status.pdf'); 
        });
    });
/*$(document).ready(function() {
var doc = new jsPDF();
doc.addHTML(20, 20, '<?php echo "<p>"."Terms and Conditions:"."</p>";?>');
doc.save('Purchase Order.pdf');
});*/
</script>