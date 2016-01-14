<?php
$m_from = date("Y-m-d", strtotime($date1));
$m_from = new MongoDate(strtotime($m_from));

$m_to = date("Y-m-d", strtotime($date2));
$m_to = new MongoDate(strtotime($m_to));


?>
<br /><br /><br />
<table class="table table-bordered" style="width:80%; background-color:#FDFDEE;">
<tr>
<th style="text-align:center;">Accounts Category</th>
<th style="text-align:center;">Debit</th>
<th style="text-align:center;">Credit</th>
</tr>
<?php

foreach($cursor1 as $collection)
{
$auto_id1 = (int)$collection['accounts_category']['auto_id'];
$category_name = $collection['accounts_category']['category_name'];	

$total_debit = 0;
$total_credit = 0;
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group_fetch'),array('pass'=>array($auto_id1)));
foreach($result as $collection)
{
$auto_id2 = (int)$collection['accounts_group']['auto_id'];
$group_name = $collection['accounts_group']['group_name'];


$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch'),array('pass'=>array($auto_id2)));
foreach($result2 as $collection)
{
$auto_id3 = (int)$collection['ledger_account']['auto_id'];
$ledger_name = $collection['ledger_account']['ledger_name'];

if($auto_id3 == 15 || $auto_id3 == 33 || $auto_id3 == 34 || $auto_id3 == 35)
{
$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_sub_account_fetch2'),array('pass'=>array($auto_id3)));
foreach($result3 as $collection)
{
$auto_id4 = (int)$collection['ledger_sub_account']['auto_id'];
$sub_ledger_name = $collection['ledger_sub_account']['name'];

$result4 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch'),array('pass'=>array($auto_id4)));
foreach($result4 as $collection)
{
$amount_type = (int)$collection['ledger']['amount_category_id'];
$amount = (int)$collection['ledger']['amount'];
if($amount_type == 1)
{
$total_debit = $total_debit + $amount;
}
else if($amount_type == 2)
{
$total_credit = $total_credit + $amount;
}
}
}
}
else 
{
$result4 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_fetch3'),array('pass'=>array($auto_id3)));
foreach($result4 as $collection)
{
$amount_type = (int)$collection['ledger']['amount_category_id'];
$amount = (int)$collection['ledger']['amount'];
if($amount_type == 1)
{
$total_debit = $total_debit + $amount;
}
else if($amount_type == 2)
{
$total_credit = $total_credit + $amount;
}
}
}
}
}
?>
<tr>
<td style="text-align:left;"><?php echo $category_name; ?></td>
<td style="text-align:center;"><?php echo $total_debit; ?></td>
<td style="text-align:center;"><?php echo $total_credit; ?></td>
</tr>
<?php
}
?>


</table>