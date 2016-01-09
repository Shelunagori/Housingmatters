<style>
#tbb th{
	font-size: 10px !important;background-color:#69F1AD; border:solid 1px #000; 
}
#tbb td{
	font-size: 10px;border:solid 1px #55965F;background-color:#F7F7F7; 
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
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Import Bank Payment</h4>
</div>
<div class="portlet-body form">
<div id="validdn"></div>
 <table class="" id="tbb" style="width:100%;">
    <thead>
        <tr>
        <th style="width:8%;">Transaction Date</th>
        <th style="width:13%;">Ledger A/c</th>
        <th style="width:8%;">Amount</th>
        <th style="width:4%;">TDS %</th>
        <th style="width:8%;">Net Amount</th>
        <th style="width:8%;">Mode of Payment</th>
        <th style="width:8%;">Instrument/UTR</th>
        <th style="width:8%;">Bank Account</th>
        <th style="width:8%;">Invoice Reference</th>
        <th style="width:16%;">Narration</th>
        <th style="width:3%;">delete</th>
        </tr>
    </thead>
    <tbody id="open_bal">
    <?php
	$ttt = 0;
    foreach($aaa as $dataaa)
	{
	$ttt++;	
	$transaction_date = $dataaa[0];	
	$typppp = (int)$dataaa[1];	
	$auto_idddd = (int)$dataaa[2];	
    $amount = $dataaa[3];
	$tds_per = $dataaa[4];
	$mode = $dataaa[5];
	$instrument = $dataaa[6];
	$bank_id = (int)$dataaa[7];
	$invoice = $dataaa[8];
	$narration = $dataaa[9]
	?>
    <tr id="tr<?php echo $ttt; ?>">
             <td valign="top">
             <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" value="<?php echo 								              $transaction_date; ?>" style="background-color:white !important; margin-top:2.5px;">
             </td>
                
                              
<td valign="top">
<select class="m-wrap span12 chosen">
<option value="">--SELECT--</option>
<?php
foreach($cursor1 as $collection)
{
$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];
?>
<option value="<?php echo $auto_id; ?>,1" <?php if($typppp == 1 && $auto_idddd == $auto_id){ ?> selected="selected"<?php } ?>><?php echo $name; ?></option>
<?php } ?>
<?php
foreach($cursor12 as $collection)
{
$auto_id_a = (int)$collection['accounts_group']['auto_id'];
$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_a)));
foreach($result33 as $collection)
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
if($auto_id == 15)
continue;
?>
<option value="<?php echo $auto_id; ?>,2" <?php if($typppp == 2 && $auto_idddd == $auto_id){ ?> selected="selected"<?php } ?>><?php echo $name; ?></option>
<?php }} ?>
<?php
foreach($cursor13 as $collection)
{
$auto_id_b = (int)$collection['accounts_group']['auto_id'];

$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_b)));
foreach($result33 as $collection)
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>,2" <?php if($typppp == 2 && $auto_idddd == $auto_id){ ?> selected="selected"<?php } ?>><?php echo $name; ?></option>
<?php }} ?>
</select>
</td>
                
<td valign="top">
<input type="text" class="m-wrap span12" id="amttt<?php echo $ttt; ?>" style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" onkeyup="numeric_vali(this.value,<?php echo $ttt; ?>)" onchange="tdssssamt2(this.value,<?php echo $ttt; ?>)" value="<?php echo $amount; ?>">
</td>
 
 
                
<td valign="top">
<select class="m-wrap chosen span12" onchange="tdssssamt(this.value,<?php echo $ttt; ?>)" id="tdssss<?php echo $ttt; ?>">
<option value="" style="display:none;">Select</option>
<?php
for($k=0; $k<sizeof($tds_arr); $k++)
{
$tds_sub_arr = $tds_arr[$k];	
$tds_id = (int)$tds_sub_arr[1];
$tds_tax = $tds_sub_arr[0];	
?>
<option value= "<?php echo $tds_id; ?>" <?php if($tds_per == $tds_tax) {  $taxx = $tds_tax; ?> selected="selected"<?php } ?>><?php echo $tds_tax; ?></option>
<?php } ?>                           
</select>
</td>

<?php
$tds_charge = (float)((@$taxx/100)*$amount);
$total_amount = round($amount - $tds_charge);
?>
<td id="tds_show<?php echo $ttt; ?>" valign="top"><input type="text"  class="m-wrap span12" readonly="readonly" style="background-color:white !important; margin-top:2.5px;" value="<?php echo $total_amount; ?>">
</td>
                
<td valign="top">
<select class="m-wrap span12 chosen">
<option value="">Select</option>
<option value="Cheque" <?php if($mode == "Cheque") { ?> selected="selected" <?php } ?>>Cheque</option>
<option value="NEFT" <?php if($mode == "NEFT") { ?> selected="selected" <?php } ?>>NEFT</option>
<option value="PG" <?php if($mode == "PG") { ?> selected="selected" <?php } ?> >PG</option>
</select>
</td>

<td valign="top"><input type="text"  class="m-wrap span12" style="text-align:right; background-color:white !important; margin-top:2.5px;" value="<?php echo $instrument; ?>">
</td>
               
<td valign="top"><select onchange="get_value(this.value)" class="m-wrap chosen span12">
<option value="" style="display:none;">Select</option>    
<?php
foreach ($cursor2 as $db) 
{
$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
$sub_account_name =$db['ledger_sub_account']['name'];
$ac_number = $db['ledger_sub_account']['bank_account']; 
$bank_acccc = substr($ac_number,-4);  
?>
<option value="<?php echo $sub_account_id; ?>" <?php if($sub_account_id == $bank_id) { ?> selected="selected" <?php } ?>><?php echo $sub_account_name; ?>&nbsp;&nbsp;<?php echo $bank_acccc; ?></option>
<?php } ?>
</select>
</td>

<td valign="top">
<input type="text" class="m-wrap span12" style="background-color:white !important; margin-top:2.5px;" value="<?php echo $invoice; ?>">
</td>

<td valign="top">
<input type="text" class="m-wrap span12" style="background-color:white !important; margin-top:2.5px;" value="<?php echo $narration; ?>">
</td>
    <td>
    <a href="#" role="button" class="btn mini red delete" del="<?php echo $ttt; ?>"><i class="icon-remove icon-white"></i></a>
    </td>
    </tr>
   <?php
	}
	?>
    </tbody>
    </table>
<br />
<div class="form-actions">
<a class="btn" href="<?php echo $webroot_path; ?>Cashbanks/bank_payment" rel="tab">Cancel</a>
<button class="btn green bank_receipt_import">Submit</button>
</div>
</div>
</div>





