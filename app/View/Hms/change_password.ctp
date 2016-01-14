 <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="<?php echo $webroot_path ; ?>/as/hm/hm-logo.png" alt="logo" />  
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form id="contact-form" method="post" class="form-vertical login-form"  />
    <fieldset>
       
   
      <div style="color:red;"><?php echo @$wrong; echo @$right;?></div>
      <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left">
			<input type="password"   class="m-wrap" name="pass" id="register_password"  style="font-size:16px;" placeholder="New Password*" >
             </div>
		</div>
	  </div>
                 <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left">
			<input type="password"   class="m-wrap" name="cpass"  style="font-size:16px;" placeholder="Retype Password*" >
             </div>
		</div>
	  </div>
    
     
      
      <input type="submit" class="btn blue btn-block"  style="font-size:16px;" value="Submit" name="change" >
      </fieldset>
    </form>
    <!-- END LOGIN FORM -->        
    <!-- BEGIN FORGOT PASSWORD FORM -->
  
    <!-- END FORGOT PASSWORD FORM -->
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
   HousingMatters.
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  
  
  
<script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      pass: {
	       
	        required: true
			
	      },
		   cpass: {
	       
	        equalTo: "#register_password"
			
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
