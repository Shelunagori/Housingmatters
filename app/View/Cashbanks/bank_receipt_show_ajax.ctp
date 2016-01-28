<style>

 #bg_color th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;
}
#report_tb td{
	padding:2px;
	font-size: 12px;border:solid 1px #55965F;
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
<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$nnn = 55;
foreach ($cursor2 as $collection) 
{
$receipt_date = $collection['new_cash_bank']['receipt_date'];
$nnn = 555;

}

//Approved by:<?php echo @$approver_name;  on:<?php echo @$approved_date; ?>			

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($nnn == 555)
{
?>
<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="bank_receipt_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<a  class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i> </a></span>
</div>
<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	
<table  width="100%" style=" background-color:white;" id="report_tb">
<thead>
<tr>
<th colspan="10"><?php echo $society_name; ?> Bank Receipt Register From : <?php echo $from; ?> &nbsp;&nbsp; To : <?php echo $to; ?></th>
</tr>
<tr id="bg_color">
<th>Receipt#</th>
<th>Receipt Date </th>
<th>Receipt Type</th>
<th>Party Name</th>
<th>Payment Mode</th>
<th>Instrument/UTR</th>
<th>Deposit Bank</th>
<th>Narration</th>
<th>Amount</th>
<th class="hide_at_print">Action</th> 
</tr>
</thead>
<tbody id="table">

		<?php
        	$total_credit = 0;
        	$total_debit = 0;
       		 $n=0;
        	foreach ($cursor2 as $collection) 
        	{
			$approver_name = "";
			$approved_by = "";
			$approved_date="";
       	 	$n++;
        	$receipt_no = $collection['new_cash_bank']['receipt_id'];
        	$receipt_mode = $collection['new_cash_bank']['receipt_mode'];
        	$TransactionDate = $collection['new_cash_bank']['receipt_date'];
			$transaction_id = $collection['new_cash_bank']['transaction_id'];
			$bill_one_time_id = @$collection['new_cash_bank']['bill_one_time_id'];
			$deposit_status = (int)@$collection['new_cash_bank']['deposit_status']; 			
            $current_date = $collection['new_cash_bank']['current_date']; 			
            $current_datttt = date('d-m-Y',strtotime($current_date));
            $creater_user_id =(int)@$collection['new_cash_bank']['prepaired_by'];
			$is_cancel = $collection['new_cash_bank']['is_cancel'];
			$approved_by = (int)@$collection['new_cash_bank']['approved_by'];
			$approved_date = @$collection['new_cash_bank']['approved_date'];
			
$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($approved_by)));
foreach ($user_dataaaa as $user_detailll) 
{
$approver_name = @$user_detailll['user']['user_name'];
}	
			
			
			
$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($creater_user_id)));
foreach ($user_dataaaa as $user_detailll) 
{
$creater_name = $user_detailll['user']['user_name'];
}	
			
			if($receipt_mode == "Cheque" || $receipt_mode=="cheque")
					{
						$reference_utr = $collection['new_cash_bank']['cheque_number'];
						$cheque_date = $collection['new_cash_bank']['cheque_date'];
						$drawn_on_which_bank = $collection['new_cash_bank']['drawn_on_which_bank'];
					}
					else
					{
						$reference_utr = $collection['new_cash_bank']['reference_utr'];
						$cheque_date = $collection['new_cash_bank']['cheque_date'];
					}
						$member_type = $collection['new_cash_bank']['member_type'];
						$narration = @$collection['new_cash_bank']['narration'];
				if($member_type == 1)
   				{
					$party_name_id = (int)$collection['new_cash_bank']['flat_id'];
					$receipt_type = $collection['new_cash_bank']['receipt_type'];
			
			    if($receipt_type == 1)
				{
				$receipt_tppp = "Maintenance";	
				}
				else
				{
				$receipt_tppp = "Other";	
				}
			
			
			
$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($party_name_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}			
		
$user_fetch = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wnngg_idddd,$party_name_id)));	
			foreach($user_fetch as $rrr)
			{
				$party_name = $rrr['user']['user_name'];	
				$wing_id = $rrr['user']['wing'];
			}
			
		$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array(@$wing_id,$party_name_id)));
		}
				else
				{
				$receipt_tppp = "Non-Residential";	
				$wing_flat = "";
				$party_name_id = (int)$collection['new_cash_bank']['party_name_id'];
				
$ledger_subaccc = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($party_name_id)));
foreach ($ledger_subaccc as $dataaa) 
{
$party_name = $dataaa['ledger_sub_account']['name'];
}	
				
				
				$bill_reference = @$collection['new_cash_bank']['bill_reference'];	
				}
				$amount=$collection['new_cash_bank']['amount'];
				$flat_id = $collection['new_cash_bank']['flat_id'];
				$deposited_bank_id = (int)$collection['new_cash_bank']['deposited_bank_id'];
				$current_date = $collection['new_cash_bank']['current_date'];
				if($receipt_mode == "Cheque")
				{
				$receipt_mode = $receipt_mode;
				}
			
			
			$ledger_sub_account_fetch_result = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($deposited_bank_id)));			
			foreach($ledger_sub_account_fetch_result as $rrrr)
			{
				$deposited_bank_name = $rrrr['ledger_sub_account']['name'];	
				$bank_account = $rrrr['ledger_sub_account']['bank_account'];
			}			
			
		if($s_role_id == 3)
		{
			$TransactionDate = date('d-m-Y',$TransactionDate);
			$total_debit =  $total_debit + $amount; 
		if(empty($reference_utr))
		{
			$reference_utr = $reference_utr;
		}
?>
<tr <?php if($deposit_status == 1) { ?> style="background-color:#E8EAE8;"  <?php } ?> >
<td><?php echo $receipt_no; ?> </td>
<td><?php echo $TransactionDate; ?></td>
<td><?php echo $receipt_tppp; ?></td>
<td><?php echo @$party_name; ?>&nbsp;(<?php echo $wing_flat; ?>)</td>
<td><?php echo $receipt_mode; ?> - <?php echo @$drawn_on_which_bank; ?></td>
<td><?php echo @$reference_utr; ?> </td>
<td><?php echo $deposited_bank_name; ?>&nbsp;(<?php echo $bank_account; ?>)</td>
<td><?php echo $narration; ?> </td>
<td align='right'>
<?php 
if(!empty($amount))
{
$amount = number_format($amount);
}
echo $amount; ?></td>
<td class="hide_at_print">
	
    <div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a>
	<ul class="dropdown-menu" style="min-width:80px !important;left:-53px;padding: 3px 0px; box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.3); font-size: 12px;">
	<li><a href="bank_receipt_html_view/<?php echo $transaction_id; ?>" target="_blank"><i class="icon-search"></i>View</a></li>
	<li><a href="bank_receipt_pdf/<?php echo $transaction_id; ?>" target="_blank"><i class="icon-file"></i>Pdf</a></li>
	<li><?php
if($is_cancel=="NO" && $maximum_one_time_id==$bill_one_time_id){ ?>
<a href="b_receipt_edit/<?php echo $transaction_id; ?>" role="button" rel="tab"><i class="icon-edit"></i>Edit</a> 
<?php } ?></li>
	<?php if($is_cancel=="NO" && ($maximum_one_time_id==$bill_one_time_id)){ ?>
	<li><a href="#" role="button" class="cancel_receipt" record_id="<?php echo $transaction_id; ?>"><i class="icon-remove"></i>Cancel</a></li>
	<?php } ?>

	</ul>
	</div>

								
<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: 
	<?php echo $creater_name; ?> on: <?php echo $current_datttt; if(!empty($approver_name)) { ?>, Approved by: <?php echo $approver_name; ?> on: <?php echo $approved_date; }?>"></i>								
							








</td>
</tr>
<?php	
}		 
}

?>
<tr>
<td colspan="8" style="text-align:right;"><b>Total</b></td>
<td align="right"><b><?php 
$total_debit = number_format($total_debit);
echo $total_debit; ?> <?php //echo "  dr"; ?></b></td>
<td class="hide_at_print"></td>
</tr>
</tbody>										 
</table> 
<?php 
}
if($nnn == 55)
{
?>					 
<br /><br />					 
<center>					 
<h3 style="color:red;"><b>No Record Found in Selected Period</b></h3>				 
</center>					 
<br /><br />					 
<?php
}
?>

<div style="display: none;" id="cancel_popup">
	<div class="modal-backdrop fade in"></div>
	<div  class="modal fade in" align="left">
		<div class="modal-body" >
			<button type="button" class="close" id="close_model" ></button>
			<div id="success_msg">
				<div style="font-size: 15px; font-weight: 600;">What is the resion for cancel this receipt?</div>
				<div class="row-fluid">
					<a href="#" role="button" class="icon-btn span3 call_cancel_receipt" record_id="0">
						<i class="icon-credit-card"></i>
						<div><b>Cheque Bounce</b></div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$( document ).ready(function() {
	$( '.cancel_receipt' ).click(function() {
		var record_id=$(this).attr("record_id");
		$("#cancel_popup").show();
		$(".call_cancel_receipt").attr("record_id",record_id);
	});
	$( '#close_model' ).click(function() {
		$("#cancel_popup").hide();
	});
	$( '.call_cancel_receipt' ).click(function() {
		var record_id=$(this).attr("record_id");
		$.ajax({
			url: "<?php echo $webroot_path; ?>Cashbanks/cancel_receipt_due_to_check_bounce/"+record_id,
		}).done(function(response){
			$("#success_msg").html(response);
		});
	});
});	
</script>

	<script>
    var $rows = $('#table tr');
    $('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    return !~text.indexOf(val);
    }).hide();
    });
    </script>	