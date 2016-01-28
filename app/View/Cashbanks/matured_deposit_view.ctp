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
<center>
<a href="<?php echo $webroot_path; ?>Cashbanks/fix_deposit_add" class="btn" rel='tab'>Add</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/fix_deposit_view" class="btn" rel='tab'>Active Deposits</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/matured_deposit_view" class="btn yellow" rel='tab'>Matured Deposits</a>
<!--<a href="<?php //echo $webroot_path; ?>Cashbanks/fixed_deposit_bar_chart" class="btn" rel='tab'>Maturity Profile</a>-->
<!--<a href="<?php //echo $webroot_path; ?>Cashbanks/matured_deposit_add" class="btn" rel='tab'>Approve matured Deposit</a>-->
<a href="<?php echo $webroot_path; ?>Cashbanks/fixed_deposit_renewal_show" class="btn" rel='tab'>Reneawal View</a>
</center>
</div>
<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?>
       
        
 <!--       
<center>
<div class="hide_at_print">
<form method="post" id="contact-form">
<table>
<tbody><tr>
<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
</tr>
</tbody></table>
</form>
</div>
</center>
<script>
$(document).ready(function() {
$("#go").bind('click',function(){
var date1=document.getElementById('date1').value;
var date2=document.getElementById('date2').value;
if((date1=='')) { alert('Please Input Date-from'); }
if((date2=='')) { alert('Please Input Date-to'); }
else
{
$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path;?>as/loding.gif" />Loading....</div>').load("bank_payment_show_ajax?date1=" +date1+ "&date2=" +date2+ "");
}
});
});
</script>	
-->      
 
 
 
 
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
<span style="float:right;"><a href="matured_deposit_excel" class="btn blue mini"><i class="icon-download"></i></a></span>
<span style="float:right; margin-right:1%;"><a type="button" class="printt btn green mini" onclick="window.print()"><i class="icon-print"></i></a></span>
</div>
<br /><br />
<div style="width:100%; overflow:auto;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>
<table width="100%" style="background-color:white;" id="report_tb">
<thead>
<tr>
<th colspan='10' style='text-align:center;'><?php echo $society_name; ?> Fixed Deposit Register</th>
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
$move_by = "";
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
@$renewal = @$data['fix_deposit']['renewal'];
$move_by_id = (int)$data['fix_deposit']['move_by'];
$move_on_date = $data['fix_deposit']['move_on'];

$move_on = date('d-m-Y',strtotime($move_on_date));
$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($move_by_id)));
foreach ($result_gh as $collection) 
{
$move_by = $collection['user']['user_name'];
}	




$creation_date = date('d-m-Y',strtotime($creation_date));

$start_date	= date('d-m-Y',($start_date));	
$mat_date	= date('d-m-Y',($mat_date));
$result_gh = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($creater_id)));
foreach ($result_gh as $collection) 
{
$prepaired_by_name = $collection['user']['user_name'];
}	
if($renewal != 'y')
{
$tt_amt = $tt_amt + $amt;
?>

<tr>
<td><?php echo $receipt_id; ?></td>
<td style="width:20%;"><?php echo $bank_name; ?></td>
<td><?php echo $branch; ?></td>
<td><?php echo $reference; ?></td>
<td style="text-align:right;"><?php echo $start_date; ?></td>
<td style="text-align:right;"><?php echo $mat_date; ?></td>
<td style="text-align:center;"><?php echo $rate; ?>%</td>
<td style="text-align:right;"><?php $amt2 = number_format($amt); echo $amt2; ?></td>
<td style="width:20%;"><?php echo $remarks; ?></td>
<td class="hide_at_print">
<?php if(!empty($file_name)){ ?><a href="<?php echo $webroot_path ; ?>/fix_deposit/<?php echo $file_name; ?>" target="_blank" class=""  download="download"> <i class=" icon-download-alt"></i> </a> <?php } ?>

<div class="btn-group">
	<a class="btn blue mini" href="#" data-toggle="dropdown">
	<i class="icon-chevron-down"></i>	
	</a>
	<ul class="dropdown-menu" style="min-width:70px !important;">
	<li><a href="matured_deposit_view?aa=<?php echo $transaction_id; ?>">Reverse</a>
	
</li>
	</ul>
	</div>
	
<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: 
	<?php echo $prepaired_by_name; ?> on: <?php echo $creation_date; if(!empty($move_by)) {?>, Moved by: <?php echo $move_by; ?> on: <?php echo $move_on; } ?>"></i>	
	
	
	
</td>
</tr>
<?php
}}
?>
            <tr>
            <td colspan="7" style="text-align:right;"><b>Total</b></td>
            <td style="text-align:right;"><b><?php $tt_amt2 = number_format($tt_amt); echo $tt_amt2; ?></b></td>
            <td></td>
            <td class="hide_at_print">
			</td>
            </tr>
            </tbody>
</table>	
	
<?php	
}
?>
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
       
        