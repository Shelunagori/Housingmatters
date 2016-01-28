<script>
$(document).ready(function(){
jQuery('.tooltips').tooltip();
});
</script> 
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

<?php
$m_from=date("Y-m-d", strtotime($from));
$m_from = strtotime($m_from);

$m_to=date("Y-m-d", strtotime($to));
$m_to = strtotime($m_to);
?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$nnn = 55;
foreach ($cursor1 as $collection) 
{
$receipt_no = (int)@$collection['new_cash_bank']['receipt_id'];
$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];	
$account_type = (int)$collection['new_cash_bank']['account_type'];
$user_id = (int)$collection['new_cash_bank']['user_id'];
$date = $collection['new_cash_bank']['transaction_date'];
$prepaired_by = (int)$collection['new_cash_bank']['prepaired_by'];   
$narration = $collection['new_cash_bank']['narration'];
$account_head = $collection['new_cash_bank']['account_head'];
$amount = $collection['new_cash_bank']['amount'];

$current_date = $collection['new_cash_bank']['current_date'];
$creation_date = date('d-m-Y',strtotime($current_date));

$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
foreach ($result_gh as $collection) 
{
$prepaired_by_name = $collection['user']['user_name'];
}			


if($account_type == 1)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_sub_account']['name'];	  
}
}
else if($account_type == 2)
{
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($user_id)));
foreach ($result_la as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];	  
}
}      
											


									
if($date >= $m_from && $date <= $m_to)
{
if($s_user_id == $user_id)  
{
$nnn = 555;								
}
else if($s_role_id == 3)
{
$nnn = 555;
}
}
}

?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($nnn == 555)
{
?>
<div style="width:100%;" class="hide_at_print">
<span style="float:right;"><a href="petty_cash_payment_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue mini"><i class="icon-download"></i> </a></span>
<span style="float:right; margin-right:1%;"><a  class=" printt btn green mini" onclick="window.print()"><i class="icon-print"></i> </a></span>
</div>
<br /><br />
<div style="width:100%; overflow:auto;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>
<table width="100%" style="background-color:white;" id="report_tb">
<thead>
<tr >
<th colspan="5" style="text-align:center;"><?php echo $society_name; ?> Petty Cash Payment Register From : <?php echo $from; ?> To : <?php echo $to; ?></th>
</tr>
<tr id="bg_color">
<th>PC Payment Vochure</th>
<th>Transaction Date</th>
<th>Paid To</th>
<th>Amount</th>
<th class="hide_at_print">Action </th>
</tr>
</thead>
<tbody id="table">
<?php

$total_debit = 0;
$total_credit = 0;
foreach ($cursor1 as $collection) 
{
$receipt_no = (int)@$collection['new_cash_bank']['receipt_id'];
$transaction_id = (int)$collection['new_cash_bank']['transaction_id'];	
$account_type = (int)$collection['new_cash_bank']['account_type'];
$user_id = (int)$collection['new_cash_bank']['user_id'];
$date = $collection['new_cash_bank']['transaction_date'];
$prepaired_by = (int)$collection['new_cash_bank']['prepaired_by'];   
$narration = $collection['new_cash_bank']['narration'];
$account_head = $collection['new_cash_bank']['account_head'];
$amount = $collection['new_cash_bank']['amount'];
$current_date = $collection['new_cash_bank']['current_date'];
$creation_date = date('d-m-Y',strtotime($current_date));

$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($prepaired_by)));
foreach ($result_gh as $collection) 
{
$prepaired_by_name = $collection['user']['user_name'];
}			

if($account_type == 1)
{
$result_lsa = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch'),array('pass'=>array($user_id)));
foreach ($result_lsa as $collection) 
{
$user_name = $collection['ledger_sub_account']['name'];	  
}
}
else if($account_type == 2)
{
$result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_amount'),array('pass'=>array($user_id)));
foreach ($result_la as $collection) 
{
$user_name = $collection['ledger_account']['ledger_name'];	  
}
}      

											


									
									if($date >= $m_from && $date <= $m_to)
									{
									
										  if($s_role_id == 3)
										   {
										 $date = date('d-m-Y',($date));	   
										 $total_debit = $total_debit + $amount;
										  $amount = number_format($amount);
										 ?>
                                        <tr>
											
                                            <td><?php echo $receipt_no; ?> </td>
											<td><?php echo $date; ?> </td>
											 <td><?php echo $user_name; ?> </td>
                                                                        
                                            <td><?php echo $amount; ?></td>
                                          
<td class="hide_at_print">






 <div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a>
	<ul class="dropdown-menu" style="min-width:80px !important;">
	<li><a href="petty_cash_payment_html_view/<?php echo $transaction_id; ?>" target="_blank"><i class="icon-search"></i>View</a></li>
	<li><a href="petty_cash_payment_update/<?php echo $transaction_id; ?>"><i class="icon-edit"></i>Edit</a> </li>
	<li><a href="" target="_blank"><i class="icon-file"></i>Pdf</a>
</li>
	</ul>
	</div>


<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: <?php echo $prepaired_by_name; ?> on: <?php echo $creation_date; ?>">
  </i>	




  
</td>
                                          </tr>
 <?php	   
											   
									   }}}
									    
									?>
 <tr>
                                    <td colspan="3" style="text-align:right;"><b>Total</b></td>
                                    <td><b><?php 
									$total_debit = number_format($total_debit);
									echo $total_debit; ?></b></td>
                                    <td class="hide_at_print"></td>
                                    </tr>
                                    
                                    </tbody>
                                    </table>

<?php } 
else
{
?>
<br /><br />											
<center>
<h3 style="color:red;">
<b>No Records Found in Selected Period</b>
</h3>
</center>
<br /><br />
<?php } ?>


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











