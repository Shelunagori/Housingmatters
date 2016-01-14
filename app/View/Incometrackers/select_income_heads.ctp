<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
<tr>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn yellow" rel='tab'>Selection of Income Heads</a>
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
<td><a href="<?php echo $webroot_path; ?>Incometrackers/other_charges" class="btn" rel='tab'>Other Charges</a>
</td>
</tr>
</table> 
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
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
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
    <div style=" border:solid 1px #CCC;  background:#FFF; width:100%; height:650px; overflow:hidden;">
            <h4 style="color: #03C;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;">&nbsp;&nbsp;&nbsp;<i class="icon-money"></i>  Select Income Heads for Bill Charges</h4>
           
           
          <div style="width:40%;  float:left; overflow:visible;">        
            <form method="post" id="contact-form">
            <br />
            <label style="font-size:14px;"> &nbsp;&nbsp;&nbsp; Select Income Heads<span style="color:red;">*</span></label>
            <div class="controls">
            	&nbsp;&nbsp;&nbsp;	<select data-placeholder="Select Account Heads"  name="i_head[]" id="i_head" class="m-wrap span10 chosen" multiple="multiple" tabindex="6">	
           			 <option value="" style="display:none;">Select</option>
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
					<option value="<?php echo $income_id; ?>"><?php echo $ac_name; ?></option>
					<?php } ?>
					</select>
					<label report="head" class="remove_report"></label>
</div>
<br />        
 &nbsp;&nbsp;&nbsp; <a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn" rel='tab'>Cancel</a>
<button type="submit" class="btn green form_post" name="sub" submit_type="sub">Submit</button>
<br />
</form>
</div>

<div style="width:55%; float:right; overflow:hidden;">
<table class="table table-bordered table-stripped" style="width:100%; overflow:Y-scroll;">
<tr>
<th>Sr #</th>
<th>Account Name</th>
</tr>
<?php 
$m=0;
foreach($cursor3 as $collection)
{
$income_head_arr = @$collection['society']['income_head'];
}
$m=0;
for($i=0; $i<sizeof(@$income_head_arr); $i++)
{
$m++;
$income_head_id = (int)$income_head_arr[$i];	
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_id)));	
foreach($result1 as $collection)
{
$income_head_name = $collection['ledger_account']['ledger_name'];	
}
?>
<tr>
<td><?php echo $m; ?></td>
<td><?php echo $income_head_name; ?>
<input type="hidden" id="delinc" value="<?php echo $income_head_id; ?>" />
</td>
<td>
<a onclick="delt(<?php echo $income_head_id; ?>)" class="btn mini black">Delete</a>
</td>
</tr>
<?php } ?>
</table>
</div>


</div>
<br />
<br />
<!--jfdhjskf-->


  <script>
$(document).ready(function() { 
		$(".form_post").bind('click', function(e){
		$(".form_post").removeClass("clicked");
		$(this).addClass("clicked");
		});

	$('form').submit( function(ev){
	ev.preventDefault();
			if( $(this).find(".clicked").attr("submit_type") === "sub" ){
			var post_type=1;
			}
			if( $(this).find(".clicked").attr("submit_type") === "del" ){
			var post_type=2;
			}
			if( $(this).find(".clicked").attr("submit_type") === "delete" ){
			var post_type=3;
			}
		var delid = $("#delinc").val();	
		var abc = $("#i_head").val();
		var m_data = new FormData();
		m_data.append( 'head',abc);
		m_data.append( 'type',post_type);
			
		$(".form_post").addClass("disabled");
		$("#wait").show();
			
			$.ajax({
			url: "select_income_head_json",
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
                $("#shwd").show()
				$(".success_report").show().html(response.report);	
				}
				if(response.report_type=='delt'){
                $("#shwd2").show()
				$(".success_report2").show().html(response.report);	
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
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
The Income Heads Added Successfully
</div>
<div class="modal-footer">
<a class="btn red" href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" rel="tab">OK</a>
</div>
</div>
</div> 
<div id="delete_topic_result"></div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
function delt(y)
{
$('#delete_topic_result').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to delete this income head ? </div><div class="modal-footer"><a href="<?php echo $webroot_path; ?>incometrackers/delete_select_income?con='+y+'" class="btn blue" id="yes">Yes</a><a href="<?php echo $webroot_path; ?>incometrackers/select_income_heads" id="can" class="btn" rel="tab">No</a></div></div></div>');

}
</script>