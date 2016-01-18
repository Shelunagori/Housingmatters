<div id="first_div">
<?php if(sizeof($result_import_record)==0){ ?>
<div class="portlet box green" style="width: 50%; margin: auto;" id="myModal4">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Import Email and Mobile </h4>
	</div>
	
	<div class="portlet-body" align="">
		<form method="post" id="form1" style="margin: 0px;">
			<h5>Upload CSV file in given format to import email and mobile update.</h5>
			<input name="file" class="default" id="image-file1" type="file">
			<label id="vali1"></label>
			<strong><a href="<?php echo $this->webroot; ?>hms/email_mobile_import_file" download>Click here for sample format</a></strong><br/><br/>
			
			<h4>Instruction set to import users</h4>
			<ol>
			<li>Email ID should be correct as all the further communication will be send to this email id. No duplicate Email is allowed.</li>
			<li>Mobile number should be 10 digits. No Duplicate Mobile No is allowed.</li>
			</ol>
			<span  id="submit_element">
			<button type="submit" class="btn blue">IMPORT </button>
			</span>
			
		</form>
	</div>
</div>
<?php } ?>

<?php if(@$process_status==1){ ?>
	<div style="width: 40%; margin: auto; background-color: rgb(210, 243, 196); border: 2px solid rgb(113, 177, 85); padding: 10px;">
		<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
		<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">File Uploaded Succesfully.</span>
		<br/><span style="padding-left: 35px; color: rgb(114, 113, 113);"><b>Uploaded on:</b> </span><span style="color: rgb(114, 113, 113);"> <?php echo $date; ?></span>
		<br/><br/>
		<img src="<?php echo $webroot_path; ?>as/loding.gif" /> 
		<span style="padding-left: 10px; font-weight: bold; color: red;">Do Not Close Window, Reading CSV file...</span>
	</div>
	<script>
	$( document ).ready(function() {
		$.ajax({
			url: "read_user_info_csv_file",
			dataType: 'json'
		}).done(function(response){
			
			if(response=="READ"){
				change_page_automatically("<?php echo $webroot_path; ?>Hms/email_mobile_update");
			}
		});
	});
	</script>
	<?php } ?>
	
	
	
<?php if(@$process_status==2){ ?>
<div style="width: 40%; margin: auto; background-color: rgb(210, 243, 196); border: 2px solid rgb(113, 177, 85); padding: 10px;">
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">File Uploaded Succesfully.</span>
	<br/><span style="padding-left: 35px; color: rgb(114, 113, 113);"><b>Uploaded on:</b> </span><span style="color: rgb(114, 113, 113);"> <?php echo $date; ?></span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">To Read Uploaded File Succesfully Done.</span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>as/loding.gif" /> 
	<span style="padding-left: 10px; font-weight: bold; color: red;">Preparing Data For More Modifications.</span>
	<div class="progress progress-striped progress-danger active">
		<div id="progress" style="width: <?php echo @$converted_per; ?>%;" class="bar"></div>
	</div>
</div>
<script>
$( document ).ready(function() {
	convert_csv_data_ajax();
});
function convert_csv_data_ajax(){
	$( document ).ready(function() {
		$.ajax({
			url: "convert_user_info_data",
			dataType: 'json'
		}).done(function(response){
			if(response.again_call_ajax=="YES"){
				$("#progress").css("width",response.converted_per+"%");
				convert_csv_data_ajax();
			}
			if(response.again_call_ajax=="NO"){
				change_page_automatically("<?php echo $webroot_path; ?>Hms/email_mobile_update");
			}
		});
	});
}
</script>
<?php } ?>

<?php if(@$process_status==3){ ?>
<div style="width: 40%; margin: auto; background-color: rgb(210, 243, 196); border: 2px solid rgb(113, 177, 85); padding: 10px;">
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">File Uploaded Succesfully.</span>
	<br/><span style="padding-left: 35px; color: rgb(114, 113, 113);"><b>Uploaded on:</b> </span><span style="color: rgb(114, 113, 113);"> <?php echo $date; ?></span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">To Read Uploaded File Succesfully Done.</span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">Uploaded Data Is Ready To More Modification.</span>
	<br/><br/>
	<a href="<?php echo $webroot_path; ?>Hms/modify_user_info_csv_data" class="btn red"  id="pulsate-regular">MODIFY DATA</a>
</div>
<?php } ?>

<?php if(@$process_status==4){ ?>
<div style="width: 40%; margin: auto; background-color: rgb(210, 243, 196); border: 2px solid rgb(113, 177, 85); padding: 10px;">
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">File Uploaded Succesfully.</span>
	<br/><span style="padding-left: 35px; color: rgb(114, 113, 113);"><b>Uploaded on:</b> </span><span style="color: rgb(114, 113, 113);"> <?php echo $date; ?></span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">To Read Uploaded File Succesfully Done.</span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">Uploaded Data Is Ready To More Modification.</span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>img/test-pass-icon.png" style="height: 20px;"/>
	<span style="padding-left: 10px; font-weight: bold; color: rgb(0, 106, 0);">Data Validation Process Completed.</span>
	<br/><br/>
	<img src="<?php echo $webroot_path; ?>as/loding.gif" /> 
	<span style="padding-left: 10px; font-weight: bold; color: red;">Updating Information Into The System.</span>
	<div class="progress progress-striped progress-danger active">
		<div id="progress_im" style="width: <?php echo @$converted_per_im; ?>%;" class="bar"></div>
	</div>
	<span style="padding-left: 35px; color: rgb(114, 113, 113);"><b id="text_per_im"></b> Information Updated.</span>
</div>
<script>
$( document ).ready(function() {
	final_import_user_info_ajax();
});
function final_import_user_info_ajax(){
	$( document ).ready(function() {
		$.ajax({
			url: "final_import_user_info_ajax",
			dataType: 'json'
		}).done(function(response){
			if(response.again_call_ajax=="YES"){
				$("#progress_im").css("width",response.converted_per_im+"%");
				$("#text_per_im").html(response.converted_per_im.toFixed(2)+"%");
				final_import_user_info_ajax();
			}
			if(response.again_call_ajax=="NO"){
				$("#first_div").html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>Receipts Imported successfully.</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Hms/email_mobile_update" >OK</a> </p></div>');
			}
		});
	});
}
</script>
<?php } ?>
</div>
<script>
$('form#form1').submit( function(ev){
	ev.preventDefault();
	$("#submit_element").html("<img src='<?php echo $webroot_path; ?>as/loding.gif' /> Please Wait, Csv file is Uploading...");
	var m_data = new FormData();
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	$.ajax({
	url: "Upload_user_info_csv_file",
	data: m_data,
	processData: false,
	contentType: false,
	type: 'POST',
	dataType: 'json'
	}).done(function(response){
		if(response=="UPLOADED"){
			change_page_automatically("<?php echo $webroot_path; ?>Hms/email_mobile_update");
		}
	});
});

function change_page_automatically(pageurl){
	$.ajax({
		url: pageurl,
		}).done(function(response) {
		
		$(".page-content").html(response);
		$("html, body").animate({
			scrollTop:0
		},"slow");
		 $('#submit_success').hide();
		});
	
	window.history.pushState({path:pageurl},'',pageurl);
}
</script>