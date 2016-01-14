	<script>
	$( document ).ready(function() {
   $('.try_again').click(function(){ 
   var r=$(this).attr('element_id');
  $("#try_a").html('loading.... <image src="<?php echo $this->webroot ; ?>/as/hm/ajax-loader-4.gif" >').load('verify_mobile_ajax?con=' + r);
  })
});
  </script>
  <div id="again_try">
 <div class="logo" >
    <img src="<?php echo $webroot_path; ?>/as/hm/hm-logo.png" alt="logo" />   
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
               Verify Phone 
</div>
		</div>
	  </div>
	 
	   <div class="control-group">
			  <div class="controls">
        	<div>
			<center><image src="<?php echo $webroot_path; ?>/as/hm/mobile.jpg" ></center>
             </div>
		</div>
	  </div>
	  <div class="control-group">
			  <div class="controls">
        	<div>
			<p style="font-size:16px;">We just sent you an SMS with a code. Enter it to verify your phone. Please note that SMS delivery can take a minute or more.  </p>
             </div>
		</div>
	  </div>
	  <br/>
	  
	  <div class="control-group">
			  <div class="controls">
        	<div>
			<p style="font-size:14px;">Didn't receive an SMS ? 
			<a  role='button' style=" text-decoration: none; cursor:pointer;" class='try_again' element_id='<?php echo $user_id ; ?>'>Try again.</a> </p>
			
			<div id='try_a'></div>
             </div>
		</div>
	  </div>
	  <div class="control-group">
			  <div class="controls">
        	<div>
		<image src="<?php echo $webroot_path; ?>/as/hm/flag.jpg" width="20px" height="20px" > &nbsp<span> +91 </span>  <span>	 <?php 
		//$r= substr($mobb, 0, 2);
		//$l= substr($mobb, 8, 10);
		//$g= chunk_split($r,2,"******");
		 //echo $mmob= chunk_split($g,8,"$l"); 
		echo $mobb;
		?> </span> &nbsp  <!--<span><image src="<?php echo $this->webroot ; ?>/as/hm/ajax-loader-4.gif" ></span>-->
            
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
			<input type="text" maxlength='5'  class="m-wrap" name="name" id="nam" style="font-size:16px;" placeholder="Please  enter the code *" >
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