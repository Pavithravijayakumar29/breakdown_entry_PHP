function get_machinery_value_list(breakdown_type)
{
// displaying earthmover breakdowntype
 
if(breakdown_type!=''){
if(breakdown_type=='8' || breakdown_type=='13' || breakdown_type=='7'){
var site_name=$("#site_name").val();
var plant_name=$("#plant_name").val();
var machinery_type=$("#machinery_type").val();
 
jQuery.ajax({

		type: "GET",

	    url:"breakdown_entry/get_machinery_name.php",

		data: "site_name="+site_name+"&plant_name="+plant_name+"&breakdown_type="+breakdown_type+"&machinery_type="+machinery_type,

		success: function(msg){
        
			jQuery("#machinery_val_div123").html(msg);
            //jQuery("#equipment_type_div").html(msg);
		}

	});
}else if (breakdown_type=='9') 
	{
	var site_name=$("#site_name").val();
	var plant_name=$("#plant_name").val();
	
	var entry_date=$("#date").val();
	var shift_name=$("#shift_name").val();
	

	jQuery.ajax({
	
			type: "POST",
	
			url:"breakdown_entry/get_earthmovers_name.php",
	// plant name
			data: "site_name="+site_name+"&entry_date="+entry_date+"&shift_name="+shift_name+"&plant_name="+plant_name,
	
			success: function(msg){
			// console.log("Msg", msg);
				jQuery("#machinery_val_div123").html(msg);
				//jQuery("#equipment_type_div").html(msg);
			}
	
		});
}
// disabled machinery
else{
	// console.log("In else 56*****")
	$("#machinery_type").prop("disabled",true);
}
// else{ 
//     var site_name=$("#site_name").val();
// var plant_name=$("#plant_name").val();
// var date=$("#date").val();
// var machinery_type=$("#machinery_type").val();
// //var rec= msg.split("@@");
// var d=date.split('T');
// var da=d[0];
// //alert(da);
//     jQuery.ajax({

// 		type: "GET",

// 	    url:"breakdown_entry/get_earthmover_machinery_name.php",

// 		data: "site_name="+site_name+"&plant_name="+plant_name+"&breakdown_type="+breakdown_type+"&date="+da+"&machinery_type="+machinery_type,

// 		success: function(msg){
//        // alert(msg);
// 			jQuery("#machinery_val_div123").html(msg);
//             //jQuery("#equipment_type_div").html(msg);
// 		}

// 	});
// }
// }
}
}

function get_equipment_type_1()
{
	
	
	
	// disabled equipment type 
	var breakdown_type=$("#breakdown_type").val();
var machinery_type=$("#machinery_type").val();
var equipment_type = $("#equipment_type").val();

	if(breakdown_type!=''){
	if(breakdown_type=='8' || breakdown_type=='13' || breakdown_type=='7'){
var site_name=$("#site_name").val();

var plant_name=$("#plant_name").val();

var date=$("#date").val();
//var rec= msg.split("@@");
var d=date.split('T');
var da=d[0];
		 
// if(breakdown_type!=''){
// 	if(breakdown_type=='8' || breakdown_type=='13' || breakdown_type=='7' || breakdown_type=='9')
jQuery.ajax({

		type: "GET",

	    url:"breakdown_entry/equipment_type.php",

		data: "machinery_type="+machinery_type+"&site_name="+site_name+"&plant_name="+plant_name+"&breakdown_type="+breakdown_type,

		success: function(msg){jQuery("#equipment_type_div").html(msg);

		}

	});	
}
//for Earthmover type
else if (breakdown_type=='9') 
	{
   
	var site_name=$("#site_name").val();
	var plant_name=$("#plant_name").val();

    var entry_date=$("#date").val();
	 var shift_name=$("#shift_name").val();
	

	jQuery.ajax({
	
			type: "POST",
	
			url:"breakdown_entry/get_equip_name.php",
	
			data: "machinery_type="+machinery_type+"&site_name="+site_name+"&plant_name="+plant_name+"&breakdown_type="+breakdown_type+"&entry_date="+entry_date+"&shift_name="+shift_name+"&machinery_type="+machinery_type,
			success: function(msg){jQuery("#equipment_type_div").html(msg);

			// success: function(msg){
			
			// jQuery("#equipment_type_div").html(msg);
			}
	
		});
}	
}
else{
    jQuery.ajax({

		type: "GET",

	    url:"breakdown_entry/get_earthmover_equipment_type.php",

		data: "machinery_type="+machinery_type+"&site_name="+site_name+"&plant_name="+plant_name+"&date="+da+"&breakdown_type="+breakdown_type,

		success: function(msg){
		   // alert(msg);
		    jQuery("#equipment_type_div").html(msg);

		}

	});	
}

}
//status change
function get_appr_status_breakdown(id,val,sno,user_type_ses)
{
  
  var from_date =$('#from_date').val() ; 
    var to_date =$('#to_date').val();
    var breakdown_type =$('#breakdown_type').val() ; 
     var status =$('#status').val() ; 
   var site_name =$('#site_name').val();
   var plant_name =$('#plant_name').val(); 
   var site =$('#site').val();
     var site_name_id =$('#site_name_id').val() ; 

  if (confirm("Are you sure?"))

  {
  $.ajax({

      type: "POST",

      url: "model/breakdown_entry.php?action=update_breakdown_approve_status&update_id="+id+"&approve_status="+val,

      success: function(data) {
        
       // alert(data);
   
//window.location.href="index1.php?hopen=resource_planning/admin&from_date="+from_date+"&to_date="+to_date+"&resource_no="+resource_no+"&vehicle_no="+vehicle_no+"&site_id="+site_name+"&plant_id="+plant_name+"&site="+site+"&site_name_id="+site_name_id; 

window.location.href ="index1.php?hopen=breakdown_entry/admin&from_date="+from_date+"&to_date="+to_date+"&breakdown_type="+breakdown_type+"&site_id="+site_name+"&plant_id="+plant_name+"&site="+site+"&site_name_id="+site_name_id+"&status="+status; 


  }
      
        
      });
  }
}


function get_invce_no(site_name)
{
	jQuery.ajax({

		type: "GET",

	    url:"breakdown_entry/inv_no.php",

		data: "site_name="+site_name,

		success: function(msg){jQuery("#invoice_div").html(msg);

		}

	});	
}
function get_plant_name_filter_display(site_name)
{
//alert();

    var site_ids = [];
  
   jQuery.each(jQuery('.all_site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();


	jQuery.ajax({

		type: "POST",
        data: "site_name="+site_ids,
	    url:"breakdown_entry/panel_plant_name_display.php",

		

		success: function(msg){jQuery("#panel_plant_namess").html(msg);

		}

	});	
}


function get_plant_name_breakdown(site_name)
{

 var site_ids = [];
  
   jQuery.each(jQuery('.site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();


	jQuery.ajax({

		type: "GET",

	    url:"breakdown_entry/panel_plant_name.php",

		data: "site_name="+site_ids,

		success: function(msg){
        // alert(msg);
			jQuery("#plant_name_div").html(msg);

		}

	});	

}
	
function breakdown_sub_add(random_no,random_sc,breakdown_no,site_name,shift_name,entry_date,from,to,total,remarks,breakdown_type,user_name,overall_tot,machinery_type,equipment_type)

{  
   // alert("random_no="+random_no+"random_sc="+random_sc+"breakdown_no="+breakdown_no+"site_name="+site_name+"shift_name"+shift_name+"entry_date="+entry_date+"from="+from+"to="+to+"total="+total+"remarks="+remarks+"breakdown_type="+breakdown_type+"user_name="+user_name+"overall_tot="+overall_tot+"machinery_type="+machinery_type+"equipment_type="+equipment_type);
	
	var sft_start_time = $("#sft_start_time").val();
	var sft_end_time = $("#sft_end_time").val();
	var plant_name = $("#plant_name").val();
    var sub_id = $("#sub_id_val").val();
    if(breakdown_type=='8' || breakdown_type=='13' || breakdown_type=='7' ||  breakdown_type=='9' ){
    var machinery_type = $("#machinery_type").val();
    var equipment_type = $("#equipment_type").val();
	
	
	if((site_name)&&(plant_name)&&(shift_name)&&(from)&&(to)&&((total!='00:00')||(total!='0:00'))&&(breakdown_type)&&(remarks)&&(machinery_type)&&(equipment_type))
   { 
	
	

jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/start_time.php",
		data: "from="+from+"&to="+to+"&random_no="+random_no+"&random_sc="+random_sc+"&breakdown_no="+breakdown_no+"&entry_date="+entry_date+"&sub_id="+sub_id+"&equipment_type="+equipment_type+"&machinery_type="+machinery_type,
		success: function(msg){
			
		//	alert(msg);
		// console.log("msg",msg);
		// check time
		var rec= msg.split("@@");
		if(rec[0]=='0'){
			alert("Check the Time..!");
		$("#from").focus();
		//	$("#from").val(rec[1]);
			return false;
}
			
	var sendInfo = {

		   random_no: random_no,

		   random_sc: random_sc,

		   breakdown_no:breakdown_no,
		  
		   site_name:site_name,

		   shift_name:shift_name,

		    entry_date:entry_date,
		     user_name:user_name,
		   overall_tot:overall_tot,

		   from: from,

		   to:to,

		   remarks:remarks,

		   total:total,
		   breakdown_type:breakdown_type,
		   sft_start_time:sft_start_time,
		   sft_end_time:sft_end_time,
		   plant_name:plant_name,
		  equipment_type:equipment_type,
		  machinery_type:machinery_type,
		  

	};
	
	
	$.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=ADD",

    data: sendInfo,

    success: function(data) 

	{ 
		// console.log("data",data);
		var brea=data.split("@@");
		if(brea[0]=='Already Exit'){

			alert(brea[1]);
			return false;
		}else{

		$( "#breakdown_sublist_div").html(data);
		get_shift_breakdown(shift_name,entry_date);
		get_frm_to_time(shift_name,entry_date);
		
		
		var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		
		 var res=data;
		 var count = res.split("@@");
		 
  if(count[0]=="1"){
	
	 add_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_tot);
	 $('#site_name').attr('disabled', 'disabled');
	 $('#date').attr('disabled', 'disabled'); 
	 $('#plant_name').attr('disabled', 'disabled'); 
	 $('#shift_name').attr('disabled', 'disabled'); 

  }else if(count[0]>0){
	  
	  var update_id=count[1];
	  update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id);
	 
  }
    
	},
	});

        // $('#site_name').attr('disabled', 'disabled');
      // $('#date').attr('disabled', 'disabled'); 
      // $('#mycheck').attr('disabled', 'disabled');
}
    },

    error: function() {

    }

	});
/////////////////////////

   }
    });
}
else { validate_breakdown_sublist(site_name,plant_name,shift_name,from,to,total,breakdown_type,remarks,machinery_type,equipment_type);
}
}else{
	// console.log('machinery_type',machinery_type);
    	if((site_name)&&(plant_name)&&(shift_name)&&(from)&&(to)&&((total!='00:00')||(total!='0:00'))&&(breakdown_type)&&(remarks))

   { 
jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/start_time.php",
		data: "from="+from+"&to="+to+"&random_no="+random_no+"&random_sc="+random_sc+"&breakdown_no="+breakdown_no+"&entry_date="+entry_date+"&sub_id="+sub_id,
		success: function(msg){
		//	alert(msg);
		//check time
		var rec= msg.split("@@");
		if(rec[0]=='0'){
			alert("Check the Time..!");
		$("#from").focus();
		//	$("#from").val(rec[1]);
			return false;
}

			
	var sendInfo = {

		   random_no: random_no,

		   random_sc: random_sc,

		   breakdown_no:breakdown_no,
		  
		   site_name:site_name,

		   shift_name:shift_name,

		    entry_date:entry_date,
		     user_name:user_name,
		   overall_tot:overall_tot,

		   from: from,

		   to:to,

		   remarks:remarks,

		   total:total,
		   breakdown_type:breakdown_type,
		   sft_start_time:sft_start_time,
		   sft_end_time:sft_end_time,
		   plant_name:plant_name,
		  equipment_type:equipment_type,
		  machinery_type:machinery_type,
		  

	};
	
	
	$.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=ADD",

    data: sendInfo,

    success: function(data) 
 
	{ 
		var brea=data.split("@@");
		if(brea[0]=='Already Exit'){

			alert(brea[1]);
			return false;
		}else{

		$( "#breakdown_sublist_div").html(data);
		get_shift_breakdown(shift_name,entry_date);
		get_frm_to_time(shift_name,entry_date);
		
		
		var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		
		 var res=data;
		 var count = res.split("@@");
		 
  if(count[0]=="1"){
	
	 add_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_tot);
	 $('#site_name').attr('disabled', 'disabled');
	 $('#date').attr('disabled', 'disabled'); 
	 $('#plant_name').attr('disabled', 'disabled'); 
	 $('#shift_name').attr('disabled', 'disabled'); 

  }else if(count[0]>0){
	  
	  var update_id=count[1];
	  update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id);
	 
  }
    
	},
	});

        // $('#site_name').attr('disabled', 'disabled');
      // $('#date').attr('disabled', 'disabled'); 
      // $('#mycheck').attr('disabled', 'disabled');
}
    },

    error: function() {

    }

	});
/////////////////////////
}
});

}
else { validate_breakdown_sublist(site_name,plant_name,shift_name,from,to,total,breakdown_type,remarks);
}
}
	 }

	
function edit_breakdown_sublist(id,breakdown_no,random_no,random_sc)

{

	$.ajax({

    type: "POST",

    url: "breakdown_entry/breakdown_sublist.php?id="+id+"&breakdown_no="+breakdown_no+"&random_no="+random_no+"&random_sc="+random_sc,

    success: function(data) {

		$( "#breakdown_sublist_div").html(data);

    },

    error: function() {

        alert('error handing here');

    }

	});

}
//                          random_no.value,random_sc.value,breakdown_no.value,site_name.value,shift_name.value,date.value,from.value,to.value,total.value,remarks.value,breakdown_type.value
function breakdown_sub_edit(random_no,random_sc,breakdown_no,site_name,shift_name,entry_date,from,to,total,remarks,breakdown_type,sub_id,user_name
	
	)

{
  var sft_start_time = $("#sft_start_time").val();
	var sft_end_time = $("#sft_end_time").val();
		var plant_name = $("#plant_name").val();
 var sub_id = $("#sub_id_val").val();


 if(breakdown_type=='8' || breakdown_type=='13' || breakdown_type=='7' || breakdown_type=='9'){
 
var machinery_type = $("#machinery_type").val();
    var equipment_type = $("#equipment_type").val();
	// console.log('machinery_type',machinery_type);
	if((site_name)&&(plant_name)&&(shift_name)&&(from)&&(to)&&((total!='00:00')||(total!='0:00'))&&(breakdown_type)&&(remarks)&&(machinery_type)&&(equipment_type))

   {
       
jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/start_time.php",
		data: "from="+from+"&to="+to+"&random_no="+random_no+"&random_sc="+random_sc+"&breakdown_no="+breakdown_no+"&entry_date="+entry_date+"&sub_id="+sub_id,
		success: function(msg){
			// checktiming
			var rec= msg.split("@@");
			if(rec[0]=='0'){
				alert("Check the Time..!");
			$("#from").focus();
			//	$("#from").val(rec[1]);
				return false;
}

	var sendInfo = {

		   random_no: random_no,

		   random_sc: random_sc,

		   breakdown_no:breakdown_no,

		   entry_date: entry_date,

		   site_name:site_name,

		   shift_name:shift_name,

		   from: from,

		   to:to,

		   remarks:remarks,

		   total:total,
		   breakdown_type:breakdown_type,
		   sft_start_time:sft_start_time,
		   sft_end_time:sft_end_time,
		   plant_name:plant_name,
		    equipment_type:equipment_type,
		  machinery_type:machinery_type,

	};
	
// if(((from==sft_start_time)||(from>sft_start_time))&&((to==sft_end_time)||(to<sft_end_time)))
// {
	 $.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=EDIT&sub_id="+sub_id,

    data: sendInfo,

    success: function(data) {
// console.log("data",data);
		$( "#breakdown_sublist_div" ).html(data);  
		var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		
		 var res=data;
		 var count = res.split("@@");

	  var update_id=count[1];
	  update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id);

	},
	}); 

 },

    error: function() {

        alert('error handing here');

    }

	});
// }
//    else
//    {
//    	alert("Please Enter the valid from & to time..!");
//    }
  }

	});
   }

    else { validate_breakdown_sublist(site_name,plant_name,shift_name,from,to,total,breakdown_type,remarks,machinery_type,equipment_type); }

}else{
    
	if((site_name)&&(plant_name)&&(shift_name)&&(from)&&(to)&&((total!='00:00')||(total!='0:00'))&&(breakdown_type)&&(remarks))

   {
       
jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/start_time.php",
		data: "from="+from+"&to="+to+"&random_no="+random_no+"&random_sc="+random_sc+"&breakdown_no="+breakdown_no+"&entry_date="+entry_date+"&sub_id="+sub_id,
		success: function(msg){
			// check timing
			var rec= msg.split("@@");
			if(rec[0]=='0'){
				alert("Check the Time..!");
			$("#from").focus();
			//	$("#from").val(rec[1]);
				return false;
}

	var sendInfo = {

		   random_no: random_no,

		   random_sc: random_sc,

		   breakdown_no:breakdown_no,

		   entry_date: entry_date,

		   site_name:site_name,

		   shift_name:shift_name,

		   from: from,

		   to:to,

		   remarks:remarks,

		   total:total,
		   breakdown_type:breakdown_type,
		   sft_start_time:sft_start_time,
		   sft_end_time:sft_end_time,
		   plant_name:plant_name,
		    equipment_type:equipment_type,
		  machinery_type:machinery_type,

	};
// if(((from==sft_start_time)||(from>sft_start_time))&&((to==sft_end_time)||(to<sft_end_time)))
// {
	 $.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=EDIT&sub_id="+sub_id,

    data: sendInfo,

    success: function(data) {

		$( "#breakdown_sublist_div" ).html(data);  
		var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		
		 var res=data;
		 var count = res.split("@@");

	  var update_id=count[1];
	  update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id);

	},
	}); 

 },

    error: function() {

        alert('error handing here');

    }

	});
// }
//    else
//    {
//    	alert("Please Enter the valid from & to time..!");
//    }
  }

	});
   }

    else { validate_breakdown_sublist(site_name,plant_name,shift_name,from,to,total,breakdown_type,remarks,machinery_type,equipment_type); }

}

}



function delete_breakdown_sublist(delete_id,breakdown_no,random_no,random_sc)

{

	var shift_name = $("#shift_name").val();
	var entry_date = $("#date").val();

	if (confirm("Are you sure?")) {

	$.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=delete_sub&delete_id="+delete_id+"&breakdown_no="+breakdown_no+"&random_no="+random_no+"&random_sc="+random_sc,

    success: function(data) {

		$( "#breakdown_sublist_div" ).html(data);   
		get_shift_breakdown(shift_name,entry_date);
		get_frm_to_time(shift_name,entry_date);
		var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		
		 var res=data;
		 var count = res.split("@@");
  if(count[2]==0){
	 
	   var delete_id=count[1];

	  delete_breakdown_main(delete_id);
	 window.location.href ="index1.php?hopen=breakdown_entry/admin";
  }else if(count[2]>0){
	  
	  var update_id=count[1];
	  var date=$('#entry_date').val();
	    var site_name=$('#site_name').val();
		var shift_name=$('#shift_name').val();
		  var user_name=$('#user_name').val();
	   update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id)
  }
	},
	});
	       },

    error: function() {

        alert('error handing here');

    }

	});



	}

	

}

function  breakdown_aproval(apprve_date_time,apprved_status,apprve_by,update_app_id,remarks,from_date,to_date,site_name,breakdown_type,status,das_status,das_site_name)
{

	var plant_name=$("#plant_name").val();
var sendInfo = {

		apprve_date_time: apprve_date_time,

		   apprved_status: apprved_status,

		   apprve_by: apprve_by,

		   remarks:remarks,


	};

	$.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=UPDATE_APPROVAL&update_app_id="+update_app_id+"&apprved_status="+apprved_status+"&apprve_by="+apprve_by,

    data: sendInfo,

    success: function(data) {
    	//alert(data);
window.location.href ="index1.php?hopen=breakdown_entry/admin&from_date="+from_date+"&to_date="+to_date+"&site_id="+site_name+"&breakdown_type="+breakdown_type+"&status="+status+"&site="+das_status+"&site_name_id="+das_site_name+"&plant_id="+plant_name;

    },

    error: function() {

        alert('error handing here');

    }

	});


}


function break_reading_aprova1(apprve_date_time,apprved_status,apprve_by,reading_no,update_app_id,remarks)
{
    //alert(update_id);
  
  var sendInfo = {

    apprve_date_time: apprve_date_time,
                apprve_by: apprve_by,
        apprved_status: apprved_status,

       reading_no: reading_no,
       remarks:remarks,
    };
$.ajax({

    type: "POST",

     url: "model/breakdown_entry.php?action=UPDATE_APPROVAL&update_app_id="+update_app_id,

    data: sendInfo,

    success: function(data) {
    //	alert(update_app_id);
    document.getElementById("apprve_status"+update_app_id).disabled = true;
    document.getElementById("remarks"+update_app_id).disabled = true;
    $("#update_div"+update_app_id).hide();
    $("#hide_div"+update_app_id).show();
    },

    error: function() {

        alert('error handing here');

    }

  });
}


function add_breakdown_main11(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_tot,das_status)
{
	
	var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		 var res=data;
		 var count = res.split("@@");
		 if(count[2]>0){
  if(count[0]==0){
	  add_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_tot);
	  window.location.href ="index1.php?hopen=breakdown_entry/admin&das_status="+das_status;
		hide_dialog();
  }else if(count[0]>0){
  	
	  var update_id=count[1];
	  update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id);
	  window.location.href ="index1.php?hopen=breakdown_entry/admin";
		hide_dialog();
  }
  
   }else{
			 alert("Please Enter sublist");
			return false; 
		 }
	},
	});
	 
	
	
}
function add_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,overall_tot)

{      
	var overall_tot=$('#overall_tot').val();
	var plant_name=$('#plant_name').val();

      
		if((breakdown_no)&&(site_name)&&(plant_name)&&(shift_name)&&(user_name)&&(overall_tot!='0:00'))

   {

	var sendInfo = {

		   random_no: random_no,

		   random_sc: random_sc,

		   breakdown_no: breakdown_no,

		   entry_date: entry_date,

		   site_name:site_name,

		   shift_name:shift_name,
             user_name:user_name,
		   overall_tot:overall_tot,
		   plant_name:plant_name,
		  

	};

	$.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=SUBMIT",

    data: sendInfo,

    success: function(data) {
        
		

    },

    error: function() {

        alert('error handing here');

    }

	});

   } else { 

   validate_breakdown_main(breakdown_no,site_name,plant_name,shift_name,user_name,overall_tot);

    }

}

function  update_breakdown_main11(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id,from_date,to_date,site_name1,breakdown_type,status,site,site_name_id,plant_name)

{
//var plant_name =$('#plant_name').val(); 

	var form_data={
			 random_no: random_no,
		   random_sc: random_sc,
			
		}
        $.ajax({

    type: "POST",

    url: "breakdown_entry/txr_count.php",

    data: form_data,

    success: function(data) 
	{
		 var res=data;
		 var count = res.split("@@");
		 if(count[2]>0){
	update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id);
	window.location.href ="index1.php?hopen=breakdown_entry/admin&from_date="+from_date+"&to_date="+to_date+"&breakdown_type="+breakdown_type+"&site_id="+site_name1+"&plant_id="+plant_name+"&site="+site+"&site_name_id="+site_name_id+"&status="+status; 

	 }else{
			 alert("Please Enter sublist");
			return false; 
		 }
	},
	});
}

function update_breakdown_main(random_no,random_sc,breakdown_no,entry_date,site_name,shift_name,user_name,update_id)

{
      var overall_tot=$('#overall_tot').val();
      var site_name=$('#site_name').val();
      var plant_name=$('#plant_name').val();


	 // if((breakdown_no)&&(site_name)&&(shift_name)&&(user_name)&&(overall_tot!='0:00'))

  // {

	var sendInfo = {

		random_no: random_no,

		   random_sc: random_sc,

		   breakdown_no: breakdown_no,

		   entry_date: entry_date,

		   site_name:site_name,

		    shift_name:shift_name,

		   user_name:user_name,
		   overall_tot:overall_tot,
		   plant_name:plant_name,

	};

	$.ajax({

    type: "POST",

    url: "model/breakdown_entry.php?action=UPDATE&update_id="+update_id,

    data: sendInfo,

    success: function(data) {

    },

    error: function() {

        alert('error handing here');

    }

	});

  // } 

   //else {   

  // validate_breakdown_main(breakdown_no,site_name,shift_name,user_name,overall_tot);

//}

}

function delete_breakdown_main11(delete_id)

{ //alert();
	var from_date =$('#from_date').val() ; 
    var to_date =$('#to_date').val();
    var breakdown_type =$('#breakdown_type').val() ; 
     var status =$('#status').val() ; 
   var site_name =$('#site_name').val();
   var plant_name =$('#plant_name').val(); 
   var site =$('#site').val();
     var site_name_id =$('#site_name_id').val() ; 

if (confirm("Are you sure?")) {
delete_breakdown_main(delete_id);
window.location.href ="index1.php?hopen=breakdown_entry/admin&from_date="+from_date+"&to_date="+to_date+"&breakdown_type="+breakdown_type+"&site_id="+site_name+"&plant_id="+plant_name+"&site="+site+"&site_name_id="+site_name_id; 

 //window.location.href ="index1.php?hopen=breakdown_entry/admin";
	 hide_dialog();
}
}

 function delete_breakdown_main(delete_id)

{ 

	

	$.ajax({
    type: "POST",
    url: "model/breakdown_entry.php?action=delete&delete_id="+delete_id,
    success: function(data) {
    	//alert(data);
    },
    error: function() {
        alert('error handing here');

    }

	});
	}

function delete_breakdown_main1(delete_id,breakdown_no,random_no,random_sc)

{ 

	alert(delete_id);alert(breakdown_no);alert(random_no);alert(random_sc);

	$.ajax({
    type: "POST",
	       url: "model/breakdown_entry.php?action=delete_sub&delete_id="+delete_id+"&breakdown_no="+breakdown_no+"&random_no="+random_no+"&random_sec="+random_sec,
    success: function(data) {
    },
    error: function() {
        alert('error handing here');

    }

	});
	}

function  validate_breakdown_sublist(site_name,plant_name,shift_name,from,to,total,breakdown_type,remarks,machinery_type,equipment_type)

{      //alert(equipment_type);
		if(site_name==='') { $("#site_name").addClass('errorClass'); return false;} else {$("#site_name").addClass('successClass');}
		if(plant_name==='') { $("#plant_name").addClass('errorClass'); return false;} else {$("#plant_name").addClass('successClass');}


		if(shift_name==='') { $("#shift_name").addClass('errorClass'); return false;} else {$("#shift_name").addClass('successClass');}

		if(breakdown_type==='') { $("#breakdown_type").addClass('errorClass'); return false;} else {$("#breakdown_type").addClass('successClass');}

		if(from==='') { $("#from").addClass('errorClass'); return false;} else {$("#from").addClass('successClass');}

	    if(to==='') { $("#to").addClass('errorClass'); return false;} else {$("#to").addClass('successClass');}
       if(from>=to){
       	alert("To time should be greater than From time...!");
       }
	    if((total==='0:00')||(total==='00:00')||(total==='')) { $("#total").addClass('errorClass'); return false;} else {$("#total").addClass('successClass');}
        if(remarks==='') { $("#remarks").addClass('errorClass'); return false;} else {$("#remarks").addClass('successClass');}
        if(machinery_type==='') { $("#machinery_type").addClass('errorClass'); return false;} else {$("#machinery_type").addClass('successClass');}
        if(equipment_type==='') {  $("#equipment_type").addClass('errorClass'); return false;} else {$("#equipment_type").addClass('successClass');}
        
}



function validate_breakdown_main(breakdown_no,site_name,plant_name,shift_name,user_name,overall_tot)

{

		if(breakdown_no==='') { $("#breakdown_no").addClass('errorClass'); return false;} else {$("#breakdown_no").addClass('successClass');}

		if(site_name==='') { $("#site_name").addClass('errorClass'); return false;} else {$("#site_name").addClass('successClass');}
		if(plant_name==='') { $("#plant_name").addClass('errorClass'); return false;} else {$("#plant_name").addClass('successClass');}


		
		if(shift_name==='') { $("#shift_name").addClass('errorClass'); return false;} else {$("#shift_name").addClass('successClass');}

        if(user_name==='') { $("#user_name").addClass('errorClass'); return false;} else {$("#user_name").addClass('successClass');}
        var overall_tot=$('#overall_tot').val();
        if((overall_tot==='0:00')||(overall_tot==='')) { $("#breakdown_sublist_validation").show(); return false;} else {$("#breakdown_sublist_validation").hide();}
}



  

function get_total_time_mach_only_break_down(start_time,end_time)
{ 
	var start_time=$('#from').val();
	var end_time=$('#to').val();
	var shift_name=$('#shift_name').val();
	jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/total_time.php",
		data: "start_time="+start_time+"&end_time="+end_time+"&shift_name="+shift_name,
		success: function(msg){
			
			jQuery("#get_total_time_div").html(msg);
		}
	});
	
}
 
function get_shift_breakdown(shift_time,date_value){
	//alert(shift_time);
	//var date_value = $('#date').val();
	//getalert(date_value);
	jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/shift_name_change_start.php",
		data: "shift_time="+shift_time+"&date_value="+date_value,
		success: function(msg){
			
			jQuery("#get_start_break_shift_div").html(msg);
		}
	});
	
	jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/shift_name_change_end.php",
		data: "shift_time="+shift_time+"&date_value="+date_value,
		success: function(msg){
			
			jQuery("#get_end_break_shift_div").html(msg);
		}
	});
}

function get_frm_to_time(shift_name,date_value)
{ 

	//var date_value = $('#date').val();
	//var shift_name=$('#shift_name').val();
	jQuery.ajax({
		type: "POST",
		url: "breakdown_entry/get_frm_to_time.php",
		data: "shift_name="+shift_name+"&date_value="+date_value,
		success: function(msg){
			//alert(msg);
			jQuery("#get_frm_to_time_div").html(msg);
		}
	});
	
}