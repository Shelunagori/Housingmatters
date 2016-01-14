<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
<tr>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn " rel='tab'>Selection of Income Heads</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn" style="font-size:16px;" rel='tab'>Rate Card</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn" style="font-size:16px;" rel='tab'>Non Occupancy Charges</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_penalty" class="btn" style="font-size:16px;" rel='tab'>Penalty Option</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/neft_add" class="btn" style="font-size:16px;" rel='tab'>Add NEFT</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_setup" class="btn" style="font-size:16px;" rel='tab'>Remarks</a>
</td>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/other_charges" class="btn yellow" rel='tab'>Other Charges</a>
</td>
</tr>
</table>


<style>
label.control-label{
	color: purple;
font-weight: bold;
}
</style>
<?php

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch'),array('pass'=>array(7)));			
foreach($result1 as $collection)
{
$ac_name = $collection['ledger_account']['ledger_name'];
$ac_id = (int)$collection['ledger_account']['auto_id'];		
if($ac_id != 43 && $ac_id != 39 && $ac_id != 40)
{
$income_head_arr1[] = (int)$ac_id;	
}
}
foreach($cursor3 as $collection)
{
$income_head_selected_arr = @$collection['society']['income_head'];
}
if(!empty($income_head_selected_arr))
{
@$income_head_arr2 = array_diff($income_head_arr1,$income_head_selected_arr);
}
else
{
$income_head_arr2 = $income_head_arr1;	
}
foreach($income_head_arr2 as $data)
{
$income_arrr[] = $data;
}


?>
<!-- BEGIN VALIDATION STATES-->
<div class="portlet box purple">
<div class="portlet-title">
<h4><i class="icon-briefcase" style="font-size:16px;"></i> OTHER CHARGES</h4>
</div>
<div class="portlet-body form">
		
<form METHOD="POST" class="form-horizontal" id="contact-form">
		   <div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<label class="control-label">Select Income Head</label>
						<div class="controls">
							<select name="income_head"  id="income_head" class="m-wrap large chosen" data-placeholder="Choose a Category" tabindex="1">
								<option value="">
								<?php
					for($r=0; $r<sizeof($income_arrr); $r++)
					{ 
					$income_id = (int)$income_arrr[$r];
					
					$ledgerac = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_id)));			
					foreach($ledgerac as $collection2)
					{
					$ac_name = $collection2['ledger_account']['ledger_name'];
					$ac_id = (int)$collection2['ledger_account']['auto_id'];		
					}
									?>
								<option value="<?php echo $ac_id; ?>"><?php echo $ac_name; ?>
								<?php } ?>
							 </select>
							  <label id="income_head"></label>
						</div>
						
					</div>
					
					
					<div class="control-group">
						  <label class="control-label">Select Flats</label>
						  <div class="controls">
							<select name="flats[]" data-placeholder="Your Favorite Football Teams" id="flats" class="chosen m-wrap large" multiple="multiple" tabindex="6">
								<option value="">
								<?php foreach($flats_for_bill as $flat_id){ 
								
								//wing_id via flat_id//
								$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
								foreach($result_flat_info as $flat_info){
								$wing=$flat_info["flat"]["wing_id"];
								} 

				
								//user info via flat_id//
								$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing,$flat_id)));
								foreach($result_user_info as $user_info){
								$user_id=(int)$user_info["user"]["user_id"];
								$user_name=$user_info["user"]["user_name"];
								} 
								
								$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat_id))); 
								?>
								<option  value="<?php echo $flat_id; ?>"><?php echo $user_name.' '.$wing_flat; ?>
								<?php } ?>
							</select>
							 <label id="flats"></label>
						  </div>
					</div>
					
					
					
					
				</div>
				
				<div class="span6">
					<div class="control-group">
						  <label class="control-label">Enter Amount</label>
						  <div class="controls">
							 <input name="amount" class="span8 m-wrap" type="text" placeholder="Amount" id="amount" style="text-align:right;" maxlength="10">
							 <label id="amount"></label>
						  </div>
					</div>
					
					
					
					<div class="control-group">
					<label class="control-label">Charge Type</label>
					<div class="controls">
					
					<select name="charge_type" class="span8 m-wrap chosen" id="type">
					<option value="" style="display:none;">Select</option>
					<option value="1">One Time/Lumpsum</option>
					<option value="2">Periodic</option>
					
					</select>
					<label id="type"></label>
					
					</div>
					</div>
					
				</div>
		   </div>
			<div class="row-fluid">
				<div class="span7">
					<!--<div class="control-group">
						  <label class="control-label">Select Flats</label>
						  <div class="controls">
							<select name="flats[]" data-placeholder="Your Favorite Football Teams" id="flats" class="chosen m-wrap large" multiple="multiple" tabindex="6">
								<option value="">
								<?php foreach($flats_for_bill as $flat_id){ 
								
								//wing_id via flat_id//
								$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
								foreach($result_flat_info as $flat_info){
								$wing=$flat_info["flat"]["wing_id"];
								} 

				
								//user info via flat_id//
								$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing,$flat_id)));
								foreach($result_user_info as $user_info){
								$user_id=(int)$user_info["user"]["user_id"];
								$user_name=$user_info["user"]["user_name"];
								} 
								
								$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat_id))); 
								?>
								<option  value="<?php echo $flat_id; ?>"><?php echo $user_name.' '.$wing_flat; ?>
								<?php } ?>
							</select>
							 <label id="flats"></label>
						  </div>
					</div>-->
				</div>
				<div class="span5"><button type="submit" name="add_charges" class="btn purple"><i class=" icon-plus-sign"></i> Add charge for selected flats</button></div>
			</div>
			
			
			<hr>
			
			<table class="table table-striped table-bordered table-advance">
				<tbody>
				<?php  $sr_no=0; foreach($flats_for_bill as $flat){ $sr_no++;
				
				
								//wing_id via flat_id//
								$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat)));
								foreach($result_flat_info as $flat_info){
								$wing=$flat_info["flat"]["wing_id"];
								} 

				
								//user info via flat_id//
								$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing,$flat)));
								foreach($result_user_info as $user_info){
								$user_id=(int)$user_info["user"]["user_id"];
								$user_name=$user_info["user"]["user_name"];
								} 
									
					if(!empty($flat)){
						$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat))); 
						
						$result_other_charges = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_other_charges_via_flat_id'),array('pass'=>array($flat))); 
						if(sizeof($result_other_charges)>0){
						?>
						<tr>
							<td><b><?php echo $user_name.' '.$wing_flat; ?></b></td>
							<td>
							<span style="float:right;" class="" data-placement="left" data-original-title="delete all charge">
							<a href="#" role="button" idd="<?php echo $flat ; ?>" class="btn black mini other_charges_delete">Delete All</a>
							</span>
							<?php 
							if(sizeof($result_other_charges)>0){
									echo '<div class="row-fluid">
											
										</div>';
										
								foreach($result_other_charges as $income_head_id=>$amount){ 
								 
								 $amount2 = $amount[0];
								 $type =  (int)$amount[1];
									$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_id)));	
									foreach($result_income_head as $data2){
										$income_head_name = $data2['ledger_account']['ledger_name'];
									} ?>
									<div class="row-fluid">
										<div class="span8"><?php echo $income_head_name; ?></div>
										<div class="span4"><?php echo $amount2; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php if($type ==1){ ?> One Time/Lumpsum <?php }else if($type ==2){ ?> Periodic <?php } ?>
										<span style="float:right;" class="tooltips" data-placement="left" data-original-title="delete current charge">
							<a href="#" role="button" idd="<?php echo $flat ; ?>" inch_id="<?php echo $income_head_id ; ?>" class="btn black mini other_charges_delete_oneby"><i class="icon-remove-sign"></i></a>
							</span>
										
										</div>
									</div>
								<?php } ?>
							<?php } ?>
							
								
							</td>
						</tr>
				<?php } } }?>
				</tbody>
			</table>
		
		
		</form>
		<!-- END FORM-->
		
		
		
		

		
		
	 </div>
	</div>
	
	<div id="delete_topic_result"></div>
	<!-- END VALIDATION STATES-->
<script>
$(document).ready(function(){
$('#contact-form').validate({
ignore: ".ignore",
			errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	   	

rules: {
  amount: {
	required: true,
	number: true
  },
   "flats[]": {
	required: true,
  },
   income_head: {
	required: true
  },
 
  charge_type:{
	required: true
  },

},

messages: {
			"multi[]": {
				required: "Please select at-least one recipient."
			},
			file: {
					accept: "File extension must be png or jpg",
					filesize: "File size must be less than 2MB."
				},
		},
	highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
	},
	success: function(element) {
		element
		.text('OK!').addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	},
	
});



$('.other_charges_delete').bind('click',function(){
	
	var id=$(this).attr('idd');
  
	$('#delete_topic_result').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to delete all charges for this flat ? </div><div class="modal-footer"><a href="<?php echo $webroot_path; ?>Incometrackers/other_charges_all_remove?con='+id+'&con2=0" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');
	$("#can").live('click',function(){
	   $('#pp').hide();
	});
}); 

$('.other_charges_delete_oneby').bind('click',function(){
	var id=$(this).attr('idd');
    var inch_id=$(this).attr('inch_id');
	
	$('#delete_topic_result').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to delete this charge for flat ? </div><div class="modal-footer"><a href="<?php echo $webroot_path; ?>Incometrackers/other_charges_all_remove?con='+id+'&con2=1&con3='+inch_id+'" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');
	$("#can").live('click',function(){
	   $('#pp').hide();
	});
});

}); 
</script>