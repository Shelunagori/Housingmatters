<?php
$date1 = date("Y-m-d", strtotime($from));
$date1 = new MongoDate(strtotime($date1));

$date2 = date("Y-m-d", strtotime($to));
$date2 = new MongoDate(strtotime($date2)); 
$c=0;
foreach($cursor1 as $collection)
{
$c++;
}
$cols = 5 + $c;
?>

<div style="width:100%;" class="hide_at_print">
<span style="margin-left:80%;">
<a href="income_head_report_excel?f=<?php echo $from; ?>&t=<?php echo $to; ?>" class="btn blue">Export in Excel</a>
<button type="button" class=" printt btn green" onclick="window.print()"><i class="icon-print"></i> Print</button></span>
</div>
<br />

           
		    <table class="table table-bordered" style="background-color:white; width:100%;">
            <thead>
            <tr>
            <th colspan="<?php echo $cols; ?>" style="text-align:center;">
            <p style="font-size:16px;">
            Income Head Report (<?php echo $society_name; ?>  <?php echo $from; ?> - <?php echo $to; ?>)
            </p>
            </th>
            </tr>
            <tr>
            <th>Bill No.</th>
            <th style="width:6%;">Flat No.</th>
            <th style="width:10%;">Name of Resident</th>
			<?php
			foreach($cursor1 as $collection)
			{
			$g_t[] = 0;
			$income_heads_name = $collection['income_head']['ih_name'];
			?>
			<th><?php echo $income_heads_name; ?></th>
			<?php } ?>
            <th>Non Occupancy charges</th>
			<th>Total</th>
			</tr>
			</thead>
          
<?php
$total_noc = 0;
$fetch_ih22 = $this->requestAction(array('controller' => 'hms', 'action' => 'regular_bill_fetch3'),array('pass'=>array($date1,$date2)));
$grand_total = 0;
foreach($fetch_ih22 as $collection2)
{
$bill_no = (int)$collection2['regular_bill']['receipt_id'];	
$ih_det = $collection2['regular_bill']['ih_detail'];
$user_id = (int)$collection2['regular_bill']['bill_for_user'];



$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($user_id)));
foreach($result_user as $collection3)
{
$user_id = (int)$collection3['user']['user_id'];   
$wing=@$collection3['user']["wing"];
$flat=$collection3['user']["flat"];
$user_name = $collection3['user']['user_name'];
}
$result2 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch'),array('pass'=>array($flat)));
foreach($result2 as $collection)
{
$flat_type_id = $collection['flat']['flat_type_id'];
$flat_master_id = $collection['flat']['flat_master_id'];
}
$result3 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_master_fetch'),array('pass'=>array($flat_master_id)));
foreach($result3 as $collection)
{
$sq_feet = $collection['flat_master']['flat_area'];
}
$result4 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_fetch'),array('pass'=>array($flat_type_id)));
foreach($result4 as $collection)
{
$charge_id = @$collection['flat_type']['charge'];	
}
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
foreach ($result as $collection) 
{
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));	

?>
<tr>
<td><?php echo $bill_no; ?></td>			
<td><?php echo $wing_flat; ?></td>				
<td><?php echo $user_name; ?></td>
<?php
$total = 0;
$p=0;
foreach($cursor1 as $collection)
{
$ih_id1 = (int)$collection['income_head']['auto_id'];
$amt = 0;
for($i=0; $i<sizeof($ih_det); $i++)
{
$ih_det2 = $ih_det[$i];
$ih_id2 = (int)$ih_det2[0];
$rate = $ih_det2[1];
if($ih_id1 == $ih_id2)
{
$amt = $rate;
}
}
$amt = number_format($amt);
?>
<td><?php echo $amt;  ?></td>
<?php
$total = $total + $amt;
$g_t[$p] = $g_t[$p]+$amt;
$p++;
} 
$abc = 5;
for($l=0; $l<sizeof($ih_det); $l++)
{
$ih_det3 = $ih_det[$l];
$ih_id3 = (int)$ih_det3[0];
$rate3 = $ih_det3[1];
if($ih_id3 == 43)
{
$abc = 55;
$rate3 = number_format($rate3);
?>
<td><?php echo $rate3; ?></td>
<?php
$total = $total + $rate3;
$total_noc = $total_noc +$rate3;
}
}
if($abc == 5)
{
?>
<td><?php echo "0";  ?></td>	
<?php
}

$grand_total = $grand_total + $total;
$total = number_format($total);
?>
<td><?php echo $total; ?></td>
</tr>
<?php
}
?>
<tr>
<th colspan="3">Grand Total</th>
<?php
for($k=0; $k<sizeof($g_t); $k++)
{
$g_amt = $g_t[$k];
$g_amt = number_format($g_amt);
?>
<th><?php echo $g_amt; ?></th>
<?php } ?>
<th><?php 
$total_noc = number_format($total_noc);
echo $total_noc; ?></th>
<th><?php 
$grand_total = number_format($grand_total);
echo $grand_total; ?></th>
</tr>
</tbody>
</table>		
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			