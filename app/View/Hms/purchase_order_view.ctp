<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$st_dat = date('1-m-Y');
$cu_dat = date('d-m-Y');
?>
<br />
<center>
<table border="0">
<tr>
<td>
<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="date1" id="date1" style="background-color:white !important;" value="<?php echo $st_dat; ?>">
</td>
<td>
<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="date2" id="date2" style="background-color:white !important;" value="<?php echo $cu_dat; ?>">
</td>
<td>
<button id="go" class="btn yellow" style="margin-bottom:11px;">GO</button>
</td>
</tr>
</table>








</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<div style="width:100%;" id="show"></div>




<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
$("#go").live('click',function(){
var date1=document.getElementById('date1').value;
var date2=document.getElementById('date2').value;

$("#show").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("purchase_order_show_ajax?date1=" +date1+ "&date2=" +date2+ "");

});
});
</script>

