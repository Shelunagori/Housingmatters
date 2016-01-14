<div class="hide_at_print">	
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
</div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<div style="text-align:center;" class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" class="btn" rel='tab'>Bill Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_regular" class="btn yellow" rel='tab'>Regular Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_supplimentry" class="btn" rel='tab'>Supplementary Report</a>
<!--<a href="<?php //echo $webroot_path; ?>Incometrackers/income_heads_report" class="btn" rel='tab'>Income head report</a>-->
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement" class="btn" rel='tab'>Account Statement</a>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y'); 
?> 
<center>
<div class="hide_at_print">
<form method="post" id="contact-form">
<label style="background-color:white;" id="v"></label>
<div id="validate_result"></div>
<table>
<tr>
<td colspan="2" style="text-align:center;">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="1" style="opacity: 0;" onclick="wing_wise()" class="wiseq" rad="1" id="v"></span></div>
Wing Wise
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="2" style="opacity: 0;" onclick="member()" class="wiseq" rad="2" id="v"></span></div>
Member Wise
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="wise" value="2" style="opacity: 0;" onclick="bill_wise()" class="wiseq" rad="3" id="v"></span></div>
Bill Wise
</label>
</td>
</tr>
<tr>
<td colspan="2" style="text-align:center;">
<div class="hide" id="one">
<select id="wing" class="m-wrap large chosen">
<option value="" style="display:none;">Select Wing</option>
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
<select id="mem" class="m-wrap large chosen">
<option value="" style="display:none;">Select member</option>
<?php 
foreach($flats_for_bill as $flat_fetch_id){
	//wing_id via flat_id//
	$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_fetch_id)));
	foreach($result_flat_info as $flat_info){
	$wing=$flat_info["flat"]["wing_id"];
	} 
	//user info via flat_id//
			$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing,$flat_fetch_id)));
			foreach($result_user_info as $user_info){
				$user_id=(int)$user_info["user"]["user_id"];
				$user_name=$user_info["user"]["user_name"];
			} 
				
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>			array($wing,$flat_fetch_id)));	


?>
<option value="<?php echo $flat_fetch_id; ?>"><?php echo $user_name; ?> <?php echo $wing_flat; ?></option>
<?php } ?>
</select>
</div>
<div class="hide" id="third">
<select id="bill" class="m-wrap large chosen">
<option value="" style="display:none;">Select Bill Number</option>
<?php 
foreach($cursor1 as $collection)
{
$flat_id = (int)$collection['new_regular_bill']['flat_id'];	
$bill_number = $collection['new_regular_bill']['bill_no'];	
?>
<option value="<?php echo $bill_number; ?>"><?php echo $bill_number; ?></option>
<?php } ?>
</select>
</div>
</td>
</tr>
<tr>
<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
</tr>
</table>
</form>
</div>
</center>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 
<center>
<div id="result" style="width:100%;">
</div>
</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 
				
<script>
$(document).ready(function() {
$("#go").bind('click',function(){
var date1=document.getElementById('date1').value;
if(date1 === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill Date</div>'); return false; }

var date2=document.getElementById('date2').value;
if(date2 === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill Date</div>'); return false; }
var wise = $(".wiseq:checked").attr("rad");

if(wise === undefined) {
$('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Select Wing Wise , Member Wise or Bill Wise </div>'); return false; }

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
else if(wise == 3)
{
var bill = $("#bill").val();
if(bill === '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Select Bill Number </div>'); return false; }
}
$('#validate_result').html('<div></div>');

if(wise == 1)
{
$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("regular_report_show_ajax?date1=" +date1+ "&date2=" +date2+ "&wise=" +wise+ "&wing=" +wing+ "");
}
else if(wise == 2)
{
$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("regular_report_show_ajax?date1=" +date1+ "&date2=" +date2+ "&wise=" +wise+ "&user=" +user_id+ "");
}
else if(wise == 3)
{
$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("regular_report_show_ajax?&wise=" +wise+ "&user=" +bill+ "");	
}
});
});
</script>	
     	
<script>
function wing_wise()
{
$("#date1").removeAttr('disabled');	
$("#date2").removeAttr('disabled');	
	
$("#one").show();	
$("#two").hide();
$("#third").hide();		
}
function member()
{
$("#date1").removeAttr('disabled');	
$("#date2").removeAttr('disabled');	
$("#one").hide();	
$("#two").show();
$("#third").hide();	
}
function bill_wise()
{
$("#date1").attr('disabled','disabled');
$("#date2").attr('disabled','disabled');
	
$("#one").hide();	
$("#two").hide();	
$("#third").show();	
}
</script>


	      
		
		
	












