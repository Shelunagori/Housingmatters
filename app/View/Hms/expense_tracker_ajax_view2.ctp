<?php
/////////////////////////////////////////////////////////////////////////
foreach($cursor3 as $collection)
{
$expense_date_mongo = $collection['expense_tracker']['posting_date'];
$expense_date = date('d-m-Y',$expense_date_mongo->sec);
$expense_date_explode = explode("-",$expense_date);
$expense_month = $expense_date_explode[1];
$expense_month_arr[] = $expense_month;
}

////////////////////////////////////////////////////////////////////////////

$fr = explode("-",$from);
$tr = explode("-",$to);
$f = (int)$fr[1];
$t = (int)$tr[1];

for($k=$f; $k<=$t; $k++)
{
for($p=0; $p<sizeof($expense_month_arr); $p++)
{	
$expense_month2 = (int)$expense_month_arr[$p];	
if($expense_month2 == $k)
{
if($k == 1)
{
$month_name = "Jan";	
}
if($k == 2)
{
$month_name = "Feb";		
}
if($k == 3)
{
$month_name = "Mar";	
}
if($k == 4)
{
$month_name = "Apr";	
}
if($k == 5)
{
$month_name = "May";	
}
if($k == 6)
{
$month_name = "Jun";	
}
if($k == 7)
{
$month_name = "Jul";	
}
if($k == 8)
{
$month_name = "Aug";	
}
if($k == 9)
{
$month_name = "Sep";	
}
if($k == 10)
{
$month_name = "Oct";	
}
if($k == 11)
{
$month_name = "Nov";	
}
if($k == 12)
{
$month_name = "Dec";	
}
$month_arr[] = $month_name;
}
}
}
$month_unic_array = array_unique($month_arr);
//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<table class="table table-bordered" style="background-color:white;">
<tr>
<th>Expense Head</th>
<?php
for($p=0; $p<sizeof($month_unic_array); $p++)
{
$month_name2 = $month_unic_array[$p];
?>
<th style="text-align:center;">
<?php echo $month_name2; ?>
</th>
<?php } ?>
</tr>

<?php
foreach($cursor2 as $collection)
{
$group_id = (int)$collection['accounts_group']['auto_id'];	

$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch'),array('pass'=>array($group_id)));
foreach($result2 as $collection2)
{
$expense_head = $collection2['ledger_account']['ledger_name'];
?>
<tr>
<th style="text-align:left;">
<?php echo $expense_head;  ?>
</th>
<?php
for($p2=0; $p2<sizeof($month_unic_array); $p2++)
{
?>
<th style="text-align:center;">
jbfdsbfbsb
</th>
<?php
}
?>
</tr>
<?php
}}
?>
</table>


