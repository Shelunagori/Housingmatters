<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
<tr>
<td style="width:25%">
<a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
</td>
<td style="width:25%">
<a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
</td>
<td style="width:25%">
<a href="in_head_report" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
</td>
<td style="width:25%">
<a href="select_income_heads" class="btn red btn-block"  style="font-size:16px;">Accounting Setup</a>
</td>
</tr>
</table>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

    <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
    <tr>
    <td><a href="select_income_heads" class="btn yellow">Selection of Income Heads</a>
    </td>
   <!-- <td>
    <a href="it_due_tax" class="btn" style="font-size:16px;">Due tax</a>
    </td> -->
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
            
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> <br /><br
<br />

        <div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
        <div class="portlet-title">
        <h4><i class="icon-reorder"></i>Selection of Income Heads</h4>
        </div>
        <div class="portlet-body form">
        <form method="post" id="contact-form">
        <center>
        <br />
        <table border="0">
        <tr>
        <td>Select Income Heads</td>
        <td>
        <select data-placeholder="Select Account Heads"  name="i_head[]" id="i_head" class="m-wrap large chosen" multiple="multiple" tabindex="6">	
		<option value="" style="display:none;">Select</option>
		<?php
		$ledgerac = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch'),array('pass'=>array(        7)));			
        foreach($ledgerac as $collection2)
        {
	    $ac_name = $collection2['ledger_account']['ledger_name'];
	    $ac_id = (int)$collection2['ledger_account']['auto_id'];		
        if($ac_id != 43 && $ac_id != 39 && $ac_id != 40)
		{
?>
		<option value="<?php echo $ac_id; ?>"><?php echo $ac_name; ?></option>
		<?php }} ?>
		</select>
       
        </td>
        </tr>
        <tr>
        <td></td>
        <td> <label id="i_head"></label></td>
        </tr>
        
 <tr>       
<td colspan="2">
<br />
<a href="select_income_heads" class="btn" >Cancel</a>
<button type="submit" class="btn green" name="sub">Submit</button>
</td>
</tr>



        </table> 
        </form> 
        </div>
        </div>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>



<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<table class="table table-bordered" style="width:60%; background-color:white;">
<tr>
<th>Sr #</th>
<!--<th>Auto Id</th>
<th>Ledger Id</th>-->
<th>Account Name</th>
</tr>
<?php 
$m=0;
foreach($cursor3 as $collection)
{
$income_head_arr = $collection['society']['income_head'];
}
$m=0;
for($i=0; $i<sizeof($income_head_arr); $i++)
{
$m++;
$income_head_id = (int)$income_head_arr[$i];	

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_id)));	
foreach($result1 as $collection)
{
$income_head_name = $collection['ledger_account']['ledger_name'];	
}
?>
<tr>
<td><?php echo $m; ?></td>
<!-- <td><?php echo $auto_id; ?></td>
<td><?php echo $ih_id; ?></td> -->
<td><?php echo $income_head_name; ?></td>
</tr>
<?php } ?>
</table>


<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>

	<script>
$.validator.addMethod('requirecheck1', function (value, element) {
	 return $('.requirecheck1:checked').size() > 0;
}, 'Please check at least one role.');

$.validator.addMethod('requirecheck2', function (value, element) {
	 return $('.requirecheck2:checked').size() > 0;
}, 'Please check at least one wing.');

$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
});

$(document).ready(function(){
			var checkboxes = $('.requirecheck1');
			var checkbox_names = $.map(checkboxes, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			
			var checkboxes2 = $('.requirecheck2');
			var checkbox_names2 = $.map(checkboxes2, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			
			
	$.validator.setDefaults({ ignore: ":hidden:not(select)" });
		$('#contact-form').validate({
		
		 errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	    groups: {
            asdfg: checkbox_names,
			qwerty: checkbox_names2
        },
		
		
		rules: {
				 
		  
		  "i_head[]": {
			 required: true
	      },
		 
	    },
		messages: {
	                from: {
	                    required: "Bill Date is Required."
	                },
					to: {
	                    required: "To date is required."
	                },
					file: {
						accept: "File extension must be gif or jpg",
	                    filesize: "File size must be less than 1MB."
	                },
					description: {
	                    maxlength: "Max 500 characters allowed."
	                }
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
