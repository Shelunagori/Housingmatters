<?php 
if($type == 1 && !empty($flat_id))
{

$result_new_regular_bill = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'fetch_last_bill_info_via_flat_id'),array('pass'=>array($flat_id)));
		
						
	
$flll_id =(int)$flat_id;	
?>
			
			
		
       <input type="text" name="amount1" class="m-wrap span9"  maxlength="10" 
	   style="text-align:right; background-color:#FFF !important;"
	   onkeyup="numeric_vali(this.value,<?php echo $ccc; ?>)" id="amttt<?php echo $ccc; ?>"/>
     
	 <button class="btn btn-danger" onclick="bill_detall(<?php echo $flat_id; ?>)">!</button>
       
      <?php		
//}
}



			else if($type == 2 && !empty($flat_id))
			{
			?>	
			
			<input type="text" name="amount2" class="m-wrap span12" maxlength="10" style="text-align:right; background-color:#FFF !important;" onkeyup="numeric_vali(this.value,<?php echo $ccc; ?>)" id="amttt<?php echo $ccc; ?>"/>  
			
			<?php	
			}
            else
			{
			?>	
			<input type="text" name="amount2" class="m-wrap span12" maxlength="10" style="text-align:right; background-color:#FFF !important;" onkeyup="numeric_vali(this.value,<?php echo $ccc; ?>)" id="amttt<?php echo $ccc; ?>"/>  	
			<?php	
			}
            ?> 

<?php
/*
if(sizeof(@$result_new_regular_bill)>0)
{
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
		
	$bill_start_date = date('d-m-Y',($bill_start_date));
		$due_date = date('d-m-Y',($due_date));
  		?>     
<div id="myModal<?php echo $flat_id22; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="false" style="display: block;">
      

	  <table class="table table-bordered">
      	<tr><td colspan="2"><h4>Detail of Regular Bill No. <b><?php echo $bill_no; ?></b><h4></td></tr>
       	<tr><td>Billing Start Date :</td><td><?php echo $bill_start_date; ?></td></tr>
       	<tr><td>Payment Due Date :</td><td><?php echo $due_date; ?></td></tr>
        <tr><td>Total Amount of Bill :</td><td><?php echo $due_for_payment; ?></td></tr>
        <tr><td>Payment Due Amount :</td><td><?php echo $due_for_payment-$total_amount; ?></td></tr>
        </table>
        <div class="modal-footer">
        <button data-dismiss="modal" class="btn green">OK</button>
        </div>
        </div>		
<?php		
} } */
?>