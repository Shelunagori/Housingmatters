<div class="hide_at_print">
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
</div>

<style>
#report_tb th{
	font-size: 14px !important;background-color:#C8EFCE;padding:5px;border:solid 1px #55965F;text-align: left;
}
#report_tb td{
	padding:5px;
	font-size: 15px;border:solid 1px #55965F;background-color:#FFF;
}
table#report_tb tr:hover td {
background-color: #E6ECE7;
}
</style>


<div style="text-align:center;" class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" class="btn" rel='tab'>Regular Bill Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_supplimentry" class="btn" rel='tab'>Supplementary Bill Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement" class="btn yellow" rel='tab'>Account Statement</a>
</div>

<div class="hide_at_print" align="center">
	<table>
		<tr>
			<td>
				<select class="m-wrap chosen" data-placeholder="Choose a Category" id="flat_select_box" tabindex="1">
					<option value="">Select...</option>
					<?php foreach($result_ledger_sub_account as $ledger_sub_account){
							$flat=$ledger_sub_account["ledger_sub_account"]["flat_id"];
							$ledger_sub_account_id=$ledger_sub_account["ledger_sub_account"]["auto_id"];
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
							$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat))); ?>
						<option value="<?php echo $ledger_sub_account_id; ?>"><?php echo $user_name.' ( '.$wing_flat.' )'; ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
<input class="date-picker m-wrap medium" id="from" data-date-format="dd-mm-yyyy" name="from" 
placeholder="From" style="background-color:white !important; margin-top:8px;" value="01-11-2015" type="text">
			</td>
			<td>
				<input class="date-picker  m-wrap medium" id="to" data-date-format="dd-mm-yyyy" 
				name="to" placeholder="To" style="background-color:white !important; margin-top:8px;" 
				value="30-11-2015" type="text">
			</td>
			<td valign="top"><button type="button" name="sub" class="btn yellow" id="go" style="margin-top:8px;">Go</button></td>
		</tr>
	</table>
</div>

	


<br/>
<div style="width:80%;margin:auto;overflow:auto;background-color:#FFF;padding:5px;display:none;border:solid 1px #ccc;" id="result_statement" >
	
</div>
<script>
$(document).ready(function() {
	$( "#go" ).click(function() {
		var ledger_sub_account_id=$("#flat_select_box").val();
		var from=$("#from").val();
		var to=$("#to").val();
		$("#result_statement").show();
		$("#result_statement").html('<div align="center"><h4>Loading...</h4></div>')
		.load('<?php echo $webroot_path; ?>Incometrackers/account_statement_for_flat_ajax/'+ledger_sub_account_id+'/'+from+'/'+to);
	});
});
</script>