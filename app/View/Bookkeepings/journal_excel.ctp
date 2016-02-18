<?php 

$filename=$society_name.'_Journal_'.$from.'_'.$to;
$filename = str_replace(' ', '_', $filename);
$filename = str_replace(' ', '-', $filename);

header ("Expires: 0");
header ("border: 1");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

?>
<div align="center"> 
<span style="font-size:16px;"><?php echo $society_name; ?><span>
<br/>
<span>Journal: <?php echo $from; ?> to <?php echo $to; ?> <span>
</div>

<table width="100%" border="1">
<thead>
<tr>
<th colspan="6" style="text-align:center;"><b>
<?php echo $society_name; ?> Journal: <?php echo $from; ?> to <?php echo $to; ?></b>
</th>
</tr>
<tr>
<th>Journal voucher Id </th>
<th>Transaction Date</th>
<th>Ledger A/c</th>
<th>Narration</th>
<th >Debit</th>
<th >Credit</th>
</tr>

</thead>
<tbody id="count_row">
<?php 
//pr($result_expense_tracker);
$total=0;$total_debit=0;$total_credit=0;
foreach($result_journal as $data){
	$journal_id=$data['journal']['journal_id'];
	$voucher_id=$data['journal']['voucher_id'];
	 $ledger_account_id=(int)$data['journal']['ledger_account_id'];
	$ledger_sub_account_id=(int)$data['journal']['ledger_sub_account_id'];
	$user_id=$data['journal']['user_id'];
	$transaction_date=$data['journal']['transaction_date'];
	$transaction_date=date('d-m-Y',$transaction_date);
	$current_date=$data['journal']['current_date'];
	$credit=$data['journal']['credit'];
	$debit=$data['journal']['debit'];
	$remark=$data['journal']['remark'];
	
	$result_ledger_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ledger_account_id)));
	$ledger_ac_name=$result_ledger_account[0]['ledger_account']['ledger_name'];
	
	
$user_detaillll = $this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'user_fetch'), array('pass' => array($user_id)));		
foreach($user_detaillll as $dataaaa){
$prepaired_by = $dataaaa['user']['user_name'];
}
	
	
	
	
	
	if($ledger_account_id == 34 ){
	$result_ledger_sub_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_subLedger_detail_via_flat_id'),array('pass'=>array($ledger_sub_account_id)));
	$flat_id=$result_ledger_sub_account[0]['ledger_sub_account']['flat_id'];	
	$ledger_ac_name=$result_ledger_sub_account[0]['ledger_sub_account']['name'];
		//wing_id via flat_id//
				$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat_info as $flat_info){
					$wing_id=$flat_info["flat"]["wing_id"];
				}
				
		$user_detail = $this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'fetch_user_info_via_flat_id'), array('pass' => array($wing_id,$flat_id)));		
		foreach($user_detail as $data){
		$ledger_ac_name = $data['user']['user_name'];
		}
		$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'), array('pass' => array($wing_id,$flat_id))); 
		
 }else{
	$user_name =null;
	$wing_flat=null;

 }
	if($ledger_account_id == 33){
		$result_ledger_sub_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($ledger_sub_account_id)));
		$led_sub_name=$result_ledger_sub_account[0]['ledger_sub_account']['name'];
		$bank_account=$result_ledger_sub_account[0]['ledger_sub_account']['bank_account'];
		$ledger_ac_name=$led_sub_name.'  '.$bank_account;
	}	
	if($ledger_account_id == 112)
	{
	$result_ledger_sub_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($ledger_sub_account_id)));
		$led_sub_name=$result_ledger_sub_account[0]['ledger_sub_account']['name'];
		//$bank_account=$result_ledger_sub_account[0]['ledger_sub_account']['bank_account'];
		$ledger_ac_name=$led_sub_name;	
		
	}
	
	if($ledger_account_id == 15)
	{
	$result_ledger_sub_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($ledger_sub_account_id)));
		$led_sub_name=$result_ledger_sub_account[0]['ledger_sub_account']['name'];
		//$bank_account=$result_ledger_sub_account[0]['ledger_sub_account']['bank_account'];
		$ledger_ac_name=$led_sub_name;	
		
	}
	if($ledger_account_id == 35)
	{
	$result_ledger_sub_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($ledger_sub_account_id)));
		$led_sub_name=$result_ledger_sub_account[0]['ledger_sub_account']['name'];
		//$bank_account=$result_ledger_sub_account[0]['ledger_sub_account']['bank_account'];
		$ledger_ac_name=$led_sub_name;	
		
	}
	
?>
<tr>
<td><?php echo $voucher_id; ?></td>
<td><?php echo $transaction_date; ?></td>
<td><?php echo $ledger_ac_name; ?> &nbsp;&nbsp; <?php  echo $wing_flat; ?></td>
<!--<td><?php echo $user_name;  ?> </td>-->
<td><?php echo $remark; ?></td>
<td style="text-align:right;"> <?php echo $debit; ?> <?php $total_debit+=$debit; ?> </td>
<td style="text-align:right;"> <?php echo $credit; ?> <?php $total_credit+=$credit; ?> </td>
</tr>
<?php } ?>

<tr>
<td colspan="4" style="text-align:right;"> <b> Total </b> </td>
<td style="text-align:right;" > <b><?php echo $total_credit; ?></b> </td>
<td class="" style="text-align:right;"> <b><?php echo $total_debit; ?></b> </td>
</tr>
</tbody>
</table>