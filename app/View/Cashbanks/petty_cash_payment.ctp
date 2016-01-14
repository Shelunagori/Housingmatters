<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />
							
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment" class="btn yellow" rel='tab'>Create</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment_view" class="btn" rel='tab'>View</a>
</center>	   
<?php ////////////////////////////////////////////////////////////////////////////////////////////////// ?>	
<?php
$default_date = date('d-m-Y');
?>
<form method="post">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Post Petty Cash Payment</h4>
</div>
<div class="portlet-body form">
<div id="validdn" style="font-size:14px; font-weight:600; color:red;"></div>
<table style="width:100%" id="tbb" class="table table-bordered">
<thead>
<tr style="background-color:#E8EAE8;">
<th style="width:15%;">Transaction Date</th>
<th style="width:20%;">A/c Group</th>
<th style="width:15%;">Expense/Party A/c</th>
<th style="width:15%;">Paid From</th>
<th style="width:15%;">Amount</th>
<th style="width:20%;">Narration</th>
<th></th>
</tr>
</thead>
<tbody id="tbbb">
<tr style="background-color:#E8F3FF;">
<td valign="top">
<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="date" id="date" style="background-color:white !important; margin-top:2.5px;" value="<?php echo $default_date; ?>">
</td>
<td valign="top">
<select name="type" class="m-wrap span12 chosen" onchange="type_ajjxx(this.value,1)" style="background-color:white !important;">
<option value="" style="display:none;">Select</option>
<option value="1">Sundry Creditors Control A/c</option>
<option value="2">All Expenditure A/cs</option>
</select>
</td valign="top">
<td id="show_user1" valign="top">
<select   name="user_id" class="m-wrap span12 chosen" style="background-color:white !important;">
<option value="" style="display:none;">Select</option>
</select>
</td>
<td valign="top">
<select name="account_head" class="m-wrap span12 chosen" style="background-color:white !important;">
<option value="" style="display:none;">Select</option>
<option value="32" selected="selected">Cash-in-hand</option>
</select>
</td>
<td valign="top"><input type="text"   class="m-wrap span12" id="amttt1" style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="5" onkeyup="numeric_vali(this.value,1)">
</td>
<td valign="top">
<input type="text" class="m-wrap span12" style="background-color:white !important; margin-top:2.5px;">
</td>
<td> <a class="btn green mini adrww" onclick="add_rowww()"><i class="icon-plus"></i></a><br></td>
</tr>
</tbody>
</table>
<div class="form-actions">
<button type="submit" class="btn green">Submit</button>
</div>
</div>
</div>
</form>

<script>
function numeric_vali(vv,dd)
{
if($.isNumeric(vv))
{
$("#validdn").html('');	
}
else
{
$("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric Value in row '+ dd +'</div>');
$("#amttt"+ dd).val("");
return false;		
}
}

</script>
<script>
function add_rowww()
{
var count = $("#tbbb tr").length;
$(".adrww").hide();
count++;

		$.ajax({
		url: 'petty_cash_payment_add_row?con=' + count,
		}).done(function(response) {
		
		$("#tbbb").append(response);
		$(".adrww").show();
});	
	
	
}


function delete_row(tttt)
{
$('.content_'+tttt).remove();
}
</script>


<script>
function type_ajjxx(tt,dd)
{
$("#show_user" + dd).load("<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment_ajax?value1=" + tt + "");
}
</script>

<script>
$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
		var count = $("#tbbb tr").length;
		var ar = [];

		for(var i=1;i<=count;i++)
		{
		var transaction_date = $("#tbbb tr:nth-child("+i+") td:nth-child(1) input").val();
		var ac_group = $("#tbbb tr:nth-child("+i+") td:nth-child(2) select").val();
		var party_ac = $("#tbbb tr:nth-child("+i+") td:nth-child(3) select").val();
		var paid_from = $("#tbbb tr:nth-child("+i+") td:nth-child(4) select").val();
		var amount = $("#tbbb tr:nth-child("+i+") td:nth-child(5) input").val();
		var narration = $("#tbbb tr:nth-child("+i+") td:nth-child(6) input").val();
		ar.push([transaction_date,ac_group,party_ac,paid_from,amount,narration]);
		
		}
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "petty_cash_payment_json?q="+myJsonString,
			dataType:'json',
			}).done(function(response){
			if(response.type == 'error'){
			
			 $("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
			$("html, body").animate({
					 scrollTop:0
					 },"slow");
			
			}
		    if(response.type == 'success'){
			  $("#shwd").show();
			  $(".shwtxt").html(response.text);
			  
			}
});			
});
});

</script>		


<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p class="shwtxt"></p>

</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_payment_view" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 



<!-- End new Front End   -->
<!--
<div style="background-color:#FFF; width:48%; float:left; margin-left:2%;">

<label style="font-size:14px;">Transaction Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date" value="<?php //echo $default_date; ?>">
<label id="date"></label>
<div id="result11"></div>
</div>
<br />


<label style="font-size:14px;">A/c Group<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select account group"> </i></label>
<div class="controls">
<select name="type" id="go" class="m-wrap span9">
<option value="" style="display:none;">Select</option>
<option value="1">Sundry Creditors Control A/c</option>
<option value="2">All Expenditure A/cs</option>
</select>
<label id="go"></label>
</div>
<br />


<label style="font-size:14px;">Expense/Party A/c<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select Expense/Party A/c"> </i></label></td>
<div class="controls" id="show_user">
<select   name="user_id" class="m-wrap span9 chosen" id="usr">
<option value="" style="display:none;">Select</option>
</select>
<label id="usr"></label>
</div>

</div>


<div style="background-color:#FFF; width:50%; float:right;">

<label style="font-size:14px;">Paid From<span style="color:red;">*</span> </label>
<div class="controls">
<select   name="account_head" class="m-wrap span9 chosen" id="ach">
<option value="" style="display:none;">Select</option>
<option value="32">Cash-in-hand</option>
</select> 
<label id="ach"></label>
</div>
<br />


<label style="font-size:14px;">Amount<span style="color:red;">*</span></label>
<div class="controls">
<input type="text"  name="ammount" id="amount" class="m-wrap span9">
<label id="amount"></label>
</div>
<br />



<label style="font-size:14px;">Narration<span style="color:red;">*</span></label>
<div class="controls">
<textarea   rows="4" name="narration" style="resize:none;" class="m-wrap span9" id="nr"></textarea>
<label id="nr"></label>
</div>
</div>
<br />

<div style="width:100%; overflow:auto;">
<hr />
<br />
<button type="submit" class="btn green" name="ptp_add" value="xyz" id="vali" style="margin-left:70%;">Submit</button>
<a href="petty_cash_payment" class="btn">Reset</a>
</div>
</form>

</div>
-->









<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		   

<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>




<script>
$(document).ready(function() {
	$("#data_tds").live('change',function(){
		
		var data_tds = document.getElementById('data_tds').value;
		var amount = document.getElementById('amount').value;
		
		$("#total_am").load("amount_cal_p?data=" + data_tds + "&amount="+ amount +"");
	});
	});
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
		  
		  
		  type: {
	       
	        required: true
	      },
		  
		   user_id: {
	       
	        required: true
	      },
		  
		  
		  
		   ammount: {
	       
	        required: true,
			number: true,
			notEqual: "0"
	      },
		 
		  
		 
		 
		    narration: {
	       
	        required: true
	      },

	     account_head: {
	       
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
		$(document).ready(function() {
		$("#vali").bind('click',function(){
        
		var fi = document.getElementById("fi").value;
		var ti = document.getElementById("ti").value;
		var cn = document.getElementById("cn").value;
		var fe = fi.split(",");
		var te = ti.split(",");
		var date1 = document.getElementById("date").value;
		
		var date = date1.split("-").reverse().join("-");
				
		var nnn = 55;
		for(var i=0; i<cn; i++)
		{
		var fd = fe[i];
		var td = te[i]
		
		    if(date == "")
			{
				nnn = 555;
			break;	
			}
			else if(Date.parse(fd) <= Date.parse(date))
		     {
			 if(Date.parse(td) >= Date.parse(date))
			 {
				 nnn = 5;
				 break;
			 }
			 else
			 {
				 
			 }
        	 } 
			 }
			 
		
		if(nnn == 55)
		{
		$("#result11").load("cash_bank_vali?ss=" + 2 + "");
        return false;	
		}
		else if(nnn == 555)
		{
			
		}
		else
		{
		$("#result11").load("cash_bank_vali?ss=" + 12 + "");		
		}
		
		
		
		});
		});
		</script>		
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   