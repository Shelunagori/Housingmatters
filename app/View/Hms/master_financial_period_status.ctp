<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>




<center>
<h3><b>Financial Period Status</b></h3>
</center>
<a href="master_financial_period_status" class="btn purple">Financial Year Status</a>
<a href="master_financial_year" class="btn yellow">Open New Year</a>
<br><br>


<center>
<form method="post">
<table class="table table-bordered" style="width:80%; background-color:white;">
<tr>
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
<td colspan="4" style="text-align:center;">
<button type="submit" name="status" class="btn green">Save</button>
</td>
</tr>
</table>
</form>
</center>
















