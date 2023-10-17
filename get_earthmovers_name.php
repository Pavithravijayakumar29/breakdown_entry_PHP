<?php 
ob_start();

require_once("../model/config.inc.php"); 

require_once("../model/Database.class.php"); 

require_once("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
$user_type_ses=$_SESSION['user_types'];
//echo $user_type_ses;
$site_name =$_POST['site_name'];
$plant_name = $_POST['plant_name'];
//  $sess_site_id=$_REQUEST['sess_site_id'];
$shift_name=$_POST['shift_name'];
$entry_date=date('Y-m-d',strtotime($_POST['entry_date']));

?>

<select name="machinery_type" id="machinery_type" class="form-control " style="width:100%" onChange="get_equipment_type_1(this.value);">
  <option value="">Select</option>

  <?php

// echo   "select v.id, (v.vehicle_no) as vehicle_no	from machinerie_entry m inner join vehicle_entry v ON m.vehicle_no= v.id where  m.entry_date LIKE  '%$entry_date%' and m.vehicle_no!='' group by m.vehicle_no 
// UNION ALL
// select v.id,(v.vehicle_no) as vehicle_no from  tipper_entry as t  inner join vehicle_entry v ON t.vehicle_no= v.id  where  t.entry_date LIKE '%$entry_date%'   and t.vehicle_no!='' group by m.vehicle_no ";
// select v.id, (v.vehicle_no) as vehicle_no ,(v.site_name) from machinerie_entry m inner join vehicle_entry v ON m.vehicle_no= v.id where m.entry_date LIKE  '%$entry_date%' and m.vehicle_no!='' group by vehicle_no

// earthmover (based on site,plant,shift)
// "select v.equipment_type as id, e.equipment_type from vehicle_entry v inner join equip_type e ON v.equipment_type=e.id where v.id ";

// for machinery 25-05-23

$sql11 = "SELECT v.equipment_type as id ,e.equipment_type
FROM machinerie_entry m
INNER JOIN vehicle_entry v ON m.vehicle_no = v.id
inner join equip_type e ON v.equipment_type=e.id
left join  machinerie_sub_entry p on m.mach_trip_no= p.mach_trip_no
WHERE m.entry_date LIKE '%$entry_date%' AND m.vehicle_no != '' AND m.site_name='$site_name' and p.remarks='$plant_name' and m.mech_shift_name='$shift_name' 
GROUP BY v.equipment_type
          UNION ALL
          SELECT  v.equipment_type as id ,e.equipment_type
          FROM tipper_entry AS t
          INNER JOIN vehicle_entry v ON t.vehicle_no = v.id
          inner join equip_type e ON v.equipment_type=e.id
          left join  tipper_sub_entry r on t.tipper_trip_no= r.tipper_trip_no
          WHERE t.entry_date LIKE '%$entry_date%' AND t.vehicle_no != '' AND t.site_name='$site_name'and r.remarks='$plant_name' and t.tipp_shift_name='$shift_name'
          GROUP BY v.equipment_type";

$rows11 = $db->fetch_all_array($sql11);

foreach ($rows11 as $record1) {
  $id = $record1['id'];
  $equipment_type = $record1['equipment_type'];
  $site_name = $record1['site_name'];
  ?>

  <option value="<?php echo $id; ?>"><?php echo $equipment_type; ?></option>
  
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

 