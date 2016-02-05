<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>


<?php foreach($result_import_record as $data_import){
	$step1=(int)@$data_import["import_ob_record"]["step1"];
	$step2=(int)@$data_import["import_ob_record"]["step2"];
	$step3=(int)@$data_import["import_ob_record"]["step3"];
	$step4=(int)@$data_import["import_ob_record"]["step4"];
	$step5=(int)@$data_import["import_ob_record"]["step5"];
	$date=@$data_import["import_ob_record"]["date"];
	$file_name=@$data_import["import_ob_record"]["file_name"];
}
$process_status= @$step1+@$step2+@$step3+@$step4+@$step5; ?>

<?php if(sizeof($result_import_record)==0){ ?>
<div class="portlet box green" style="width: 50%; margin: auto;">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Import Receipts</h4>
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

<script>
$('form#form1').submit( function(ev){
	ev.preventDefault();
	$("#submit_element").html("<img src='<?php echo $webroot_path; ?>as/loding.gif' /> Please Wait, Csv file is Uploading...");
	var m_data = new FormData();
	m_data.append( 'file', $('input[name=file]')[0].files[0]);
	$.ajax({
	url: "<?php echo $webroot_path; ?>Accounts/upload_opening_balance_csv_file",
	data: m_data,
	processData: false,
	contentType: false,
	type: 'POST',
	dataType: 'json'
	}).done(function(response){
		if(response=="UPLOADED"){
			change_page_automatically("<?php echo $webroot_path; ?>Accounts/opening_balance_import");
		}
	});
});

</script>

<script>
function change_page_automatically(pageurl){
	$.ajax({
		url: pageurl,
		}).done(function(response) {
		
		//$("#loading_ajax").html('');
		
		$(".page-content").html(response);
		$("html, body").animate({
			scrollTop:0
		},"slow");
		 $('#submit_success').hide();
		});
	
	window.history.pushState({path:pageurl},'',pageurl);
}
</script>
















