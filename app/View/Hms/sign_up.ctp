  <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="<?php echo $webroot_path ; ?>/as/hm/hm-logo.png" alt="logo" />   
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    
    <form  method="POST" class="form-vertical login-form" onSubmit="return check_email()" id="contact-form" />
    <fieldset>
      <h3 class="form-title">Join HousingMatters</h3>
      <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-user"></i>
			<input type="text"   class="m-wrap" name="name" id="nam" style="font-size:16px;" placeholder="Name*" value="" >
             </div>
		</div>
	  </div>
 
        <div style="color:red;"><?php echo @$error; ?></div>       
       <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-envelope-alt"></i>
			<input type="text" class="m-wrap" placeholder="Email Address*"  id="email" style="font-size:16px;" name="email" >
             <div id="echo_error_massage" style="color:red;"></div>
             </div>
		</div>
	  </div>
     
       
      
       <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-lock"></i>
			<input type="text" maxlength="10"   class="m-wrap" placeholder="Mobile No*"style="font-size:16px;" id="mob" name="mobile" >
            <div id="mob_exit"></div>
             </div>
		</div>
	  </div>
	  
	 <!-- <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-lock"></i>
			<input type="password"   class="m-wrap" placeholder="Password*" style="font-size:16px;"   name="password" >
             </div>
		</div>
	  </div> -->
      
				
			
      <div class="form-actions" >
        <button type="submit" name="login" id="submit" class="btn blue pull"  style="width:40%;  font-size:16px;">SIGN UP</button>
      </div>
      <div class="forget-password">
      <a href="index" class="btn green pull-right" style="font-size:16px;">Login</a>
       <!-- <h5 class="pull-right" style="padding:5px;">Already Registered</h5>-->
       <div class="pull-right" style=" padding:10px;">Already registered ?</div>
        
		</div>
      
      </fieldset>
    </form>
    <!-- END LOGIN FORM -->        
   
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
	      name: {
	       
	        required: true
	      },
		 
		 
		  
		  email:
        {
            required: true,
			email: true,
            remote: "signup_emilexits"
        },
		  
	      password: {
	        required: true,
	      },
		  mobile: {
	       
	        required: true,
			number: true,
			minlength: 10,
			maxlength: 10,
			remote: "signup_mobileexit"
	      }
	    },
		messages: {
	                email: {
	                    remote: "Login-Id is Already Exist."
	                },
					 mobile: {
	                    remote: "Mobile-No is Already Exist."
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