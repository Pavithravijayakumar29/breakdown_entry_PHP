<?php 

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 



$site_name = $_POST['site_name'];

?>

<select name="plant_name" id="plant_name"  class="form-control all_plant_co select2" style="width:100%"  multiple>

                    <?php 

          if($sess_site_id=="All")

          {

                    $sql = "select * FROM plant_creation where  site_id IN ($site_name) order by id ASC";
                   
                     $sql_exe=mysql_query($sql);

          }

          else

          {

                    $sql = "select * FROM plant_creation where site_id IN ($site_name) order by id ASC";
                  
                   $sql_exe=mysql_query($sql);

          }

                     while($rsdata=mysql_fetch_object($sql_exe))

                       {

                      

                        $plant_id=$rsdata->id;

                        $plant=$rsdata->plant;

                       

                        ?>

                        <option value="<?php echo $plant_id;?>" ><?php echo $plant;?></option>

                        <?php

                    }?>

                </select>  


<?php $db->close(); ?>
 
 <script>

  //$.widget.bridge('uibutton', $.ui.button);

  $(function () {

    //Initialize Select2 Elements

    $(".select2").select2();

  });

</script>