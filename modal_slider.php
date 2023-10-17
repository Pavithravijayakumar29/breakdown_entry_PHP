<!-- <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap/maxcdn.bootstrap.min.css">
  <script src="../bootstrap/jquery.min.js"></script>
  <script src="../bootstrap/bootstrap.min.js"></script>
 -->
 
<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

  <div class="modal-dialog" style="width:100%;height:110%">

    <div class="modal-content">

      <div class="modal-header">

      <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->

        <h4 class="modal-title" id="myModalLabel"></h4>

      </div>

      <div class="modal-body">

        ...

      </div>

    </div>

  </div>

</div>
<style type="text/css">
  .app_clr:hover
{
background-color: #8916C1;
color:#FCF9F9;
}
.app_clr{
  background-color:#8916C1;
  color:#FCF9F9;
  
  }
</style>
<div id="mycarousel" class="carousel slide" data-ride="carousel">
 <div class="container">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    
   <?php 
error_reporting(0);

ob_start();

session_start();  
include("../model/config.inc.php"); 

include("../model/Database.class.php");

include_once("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 

$user_type_ids=$_SESSION['user_type_ids'];

$session_user_name=$_SESSION['sess_user_name'];

$session_password=$_SESSION['password'];

$user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];

$sess_user_id=$_SESSION['sess_user_id'];

 $session_user_name=$_SESSION['sess_user_name'];

$from_date=$_REQUEST['from_date'];

$to_date=$_REQUEST['to_date'];

$site_name=$_REQUEST['site_name'];
$plant_name=$_REQUEST['plant_name'];

$status = $_REQUEST['status'];

$breakdown_type=$_REQUEST['breakdown_type'];

$current_date=date('Y-m-d');

  

if($_REQUEST[site]=='site')
{
if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name in ($site_name)";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}

if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}
else
{
     if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name in ($site_name)";}else{$site_name1='';}
if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}

if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

//if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}

$all_value10 = $from_date1."@".$to_date1."@".$site_name1."@".$breakdown_type1."@".$status1."@".$plant_name1;



$all_array10 = explode('@',$all_value10);
  

foreach($all_array10 as $value10)

{ 

if($value10!='')

{

  $get_query131 .= $value10." AND ";

}

}
if($sess_site_id=='All')
        {

  $sql1="select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' group by a.breakdown_no order by a.id asc";
}
else
{

 $sql1="select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($sess_site_id) group by a.breakdown_no order by a.id asc";
}

$fetcnt = mysql_num_rows(mysql_query($sql1));
$record = mysql_fetch_array(mysql_query($sql1));

 $id = $record['id'];
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

 $approve_user = $record['approved_by'];

 
?>
<div class="item active">
      <form>
  <div class="box box-info">
  <form class="form-horizontal"  method="POST">
              <div class="box-body">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Breakdown No :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp; <span style="color:red;font-weight: bold;"><?php echo $breakdown_no; ?></span>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Entry Date :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date('d-m-Y',strtotime($entry_date)); ?></strong>
    </td>
  </tr>

  <tr>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Site Name :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-weight: bold;"><?php echo $site_name; ?></span>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Shift Name :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;<strong><?php echo $shift_name; ?></strong>
    </td>
  </tr>

  <tr>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Staff Name :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-weight: bold;"><?php echo ucfirst($staff_name); ?></span>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
  </tr>
</table>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
</table>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
  <th width="7%" height="34" class="right1" >&nbsp;</th>.

  

  <th width="4%" height="34" class="style10 main right" align="left" >&nbsp;S.No</th>


  <th width="16%" class="style10 main right" align="left"  >&nbsp;Breakdown Type&nbsp; </th>
  <th width="10%" class="style10 main right"   ><div style="text-align:right">&nbsp;From Time &nbsp; </th></div>

  <th width="10%"  class="style10 main right"  ><div style="text-align:right">&nbsp;To Time&nbsp;</th></div>

  <th width="15%"  class="style10 main right" ><div style="text-align:right">&nbsp;Total Time&nbsp;&nbsp;&nbsp;&nbsp;</th></div>

  <th width="25%" class="style10 main right" ><div style="text-align:left;">&nbsp;Remarks&nbsp; </th></div>

  <th width="3%" height="34" class="" >&nbsp;</th>


    </tr>


  <tr>

  <td width="7%" height="" class=" " ></td>

  <td colspan="6" align="center" class="style10 style4"></td>

  <td width="3%" height="" class=" " ></td>

  

  </tr>
  <tr>
<?php 

  

  $s_no=0;
//echo "select * from   panel_reading_entry_sub where reading_no='$reading_no' and random_no='$random_no' and random_sc='$random_sc' and mu_status!='1' order by id asc";

  $sql12="select * from   breakdown_entry_sub where breakdown_no='$breakdown_no' and random_no='$random_no' and random_sc='$random_sc' order by id asc ";
  $rs12=mysql_query($sql12);

  while($rsdata=mysql_fetch_object($rs12))

  {
$sub_id=$fetch_list2['id'];
             $entry_date=$fetch_list2['entry_date'];
             $from_time=$fetch_list2['from_time'];
             $to_time=$fetch_list2['to_time'];
              $remarks=$fetch_list2['remarks'];
              $breakdown_no=$fetch_list2['breakdown_no'];
             $total_time=$fetch_list2['total_time'];
             $breakdown_type=$fetch_list2['breakdown_type'];
  $s_no=$s_no+1;

  $entry_date=$rsdata->entry_date ;

  $from_time=$rsdata->from_time ;

  $to_time=$rsdata->to_time ;

  $remarks=$rsdata->remarks ;

  $breakdown_no=$rsdata->breakdown_no ;

  $total_time=$rsdata->total_time;

  $breakdown_type=$rsdata->breakdown_type;

?>

<th width="7%" height="34" class="right1 " ></th>

  

  <td align="center" height="32" class="data  right1   ">&nbsp;<?php echo $s_no;?></td>

  <td align="left" class="data right" >&nbsp;<?php echo get_breakdown_type($breakdown_type);?>&nbsp;</td>

  <td align="right" class="data right" >&nbsp;<?php echo date('h:i A',strtotime($from_time));?>&nbsp;</td>

  <td align="right" class="data right" >&nbsp;<?php echo date('h:i A',strtotime($to_time));?>&nbsp;</td>

  <td align="right" class="data right" >&nbsp;<?php echo $total_time;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

  <td align="left" class="data right " >&nbsp;<?php echo $remarks;?>&nbsp;</td>

  

  <td width="3%" height="" class=" " ></td>

  <td width="9%" align="right" class=" ">&nbsp;</td>

  </tr>
  <?php $tot_total_reading+=$total_reading;   } ?>

  <tr>

  <td  width="7%" height="34" class="right" ></td>

  <td align="right" colspan="3" width="7%" height="34" class="data top" >&nbsp;</td>

  <td align="right" class="data    top right" ><strong>Total Time&nbsp;</strong></td>

  <td align="right" class="data    top right" ><strong><?php   $break_down_sub_mech=mysql_fetch_array(mysql_query("select SEC_TO_TIME(sum(( TIME_TO_SEC( `total_time` ) ) ) ) as tot_time from  breakdown_entry_sub where breakdown_no='$breakdown_no' and random_no='$random_no' and random_sc = '$random_sc' and  id!=''")); echo $break_down_sub_mech[tot_time]; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>

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

<label class="col-sm-2 control-label font_label"  >Approve Date and Time</label>

 <div class="col-sm-3" >
<input type="text" class="form-control" name="apprve_date_time" id="apprve_date_time" value="<?php if($record[approved_date_time]=='0000-00-00 00:00:00') { echo date('d-m-Y h:i:s a '); } else { echo date('d-m-Y h:i:s a',strtotime($record[approved_date_time])); }?>" readonly/>  </div>
 <label class="col-sm-1 control-label font_label"  >Status</label>
<div class="col-sm-2" >   
 
  <select name="apprve_status<?php echo $record['id']; ?>" id="apprve_status<?php echo $record['id']; ?>" class="form-control  " style="width:100%"  <?php if($app_status=='1'){?> disabled <?php } ?>>
    <option value="1" <?php if($app_status=='1'){?> selected <?php } ?> >Verified</option>
<option value="0" <?php if($app_status=='0' && $approve_user!=''){?> selected <?php } ?> >Pending</option>
     
                      


                      
                      
                     </select>
      </div> 
      <label class="col-sm-2 control-label font_label"  >Approved By</label>
<div class="col-sm-2" >   
 <?php 
$record1=mysql_fetch_array(mysql_query("select * from  user_creation where user_id='$sess_user_id'"));

  ?>
  <input type="hidden" name="apprve_by" id="apprve_by" value="<?php  echo $record1[staff_name];?>">

 <label class="control-label" ><?php echo get_staff_name($record1[staff_name]); ?></label>
      </div>
</div>


<div class="form-group"><br/><br/>
 

      <label class="col-sm-2 control-label font_label"  >Remarks</label>
<div class="col-sm-4" >   
<textarea name="remarks<?php echo $record['id']; ?>" id="remarks<?php echo $record['id']; ?>" class="form-control numeric" onkeyup=""<?php if($record[remarks]!='' && $app_status==1){?> disabled <?php } ?>><?php echo $record[remarks]; ?></textarea>
      </div>
<div class="col-sm-1"></div>
<div id="update_div<?php echo $record['id']; ?>"<?php if($app_status=='0'){ ?> style="display: block;margin-top: 10px;" <?php } else {?> style='display: none;' <?php } ?>>
<button type="button" id="button" class="btn btn-info" onClick="break_reading_aprova1(apprve_date_time.value,apprve_status<?php echo $record['id']; ?>.value,apprve_by.value,'<?php echo $breakdown_no; ?>','<?php echo $record['id']; ?>',remarks<?php echo $record['id']; ?>.value)">Verify</button>
</div>
<div id="hide_div<?php echo $record['id']; ?>" <?php if($app_status=='1'){ ?> style="display: block;margin-top: 10px;" <?php } else {?> style='display: none;' <?php } ?>>
<button type="button" id="button" class="btn app_clr">Verified</button>
</div>

</div> 

 
 
 

              </div>
              <button style="float: right;" type="button" class="btn btn-info" data-dismiss="modal" onClick="re_load_fun_break()">Close</button>
</form>

  </div>
 
</form>
    </div>

<?php 

if($_REQUEST[site_name_id]!='')
{

 $sql1="select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($_REQUEST[site_name_id]) group by a.breakdown_no order by a.id asc limit 1,$fetcnt";
}
elseif($sess_site_id=='All')

{
  $sql1="select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' group by b.breakdown_no order by a.id asc limit 1,$fetcnt";

}
else

{
  
 $sql1="select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.site_name IN ($sess_site_id) group by b.breakdown_no order by a.id asc limit 1,$fetcnt";

}


$rows1 = $db->fetch_all_array($sql1);

foreach($rows1 as $record)

{
  $id = $record['id'];
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

 $approve_user = $record['approved_by'];


?>
    <div class="item">
      <form>
  <div class="box box-info">
  <form class="form-horizontal"  method="POST">
              <div class="box-body">
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Breakdown No :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp; <span style="color:red;font-weight: bold;"><?php echo $breakdown_no; ?></span>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Entry Date :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date('d-m-Y',strtotime($entry_date)); ?></strong>
    </td>
  </tr>

  <tr>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Site Name :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-weight: bold;"><?php echo $site_name; ?></span>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Shift Name :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;<strong><?php echo $shift_name; ?></strong>
    </td>
  </tr>

  <tr>
    <td>
      <label class="control-label font_label"> &nbsp;&nbsp;&nbsp; Staff Name :&nbsp;&nbsp;&nbsp; </label>&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-weight: bold;"><?php echo ucfirst($staff_name); ?></span>
    </td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
  </tr>
</table>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
</table>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tr>
  <th width="7%" height="34" class="right1" >&nbsp;</th>.

  

  <th width="4%" height="34" class="style10 main right" align="left" >&nbsp;S.No</th>


  <th width="16%" class="style10 main right" align="left"  >&nbsp;Breakdown Type&nbsp; </th>
  <th width="10%" class="style10 main right"   ><div style="text-align:right">&nbsp;From Time &nbsp; </th></div>

  <th width="10%"  class="style10 main right"  ><div style="text-align:right">&nbsp;To Time&nbsp;</th></div>

  <th width="15%"  class="style10 main right" ><div style="text-align:right">&nbsp;Total Time&nbsp;&nbsp;&nbsp;&nbsp;</th></div>

  <th width="25%" class="style10 main right" ><div style="text-align:left">&nbsp;Remarks&nbsp; </th></div>

  <th width="3%" height="34" class="" >&nbsp;</th>


    </tr>


  <tr>

  <td width="7%" height="" class=" " ></td>

  <td colspan="6" align="center" class="style10 style4"></td>

  <td width="3%" height="" class=" " ></td>

  

  </tr>
  <tr>
<?php 

  

  $s_no=0;
//echo "select * from   panel_reading_entry_sub where reading_no='$reading_no' and random_no='$random_no' and random_sc='$random_sc' and mu_status!='1' order by id asc";

  $sql12="select * from   breakdown_entry_sub where breakdown_no='$breakdown_no' and random_no='$random_no' and random_sc='$random_sc' order by id asc ";
  $rs12=mysql_query($sql12);

  while($rsdata=mysql_fetch_object($rs12))

  {
$sub_id=$fetch_list2['id'];
             $entry_date=$fetch_list2['entry_date'];
             $from_time=$fetch_list2['from_time'];
             $to_time=$fetch_list2['to_time'];
              $remarks=$fetch_list2['remarks'];
              $breakdown_no=$fetch_list2['breakdown_no'];
             $total_time=$fetch_list2['total_time'];
             $breakdown_type=$fetch_list2['breakdown_type'];
  $s_no=$s_no+1;

  $entry_date=$rsdata->entry_date ;

  $from_time=$rsdata->from_time ;

  $to_time=$rsdata->to_time ;

  $remarks=$rsdata->remarks ;

  $breakdown_no=$rsdata->breakdown_no ;

  $total_time=$rsdata->total_time;

  $breakdown_type=$rsdata->breakdown_type;

?>

<th width="7%" height="34" class="right1 " ></th>

  

  <td align="center" height="32" class="data  right1   ">&nbsp;<?php echo $s_no;?></td>

  <td align="left" class="data right" >&nbsp;<?php echo get_breakdown_type($breakdown_type);?>&nbsp;</td>

  <td align="right" class="data right" >&nbsp;<?php echo date('h:i A',strtotime($from_time));?>&nbsp;</td>

  <td align="right" class="data right" >&nbsp;<?php echo date('h:i A',strtotime($to_time));?>&nbsp;</td>

  <td align="right" class="data right" >&nbsp;<?php echo $total_time;?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

  <td align="left" class="data right " >&nbsp;<?php echo $remarks;?>&nbsp;</td>

  

  <td width="3%" height="" class=" " ></td>

  <td width="9%" align="right" class=" ">&nbsp;</td>

  </tr>
  <?php $tot_total_reading+=$total_reading;   } ?>

  <tr>

  <td  width="7%" height="34" class="right" ></td>

  <td align="right" colspan="3" width="7%" height="34" class="data top" >&nbsp;</td>

  <td align="right" class="data    top right" ><strong>Total Time&nbsp;</strong></td>

  <td align="right" class="data    top right" ><strong><?php   $break_down_sub_mech=mysql_fetch_array(mysql_query("select SEC_TO_TIME(sum(( TIME_TO_SEC( `total_time` ) ) ) ) as tot_time from  breakdown_entry_sub where breakdown_no='$breakdown_no' and random_no='$random_no' and random_sc = '$random_sc' and  id!=''")); echo $break_down_sub_mech[tot_time]; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>

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

<label class="col-sm-2 control-label font_label"  >Approve Date and Time</label>

 <div class="col-sm-3" >
   <input type="text" class="form-control" name="apprve_date_time" id="apprve_date_time" value="<?php if($record[approved_date_time]=='0000-00-00 00:00:00') { echo date('d-m-Y h:i:s a '); } else { echo date('d-m-Y h:i:s a',strtotime($record[approved_date_time])); }?>" readonly/>
  </div>
 <label class="col-sm-1 control-label font_label"  >Status</label>
<div class="col-sm-2" >   
 
  <select name="apprve_status<?php echo $record['id']; ?>" id="apprve_status<?php echo $record['id']; ?>" class="form-control  " style="width:100%"<?php if($app_status=='1'){?> disabled <?php } ?>>

    <option value="1" <?php if($app_status=='1'){?> selected <?php } ?> >Verified</option>
                      <option value="0" <?php if($app_status=='0' && $approve_user!=''){?> selected <?php } ?> >Pending</option>
                      
                     </select>
      </div>
      <label class="col-sm-2 control-label font_label"  >Approved By</label>
<div class="col-sm-2" >   
 <?php 
$record1=mysql_fetch_array(mysql_query("select * from  user_creation where user_id='$sess_user_id'"));

  ?>
  <input type="hidden" name="apprve_by" id="apprve_by" value="<?php  echo $record1[staff_name];?>">

 <label class="control-label" ><?php echo get_staff_name($record1[staff_name]); ?></label>
      </div> 
</div>


<div class="form-group"><br/><br/>
 

      <label class="col-sm-2 control-label font_label"  >Remarks</label>
<div class="col-sm-4" >   
<textarea name="remarks<?php echo $record['id']; ?>" id="remarks<?php echo $record['id']; ?>" class="form-control numeric" onkeyup=""<?php if($record[remarks]!='' && $app_status==1){?> disabled <?php } ?>><?php echo $record[remarks]; ?></textarea>
      </div>
<div class="col-sm-1"></div>
<div id="update_div<?php echo $record['id']; ?>"<?php if($app_status=='0'){ ?> style="display: block;margin-top: 10px;" <?php } else {?> style='display: none;' <?php } ?>>
<button type="button" id="button" class="btn btn-info" onClick="break_reading_aprova1(apprve_date_time.value,apprve_status<?php echo $record['id']; ?>.value,apprve_by.value,'<?php echo $breakdown_no; ?>','<?php echo $record['id']; ?>',remarks<?php echo $record['id']; ?>.value)">Verify</button>
</div>
<div id="hide_div<?php echo $record['id']; ?>" <?php if($app_status=='1'){ ?> style="display: block;margin-top: 10px;" <?php } else {?> style='display: none;' <?php } ?>>
<button type="button" id="button" class="btn app_clr">Verified</button>
</div>

</div> 
</div>
 

<button style="float: right;" type="button" class="btn btn-info" data-dismiss="modal" onClick="re_load_fun_break()">Close</button>
</form>

  </div>
 
</form>
    </div>
    <?php }?>
 
  </div>


</div>



  <!-- Controls -->
  <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>



<style>
h3 {
  display: inline-block;
  padding: 10px;
  background: #B9121B;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.p {
  text-align: center;
  padding-top: 40px;
  font-size: 13px;
}
.carousel-control.right
   {
     background-image:none;
   }
   .carousel-control.left
   {
      background-image:none;
   }
   .carousel-control .icon-next, .carousel-control .glyphicon-chevron-right
   {
     right:0%;
     color:black;
   }
   .carousel-control .icon-prev, .carousel-control .glyphicon-chevron-left
   {
     left:0%;
     color:black;
   }
   .carousel-control 
   {
      width: 0% !important;
   }
</style>





<script>
$('.carousel').carousel({
  interval: false,
  pause: "true"
});

function re_load_fun_break()
{
  var from_date =$('#from_date').val() ; 
    var to_date =$('#to_date').val();
    var breakdown_type =$('#breakdown_type').val() ; 
     var status =$('#status').val() ; 
   var site_name =$('#site_name').val();
   var plant_name =$('#plant_name').val(); 
   var site =$('#site').val();
     var site_name_id =$('#site_name_id').val() ; 

    /*  var from_date="<?php echo $_REQUEST['from_date']; ?>";

var to_date="<?php echo $_REQUEST['to_date']; ?>";

var site_name="<?php echo $_REQUEST['site_name']; ?>";

var breakdown_type="<?php echo $_REQUEST['breakdown_type']; ?>";

var status="<?php echo $_REQUEST['status']; ?>";

var site="<?php echo $_REQUEST['site']; ?>";

var site_name_id="<?php echo $_REQUEST['site_name_id']; ?>";*/

  //$( "#panel_reading_list_div" ).load( "index1.php?hopen=panel_reading_form/admin #example" );

    window.location.href ="index1.php?hopen=breakdown_entry/admin&from_date="+from_date+"&to_date="+to_date+"&site_id="+site_name+"&breakdown_type="+breakdown_type+"&status="+status+"&site="+site+"&site_name_id="+site_name_id+"&plant_id="+plant_name;

}
</script>


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

  .right111{ border-right: 1px solid #999;}

  .title{font-family:calibri; font-family:calibri; font-size:28px; color:#333; }

  .address{font-family:calibri; font-family:calibri; font-size:20px; color:#333; }

  .main{font-family:calibri; font-family:calibri; font-size:15px; color:#666; }

  .data{font-family:calibri; font-family:calibri; font-size:15px; color:#333; }
</style>
