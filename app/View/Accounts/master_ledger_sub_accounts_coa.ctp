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
<center>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_account_coa" class="btn" rel='tab'>Ledger Accounts Add</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_sub_accounts_coa" class="btn yellow" rel='tab'>Ledger Sub Accounts Add</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_accounts_view" class="btn" rel='tab'>Master Ledger  Account View</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_sub_account_view" class="btn" rel='tab'>Master Ledger Sub Account View</a>
</center>
<input type="hidden" id="ledger" value="<?php echo $ledger2; ?>" />
<input type="hidden" id="tt" value="<?php echo $t; ?>" />
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?> 
<form method="post" id="contact-form"> 
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Add Ledger Sub Account</h4>
</div>
<div class="portlet-body form">

<label style="font-aize:14px;">Ledger Accounts</label>
<div class="controls">
<select class="span5 m-wrap chosen" name="main_id" id="go">
<option value="" style="display:none;">Select Ledger Account</option>
<?php
foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name']; 
if($auto_id == 33 || $auto_id == 35 || $auto_id == 15 || $auto_id == 112)
{
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php }} ?>
</select>
<label id="go"></label>
</div>
<br>


<label style="font-size:14px;">Ledger Sub Account</label>
<div class="controls">
<input type="text" name="cat_name" placeholder="Name" class="m-wrap span5" style="background-color:white !important;" id="cat">
<label id="cat"></label>
<div id="over"></div>
</div>
<br>


<div id="result">
</div>

<div class="form-actions">
<button type="submit" name="sub" class="btn blue" id="vali">Add</button>
</div>

</div>
</div>


                     

     </div>   </div>                    
                      
                       </form>
    
         
			   
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
           

<script>
$(document).ready(function() {
	$("#go").bind('change',function(){
		var value=document.getElementById('go').value;
		
		
		$("#result").load("master_ledger_sub_account_ajax?value=" +value+ "");
		
		
	});
	
});
</script>	

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
	      main_id: {
	       
	        required: true
	      },
		  
		  
		  cat_name: {
	       
	        required: true
	      },
		  
		
		 user_id: {
	       
	        required: true,
			number:true
	      },
		  
		  
		
		 bank_account: {
	       
	        required: true,
			number:true
	      },
		 
		  tax: {
	       
	        required: true
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

<script>
$(document).ready(function(){
 $("#vali").bind('click',function(){

var sub_led = $("#cat").val();
string1 = sub_led.toLowerCase();

var t = $("#tt").val();
var ledger1 = $("#ledger").val();
var led = ledger1.split(",");

for(var k=0; k<t; k++)
{
var ledger2 = led[k];
string2 = ledger2.toLowerCase();

var nn = 5;
if(string1 === string2)
{
var nn = 555;
break;	
}
}

if(nn == 555)
{
$("#over").html('<p style="color:red";>The Sub ledger Name Already Exist, Please Fill Another Name</p>');
return false;
}
else
{
$("#over").html('<p style="color:red";></p>');	
}
});
});
</script>

			   
<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('ledgrr_sub_accc');
if($status5==1)
{
?>
$.gritter.add({
title: 'Ledger Sub Account',
text: '<p>Thank you.</p><p>Ledger Sub Account added sucessfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(3102)));
} ?>
});
</script> 	   
			


















