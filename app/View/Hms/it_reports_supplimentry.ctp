<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>		
        <div class="hide_at_print">
		<table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
		<tr>
		<td style="width:25%">
		<a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
		</td>
		<td style="width:25%">
		<a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
		</td>
		<td style="width:25%">
		<a href="in_head_report" class="btn red btn-block"  style="font-size:16px;">Reports</a>
		</td>
		<td style="width:25%">
		<a href="select_income_heads" class="btn blue btn-block"  style="font-size:16px;">Accounting Setup</a>
		</td>
		</tr>
		</table>
        </div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<div style="text-align:center;" class="hide_at_print">
<a href="in_head_report" class="btn">bill Report</a>
<a href="it_reports_regular" class="btn ">Regular</a>
<a href="it_reports_supplimentry" class="btn yellow">Supplementary</a>
<a href="income_heads_report" class="btn ">Income head report</a>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
 <?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?>

<center>
<div class="hide_at_print">
<form method="post" id="contact-form">
<br>
<table>
<tbody>
<!--<tr>
<td colspan="3" style="text-align:center;">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="1" style="opacity: 0;" onclick="wing_wise()"></span></div>
Wing Wise
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="2" style="opacity: 0;" onclick="member()"></span></div>
Member Wise
</label>
</td>
</tr>
<tr>
<td colspan="3" style="text-align:center;">
<br />
<div id="one" class="hide">
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
<div id="two" class="hide">
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
-->
<tr>
<td>
<select name="type" id="tp" class="m-wrap medium">
<option value="" style="display:none;">Select</option>
<option value="1">All</option>
<option value="2">Residential</option>
<option value="3">Non-residential</option>
</select>
</td>
<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>

<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
</tr>
</tbody></table>
</br>
</form>
</div>
</center>
	
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>    
   <center>
   <div id="result" style="width:94%;">
   </div>
   </center>
    
    
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>    
    	<!--<div align="right">
		<a href="report_excel" class="btn " target="_new" style="margin-right:5%" > <img src="as/Download-icon.png"></a>
		</div>
		<div class="controls" style="padding-left:10px;">
		<label class="radio">Short By</label>
		<label class="radio">
		<div class="radio" id="uniform-undefined">
		<span><input type="radio" onClick="show_record(1)" checked name="optionsRadios1" value="option1" style="opacity: 0;"></span>
		</div>All
		</label>
		<label class="radio">
		<div class="radio" id="uniform-undefined">
		<span><input type="radio" onClick="show_record(2)" name="optionsRadios1" value="option1" style="opacity: 0;"></span>
		</div>Residential
		</label>
		<label class="radio">
		<div class="radio" id="uniform-undefined">
		<span><input type="radio" onClick="show_record(3)" name="optionsRadios1" value="option1" style="opacity: 0;"></span>
		</div>Non-residential
		</label>
		</div>  -->
		
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		

		
							

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		var tp=document.getElementById('tp').value; 
		
		if((tp=='')) { alert('Please Select Bill Type'); }
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("supplimentry_reports_show_ajax?date1=" +date1+ "&date2=" +date2+ "&tp=" +tp+ "");
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
