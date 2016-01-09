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
</div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<div style="text-align:center;" class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" class="btn" rel='tab'>Bill Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_regular" class="btn yellow" rel='tab'>Regular Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_supplimentry" class="btn" rel='tab'>Supplementary Report</a>
<!--<a href="<?php //echo $webroot_path; ?>Incometrackers/income_heads_report" class="btn" rel='tab'>Income head report</a>-->
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement" class="btn" rel='tab'>Account Statement</a>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="background-color:#fff;padding:5px;width:100%; overflow:auto;" class="form_div">
<h4 style="color: #09F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;"><i class="icon-money"></i> Regular Bill Edit</h4>

<form id="contact-form" method="post">
<div class="row-fluid">
<div class="span6">

<?php
foreach($cursor1 as $data)
{
$arr1 = $data['society']['income_head'];
}

foreach($arr1 as $ddd)
{
$ih_id = (int)$ddd;

$head1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($ih_id)));
foreach($head1 as $yyyy)
{
$name = $yyyy['ledger_account']['ledger_name'];	
}
?>

<label style="font-size:14px;"><?php echo $name; ?><span style="color:red;">*</span></label>
<div class="controls">
<input type="text"  name="ammount" id="amount" class="m-wrap span9">
<label id="amount"></label>
</div>
<br />









<?php
}
?>


<div class="controls">
<label class="" style="font-size:14px;">Penalty<i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please choose penalty yes/no "> </i></label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="pen" value="1" style="opacity: 0;" id="pen"></span></div>
Yes
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="pen" value="2" style="opacity: 0;" id="pen"></span></div>
No
</label>
<label id="pen"></label>
</div>
<br />

























</div>
<div class="span6">


<label style="font-size:14px;">Billing Description</label>
<div class="controls">
<textarea class="span9 m-wrap" name="description" id="description" style="resize:none;" rows="3"></textarea>
<label id="description"></label>
</div>








</div>
</div>
<br />
<button type="submit" class="btn green" name="ptp_add" value="xyz" id="vali">Submit</button>
<a href="it_reports_regular" class="btn">Reset</a>
</form>
</div>


































