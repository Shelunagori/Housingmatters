<?php
$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 
'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));


foreach($result_new_regular_bill as $data){
$bill_no=$data["bill_no"];
$bill_start_date=$data["bill_start_date"];
$due_date=$data["due_date"];
$due_for_payment=$data["due_for_payment"];
$due_date=$data["due_date"];
$last_bill_one_time_id=$data["one_time_id"];
$flat_id22 = (int)$data["flat_id"];
$result_new_cash_bank = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_receipt_info_via_flat_id'),array('pass'=>array($flat_id,$last_bill_one_time_id)));
$total_amount=0;
foreach($result_new_cash_bank as $data2){
$amount=$data2["new_cash_bank"]["amount"];
$total_amount+=$amount;
}
}
$bill_start_date = date('d-m-Y',(@$bill_start_date));
$due_date = date('d-m-Y',(@$due_date));
  		?> 
<?php
if(sizeof($result_new_regular_bill) > 0)
{
?>
<div id="billlshh">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
Detail of Regular Bill No. <b><?php echo $bill_no; ?></b>									
</div>
<div class="modal-body">

	<table class="table table-bordered">
	<tr><td>Billing Start Date :</td><td><?php echo $bill_start_date; ?></td></tr>
	<tr><td>Payment Due Date :</td><td><?php echo $due_date; ?></td></tr>
	<tr><td>Total Amount of Bill :</td><td><?php echo $due_for_payment; ?></td></tr>
	<tr><td>Payment Due Amount :</td><td><?php echo $due_for_payment-$total_amount; ?></td></tr>
	</table>

</div>
<div class="modal-footer">
<a class="btn red" onclick="hiddd()">OK</a>
</div>
</div>
</div> 
<?php } else { ?>


<div id="billlshh">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
No Rised any Bill
</div>
<div class="modal-footer">
<a class="btn red" onclick="hiddd()">OK</a>
</div>
</div>
</div> 	
	
<?php } ?>