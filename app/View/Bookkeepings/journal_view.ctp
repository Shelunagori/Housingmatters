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
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>  
<center>
<div class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Bookkeepings/journal_add" class="btn" rel='tab'> Create</a>
<a href="<?php echo $webroot_path; ?>Bookkeepings/journal_view" class="btn yellow" rel='tab'> View</a>
</div>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?> 


 <div class="hide_at_print">
            <form method="post" id="contact-form">
           
            <table>
            <tbody><tr>
			<!--<td valign="top">
				<select class=" m-wrap chosen" id="select_voucher" >
				<option value="">--SELECT Journal Voucher--</option>
					<?php foreach($result_journal as $data){
						$voucher_id=$data;
						
						?>
				<option value="<?php echo $voucher_id; ?>"><?php echo $voucher_id; ?></option> 
					<?php } ?>
				</select>
			</td>-->
            <td><input type="text" class="date-picker m-wrap medium" id="date1" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
            <td><input type="text" class="date-picker m-wrap medium" id="date2" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
            <td valign="top"><button type="button" name="sub" class="btn blue" id="go"><i class="m-icon-swapright m-icon-white"></i></button></td>
            </tr>
            </tbody></table>
            </form>
            </div>
</center>			
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

 
 <div id="result" style="width:100%;">
 </div>
 
 
 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 
<script>
$(document).ready(function() {
	$("#go").bind('click',function(){
		
		//var select_voucher=$("#select_voucher").val();
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("journal_view_ajax/"+1+"/" +date1+ "/" + date2);
		}
		
	});
	
});
</script>
<script>
function paginttion(ii)
{
var date1=document.getElementById('date1').value;
var date2=document.getElementById('date2').value;	
if((date1=='')) { alert('Please Input Date-from'); }
if((date2=='')) { alert('Please Input Date-to'); }
else
{
$("#result").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("journal_view_ajax/"+ii+"/" +date1+ "/" + date2);	
}
}
</script>
<!--
<script>
$(document).ready(function() {
	
		 $('#search_content').live('keyup',function() {
			 
			 var date1=document.getElementById('date1').value;
			 var date2=document.getElementById('date2').value;
			 var ser=$(this).val();
			 ser=encodeURIComponent(ser);
			$("#tbb").html('<div align="center" style="padding:10px;"><img src="<?php echo $webroot_path; ?>as/loding.gif" />Loading....</div>').load("journal_view_ajax_show_vocher?date1=" +date1+ "&date2=" +date2+ "&search=" +ser+""); 
			
		});
	
});

</script> -->



			
<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('journll');
if($status5==1)
{
?>
$.gritter.add({
title: 'Journal',
text: '<p>Thank you.</p><p>Journals generated successfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(1601)));
} ?>
});
</script>           
            



































