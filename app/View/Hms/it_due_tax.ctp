<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
			
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:25%">
            <a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
            </td>
            <td style="width:25%">
             <a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
            </td>
            <td style="width:25%">
            <a href="it_reports_regular" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
            </td>
            <td style="width:25%">
            <a href="it_setup" class="btn red btn-block"  style="font-size:16px;">Set-Up</a>
            </td>
            </tr>
            </table>
            
           <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
			<td><a href="select_income_heads" class="btn">Selection of Income Heads</a>
			</td>
            <td>
            <a href="it_due_tax" class="btn yellow" style="font-size:16px;">Due tax</a>
            </td>
            <td>
            <a href="it_setup" class="btn" style="font-size:16px;">Terms & Condition</a>
            </td>
            <td>
            <a href="master_rate_card" class="btn" style="font-size:16px;">Rate Card</a>
            </td>
			<td>
            <a href="master_noc" class="btn" style="font-size:16px;">Non Occupancy Charges</a>
            </td>
			<td>
            <a href="it_penalty" class="btn" style="font-size:16px;">Penalty Option</a>
            </td>
			</tr>
			</table> 
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br /><Br />

                <div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
                <div class="portlet-title">
                <h4><i class="icon-reorder"></i>Due Tax</h4>
                </div>
                <div class="portlet-body form">
                <center>
                <form method="post" id="contact-form">
                <table border="0">
                <tr>
                <td>Select Tax Type</td>
                <td>
                <select name="type" class="m-wrap medium" id="tp">
                <option value="">Select</option>
                <option value="1">Monthly</option>
                <option value="2">15 Days</option>
                </select>
                </td>
                </tr>
                <tr>
                <td></td>
                <td><label id="tp"></label></td>
                </tr>
                <tr>
                <td>Tax in Persentage</td>
                <td>
                <input type="text" name="tax_p" class="m-wrap medium" id="tx"/>
                </td>
                </tr>
                <tr>
                <td></td>
                <td><label id="tx"></label></td>
                </tr>
                <tr>
                <td colspan="2">
                <br />
                <button type="reset" class="btn">Reset</button>
                <button type="submit" name="taxp" class="btn green">Submit</button>
                </td>
                </tr>
                </table>
                </form>
                </center>
                </div>
                </div>
    

<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function(){

$.validator.setDefaults({ ignore: ":hidden:not(select)" });


		$('#contact-form').validate({
		
		errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    },
		
		
		
	    rules: {
	      
		  type: {
	       
	        required: true
	      },
		  
		  
		  tax_p: {
	       
	        required: true,
			number: true
	      },
	
		},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); 
</script>	

















