 <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="<?php echo $webroot_path; ?>/as/hm/hm-logo.png" alt="logo" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form id="contact-form" method="post" class="form-vertical login-form"  />
    <fieldset>
      <h3 class="form-title">Sign Up</h3>
      <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-user"></i>
			<input type="text"   class="m-wrap" name="society_name" style="font-size:16px;" placeholder="Housing Society Name*" >
             </div>
		</div>
	  </div>
      
      
      
       <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-user"></i>
			<input type="text"   class="m-wrap" name="pin_code" style="font-size:16px;" placeholder="Pin Code*" >
             </div>
		</div>
	  </div>
      
      <div class="control-group">
          <div class="controls">
              <select style="width:100%; font-size:16px;" class="m-wrap" name="association"  data-placeholder="Choose a Category*"   tabindex="1">
                 <option value="">--Association Formed--</option>
                 <option value="1">Yes</option>
                 <option value="2">No</option>
             </select>
          </div>
      </div>
      
      <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-user"></i>
			<input type="text"   class="m-wrap" name="no_flat" style="font-size:16px;" placeholder="No. of Flat*" >
             </div>
		</div>
	  </div>
                
      
      
   
      
       
     
         
				
			
      <div class="form-actions">
      		<a href="sign_up_next?user=<?php echo $user_id; ?>" class="btn" style="font-size:16px;">Back</a>
     		<button type="submit" name="sub" class="btn blue pull-right" style="font-size:16px;">SIGN UP</button>
      </div>
     
      
      </fieldset>
    </form>
    <!-- END LOGIN FORM -->        
   
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    HousingMatters.
  </div>
  <!-- END COPYRIGHT -->
  
  
  <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      society_name: {
	       
	        required: true
	      },
		  district: {
	       
	        required: true
	      },
		  pin_code: {
	       
	        required: true,
			number: true
	      },
		  association: {
	       
	        required: true,
	      },
	     // no_flat: {
	        //required: true,
			//number: true
	     // },
		 
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
