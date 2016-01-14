<div style="background-color:#fff;">
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Add Family Member
</div>
<br/>
<form id="contact-form" method="POST" class="" />
<center>
<table>
<tr>
<td>
<div class="control-group">
<div class="controls">
<div class="input-icon left" ><i class="icon-user"></i>
<input type="text"   class="span12 m-wrap" name="name" id="nam" style="font-size:16px;" placeholder="Name*" value="<?php echo @$nam; ?>" >
</div>
</div>
</div>
 </td></tr>
<tr><td> 
<div style="color:red;"><?php echo @$error; ?></div>       
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-envelope-alt"></i>
<input type="text" class="m-wrap" placeholder="Email Address"  id="exits" style="font-size:16px;" name="email" >
<div id="echo_exit"></div>
</div>
</div>
</div>
</td></tr>
<tr><td> 
<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-phone-sign"></i>
<input type="text"   class="m-wrap" placeholder="Mobile No"style="font-size:16px;" id="mob" maxlength="10" name="mobile" >
<div id="mob_exit"></div>
</div>
</div>
</div>
</td></tr>
<!--<tr><td> 
<div class="control-group">
<div class="controls">
<div class=""><i class=""></i>
<select name="dob" class="m-wrap" >
<option>Select Age </option>
<?php 
for($i=13;$i<=80;$i++)
{
?>

<option><?php echo $i ; ?> </option>
<?php } ?>
</select>
</div>
</div>
</div>
</td></tr>
<tr><td>--> 
<tr>
<td>
<div class="control-group">
                             
                              <div class="controls">
							  <div class="input-icon left"><i class="icon-calendar"></i>
                                 <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" name="dob" data-date-format="dd-mm-yyyy" placeholder="Dob">
                              </div>
                           </div>
 </td></tr>
 <tr>
<td> 
<div class="control-group">
<div class="controls">
<select class=" span12 m-wrap m-ctrl-medium chosen" data-placeholder="Choose A Blood Group" name="blood_group">
<option value="" style="display:none;"></option>
<option value="1"> Group A </option>
<option value="2"> Group B </option>
<option value="3"> Group AB  </option>
<option value="4"> Group O  </option>
</select>
</div>
</div>
 </td>
 </tr>
 <tr>
<td>
<div class="control-group">
                             
                              <div class="controls">
							  <div class="input-icon left"><i class="icon-user-md"></i>
                                 <input class="m-wrap m-ctrl-medium " size="16" type="text" value="" name="relation" placeholder="Relationship">
                              </div>
                           </div>
 </td></tr>
 
 
<tr><td>
<div>
<button type="submit" name="login" class="btn blue pull" onMouseOver="emilexits()" style="width:40%;  font-size:16px;">Submit</button>
</div>


</td></tr></table>

</center>
</form>

</div>


<script>
$(document).ready(function(){
$('#contact-form').validate({
  ignore: 'null',
rules: {
name: {

required: true
},

relation: {

required: true
},
email: {

//required: true,
email: true,
 remote: "signup_emilexits"
},
dob: {

required: true,
remote: "dob_check"
},
mobile: {

//required: true,
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
	                },
					 dob: {
	                    remote: "Your age should be above 13"
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