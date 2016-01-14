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
<div style="width:100%;" class="hide_at_print">
<span style="float:right;"><a href="fix_deposit_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a></span>
<span style="float:right; margin-right:1%;"><button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
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
<th class="hide_at_print">Action </th>
</tr>
<?php
$tt_amt = 0;
foreach($cursor1 as $data)
{
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
<td class="hide_at_print">
<?php if(!empty($file_name)){ ?><a href="<?php echo $webroot_path ; ?>/fix_deposit/<?php echo $file_name; ?>" target="_blank" class=""  download="download"> <i class=" icon-download-alt"></i> </a> <?php } ?>
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
	
<?php	
}

