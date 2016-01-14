<div class="hide_at_print">
<center>
<h3><b>Bill Detail</b></h3>
</center>
<!-- <a href="my_flat" class="btn yellow">Flat Ledger</a> -->
<a href="my_flat_bill" class="btn purple">Bill Detail</a>
<a href="my_flat_receipt" class="btn yellow">Bank Receipt</a>
</div>
<!--<div class="hide_at_print">
<span style="margin-left:80%;">
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button>
</span>
</div>-->
<center>
<br />
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?>



<center>
<div class="hide_at_print">
<form method="post" id="contact-form">
<br>
<table>
<tbody><tr>
<td>
<select name="type" id="tp" class="m-wrap medium">
<option value="" style="display:none;">Select</option>
<option value="1">All Bills</option>
<option value="2">Current Bill</option>
<option value="3">Old Bills</option>
</select>
</td>
<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>

<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
</tr>
</tbody></table>
</br>
</form>
</div>
</center>






















<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<div style="width:94%;" id="result">

</div>
</center>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<!-- </center>
<center>
<br />
<div style="width:94%;" id="result">
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th style="text-align:center;">#</th>
<th style="text-align:center;">Bill No.</th>
<th style="text-align:center;">Bill Date</th>
<th style="text-align:center;">Due Date</th>
<th style="text-align:center;">Total Amount</th>
<th style="text-align:center;">Pay Amount</th>
<th style="text-align:center;">Action</th>
</tr>
<?php
$nn=0;
foreach($cursor1 as $collection)
{
$nn++;
$bill_no = (int)$collection['regular_bill']['receipt_id'];	
$from = $collection['regular_bill']['bill_daterange_from'];
$to = $collection['regular_bill']['bill_daterange_to'];
$due_date = $collection['regular_bill']['due_date'];
$total_amount = (int)$collection['regular_bill']['g_total'];
$remaining_amt = (int)$collection['regular_bill']['remaining_amount'];
$fromm = date('d-M-Y',$from->sec);
$tom = date('d-M-Y',$to->sec);
$due = date('d-M-Y',$due_date->sec);
$pay_amt = $total_amount - $remaining_amt; 
?>
<tr>
<td style="text-align:center;"><?php echo $nn; ?></td>
<td style="text-align:center;"><?php echo $bill_no; ?></td>
<td style="text-align:center;"><?php echo $fromm; ?>-<?php echo $tom; ?></td>
<td style="text-align:center;"><?php echo $due; ?></td>
<td style="text-align:center;"><?php echo $total_amount; ?></td>
<td style="text-align:center;"><?php echo $pay_amt; ?></td>
<td style="text-align:center;">
<a href="regular_bill_view?bill=<?php echo $bill_no; ?>" class="btn mini yellow" target="_blank">View Bill</a>

</td>
</tr>
<?php
}
?>

</table>
</div>
</center>
-->

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
$("#go").live('click',function(){
var date1=document.getElementById('date1').value;
var date2=document.getElementById('date2').value;
var tp=document.getElementById('tp').value; 

if((tp=='')) { alert('Please Select Bill Type'); }
if((date1=='')) { alert('Please Input Date-from'); }
if((date2=='')) { alert('Please Input Date-to'); }
else
{
$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("my_flat_bill_ajax?date1=" +date1+ "&date2=" +date2+ "&tp=" +tp+ "");
}
});
});
</script>	






