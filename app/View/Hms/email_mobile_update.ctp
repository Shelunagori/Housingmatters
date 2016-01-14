<div class="portlet box green" style="width: 50%; margin: auto;" id="myModal4">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Import Email and Mobile </h4>
	</div>
	<div class="portlet-body" align="">
		<form method="post" id="form_email" style="margin: 0px;">
			<h5>Upload CSV file in given format to import email and mobile update.</h5>
			<input name="file1" class="default" id="image-file1" type="file">
			<label id="vali1"></label>
			<strong><a href="<?php echo $this->webroot; ?>Hms/sample_csv_file_for_update_user_info" download>Click here for sample format</a></strong><br/><br/>
			<h5 id="submit_element" >
			<h4>Instruction set to import users</h4>
			<ol>
			<li>Email ID should be correct as all the further communication will be send to this email id. No duplicate Email is allowed.</li>
			<li>Mobile number should be 10 digits. No Duplicate Mobile No is allowed.</li>
			</ol>
			<button type="submit" class="btn blue">IMPORT </button>
			</h5>
		</form>
	</div>
</div>

<div id="url_main_new">

</div>

<script>
$(document).ready(function(){
	
	$('#submit').live("click",function(ev){
		ev.preventDefault();	
		var count = $("#url_main tr").length;
		alert(count);
		var ar = [];
		for(var i=1;i<=count;i++){
			$("#url_main tr:nth-child("+i+") span.report").remove();
			$("#url_main  tr:nth-child("+i+") td").css("background-color", "#fff");
			
			var n=$("#url_main  tr:nth-child("+i+")  select").val();
			var e=$("#url_main  tr:nth-child("+i+")  input[name=email]").val();
			var m=$("#url_main  tr:nth-child("+i+")  input[name=mobile]").val();
			ar.push([n,e,m]);
		}
		
		var myJsonString = JSON.stringify(ar);
		myJsonString=encodeURIComponent(myJsonString);
		$.ajax({
		url: "email_mobile_update_ajax?q="+myJsonString,
		type: 'POST',
		//dataType:'json',
		}).done(function(response) {
			
			alert(response);
			
		});	
		
	});	
	
 $('form#form_email').submit( function(ev){
		ev.preventDefault();
			
		im_name=$("#image-file1").val();
		var insert = 1;
		if(im_name==""){
			$("#vali1").html("<span style='color:red;'>Please Select a Csv File</span>");	
			return false;
		}
		
		var ext = $('#image-file1').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['csv']) == -1) {
			$("#vali1").html("<span style='color:red;'>Please Select a Csv File</span>");
			return false;
		}
		$(".import_btn").text("Importing...");
		var m_data = new FormData();
		m_data.append( 'file1', $('input[name=file1]')[0].files[0]);
		$.ajax({
			url: "import_email_mobile_update",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			}).done(function(response) {
				alert(response);
				$("#myModal4").hide();
				$("#url_main_new").html(response);
				
				
			});	
	
	});
});
	</script>