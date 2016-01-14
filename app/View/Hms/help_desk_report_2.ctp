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
if(sizeof(@$help_desk_result)==0){ $help_desk_result=array(); };
foreach ($help_desk_result as $data) 
{
$help_desk_date=$data['help_desk_date'];
$help_desk_date=date("Y-m-d",strtotime(date("d-m-y",strtotime($help_desk_date))));

$help_desk_close_date=$data['help_desk_close_date'];
$help_desk_close_date=date("Y-m-d",strtotime(date("d-m-y",strtotime($help_desk_close_date))));

$help_desk_date = strtotime($help_desk_date);
$help_desk_close_date = strtotime($help_desk_close_date);
$datediff = $help_desk_close_date - $help_desk_date;
$days[]=floor($datediff/(60*60*24));
}
if(sizeof(@$days)==0){ $days=array(); };

$total=0;
foreach ($days as $day) 
{
$total=$total+$day;
}
@$avarage=$total/sizeof($days);
?>
<br/>
<div style="background-color:#fff;padding:20px;">
<span style="font-size:18px;">Average duration of Ticket resolution is : <?php echo $avarage; ?> Days</span>
</div>