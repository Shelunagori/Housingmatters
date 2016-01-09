<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
New Enrollment 
</div>
<div class="portlet-body" style="padding:10px;";>
<!--BEGIN TABS-->
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">

<li class="active" ><a href="new_society_enrollment" >New Society Enrollment</a></li>
<li class="" ><a href="hm_new_user_enrollment" >New User Enrollment </a></li>
</ul> 
<div class="tab-content" style="min-height:300px;">
<form id="contact-form" method="POST" class="" />
<center>
<table>
<tr>
<td>
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-user-md"></i>
<input type="text"   class="span12 m-wrap" name="society_name" style="font-size:16px;" placeholder="Housing Society Name*">
</div>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-user"></i>
<input type="text"   class="span12 m-wrap" name="user_name"  style="font-size:16px;" placeholder="User Name*"  >
</div>
</div>
</div>
</td>
</tr>


<tr><td> 

<div style="color:red;"><?php echo @$error; ?></div>       
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-envelope-alt"></i>
<input type="text" class="m-wrap" placeholder="Email Address*"  id="exits" style="font-size:16px;" name="email" >
<div id="echo_exit"></div>
</div>
</div>
</div>
</td></tr>

<tr><td> 
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-phone-sign"></i>
<input type="text"   class="m-wrap" placeholder="Mobile No*"style="font-size:16px;" id="mob" maxlength="10" name="mobile" >
<div id="mob_exit"></div>
</div>
</div>
</div>

</td></tr>

<tr>
<td>
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-qrcode"></i>
<input type="text"   class="span12 m-wrap" name="pin_code"  style="font-size:16px;" placeholder="Pin Code*"  >
</div>
</div>
</div>
</td>
</tr>
 <tr>
<td> 
<div class="control-group">
          <div class="controls">
              <select style="width:100%; font-size:16px;" class=" m-wrap" name="association"  data-placeholder="Choose a Category*"   tabindex="1">
                 <option value="">--Association Formed--</option>
                 <option value="1">Yes</option>
                 <option value="2">No</option>
             </select>
          </div>
      </div>
</td></tr>
<tr>
<td>


<div class="control-group">
	  	<div class="controls">
        	<div class="input-icon left"><i class="icon-sign-blank"></i>
			<input type="text"   class="m-wrap" name="no_flat" style="font-size:16px;" placeholder="No. of Flat" >
             </div>
		</div>
	  </div>
</td>
</tr>   
<tr><td> 
<div  >
<button type="submit" name="login" class="btn blue pull"  style="width:40%;  font-size:16px;">Submit</button>
</div>


</td></tr></table>

</center>
</form>

</div>
</div>
</div>




<script>
$(document).ready(function(){
$('#contact-form').validate({
  ignore: 'null',
rules: {

society_name: {

required: true
},
pin_code: {

required: true,
number: true
},
association: {

required: true,
},
user_name: {

required: true
},
email: {
required: true,
email: true,
 remote: "signup_emilexits"
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