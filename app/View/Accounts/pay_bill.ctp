<?php
$default_date = date('d-m-Y');
?>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">
<h4 style="color: #09F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;"><i class="icon-money"></i> Post Bill Payment Detail</h4>
<form method="post" id="contact-form">
<div class="row-fluid">
<div class="span6">


<label style="font-size:14px;">Transaction Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date" value="<?php echo $default_date; ?>">
<label id="date"></label>
</div>
<br />

<label style="font-size:14px;">Bank Name<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="bank_name" id="bnk" />
<label id="bnk"></label>
</div>
<br />

<label style="font-size:14px;">Mobile<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="mobile" id="mob" maxlength="10"/>
<label id="mob"></label>
</div>
<br />

<label style="font-size:14px;">Bill Number:<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="bill_no" value="<?php echo $receipt_no; ?>" readonly="readonly" id="bll"/>
<label id="bll"></label>
</div>
<br />


</div>
<div class="span6">


<label style="font-size:14px;">Paying Mode<span style="color:red;">*</span></label>
<div class="controls">
<select class="m-wrap span9" name="mode" onchange="show(this.value)" id="mode">
<option value="" style="display:none;">Select</option>
<option value="1"> By Cheque</option>
<option value="2"> By Cash</option>
</select>
<label id="mode"></label>
</div>
<br />


<div id="one" class="hide">
<label style="font-size:14px;">Cheque Number<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="chq_no" class="m-wrap span9"  id="chq"/>
<label id="chq"></label>
</div>
<br />
</div>

<label style="font-size:14px;">Branch<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="branch" class="m-wrap span9" id="bnch"/>
<label id="bnch"></label>
</div>
<br />


<label style="font-size:14px;">Account Number<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="acno" class="m-wrap span9" id="acno"/>
<label id="acno"></label>
</div>
<br />


<label style="font-size:14px;">Pay Amount<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="amt" id="amt"/>
<label id="amt"></label>
</div>
<br />


</div>
</div>
<button type="submit" class="btn green" name="sub" value="xyz">Submit</button>
<a href="<?php echo $webroot_path; ?>Accounts/pay_bill?b=<?php echo $receipt_no; ?>" class="btn" rel='tab'>Reset</a>
<a href="<?php echo $webroot_path; ?>Accounts/my_flat_bill" class="btn" rel='tab'>Back</a>
</form>
</div>



<script>
function show(g)
{
if(g == 1)
{
$("#one").show();	
}
else
{
$("#one").hide();	
}
}
</script>

<script>
$(document).ready(function(){

jQuery.validator.addMethod("notEqual", function(value, element, param) {
return this.optional(element) || value !== param;
}, "Please choose Other value!");	


$.validator.setDefaults({ ignore: ":hidden:not(select)" });

$('#contact-form').validate({
errorElement: "label",
//place all errors in a <div id="errors"> element
errorPlacement: function(error, element) {
//error.appendTo("label#errors");
error.appendTo('label#' + element.attr('id'));
},

rules: {

date: {
required: true
},


bank_name: {
required: true
},

mobile: {
required: true,
number:true
},

amt: {
required: true,
number: true,
},

mode: {
required: true
},

chq_no: {
   required: true,
   number: true
    },

branch: {
required: true
},

acno: {
required: true,
number:true
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




