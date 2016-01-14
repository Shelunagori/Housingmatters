<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>  
        <div class="hide_at_print">  
		<center>
		<table width="50%" border="1" bordercolor="#FFFFFF" cellpadding="0">
		<tr>
		<td style="width:25%">
		<a href="journal_view" class="btn red btn-block"  style="font-size:16px;">Journal</a>
		</td>
		<td style="width:25%">
		<a href="ledger" class="btn blue btn-block"  style="font-size:16px;">Ledger</a>
		</td>
		</tr>
		</table> 
		</center>
        </div>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<br>
<center>
<div class="hide_at_print">
<a href="journal_add" class="btn blue"> Create</a>
<a href="journal_view" class="btn red"> View</a>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?> 



 <div class="hide_at_print">
            <form method="post" id="contact-form">
            <br>
            <table>
            <tbody><tr>
            <td><input type="text" class="date-picker m-wrap medium" id="date1" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;" value="<?php echo $b_date; ?>"></td>
            <td><input type="text" class="date-picker m-wrap medium" id="date2" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;" value="<?php echo $c_date; ?>"></td>
            <td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
            </tr>
            </tbody></table>
            <br>
            </form>
            </div>
			
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

 <center>
 <div id="result" style="width:94%;">
 </div>
 </center>
 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 
<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("journal_view_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});
</script>










































