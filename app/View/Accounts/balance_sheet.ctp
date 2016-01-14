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

<div align="center" class="hide_at_print">
	
	<input type="text" id="from" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="To"  value="" style="background-color:#FFF !important;">
	<a href="#" style="margin-bottom: 12px;" role="button" class="btn blue icn-only" id="go"><i class="m-icon-swapright m-icon-white"></i></a>
</div>


<div id="result"></div>



<script>
$(document).ready(function() {
	$("#go").bind('click',function(){
		
		var from=document.getElementById('from').value;
		
		$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("balance_sheet_ajax/"+from);
		
	});
});
</script>	