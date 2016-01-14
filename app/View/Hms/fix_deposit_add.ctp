<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>          
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
            <a href="petty_cash_payment_view" class="btn blue btn-block"  style="font-size:16px;">Petty Cash Payment</a>
            </td>
            <td style="width:20%">
            <a href="fix_deposit_view" class="btn red btn-block"  style="font-size:16px;">Fixed Deposit</a>
            </td>
            </tr>
            </table>      
			
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br>
<center>
<a href="fix_deposit_add" class="btn red">Add</a>
<a href="fix_deposit_view" class="btn blue">Active Deposits</a>
<a href="matured_deposit_view" class="btn blue">Matured Deposits</a>
</center>	

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br>
			<div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
			<div class="portlet-title">
			<h4><i class="icon-reorder"></i>Fixed Diposit</h4>
			</div>
			<div class="portlet-body form">

			<form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<center>
			<table  style="width:80%;">


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Bank Name</label>
			</td>
			<td><br>
			<input type="text" name="bank_name" class="m-wrap medium">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Branch</label>
			</td>
			<td><br>
			<input type="text"  name="branch" class="m-wrap medium">
			</td>
			</tr>	


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Account Reference</label>
			</td>
			<td><br>
			<input type="text"  name="account_reference" class="m-wrap medium"> 
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Principal Amount</label>
			</td>
			<td><br>
			<input type="text"  name="principal_amount" class="m-wrap medium"> 
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Start Date</label>
			</td>
			<td><br>
			<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="start_date">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Maturity Date</label>
			</td>
			<td><br>
			<input type="text" class="date-picker m-wrap medium" data-date-format="dd-mm-yyyy" name="maturity_date">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Interest Rate %</label>
			</td>
			<td><br>
			<input type="text"  name="interest_rate" class="m-wrap medium">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Remarks</label>
			</td>
			<td><br>
			<input type="text" name="remark" class="m-wrap medium">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Reminder Days</label>
			</td>
			<td><br>
			<input type="text" name="reminder" class="m-wrap medium">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">TDS Amount</label>
			</td>
			<td><br>
			<input type="text" name="tds" class="m-wrap medium">
			</td>
			</tr>


			<tr>
			<td><br>
			<label class="" style="font-size:14px;">Attachment</label>
			</td>
			<td><br>
			<div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
			<span class="btn btn-file">
			<span class="fileupload-new">Select file</span>
			<span class="fileupload-exists">Change</span>
			<input type="file" class="default" name="uploaded">
			</span>
			<span class="fileupload-preview"></span>
			<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
			</div>
			</td>
			</tr>
			
			
			<br> 
			</table> 
			<table border="0" style="width:80%;">
			
			 
			<tr>
			<td><h6><b><span style="margin-left:25%;"> Contact Detail  (optional)</span></b></h6></td>
			</tr>
			</table>
			<table style="width:80%;">
			<tr>
			<td style="width:37%;"><br><label class="" style="font-size:14px;">Name</label></td>
			<td><br><input type="text"  name="name" class="m-wrap medium"></td>
			</tr>
			
			
			<tr>
			<td><br><label class="" style="font-size:14px;">E-mail</label></td>
			<td><br><input type="text" name="email" class="m-wrap medium"></td>
			</tr>

			
			<tr>
			<td><br><label class="" style="font-size:14px;">Mobile</label></td>
			<td><br><input type="text" name="mobile" class="m-wrap medium"></td>
			</tr>
			
			</table>
            </center>            
			
			
			
			
			
			
			
			<br><br>
			<div class="form-actions" style="background-color:#CCC;">
			<input type="submit" name="sub" class="btn green" value="Submit">
			<button type="button" class="btn">Cancel</button>
			</div>
			
			
			
			
			
			</span>
			</form>
			 
			
			</form>
			

			</div>
			</div>
            
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			























