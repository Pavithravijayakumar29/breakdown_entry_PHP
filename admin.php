

  <?php 

error_reporting(0);

ob_start();

session_start(); 

require_once("model/config.inc.php"); 

require_once("model/Database.class.php"); 

include_once("../include/common_function.php"); 



$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 

$ses_site=$_SESSION['sess_site_id'];

$user_type_ids=$_SESSION['user_type_ids'];

$session_user_name=$_SESSION['sess_user_name'];

$session_password=$_SESSION['password'];

$user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];




?>

<?php



  



?>  

<script>

function tipper_entry_print(url)

{

onmouseover= window.open(url,'','height=700,width=1000,scrollbars=yes,left=150,top=80,toolbar=no,location=no,directories=no,status=no,menubar=no');

}



function get_vehicle_no_machinerie_list(vehicle_type,site_name)

{

jQuery.ajax({

    type: "POST",

    url: "tipper_entry/vehicle_no_filter.php",

    data: "vehicle_type="+vehicle_type+"&site_name="+site_name,

    success: function(msg){

      jQuery("#get_vehicle_no_tipper_list_div").html(msg);

    }

  });

}

</script> 



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



<div class="row space-hight">

<div class="col-md-8">
   <?php if($_GET['site']!='site'){ ?>
<a href="breakdown_entry/create.php?site='<?php echo $_REQUEST['site']; ?>'" accesskey="o" data-toggle="modal" data-target="#myModal" title="Add Breakdown" data-remote="true" class="btn btn-default"><img src="image/pen.png" width="35" height="35"></a>
<?php } ?>
<span class="topic-header">Breakdown Entry</span> </div>
 <div class="col-md-4">

 <?php 

if($_GET['site']=='site'){?>
<div style="text-align:right">

<a href="index1.php?hopen=site_coordinator/admin&site_id=<?php echo $_REQUEST['site_name_id'];?>"><span class="back_btn hvr-underline-from-center" ><i class="pe-7s-refresh" ></i>Back</span></a>
</div>
<?php }?>
</div>

</div>

<div class="col-md-12 pad_no">

<form name="panel_reading_entry" id="panel_reading_entry" class="form-horizontal" method="post" action="#">
<?php
 $prev_date = date('Y-m-d', strtotime("-1 days"));
   $cur_time=date('H:i');
   $c1=strtotime($cur_time);
   $def_time="08:00";
   $c2=strtotime($def_time);
   if($c1<$c2){
     $e_date=$prev_date;
   }else{
    $e_date=date('Y-m-d'); 
   }
   ?>
 <div class="form-group">
  <div class="col-sm-2">

    <strong>From Date</strong>

             <input type="date" class="form-control numeric" name="from_date" id="from_date"  value="<?php if($_REQUEST['from_date']!='') { echo $_REQUEST['from_date']; } else { echo date("Y-m-d"); } ?>">

    </div>

    <div class="col-sm-2">

   <strong>To Date </strong>

               <input type="date" class="form-control numeric" name="to_date" id="to_date" value="<?php if($_REQUEST['to_date']!='') { echo $_REQUEST['to_date']; } else { echo date("Y-m-d"); } ?>">
             

    </div>

  

    <div class="col-sm-2" ><strong>Site Name</strong>

<select name="site_name" id="site_name" class="form-control all_site_co select2" style="width:100%" onChange="get_plant_name_filter_display(site_name.value)"  multiple>
  
 <?php 
         if($ses_site=='All'){ ?>
        
       <?php 
  if($_REQUEST['site_name_id']!=''){ $site_name="id in($_REQUEST[site_name_id])";  }else{
       $site_name="id!=''";}
}else{
  if($_REQUEST['site_name_id']!=''){ $site_name="id in($_REQUEST[site_name_id])";  }else{
       $site_name="id in($ses_site)";}
  
}

  $sql = "select * FROM site_creation where site_status='1' and $site_name order by site_name ASC";

  $sql_exe=mysql_query($sql);

  while($rsdata=mysql_fetch_object($sql_exe))

  {

  $id=$rsdata->id;

  $site_name=$rsdata->site_name;

   $value=explode(',',$_GET['site_id']);
  
    
   ?>

   <option value="<?php echo $id;?>" <?php foreach($value as $val){if($id==$val){?> selected<?php } }?>><?php echo $site_name;?></option>

    <?php 
    } ?>

  </select>   

  

                </div>


<div class="col-sm-2"><strong>Plant Name </strong> 

  

   <div id="panel_plant_namess">
        <select name="plant_name" id="plant_name" onChange="" class="form-control all_plant_co select2  " style="width:100%" multiple>
          <?php
          if ($ses_site == 'All') { ?>  <?php } ?>
          <?php
          if ($ses_site == "All") {
            $sql = "select * FROM plant_creation order by id ASC";
            $sql_exe = mysql_query($sql);
          } else {
            $sql = "select * FROM plant_creation where site_id IN ($ses_site) order by id ASC";
            $sql_exe = mysql_query($sql);
          }
          while ($rsdata = mysql_fetch_object($sql_exe)) {
            $plant_id = $rsdata->id;

            $plant = $rsdata->plant;
            $site_id1 = $rsdata->site_id;

            $value=explode(',',$_GET['plant_id']);
          ?>

            <option value="<?php echo $plant_id; ?>" <?php foreach($value as $val){if($plant_id==$val){?> selected<?php } }?>><?php echo $plant; ?></option>

          <?php

          } ?>

        </select>

      </div>
  </div>

    

    

    

    <div class="col-sm-2">

   <strong>Type </strong>


 <select name="breakdown_type" id="breakdown_type" class="form-control" style="width:100%" >
               <option value="">Select</option>
               <?php $sql=mysql_query("select * from  breakdown_type_creation where  breakdown_id!='' order by breakdown_id asc");
            while($fetch_detail=mysql_fetch_array($sql))
              { ?>
              <option value="<?php echo  $fetch_detail['breakdown_id']; ?>"<?php if($fetch_detail['breakdown_id']==$_REQUEST['breakdown_type']){ echo "selected"; } ?>><?php echo  $fetch_detail['breakdown_type']; ?></option>
            <?php }?>
                </select>
              </div>

       <?php if($_GET['site']!='site'){ ?>
        <div class="col-sm-2" style="margin-top:19px;">

     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

     <input id="follow" type="button" class="btn btn-info "  name="follow" value="GO" 

     onClick="get_breakdown_list()"  />

    </div>
 <?php } ?>
        


        <input type="hidden" name="site" id="site" value="<?php echo $_GET['site'];?>">
        <input type="hidden" name="site_name_id" id="site_name_id" value="<?php echo $_GET['site_name_id'];?>">

        <input type="hidden" name="from_date_hide" id="from_date_hide" value="<?php echo $_GET['from_date'];?>">

        <input type="hidden" name="to_date_hide" id="to_date_hide" value="<?php echo $_GET['to_date'];?>">


         <?php if($_GET['site']=='site'){ ?>
           <div class="form-group">
     <?php if($_GET['site']=='site'){ ?>
     
    <div class="col-sm-2"><strong>Status </strong> 

  <select name="status" id="status" class="form-control">
            <option value="0"<?php if($_REQUEST['status']==0){ echo "selected"; } ?>>Pending</option>
            <option value="1"<?php if($_REQUEST['status']==1){ echo "selected"; } ?>>Verified</option>                 
           </select>

  </div>
    <?php } ?> </div>
         <div class="col-sm-2" style="margin-top:19px;">

     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

     <input id="follow" type="button" class="btn btn-info "  name="follow" value="GO" 

     onClick="get_breakdown_list(),get_pannelgo_value();"  />
     <input type="hidden" name="panelgovalue" id="panelgovalue">

    </div> <?php } ?>

</div>

<!-------------edit_starts------------------------->

<div class="col-sm-2">
    
<input type="hidden" class="form-control" name="type_v" id="type_v" value="7">
	  
</div>

<!--------------edit_ends-------------------------> 


 </form>

<script>
//     function excel_value(from_date,to_date,type_v,site_name,breakdown_type,plant_name){
 
// //  console.log("site_name:" +site_name);

//  window.location.href="breakdown_entry/stock_excel_list_breakdown_entry.php?from_date="+from_date+"&to_date="+to_date+"&type="+type_v+"&site_name="+site_name+"&breakdown_type="+breakdown_type+"&plant_name="+plant_name;

//     }

///////////////////edit_ends////////////////////////////////
</script>



</div>

</div>

<div id="breakdown_list_div">

<?php //include("tipper_entry_list.php"); ?>
  
  <div id="">



<a><img  align="right" onclick="breakdown_main_print_go('<?php echo $_SESSION['user_types'];?>','<?php echo $_SESSION['sess_site_id'];?>');" src="image/report_print.png" width="35" height="35" border="0" title="PRINT" value="Print" style="float:center;"/></a> 

<!---------edit_starts---------------------->
<img align="right" src="image/excel-icon.png" onclick="excel_value('<?php echo $_SESSION['user_types'];?>','<?php echo $_SESSION['sess_site_id'];?>');" width="35" height="35" title="Click to export sublist" />

<!----------edit_ends------------------------>


<div id="silder">
<?php if($_GET['site']=='site'){ ?>
 
  <a style="float:right;" href="breakdown_entry/modal_slider.php?from_date=<?php echo $_REQUEST['from_date']; ?>&to_date=<?php echo $_REQUEST['to_date']; ?>&site_name=<?php echo $_REQUEST['site_name'];?>&breakdown_type=<?php echo $_REQUEST['breakdown_type'];?>&status=<?php echo $_REQUEST['status'];?>&site_name_id=<?php echo $_REQUEST['site_name_id'];?>&site=<?php echo $_REQUEST['site'];?>&plant_name=<?php echo $_REQUEST['plant_name'];?>" accesskey="o" data-toggle="modal" data-target="#myModal" title="BreakDown Entry Verification " data-remote="true" id="slider"  class="btn btn-default"><span align="right" class="glyphicon glyphicon-zoom-in"></span></a>  
 
  <!-- <a ><img  align="right" onclick="breakdown_main_print12('<?php echo $_SESSION['user_types'];?>','<?php echo $_SESSION['sess_site_id'];?>');" src="image/approved.png" width="35" height="35"  /></a>  -->

  <?php } ?>
</div>
<!-- 
<?php 

if($_REQUEST['from_date']==''){?>
  <a  tabindex=""  href="javascript:breakdown_main_print('breakdown_entry/breakdown_main_print.php?from_date=<?php echo $_REQUEST['from_date']; ?>&to_date=<?php echo $_REQUEST['to_date']; ?>&site_name=<?php echo $_REQUEST['site_name'];?>&breakdown_type=<?php echo $_REQUEST['breakdown_type'];?>&status=<?php echo $_REQUEST['status'];?>&site_name_id=<?php echo $_REQUEST['site_name_id'];?>&site=<?php echo $_REQUEST['site'];?>&plant_name=<?php echo $_REQUEST['plant_name'];?>'); "  style="float:center;" ><img  align="right" src="image/report_print.png" width="35" height="35" border="0" title="PRINT" value="Print"/></a>
<?php } else{?> 
    <a><img  align="right" onclick="breakdown_main_print_go('<?php echo $_SESSION['user_types'];?>','<?php echo $_SESSION['sess_site_id'];?>');" src="image/report_print.png" width="35" height="35" border="0" title="PRINT" value="Print" style="float:center;"/></a> 
   <?php } ?> -->


&nbsp;&nbsp;

 <div id="curd_message" align="center" style="font-weight:bold; padding:5px;"></div>

<table id="empTable_breakdown" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

        <thead>

            <tr>

                 <th width="4%">#</th>

                <th width="11%">Date</th>

                <th width="15%">Breakdown No</th>

                <th width="21%">Site Name </th>
                <th width="21%">Plant Name </th>


                <th width="15%" >Shift Name</th>

                <th width="15%" style="text-align:left">Total Time&nbsp;</th>

        

                <th width="5%" style="text-align:center">View</th>

            <?php 

            if($_REQUEST['site']!='site'){

            if(($user_types=='30')) { 
              ?> 
              <th width="9%" style="text-align:center">Verify</th> 
            <?php } 
          }?>


                <th width="9%" style="text-align:center">Action</th>


        

               <!--  <th width="5%" style="text-align:center">View</th> -->

                <!-- <th width="9%" style="text-align:center">Action</th> -->

           </tr>

        </thead>
       


    <?php 
          



$db->close();

?>

</tbody>
<tfoot>
  
</tfoot>

     
</table>

</div>

</div>

<script>
function get_pannelgo_value()
  {
//console.log("function");
$("#panelgovalue").val("1");

  }
  $(document).ready(function(){

  var site="<?php echo $_REQUEST['site']; ?>";
  var from_d="<?php echo $_REQUEST['from_date']; ?>";
  var to_d="<?php echo $_REQUEST['to_date']; ?>";

   get_breakdown_list(site,from_d,to_d);
   //get_breakdown_list_ready();
 });

function get_breakdown_list(site,from_d,to_d) 
{
  if(site=='site'){
  if(from_d!=''){
   var from_date =from_d ; 
    var to_date =to_d;
  }else{
    var from_date ='' ; 
    var to_date ='';
  }

}else{
 var from_date =$('#from_date').val() ; 
    var to_date =$('#to_date').val();

}

  /*var from_date =$('#from_date').val() ;
  var to_date =$('#to_date').val();*/
  var breakdown_type =$('#breakdown_type').val();
   
  var site =$('#site').val();
  var site_name_id =$('#site_name_id').val() ; 
  if(site=='site')
  {
    var app_status=$('#status').val();
  }
  else
  {
    var app_status='';
  }
  var site_ids = [];
  jQuery.each(jQuery('.all_site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();


     var plant_ids = [];
  
   jQuery.each(jQuery('.all_plant_co option:selected'), function() {
        plant_ids.push(jQuery(this).val()); 
    });
   
    var plant_ids=plant_ids.toString();
//alert(site_ids+" - "+plant_ids);
var slide='breakdown_entry/modal_slider.php?from_date='+from_date+'&to_date='+to_date+'&site_name='+site_ids+'&breakdown_type='+breakdown_type+'&status='+app_status+'&site='+site+'&site_name_id='+site_name_id+'&plant_name='+plant_ids;

var s1=$("#slider").removeAttr('href');

var s2=$("#slider").attr('href',slide);



var print='breakdown_entry/breakdown_main_print.php?from_date='+from_date+'&to_date='+to_date+'&site_name='+site_ids+'&breakdown_type='+breakdown_type+'&status='+app_status+'&site='+site+'&site_name_id='+site_name_id+'&plant_name='+plant_ids;

var s12=$("#main_print").removeAttr('href');

var s22=($("#main_print").attr('href',(print)));
     
  var table_name= $('#empTable_breakdown').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      
      'ajax': {
          'url':'breakdown_entry/ajaxfile.php',

           data: {"from_date":from_date,"to_date":to_date,"breakdown_type":breakdown_type,"site_name":site_ids,"site":site,"status":app_status,"site_name_id":site_name_id,"plant_name":plant_ids},
      },
      'columns': [
            { data: 'sno' },
              { data: 'date' },
            //  
              { data: 'breakdown_no' },
              { data: 'site' },
              { data: 'plant' },
              { data: 'shift' },
            { data: 'overall_time' },
           { data: 'view' },
           <?php if($_REQUEST['site']!='site'){if(($user_types=='30')) {?>
           { data: 'verified_status' },
            <?php } }?>
             { data: 'action' },
      ],

   destroy: true,



});
  //table_name.destroy();

}

function get_breakdown_list_ready() 
{

  var from_date ='';
  var to_date ='';
  var breakdown_type =$('#breakdown_type').val();
   
  var site =$('#site').val();
  var site_name_id =$('#site_name_id').val() ; 
  if(site=='site')
  {
    var app_status=$('#status').val();
  }
  else
  {
    var app_status='';
  }
  var site_ids = [];
  jQuery.each(jQuery('.all_site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();


     var plant_ids = [];
  
   jQuery.each(jQuery('.all_plant_co option:selected'), function() {
        plant_ids.push(jQuery(this).val()); 
    });
   
    var plant_ids=plant_ids.toString();

var slide='breakdown_entry/modal_slider.php?from_date='+from_date+'&to_date='+to_date+'&site_name='+site_ids+'&breakdown_type='+breakdown_type+'&status='+app_status+'&site='+site+'&site_name_id='+site_name_id;

var s1=$("#slider").removeAttr('href');

var s2=$("#slider").attr('href',slide);
     
  var table_name= $('#empTable_breakdown').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      
      'ajax': {
          'url':'breakdown_entry/ajaxfile.php',

           data: {"from_date":from_date,"to_date":to_date,"breakdown_type":breakdown_type,"site_name":site_ids,"site":site,"status":app_status,"site_name_id":site_name_id,"plant_name":plant_ids},
      },
      'columns': [
            { data: 'sno' },
              { data: 'date' },
            //  
              { data: 'breakdown_no' },
              { data: 'site' },
              { data: 'plant' },
              { data: 'shift' },
            { data: 'overall_time' },
           { data: 'view' },
            <?php if(($_REQUEST['site']=='site')||($user_types=='30')) {?>
           { data: 'verified_status' },
            <?php }?>
             { data: 'action' },
      ],

   destroy: true,



});
  //table_name.destroy();

}


</script>
<script>

function breakdown_indi_print(url)

{

  onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}


function breakdown_main_print(url)

{

  onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}

function breakdown_main_print_go(user_name,sess_staff_id)
{
var from_d ="<?php echo $_REQUEST['from_date'];?>"; 
    var to_d ="<?php echo $_REQUEST['to_date1'];?>";
  var site="<?php echo $_REQUEST['site'];?>";
var panelgovalue=$("#panelgovalue").val();
if(site=='site'){
  
  if(from_d!='' && panelgovalue==''){ 
    
  var from_date =from_d ; 
    var to_date =to_d;
  }else if(from_d=='' && panelgovalue==''){
    var from_date ='' ; 
    var to_date='';
  }
else if(from_d=='' && panelgovalue=='1'){
    var from_date =$('#from_date').val(); 
    var to_date=$('#to_date').val();
  }
}else{
    var from_date =$('#from_date').val(); 
    var to_date=$('#to_date').val();
    
}
/*var from_date = $('#from_date').val();
var to_date = $('#to_date').val();*/
var breakdown_type =$('#breakdown_type').val();
//var status =$('#status').val();
 var site =$('#site').val();
  var site_name_id =$('#site_name_id').val() ; 
   if(site=='site')
  {
    var status=$('#status').val();
  }
  else
  {
    var status='';
  }
//alert(breakdown_type);
  var site_ids = [];
  
   jQuery.each(jQuery('.all_site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();



 var plant_ids = [];
  
   jQuery.each(jQuery('.all_plant_co option:selected'), function() {
        plant_ids.push(jQuery(this).val()); 
    });
   
    var plant_ids=plant_ids.toString();

    //alert(from_date+" - "+to_date+" - "+site_ids+" -"+plant_ids );

var url ="breakdown_entry/breakdown_main_print.php?from_date="+from_date+"&to_date="+to_date+"&site_name="+site_ids+"&plant_name="+plant_ids+"&user_types="+user_name+"&sess_site_id="+sess_staff_id+"&site="+site+"&site_name_id="+site_name_id+"&status="+status+"&breakdown_type="+breakdown_type;

  onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


function excel_value(user_name,sess_staff_id)
{
var from_d ="<?php echo $_REQUEST['from_date'];?>"; 
var to_d ="<?php echo $_REQUEST['to_date1'];?>";
var site="<?php echo $_REQUEST['site'];?>";
var panelgovalue=$("#panelgovalue").val();

if(site=='site'){
  if(from_d!='' && panelgovalue==''){ 
    var from_date =from_d ; 
    var to_date =to_d;
  }else if(from_d=='' && panelgovalue==''){
    var from_date ='' ; 
    var to_date='';
  }
  else if(from_d=='' && panelgovalue=='1'){
    var from_date =$('#from_date').val(); 
    var to_date=$('#to_date').val();
  }}else{
    var from_date =$('#from_date').val(); 
    var to_date=$('#to_date').val();
  }

var breakdown_type =$('#breakdown_type').val();
var site =$('#site').val();
var site_name_id =$('#site_name_id').val() ; 
if(site=='site'){
  var status=$('#status').val();
}else{
  var status='';
}
var site_ids = [];
jQuery.each(jQuery('.all_site_co option:selected'), function() {
  site_ids.push(jQuery(this).val()); 
});
var site_ids=site_ids.toString();


var plant_ids = [];
jQuery.each(jQuery('.all_plant_co option:selected'), function() {
plant_ids.push(jQuery(this).val()); 
});
var plant_ids=plant_ids.toString();


window.location.href="breakdown_entry/stock_excel_list_breakdown_entry.php?from_date="+from_date+"&to_date="+to_date+"&site_name="+site_ids+"&plant_name="+plant_ids+"&user_types="+user_name+"&sess_site_id="+sess_staff_id+"&site="+site+"&site_name_id="+site_name_id+"&status="+status+"&breakdown_type="+breakdown_type;
}


function breakdown_main_print123(url)

{

  onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}





function get_breakdown_list_1234(from_date,to_date,breakdown_type,status,site_name_id)

{
   var site_name_id="<?php echo $_REQUEST['site_name_id']; ?>";
    //alert(site_name_id);


    var site_ids = [];
  
   jQuery.each(jQuery('.all_site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();



 var plant_ids = [];
  
   jQuery.each(jQuery('.all_plant_co option:selected'), function() {
        plant_ids.push(jQuery(this).val()); 
    });
   
    var plant_ids=plant_ids.toString();

    //alert(site_ids);

    site="<?php echo $_REQUEST['site']; ?>";


   jQuery.ajax({

    type: "POST",

    url: "breakdown_entry/breakdown_list.php",

    data: "from_date="+from_date+"&to_date="+to_date+"&site_name="+site_ids+"&breakdown_type="+breakdown_type+"&status="+status+"&site="+site+"&site_name_id="+site_name_id+"&plant_name="+plant_ids,

    success: function(data) {

    jQuery("#breakdown_list_div").html(data);

      }

    });

    }





</script>


<script>

  //$.widget.bridge('uibutton', $.ui.button);

  $(function () {


    //Initialize Select2 Elements

    $(".select2").select2();

  });
  
function export_tipper_form(from_date,to_date,site_name,vehicle_type,vehicle_no)
{ 
  window.location.href="tipper_entry/export.php?from_date="+from_date+"&to_date="+to_date+"&site_name="+site_name+"&vehicle_type="+vehicle_type+"&vehicle_no="+vehicle_no;
}

</script>
<style type="text/css">
  .back_btn
{
background-color: #8e1bab;
padding: 10px 15px;
box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.3); 
color: #fff;
border-radius:4px;
text-transform: uppercase;
font-weight: bold;
}
.back_btn i
{
font-size: 15px;
padding-right: 6px;
font-weight: bold;  
}
.back_btn:hover
{
background-color: #8a8a8a;
}
/* Underline From Center */
.hvr-underline-from-center {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  position: relative;
  overflow: hidden;
}
.hvr-underline-from-center:before {
  content: "";
  position: absolute;
  z-index: -1;
  left: 51%;
  right: 51%;
  bottom: 0;
  background: #2098D1;
  height: 4px;
  -webkit-transition-property: left, right;
  transition-property: left, right;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-timing-function: ease-out;
  transition-timing-function: ease-out;
}
.hvr-underline-from-center:hover:before, .hvr-underline-from-center:focus:before, .hvr-underline-from-center:active:before {
  left: 0;
  right: 0;
}


</style>
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
    
    

    