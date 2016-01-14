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
<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>		
   
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<div style="text-align:center;" class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" class="btn" rel='tab'>Regular Bill Report</a>
<!--<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_regular" class="btn" rel='tab'>Regular Report</a>-->
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_supplimentry" class="btn yellow" rel='tab'>Supplementary Bill Report</a>
<!--<a href="<?php //echo $webroot_path; ?>Incometrackers/income_heads_report" class="btn" rel='tab'>Income head report</a>-->
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement" class="btn" rel='tab'>Account Statement</a>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
 <?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?>
<center>
<div class="hide_at_print">
<form method="post" id="contact-form">
<table>
<tr>
<td>
<select name="type" id="tp" class="m-wrap medium chosen">
<option value="" style="display:none;">Select</option>
<option value="1">All</option>
<option value="2">Residential</option>
<option value="3">Non-residential</option>
</select>
</td>
<td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important; margin-top:8px;" value="<?php echo $b_date; ?>">
</td>
<td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important; margin-top:8px;" value="<?php echo $c_date; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go" style="margin-top:8px;">Go</button></td>
</tr>
</tbody></table>
<div id="validate_result"></div>
</form>
</div>
</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>    
<center>
<div id="result" style="width:100%;">
</div>
</center>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<script>
$(document).ready(function() {
$("#go").bind('click',function(){
var date1=document.getElementById('date1').value;
var date2=document.getElementById('date2').value;
var tp=document.getElementById('tp').value; 

if(tp === "") {
$('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Select an Option</div>'); return false; }
else
{
$('#validate_result').html('<div> </div>'); 	
}





$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("supplimentry_reports_show_ajax?date1=" +date1+ "&date2=" +date2+ "&tp=" +tp+ "");

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
