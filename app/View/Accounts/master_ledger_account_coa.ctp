<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<center>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_account_coa" class="btn yellow" rel='tab'>Ledger Accounts Add</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_sub_accounts_coa" class="btn" rel='tab'>Ledger Sub Accounts Add</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_accounts_view" class="btn" rel='tab'>Master Ledger  Account View</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_sub_account_view" class="btn" rel='tab'>Master Ledger Sub Account View</a>
</center>
<input type="hidden" id="yy" value="<?php echo $y; ?>" />
<input type="hidden" id="ledger" value="<?php echo $ledger2; ?>" />
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<form method="post" id="contact-form"> 
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Add Ledger Account</h4>
</div>
<div class="portlet-body form">


<label style="font-aize:14px;">Accounts Group</label>
<div class="controls">
<select class="m-wrap chosen span5" name="main_id" id="go">
<option value="" style="display:none;">Select Accounts Group</option>
<?php
foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['accounts_groups']['auto_id'];
$name = $collection['accounts_groups']['group_name']; 
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php } ?>
</select>
<label id="go"></label>
</div>
<br>



<label style="font-size:14px;">Ledger Account</label>
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
</form>


<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").bind('change',function(){
		var value = document.getElementById('go').value;
		
		$("#result").load("master_ledger_account_ajax?value=" +value+ "");
		
		
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
		  
		   rate: {
	       
	        required: true
	      },
		  
		  
		  
		   amount: {
	       
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

 var ledger_name2 = $("#cat").val();	
 string2 = ledger_name2.toLowerCase();

 var ledger = $("#ledger").val();
 var y = $("#yy").val();
 
 var led = ledger.split(",");
	var hhh = 5;
	for(k=0; k<y; k++)
	{
	ledger_name = led[k];
    string1 = ledger_name.toLowerCase();
   
	if(string1 == string2)
	{
	hhh = 555;	
	break;
	}
   	}
	
	if(hhh == 555)
	{
	$("#over").html('<p style="color:red;">The Ledger Name is Already Exist,Please Select Another</p>');	
	return false;
	}
	else
	{
	$("#over").html('<p style="color:red;"></p>');	
	}
	
	
    });
 });
</script>			   
		   
			   
<script>
$(document).ready(function() {
<?php	
$status5=(int)$this->Session->read('ledd_accc');
if($status5==1)
{
?>
$.gritter.add({
title: 'Ledger Account',
text: '<p>Thank you.</p><p>Ledger Account added sucessfully.</p>',
sticky: false,
time: '10000',
});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(3101)));
} ?>
});
</script> 	   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   
			   