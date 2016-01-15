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


<?php
foreach($result_society as $data){
	$society_name=@$data["society"]["society_name"];
	$society_reg_num=@$data["society"]["society_reg_num"];
	$society_address=@$data["society"]["society_address"];
	$society_email=@$data["society"]["society_email"];
	$society_phone=@$data["society"]["society_phone"];
}

$result_opening_balance= $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_opening_balance_via_user_id'),array('pass'=>array($s_user_id)));


?>
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
<style media="print">
 #result_statement a[href]:after { display:none; } 
 #result_statement{
	 width:98% !important;
 }
</style>
<?php
$multiple_flat=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_flat'), array('pass' => array($s_user_id)));

?>


<div align="center" class="hide_at_print">
	<table>
		<tr>
		<?php  if(sizeof($multiple_flat)>1){  ?>
		<td>
		<select class="m-wrap" data-placeholder="Choose a Category"  id="flat_select_box">
			<option value="" style="display:none;" >Select...</option>
			<?php $count=0; foreach($multiple_flat as $flat_data){ $count++;
				
				$flat_id = (int)$flat_data['user_flat']['flat_id'];
				
				$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat_info as $flat_info){
					$wing_id=$flat_info["flat"]["wing_id"];
				}
				
				$wing_flat=$this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
			?>
			<option value="<?php echo $flat_id; ?>" <?php if($count==1){ echo 'selected="selected"'; } ?> ><?php echo $wing_flat; ?></option>
			<?php } ?>
		</select>
		</td>
		<?php } ?>
		<td><input class="date-picker m-wrap medium" id="from" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo date("d-m-Y",strtotime($from)); ?>" type="text"></td>
		<td><input class="date-picker  m-wrap medium" id="to" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo date("d-m-Y",strtotime($to)); ?>" type="text"></td>
		<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
		</tr>
	</table>
</div>



<br/>
<div style="width:98%;margin:auto;overflow:auto;background-color:#FFF;padding:5px;display:none;border:solid 1px #ccc;" id="result_statement" >
	
</div>

<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var flat_id=$("#flat_select_box").val();
		var from=$("#from").val();
		var to=$("#to").val();
		$("#result_statement").show();
		$("#result_statement").html('<div align="center"><h4>Loading...</h4></div>').load('my_flat_bill_ajax/'+from+'/'+to+'/'+flat_id);
	});
});
</script>