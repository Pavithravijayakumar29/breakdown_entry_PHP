<?php

require("../model/config.inc.php");

require("../model/Database.class.php");
require_once("../include/common_function.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

$db->connect();


$site_name = $_POST['site_name'];
$plant_name = $_POST['plant_name'];
$machinery_type = $_POST['machinery_type'];
$entry_date=date('Y-m-d',strtotime($_POST['entry_date']));
$breakdown_type = $_POST['breakdown_type'];
$shift_name=$_POST['shift_name'];
$machinery_type=$_POST['machinery_type'];
// $date_value = $_REQUEST['date'];
//echo $sql = "SELECT Distinct(mechinary_type)as mechinary_type FROM plant_machinery_list WHERE list_id!='' and site_name='$site_name' and plant_id='$plant_name' order by mechinary_type asc ";
//  if($breakdown_type=='8' || $breakdown_type='13' || $breakdown_type='7')        {            echo "//"; 
//echo "select (vehicle_no) as vehicle_no  from   machinerie_entry  where  (entry_date)='$date_value' and vehicle_no!=''  group by vehicle_no     	 UNION ALL    	 select (vehicle_no) as vehicle_no from  tipper_entry  where  (entry_date)='$date_value'   and vehicle_no!='' group by vehicle_no ";
// echo "select v.equipment_type, e.equipment_type from vehicle_entry v inner join equip_type e ON v.equipment_type=e.id where v.id = $_POST[machinery_type] order by id";

?>


<select name="equipment_type" id="equipment_type" class="form-control " <?php if (($breakdown_type != '9' && $breakdown_type != '7' || $breakdown_type != '8' || $breakdown_type != '13') && empty($machinery_type)) {
                                                                                        echo 'disabled';
                                                                                    } ?>>

  <option value="">Select</option>
  <!-- <option value="0">Others</option> -->
  <?php
 
  
//  $sql11 = "select v.id,v.equipment_type, e.equipment_type from vehicle_entry v inner join equip_type e ON v.equipment_type=e.id where v.id!='' order by id";

// $equipment_type_qry= "select v.equipment_type as id, e.equipment_type from vehicle_entry v inner join equip_type e ON v.equipment_type=e.id where v.id = $_POST[machinery_type] order by id";

// for equipment 25-5-23

$equipment_type_qry="SELECT v.id, v.vehicle_no
 FROM machinerie_entry m
 INNER JOIN vehicle_entry v ON m.vehicle_no = v.id
 inner join equip_type e ON v.equipment_type=e.id
 left join  machinerie_sub_entry p on m.mach_trip_no= p.mach_trip_no
 WHERE m.entry_date LIKE '%$entry_date%' AND m.vehicle_no != '$_POST[machinery_type]' AND m.site_name='$site_name' and p.remarks='$plant_name' and m.mech_shift_name='$shift_name' and v.equipment_type='$machinery_type'GROUP BY v.id
          UNION ALL
          SELECT v.id, v.vehicle_no
          FROM tipper_entry AS t
          INNER JOIN vehicle_entry v ON t.vehicle_no = v.id
          left join  tipper_sub_entry r on t.tipper_trip_no= r.tipper_trip_no
          WHERE t.entry_date LIKE '%$entry_date%' AND t.vehicle_no !='$_POST[machinery_type]' AND t.site_name='$site_name'and r.remarks='$plant_name' and t.tipp_shift_name='$shift_name' and v.equipment_type='$machinery_type'
          GROUP BY v.id";
 
 $rows11 = $db->fetch_all_array($equipment_type_qry);
    foreach($rows11 as $record1)
    {
      $id=$record1['id'];
      $vehicle_no=$record1['vehicle_no'];
  ?>

    <option value="<?php echo $id; ?>"><?php echo $vehicle_no ; ?></option>
  <?php
  }
  ?>
</select>


<?php //}
$db->close(); ?>

<script>
  //$.widget.bridge('uibutton', $.ui.button);

  $(function() {

    //Initialize Select2 Elements

    $(".select2").select2();

  });
</script>