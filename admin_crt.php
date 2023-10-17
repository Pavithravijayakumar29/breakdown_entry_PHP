<?php 

error_reporting(0);

ob_start();

session_start();  

require_once("model/config.inc.php"); 

require_once("model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 



$user_type_ids=$_SESSION['user_type_ids'];

$session_user_name=$_SESSION['sess_user_name'];

$session_password=$_SESSION['password'];

$user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];



?>	

</script>



<div class="modal fade" data-keyboard="false" data-backdrop="static"  id="myModal" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

 <div class="modal-dialog" style="width: 80%;">

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



<div class="row space-hight">

<div class="col-md-11">
<?php if($user_types!='167'){ ?>

<a href="breakdown_entry/create.php?das_status='<?php echo $_REQUEST[das_status]; ?>'" accesskey="o" data-toggle="modal" data-target="#myModal" title="Add Breakdown" data-remote="true" class="btn btn-default"><img src="image/pen.png" width="35" height="35"></a>
<?php } ?>
<span class="topic-header">Breakdown Entry</span>	

</div>
<div class="col-md-1">
  <?php 
  if($_REQUEST[das_status]==1)
    {
      ?>
 <a href="index1.php?hopen=site_coordinator/admin&site_id=<?php echo $_REQUEST[das_site_name]; ?>"><span class="back_btn hvr-underline-from-center" ><i class="pe-7s-refresh" ></i>Back</span></a>
<?php } ?>
</div>
</div>

<div class="col-md-12 pad_no">

<form name="panel_reading_entry" id="panel_reading_entry" class="form-horizontal" method="post" action="#">

	

    <div class="col-sm-2">

    <strong>From Date</strong>

             <input type="date" class="form-control numeric" name="from_date" id="from_date"  value="<?php if($_REQUEST[from_date]!='') { echo $_REQUEST[from_date]; } else { echo date("Y-m-d"); } ?>">

    </div>

    <div class="col-sm-2">

   <strong>To Date</strong>

               <input type="date" class="form-control numeric" name="to_date" id="to_date" value="<?php if($_REQUEST[to_date]!='') { echo $_REQUEST[to_date]; } else { echo date("Y-m-d"); } ?>">

             

    </div>

    <div class="col-sm-2">

   <strong>Site Name </strong>

    <select name="site_name" id="site_name" class="form-control  site_co select2" style="width:100%"  onChange="get_plant_name_filter_display(site_name.value)" multiple>

      

                     <?php 

					if($_GET[das_site_name]!='')

					{?>
            <?php        $sql = "select * FROM site_creation where id IN ($_GET[das_site_name]) and site_status='1' order by site_name ASC";

					}
                    
                    
                    elseif($sess_site_id=="All")

					{?>


                    <?php

                    $sql = "select * FROM site_creation where site_status='1' order by site_name ASC";

					}
					else

					{?>
            <?php

                    $sql = "select * FROM site_creation where id IN ($sess_site_id) and site_status='1' order by site_name ASC";

					}

                    $sql_exe=mysql_query($sql);

                    while($rsdata=mysql_fetch_object($sql_exe))

                    {

                        $id_site=$rsdata->id;

						$site_namess=$rsdata->site_name;

                       

                        ?>

                        <option value="<?php echo $id_site;?>" <?php if($id_site==$_REQUEST[site_name]){ echo "selected"; } ?> ><?php echo $site_namess;?></option>

                        <?php

                    }?>

                </select>      

           

         </div>


         <div class="col-sm-2">

   <strong>Plant Name </strong>

     <div id="panel_plant_namess">

        <select name="plant_name" id="plant_name" onChange="" class="form-control plant_co select2  " style="width:100%" >

         <option value=""></option>

                  

                </select>      

              </div>
           

         </div>

         

     

               <div class="col-sm-2">

   <strong>Type </strong>



          

       <!--  <select name="breakdown_type" id="breakdown_type"  class="form-control  " style="width:100%" >

           <option value="">Select</option>
              <option value="Mechanical Section">Mechanical Section</option>
              <option value="Operational Section">Operational Section</option>
              <option value="Electrical Section">Electrical Section</option>   

                </select>       -->
  <select name="breakdown_type" id="breakdown_type" class="form-control" style="width:100%" >
               <option value="">Select</option>
               <?php $sql=mysql_query("select * from  breakdown_type_creation where  breakdown_id!='' order by breakdown_id asc");
            while($fetch_detail=mysql_fetch_array($sql))
              { ?>
              <option value="<?php echo  $fetch_detail['breakdown_id']; ?>"<?php if($fetch_detail['breakdown_id']==$_REQUEST[breakdown_type]){ echo "selected"; } ?>><?php echo  $fetch_detail['breakdown_type']; ?></option>
            <?php }?>
                </select>
              

           </div>
                <div class="form-group">

         <div class="col-sm-1">
          <label>Status</label>
           <select name="status" id="status" class="form-control">
            <option value="0"<?php if($_REQUEST[status]==0){ echo "selected"; } ?>>Pending</option>
            <option value="1"<?php if($_REQUEST[status]==1){ echo "selected"; } ?>>Verified</option>                 
           </select>
         </div>


      <div class="col-sm-1" style="margin-top:19px;">

     <!-- <input id="factoryentry" type="submit"  class="btn btn-info"  name="factoryentry" value="GO"  />-->

                   <input id="follow" type="button" class="btn btn-info "  name="follow" value="GO"

                    onclick="get_breakdown_list(from_date.value,to_date.value,breakdown_type.value,status.value,'<?php $_REQUEST[das_site_name];?>')"  />

    </div>
      </div>

</form>



</div>

</div>

 



<div id="breakdown_list_div">

 <?php 

 include("breakdown_list.php");

 

 ?>

</div>

<script>

function breakdown_indi_print(url)

{

	onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}



function breakdown_main_print(url)

{

	onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}





function get_breakdown_list(from_date,to_date,breakdown_type,status,das_site_name)

{
   var das_site_name="<?php echo $_REQUEST[das_site_name]; ?>";
    //alert(das_site_name);


    var site_ids = [];
  
   jQuery.each(jQuery('.site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();



 var plant_ids = [];
  
   jQuery.each(jQuery('.plant_co option:selected'), function() {
        plant_ids.push(jQuery(this).val()); 
    });
   
    var plant_ids=plant_ids.toString();

    //alert(site_ids);

    das_status="<?php echo $_REQUEST[das_status]; ?>";


   jQuery.ajax({

	  type: "POST",

	  url: "breakdown_entry/breakdown_list.php",

	  data: "from_date="+from_date+"&to_date="+to_date+"&site_name="+site_ids+"&breakdown_type="+breakdown_type+"&status="+status+"&das_status="+das_status+"&das_site_name="+das_site_name+"&plant_name="+plant_ids,

	  success: function(data) {

	  jQuery("#breakdown_list_div").html(data);

	    }

		});

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


