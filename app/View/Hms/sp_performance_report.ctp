

 <div style=" "align="center" class='hide_at_print'>
            <form method="post" id="contact-form">
            <br>
            <table>
            <tbody><tr>
            <td><input type="text" class="date-picker m-wrap medium" id="date1" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value=""></td>
            <td><input type="text" class="date-picker m-wrap medium" id="date2" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value=""></td>
            <td valign="top"><button type="submit" name="sub" class="btn blue" >Go</button></td>
            </tr>
            </tbody></table>
            <br>
            </form>
    </div>

<div style="" id="result_id">
<div>
<div style="float:right;">
<a class="btn blue hide_at_print" onclick="window.print();">Print </a>

<a href="sp_performance_report_pdf?con=<?php echo@$date1;?>&con2=<?php echo@$date2;?>" class="btn blue hide_at_print" >Pdf </a>

</div>
<br/><br/>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;"><i class="icon-cloud"></i>
Service Provider Performance Report
</div>

<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="">
<thead>
<tr>
<th>Sr No.</th>
<th>Ticket</th>
<th>Service Provider</th>
<th>Assigned Date</th>
<th>Closure Date</th>
<th>Number of Days</th>
</tr>
</thead>
<tbody>
<?php
$i=0;
if(!empty($result_help_desk))
{
foreach($result_help_desk as $data)
{
 $avg='';
$assign_date=$data['help_desk']['help_desk_assign_date'];
$help_desk_date=$data['help_desk']['help_desk_date'];
$close_date=@$data['help_desk']['help_desk_close_date'];
$sp_id=$data['help_desk']['help_desk_service_provider_id'];
$ticket_id=$data['help_desk']['ticket_id'];

 $help_desk_date1=date("d-m-y", strtotime($help_desk_date));
 $help_desk_date2 = date("Y-m-d", strtotime($help_desk_date1));
 $help_desk_date3 = date("d-m-Y", strtotime($help_desk_date2));

if(!empty($assign_date) && !empty($close_date))
{
$newDate = date("d-m-y", strtotime($assign_date));
$newDate1 = date("Y-m-d", strtotime($newDate));
$newDate2 = date("d-m-y", strtotime($close_date));
$newDate3 = date("Y-m-d", strtotime($newDate2));
$datetime1 = date_create($newDate1);
$datetime2 = date_create($newDate3);
$interval = date_diff($datetime1, $datetime2);
$avg= $interval->format('%R%a days');

}
$sp= $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_service_provider_info_via_vendor_id'),array('pass'=>array($sp_id)));
foreach($sp as $data)
{
 $sp_name=$data['service_provider']['sp_name'];
}
if(strtotime($date1)<=strtotime($help_desk_date3) && strtotime($date2)>=strtotime($help_desk_date3))
{
$i++;

?>
<tr class="odd gradeX" >
<td><?php echo $i; ?> </td>
<td><?php echo $ticket_id; ?></td>
<td><?php echo $sp_name; ?></td>
<td><?php echo $assign_date ; ?></td>
<td><?php echo $close_date; ?></td>
<td><?php echo $avg; ?></td>
</tr>
<?php } } } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>



<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result_id").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("sp_performance_report_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});
</script>
