<?php

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
// ''
echo $val=$_REQUEST['timing'];
$sub_id=$_REQUEST['sub_id'];
?>
  
<?php

?>
