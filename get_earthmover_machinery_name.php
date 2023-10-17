<?php 

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 
require_once("../include/common_function.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 


 $site_name = $_REQUEST['site_name'];
 $plant_name = $_REQUEST['plant_name'];
 $breakdown_type = $_REQUEST['breakdown_type'];
 $date_value = $_REQUEST['date'];
 //echo $sql = "SELECT Distinct(mechinary_type)as mechinary_type FROM plant_machinery_list WHERE list_id!='' and site_name='$site_name' and plant_id='$plant_name' order by mechinary_type asc ";
//  if($breakdown_type=='8' || $breakdown_type='13' || $breakdown_type='7')        {            echo "//"; 
//echo "select (vehicle_no) as vehicle_no  from   machinerie_entry  where  (entry_date)='$date_value' and vehicle_no!=''  group by vehicle_no     	 UNION ALL    	 select (vehicle_no) as vehicle_no from  tipper_entry  where  (entry_date)='$date_value'   and vehicle_no!='' group by vehicle_no ";
?> 

    <select  name="machinery_type" id="machinery_type" class="form-control "  style="width:100%" onChange="get_equipment_type_1(this.value,);">
        <option value="">Select</option>

                             <?php 
                             
                             $sql11="select (vehicle_no) as vehicle_no  from   machinerie_entry  where  (entry_date)='$date_value' and vehicle_no!=''  group by vehicle_no 
    	 UNION ALL
    	 select (vehicle_no) as vehicle_no from  tipper_entry  where  (entry_date)='$date_value'   and vehicle_no!='' group by vehicle_no ";
       
        $rows11 = $db->fetch_all_array($sql11);
        foreach($rows11 as $record1)
        {
          $IN_values[]	= $record1['vehicle_no'];
    	  $IN_vals=implode(',',$IN_values);
    	  
    	}
    	
    	/******************************************************************/
    	if($IN_vals!='')
    	{
       $sql1="select * from   vehicle_entry where site_name='$site_name' and  equip_field!='Genset' and id IN ($IN_vals)  group by equipment_type order by  id ASC";
    	}
    	else
    	{
          $sql1="select * from   vehicle_entry where  id=''"; //IN value Null Empty List 
    	}
    //echo $sql1;
    $rows1 = $db->fetch_all_array($sql1);
    foreach($rows1 as $record)
    {
    
    $equipment_type	= $record['equipment_type'];
    $equipment_model	= $record['equipment_model'];
    $vehi_type=get_equipment_type($equipment_type);
    $vehi_model=get_equipment_model($equipment_model);
   

    ?>
      

                        <option value="<?php echo $equipment_type;?>" ><?php echo ($vehi_type);?></option>
                        <?php

                    }
                    ?>

                </select> 



<?php //}
$db->close(); ?>
 
 <script>

  //$.widget.bridge('uibutton', $.ui.button);

  $(function () {

    //Initialize Select2 Elements

    $(".select2").select2();

  });

</script>