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

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<a href="<?php echo $webroot_path; ?>Cashbanks/fix_deposit_add" class="btn" rel='tab'>Add</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/fix_deposit_view" class="btn" rel='tab'>Active Deposits</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/matured_deposit_view" class="btn" rel='tab'>Matured Deposits</a>
<!--<a href="<?php echo $webroot_path; ?>Cashbanks/fixed_deposit_bar_chart" class="btn" rel='tab'>Maturity Profile</a>-->
<!--<a href="<?php //echo $webroot_path; ?>Cashbanks/matured_deposit_add" class="btn" rel='tab'>Approve matured Deposit</a>-->
<a href="<?php echo $webroot_path; ?>Cashbanks/fixed_deposit_renewal_show" class="btn yellow" rel='tab'>Reneawal View</a>
</center>
</div>
<!----------------------------------- Start View coding ------------------------------------>
<?php
$nnn = 55;
foreach($cursor1 as $data)
{
$nnn = 555;
}
if($nnn == 555)
{
$c_date = date('d-m-Y');
?>
<br>

<table width="100%" style="background-color:white;" id="report_tb">
<thead>
<tr>
<th colspan='10' style='text-align:center;'><?php echo $society_name; ?> Fixed Deposit Register on <?php echo $c_date; ?></th>
</tr>
<tr id="bg_color">
<th>Deposit ID</th>
<th>Bank name</th>
<th>Bank Branch</th>
<th>Account Reference</th>
<th>Start Date</th>
<th>Maturity Date</th>
<th>Interest Rate</th>
<th>Principal Amount</th>
<th>Purpose</th>
<th class="hide_at_print">Action </th>
</tr>
</thead>
<tbody id="table">
<?php
$tt_amt = 0;
foreach($cursor1 as $data)
{
$transaction_id = (int)$data['fix_deposit']['transaction_id'];
$receipt_id = $data['fix_deposit']['receipt_id'];
$start_date = $data['fix_deposit']['start_date'];	
$bank_name = $data['fix_deposit']['bank_name'];	
$branch = $data['fix_deposit']['bank_branch'];	
$rate = $data['fix_deposit']['interest_rate'];	
$mat_date = $data['fix_deposit']['maturity_date'];	
$remarks = $data['fix_deposit']['purpose'];		
$reference = $data['fix_deposit']['account_reference'];		
$amt = $data['fix_deposit']['principal_amount'];
$file_name = $data['fix_deposit']['file_name'];
$creation_date = $data['fix_deposit']['current_date'];
$creater_id = (int)$data['fix_deposit']['prepaired_by'];
$creation_date = date('d-m-Y',strtotime($creation_date));
$tt_amt = $tt_amt + $amt;
$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));
$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($creater_id)));
foreach ($result_gh as $collection) 
{
$prepaired_by_name = $collection['user']['user_name'];
}	

?>

<tr>
<td><?php echo $receipt_id; ?></td>
<td style="width:15%;"><?php echo $bank_name; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $reference; ?></td>
<td style="text-align:right;"><?php echo $start_date; ?></td>
<td style="text-align:right;"><?php echo $mat_date; ?></td>
<td style="text-align:center; width:11%;"><?php echo $rate; ?>%</td>
<td style="text-align:right; width:10%;"><?php $amt2= number_format($amt); echo $amt2; ?></td>
<td style="width:20%;"><?php echo $remarks; ?></td>
<td class="hide_at_print" style="width:12%;">
<?php if(!empty($file_name)){ ?><a href="<?php echo $webroot_path ; ?>/fix_deposit/<?php echo $file_name; ?>" target="_blank" class=""  download="download"> <i class=" icon-download-alt"></i> </a> <?php } ?>
<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: 
	<?php echo $prepaired_by_name; ?> on: <?php echo $creation_date; ?>"></i>
</td>
</tr>
<?php
}
?>
            <tr>
            <td colspan="7" style="text-align:right;"><b>Total</b></td>
            <td style="text-align:right;"><b><?php $tt_amt2=number_format($tt_amt); echo $tt_amt2; ?></b></td>
            <td></td>
            <td class="hide_at_print"></td>
            </tr>
            </tbody>
</table>

<?php } else { ?>
	
<div align="center" style="width:100%; overflow:auto;" id="result">
		<br/><br/><h3>Not Found Renewal Fixed Deposit</h3>
	</div>	
	
<?php	
}
?>
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