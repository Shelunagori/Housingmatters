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

$nnn = 55;
foreach ($cursor1 as $collection) 
{
$nnn = 5555;
}


if($nnn == 5555)
{
?>	
<br /><br />
<table width="100%" style="background-color:white;" id="report_tb">
<tr >
<th colspan="10" style="text-align:center;"><?php echo $society_name; ?> Fixed Deposit Register From : <?php echo $from; ?> To : <?php echo $to; ?></th>
</tr>
<tr id="bg_color">
<th>Bank name</th>
<th>Bank Branch</th>
<th>Account Reference</th>
<th>Start Date</th>
<th>Maturity Date</th>
<th>Interest Rate</th>
<th>Principal Amount</th>
<th>Remarks</th>
<th class="hide_at_print">
    <label class="checkbox line">
    <div class="checker" id="uniform-undefined"><span><input type="checkbox" value="" style="opacity: 0;" id="select_all" onclick="select_all_check()"></span></div> 
    </label>
</th>
</tr>
<?php
$tt_amt = 0;
foreach($cursor1 as $data)
{
$auto_id = (int)$data['fix_deposit']['transaction_id'];	
$start_date = $data['fix_deposit']['start_date'];	
$bank_name = $data['fix_deposit']['bank_name'];	
$branch = $data['fix_deposit']['bank_branch'];	
$rate = $data['fix_deposit']['interest_rate'];	
$mat_date = $data['fix_deposit']['maturity_date'];	
$remarks = $data['fix_deposit']['remarks'];		
$reference = $data['fix_deposit']['account_reference'];		
$amt = $data['fix_deposit']['principal_amount'];
$file_name = $data['fix_deposit']['file_name'];
$tt_amt = $tt_amt + $amt;
$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));
?>

<tr>
<td><?php echo $bank_name; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $reference; ?></td>
<td><?php echo $start_date; ?></td>
<td><?php echo $mat_date; ?></td>
<td><?php echo $rate; ?> %</td>
<td style="text-align:right;"><?php echo $amt; ?></td>
<td><?php echo $remarks; ?></td>
<td style="text-align:center;">
<label class="checkbox line">
<div class="checker" id="uniform-undefined"><span><input type="checkbox" value="1" style="opacity: 0;" class="group_check1" name="app<?php echo $auto_id; ?>"></span></div>
</label>
</td>
</tr>
<?php
}
?>
            <tr>
            <td colspan="6" style="text-align:right;"><b>Total</b></td>
            <td style="text-align:right;"><b><?php echo $tt_amt; ?></b></td>
            <td></td>
            <td class="hide_at_print"></td>
            </tr>
</table>	

<br />
<button type="submit" name="sub" class="btn green" style="margin-left:80%;">Approve</button>
	
<?php	
}
?>
<script>
function select_all_check(){
	$(document).ready(function() {
		if($("#select_all").is(":checked")==true){
			$(".group_check1").parent('span').addClass('checked');
			$(".group_check1").prop('checked',true);
		}else{
			$(".group_check1").parent('span').removeClass('checked');
			$(".group_check1").prop('checked',false);
		}
	});
}
</script>















