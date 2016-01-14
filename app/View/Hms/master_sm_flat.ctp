<?php
foreach($cursor11 as $dataaaa)
{
$vallll = (int)@$dataaaa['society']['area_scale'];
}
?>

<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Setup
</div>
			
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li ><a href="<?php echo $webroot_path; ?>Hms/master_sm_wing" rel='tab'> Wing</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/flat_type" rel='tab'>Unit Number</a></li>
<li class="active"><a href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel='tab'>Unit Configuration</a></li>
<!--<li><a href="<?php echo $webroot_path; ?>Hms/flat_nu_import" rel='tab'>Flat Number Import</a></li>-->
<li><a href="<?php echo $webroot_path; ?>Hms/society_details" rel='tab' >Society Details</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/society_settings" rel='tab'>Society Settings</a></li>
</ul>



<div class="tab-content" style="min-height:330px;">
<div class="tab-pane active" id="tab_1_1">
<div id="done">

<a href="#" class="btn purple" role="button" id="import">Import csv</a>
<a  class="btn yellow" onclick="area_type()">Area Type</a>


<div id='suces'>
<div id="error_msg"></div>
<div id="myModal3" class="modal hide fade in" style="display: none;">

<div class="modal-backdrop fade in"></div>
<form id="form1" method="post">
<div class="modal">
<div class="modal-header">
<h4 id="myModalLabel1">Import csv</h4>
</div>
<div class="modal-body">
<input type="file" name="file" class="default" id="image-file">
<label id="vali"></label>			
			<strong><a href="unit_config" download>Click here for sample format</a></strong>
			<br/>
			<h4>Instruction set to import users</h4>
			<ol>
			<li>All the field are compulsory.</li>
			<li>Wing and Flat number be valid as per society setting.</li>
			<li>Flat type be valid as per society setting. </li>
			<li>Flat area be valid as per society setting. </li>
			<li>Flat number should be not same.</li>
			</ol>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn" id="close_div">Close</button>
			<button type="submit" class="btn blue import_btn">Import</button>
		</div>
	</div>
	</form>
</div>

<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>
<div id="url_main" style="overflow:auto;">
<table width="100%" style="background-color:#CDD5ED;">
<tr class="table table-bordered table-hover" style="font-size:16px;">
<th style="text-align:center;" width="25%">Wing</th>
<th style="text-align:center;" width="25%">Unit Number</th>
<th style="text-align:center;" width="25%">Unit Type</th>
<th style="text-align:center;" width="25%">Unit Area <?php if ($vallll == 0) { ?>(Sq. Ft.)<?php } else { ?> (Sq. Mtr.) <?php } ?></th>
</tr>
</table>
<form id="form2" method="post">

<table width="100%" id="myTable">
<tr class="table table-bordered table-hover" id="tr1">
<td width="25%" style="text-align:center;">
<select name="wing_name1" class=" m-wrap medium wing chosen" id="sel1" inc_id="1">
<option value="">Select Category</option>
<?php
foreach($user_wing as $collection) 
{
$wing_id=$collection['wing']["wing_id"];
$wing_name=$collection['wing']["wing_name"];
?>
<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
<?php } ?>
</select>
</td>					
	
<td width="25%" style="text-align:center;" id="showflat1">

</td>	
				
<td width="25%" style="text-align:center;">
<select name="flat_type1" class="m-wrap medium chosen" id="fltp1">
<option value="">--SELECT UNIT TYPE--</option>
<?php
foreach($cursor4 as $collection)
{
$auto_id = (int)$collection['flat_type_name']['auto_id'];
$flat_type_name = $collection['flat_type_name']['flat_name'];	
?>
<option value="<?php echo $auto_id; ?>"><?php echo $flat_type_name; ?></option>
<?php } ?>
</select>
</td>



<td width="25%" style="text-align:center;">
<input type="text" name="area1" class="m-wrap medium" id="ar1" />
</td>
				
</tr>
</table>



<br/>
<a role="button" class="btn blue " id="add_row"><i class="icon-plus"></i> Add row</a>
<div align="center">
<button type="submit" id="submit" class="btn blue">Submit</button>
</div>
</form>

</div>
</div>
</div>
</div>
</div>

</div>			

<?php //////////////////////////////////////////////////////////////////////////////////////// ?>



<br>
                    
<div>
<a href="flat_excel" class="btn blue" style="float:right;">Export in Excel</a>
</div>                    
  <br />                  

					<div class="portlet box" style="width:80%;overflow:auto;">

					<div class="portlet-body" style="float:right; width:70%;" align="center">
					
					<table class="table table-striped table-bordered" id="sample_2" style="width:100%;">
					<thead>
					<tr>
					<th>Sr No.</th>
					<th>Wing</th>
					<th>Unit Number</th>
                    <th>Unit Type</th>
                    <th>Unit Area <?php if ($vallll == 0) { ?>(Sq. Ft.)<?php } else { ?> (Sq. Mtr.) <?php } ?></th>
					</tr>
							</thead>
							<tbody>
							<?php
							$q=0;
	                        foreach($user_wing as $collection)
	                        {
												
							$wing_id = (int)$collection['wing']['wing_id'];
							$wing_name = $collection['wing']['wing_name'];
							
							$result_flat = $this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_all_flat_via_wing_id'),array('pass'=>array(@$wing_id)));	
							foreach($result_flat as $data){ $q++;	
								$flat_name = $data['flat']['flat_name'];
								$flat_area = @$data['flat']['flat_area'];
								$flat_type_id = (int)@$data['flat']['flat_type_id'];
								
								

								$fl_tp2 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array(@$flat_type_id)));		
								foreach($fl_tp2 as $collection)
								{
								$flat_type_name = $collection['flat_type_name']['flat_name'];
								}
								?>
							<tr>
							<td><?php echo $q; ?></td>
							<td><?php echo $wing_name; ?></td>
							<td><?php echo $flat_name; ?></td>
							<td><?php if($flat_type_id == 0) { echo "-"; } else { echo $flat_type_name; } ?></td>
							<td><?php if($flat_area == 0) { echo "-"; } else { echo $flat_area; } ?></td>
							</tr>
							<?php } } ?>
</tbody>
</table>

</div>
</div>
    
  
</div>
</div>
<script>	
$(document).ready(function(){

});
</script>
<script>
$(document).ready(function(){
	 $("#add_row").bind('click',function(){
		var count = $("#myTable tr").length;
		count++;
		
		$("#url_main").append();
		$.get('master_sm_flat_add_row?con='+count, function(data){
			content= data;
			$('#myTable').append(content);
		});
	 });
	
	
	 $(".delete").live('click',function(){
		var id = $(this).attr("id");
		$('#tr'+id).remove();
	 });
	 
	 
	 $(".wing").live('change',function(){
		var c=this.value;
		var i=$(this).attr('inc_id');
		$('#echo_flat'+i).html("Loading...").load('return_flat_via_wing_id3?con2='+c+'&con1='+i);
	 });
	 
	 
	 $('form#form2').submit( function(ev){
		ev.preventDefault();
		var count = $("#myTable tr").length;
		var ar = [];
		if(count>0)
		{
		for(var i=1;i<=count;i++)
		{
		
		var w=$("#url_main table tr:nth-child("+i+") td:nth-child(1) select").val();
		var f=$("#url_main table tr:nth-child("+i+") td:nth-child(2) select").val();
		var ft=$("#url_main table tr:nth-child("+i+") td:nth-child(3) select").val();
		var a=parseFloat($("#url_main table tr:nth-child("+i+")  input[name=area1]").val());
		
		ar.push([w,f,ft,a]);
		
		}
		
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "master_sm_flat_vali?q="+myJsonString,
			dataType:'json',
			}).done(function(response) {
					if(response.type == 'error'){
					output = '<div class="alert alert-error">'+response.text+'</div>';
					$("#submit").removeClass("disabled").text("submit");
					$("html, body").animate({
					scrollTop:0
					},"slow");
					}
					if(response.type=='succ'){
					$('#suces').show().html('<div class="alert alert-success"><h4 class="alert-heading">Success!</h4><p>'+response.text+'</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel="tab">OK</a></p></div>');
					}
			$("#error_msg").html(output);
			});

		 };
	 });
	
		 
});
</script>
<script>
$(document).ready(function() {
$("#import").bind('click',function(){
		$("#myModal3").show();
	 });
	 
	  $("#close_div").bind('click',function(){
	  $("#myModal3").hide();
	 });
	$(".wing").live('change',function(){
		var c=this.value;
		var i=$(this).attr('inc_id');
		$('#showflat'+i).html("Loading...").load('return_flat_via_wing_id3?con2='+c+'&con1='+i);
	 });
	
	
	$('form#form1').submit( function(ev){
			ev.preventDefault(); 
		
		var im_name=$("#image-file").val();
		if(im_name==""){
		$("#vali").html("<span style='color:red;'>Please Select a Csv File</span>");	
		return false;
		}
		
		var ext = $('#image-file').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['csv']) == -1) {
			$("#vali").html("<span style='color:red;'>Please Select a Csv File</span>");
			return false;
		}
		
		$(".import_btn").text("Importing...");
		var m_data = new FormData();
		m_data.append( 'file', $('input[name=file]')[0].files[0]);
		$.ajax({
			url: "import_flat_configuration",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			}).done(function(response) {
			$("#myModal3").hide();
			$("#url_main").html(response);
			
    
	
var insert = 1;
var count = $("#open_bal tr").length;
var ar = [];

for(var i=2;i<=count;i++)
{
$("#open_bal tr:nth-child("+i+") span.report").remove();
$("#open_bal tr:nth-child("+i+") span.report").css("background-color","#FFF;");
var wing = $("#open_bal tr:nth-child("+i+") td:nth-child(1) input").val();
var flat=$("#open_bal tr:nth-child("+i+") td:nth-child(2) input").val();
var type=$("#open_bal tr:nth-child("+i+") td:nth-child(3) select").val();
var feet=parseFloat($("#open_bal tr:nth-child("+i+") td:nth-child(4) input").val());

ar.push([wing,flat,type,feet,insert]);

}

var myJsonString = JSON.stringify(ar);
myJsonString=encodeURIComponent(myJsonString);
	
	
$.ajax({
url: "save_flat_imp?q="+myJsonString,
type: 'POST',
dataType:'json',
}).done(function(response) {
if(response.report_type=='error'){
jQuery.each(response.report, function(i, val) {
$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");


});
}	
});
});

$(".import_op").live('click',function(){

var insert = 2;
var count = $("#open_bal tr").length;
var ar = [];

for(var i=2;i<=count;i++)
{
$("#open_bal tr:nth-child("+i+") span.report").remove();
$("#open_bal tr:nth-child("+i+") span.report").css("background-color","#FFF;");
var wing = $("#open_bal tr:nth-child("+i+") td:nth-child(1) input").val();
var flat=$("#open_bal tr:nth-child("+i+") td:nth-child(2) input").val();
var type=$("#open_bal tr:nth-child("+i+") td:nth-child(3) select").val();
var feet=parseFloat($("#open_bal tr:nth-child("+i+") td:nth-child(4) input").val());

ar.push([wing,flat,type,feet,insert]);
}

var myJsonString = JSON.stringify(ar);
myJsonString=encodeURIComponent(myJsonString);
	
	
$.ajax({
url: "save_flat_imp?q="+myJsonString,
type: 'POST',
dataType:'json',
}).done(function(response) {
if(response.report_type=='error'){
jQuery.each(response.report, function(i, val) {
$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');
$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

$("#open_bal tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");

});
}
if(response.report_type=='vali')
{
$("#vali5").html('<b style="color:red;">'+response.text+'</b>');
}
if(response.report_type=='done')
{
$("#done").html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>Record Inserted Successfully</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel="tab">OK</a></p></div>');
	
}
});
});
});
}); 
</script>	



<script>
function area_type()
{
$("#pppupp").show();
}

function area_type2()
{
$("#pppupp").hide();
}

</script>

<div id="pppupp" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<form method="post">
<div class="modal-body">
<center>
<select name="arra_typpp" class="m-wrap medium">
<option value="0" <?php if($vallll == 0) { ?> selected="selected" <?php } ?>>Per Square Feet</option>
<option value="1" <?php if($vallll == 1) { ?> selected="selected" <?php } ?> >Per Square Meter</option>
</select>
</center>
</div>
<div class="modal-footer">
<a class="btn" onclick="area_type2()">Cancel</a>
<button type="submit" class="btn green" name="sssbbb">Submit</button>
</form>
</div>
</div>
</div> 
			