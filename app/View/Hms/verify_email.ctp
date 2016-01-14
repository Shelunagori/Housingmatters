
	<script>
	function try_again(c1,c2,c3)
	{	
	
	$( "#again_try" ).load('sign_up_otp?try=' + c3 + '&user=' + c1 + '&mobile=' + c2)
	{
	};
	}


  </script>
  <div id="again_try">
 <div class="logo" >
    <img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo" />   
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form id="contact-form" method="POST" class="form-vertical login-form" / name='form' action=''>
    <fieldset>
      <h3 class="form-title">Join HousingMatters</h3>
     <div class="control-group">
	  	<div class="controls">
        	  <!-- <div class="control-group">
			  <div class="controls">
        	<div class="alert alert-success" >
			Please enter the code sent to your mobile number to continue your registration process
             </div>
		</div>
	  </div>-->
	  
	   <div class="control-group">
			  <div class="controls">
        	<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:12px; box-shadow:20px; font-size:16px; color:#006;">
               Verify Email 
</div>
		</div>
	  </div>
	 
	   <div class="control-group">
			  <div class="controls">
        	<div>
			<center><image src="<?php echo $this->webroot ; ?>/as/hm/gmail.png" ></center>
             </div>
		</div>
	  </div>
	  <div class="control-group">
			  <div class="controls">
        	<div>
			<p style="font-size:16px;">We just sent you an Email with a code. Enter it to verify your Email. Please note that Email delivery can take a minute or more.  </p>
             </div>
		</div>
	  </div>
	  <br/>
	  
	  <div class="control-group">
			  <div class="controls">
        	<div>
			<p style="font-size:14px;">Didn't receive an Email ? 
			<a href="" style=" text-decoration: none;">Try again.</a> </p>
             </div>
		</div>
	  </div>
	  <div class="control-group">
			  <div class="controls">
        	<div>
		<!--<image src="<?php echo $this->webroot ; ?>/as/hm/flag.jpg" width="20px" height="20px" > &nbsp<span> +91 </span>-->  <span>	 <?php 
		$count=strlen($email);
		 $r= substr($email, 0, 4);
		$l= substr($email, $count-4, $count);
		
		 $g= chunk_split($r,$count,"****");
		 echo $mmob= chunk_split($g,$count-4,"$l"); 
	  
		?> </span> &nbsp &nbsp  <span><image src="<?php echo $this->webroot ; ?>/as/hm/ajax-loader-4.gif" ></span>
            
			 </div>
		</div>
	  </div>
	  
	     <!-- <div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-lock"></i>
			<input type="text"   class="m-wrap" placeholder="Mobile No*"style="font-size:16px;" maxlength="10" disabled name="mobile" value="<?php echo $mob ; ?>" >
             </div>
		</div>
	  </div>-->
	  <br>
      <div> <label> <?php echo @$error ; ?></label></div>
	  <label><b>Enter Code</b> </label>
      <div class="input-icon left"><i class="icon-user"></i>
			<input type="password"   class="m-wrap" name="name" id="nam" style="font-size:16px;" placeholder="Please  enter the code *" >
             </div>
		</div>
	  </div>
      <div>
        <button type="submit" name="login" class="btn blue  " style="width:40%; value='task1' font-size:16px;">Verify</button>
      </div>
     </form>
    <!-- <form method='post'>
		<div style="float:right;">
        <button type="submit" name="sub" class="btn blue  " style=" value='task2' font-size:16px;"> Resend code</button>
      </div>
	  </form>-->
	   </fieldset> 
     
    <!-- END LOGIN FORM -->        
    
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    HousingMatters.
  </div>
 </div>
  <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      name: {
	       
	        required: true,
			number: true
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