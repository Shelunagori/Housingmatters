<?php
$from = date('1-m-Y');
$to = date('d-m-Y');
?>
<center>
<h3 class="hide_at_print"><b>Over Due Report</b></h3>
</center>
<br>
<center>
<div id="validate_result"></div>
<div class="hide_at_print">
<table border="0">
<tr>
<td colspan="2" style="text-align:center;">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="1" style="opacity: 0;" onclick="wing_wise()" class="wise"></span></div>
Wing Wise
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="2" style="opacity: 0;" onclick="member()" class="wise"></span></div>
Member Wise
</label>

</td>
</tr>
<tr>
<td colspan="2" style="text-align:center;">
<br />
<div class="hide" id="one">
<select id="wing" class="m-wrap medium">
<option value="">--SELECT WING--</option>
<?php
foreach($cursor2 as $collection)
{
$wing_id = (int)$collection['wing']['wing_id'];	
$wing_name = $collection['wing']['wing_name'];	
?>
<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
<?php } ?>
</select>
</div>
<div class="hide" id="two">
<select id="mem" class="m-wrap medium">
<option value="">--SELECT MEMBER--</option>
<?php
foreach($cursor3 as $collection)
{
$user_id = (int)$collection['user']['user_id'];
$user_name = $collection['user']['user_name'];	
?>
<option value="<?php echo $user_id; ?>"><?php echo $user_name; ?></option>
<?php } ?>
</select>
</div>
</td>
</tr>
<tr>
<!--<td>
<select name="flat" id="flat" class="m-wrap medium chosen">
<option value="" style="display:none;">Select Flat</option>
<?php
foreach($cursor1 as $collection)
{
$flat_id = (int)$collection['user']['flat'];

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch'),array('pass'=>array($flat_id)));
foreach($result1 as $collection)
{
$flat_name = $collection['flat']['flat_number'];	
}
//$flat_name = $collection['user']['flat_name'];
?>
<option value="<?php echo $flat_id; ?>"><?php echo $flat_name; ?></option>
<?php
}
?>
</select>
</td>-->
<td>
<input type="text" placeholder="From Date" id="date1" style="margin-top:8px; background-color:white !important;" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" value="<?php echo $from; ?>">
</td>
<td> 
<input type="text" placeholder="To Date" id="date2" style="margin-top:8px; background-color:white !important;" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" value="<?php echo $to; ?>">
</td>

<td><button class="btn yellow" id="go" style="margin-bottom:2px;">Go</button></td>

</tr>
</table>
</div>
</center>







<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<div id="result" style="width:96%;"></div>
</center>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		
var date1=document.getElementById('date1').value;
if(date1 === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill Date</div>'); return false; }
		
var date2=document.getElementById('date2').value;
if(date2 === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill Date</div>'); return false; }

var wise = $(".wise:checked").attr("value");
if(wise === undefined) { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Select Wing wise of Member wise</div>'); return false; }		

		if(wise == 1)
		{
		var wing = $("#wing").val();
		if(wing === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Select Wing </div>'); return false; }
		}
		else if(wise == 2)
		{
		var user_id = $("#mem").val();
		if(user_id === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Select Member </div>'); return false; }
		}
		
$('#validate_result').html('<div></div>');		
		
		if(wise == 1)
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("over_due_report_show_ajax?date1=" +date1+ "&date2=" +date2+ "&w=" +wise+ "&wi=" +wing+ "");
		}
		else if(wise == 2)
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("over_due_report_show_ajax?date1=" +date1+ "&date2=" +date2+ "&w=" +wise+ "&u=" +user_id+ "");	
		}
		
	});
	
});
</script>		

<script>
function wing_wise()
{
$("#one").show();
$("#two").hide();	
}
function member()
{
$("#one").hide();
$("#two").show();		
}
</script>











