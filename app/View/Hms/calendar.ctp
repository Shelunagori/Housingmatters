<style>
.day_head{
background-color:#44b6ae;
font-size:16px;
color:#fff;
padding:5px;
}

.btn_next{
background-color:#44b6ae;
color:#fff;
}
.btn_next:hover{
background-color:#469B95;
color:#fff;
}
.have_event{
height: 70px;background-color: #44b6ae;color: #fff;font-size: 24px;
}
.have_event:hover{
height: 70px;background-color: #44b6ae;color: #fff;font-size: 24px;
}
</style>

<?php
$date = new DateTime($year.'-'.$month.'-1');

$date->modify('+1 month');
$nxt=$date->format('m-Y') . "\n";

$date = new DateTime($year.'-'.$month.'-1');

$date->modify('-1 month');
$prv=$date->format('m-Y') . "\n";


?>
<table width="100%">
<tr style="background-color: #44b6ae;">
<td><a href="#"  class="btn btn_next icn-only next" role='button' result="<?php echo $prv; ?>"><i class="icon-chevron-left"></i></a></td>
<td colspan="5" align="center" style="font-size: 22px;color: #fff;"><?php echo $month_name.'-'.$year; ?></td>
<td align="right"><a href="#" role='button'  result="<?php echo $nxt; ?>" class="btn btn_next icn-only next"><i class=" icon-chevron-right"></i></a></td>
</tr>

<tr align="center">
	<td><div class="day_head">Mon</div></td>
	<td><div class="day_head">Tue</div></td>
	<td><div class="day_head">Wed</div></td>
	<td><div class="day_head">Thu</div></td>
	<td><div class="day_head">Fri</div></td>
	<td><div class="day_head">Sat</div></td>
	<td><div class="day_head">Sun</div></td>  	
</tr>

<tr>
<?php


$f_date = strtotime($year . "-" . $month . "-" . (1));
$f_day=strftime("%a", $f_date);
if($f_day=='Mon') { $minus_day=0; }
if($f_day=='Tue') { $minus_day=1; }
if($f_day=='Wed') { $minus_day=2; }
if($f_day=='Thu') { $minus_day=3; }
if($f_day=='Fri') { $minus_day=4; }
if($f_day=='Sat') { $minus_day=5; }
if($f_day=='Sun') { $minus_day=6; }

for($b=1;$b<=$minus_day;$b++)
{
echo '<td><a  style="height: 70px;background-color: #C3C3C3;" class="btn btn-block disabled"></a></td>';
}
$num_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$carry_event=array();
for($i=1;$i<=$num_of_days;$i++)
{
$e_date=$year.'-'.$month.'-'.$i;
$e_date = strtotime($e_date);

	foreach($event_info as $data)
	{
	
	$from = strtotime($data[2]);
	$to = strtotime($data[3]);
	
	if(($e_date >= $from) && ($e_date <= $to)) {
	$e_id=$data[0];
	$carry_event[$i][]=array($e_id,$data[1]);	
	}
  
	
	
	}
	
	
	if(sizeof($carry_event)>0)
	{
	echo '<td>
	<div class="btn-group" style="width:100%;">
		<a style="height: 70px;background-color: #44b6ae;color: #fff;font-size: 24px;" class="btn btn-block dropdown-toggle" data-toggle="dropdown">'.$i.'</a>
		<ul class="dropdown-menu">';
	 foreach($carry_event[$i] as $event) {
	
		echo '<li><a href=event_info/'.$event[0].'>'.$event[1].'</a></li>';
	 } 
	echo '</ul>
	</div>
	</td>';
	}
	if(sizeof($carry_event)==0)
	{
	echo '<td><a  style="height: 70px;background-color: #F5FFFE;color: #44b6ae;font-size: 24px;" class="btn btn-block disabled">'.$i.'</a></td>';
	}
	$carry_event=array();
	

if(($i+$minus_day)%7==0) { echo '</tr><tr>'; }
}

$rest=7-(($minus_day+$num_of_days)%7);
if($rest<7)
{
for($r=1;$r<=$rest;$r++)
{
echo '<td><a  class="btn btn-block disabled" style="height: 70px;"></a></td>';
}
}

?>
	
</table>

<?php
$month=11;
$year=2014;
$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $today = strtotime(date("Y-m-d")); 
	
    for ($i = 1; $i <= $num; $i++)
    {
        $date = strtotime($year . "-" . $month . "-" . ($i));
        if ($today === $date)
        {
            //echo ("!!");
        }
        $day=strftime("%a", $date);
         (($i) . " " . $day . "<BR>");
		
		
		
		
    }
?>
