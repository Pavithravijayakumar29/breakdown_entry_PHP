<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);

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



$from_date=$_REQUEST['from_date'];

$to_date=$_REQUEST['to_date'];

$site_name=$_REQUEST['site_name'];


$plant_name=$_REQUEST['plant_name'];


$status = $_REQUEST['status'];

$breakdown_type=$_REQUEST['breakdown_type'];

$current_date=date('Y-m-d');
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" style="">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title" id="myModalLabel"></h4>

      </div>

      <div class="modal-body">

        ...

      </div>

    </div>

  </div>

</div>

<script>

$(document).ready(function() {

    $('#example').DataTable();

} );

</script>



<div id="">

 <table width="100%" border="0" cellpadding="0" cellspacing="0" >
 <tr align="right">
    <td>
        <?php if($user_types=='167') { ?>
  <a href="breakdown_entry/modal_slider.php?from_date=<?php echo $_REQUEST['from_date']; ?>&to_date=<?php echo $_REQUEST['to_date']; ?>&site_name=<?php echo $_REQUEST['site_name'];?>&breakdown_type=<?php echo $_REQUEST['breakdown_type'];?>&status=<?php echo $_REQUEST['status'];?>&das_site_name=<?php echo $_REQUEST['das_site_name'];?>&das_status=<?php echo $_REQUEST['das_status'];?>" accesskey="o" data-toggle="modal" data-target="#myModal" title="BreakDown Entry Verification " data-remote="true"><img src="image/approved.png" width="35" height="35"></a>
  <?php } ?>
  
   <a  tabindex=""  href="javascript:breakdown_main_print('breakdown_entry/breakdown_main_print.php?from_date=<?php echo $_REQUEST['from_date']; ?>&to_date=<?php echo $_REQUEST['to_date']; ?>&site_name=<?php echo $_REQUEST['site_name'];?>&breakdown_type=<?php echo $_REQUEST['breakdown_type'];?>&status=<?php echo $_REQUEST['status'];?>&das_site_name=<?php echo $_REQUEST['das_site_name'];?>&das_status=<?php echo $_REQUEST['das_status'];?>&plant_name=<?php echo $_REQUEST['plant_name'];?>');" style="float:center;"><img  align="right" src="image/report_print.png" width="35" height="35" border="0" title="PRINT" value="Print"/></a></td>

  </tr>
</table>

&nbsp;&nbsp;

 <div id="curd_message" align="center" style="font-weight:bold; padding:5px;"></div>

<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

        <thead>

            <tr>

                <th width="4%">#</th>

                <th width="11%">Date</th>

                <th width="15%">Breakdown No</th>

                <th width="21%">Site Name </th>
                <th width="21%">Plant Name </th>


                <th width="15%" >Shift Name</th>

                <th width="15%" style="text-align:right">Total Time&nbsp;</th>

        

                <th width="5%" style="text-align:center">View</th>

            <?php if(($user_types=='167')||($user_types=='30')) { ?> <th width="9%" style="text-align:center">Verify</th> <?php } ?>


                <th width="9%" style="text-align:center">Action</th>

           </tr>

        </thead>

        <tbody>

<?php 


  
if($_REQUEST[das_status]==1)
{
if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}


if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}
else
{
    if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}


if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
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

if($_REQUEST[das_site_name]!='')
{
  //  echo "resquest:"."select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($_REQUEST[das_site_name]) group by a.breakdown_no order by a.id DESC";

 $sql1="select *,a.id as id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($_REQUEST[das_site_name]) group by a.breakdown_no order by a.id DESC";
}
 
else if($sess_site_id=='All')
        {
//echo "sql tot:"."select *,a.id as main_id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' group by a.breakdown_no order by a.id DESC";

 $sql1="select *,a.id as main_id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' group by a.breakdown_no order by a.id DESC";
}
else
{
   // echo "sqltotal:"."select *,a.id as main_id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($sess_site_id) group by a.breakdown_no order by a.id DESC";

 //="select *,a.id as main_id,a.remarks as remarks from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' and a.site_name IN ($sess_site_id) group by a.breakdown_no order by a.id DESC";
}

  /* $sql1="select *,a.id as main_id from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.site_name='$sess_site_id' order by a.id DESC"; */



$rows1 = $db->fetch_all_array($sql1);

foreach($rows1 as $record)

{

 $site_id=$record['site_name']; 

 

 $site_name=get_site_name($site_id);

 
  $breakdown_no=$record['breakdown_no']; 
  $random_no=$record['random_no']; 
  $random_sc=$record['random_sc']; 
  $breakdown_type=$record['breakdown_type'];
  $shift_name=$record['shift_name'];
  $plant_name1=$record['plant_name'];
  $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$plant_name1'"));
  $plant_id11= $party_names['plant'];
  $overall_time=$record['overall_time'];

	?>

   <tr>

                <td><?php echo $i = $i+1; ?>.</td>

                <td><?php echo date("d-m-Y",strtotime($record['entry_date'])); ?></td>

                <td>&nbsp;
                  <div class="tooltip8"> 
                  <span class="tooltiptext8"><?php if($record['approved_by']!='') { ?><?php echo date("d-m-Y h:i a",strtotime($record['approved_date_time']));?><br><?php echo get_staff_name($record['approved_by']); } ?><br><?php echo $record['remarks'];?></span>
			           	<?php echo $breakdown_no; ?>
                    </div>
                   </td>

                 <td><?php echo $site_name; ?></td>
                <td ><?php echo $plant_id11 ?>&nbsp;</td>

                 <td ><?php echo get_shift_name($shift_name); ?>&nbsp;</td>


                 <td style="text-align:right" ><?php echo $overall_time; ?>&nbsp;</td>

              <td width="5%" style="text-align:center"><a  tabindex="7" href="javascript:breakdown_indi_print('breakdown_entry/breakdown_view.php?breakdown_no=<?php echo $record['breakdown_no'];?>&main_id=<?php echo $record['main_id'];?>&random_no=<?php echo $record['random_no']; ?>&random_sc=<?php echo $record['random_sc']; ?>');" style="float:center"><img  align="center" src="image/view.png" width="30" height="30" border="0" title="PRINT" value="Print"/></a></td>

<?php if(($user_types=='167')||($user_types=='30')) { ?>            <td align="center"><a href="breakdown_entry/breakdown_approval.php?update_id=<?php echo $record['main_id']; ?>&breakdown_no=<?php echo $record['breakdown_no']; ?>&random_no=<?php echo $record['random_no']; ?>&random_sc=<?php echo $record['random_sc']; ?>&das_status=<?php echo $_REQUEST['das_status']; ?>&from_date=<?php echo $_REQUEST['from_date']; ?>&to_date=<?php echo $_REQUEST['to_date']; ?>&site_name=<?php echo $_REQUEST['site_name'];?>&breakdown_type=<?php echo $_REQUEST['breakdown_type']?>&status=<?php echo $_REQUEST['status']?>&das_site_name=<?php echo $_REQUEST['das_site_name']?>" title="Approval  Breakdown" data-toggle="modal" data-target="#myModal" data-remote="false" class="btn btn-default" >             <img  align="center" src="image/approved.png" width="30" height="30" border="0" title="Approval" value="Approval"/>  </a> </td><?php } ?>



                <td align="center">

<?php if($record[approved_status]=='0') { ?>
<?php if($user_types!='167') { ?>
                  <a href="breakdown_entry/update.php?update_id=<?php echo $record['main_id']; ?>&breakdown_no=<?php echo $record['breakdown_no']; ?>&random_no=<?php echo $record['random_no']; ?>&random_sc=<?php echo $record['random_sc']; ?>&das_status=<?php echo $_REQUEST['das_status']; ?>&from_date=<?php echo $_REQUEST['from_date']; ?>&to_date=<?php echo $_REQUEST['to_date']; ?>&site_name=<?php echo $_REQUEST['site_name'];?>&breakdown_type=<?php echo $_REQUEST['breakdown_type']?>&status=<?php echo $_REQUEST['status']?>&das_site_name=<?php echo $_REQUEST['das_site_name']?>" title="Update Breakdown" data-toggle="modal" data-target="#myModal" data-remote="false" class="btn btn-default" onClick = "get_shift_breakdown('<?php echo $record[shift_name]; ?>','<?php echo $record[entry_date]; ?>'),get_frm_to_time('<?php echo $record[shift_name]; ?>','<?php echo $record[entry_date]; ?>')"><span class="glyphicon glyphicon-pencil" ></span></a> 

                

                <?php if($user_types=='30') { ?><a href="#" title="Delete  Details" class="btn btn-default" onClick="delete_breakdown_main11('<?php echo $record['main_id']; ?>','<?php echo $record['breakdown_no']; ?>','<?php echo $record['random_no']; ?>','<?php echo $record['random_sc']; ?>&das_status=<?php echo $_REQUEST[das_status]; ?>');"><span class="glyphicon glyphicon-trash"></span></a>
                <?php } ?>

<?php } 
}
              
              else
              {?>
                <label style="color:green;">Verified</label>
             <?php }

              ?>
              </td>

            </tr>

    <?php 
          

} 

$db->close();

?>

</tbody>
     
</table>

</div>

<style>
.tooltip8 {
    position: relative;
    display: inline-block;
	
}
.tooltip8 .tooltiptext8 {
    visibility: hidden;
    width: auto;
    background-color:#F93;
    color:#000;
    text-align:left ;
    border-radius: 6px;
    padding: 7px 10px;
    
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    top: -4px;
    left: 155%;

}

.tooltip8 .tooltiptext8 {
	position: absolute;
	background: #F93;
}
.tooltip8 .tooltiptext8:after, .tooltip8 .tooltiptext8:before {
	right: 100%;
	top: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
}



.tooltip8:hover .tooltiptext8 {
    visibility: visible;
}
</style>