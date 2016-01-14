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
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<?php
$showing_from_date = date('1-m-Y');
$showing_to_date = date('d-m-Y');

?>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<div style="text-align:center;" class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" class="btn" rel='tab'>Bill Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_regular" class="btn" rel='tab'>Regular Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_supplimentry" class="btn" rel='tab'>Supplementary Report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/income_heads_report" class="btn yellow" rel='tab'>Income head report</a>
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement" class="btn" rel='tab'>Account Statement</a>
</div>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style=" margin-top:5px;" align="center" class="hide_at_print">
<table>
<tr>
<td><input type="text" class="span12 m-wrap date-picker" style="background-color:#FFF !important;" placeholder="From" id="date1" data-date-format="dd-mm-yyyy" value="<?php echo $showing_from_date; ?>"></td>
<td><input type="text" class="span12 m-wrap date-picker" style="background-color:#FFF !important;" placeholder="To" id="date2" data-date-format="dd-mm-yyyy" value="<?php echo $showing_to_date; ?>"></td>
<td valign="top"><button type="button" class="btn yellow" id="go">Go</button></td>
</tr>
</table>
</div>      
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
		<center>
		<div id="result" style="width:100%; overflow-x:scroll;">
		</div>
        </center>   								
<?php /////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").bind('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loding....</div>').load("income_heads_report_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});
</script>								
									
								
									
									
									
									
							