

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

  $random_nos = $record['random_no'];

  $random_scs = $record['random_sc'];

  $breakdown_no = $record['breakdown_no'];

  $entry_date  = $record['entry_date'];

  $site_name_edit = $record['site_name'];

  $shift_name_edit = $record['shift_name'];

  $user_name_edit = $record['user_name'];

   $plant_name_edit=$record['plant_name'];


   $staff_name=get_staff_name($user_name_edit);



}



  ?><input type="hidden" name="random_no" id="random_no" value="<?php echo $random_nos; ?>"/> 

   <input type="hidden" name="random_sc" id="random_sc" value="<?php echo $random_scs; ?>"/>



<div class="box box-info">

            <form class="form-horizontal"  method="POST">

              <div class="box-body">

              <div class="form-group">

                   <label class="col-sm-2 control-label font_label"  >Breakdown&nbsp;No</label>

            

        <div class="col-sm-2">

<input type="hidden" readonly name="breakdown_no" id="breakdown_no" class="text_box" style="font-size:12px" value="<?php  echo $breakdown_no;?>" /><strong> <span style="color:#FF0000;"><strong><?php  echo $breakdown_no;?></strong></span>

    </strong> </div>

          

                   <label class="col-sm-5 control-label font_label"  >Date/Time&nbsp;<span style="color:#F00">*</span></label>

                <div class="col-sm-3">
                  <input type="datetime-local" class="form-control" name="date" id="date" value="<?php echo $entry_date;?>" readonly/>
<!--<?php if($_GET['update_id']==''){ ?>
                     <input type="datetime-local" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d').'T'.date('h:i:s'); ?>"  tabindex="1">
             <?php } else {?>
                     <input type="datetime" class="form-control" name="date" id="date" value="<?php echo date('Y-m-d h:i:s',strtotime($entry_date)); ?>"  tabindex="1" readonly>
                 <?php } ?>-->
                </div>   

                </div>

                 <div class="form-group">   

                 <label class="col-sm-2 control-label font_label"  >Site&nbsp;Name<span style="color:#F00" >*</span></label>

                            <div class="col-sm-3" >

      

        <select name="site_name" id="site_name"  class="form-control  " style="width:100%" onChange="get_invce_no(site_name.value),get_plant_name_breakdown(site_name.value);" disabled>

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

            $site_name=$rsdata->site_name;

                       

                        ?>

                        <option value="<?php echo $id_site;?>" <?php if($id_site==$site_name_edit){ ?> selected <?php }?>><?php echo $site_name;?></option>

                        <?php

                    }?>

                </select>      

              

               </div>


               <label class="col-sm-4 control-label font_label">Plant&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3">

      

 <div id="plant_name_div">
 <select name="plant_name" id="plant_name" onChange="" class="form-control " style="width:100%" disabled>

                    <?php 

          if($sess_site_id=="All")

          {

                    $sql = "select * FROM plant_creation order by id ASC";
                    $sql_exe=mysql_query($sql);
          }

          else

          {

                   $sql ="select * FROM plant_creation where site_id in ($sess_site_id) order by id ASC";
                    $sql_exe=mysql_query($sql);

          }

                   
                  while($rsdata=mysql_fetch_object($sql_exe))

                       {

                      

                        $plant_id=$rsdata->id;

                        $plant=$rsdata->plant;

                       

                        ?>

                        <option value="<?php echo $plant_id;?>" <?php if($plant_name_edit==$plant_id){ ?> selected<?php }?>><?php echo $plant;?></option>

                        <?php

                    }?>

                </select>   
               </div>    
</div>

             </div>

                             <div class="form-group">   



                 <label class="col-sm-2 control-label font_label"  >Shift&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3" >

      

        <select name="shift_name" id="shift_name" class="form-control  " style="width:100%" onChange="get_shift_breakdown(this.value,date.value),get_frm_to_time(this.value,date.value);" disabled="">

        <option value="">Select</option>

                    <?php 

                    $sql = "select * FROM shift_creation where status!='1' order by shift_name ASC";



                    $sql_exe=mysql_query($sql);

                    while($rsdata=mysql_fetch_object($sql_exe))

                    {

                        $shift_id=$rsdata->shift_id;

                        $shift_name=$rsdata->shift_name;

                     

                        ?>

                        <option value="<?php echo $shift_id;?>"<?php if($shift_id==$shift_name_edit){ ?> selected <?php }?> ><?php echo $shift_name;?></option>

                        <?php

                    }?>

                </select>      

              

               </div>  

                 

                       

                  <label class="col-sm-4 control-label font_label" >Staff&nbsp;Name<span style="color:#F00">*</span></label>

                            <div class="col-sm-3" >
                     <select name="user_name" id="user_name" class="form-control  " style="width:100%"disabled="">
                      <option value="<?php echo $user_name_edit;?>" ><?php echo ucfirst($staff_name);?></option>
                     </select>
     

               </div>    
</div>
                

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


 <div align="center" >

<button type="button" id="button" class="btn btn-info" onClick="update_breakdown_main11(random_no.value,random_sc.value,breakdown_no.value,date.value,site_name.value,shift_name.value,user_name.value,'<?php echo $_GET['update_id']; ?>','<?php echo $_REQUEST['from_date']; ?>','<?php echo $_REQUEST['to_date']; ?>','<?php echo $_REQUEST['site_name']; ?>','<?php echo $_REQUEST['breakdown_type']; ?>','<?php echo $_REQUEST['status']; ?>','<?php echo $_REQUEST['site']; ?>','<?php echo $_REQUEST['site_name_id']; ?>','<?php echo $_REQUEST['plant_name']; ?>')">UPDATE</button>
<button type="button" class="btn btn-info" data-dismiss="modal" >CLOSE</button>

</div>

                

                </div>

                </div>

            

                </form></div>

                

                <?php $db->close();

?>

<script>

  //$.widget.bridge('uibutton', $.ui.button);

  $(function () {

    //Initialize Select2 Elements

    $(".select2").select2();

  });

  $('.sl').select2({

        placeholder:'Select'   

    })

  </script>