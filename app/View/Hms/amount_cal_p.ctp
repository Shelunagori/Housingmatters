<?php
$result_tds = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_tds'),array('pass'=>array($tds)));
foreach($result_tds as $collection)
{
 $charge = (int)$collection['master_tds']['charge'];
}


$tds_charge = (float)(($charge/100)*$amount);

$total_amount = round($amount - $tds_charge); 
?>
<input type="text" value="<?php echo $total_amount; ?>"  style="height:25px;" readonly="readonly">