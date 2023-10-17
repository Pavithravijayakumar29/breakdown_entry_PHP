<?php

require("../model/config.inc.php");

require("../model/Database.class.php");
require_once("../include/common_function.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

$db->connect();


$site_name = $_REQUEST['site_name'];
$plant_name = $_REQUEST['plant_name'];
$breakdown_type = $_REQUEST['breakdown_type'];
$machinery_type = $_REQUEST['machinery_type'];
// echo "SELECT group_concat(Distinct(mechinary_type)) as ids FROM plant_machinery_list WHERE list_id!='' and site_name='$site_name' and plant_id='$plant_name' and breakdown_type='$breakdown_type'";
//echo  "SELECT * FROM mechinary_creation WHERE (mac_id in ($mac_no) or mac_id ='59')   order by mechinary_name asc"
// echo $sql = "SELECT Distinct(mechinary_type)as mechinary_type FROM plant_machinery_list WHERE list_id!='' and site_name='$site_name' and plant_id='$plant_name' order by mechinary_type asc ";

?>
<!-- mechinery disabled -->
<select name="machinery_type" id="machinery_type" class="form-control " style="width:100%" onChange="get_equipment_type_1(this.value, <?php echo $breakdown_type; ?>);" <?php if ($breakdown_type != '9' && $breakdown_type != '7' && $breakdown_type != '8' && $breakdown_type != '13') {
                                                                                                                                                                          echo 'disabled';
                                                                                                                                                                        } ?>>
  <option value="">Select</option>
  <!-- 31 -->
  <?php

  $machinery_no = mysql_fetch_array(mysql_query("SELECT group_concat(Distinct(mechinary_type)) as ids FROM plant_machinery_list WHERE list_id!='' and site_name='$site_name' and plant_id='$plant_name'   "));
  if ($machinery_no['ids'] != '') {

    //$mac_no="mac_id in($machinery_no[ids])";
    $mac_no = $machinery_no['ids'];
  } else {

    $mac_no = "";
  }
  // displaying others option
  // $machinery=("SELECT * FROM mechinary_creation WHERE $mac_no    order by mechinary_name asc");
  $machinery = ("SELECT * FROM mechinary_creation WHERE (mac_id in ($mac_no) )   order by mechinary_name asc");

  $rows2 = $db->fetch_all_array($machinery);

  foreach ($rows2 as $record2) {
    $mac_id =  $record2['mac_id'];
    $mechinary_name = $record2['mechinary_name'];

  ?>

    <option value="<?php echo $mac_id; ?>"><?php echo ($mechinary_name); ?></option>
  <?php

  }
  ?>
  <option value="0">Others</option>
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