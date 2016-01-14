<?php 
if($type == 1 && !empty($flat_id)){
$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));
	  if(sizeof($result_new_regular_bill)== 0)
	  {
?>
<p style="color:red; font-size:15px; font-weight:400;">There are not found any Bill</p>
<label style="font-size:14px;">&nbsp;&nbsp;&nbsp;Amount Applied<span="color:red;">*</span></label>
<div class="controls">
&nbsp;&nbsp;<input type="text" name="amount4" id="amtttt" class="m-wrap span5" readonly="readonly"/>
<label id="amtttt"></label>
</div>
<br />
<?php	  
}
		foreach($result_new_regular_bill as $data){
			$bill_no=$data["bill_no"];
			$bill_start_date=$data["bill_start_date"];
			$due_date=$data["due_date"];
			$due_for_payment=$data["due_for_payment"];
			$due_date=$data["due_date"];
			$last_bill_one_time_id=$data["one_time_id"];
		
		$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat_id,$last_bill_one_time_id)));
			$total_amount=0;
			foreach($result_new_cash_bank as $data2){
			$amount=$data2["new_cash_bank"]["amount"];
			$total_amount+=$amount;
			}
			
			?>
			
			
		<label style="font-size:14px;">&nbsp;&nbsp;&nbsp;Amount Applied for Bill <b><?php echo $bill_no; ?></b><span style="color:red;">*</span></label>
        <div class="controls">
        &nbsp;&nbsp;<input type="text" name="amount1" class="m-wrap span5" id="amt_other" /><a href="#myModal2" role="button" class="btn btn-danger" data-toggle="modal">Bill Detail</a> 
        &nbsp;&nbsp;<label id="amt_other"></label>	
        </div>
        <br />

		<?php  
		$bill_start_date = date('d-m-Y',($bill_start_date));
		$due_date = date('d-m-Y',($due_date));
  		?>     
<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="false" style="display: block;">
       <table class="table">
      	<tr><th style="background-color:#3F9;" colspan="2">Detail of Regular Bill No. <b><?php echo $bill_no; ?></b></th></tr>
       	<tr><th>Billing Start Date :</th><td><?php echo $bill_start_date; ?></td></tr>
       	<tr><th>Payment Due Date :</th><td><?php echo $due_date; ?></td></tr>
        <tr><th>Total Amount of Bill :</th><td><?php echo $due_for_payment; ?></td></tr>
        <tr><th>Payment Due Amount :</th><td><?php echo $due_for_payment-$total_amount; ?></td></tr>
        </table>
        <div class="modal-footer">
        <button data-dismiss="modal" class="btn green">OK</button>
        </div>
        </div>
				
<?php		
}
}



			if($type == 2)
			{
			?>	
			<label style="font-size:14px;">&nbsp;&nbsp;&nbsp;Amount Applied<span style="color:red;">*</span></label>
			<div class="controls">
			&nbsp;&nbsp;<input type="text" name="amount2" class="m-wrap span5" id="amt_other2" />  
			&nbsp;&nbsp;<label id="amt_other2"></label>	
			</div>
			<br />	 
			<?php	
			}

?> 