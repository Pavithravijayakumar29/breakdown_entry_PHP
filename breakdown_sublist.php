<?php
error_reporting(0);
/*require_once("../model/config.inc.php"); 
require_once("../model/Database.class.php"); 
//include("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

*/

if ($_GET['id'] != '') {
  include_once("../model/config.inc.php");
  include_once("../model/Database.class.php");

  $db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  $db->connect();
}

include_once("../include/common_function.php");

function total_bd_time($times)
{

  // loop throught all the times
  foreach ($times as $time) {

    list($hour, $minute) = explode(':', $time);
    $minutes += $hour * 60;
    $minutes += $minute;
  }

  $hours = floor($minutes / 60);
  $minutes -= $hours * 60;

  // returns the time already formatted
  return sprintf('%02d:%02d', $hours, $minutes);
}



?>

<div id="">
  <input type="hidden" name="sub_id_val" id="sub_id_val" value="<?php echo $_GET['id']; ?>" />
  <?php

  $query2 = mysql_query("select * from  breakdown_entry_sub where  id='$_GET[id]' and (breakdown_no='$_POST[breakdown_no]' or breakdown_no='$_GET[breakdown_no]') and (random_no='$_POST[random_no]' or random_no='$_GET[random_no]') and (random_sc='$_POST[random_sc]' or random_sc='$_GET[random_sc]')");
  while ($fetch_list21 = mysql_fetch_array($query2, $sql11)) {
    $i = $i + 1;
    $breakdown_no_edit = $fetch_list21['breakdown_no'];
    $date_edit = $fetch_list21['entry_date'];
    // for earthmover date
    $entry_date = date('Y-m-d', strtotime($fetch_list21['entry_date']));
    $from_time_edit = explode(' ', $fetch_list21['from_time']);
    $to_time_edit = explode(' ', $fetch_list21['to_time']);
    $remarks_edit = $fetch_list21['remarks'];
    $total_time_edit = $fetch_list21['total_time'];
    //$$$$ Edited 11.03.2023
    $breakdown_type_edit = $fetch_list21['breakdown_type'];
    //$$$$ Edited 11.03.2023
    $br_id = $fetch_list21['id'];
    $machinery_type = $fetch_list21['machinery_type'];
    $equipment_type1 = $fetch_list21['equipment_type'];
    $site = $fetch_list21['site_name'];
    $plant_name = $fetch_list21['plant_name'];
    $shift_name = $fetch_list21['shift_name'];
  }



  ?>
  <!-- form start -->
  <div id="get_frm_to_time_div">

    <input type="hidden" name="sft_start_time" id="sft_start_time" />
    <input type="hidden" name="sft_end_time" id="sft_end_time" />
  </div>
  <table width="90%" class="table table-bordered">
    <thead>
      <tr>
        <th width="4%" class="font_label" height="27" align="left">S.no</th>

        <th width="15%" class="font_label" style="text-align:left"><strong>Breakdown Type</strong><span style="color:#F00">*</span></th>
        <th width="9%" class="font_label" style="text-align:left" align="left"><strong>From Time</strong><span style="color:#F00">*</span></th>
        <th width="9%" class="font_label" style="text-align:"><strong>To Time</strong><span style="color:#F00">*</span></th>

        <th width="9%" align="left" class="font_label" style="text-align:"><strong>Total Time</strong><span style="color:#F00">*</span></th>
        <th width="12%" align="left" class="font_label" style="text-align:"><strong>Remarks</strong><span style="color:#F00">*</span></th>
        <th width="12%" align="left" class="font_label" style="text-align:"><strong>Machinery Type</strong><span style="color:#F00">*</span></th>
        <th width="12%" align="left" class="font_label" style="text-align:"><strong>Equipment Type</strong><span style="color:#F00">*</span></th>
        <th width="12%" class="center font_label" style="text-align:center">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td align="left"><label for="form-field-1" class="no-padding-right control-label col-sm-20">#</label></td>


        <!----------------------------------------------------------------------------->
        <?php

        ?>


        <td align="left">
          <select name="breakdown_type" id="breakdown_type" class="form-control" onclick="get_frm_to_time(shift_name.value,date.value),get_shift_breakdown(shift_name.value,date.value),get_total_time_mach_only_break_down(from.value,to.value)" onChange="get_machinery_value_list(breakdown_type.value,site_name.value,plant_name.value),get_equipment_type_1(this.value);">
            <option value="">Select</option>

            <?php

            $sql = mysql_query("select * from  breakdown_type_creation where  breakdown_id!='' order by breakdown_type asc");
            while ($fetch_detail = mysql_fetch_array($sql)) { ?>
              <option value="<?php echo  $fetch_detail['breakdown_id']; ?>" <?php if ($breakdown_type_edit == $fetch_detail['breakdown_id']) {
                                                                              echo "selected";
                                                                            } ?>><?php echo  $fetch_detail['breakdown_type']; ?></option>
            <?php } ?>
          </select>

        </td>
        <td align="left">
          <!-- <input type="time" id="from" name="from" class="form-control numeric" value="<?php echo $from_time_edit; ?>" onClick="get_breakdown_total(from.value,to.value);" >
    </td>
    
      <td align="left">
    <input type="time" id="to" name="to" class="form-control numeric" value="<?php echo $to_time_edit; ?>" onClick="get_breakdown_total(from.value,to.value);" >-->
          <div id="get_start_break_shift_div">

            <input type="datetime-local" class="form-control numeric" name="from" id="from" onChange="get_total_time_mach_only_break_down(from.value,to.value)" value="<?php if ($_GET['id'] != '') {
                                                                                                                                                                          echo $from_time_edit[0] . 'T' . $from_time_edit[1];
                                                                                                                                                                        } else {
                                                                                                                                                                          echo date('Y-m-d') . 'T' . date('h:i');
                                                                                                                                                                        } ?>">
          </div>
        </td>

        <td>
          <div id="get_end_break_shift_div">
            <input type="datetime-local" class="form-control numeric" name="to" id="to" onChange="get_total_time_mach_only_break_down(from.value,to.value)" value="<?php if ($_GET['id'] != '') {
                                                                                                                                                                      echo $to_time_edit[0] . 'T' . $to_time_edit[1];
                                                                                                                                                                    } else {
                                                                                                                                                                      echo date('Y-m-d') . 'T' . date('h:i');
                                                                                                                                                                    } ?>">
          </div>
        </td>



        <td align="left">

          <div id="get_total_time_div">
            <input type="text" class="form-control numeric" style="text-align:right;" name="total" id="total" value="<?php if ($_GET['id'] != '') {
                                                                                                                        echo $total_time_edit;
                                                                                                                      } else {
                                                                                                                        echo "0:00";
                                                                                                                      } ?>" readonly>
          </div>
        </td>
        <!-- Machinery Type and Equipment Type field have others option. so, we need to entry what was the problem .so, Remarks field should mandatory - date:10\03\23 -->
        <td align="left">
          <textarea name="remarks" id="remarks" class="form-control numeric" onkeyup=""><?php echo $remarks_edit; ?></textarea>
        </td>
        <td>



          <!--mechinery type edit 14-03-23 & while edit disabled the except(7,8,9,13 breakdown type) in machinery -->
          <div id="machinery_val_div123">

            <!-- <?php echo "breakdown type   -- $breakdown_type   ----"; ?> -->


            <select name="machinery_type" id="machinery_type" class="form-control " style="width:100%" onChange="get_equipment_type_1(this.value, <?php echo $breakdown_type; ?>);" <?php if ($breakdown_type != '9' && $breakdown_type != '7' && $breakdown_type != '8' && $breakdown_type != '13' && empty($machinery_type)) {

                                                                                                                                                                                      if ($machinery_type == "0") {
                                                                                                                                                                                        echo 'others';
                                                                                                                                                                                      } else {
                                                                                                                                                                                        echo 'disabled';
                                                                                                                                                                                      }
                                                                                                                                                                                    } ?>>
              <!-- <select name="machinery_type" id="machinery_type" class="form-control " style="width:100%" onChange="get_equipment_type_1(this.value);"> -->
              <option value="">Select</option>


              <?php
              if ($breakdown_type_edit == '8' || $breakdown_type_edit == '13' || $breakdown_type_edit == '7') {


                $machinery_no = mysql_fetch_array(mysql_query("SELECT group_concat(Distinct(mechinary_type)) as ids FROM plant_machinery_list WHERE list_id!='' and site_name='$site' and plant_id='$plant_name'   "));
                if ($machinery_no['ids'] != '') {

                  // $mac_no="mac_id in($machinery_no[ids])";
                  $mac_no = $machinery_no['ids'];
                } else {

                  $mac_no = "mac_id=''";
                }
                // displaying others option
                // $machinery=("SELECT * FROM mechinary_creation WHERE $mac_no    order by mechinary_name asc");
                $machinery = ("SELECT * FROM mechinary_creation WHERE (mac_id in ($mac_no))   order by mechinary_name asc");

                $rows2 = $db->fetch_all_array($machinery);

                foreach ($rows2 as $record2) {
                  $mac_id =  $record2['mac_id'];
                  $mechinary_name = $record2['mechinary_name'];

              ?>
                  <!-- selecting option display-->
                  <option value="<?php echo $mac_id; ?>" <?php if ($machinery_type == $mac_id) { ?> selected <?php } ?>><?php echo $mechinary_name; ?></option>
                  <!-- <option value="<?php echo $mac_id; ?>"><?php echo ($mechinary_name); ?></option> -->

                <?php

                }
                ?>
                <option value="0" <?php if ($machinery_type['mac_id'] == '0') {
                                    echo 'selected';
                                  } ?>>Others</option>

                <?php
                // earthmover edit   (machinery to equip 25-05-2023)
              } elseif ($breakdown_type_edit == '9') {
                // update earthmover (based on site,plant,shift)
                $sql11 =  "SELECT v.equipment_type as id ,e.equipment_type
                FROM machinerie_entry m
                INNER JOIN vehicle_entry v ON m.vehicle_no = v.id
                inner join equip_type e ON v.equipment_type=e.id
                left join  machinerie_sub_entry p on m.mach_trip_no= p.mach_trip_no
                WHERE m.entry_date LIKE '%$entry_date%' AND m.vehicle_no != '' AND m.site_name='$site' and p.remarks='$plant_name' and m.mech_shift_name='$shift_name' 
                GROUP BY v.id
                          UNION ALL
                          SELECT  v.equipment_type as id ,e.equipment_type
                          FROM tipper_entry AS t
                          INNER JOIN vehicle_entry v ON t.vehicle_no = v.id
                          inner join equip_type e ON v.equipment_type=e.id
                          left join  tipper_sub_entry r on t.tipper_trip_no= r.tipper_trip_no
                          WHERE t.entry_date LIKE '%$entry_date%' AND t.vehicle_no != '' AND t.site_name='$site'and r.remarks='$plant_name' and t.tipp_shift_name='$shift_name'
                          GROUP BY v.id";


                $rows11 = $db->fetch_all_array($sql11);
                foreach ($rows11 as $record1) {
                  $id = $record1['id'];

                  $equipment_type = $record1['equipment_type'];




                ?>

                  <option value="<?php echo $id; ?>" <?php if ($machinery_type == $id) { ?> selected <?php } ?>><?php echo ($equipment_type); ?></option>
                <?php
                }
              } else {

                $sql = "select * from vehicle_entry where site_name='$site' and equip_field!='Genset' and equipment_type='$machinery_type' group by equipment_type";

                $sql_exe = mysql_query($sql);

                while ($rsdata = mysql_fetch_array($sql_exe)) {

                  $equipment_type  = $rsdata['equipment_type'];
                  $equipment_model  = $rsdata['equipment_model'];
                  $vehi_type = get_equipment_type($equipment_type);
                  $vehi_model = get_equipment_model($equipment_model);



                ?>

                  <option value="<?php echo $equipment_type; ?>"><?php echo $vehi_type; ?></option>
              <?php }
              } ?>

            </select>
          </div>
        </td>

        <td>
          <!-- equipment type edit 14-03-2023  equip to machinery 25-05-23-->
          <div id="equipment_type_div">

            <select name="equipment_type" id="equipment_type" class="form-control" <?php if ($machinery_type == "0") {
                                                                                      echo 'others';
                                                                                    } ?> <?php if (($breakdown_type != '9' || $breakdown_type != '7' || $breakdown_type != '8' || $breakdown_type != '13') && empty($machinery_type)) {
                                                                                            if ($machinery_type == "0") {
                                                                                              echo 'others';
                                                                                            } else {
                                                                                              echo 'disabled';
                                                                                            }
                                                                                          } ?>>

              <option value="">Select</option>
              <!-- instering others option -->
              <!-- <option value="0" <?php if ($equipment_type1['list_id'] == '0') {
                                        echo 'selected';
                                      } ?>>Others</option> -->
              <?php
              // select * FROM plant_machinery_list where list_id!='' order by list_id ASC

              if ($breakdown_type_edit == '8' || $breakdown_type_edit == '13' || $breakdown_type_edit == '7') {

                $sql = "select * FROM plant_machinery_list where mechinary_type='$machinery_type' and site_name = '$site' and plant_id='$plant_name' order by list_id ASC";

                $sql_exe = mysql_query($sql);

                while ($rsdata = mysql_fetch_object($sql_exe)) {

                  $equipment_name = $rsdata->equipment_name;

                  $id = $rsdata->list_id;

              ?>
                  <!-- <option value="<?php echo $id; ?>"><?php echo $equipment_name; ?></option> -->
                  <!-- selected option display -->
                  <option value="<?php echo $id; ?>" <?php if (($equipment_type1 == $id)) { ?> selected <?php } ?>><?php echo $equipment_name; ?></option>
                <?php
                }
                // inserting others option only for electrical,mechinery,Jamming .
                ?>
                <option value="0" <?php if ($equipment_type1['list_id'] == '0') {
                                    echo 'selected';
                                  } ?>>Others</option>
                <?php



                // earthmover edit
              } elseif ($breakdown_type_edit == '9') {
                $equipment_type_qry = "SELECT v.id, v.vehicle_no
                FROM machinerie_entry m
                INNER JOIN vehicle_entry v ON m.vehicle_no = v.id
                left join  machinerie_sub_entry p on m.mach_trip_no= p.mach_trip_no
                WHERE m.entry_date LIKE '%$entry_date%' AND m.vehicle_no != '$_POST[machinery_type]' AND m.site_name='$site' and p.remarks='$plant_name' and m.mech_shift_name='$shift_name' and  v.equipment_type='$machinery_type'
                GROUP BY v.id
                         UNION ALL
                         SELECT v.id, v.vehicle_no
                         FROM tipper_entry AS t
                         INNER JOIN vehicle_entry v ON t.vehicle_no = v.id
                         left join  tipper_sub_entry r on t.tipper_trip_no= r.tipper_trip_no
                         WHERE t.entry_date LIKE '%$entry_date%' AND t.vehicle_no !='$_POST[machinery_type]' AND t.site_name='$site'and r.remarks='$plant_name' and t.tipp_shift_name='$shift_name' and v.equipment_type='$machinery_type'
                         GROUP BY v.id";


                $rows11 = $db->fetch_all_array($equipment_type_qry);
                foreach ($rows11 as $record1) {
                ?>

                  <option value="<?php echo $record1['id'] ?>" <?php if (($equipment_type1 == $record1['id'])) { ?> selected <?php } ?>><?php echo $record1['vehicle_no']; ?></option>
                <?php
                }
              } else {

                $sql = "select * from vehicle_entry where site_name='$site' and equip_field!='Genset' and equipment_model='$equipment_type1' group by equipment_model  ";

                $sql_exe = mysql_query($sql);

                while ($rsdata = mysql_fetch_array($sql_exe)) {

                  $equipment_type  = $rsdata['equipment_type'];
                  $equipment_model  = $rsdata['equipment_model'];
                  $vehi_type = get_equipment_type($equipment_type);
                  $vehi_model = get_equipment_model($equipment_model);



                ?>

                  <option value="<?php echo $equipment_model; ?>"><?php echo $vehi_model; ?></option>
              <?php }
              } ?>


            </select>
          </div>
        </td>

        <td align="center"><?php if ($_GET['id'] == '') { ?>
            <input type="button" class="btn btn-info" id="add" value="ADD" onClick="breakdown_sub_add(random_no.value,random_sc.value,breakdown_no.value,site_name.value,shift_name.value,date.value,from.value,to.value,total.value,remarks.value,breakdown_type.value,user_name.value,overall_tot.value,machinery_type.value,equipment_type.value)">
          <?php } ?>
          <?php if ($_GET['id'] != '') {  ?>
            <input type="button" class="btn btn-info" id="edit" value="EDIT" onClick="breakdown_sub_edit(random_no.value,random_sc.value,breakdown_no.value,site_name.value,shift_name.value,date.value,from.value,to.value,total.value,remarks.value,breakdown_type.value,'<?php echo $_GET['id']; ?>')" />
          <?php }; ?>
        </td>
      </tr>

      <!-- /.box-body -->
      <div id="curd_message" align="center" style="font-weight:bold; padding:5px;"></div>
      <!-- /.box-footer -->
      <?php


      $i = 0;

      $get_query_sub = mysql_query("select * from  breakdown_entry_sub where (breakdown_no='$_POST[breakdown_no]' or breakdown_no='$_GET[breakdown_no]') and (random_no='$_POST[random_no]' or random_no='$_GET[random_no]') and (random_sc='$_POST[random_sc]' or random_sc='$_GET[random_sc]') order by id asc");
      while ($fetch_list2 = mysql_fetch_array($get_query_sub, $sql11_sub)) {
        $i = $i + 1;
        $sub_id = $fetch_list2['id'];
        $entry_date = $fetch_list2['entry_date'];
        $from_time = $fetch_list2['from_time'];
        $to_time = $fetch_list2['to_time'];
        $remarks = $fetch_list2['remarks'];
        $breakdown_no = $fetch_list2['breakdown_no'];
        $total_time = $fetch_list2['total_time'];
        $breakdown_type = $fetch_list2['breakdown_type'];
        $random_no = $fetch_list2['random_no'];
        $random_sc = $fetch_list2['random_sc'];
        $sql5 = mysql_fetch_array(mysql_query("select * from  breakdown_entry_sub where breakdown_no='$breakdown_no' and random_no='$random_no' and random_sc='$random_sc'  order by id desc limit 1"));


        $machinery_type = $fetch_list2['machinery_type'];
        // machinery others 31
        if ($machinery_type == '0') {
          $machinery = 'Others';
        } else {
          $machinery =  get_mechinary_name($machinery_type);
        }
        // earthmover 
        if ($breakdown_type == '9') {
          // machinery (25-05-23)
          $machinery_name = mysql_fetch_array(mysql_query("select id, equipment_type from equip_type  where id = '$fetch_list2[machinery_type]'"));

          $equipment_type = $fetch_list2['equipment_type'];
          // echo "equipment_type  -- $equipment_type   ----";
          if ($equipment_type != '0' && $equipment_type > 0) {
            // equip (25-05-23)
            $equipement_name = mysql_fetch_array(mysql_query("select id, vehicle_no from vehicle_entry  where id = '$fetch_list2[equipment_type]'"));
            // echo "equipement_ name -- $equipement_name";
          }
        }
        // equip others
        $equipment_type = $fetch_list2['equipment_type'];
        //  echo "equipment_type  -- $equipment   ----";
        if ($equipment_type == '0') {
          $equipment = 'Others';
        } else {
          $equipment = get_plant_equipment_name($equipment_type);
        }


      ?>

        <tr>
          <td align="left"><?php echo $i; ?></td>
          <td align="left"><?php echo get_breakdown_type($breakdown_type); ?></td>
          <td align="right" style="text-align: left"><?php echo date('d-m-Y h:i A', strtotime($from_time)); ?></td>
          <td align="right" style="text-align: left"><?php echo date('d-m-Y h:i A', strtotime($to_time)); ?></td>

          <td align="right"><?php echo $total_time; ?></td>
          <td align="right">&nbsp;<?php echo $remarks; ?></td>
          <!-- others option display in this breakdown type -->
          <?php if ($breakdown_type != '9' && $breakdown_type != '7' && $breakdown_type != '8' && $breakdown_type != '13') { ?>
            <td align="right">&nbsp; <?php if ($machinery_type != '') {
                                        echo get_mechinary_name($machinery_type);
                                      } else {
                                        echo $machinery_type = '--';
                                      } ?></td>
            <td align="right">&nbsp;<?php if ($equipment_type != '') {
                                      echo get_plant_equipment_name($equipment);
                                    } else {
                                      echo $equipment = '--';
                                    } ?></td>
          <?php } else if ($breakdown_type == '9') { ?>
            <!-- earthmover  25-05-23 -->
            <td align="right">&nbsp; <?php echo $machinery_name['equipment_type']; ?></td>
            <td align="right">&nbsp; <?php echo $equipement_name['vehicle_no']; ?></td>
          <?php } else {
            //                      $vehi_type=get_equipment_type($equipment_type);
            // $vehi_model=get_equipment_model($equipment_model);
          ?>
            <!-- <?php echo "machinery_type  -- $machinery_type   ----"; ?> -->
            <!-- othrs 31 -->
            <td align="right">&nbsp; <?php echo $machinery;
                                      ?></td>
            <!-- <?php echo "equipment_type  -- $equipment   ----"; ?> -->
            <td align="right">&nbsp; <?php echo ($equipment);
                                      ?></td>
          <?php } ?>
          <td colspan="6" align="center" class="center">
            <div class="hidden-sm hidden-xs action-buttons">
              <?php if ($sub_id == $sql5['id']) { ?>
                <a href="#" onClick="edit_breakdown_sublist('<?php echo $sub_id; ?>','<?php echo $breakdown_no; ?>','<?php echo $fetch_list2['random_no']; ?>','<?php echo $fetch_list2['random_sc']; ?>'),get_frm_to_time(shift_name.value,date.value)" title="Update Breakdown" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>

                <a class="btn btn-default" href="#" onclick="delete_breakdown_sublist('<?php echo $sub_id; ?>','<?php echo $breakdown_no; ?>','<?php echo $fetch_list2['random_no']; ?>','<?php echo $fetch_list2['random_sc']; ?>')"><span class="glyphicon glyphicon-trash"></span></a>

              <?php

              } ?>
            </div>
          </td>

        <?php
        $tot[] = $total_time;
        $t_time_tot = total_bd_time($tot);
      } ?>
        </tr>

    </tbody>
    <tr>
      <td colspan="4" align="right"><strong>Total</strong></td>
      <td align="right"><strong>
          <input type="text" name="overall_tot" id="overall_tot" style="text-align:right;border: none;" value="<?php if ($t_time_tot != '') {
                                                                                                                  echo $t_time_tot;
                                                                                                                } else {
                                                                                                                  echo "0:00";
                                                                                                                } ?>" /></strong>
      </td>

      <td></td>
      <td></td>
    </tr>
  </table>
</div>