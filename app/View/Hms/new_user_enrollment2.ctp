<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<div id="report_success_pop">
<a href="#" class="btn purple" role="button" id="import">Import</a>
<div id="myModal3" class="modal hide fade in" style="display: none;">
<div class="modal-backdrop fade in"></div>
	<form id="form1" method="post">
	<div class="modal">
		<div class="modal-header">
			<h4 id="myModalLabel1">Import csv</h4>
		</div>
		<div class="modal-body">
			<input type="file" name="file" class="default"  id="image-file">
			  <label id="vali"></label>	
			<strong><a href="<?php echo $this->webroot; ?>csv_file/demo/user_enrollment_file.csv" download>Click here for sample format</a></strong>
			<br/>
			<h4>Instruction set to import users</h4>
			<ol>
			<li>All the field are compulsory.</li>
			<li>Wing and Flat name be valid as per society setting.</li>
			<li>Email ID should be correct as all the further communication will be send to this email id. No duplicate Email is allowed.</li>
			<li>Mobile number should be 10 digits. No Duplicate Mobile No is allowed.</li>
			<li>Owner,Committee,Residing should be only "Yes" or "No".</li>
			</ol>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn" id="close_div">Close</button>
			<button type="submit" class="btn blue import_btn">Import</button>
		</div>
	</div>
	</form>
</div>
<a href="email_mobile_update" class="btn purple" role="btn" id="import">Import Email and Mobile</a>
<div id="report_id"></div>								
<div id="report"></div>
<table class="table table-bordered" style="background-color:#FFC;">
<tr>
<th width="15%">Name</th>
<th width="10%">Wing</th>
<th width="10%">Unit #</th>
<th width="20%">Email</th>
<th width="15%">Mobile</th>
<th width="10%">Owner</th>
<th width="10%">Committee</th>
<th width="10%">Action</th>
</tr>
</table>
<form method="post" id="form2">
<div id="url_main">
<table class="table table-bordered" valign="middle" cellpadding="0" id="myTable" style="background-color:white;">
	<tr id="tr1">
		<td width="15%"><input type="text" class="span12 m-wrap textbox" name="name" id="name1" style="font-size:16px;  background-color: white !important;" placeholder="Name*" value=""></td>
		<td width="10%">
		<select class="span12 m-wrap wing" id="wing2" name="wing" inc_id="1">
		<option value="">-Wing-</option>
		<?php 
		foreach($result_wing as $data) { 
		$wing_id=$data["wing"]["wing_id"];
		$wing_name=$data["wing"]["wing_name"];
		?>
		<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
		<?php } ?>

		</select>
		</td>
		<td id="echo_flat1" width="10%">
		<select class="span12 m-wrap" id="flat1" name="flat" >
		<option value="">Unit</option>
		</select>
		</td>
		<td width="20%"><input type="text" class="span12 m-wrap textbox" name="email" id="email1" style="font-size:16px;  background-color: white !important;" placeholder="Email" value=""></td>
		<td width="15%"><input type="text" class="span12 m-wrap textbox" name="mobile" id="mobile1" style="font-size:16px;  background-color: white !important;" placeholder="Mobile" value="" maxlength="10"></td>
		<td width="10%">
		<div class="controls">
		<label class="radio"><input type="radio" class="owner" name="owner1"  value="1" inc_id="1">Yes</label>
		<label class="radio"><input type="radio" class="owner" name="owner1"  value="2" inc_id="1">No</label>
		</div>
		</td>
		<td width="10%">
		<div class="controls" id="committe1">
		<label class="radio"><input type="radio" name="committe1"  value="1">Yes</label>
		<label class="radio"><input type="radio" name="committe1"  value="2">No</label>
		</div>
		<div id="no1" style="display:none;">No</div>
		</td>
		<td width="10%">
		<!--<div class="controls" id="residing_div1">
		<label class="radio"><input type="radio" name="residing1"  value="1">Self Occupied</label>
		<label class="radio"><input type="radio" name="residing1"  value="2">Leased</label>
		</div>
		<div id="not1" style="display:none;">No</div>-->
		<div class="pull-right"><a href="#" role="button" class="btn mini black delete" id="1"><i class="icon-trash"></i> Delete</a></div>
		</td>
	</tr>

</table>

</div>
<a role="button" class="btn blue " id="add_row"><i class="icon-plus"></i> Add row</a>
<button type="submit" id="submit" class="btn blue">Submit</button>
</form>
</div>
<script>
$(document).ready(function(){

	 $("#add_row").bind('click',function(){
		var count = $("#myTable tr").length;
		count++;
		$("#url_main").append();
		$.get('user_enrollment_ajax_add_row?q='+count, function(data){
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
		$('#echo_flat'+i).html("Loading...").load('return_flat_via_wing_id?con2='+c+'&con1='+i);
	 });
	 
	 $("#import").bind('click',function(){
		$("#myModal3").show();
	 });
	 
	  $("#close_div").bind('click',function(){
		$("#myModal3").hide();
	 });
	 
	 $(".owner").live('click',function(){
		var j=$(this).attr('inc_id');
		var w=this.value;
		
		if(w==1){
		$('#committe'+j).show();
		$('#residing_div'+j).show();
		$('#no'+j).hide();
		$('#not'+j).hide();
		}
		if(w==2){
		$('#committe'+j).hide();
		$('#residing_div'+j).hide();
		$('#no'+j).show();
		$('#not'+j).show();
		}
	 });
	 
	 
	 
	$('form#form2').submit( function(ev){
		ev.preventDefault();
		var count = $("#myTable tr").length;
		var ar = [];
		for(var i=1;i<=count;i++)
		{
		$("#url_main table tr:nth-child("+i+") span.report").remove();
		$("#url_main table tr:nth-child("+i+") td").css("background-color", "#fff");
		
		var n=$("#url_main table tr:nth-child("+i+")  input[name=name]").val();
		var w=$("#url_main table tr:nth-child("+i+") td:nth-child(2) select").val();
		var f=$("#url_main table tr:nth-child("+i+") td:nth-child(3) select").val();
		var e=$("#url_main table tr:nth-child("+i+")  input[name=email]").val();
		var m=$("#url_main table tr:nth-child("+i+")  input[name=mobile]").val();

		var qw1='input:radio:checked';
		var o=$("#url_main table tr:nth-child("+i+") td:nth-child(6) "+qw1).val();
	
		var qw2='input:radio:checked';
		var c=$("#url_main table tr:nth-child("+i+") td:nth-child(7) "+qw2).val();
		
		var qw3='input:radio:checked';
		var r=$("#url_main table tr:nth-child("+i+") td:nth-child(8) "+qw3).val();
		var sub="yes";
		ar.push([n,w,f,e,m,o,c,r,sub]);
		}
		var myJsonString = JSON.stringify(ar);
		myJsonString=encodeURIComponent(myJsonString);
		$.ajax({
			url: "check_email_already_exist?q="+myJsonString,
			type: 'POST',
			dataType:'json',
		}).done(function(response) {
			//alert(response);
			if(response.report_type=='error'){
				jQuery.each(response.report, function(i, val) {
					$("#url_main table tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');
					$("#url_main table tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");
				});
			}
			if(response.report_type=='already_error'){
				$("#report_id").html("<div class='alert alert-block alert-success fade in'><p>"+response.text+"</p></div>");
				setTimeout( function(){$('#report_id').html('');} , 5000);
				
			}
			if(response.report_type=='success'){
				$("#report_success_pop").html("<div class='alert alert-block alert-success fade in'><h4 class='alert-heading'>Success!</h4><p>"+response.text+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Hms/society_member_view' rel='tab' role='button'>Ok</a></p></div>");
			}
		});
	});
	
	
	
	   $('form#form1').submit( function(ev){
		ev.preventDefault();
		
		im_name=$("#image-file").val();
		var insert = 1;
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
			url: "import_user_ajax",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			}).done(function(response) {
				$("#myModal3").hide();
				$("#url_main table").html(response);

		var count = $("#myTable tr").length;
		var ar = [];
		for(var i=1;i<=count;i++)
		{
			$("#url_main table tr:nth-child("+i+") span.report").remove();
			$("#url_main table tr:nth-child("+i+") td").css("background-color", "#fff");
			
		var n=$("#url_main table tr:nth-child("+i+")  input[name=name]").val();
		var w=$("#url_main table tr:nth-child("+i+") td:nth-child(2) select").val();
		var f=$("#url_main table tr:nth-child("+i+") td:nth-child(3) select").val();
		var e=$("#url_main table tr:nth-child("+i+")  input[name=email]").val();
		var m=$("#url_main table tr:nth-child("+i+")  input[name=mobile]").val();
		
		
		
		
		var qw1='input:radio:checked';
		var o=$("#url_main table tr:nth-child("+i+") td:nth-child(6) "+qw1).val();
	
		var qw2='input:radio:checked';
		var c=$("#url_main table tr:nth-child("+i+") td:nth-child(7) "+qw2).val();
		
		var qw3='input:radio:checked';
		var r=$("#url_main table tr:nth-child("+i+") td:nth-child(8) "+qw3).val();
		var sub="no";
		ar.push([n,w,f,e,m,o,c,r,sub]);
		}
		var myJsonString = JSON.stringify(ar);
		myJsonString=encodeURIComponent(myJsonString);
		$.ajax({
			url: "check_email_already_exist?q="+myJsonString,
			type: 'POST',
			dataType:'json',
		}).done(function(response) {
			
			if(response.report_type=='error'){
				jQuery.each(response.report, function(i, val) {
					$("#url_main table tr:nth-child("+val.tr+") td:nth-child("+val.td+")").append('<span class="report" style="color:red;">'+val.text+'</span>');
					$("#url_main table tr:nth-child("+val.tr+") td:nth-child("+val.td+")").css("background-color", "#f2dede");
				});
			}
			if(response.report_type=='already_error'){
				$("#report_id").html("<div class='alert alert-block alert-success fade in'><p>"+response.text+"</p></div>");
				setTimeout( function(){$('#report_id').html('');} , 5000);
			}
			$(".import_btn").text("Import");
		});
		
	});
	});
});

</script>