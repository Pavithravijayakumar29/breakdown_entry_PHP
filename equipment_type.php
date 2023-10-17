<?php

require("../model/config.inc.php");

require("../model/Database.class.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

$db->connect();


// $mechinary_type=isset($_POST['$mechinary_type']);
$machinery_type = $_GET['machinery_type'];
$site_name = $_GET['site_name'];
$plant_name = $_GET['plant_name'];
$breakdown_type = $_GET['breakdown_type'];
// $breakdown_type = $_POST['breakdown_type'];
// $breakdown_type= isset($_POST['breakdown_type']);


// echo $sql = "select * FROM plant_machinery_list where breakdown_type = '$breakdown_type' and mechinary_type='$machinery_type' and site_name = '$site_name' and plant_id='$plant_name' order by list_id ASC";

// echo "  --Empty" . empty($machinery_type) ? "empty " : "Not empty";
// echo "$machinery_type"
?>
<!-- equipment disabled and machinery others enabled 31-->
<select name="equipment_type" id="equipment_type" class="form-control" <?php if ($machinery_type == "0") {
                                                                            echo 'others';
                                                                        } ?><?php if (($breakdown_type != '9' || $breakdown_type != '7' || $breakdown_type != '8' || $breakdown_type != '13') && empty($machinery_type)) {
                                                                                                                                echo 'disabled';
                                                                                                                            } ?>>

    <option value="">Select</option>

    <?php



    $sql = "select * FROM plant_machinery_list where mechinary_type='$machinery_type' and site_name = '$site_name' and plant_id='$plant_name' order by list_id ASC";

    $sql_exe = mysql_query($sql);

    while ($rsdata = mysql_fetch_object($sql_exe)) {

        $equipment_name = $rsdata->equipment_name;

        $id = $rsdata->list_id;

    ?>

        <option value="<?php echo $id; ?>"><?php echo $equipment_name; ?></option>

    <?php

    } ?>
    <!-- other option displaying -->
    <option value="0">Others</option>
</select>


<?php $db->close(); ?>

<script>
    //$.widget.bridge('uibutton', $.ui.button);

    $(function() {

        //Initialize Select2 Elements

        $(".select2").select2();

    });
</script>