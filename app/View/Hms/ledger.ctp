
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////?>		
		<center>
		<div class="hide_at_print">
		<table width="50%" border="1" bordercolor="#FFFFFF" cellpadding="0">
		<tr>
		<td style="width:25%">
		<a href="journal_view" class="btn blue btn-block"  style="font-size:16px;">Journal</a>
		</td>
		<td style="width:25%">
		<a href="ledger" class="btn red btn-block"  style="font-size:16px;">Ledger</a>
		</td>
		</tr>
		</table>
        </div>		
		</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
 <center>
                <form method="post" onSubmit="return valid()">
                <div id="validate_result"></div>
				<div  class="hide_at_print">
                <br>
				<table style="width:60%;">
                <tr>
                <td>
                
                <select class="medium m-wrap chosen" tabindex="1" name="type" id="main_id">
                <option value="">Select Ledger Type</option>
                <?php
                foreach ($cursor1 as $collection) 
				{
				$auto_id = (int)$collection['ledger_account']['auto_id'];
                $name = $collection['ledger_account']['ledger_name'];
				?>
                <option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
                </select>
                
                </td>
               
               
                <td id="result1">
                <select class="medium m-wrap" tabindex="1" name="user_name" id="sub_id">
                <option value="0">Sub Ledger</option>
                </select>
                </td>
               
               
                <td>
                <input type="text" placeholder="From Date" id="date1" style="height:77%;" class="date-picker medium" data-date-format="dd-mm-yyyy" name="from">
                </td>
                
                
                <td>
                <input type="text" placeholder="To Date" id="date2" style="height:77%;" class="date-picker medium" data-date-format="dd-mm-yyyy" name="to">
                </td>
                
                
                <td valign="top">
                <button type="button" id="go" name="sub" class="btn yellow">Search</button>
                </td>
                
                
                </tr>
                </table>
                <br>
				</div>	 
                </form>
</center>
<?php ////////////////////////////////////////////////////////////////////////////////////////?>



<?php //////////////////////////////////////////////////////////////////////////////////?>		
<center>
<div id="result" style="width:94%;">
</div>
</center>		
		
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 		
		

    	
		
<script>
$(document).ready(function() {
	$("#main_id").live('change',function(){
		var c1 = document.getElementById('main_id').value;
		
		
		
		
		
		$("#result1").load("ledger_ajax?c1=" +c1+ "");
		
		
	});
	
});
</script>			
		
<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var main_id = document.getElementById('main_id').value;
		
		if(main_id=== '') { $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;"><b>Please Select Ledger Type</b></div>'); return false; }
		var sub_id = document.getElementById('sub_id').value;
		if(main_id == 15 || main_id == 33 || main_id == 34 || main_id == 35)
		{		
				if(sub_id=== '') { $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;"><b>Please Select Sub Ledger</b></div>'); return false; }
		}
		
		
		
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		if((date1=='')) { 
		$('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;"><b>Please Select From Date</b></div>'); return false;
		}
		if((date2=='')) {
		$('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;"><b>Please Select To Date</b></div>'); return false; 
		
		}
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("ledger_show_ajax?date1=" +date1+ "&date2=" +date2+ "&main_id=" +main_id+ "&sub_id=" +sub_id+ "");
		}
		
	});
	
});
</script>			
		
		
		
		
		
		
		
		