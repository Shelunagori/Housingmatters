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
       <h3 class="">Forgot Password ?</h3>
      <p>Enter your e-mail address below to reset your password.</p>
      <div style="color:red;"><?php echo @$wrong; echo @$right;?></div>
      <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-envelope"></i>
			<input type="text"   class="m-wrap" name="email" style="font-size:16px;"  placeholder="Login-Id*" >
             </div>
		</div>
	  </div>
                
    
     
      
      <input type="submit" class="btn blue btn-block" value="Submit" style="font-size:16px;" name="forget" >
	 <!-- <hr>
	  Demo Link for Mobile
	  <a href="mobile.php" class="btn yellow btn-block">Call</a>-->
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
			email:true
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

  
  