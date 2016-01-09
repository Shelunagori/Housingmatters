
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>




<input type="hidden" name="fd1" value="<?php echo $fd1; ?>" id="fd1"/>
<input type="hidden" name="td1" value="<?php echo $td1; ?>" id="td1" />
<center>
<h3><b>Master Financial Year</b></h3>
</center>

<a href="master_financial_period_status" class="btn yellow">Financial Year Status</a>
<a href="master_financial_year" class="btn purple">Open New Year</a>
<br><br>
<center>
 <div class="portlet box grey" style="width:90%; margin-left:1%; margin-right:1%;">
              <div class="portlet-title">
              <h4><i class="icon-reorder"></i>Open New Year</h4>
              </div>
              <div class="portlet-body form" style="background-color:white;"> 
<br><br>
<form method="post" id="contact-form" onsubmit="return valid()">			  
<table border="0">
<tr>
<td  colspan="4" style="text-align:center;">
<label style="font-size:18px"><b>Open New Financial Year for Posting Entries</b></label>
</td>
</tr>
<tr>

<td><label style="font-size:22px;"><b>From</b></label></td>
<td><input type="text" name="from" class="m-wrap medium date-picker" data-date-format="dd-mm-yyyy" style="background-color:white !important;" id="from" placeholder="Select Start Date">

</td>
<td><label style="font-size:22px;"><b>To</b></label></td>
<td><input type="text" name="to" class="m-wrap medium date-picker" data-date-format="dd-mm-yyyy" style="background-color:white !important;" id="to" placeholder="Select End Date"></td>

</tr>
<tr>
<td style="padding:0px; margin:0px;"></td>
<td style="padding:0px; margin:0px;"><label id="from"></label></td>
<td style="padding:0px; margin:0px;"></td>
<td style="padding:0px; margin:0px;"><label id="to"></label></td>
</tr>
<tr>
<td colspan="4" id="result5" style="padding:0px; margin:0px; text-align:center;"></td>
</tr>
</table>

<br>
<br>





		<div class="form-actions" style="background-color:#D7DACD;">
        <a href="#myModal3" role="button" class="btn green" data-toggle="modal">Submit</a>
		<!--<button type="submit" class="btn green" name="sub1" value="xyz" id="go">Submit</button> -->
		<button type="reset" class="btn">Cancel</button>
		</div>
        
        

    
        
        
        
        
        
        

</div>
</div>
			  
			  
</center>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="display: block;">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Financial Year</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h3><b>Are You Sure</b></h3>
</center>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button type="submit" class="btn blue" name="sub1" value="xyz" id="go">Confirm</button>
</div>
</div>
</form>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
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
	      from: {
	       
	        required: true
	      },
		  
		   to: {
	       
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


<!--
<div class="edit_div" style="display: none;">
<div class="modal-backdrop fade in"></div>
<div class="modal" id="poll_edit_content">
<div class="modal-header">
	<h4 id="myModalLabel1">Edit poll</h4>
</div>
<div class="modal-body">
<div class="control-group">
<label class="control-label">Description</label>
<div class="controls">
<textarea class="m-wrap span12" id="description">i have a support for this project develop. please give me your review. 
thanks</textarea>
</div>
</div>
<div class="control-group">
<label class="control-label">Poll will be close after</label>
<div class="controls">
<input class="m-wrap" id="close_date" type="text" value="29-12-2014">
</div>
</div>
			   
</div>
<div class="modal-footer">
<button class="btn" id="close_edit">Close</button>
<button class="btn blue save_edited_poll" poll_id="4">Save</button>
</div>
</div>
</div>
-->

	<script>
		$(document).ready(function() {
		$("#go").live('click',function(){

		 var fromd1 = document.getElementById("from").value;
		 var tod1 = document.getElementById("to").value;
         var fd1 = document.getElementById("fd1").value;
		 var td1 = document.getElementById("td1").value;
         
		 var fromd = fromd1.split("-").reverse().join("-");
		 var tod = tod1.split("-").reverse().join("-");
		 if(fromd == "")
		 {
			
		 }
		 else if(tod == "")
		 {
		   	 
		 }
		 else if(Date.parse(td1) >= Date.parse(fromd))
		 {
         $("#result5").load("financial_vali_ajax?ss=" + 1 + "");
       	 return false;
		 } 
		 else if(Date.parse(tod) <= Date.parse(fromd))
		 {
		 $("#result5").load("financial_vali_ajax?ss=" + 2 + "");
       	 return false;
		 }
		 else
		 {
		 $("#result5").load("financial_vali_ajax?ss=" + 3 + "");	 
		 }
		
		 
		
		});
		});
		</script>	













