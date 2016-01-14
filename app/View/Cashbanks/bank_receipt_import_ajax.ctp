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
<h4 class="block"><i class="icon-reorder"></i>Import Bank Receipt</h4>
</div>
<div class="portlet-body form"> 
<div id="validdn"></div>
<table style="width:100%; background-color:white;" id="tbb">
<thead>
<tr>
<th>Tranasction Date</th>
<th>Receipt Mode</th>
<th>Cheque No</th>
<th>Branch</th>
<th>Reference/UTR#</th>
<th>Drawn Bank</th>
<th>Date</th>
<th>Deposited In</th>
<th>Party Name</th>
<th>Amount</th>
<th>Narration</th>
<th>Delete</th>
</tr>
</thead>
<tbody id="open_bal">
<?php 
$j=0;
foreach($aaa as $data)
{
$j++; 
$TransactionDate = $data[0];
$ReceiptMod = $data[1];
$ChequeNo = $data[2];
$Reference = $data[3];
$DrawnBankname = $data[4];
$bank_id = $data[5];
$Date1 = $data[6];
$auto_id = $data[7];
$Amount = $data[8];
$narration = $data[9];
$branch = $data[12]; 
?>
<tr id="tr<?php echo $j; ?>">
<td>
<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" placeholder="Transaction Date" style="background-color:white !important;" value="<?php echo $TransactionDate; ?>">
</td>
<td>
<input type="text" class="m-wrap span12" readonly="readonly" value="<?php echo $ReceiptMod; ?>" style="background-color:white !important;"/>
</td>
<td>
<input type="text" class="m-wrap span12" value="<?php echo $ChequeNo; ?>" style="background-color:white !important;"/>
</td>
<td>
<input type="text" class="m-wrap span12" value="<?php echo $branch; ?>" style="background-color:white !important;"/>
</td>
<td>
<input type="text" class="m-wrap span12" value="<?php echo $Reference; ?>" style="background-color:white !important;"/>
</td>
<td>
<input type="text" class="m-wrap span12" value="<?php echo $DrawnBankname; ?>" style="background-color:white !important;"/>
</td>
<td>
<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" placeholder="Transaction Date" style="background-color:white !important;" value="<?php echo $Date1; ?>">
</td>
<td> 
<select class="m-wrap span12 chosen">
<?php
foreach($cursor1 as $collection)
{
$b_id = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];		
?>
<option value="<?php echo $b_id; ?>" <?php if($b_id == $bank_id) { ?> selected="selected" <?php } ?> ><?php echo $name; ?></option>
<?php
}
?>
</select>
</td>
<td>
<select class="m-wrap span12 chosen">
<?php
foreach($cursor2 as $collection)
{
$a_id = (int)$collection['ledger_sub_account']['auto_id'];
$name1 = $collection['ledger_sub_account']['name'];
$flat_id = $collection['ledger_sub_account']['flat_id'];

$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}	


$wing_flat = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'wing_flat'),array('pass'=>array($wnngg_idddd,$flat_id)));
		
?>
<option value="<?php echo $a_id; ?>" <?php if($a_id == $auto_id) { ?> selected="selected" <?php } ?> ><?php echo $name1; ?>
&nbsp;&nbsp;<?php echo $wing_flat; ?>
</option>
<?php
}
?>
</select>
</td>
<td>
<input type="text" class="m-wrap span12" value="<?php echo $Amount; ?>" style="background-color:white !important; text-align:right;" onkeyup="numeric_vali(this.value,<?php echo $j; ?>)" id="amttt<?php echo $j; ?>"/>
</td>
<td>
<input type="text" value="<?php echo $narration; ?>" class="m-wrap span12" style="background-color:white !important;"/>
</td>
<td><a href="#" role="button" class="btn mini red delete" del="<?php echo $j; ?>"><i class="icon-remove icon-white"></i></a></td>
</tr>

<?php
}
?>
</tbody>
</table> 
<br />
<div class="form-actions">

<a class="btn" href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt" rel="tab">Cancel</a>
<button class="btn blue bank_receipt_import">Import</button>
</div>
</div>
</div>

  
  
<?php /* 
  
    <div class="bank_rr" style="overflow:auto;">
	<div style="background-color:white; width:100%; overflow:auto;">
		<div class="modal-header">
		<h4 id="myModalLabel1">Import csv</h4>
		</div>
	<div class="modal-body bank_receipt_done" style="overflow:auto;">
	<div class="validat_text"></div> 
	<br />
<table class="table table-bordered" style="width:100%; background-color:white;" id="open_bal">
<tr>
<th>Tranasction Date</th>
<th>Receipt Mode</th>
<th>Cheque No</th>
<th>Branch</th>
<th>Reference/UTR#</th>
<th>Drawn Bank</th>
<th>Date</th>
<th>Deposited In</th>
<th>Party Name</th>
<th>Amount</th>
<th>Narration</th>
<th>Delete</th>
</tr>
<?php 
$j=0;
foreach($aaa as $data)
{
$j++; 
$TransactionDate = $data[0];
$ReceiptMod = $data[1];
$ChequeNo = $data[2];
$Reference = $data[3];
$DrawnBankname = $data[4];
$bank_id = $data[5];
$Date1 = $data[6];
$auto_id = $data[7];
$Amount = $data[8];
$narration = $data[9];
$branch = $data[12]; 

/*
$c = (int)strcasecmp("Cheque",$ReceiptMod);
$n = (int)strcasecmp("NEFT",$ReceiptMod);
$p = (int)strcasecmp("PG",$ReceiptMod);
if($c == 0)
{
$mode_id = 1;	
}
if($n == 0)
{
$mode_id = 1;	
}
if($p == 0)
{
$mode_id = 1;	
}
*/

/*
?>


<tr id="tr<?php echo $j; ?>">
<td>
<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="date" placeholder="Transaction Date" style="background-color:white !important;" id="date" value="<?php echo $TransactionDate; ?>">
</td>
<td>
<input type="text" name="" class="m-wrap span12" readonly="readonly" value="<?php echo $ReceiptMod; ?>" />
</td>
<td>
<input type="text" name="" class="m-wrap span12" value="<?php echo $ChequeNo; ?>" />
</td>
<td>
<input type="text" name="" class="m-wrap span12" value="<?php echo $branch; ?>" />
</td>
<td>
<input type="text" name="" class="m-wrap span12" value="<?php echo $Reference; ?>" />
</td>
<td>
<input type="text" name="" class="m-wrap span12" value="<?php echo $DrawnBankname; ?>" />
</td>
<td>
<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="date" placeholder="Transaction Date" style="background-color:white !important;" id="date" value="<?php echo $Date1; ?>">
</td>
<td> 
<select name="" class="m-wrap span12">
<?php
foreach($cursor1 as $collection)
{
$b_id = (int)$collection['ledger_sub_account']['auto_id'];
$name = $collection['ledger_sub_account']['name'];		
?>
<option value="<?php echo $b_id; ?>" <?php if($b_id == $bank_id) { ?> selected="selected" <?php } ?> ><?php echo $name; ?></option>
<?php
}
?>
</select>
</td>
<td>
<select name="" class="m-wrap span12">
<?php
foreach($cursor2 as $collection)
{
$a_id = (int)$collection['ledger_sub_account']['auto_id'];
$name1 = $collection['ledger_sub_account']['name'];
$flat_id = $collection['ledger_sub_account']['flat_id'];

$flatt_datta = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach ($flatt_datta as $fltt_datttaa) 
{
$wnngg_idddd = (int)$fltt_datttaa['flat']['wing_id'];
}	


$wing_flat = $this->requestAction(array('controller' => 'Incometrackers', 'action' => 'wing_flat'),array('pass'=>array($wnngg_idddd,$flat_id)));
		
?>
<option value="<?php echo $a_id; ?>" <?php if($a_id == $auto_id) { ?> selected="selected" <?php } ?> ><?php echo $name1; ?>
&nbsp;&nbsp;<?php echo $wing_flat; ?>
</option>
<?php
}
?>
</select>
</td>
<td>
<input type="text" name="" class="m-wrap span12" value="<?php echo $Amount; ?>" />
</td>
<td>
<input type="text" value="<?php echo $narration; ?>" class="m-wrap span12" />
</td>
<th><a href="#" role="button" class="btn mini red delete" del="<?php echo $j; ?>"><i class="icon-remove icon-white"></i></a></th>
</tr>
<?php
}
?>
</table>
</div>
<div class="modal-footer">
<a class="btn" href="<?php echo $webroot_path; ?>Cashbanks/bank_receipt" rel="tab">Cancel</a>
<button type="submit" class="btn blue bank_receipt_import">Import</button>
</div>
</div>
</div>
*/ ?>