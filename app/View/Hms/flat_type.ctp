<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Setup
</div>
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li><a href="<?php echo $webroot_path; ?>Hms/master_sm_wing" rel='tab'> Wing</a></li>
<li class="active"><a href="<?php echo $webroot_path; ?>Hms/flat_type" rel='tab'>Unit Number</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel='tab'>Unit Configuration</a></li>
<!--<li><a href="<?php echo $webroot_path; ?>Hms/flat_nu_import" rel='tab'>Flat Number Import</a></li>-->
<li><a href="<?php echo $webroot_path; ?>Hms/society_details" rel='tab'>Society Details</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/society_settings" rel='tab'>Society Settings</a></li>
</ul>
<div class="tab-content" style="min-height:300px;">
<div class="tab-pane active" id="succ">
<a href="#"role="button" class="btn blue" id="import_btn">Import csv</a>
<div id="error_msg"></div>
<div id="don"></div>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php ////////////////////////////////////////////////////////////////////////////////////////////// ?>   
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">    
<div class="row-fluid">
<div class="span5">    
<form  method="post" id="form2">
<br />
<div id="error_msg"></div>
<br />   
<label style="font-size:14px;">Select Wing</label>   
<div class="controls">
<select name="wing" id="tp" class="m-wrap span7 chosen">
<option value="">Select</option>
<?php
foreach($cursor2 as $collection)
{
$wing_id = (int)$collection['wing']['wing_id'];	 
$wing_name = $collection['wing']['wing_name'];		 
?>
<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
<?php } ?>
</select> 
<label report="wing" class="remove_report"></label>  
</div>
<br />   

<label style="font-size:14px;">Unit Number</label>
<div id="url_main">
<div>
<input type="text" class="m-wrap span7" maxlength="10" id="nu">
<a href="#" role="button" id="add_row" class="btn black mini"><i class="icon-plus-sign"></i> Add row</a>
</div>
</div>
<br />
<button type="submit" class="btn form_post" style="background-color: #09F; color:#fff;" value="xyz">Submit</button>
</form>
</div>
<div class="span7">

<table class="table table-striped table-bordered">
<tr>
<th style="text-align:center;">Sr #</th>
<th style="text-align:center;">Wing Name</th>
<th style="text-align:center;">Unit Number</th>
</tr>
<?php
$c=0;
foreach($cursor1 as $collection)
{
$c++;
$wing_id = (int)$collection['flat']['wing_id'];	
$flat_number = $collection['flat']['flat_name'];	

$result_prb = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_fetch'),array('pass'=>array($wing_id)));
foreach ($result_prb as $collection) 
{
$wing_name = $collection['wing']['wing_name'];	
}

?>
<tr>
<td style="text-align:center;"><?php echo $c; ?></td>
<td style="text-align:center;"><?php echo $wing_name; ?></td>
<td style="text-align:center;"><?php echo $flat_number; ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>    
</div>
</div>
</div>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
<?php
/*
if(@$ok==2)
{
echo '<div class="alert alert-success">'.$sucess.'</div>';
}
if(@$ok==1)
{

echo '<div class="alert alert-error">';
echo "<h4>Error :</h4></br>";
foreach($error_msg as $er_msg)
{
echo '<p>'.$er_msg.'</p>';
}
echo '</div>';
}
?>
<div class="portlet box green">
<div class="portlet-title">
<h4><i class="icon-cogs"></i>Flat Number Import</h4>
</div>
<div class="portlet-body">
<form  id="contact-form" name="myform" enctype="multipart/form-data" class="form-horizontal" method="post" >	
<div class="control-group">
<label class="control-label">Attach csv file</label>
<div class="controls">
<input type="file" name="file" class="default">
<input type="submit" name="sub1" class="btn blue" value="Import" >
</div>
</div>
</form>	
<strong><a href="/housingmatters/csv_file/demo/flat_import.csv" download="">Click here for sample format</a></strong>
<br>
<h4>Instruction set to import users</h4>
<ol>
<li>All the field are compulsory.</li>
<li>The field flat fype format is : (1 BHK)</li>
<li>Flat area shouls be in square feet</li>
</ol>
</div>
</div>
*/ ?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function(){
$("#add_row").bind('click',function(){
var count = $("#url_main div").length;
count++;
$("#url_main").append('<div class="content_'+count+'"><input type="text" class="m-wrap span7" maxlength="10" id="nu"><a href="#" role="button" id='+count+' class="btn black mini delete"><i class="icon-remove-sign"></i></a></div>');
});
$(".delete").live('click',function(){
var id = $(this).attr("id");
$('.content_'+id).remove();
});
});
</script> 
 
 
<script>
$(document).ready(function() { 
	$('form#form2').submit( function(ev){
	ev.preventDefault();
	$("#submit").addClass("disabled").text("submiting...");
		var count = $("#url_main div").length;
		var wing = $("#tp").val();
		var ar = [];
			for(var i=1;i<=count;i++)
			{
			var s=$("#url_main div:nth-child("+i+") input").val();
			ar.push([s]);
			}
			var myJsonString = JSON.stringify(ar);
			var wi = JSON.stringify(wing);
			
			$.ajax({
			url: "flat_type_validation?q="+myJsonString+"&b="+wi,
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
				$("#succ").html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>Record Inserted Successfully</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Hms/flat_type" rel="tab">OK</a></p></div>');
			}
				
				$("#error_msg").html(output);
	});
	});
});
</script>
 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////// ?> 


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Flat Type</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b class="success_report"></b></h5>
</center>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Hms/flat_type" class="btn blue" rel='tab'>OK</a>
</div>
</div>
</div> 	



<div id="myModal3" class="modal hide fade in" style="display: none;">
<div class="modal-backdrop fade in"></div>
	<form id="form1" method="post">
	<div class="modal content_model">
	<input type="hidden" value="1" id="stype"/>
   
    <div class="modal-header">
			<h4 id="myModalLabel1">Import csv</h4>
		</div>
		<div class="modal-body">
			<input type="file" name="file" class="default">
			
			<strong><a href="<?php echo $this->webroot; ?>csv_file/demo/unit_import.csv" download>Click here for sample format</a></strong>
			<br/>
			<h4>Instruction set to import users</h4>
			<ol>
			<li>All the field are compulsory.</li>
			<li>Wing and Flat number be valid as per society setting.</li>
			<li>Flat number should be not same.</li>
			</ol>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn" id="import_close">Cancel</button>
			<button type="submit" class="btn blue import_btn">Import</button>
		</div>
		
	</div>
	</form>
</div>




<script>
$(document).ready(function(){

$(".delete").live('click',function(){
var id = $(this).attr("del");
$('#tr'+id).remove();
});


$("#import_btn").live('click',function(){
$("#myModal3").show();
});
	$("#import_close").live('click',function(){
		$("#myModal3").hide();
	});
	
	
	$(".form_post").bind('click', function(e){
		$(".form_post").removeClass("clicked");
		$(this).addClass("clicked");
	});
	
	$('form#form1').submit( function(ev){
		ev.preventDefault();
		$(".import_btn").text("Importing...");
		var sub=$("#stype").val();
		
		if(sub==1){
		
			var m_data = new FormData();
			m_data.append( 'file', $('input[name=file]')[0].files[0]);
			$.ajax({
				url: "import_flat_ajax",
				data: m_data,
				processData: false,
				contentType: false,
				type: 'POST',
			}).done(function(response) {
				$(".content_model").html(response);
		
				var count = $("#flats_main tr").length;
		        var ar = [];
		
		    for(var i=1;i<=count;i++)
		    {
			$("#url_main table tr:nth-child("+i+") span.report").remove();
			var w=$("#flats_main tr:nth-child("+i+") select").val();
			var f=$("#flats_main tr:nth-child("+i+") input").val();
			var sub="no";
			ar.push([w,f,sub]);
		    }
		var myJsonString = JSON.stringify(ar);
		myJsonString=encodeURIComponent(myJsonString);
		
		$.ajax({
			url: "save_import_flat?q="+myJsonString,
			type: 'POST',
			dataType:'json',
		}).done(function(response) {
			if(response.report_type=='error'){
				jQuery.each(response.report, function(i, val) {
					$("#flats_main tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<br><span class="report" style="color:red;">'+val.text+'</span>');
					$("#flats_main tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");
				});
			}
			
		});
				
				
				
				
			});
			
			
			
			
			
		
		}
		
		if(sub==2){
		var count = $("#flats_main tr").length;
		var ar = [];
		
		for(var i=1;i<=count;i++)
		{
			$("#flats_main tr:nth-child("+i+") span.report").remove();
			var w=$("#flats_main tr:nth-child("+i+") select").val();
			var f=$("#flats_main tr:nth-child("+i+") input").val();
			var sub="yes";
			ar.push([w,f,sub]);
		}
		var myJsonString = JSON.stringify(ar);
		myJsonString=encodeURIComponent(myJsonString);
		
		$.ajax({
			url: "save_import_flat?q="+myJsonString,
			type: 'POST',
			dataType:'json',
		}).done(function(response) {
			if(response.report_type=='error'){
				jQuery.each(response.report, function(i, val) {
					$("#flats_main tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');
					$("#flats_main tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");
				});
			}
			if(response.report_type=='already')
			{
			$("#ovrlp").html('<h5 style="color:red;"><b>'+response.text+'</b></h5>');	
			}
			if(response.report_type=='repeat')
			{
			$("#ovrlp").html('<h5 style="color:red;"><b>'+response.text+'</b></h5>');	
			}
			if(response.report_type=='done')
			{
			$("#myModal3").hide();
			$("#don").html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>Record Inserted Successfully</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Hms/flat_type" rel="tab">OK</a></p></div>');
			
			}
			
			
			
		});
		
		}
		
	});
	
	
	
	
});
</script>