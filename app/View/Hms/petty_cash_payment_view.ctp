<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
			<div class="hide_at_print">
			<?php if($s_role_id == 2) { ?> 
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:25%">
            <a href="bank_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Bank Receipt</a>
            </td>
            <td style="width:25%">
            <a href="bank_payment_view" class="btn blue btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:25%">
            <a href="petty_cash_payment_view" class="btn red btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            </tr>
            </table>     
           <?php } if($s_role_id == 3) { ?>
           
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:20%">
            <a href="bank_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Bank Receipt</a>
            </td>
            <td style="width:20%">
            <a href="bank_payment_view" class="btn blue btn-block"   style="font-size:16px;">Bank Payment</a>
            </td>
            <td style="width:20%">
            <a href="petty_cash_receipt_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Receipt</a>
            </td>
            <td style="width:20%">
            <a href="petty_cash_payment_view" class="btn red btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            <td style="width:20%">
            <a href="fix_deposit_view" class="btn blue btn-block"  style="font-size:16px;">Fixed Deposit</a>
            </td>
            </tr>
            </table> 
           <?php } ?>
		  </div> 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
              <br>
			  <center>
<div class="hide_at_print">			 
			 <?php
              if($s_role_id == 3)
              {
              ?>
              <a href="petty_cash_payment" class="btn blue">Create</a>
              <a href="petty_cash_payment_view" class="btn red">View</a>
              <?php } ?>
			  </div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
$c_date = date('d-m-Y');
$b_date = date('1-m-Y');
?> 





            <div class="hide_at_print">
            <form method="post" id="contact-form">
            <br>
            <table>
            <tbody><tr>
           
            <td><input type="text" id="date1" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="from" placeholder="From" style="background-color:white !important;"  value="<?php echo $b_date; ?>"></td>
            
            <td><input type="text" id="date2" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="to" placeholder="To" style="background-color:white !important;"  value="<?php echo $c_date; ?>"></td>
            <td valign="top"><button type="button" name="sub" class="btn yellow" id="go">Go</button></td>
            </tr>
            </tbody></table>
            <br>
            </form>
            </div>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<center>
<div id="result" style="width:94%;">
</div>
</center>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function() {
	$("#go").live('click',function(){
		var date1=document.getElementById('date1').value;
		var date2=document.getElementById('date2').value;
		
		if((date1=='')) { alert('Please Input Date-from'); }
		if((date2=='')) { alert('Please Input Date-to'); }
		else
		{
		$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("petty_cash_payment_show_ajax?date1=" +date1+ "&date2=" +date2+ "");
		}
		
	});
	
});
</script>	






