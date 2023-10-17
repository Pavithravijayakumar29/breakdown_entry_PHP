<?php 
error_reporting(0);

ob_start();

session_start();

require("../model/config.inc.php"); 

require("../model/Database.class.php");

include("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect();

 $sess_user_id=$_SESSION['sess_user_id'];

 $session_user_name=$_SESSION['sess_user_name'];

 $user_type_ids=$_SESSION['user_type_ids'];

 $user_types=$_SESSION['user_types'];

 $sess_site_id=$_SESSION['sess_site_id'];

 $ipaddress = $_SESSION['sess_ipaddress'];

 $entry_date=$_SESSION['entry_date'];
 
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

$random_sc = date('dmyhis');

$random_no1 = date('his');

$random_no = rand(00000, 99999);



if(!isset($_GET['breakdown_no']))

{

  $rs1=mysql_query("select breakdown_no from   breakdown_entry order by id desc");

  if($res1=mysql_fetch_assoc($rs1))

  {

    $pur_array=explode('-',$res1['breakdown_no']);

  

       $year1=$pur_array[1];

        $year2=substr($year1, 0, 2);

      $year='20'.$year2;

    $enquiry_no=$pur_array[2];

  }

  if($enquiry_no=='')

    {$enquiry_nos='BRDN-'.$datee.'-0001';
  $ran_no='BRDN'.$datee."0001".$random_no.$random_no1;
}
  elseif($year!=date("Y"))
{
    $enquiry_nos='BRDN-'.$datee.'-0001';
    $ran_no='BRDN'.$datee."0001".$random_no.$random_no1;
}
  else

  {

    $enquiry_no+=1;

    $enquiry_nos='BRDN-'.$datee.'-'.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT);
$ran_no='BRDN'.$datee.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT).$random_no.$random_no1;

  }

  

}

	

 /*$date=date("Y");

		$month=date("m");

		 $year=date("d");

		 $hour=date("h");

		 $minute=date("i");

		$second=date("s");

		$random_sc = date('dmyhis');

		$random_no = rand(00000, 99999);
*/
		

		//$mode_type='panel_reading_entry';

		//get_mu_status($ipaddress,$enquiry_nos,$mode_type);

		

  ?>

  <input type="hidden" name="random_no" id="random_no" value="<?php echo $ran_no; ?>"/> 

  <input type="hidden" name="random_sc" id="random_sc" value="<?php echo $random_sc; ?>"/>



<div class="box box-info">

            <form class="form-horizontal"  method="POST">

              <div class="box-body">

              <div class="form-group">   

              

      <label class="col-sm-2 font_label" style="vertical-align:bottom" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Breakdown&nbsp;No </label>

   <div id="invoice_div">       <div class="col-sm-2">

<input type="hidden" readonly name="breakdown_no" id="breakdown_no" class="text_box" style="font-size:12px" value="<?php  echo $enquiry_nos;?>" /><strong> <span style="color:#FF0000;"><strong><?php  echo $enquiry_nos;?></strong></span>

    </strong> </div></div>

    <div class="col-sm-2"></div>

          

                  <label class="col-sm-2 font_label">Date/Time</label>

                <div class="col-sm-3">

                     <input type="datetime-local" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d').'T'.date('H:i:s'); ?>"  tabindex="1" onKeyUp="get_date_validation(date.value)">



                </div>   

                </div>

                

              <div class="form-group">   

                 <label class="col-sm-2 control-label font_label"  >Site&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3" >

      

   <select name="site_name" id="site_name" class="form-control site_co " style="width:100%" onChange="get_invce_no(site_name.value),get_plant_name_breakdown(site_name.value),get_machinery_value_list(breakdown_type.value,site_name.value,plant_name.value);" >

        <option value="">Select</option>

                    <?php 

					if($sess_site_id=="All")

					{

                    $sql = "select * FROM site_creation where site_status='1' order by site_name ASC";

					}

					else

					{

                    $sql = "select * FROM site_creation where id in ($sess_site_id) and site_status='1' order by site_name ASC";

					}

                    $sql_exe=mysql_query($sql);

                    while($rsdata=mysql_fetch_object($sql_exe))

                    {

                        $id_site=$rsdata->id;

						$site_namess=$rsdata->site_name;

                       

                        ?>

                        <option value="<?php echo $id_site;?>" ><?php echo $site_namess;?></option>

                        <?php

                    }?>

                </select>      

              

	             </div>  

                               <div class="col-sm-1" ></div>


                                <label class="col-sm-2 control-label font_label">Plant&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3">

                              <div id="plant_name_div">
 <select name="plant_name" id="plant_name"  class="form-control  " style="width:100%"  >
        <option value="">Select</option>



                    <?php 

          if($sess_site_id!="All")

            {

                    $sql = "select * FROM plant_creation where site_id IN ($sess_site_id) order by id ASC";
                  
                   $sql_exe=mysql_query($sql);

           }

                     while($rsdata=mysql_fetch_object($sql_exe))

                       {

                      

                        $plant_id=$rsdata->id;
                        $site_id1=$rsdata->site_id;

                        $plant=$rsdata->plant;

                       

                        ?>

                        <option value="<?php echo $plant_id;?>"  <?php if($site_id1==$sess_site_id){ ?> selected <?php }?> ><?php echo $plant;?></option>

                        <?php

                    }?>

                </select> 

      

                             

                               </div>
                             </div>


                 
</div>

              <div class="form-group">   
                 <label class="col-sm-2 control-label font_label"  >Shift&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3" >

      

        <select name="shift_name" id="shift_name" class="form-control  " style="width:100%" onChange="get_shift_breakdown(this.value,date.value),get_frm_to_time(this.value,date.value);">

        <option value="">Select</option>

                    <?php 

                    $sql = "select * FROM shift_creation where status!='1'  order by shift_name ASC";



                    $sql_exe=mysql_query($sql);

                    while($rsdata=mysql_fetch_object($sql_exe))

                    {

                        $shift_id=$rsdata->shift_id;

                        $shift_name=$rsdata->shift_name;

                       

                        ?>

                        <option value="<?php echo $shift_id;?>" ><?php echo $shift_name;?></option>

                        <?php

                    }?>

                </select>      

              

               </div>  

                 
 
                      
                <div class="col-sm-1" ></div>
                  <label class="col-sm-2 control-label font_label" >Staff&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3 " >
                     <select name="user_name" id="user_name" class="form-control  " style="width:100%"disabled="">
                      <?php  
                    
          $staff=mysql_fetch_array(mysql_query("select user_id_a,employee_name from  View_staff_name where user_id_a='$_SESSION[sess_staff_id]'"));
          
          ?>
                       <option value="<?php echo $staff[user_id_a];?>"> <?php echo $staff[employee_name];?></option>
                     </select>
     

               </div>  
               </div>  

   <!--------------------------------------------------------------------------------------------------->

       

              <div class="box-body">

              

            

                

   <!--------------------------------------------------------------------------------------------------->
                                              <span id="breakdown_sublist_validation" style="display:none; color:red;">Fill Sublist</span>
                                <div class="form-group"> 

                   <div class="box-body">   

     <div class="col-sm-12">

     <div id="breakdown_sublist_div">

	 <?php include("breakdown_sublist.php"); ?>

     </div></div></div></div>

                 

<!---------------------------------------------------------------------------------------------->

 

                    

                </div>

              

<!---------------------------------------------------------------------------------------------->



 <div align="center" >

<button type="button" id="button" class="btn btn-info" onClick="add_breakdown_main11(random_no.value,random_sc.value,breakdown_no.value,date.value,site_name.value,shift_name.value,user_name.value,overall_tot.value,<?php echo $_REQUEST[das_status]; ?>)">SUBMIT</button>
<button type="button" class="btn btn-info" data-dismiss="modal" >CLOSE</button>

</div>

                

              

              </div>

            

                </form></div>

                

                <?php $db->close(); ?>

<script>
function get_date_validation(entry_date)
{ //alert();
  jQuery.ajax({

    type: "POST",

      url:"breakdown_entry/valid_entry_date.php",

    data: "entry_date="+entry_date,

    success: function(msg){
      var data=msg;
      var res = data.split("@@");
      var date=res[0];
        var values= res[1];
      if(values=='1'){
        alert("Check The Entry Date..!");
        $('#date').val(date);
      }

    }

  }); 
}
</script>