<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu_as_per_role_privilage'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1;  ?>" /> 
<input type="hidden" id="cn" value="<?php echo $count;  ?>" /> 
<?php
$default_date = date('d-m-Y');
?>
		
<!--------------------------------- Start Supplimentry Bill Form --------------------->
<form method="post" id="contact-form">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Generate Supplimentry Bill</h4>
</div>
<div class="portlet-body form">
<div id="validdn"></div>
		<table class="table table-bordered">
            <tr style="background-color:#E8EAE8;">
		    <th style="width:14%;">Billing Date</th>
		    <th style="width:14%;">Payment Due Date</th>
            <th style="width:20%;">Bill Type</th>
            <th style="width:20%;">User<a class="btn mini green" style="float:right;" onclick="add_member()"><i class="icon-plus"></i></a></th>
			<th style="width:20%;">Income Head</th>
			<th style="width:12%;">Amount</th>
			</tr>
			
		<tr style="background-color:#E8F3FF;">
		<td>
		<input type="text" class="m-wrap span12 date-picker" 
		data-date-format="dd-mm-yyyy" placeholder="Bill Date" value="<?php echo $default_date; ?>" 
		style="background-color:white !important;" id="fromm"/>
		</td>
				
		<td>
		<input type="text" class="span12 m-wrap  m-ctrl-medium date-picker" 
		data-date-format="dd-mm-yyyy" placeholder="Due Date"  id="duee"
		style="color:red; border-color:red; background-color:white !important;">
		</td>
			
		
			<td>
			<select class="m-wrap span12 chosen" onchange="bill_type(this.value)" id="typp">
			<option value="" style="display:none;">Select</option>
			<option value="2">Residential</option>
			<option value="1">Non Residential</option>
			</select>
			</td>
			
				
			<td>
			<span id="nonres">
			<select class="chosen m-wrap medium" id="nonress">
			<option value="" style="display:none;">Select</option>
			<?php
			foreach ($cursor11 as $collection) 
			{
			$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
			$user_name = $collection['ledger_sub_account']['name'];
			?>
			<option value="<?php echo $auto_id; ?>"><?php echo $user_name; ?></option>
			<?php } ?>
			</select>
			
            </span> 
		<span id="forres" class="hide">	
		<?php $this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down')); ?> 
        
		<script>
		$(document).ready(function() { 
		$(".resident_drop_down").addClass("medium");
		});
		</script>
		
		</span>



			
			</td>
			<td>
			<select class="m-wrap chosen span12" id="incmm">
			<option value="" style="display:none;">Select</option>
			<?php  
			foreach ($cursor2 as $collection) 
			{
			$income_heads_id= (int)$collection['ledger_account']["auto_id"];
			$income_heads_name=$collection['ledger_account']["ledger_name"];
			?>
			<option value="<?php echo $income_heads_id; ?>"><?php echo $income_heads_name; ?></option>
			<?php } ?>
			<option value="43">Non Occupancy Charges</option>
			</select>	
			</td>
		
			<td>
			<input type="text" class="m-wrap span12" style="background-color:white !important;" id="amttt">
			</td>
						
			</tr>
			
			<tr style="background-color:#E8EAE8;">
			<th colspan="2">Company Name</th>
			<th colspan="4">Narration</th>
			</tr>
			
			<tr style="background-color:#E8F3FF;">
			<td colspan="2"><input type="text" class="m-wrap span12" 
			style="background-color:white !important;" id="com_name"></td>
			<td colspan="4"><input type="text" class="m-wrap span12" 
			style="background-color:white !important;" id="descc"></td>
		</table>
		
			<div class="form-actions">
			<button type="submit" class="btn green" value="Generate Bill" name="sub1" id="go5">Preview Bill</button>
			<a href="it_supplimentry_bill" class="btn">Reset</a>
			</div>  
</div>
</div>
</form>
<!------------------------------ End Supplimentry Bill Form ------------------------------------->			
		

<div id="party_acc_popup" class="modal fade in" style="display:none;">
<div class="modal-backdrop fade in"></div>
<form  class="form-horizontal">
<div class="modal" id="party_acc_head_body">
<div class="modal-header">
<h4 id="myModalLabel1">Add New Supplimentry User</h4>
</div>
<div class="modal-body" >
<div class="control-group">
<label class="control-label">Supplimentry User</label>
<div class="controls">
<input placeholder="Supplimentry User" id="supplimentry_userrr" class="m-wrap " type="text">
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn" onclick="hide_popup()">Close</button>
<button type="button" class="btn blue submit_btn">Add</button>
</div>
</div>
</form>
</div>


<script>
function bill_type(ttt)
{
		if(ttt == 2)
		{
		$("#nonres").hide();
        $("#forres").show();
	$("#com_name").attr("readonly","readonly");	
	 	}
       else
        { 
	$("#com_name").removeAttr("readonly","readonly");
	
	    $("#nonres").show();
        $("#forres").hide();
	    }	
}
</script>		
		
		
<script>
$(document).ready(function() { 
	$('form#contact-form').submit( function(ev){
		ev.preventDefault();
	     		var ar = [];
   
		var billing_date = $("#fromm").val();
		var due_date = $("#duee").val();
		var bill_type = $("#typp").val();
			if(bill_type == 2)
			{
		var user_id = $(".resident_drop_down").val();	
			}
	        else if(bill_type == 1)
			{
		var user_id = $("#nonress").val();	
		var company_name = $("#com_name").val();		
			}	
		var income_id = $("#incmm").val();
		var amount = $("#amttt").val();
		var desc = $("#descc").val();
				
		ar.push([billing_date,due_date,bill_type,user_id,income_id,amount,company_name,desc]);
		
		
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "supplimentry_bill_json?q="+myJsonString,
			dataType:'json',
			}).done(function(response){
				if(response.type == 'error'){
			  		
			$("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
			}
		    if(response.type == 'success'){
				
			window.location.href = response.text;
			  $("#shwd").show();
			  $(".swwtxx").html(response.text);
			}
});			
});
});

</script>			
<script>
function add_member() 
{
$("#add_memrr").show();
}
function hide_add_mem()
{
$("#add_memrr").hide();	
}

</script>		
		
		
<div id="add_memrr" class="hide">
<form method="post">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<label style="font-size:14px;">Member Name</label>
<div class="controls">
<input type="text" name="mem_name" class="m-wrap span8">
<span id="vall"></span>
</div>
</div>
<div class="modal-footer">
<a class="btn" onclick="hide_add_mem()">Cancel</a>
<button type="submit" name="add_non_member" class="btn red">Add</button>
</div>
</div>
</form>
</div> 		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		