<?php 

error_reporting(0);

ob_start();

session_start();

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 
require("../include/common_function.php"); 


$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 	

$date=date("Y");

$st_date=substr($date,2);

$month=date("m");	   

$datee=$st_date.$month;

$sess_user_id=$_SESSION['sess_user_id'];

 $session_user_name=$_SESSION['sess_user_name'];

 $user_type_ids=$_SESSION['user_type_ids'];

 $user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];

$sql = "SELECT * FROM   breakdown_entry  where id='$_GET[update_id]' ";

$rows = $db->fetch_all_array($sql);

foreach($rows as $record)

{
	 $approve_user = $record['approved_by'];
	$random_no = $record['random_no'];

	$random_sc = $record['random_sc'];

	$breakdown_no = $record['breakdown_no'];


	$entry_date  = $record['entry_date'];

	$site_name_edit = $record['site_name'];
$site_name=get_site_name($site_name_edit);

$shift_name_edit = $record['shift_name'];
$shift_name=get_shift_name($shift_name_edit);

  $user_name_edit = $record['user_name'];

	$staff_name=get_staff_name($user_name_edit);
$app_status = $record[approved_status];

$plant_name1=$record['plant_name'];
  $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$plant_name1'"));
  $plant_id11= $party_names['plant'];
}
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


<style type="text/css">

	.style10{ border-top: solid 1px; border-top-color:#999;}

	.style1{font-weight:bold; text-align:right;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}

	.style2{font-weight:normal;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}

	.style3{color:#F00;}

	.style4{font-weight:normal;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;}

	.style5 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-weight: bold;

	font-size: 14px;

	}

	.top{ border-top: 1px solid #999;}

	.bottom{ border-bottom: 1px solid #999;}

  .right{ border-right: 1px solid #999;}

	.title{font-family:calibri; font-family:calibri; font-size:28px; color:#333; }

	.address{font-family:calibri; font-family:calibri; font-size:20px; color:#333; }

	.main{font-family:calibri; font-family:calibri; font-size:18px; font-weight:600; color:#666; }

	.data{font-family:calibri; font-family:calibri; font-size:15px; color:#333; }</style>


<div class="box box-info">
  <form class="form-horizontal"  method="POST">
              <div class="box-body">

              <div class="form-group">

                   <label class="col-sm-2 control-label font_label"  >Breakdown&nbsp;No</label>

            

        <div class="col-sm-2">

<input type="hidden" readonly name="breakdown_no" id="breakdown_no" class="text_box" style="font-size:12px" value="<?php  echo $breakdown_no;?>" /><strong> <span style="color:#FF0000;"><strong><?php  echo $breakdown_no;?></strong></span>

    </strong> </div>

          

                   <label class="col-sm-4 control-label font_label"  >Date/Time&nbsp;</label>

                <div class="col-sm-3">
                 
                   <label class="control-label font_label" ><strong><?php echo $entry_date; ?></strong></label>

                </div>   

                </div>

                 <div class="form-group">   

                 <label class="col-sm-2 control-label font_label"  >Site&nbsp;Name</label>

                            <div class="col-sm-2">
                <label class="control-label font_label" ><strong><?php echo $site_name; ?></strong></label>
      

	             </div>
	                         	         <div class="col-sm-2" ></div>


	                  <label class="col-sm-2 control-label font_label" >Plant &nbsp;Name</label>

                            <div class="col-sm-2" >
                     <label class="control-label font_label" ><strong><?php echo ucfirst($plant_id11); ?></strong></label>

               </div>  


	         </div>


	      
                 <div class="form-group">   


   <label class="col-sm-2 control-label font_label"  >Shift&nbsp;Name</label>

                            <div class="col-sm-2" >

      <label class="control-label font_label" ><strong><?php echo $shift_name; ?></strong></label>
               </div>  

                 

            	         <div class="col-sm-2" ></div>
           

   <label class="col-sm-2 control-label font_label" >Staff&nbsp;Name</label>

                            <div class="col-sm-2" >
                     <label class="control-label font_label" ><strong><?php echo ucfirst($staff_name); ?></strong></label>

               </div>    
</div>

	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

	<tr>

	<th width="7%" height="34" class="right" >&nbsp;</th>

	
.
	<th width="4%" height="34" class="style10 main right" align="left" >&nbsp;S.No</th>


	<th width="16%" class="style10 main right" align="left"  >&nbsp;Breakdown Type&nbsp; </th>
	<th width="10%" class="style10 main right"   ><div style="text-align:right">From Time &nbsp; </th></div>

	<th width="10%"  class="style10 main right"  ><div style="text-align:right">&nbsp;To Time&nbsp;</th></div>

	<th width="15%"  class="style10 main right" ><div style="text-align:right">&nbsp;Total Time&nbsp;&nbsp;&nbsp;&nbsp;</th></div>

	<th width="25%" class="style10 main right" ><div style="text-align:left">&nbsp;Remarks&nbsp; </th></div>

	</tr>

	<tr>

	<td width="7%" height="" class=" " ></td>

	<td colspan="6" align="center" class="style10 style4"></td>

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
            

	?>

	<th width="7%" height="34" class="right " ></th>

	

	<td align="center" height="32" class="data right" align="left">&nbsp;<?php echo $i;?></td>

	<td align="left" class="data right" >&nbsp;<?php echo get_breakdown_type($breakdown_type);?>&nbsp;</td>

	<td align="right" class="data right" >&nbsp;<?php echo date('h:i A',strtotime($from_time));?>&nbsp;</td>

	<td align="right" class="data right" >&nbsp;<?php echo date('h:i A',strtotime($to_time));?>&nbsp;</td>

	<td align="right" class="data right" >&nbsp;<?php echo $total_time;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

	<td align="left" class="data right " >&nbsp;<?php echo $remarks;?>&nbsp;</td>

	
	

	</tr>

	<?php
$tot[]=$total_time;
          $t_time_tot= total_bd_times($tot);

 }


	?>

	<tr>

	<td  width="7%" height="34" class="right" ></td>

	<td align="right" colspan="3" width="7%" height="34" class="data top" >&nbsp;</td>

	<td align="right" class="data    top right" ><strong>Total Time&nbsp;</strong></td>

	<td align="right" class="data    top right" ><strong><?php echo $t_time_tot; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>

	<td width="3%"  height=""  class="data    top right"></td>
	

	</tr>

	<tr>

	<th width="7%" height="34" class=" " ></th>

	<td align="right" colspan="4" class="style10 main"></td>

	<td align="right" class="style10 style23">&nbsp;</td>

	

	<td align="right" class="style10 style23">&nbsp;</td>

	<td align="right" class=" ">&nbsp;</td>

	</tr>

	

	</table>

 <div class="form-group">   

<label class="col-sm-2 control-label font_label"  >Approved Date/ime</label>

 <div class="col-sm-3" >
   <input type="text" class="form-control" name="approved_date_time" id="approved_date_time" value="<?php if($record[approved_date_time]=='0000-00-00 00:00:00') { echo date('d-m-Y h:i:s a '); } else { echo date('d-m-Y h:i:s a',strtotime($record[approved_date_time])); }?>" readonly/>
  </div>

    

 <label class="col-sm-3 control-label font_label"  >Status</label>
<div class="col-sm-3" >   
 
  <select name="apprved_status" id="apprved_status" class="form-control  " style="width:100%"<?php if( $app_status=='1'){?> disabled <?php } ?>>
  			 <option value="1" <?php if($app_status=='1'){?> selected <?php } ?> >Verified</option>
                      <option value="0" <?php if($app_status=='0' && $approve_user!=''){?> selected <?php } ?> >Pending</option>
                     
                     </select>
      </div> 
</div>


<div class="form-group">
<label class="col-sm-2 control-label font_label"  >Approved By</label>
<div class="col-sm-2" >   
 <?php 
$record1=mysql_fetch_array(mysql_query("select * from  user_creation where user_id='$sess_user_id'"));

  ?>
  <input type="hidden" name="apprve_by" id="apprve_by" value="<?php  echo $record1[staff_name];?>">

 <label class="control-label font_label" ><?php echo get_staff_name($record1[staff_name]); ?></label>
      </div> 
      <label class="col-sm-2 control-label font_label"  >Remarks</label>
<div class="col-sm-4" >   
<textarea name="remarks" id="remarks" class="form-control numeric" onkeyup=""<?php if( $app_status=='1'){?> disabled <?php } ?>><?php echo $record[remarks]; ?></textarea>
      </div>
</div>
 <div align="center" >

<button type="button" id="button" class="btn btn-info" onClick="breakdown_aproval(approved_date_time.value,apprved_status.value,apprve_by.value,'<?php echo $_GET['update_id']; ?>',remarks.value,'<?php echo $_REQUEST[from_date]; ?>','<?php echo $_REQUEST[to_date]; ?>','<?php echo $_REQUEST[site_name]; ?>','<?php echo $_REQUEST[breakdown_type]; ?>','<?php echo $_REQUEST[status]; ?>','<?php echo $_REQUEST[das_status]; ?>','<?php echo $_REQUEST[das_site_name]; ?>')">VERIFY</button>
<button type="button" class="btn btn-info" data-dismiss="modal" >CLOSE</button>

</div>






</div>
</form>

</div>