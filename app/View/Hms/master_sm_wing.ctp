<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Setup
</div>
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li class="active" ><a href="<?php echo @$webroot_path; ?>Hms/master_sm_wing" rel='tab'> Wing</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/flat_type" rel='tab'>Unit Number</a></li>
<li ><a href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel='tab'>Unit Configuration</a></li>
<!--<li ><a href="<?php echo $webroot_path; ?>Hms/flat_nu_import" rel='tab'>Flat Number Import</a></li>-->
<li><a href="<?php echo $webroot_path; ?>Hms/society_details" rel='tab'>Society Details</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/society_settings" rel='tab'>Society Settings</a></li>
</ul>
<div class="tab-content" style="min-height:300px;">
<div class="tab-pane active" id="tab_1_1">
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">


<div class="row-fluid">
<div class="span5">
<form method="post" id="sucess">

<label >Wing Name <span style="font-size:12px; color:#999;">(Maximum 10 characters.)</span></label>
<div class="controls">
<input type="text" class="m-wrap span7" name="wing_name" maxlength="10" id="wing">
<button type="submit" class="btn form_post" style="background-color: #09F; color:#fff;" value="xyz">Add Wing</button>
<label report="win" class="remove_report"></label>

</div>
</form>
</div>
<div class="span7">



<table class="table table-striped table-bordered" id="sample_2" style="width:100%;">
<thead>
<tr>
<th>Sr No.</th>
<th>Wing-Name</th>
</tr>
</thead>
<tbody>

<?php
$q=0;
foreach ($user_wing as $collection) 
{
$q++;
$wing_name=$collection['wing']['wing_name'];
?>
<tr class="odd gradeX" >
<td><?php echo $q; ?></td>
<td><?php echo $wing_name; ?></td></tr>
<?php } ?>
</tbody>
</table>


</div>
</div>
</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>   
</div>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	

  <script>
$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
		var m_data = new FormData();
		m_data.append( 'wing', $('#wing').val());
					
		$(".form_post").addClass("disabled");
		$("#wait").show();
			
			$.ajax({
			url: "wing_json",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
			if(response.report_type=='error'){
					$(".remove_report").html('');
						jQuery.each(response.report, function(i, val) {
						$("label[report="+val.label+"]").html('<span style="color:red;">'+val.text+'</span>');
					});
				}
				if(response.report_type=='publish'){
               
				$("#sucess").show().html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>'+response.report+'</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Hms/master_sm_wing" rel="tab">OK</a></p></div>');	
				}
				if(response.report_type=='already_error'){
				$(".remove_report").html("<span style='color:red;'>"+response.text+"</span>");
			}
			$("html, body").animate({
			scrollTop:0
			},"slow");
			$(".form_post").removeClass("disabled");
			$("#wait").hide();
			});

	});
});
</script>	

