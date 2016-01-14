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

<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?>
<center>
<div class="hide_at_print">
<form method="post" id="contact-form">
<table>
<tbody><tr>
<td><input type="text" class="date-picker m-wrap medium" id="date1" data-date-format="dd-mm-yyyy" name="from" placeholder="From" 
style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
<td><input type="text" class="date-picker  m-wrap medium" id="date2" data-date-format="dd-mm-yyyy" 
name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
<td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
</tr>
</tbody></table>
</form>
</div>
</center>





<center>
<div id="result" style="width:100%;">
</div>
</center> 




<script>
$(document).ready(function() {
$("#go").bind('click',function(){
var date1=document.getElementById('date1').value;
var date2=document.getElementById('date2').value;
if((date1=='')) { alert('Please Input Date-from'); }
if((date2=='')) { alert('Please Input Date-to'); }
else
{
$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path;?>as/loding.gif" />Loading....</div>')
.load("<?php echo $this->webroot; ?>
Accounts/cash_book_report_show_ajax?date1=" +date1+ "&date2=" +date2+ "");
}
});
});
</script>

