<div style="">

<div align="right" class="hide_at_print">

<a href="journal_excel?to=<?php echo $to; ?>&from=<?php echo $from; ?>&search_vocher=<?php echo @$search_vocher; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<a  class="btn green mini" onclick="window.print()" ><i class="icon-print"></i>  </a>
<!--<a href="expense_tracker_pdf?to=<?php echo $to; ?>&from=<?php echo $from; ?>" class="btn purple mini">Pdf</a>-->
</div>
<!--<label class="m-wrap pull-left"><input type="text" id="search_content" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="search by voucher"></label>-->
</div>

<style>
#bg_color th{
font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;
}
#report_tb td{
padding:2px;
font-size: 12px;border:solid 1px #55965F;background-color:#FFF;
}
.text_bx{
width: 50px;
height: 15px !important;
margin-bottom: 0px !important;
font-size: 12px;
}
.text_rdoff{
width: 50px;
height: 15px !important;
border: none !important;
margin-bottom: 0px !important;
font-size: 12px;
}
</style>
<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	

<table width="100%" style="background-color:white;" class="table table-bordered table-striped">
<thead>
<tr>
<th colspan="7" style="text-align:center;"><b>
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
<th class="hide_at_print" style="width:20px;">view</th>
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
<td class="hide_at_print" style="width:7%;"> 

<div class="btn-group">
<a class="btn blue mini" href="#" data-toggle="dropdown">
<i class="icon-chevron-down"></i>	
</a>
<ul class="dropdown-menu" style="min-width:80px !important;">
<li><a href="journal_voucher_view/<?php echo $voucher_id; ?>" target="_blank" ><i class="icon-search"></i> View</a>  </li>
</ul>
</div> 


<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: <?php echo $prepaired_by; ?> on: <?php echo $current_date; ?>">
 </i>	



</td>
</tr>
<?php } ?>

<tr>
<td colspan="4" style="text-align:right;"> <b> Total </b> </td>
<td style="text-align:right;" > <b><?php echo $total_credit; ?></b> </td>
<td class="" style="text-align:right;"> <b><?php echo $total_debit; ?></b> </td>
<td class="hide_at_print" style="text-align:right;">  </td>
</tr>
</tbody>
</table>

<?php if(empty($page)){ $page=1;} ?>
<div class="hide_at_print">
	<span>Showing page:</span><span> <?php echo $page; ?></span> <br/>
	<span>Total entries: <?php echo ($count_bank_receipt_converted); ?></span>
</div>
<div class="pagination pagination-medium hide_at_print">
<ul>
<?php 
$loop=(int)($count_bank_receipt_converted/10);
if($count_bank_receipt_converted%10>0){
	$loop++;
}
for($ii=1;$ii<=$loop;$ii++){ ?>
	<li><a href="#" onclick="paginttion(<?php echo $ii; ?>)" role="button" ><?php echo $ii; ?></a></li>
<?php } ?>
</ul>
</div>


<script>
		 var $rows = $('#count_row tr');
		 $('#search').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
			
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
 </script>	










