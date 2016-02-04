<?php foreach($result_import_record as $data_import){
	$step1=(int)@$data_import["import_payment_record"]["step1"];
	$step2=(int)@$data_import["import_payment_record"]["step2"];
	$step3=(int)@$data_import["import_payment_record"]["step3"];
	$step4=(int)@$data_import["import_payment_record"]["step4"];
	$step5=(int)@$data_import["import_payment_record"]["step5"];
	$date=@$data_import["import_payment_record"]["date"];
	$file_name=@$data_import["import_payment_record"]["file_name"];
}
$process_status= @$step1+@$step2+@$step3+@$step4+@$step5; ?>

<?php if(sizeof($result_import_record)==0){ ?>
<div class="portlet box green" style="width: 50%; margin: auto;">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Import Payment</h4>
	</div>
	<div class="portlet-body" align="">
		<form method="post" id="form1" style="margin: 0px;">
			<h5>Upload CSV file in given format to import Receipts.</h5>
			<input name="file" class="default" id="image-file" type="file">
			<a href="<?php echo $webroot_path; ?>Bank_Receipt_csv_files/sample/Bank_Receipt_Import_Sample.csv" download=""><b>Click here for sample format</b></a><br/><br/>
			<h5 id="submit_element" >
			<button type="submit" class="btn blue">IMPORT RECEIPTS</button>
			</h5>
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
		url: "read_payment_csv_file",
		dataType: 'json'
	}).done(function(response){
		
		if(response=="READ"){
			change_page_automatically("<?php echo $webroot_path; ?>Cashbanks/import_bank_receipts_csv");
		}
	});
});
</script>
<?php } ?>
<script>
$('form#form1').submit( function(ev){
	ev.preventDefault();
	$("#submit_element").html("<img src='<?php echo $webroot_path; ?>as/loding.gif' /> Please Wait, Csv file is Uploading...");
	var m_data = new FormData();
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	$.ajax({
	url: "Upload_Bank_payment_csv_file",
	data: m_data,
	processData: false,
	contentType: false,
	type: 'POST',
	dataType: 'json'
	}).done(function(response){
		if(response=="UPLOADED"){
			change_page_automatically("<?php echo $webroot_path; ?>Cashbanks/import_bank_receipts_csv");
		}
	});
});

</script>