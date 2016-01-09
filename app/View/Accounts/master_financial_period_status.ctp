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
<a href="<?php echo $webroot_path; ?>Accounts/master_financial_period_status" class="btn yellow" rel='tab'>Financial Year Status</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_financial_year" class="btn" rel='tab'>Open New Year</a>
</center>
<br />
<form method="post">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Financial Year Status</h4>
</div>
<div class="portlet-body form">
<center>
<table class="table table-bordered" style="width:80%; background-color:white;">
<tr style="background-color:#CAFCC9;">
<th style="text-align:center;"><p style="font-size:18px;">#</p></th>
<th style="text-align:center;"><p style="font-size:18px;">Period</p></th>
<th style="text-align:center;"><p style="font-size:18px;">Status</p></th>
<th style="text-align:center;"><p style="font-size:18px;">Edit/Change</p></th>
</tr>
<?php 
$n = 0;
foreach($cursor1 as $collection)
{
$n++;
$auto_id = (int)$collection['financial_year']['auto_id'];
$from = $collection['financial_year']['from'];
$to = $collection['financial_year']['to'];
$fromm = date('d-M-Y',$from->sec);
$tom = date('d-M-Y',$to->sec);
$status = (int)$collection['financial_year']['status'];
$society_id = (int)$collection['financial_year']['society_id'];
?>
<tr>
<td style="text-align:center;"><p style="font-size:18px;"><?php echo $n; ?></p></td>
<td style="text-align:center;"><p style="font-size:18px;"><?php echo $fromm; ?> - <?php echo $tom; ?></p></td>
<td style="text-align:center;"> <?php if($status == 2) { ?>
<span class="label label-important">Closed</span>
<?php } else { ?>
<span class="label label-success">Opened</span>
<?php } ?>
</td>
<td style="text-align:center;"> 

 
                            
                              <div class="controls">
                                 <div class="basic-toggle-button">
                                    <input type="checkbox" class="toggle" 
									<?php if($status == 1) { ?>
									checked="checked" <?php } ?> value="2" name="abc<?php echo $auto_id; ?>"/>
                                 </div>
                              </div>
                           
                               






</td>
</tr>
<?php } ?>
<tr>
</table>
</center>
<br>
<div class="form-actions">
<button type="submit" name="status" class="btn green">Save</button>
</div>

</div>
</div>
</form>



<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('ffyyyy');
if($status5==1)
{
?>
$.gritter.add({
title: 'Financial Year',
text: '<p>Thank you.</p><p>The Financial year added successfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(3104)));
} ?>
});
</script> 













