<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>


<div style='float:right;  margin-right: 2px;'><a href="csv_import_signup" role='button' class='btn ' rel='tab'>Import User </a></div>

<div style='float:right;  margin-right: 2px;'><a href="new_user_enrollment" role='button' class='btn yellow' rel='tab'>Manuly Enrollment </a></div>
<form method="post" id="contact-form">
<input type="hidden" name="hidden" id="hidden" value="1">
<div id="error_msg" class='span6'></div>
<table class="table table-bordered table-hover" valign="middle" cellpadding="0" id="myTable" style="background-color:white;">
<thead>
	<tr>
		<th >Name</th>
		<th width="10%">Wing</th>
		<th width="10%">Flat</th>
		<th>Email</th>
		<th >Mobile</th>
		<th width="10%">Owner</th>
		<th width="10%">Committee</th>
		<th width="10%">NOC Type</th>
	</tr>
</thead>
<tbody>

<tr id="tr1">
<td><input type="text" class="span12 m-wrap textbox" name="name1" id="name1" style="font-size:16px;  background-color: white !important;" placeholder="Name*" value=""></td>
<td>
<select class="span12 m-wrap wing" id="wing1" name="wing1" inc_id="1">
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
<td id="echo_flat1">
<select class="span12 m-wrap" id="flat1" name="flat1">
<option value="">Flat</option>
</select>
</td>
<td><input type="text" class="span12 m-wrap textbox" name="email1" id="email1" style="font-size:16px;  background-color: white !important;" placeholder="Email" value=""></td>
<td><input type="text" class="span12 m-wrap textbox" name="mobile1" id="mobile1" style="font-size:16px;  background-color: white !important;" placeholder="Mobile" value=""></td>
<td>
<div class="controls">
<label class="radio"><input type="radio" class="owner" name="owner1"  value="1" inc_id="1">Yes</label>
<label class="radio"><input type="radio" class="owner" name="owner1"  value="2" inc_id="1">No</label>
</div>
</td>
<td>
<div class="controls" id="committe1">
<label class="radio"><input type="radio" name="committe1"  value="1">Yes</label>
<label class="radio"><input type="radio" name="committe1"  value="2">No</label>
</div>
<div id="no1" style="display:none;">No</div>
</td>
<td>
<div class="controls">
<label class="radio"><input type="radio" name="residing1"  value="1">Self Occupied</label>
<label class="radio"><input type="radio" name="residing1"  value="2">Leased</label>
</div>
</td>
</tr>




</tbody>
</table>
<a role="button" class="btn blue " id="add_row"><i class="icon-plus"></i> Add row</a>
<a role="button" class="btn red " id="remove_row"><i class=" icon-remove-sign"></i> Remove last row</a>

<div align="center">
<button type="submit" id="submit" class="btn blue">Submit</button>
</div>
</form>
<script>
$(document).ready(function() { 
	 $("#add_row").bind('click',function(){
		var h=$('#hidden').val();
		h++;
		$('#hidden').val(h);
		var content;
		$.get('user_enrollment_ajax_add_row?q='+h, function(data){
			content= data;
			$('#myTable').append(content);
		});
	 });
	 
	 $("#remove_row").bind('click',function(){
		var h=$('#hidden').val();
		if(h>1){
			$("#tr"+h).remove();
			h--;
			$('#hidden').val(h);
		}
		
	 });
	 
	 
	 
	 $(".wing").live('change',function(){
		var c=this.value;
		var i=$(this).attr('inc_id');
		$('#echo_flat'+i).html("Loading...").load('return_flat_via_wing_id?con2='+c+'&con1='+i);
	 });
	 
	 $(".owner").live('click',function(){
		var j=$(this).attr('inc_id');
		var w=this.value;
		
		if(w==1){
		$('#committe'+j).show();
		$('#no'+j).hide();
		}
		if(w==2){
		$('#committe'+j).hide();
		$('#no'+j).show();
		}
	 });
	 
	 
	 
	
});


$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
		$("#submit").addClass("disabled").text("submiting...");
		var hidden=$("#hidden").val();
		var ar = [];
		for(var i=1;i<=hidden;i++)
		{
		var n=$("#name"+i).val();
		var w=$("#wing"+i).val();
		var f=$("#flat"+i).val();
		var e=$("#email"+i).val();
		var m=$("#mobile"+i).val();
		var qw1='input:radio[name=owner'+i+']:checked';
		var o=$(qw1).val();
		var qw2='input:radio[name=committe'+i+']:checked';
		var c=$(qw2).val();
		var qw3='input:radio[name=residing'+i+']:checked';
		var r=$(qw3).val();
		
		ar.push([n,w,f,e,m,o,c,r]);
		var myJsonString = JSON.stringify(ar);
		}
		
			$.ajax({
			url: "check_email_already_exist?q="+myJsonString,
			dataType:'json',
			}).done(function(response) {
			
				if(response.type == 'error'){  
					output = '<div class="alert alert-error">'+response.text+'</div>';
					$("#submit").removeClass("disabled").text("submit");
					$("html, body").animate({
					 scrollTop:0
					 },"slow");
				}else{
				    output = '<div class="alert alert-success">'+response.text+'</div>';
					$("form").html(output);
				}
				
				
				$("#error_msg").html(output);
			});

	 
	});
});

</script>

