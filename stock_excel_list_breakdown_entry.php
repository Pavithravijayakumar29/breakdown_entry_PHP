<?php 

// Excel Download - Filter Not Working - old file saved in same folder (stock_excel_list_breakdown_entry_12.01.2023.php) - completed by Sangeetha - 13.01.2023 

error_reporting(0);

ob_start();

session_start();  

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

include_once("../include/common_function.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 

$company=get_company_name();

$sess_site_id=$_SESSION['sess_site_id'];

$site_name_head=get_site_name($_GET[site_name]);

$breakdown_type=$_GET[breakdown_type];

$site=$_REQUEST[site];

$site_name_head=get_site_name($_GET[site_name]);

$plant_name_head=get_plant_name($_GET[plant_name]);

$blog=array('','','',"","",' Breakdown Entry List ','','','');

foreach($blog as $icon)
{
$output     .= '"'.$icon.'",';
}

$output .="\n";

$output .="\n";

$output .= '"SNO","DATE","SITE NAME","PLANT NAME","SHIFT NAME","BREAKDOWN NO","BREAKDOWN ENTRY","MACHINERY TYPE","EQUIPMENT TYPE","FROM TIME","TO TIME","TOTAL TIME","REMARKS" '."\n";

$table_values=array(s1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12,s13);

$from_date=$_GET['from_date'];

$to_date=$_GET['to_date'];

$site_name=$_GET['site_name'];

$plant_name=$_GET['plant_name'];

$status=$_GET['status'];

$breakdown_type=$_GET['breakdown_type'];

$current_date=date('Y-m-d');


if($_REQUEST[site]=='site')
{
    if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

    if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

    if($sess_site_id=="All"){
        if($site_name!="" and $site_name!="null" ){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}
    }else{
        if($site_name!="" and $site_name!="null"){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1="a.site_name IN ($sess_site_id) ";}
    }

    if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}

    if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

    if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}

else
{
    if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

    if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

    if($sess_site_id=="All"){
        if($site_name!="" and $site_name!="null"){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}
    }else{
        if($site_name!="" and $site_name!="null"){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1="a.site_name IN ($sess_site_id) ";}
    }

    if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}

    if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

}

$all_value10 = $from_date1."@".$to_date1."@".$site_name1."@".$breakdown_type1."@".$status1."@".$plant_name1;;

$all_array10 = explode('@',$all_value10);

foreach($all_array10 as $value10)

{ 
    if($value10!=''){$get_query131 .= $value10." AND ";}
}


    $sql1="select *,a.id as main_id from  breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where $get_query131 a.id!='' group by a.breakdown_no order by a.id asc";


$rows1 = $db->fetch_all_array($sql1);

$sno = 0;

foreach($rows1 as $record)
{

    $id = $record['main_id'];
    
    $site_id=$record['site_name']; 

    $site_name=get_site_name($site_id);

    $random_no=$record['random_no']; 

    $random_sc=$record['random_sc'];

    $breakdown_no = $record['breakdown_no'];

    $breakdown_type=get_breakdown_type($record['breakdown_type']);
    
    $shift_name=get_shift_name($record['shift_name']);

    $overall_time=$record['overall_time'];

    $plant_name1=$record['plant_name'];

    $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$plant_name1'"));

    $plant_id11= $party_names['plant'];

    $date1 = date("d-m-Y",strtotime($record['entry_date']));


$sql10 = "select * from breakdown_entry_sub where random_no='$random_no' and random_sc='$random_sc' ";

$rows10 = $db->fetch_all_array($sql10);

foreach($rows10 as $record10)

{
    $sno=$sno+1;

    $from_time=date('h:i A',strtotime($record10['from_time']));

    $to_time=date('h:i A',strtotime($record10['to_time']));

    $remarks=$record10['remarks'];
    // getting breakdowntype 
    $breakdown_type=get_breakdown_type($record10['breakdown_type']);
//     $machinery_type_id=($record10['machinery_type']);
//         if($breakdown_type == '9')
//         {
            
//          $machinery_type_id = mysql_fetch_array(mysql_query("select id, vehicle_no from vehicle_entry  where id = '$record10[machinery_type]'"));

//           $equipment_type_id = ($record10['equipment_type']);
//           //displaying others option 
//           if ($equipment_type == '0') {
//             $equipment = 'Others';
//           } else {
//             $equipment_type_id = mysql_fetch_array(mysql_query("select id, equipment_type from equip_type  where id = '$record10[equipment_type]'"));
            
//           }
          
//         }
    

//     if($machinery_type_id!=''){
//         $machinery_type = ($machinery_type_id) or $machinery_type_id['vehicle_no'] ;
//     }
//         else{$machinery_type="--";}

//     $equipment_type_id=$record10['equipment_type'];
// if($equipment_type_id =='0'){$equipment_type = 'Others';}else{$equipment_type =($equipment_type_id) or $equipment_type=$equipment_type_id['equipment_type'] or $equipment_type="--";}
 

//earthmover mech
// $machinery_type_id = get_mechinary_name($record10['machinery_type']);
// if ($breakdown_type == '9') {
//     $result = mysql_query("SELECT id, vehicle_no FROM vehicle_entry WHERE id = '$record10[machinery_type]'");
//     $row = mysql_fetch_array($result);
//     $machinery_type_id = $row['vehicle_no'];
//  $equipment_type_id = $record10['equipment_type'];
//     // displaying others option
//     if ($equipment_type_id == '0') {
//         $equipment_type = 'Others';
//     } else {
       
//         $result = mysql_query("SELECT id, equipment_type FROM equip_type WHERE id = '$equipment_type_id'");
//         $row = mysql_fetch_array($result);
//         $equipment_type = $row['equipment_type'];
//     }
// }
// $machinery_type_id = ($record10['machinery_type']);
// echo " machinery_type_id -  $machinery_type_id";
// if ($machinery_type_id != '') {
//     $machinery_type = ($machinery_type_id);
// } else {
//     $result = mysql_query("SELECT id, vehicle_no FROM vehicle_entry WHERE id = '$record10[machinery_type]'");
//     $row1 = mysql_fetch_array($result);
//     if($row){
//         $machinery_type= $row['vehicle_no'];
//     }else{
//         $machinery_type = "--";
//     }
// }  

// machinery earthmover
$machinery_type_id = $record10['machinery_type'];
// othrers 31
if ($machinery_type_id == '0') {
    $machinery_type ='Others';
}
else{
    // machinery 25-05-23
$result = mysql_query("select id, equipment_type from equip_type  where  id = '$record10[machinery_type]'");
    $row = mysql_fetch_array($result);
    if ($row){
        $machinery_type = $row['equipment_type'];  
    }else{
        $machinery_type = get_mechinary_name($machinery_type_id) or $machinery_type ='--';
    }
   
}



//equip earthmover
$equipment_type_id = $record10['equipment_type'];
if ($equipment_type_id == '0') {
    $equipment_type = 'Others';
} else {
    // equip 25-05-23
    $result = mysql_query("select id, vehicle_no from vehicle_entry  where id = '$equipment_type_id'");
    $row = mysql_fetch_array($result);
    if ($row) {
        $equipment_type = $row['vehicle_no'];
    } else {
        $equipment_type =get_plant_equipment_name($equipment_type_id) or $equipment_type = "--"; 
    }
}



$total_time_sublist=$record10['total_time'];
    
    // if($equipment_type_id!=''){$equipment_type = get_plant_equipment_name($equipment_type_id);}else{$equipment_type="--";}
// displaying others option in excel 
    // if($equipment_type_id =='0'){$equipment_type = 'Others';}else{$equipment_type =($equipment_type_id) or $equipment_type=$equipment_type_id['equipment_type'] or $equipment_type="--";}
//$output = ' "SNO", "DATE", "SITE NAME", "PLANT NAME", "SHIFT NAME","BREAKDOWN NO","BREAKDOWN ENTRY","FROM TIME","TO TIME","TOTAL TIME","REMARKS" '."\n";

    foreach ($table_values as $val) 
    {
        if($val=='s1'){$output.='"'.$sno.'",';}
        if($val=='s2'){$output.='"'.$date1.'",';}
        if($val=='s3'){$output.='"'.$site_name.'",';}
        if($val=='s4'){$output.='"'.$plant_id11.'",';}
        if($val=='s5'){$output.='"'.$shift_name.'",';}
        if($val=='s6'){$output.='"'.$breakdown_no.'",';}
        if($val=='s7'){$output.='"'.$breakdown_type.'",';}
        if($val=='s8'){$output.='"'.$machinery_type.'",';}
        if($val=='s9'){$output.='"'.$equipment_type.'",';}
        if($val=='s10'){$output.='"'.$from_time.'",';}
        if($val=='s11'){$output.='"'.$to_time.'",';}
        if($val=='s12'){$output.='"'.$total_time_sublist.'",';}
        if($val=='s13'){$output.='"'.$remarks.'",';}

        if( ($val!='s1')&&($val!='s2')&&($val!='s3')&&($val!='s4')&&($val!='s5')&&($val!='s6')&&($val!='s7')&&($val!='s8')&&($val!='s9')&&($val!='s10')&&($val!='s11')&&($val!='s12')&&($val!='s13') )
        {$output .='"'.$val.'",';}
    }

    $output .="\n";

    } 

}

$output .="\n";

$output .= '"","","","","","","","","","","",Printed Date",""'. $curdate=date('d-m-Y')."\n";

$date=date('d-m-Y H:i:s');

$filename =  " Breakdown Entry List  ".$date." ".".csv";

header('Content-type: application/xls');

header('Content-Disposition: attachment; filename='.$filename);

echo $output;

exit;
