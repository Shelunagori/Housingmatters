<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Master Flat Type</b></h3>
</center>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<br>

			<div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
			<div class="portlet-title">
			<h4><i class="icon-reorder"></i>Flat Master</h4>
			</div>
			<div class="portlet-body form">
       

			<center>      
			<form method="post" id="contact-form">
			<table style="width:80%;">
       
       

			<tr>
			<td style="width:29.6%;">
			<br>
			<label class="" style="font-size:14px;">Flat Type</label>
			</td>
			<td>
			<br>
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span><input type="radio" name="flat_type" value="1" style="opacity: 0;" id="go1"></span></div>
			By Square Feet
			</label>
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span><input type="radio" name="flat_type" value="2" style="opacity: 0;" id="go2"></span></div>
			By BHK
			</label>
			</td>
			</tr>
        
        
      
			<tr class="hide" id="div2">
			<td style="width:29.6%;">
			<br>
			<label class="" style="font-size:14px;">Per Square Feet Rent</label>
			</td>
			<td>
			<br>
			<input type="text" name="rs_feet" class="m-wrap medium">
			</td>
			</tr>
			</table>
        
        
		
			<div id="div1" class="hide" style="width:100%;">
			<center>
			<table style="width:80%;">
      


			<tr>
			<td style="width:29.6%;">
			<br>
			<label class="" style="font-size:14px;">Select BHK</label>
			</td>
			<td>
			<br>
			<select class="m-wrap medium" name="flat_cat">
			<option value="">Select</option>
			<option value="1">1 BHK</option>
			<option value="2">2 BHK</option>
			<option value="3">3 BHK</option>
			<option value="4">4 BHK</option>
			<option value="5">5 BHK</option>
			<option value="6">6 BHK</option>
			</select>
			</td>
			</tr>
 
       
	   
			<tr>
			<td>
			<br>
			<label class="" style="font-size:14px;">Flate Rent</label>
			</td>
			<td>
			<br>
			<input type="text" name="rs" class="medium m-wrap">
			</td>
			</tr>
       
       
       
			</table>
			</center>
			</div>
			</center>
			<br><br>
                            

			<div class="form-actions" style="background-color:#CCC;">
			<button type="submit" class="btn green" name="sub" value="xyz">Submit</button>
			<button type="button" class="btn">Cancel</button>
			</div>
        
        
			</form>
			</div>
			</div>   
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>        
     
  <script>
$(document).ready(function() {
	$("#go2").live('click',function(){
		$("#div1").show();
		$("#div2").hide();
		
	});
	
	$("#go1").live('click',function(){
		$("#div2").show();
		$("#div1").hide();
		
	});
	
});
</script>

<script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      flat_type: {
	       
	        required: true
	      },
		  
		  
		  rs_feet: {
	       
	        required: true,
			number: true
	      },
		  
		   rs: {
	       
	        required: true,
			number: true
	      },
		  
		  
		  
		   flat_cat: {
	       
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
    
    































 