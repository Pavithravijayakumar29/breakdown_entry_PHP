<?php
error_reporting(0); 

ob_start();

session_start(); 

require_once("../model/config.inc.php"); 

require_once("../model/Database.class.php"); 

require_once("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
$user_type_ids=$_SESSION['user_type_ids'];

$session_user_name=$_SESSION['sess_user_name'];

$session_password=$_SESSION['password'];

$user_types=$_SESSION['user_types'];

$ses_site=$_SESSION['sess_site_id'];

$sess_staff_id=$_SESSION['sess_staff_id'];
 $user_type_ses=$_SESSION['user_types'];

$ses_site=$_SESSION['sess_site_id'];
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$from_date=$_REQUEST['from_date'];
$to_date=$_REQUEST['to_date'];
//$site_name=$_REQUEST['site_name'];
$plant_name=$_REQUEST['plant_name'];
$breakdown_type=$_REQUEST['breakdown_type'];

$site=$_REQUEST['site'];
$status=$_REQUEST['status'];
$site_name_id=$_REQUEST['site_name_id'];

if($ses_site=='All'){
  if($_REQUEST['site_name']!=''){ $site_name=$_REQUEST['site_name'];  }else{
       $site_name='';}
}else{
  if($_REQUEST['site_name']!=''){ $site_name=$_REQUEST['site_name'];  }else{
       $site_name=$ses_site;}
  
}

$current_date=date('Y-m-d');
if($_REQUEST['site']=='site')  
{
if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}


if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

if($status!=""){ $status1 = "a.approved_status='$status'";}else{$status1="a.approved_status='0'";}
}
else
{
    if($from_date!=""){ $from_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')>='$from_date'";}else{$from_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($to_date!=""){ $to_date1 = "DATE_FORMAT(a.entry_date,'%Y-%m-%d')<='$to_date'";}else{$to_date1="DATE_FORMAT(a.entry_date,'%Y-%m-%d')='$current_date'";}

if($site_name!=""){ $site_name1 = "a.site_name IN ($site_name) ";}else{$site_name1='';}

if($plant_name!=""){ $plant_name1 = "a.plant_name IN ($plant_name) ";}else{$plant_name1='';}


if($breakdown_type!=""){ $breakdown_type1 = "b.breakdown_type='$breakdown_type'";}else{$breakdown_type1='';}

}

$all_value10 = $from_date1."@".$to_date1."@".$breakdown_type1."@".$site_name1."@".$status1."@".$plant_name1;


// if($_REQUEST['site']=='site'){
// $all_value10 = $from_date1."@".$to_date1."@".$breakdown_type1."@".$site_name1."@".$status1."@".$plant_name1;}else{
//   $all_value10 = $from_date1."@".$to_date1."@".$breakdown_type1."@".$site_name1."@".$plant_name1;
// }


 $all_array10 = explode('@',$all_value10);
foreach($all_array10 as $value10)
{ 
  if($value10!='')
  {
  $get_query131 .= $value10." AND ";
  }
}

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = "(a.breakdown_no like '%".$searchValue."%') and ";
}

## Total number of records without filtering



$sel = mysql_query("select count(*) as allcount from   breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc  where ".$searchQuery." ".$get_query131."  a.id!='' group by a.breakdown_no order by a.id DESC");


  
$records = mysql_fetch_array($sel);
$all_count=mysql_num_rows($sel);
$totalRecords = $all_count;

## Total number of record with filtering
if($ses_site=='All')
{
  $sel = mysql_query("select count(*) as allcount from   breakdown_entry as a join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc  where ".$searchQuery." ".$get_query131."  a.id!='' group by a.breakdown_no ");

 
}
else{
    $sel = mysql_query("select count(*) as allcount from   breakdown_entry as a  join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc where ".$searchQuery." ".$get_query131."  a.id!='' and a.site_name IN ($ses_site) group by a.breakdown_no ");

    }
$records = mysql_fetch_array($sel);
$all_count=mysql_num_rows($sel);
$totalRecordwithFilter = $all_count;

## Fetch records
if($ses_site=='All')
{

   $empQuery = "select *,a.id as main_id,a.remarks as remarks from breakdown_entry as a  join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc  WHERE ".$searchQuery." ".$get_query131." a.id!='' group by a.breakdown_no order by a.id ".$columnSortOrder." limit ".$row.",".$rowperpage;
}
else{
 

 $empQuery = "select *,a.id as main_id,a.remarks as remarks from breakdown_entry as a  join breakdown_entry_sub as b on a.breakdown_no=b.breakdown_no and a.random_no=b.random_no and a.random_sc=b.random_sc  WHERE ".$searchQuery." ".$get_query131." a.id!='' and a.site_name IN ($ses_site) group by a.breakdown_no  order by a.id ".$columnSortOrder." limit ".$row.",".$rowperpage;
}
$empRecords = mysql_query($empQuery);
$data = array();
$sno=$row;
while ($record = mysql_fetch_array($empRecords)) 
{
  $sno=$sno+1;
  $date=date("d-m-Y",strtotime($record['entry_date']));
$shift=get_shift_name($record['shift_name']);
	$approve_date = $record['approved_date_time'];
  $approved_by = $record['approved_by'];
 $app_desc = $record['remarks'];
  $app_coord_dt=explode(' ',$approve_date);

      
      
 if($app_coord_dt[0]!='0000-00-00')
        {

            if($approved_by!='')
            {

             $staff= get_staff_name($approved_by).'<br>';
             }
            if($app_coord_dt[0]!='0000-00-00')
             { 
             $date1= date('d-m-Y H:i a',strtotime($approve_date)).'<br>';
             }
              if($app_desc!='')
              {  
                $desc= ucfirst($app_desc);
              }
              $no1=$record['breakdown_no'];
              $no=" <div class='tooltip8'> 
                  <span class='tooltiptext8'> $staff$date1$desc</span>$no1</div>";
          
           }
          else{ 
           $no=$record['breakdown_no']; 
           }
        if($record['approved_status']=='0'){

          $style1="<span style='color:#F31317' >$no</span>";
        }else{
          $style1="<span style='color:#0AB80D' >$no</span>";
        }
     

 $site=get_site_name($record['site_name']);
  $plant_name1=$record['plant_name'];
  $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$plant_name1'"));
  $plant_id11= $party_names['plant'];

if($plant_name1!=''){  $plant=ucfirst($plant_id11);  } else { $plant="---";} 

$overall_time=$record['overall_time'];



$print="<a href=javascript:breakdown_indi_print('breakdown_entry/breakdown_view.php?breakdown_no=". $record[breakdown_no]."&main_id=". $record[main_id]."&random_no=".$record[random_no]."&random_sc=". $record[random_sc]."')><img  align='center' src='image/view.png' width='30' height='30' border='0' title='PRINT' value='Print' /></a>";
/////



////
if($record['approved_status']=='1') 

        { $tip=$record[main_id];
          $zero='0';
          
          if($user_type_ses=='30' ){ 
        $verified_status="<img  align='center' src='image/tick.png' width='30' height='30' border='0' id='status_div' title='Verified' value='1'  onClick='get_appr_status_breakdown(" .$tip.",".$zero.",".$sno. ",".$user_type_ses. ")'/>";
      }else{
        $verified_status="<img  align='center' src='image/tick.png' width='30' height='30' border='0' id='status_div' title='Verified' value='1' />";
      }

        } 
        else {
          $tip=$record[main_id];
          $zero='1';
         
          if($user_type_ses=='30'){ 
        $verified_status="<img  align='center' src='image/deletes.png' width='30' height='30' border='0' id='status_div' title='Pending' value='1'    onClick='get_appr_status_breakdown(" .$tip.",".$zero.",".$sno. ",".$user_type_ses.")' />"; 
      }else{
        $verified_status="<img  align='center' src='image/deletes.png' width='30' height='30' border='0' id='status_div' title='Pending' value='1'  />"; 
      }
 
        }

        /////

if($_REQUEST[site]!='site'){  

           if($record['approved_status']=='1') {

            
               $action=' <span style="color:#15D00D" > Verified </span>';
             
              }else{ 
      
                  
 $action="<a href=breakdown_entry/update.php?update_id=".$record[main_id]."&breakdown_no=".$record[breakdown_no]."&random_no=".$record[random_no]."&random_sc=".$record[random_sc]."&site=".$_REQUEST['site']."&from_date=".$_REQUEST[from_date]."&to_date=".$_REQUEST['to_date']."&to_date=".$_REQUEST['to_date']."&site_name=".$_REQUEST['site_name']."&breakdown_type=".$_REQUEST['breakdown_type']."&status=".$_REQUEST['status']."&site_name_id=".$_REQUEST['site_name_id']."&plant_name=".$_REQUEST['plant_name']." title='Update Breakdown Entry' data-toggle='modal' data-target='#myModal' data-remote='false' class='btn btn-default' ><span class='glyphicon glyphicon-pencil'></span></a> <a href='#' title='Delete  Details' class='btn btn-default' onClick='delete_breakdown_main11(" .$record[main_id].")'><span class='glyphicon glyphicon-trash'></span></a>";
    /*if($user_type_ses!='167') { $action11=$action1; if($user_type_ses=='30'){$action22=$action2;}

    $action=$action11."".$action22;
  
          
          }else{
             if($record['approved_status']=='1') {

            
               $action=' <span style="color:#15D00D" > Verified </span>';
             
              }else{
              $action=$action11."".$action22;

              }
          } 
       }*/
     }
              } 


              elseif($_REQUEST[site]=='site'){
    $action="<a href=breakdown_entry/breakdown_approval.php?update_id=".$record[main_id]."&breakdown_no=".$record[breakdown_no]."&random_no=".$record[random_no]."&random_sc=".$record[random_sc]."&das_status=".$_REQUEST[site]."&from_date=".$_REQUEST[from_date]."&to_date=".$_REQUEST[to_date]."&site_name=".$_REQUEST['site_name']."&breakdown_type=".$_REQUEST['breakdown_type']."&status=".$_REQUEST['status']."&das_site_name=".$_REQUEST['site_name_id']." title='Approval  Breakdown' data-toggle='modal' data-target='#myModal' data-remote='false' class='btn btn-default' ><span class='glyphicon glyphicon-check'></span></a></a> ";

           } else{
            
           } 

   $data[] = array( 
      "sno"=>$sno,

        "date"=>$date,
      //  
        "breakdown_no"=>$style1,
       "site"=>$site,
        "plant"=>$plant,
        "shift"=>$shift,
        "overall_time"=>$overall_time,
       "view"=>$print,
      "verified_status"=>$verified_status,
      //  "mr"=>$mr,
      //   "osc_upload"=>$osc_upload,
      //     "osc_view"=>$osc_view,
      //    "verified_status"=>$verified_status,

      //      /* "verified_status"=> "<div id='status_change_div$sno' align='center'> $verified_status </div>",*/
      //          "print"=>$print,
                "action"=>$action,
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>
