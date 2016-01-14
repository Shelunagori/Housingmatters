<!--<div style="float:left;">
<a href="<?php echo $webroot_path; ?>Bookkeepings/journal_view" rel="tab" class="btn  green hide_at_print"><i class="icon-caret-left"></i> Back</a>
</div> -->
<div align="right" class="hide_at_print">
<a  class="btn green mini" onclick="window.print()" ><i class="icon-print"></i>  </a>
</div>
<br/>
<div style="background-color:#fff; border:solid 1px;" class="print_margin" >
<div class="bg_co" align="center" style="background-color: rgb(0, 141, 210);padding: 5px;font-size: 16px;font-weight: bold;color: #fff;"> <?php echo $society_name; ?> </div>

<div align="center" style="padding: 2px;">
<span style="font-size:14px;"> <b> Journal Voucher </b> </span>
</div>


<div align="" style="padding: 10px;">
<span style="font-size:14px; float:left;"> <b> Journal Voucher # : </b> <?php echo $voc_id; ?>  </span>

<span style="font-size:14px; float:right;"> <b> Date :</b>
 <?php $transaction_date=$result_journal[0]['journal']['transaction_date'];
$transaction_date=date('d-m-Y',$transaction_date);
echo $transaction_date; ?> </span>

</div>
<br/>
<div align="" style="padding: 5px;">
<table cellpadding="5" width="100%;" border="1">
<tr>
<td><span style="font-size:14px;"><b> Ledger A/c  </b></span></td>
<td align="right"> <span style="font-size:14px;"><b> Debit  </b></span></td>
<td align="right"> <span style="font-size:14px;"><b> Credit  </b></span></td>
</tr>

<?php //pr($result_journal);
$total_credit=0; $total_debit=0;
foreach($result_journal as $data){
$voucher_id=(int)$data['journal']['voucher_id'];	
$ledger_account_id=(int)$data['journal']['ledger_account_id'];
$ledger_sub_account_id=(int)$data['journal']['ledger_sub_account_id'];
$transaction_date=$data['journal']['transaction_date'];
$credit=$data['journal']['credit'];
$debit=$data['journal']['debit'];
$user_id=$data['journal']['user_id'];
$remark=$data['journal']['remark'];
$transaction_date=date('d-m-Y',$transaction_date);
$result_ledger_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ledger_account_id)));
$ledger_ac_name=$result_ledger_account[0]['ledger_account']['ledger_name'];

if($ledger_account_id == 34 ){
	$result_ledger_sub_account=$this->requestAction(array('controller' => 'Hms', 'action' => 'subledger_fetch_by_auto_id'),array('pass'=>array($ledger_sub_account_id)));
	$flat_id=$result_ledger_sub_account[0]['ledger_sub_account']['flat_id'];	
	$led_sub_name=$result_ledger_sub_account[0]['ledger_sub_account']['name'];
		//wing_id via flat_id//
				$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat_info as $flat_info){
					$wing_id=$flat_info["flat"]["wing_id"];
				}
				
		$user_detail = $this->requestAction(array('controller' => 'Bookkeepings', 'action' => 'fetch_user_info_via_flat_id'), array('pass' => array($wing_id,$flat_id)));		
		foreach($user_detail as $data){
		$user_name = $data['user']['user_name'];
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
		$user_name.=$led_sub_name.'  '.$bank_account;
	}	
	





$result_user=$this->requestAction(array('controller' => 'Hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));

$prepared_by=$result_user[0]['user']['user_name'];
$flat=$result_user[0]['user']['flat'];
$wing=$result_user[0]['user']['wing'];

$wing_flat_prepared=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'), array('pass' => array($wing,$flat))); 

?>
<tr>
<td><?php echo $ledger_ac_name ; ?>   <?php echo $user_name; ?> <?php echo $wing_flat; ?>  </td>

<td align="right"><?php echo $debit ; ?>  <?php $total_debit+=$debit; ?></td>
<td align="right"><?php echo $credit ; ?> <?php $total_credit+=$credit; ?></td>
</tr>
<?php
}
 ?>
<tr>
<td align="right" colspan="1" ><span style="float:left;"><b>Narration:</b> <?php echo $remark; ?></span><span><b> Total </b> </span> </td>

<td align="right" > <?php echo $total_debit; ?>  </td>
<td align="right"> <?php echo $total_credit; ?>  </td>

</tr>
</table>
</div>
<div align="" style="padding: 10px;">
<center><span style="font-size:14px;float:left;"><b> Prepared By : </b>  <?php echo $prepared_by; ?> <?php echo $wing_flat_prepared; ?> </span>
 <span style="font-size:14px;"><b> Approved By : </b>   </span > </center>
</div>

</div>

