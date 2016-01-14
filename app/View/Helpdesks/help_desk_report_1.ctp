<?php 
function check_in_range($d1, $d2, $help_desk_date)
	{
	  // Convert to timestamp
	  $d1 = strtotime($d1);
	  $d2 = strtotime($d2);
	  $help_desk_date = strtotime($help_desk_date);

	  // Check that user date is between start & end
	  return (($help_desk_date >= $d1) && ($help_desk_date <= $d2));
	}
	
foreach ($result_help_desk_report1 as $collection) 
{
$help_desk_date=$collection['help_desk']['help_desk_date'];
$help_desk_date=date("Y-m-d",strtotime(date("d-m-y",strtotime($help_desk_date))));
	
	if(check_in_range($d1, $d2, $help_desk_date)==1)
	{
	$help_desk_result[]=$collection['help_desk'];
	}
}


$open=0;
$open_and_assigned=0;
$closed=0;
if(sizeof(@$help_desk_result)==0){ $help_desk_result=array(); };
foreach ($help_desk_result as $data) 
{
if($data['help_desk_status']==0 && $data['help_desk_service_provider_id']==0) { $open++;}
if($data['help_desk_status']==0 && $data['help_desk_service_provider_id']!=0) { $open_and_assigned++;}
if($data['help_desk_status']==1) { $closed++;}
}

@$open_per=($open*100)/sizeof($help_desk_result);
@$open_and_assigned_per=($open_and_assigned*100)/sizeof($help_desk_result);
@$closed_per=($closed*100)/sizeof($help_desk_result);
?>

<div style="background-color:#fff;padding:20px;">
<table width="100%"  >
<tr>
<td width="33%" align="center">
<span style="font-size:40px;color:#d43f3a;"><?php echo $open; ?></span><br/>
<span style="font-size:14px;color:#d43f3a;">Open Tickets</span>
</td>
<td width="33%" align="center" >
<span style="font-size:40px;color:#eea236;"><?php echo $open_and_assigned; ?></span><br/>
<span style="font-size:14px;color:#eea236;">Open and assigned Tickets</span>
</td>
<td width="33%" align="center">
<span style="font-size:40px;color:#4cae4c;"><?php echo $closed; ?></span><br/>
<span style="font-size:14px;color:#4cae4c;">Closed Tickets</span>
</td>
</tr>



<td colspan="3"><br/></td>
</tr>
<tr>
<td width="33%" align="center">
<span style="font-size:40px;color:#d43f3a;"><?php echo $open_per.'%'; ?></span><br/>
<span style="font-size:14px;color:#d43f3a;">Open Tickets</span>
</td>
<td width="33%" align="center" >
<span style="font-size:40px;color:#eea236;"><?php echo $open_and_assigned_per.'%'; ?></span><br/>
<span style="font-size:14px;color:#eea236;">Open and assigned Tickets</span>
</td>
<td width="33%" align="center">
<span style="font-size:40px;color:#4cae4c;"><?php echo $closed_per.'%'; ?></span><br/>
<span style="font-size:14px;color:#4cae4c;">Closed Tickets</span>
</td>
</tr>

<tr>
<td colspan="3"><br/>
<span style="font-size:24px;">Total Tickets : <?php echo sizeof($help_desk_result); ?></span>
</td>
</tr>
</table>
</div>