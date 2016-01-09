 <!-- BEGIN LOGO -->
  <div class="logo">
   <img src="<?php echo $webroot_path ; ?>/as/hm/hm-logo.png" alt="logo" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
   <div class="alert alert-info"><strong style="color:#33C; font-family:Georgia, 'Times New Roman', Times, serif;">Info!</strong>
    <span style="font-family:Georgia, 'Times New Roman', Times, serif; color:#60C;"> Verification Code has been sent to your login-email address.<br/>
     Kindly check your Inbox.</span>
     </div> 
     
    <form id="contact-form" method="post" class="form-vertical login-form"  />
    <fieldset>
       
      <p style="font-size:16px;"><?php //echo $emil ; ?></p>
      <div style="color:red;"><?php echo @$wrong; echo @$right;?></div>
      <div class="control-group">
	  	<div class="controls">
        	<div class="">
			<input type="text"   class="m-wrap" name="email" style="font-size:16px;" placeholder="Verification code*" maxlength="5" >
             </div>
		</div>
	  </div>
                
    
     
      
      <input type="submit" class="btn blue btn-block" style="font-size:16px;" value="Submit" name="sub" >
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
  
  <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      email: {
	       
	        required: true,
			number:true
			
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
