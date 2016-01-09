<div style="background-color: #fff;">
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Add Family Member
</div>
<br/>

<form id="contact-form" method="POST" class="" />
<input type="hidden" value='1' id="add_h">
<table class="table_1">
<tr>
<td>
<input type="text"   class="span12 m-wrap" name="name"  style="font-size:16px;" placeholder="Name*"  >
</td>
<td> 
<input type="text" class="m-wrap" placeholder="Email Address*"   style="font-size:16px;" name="email" >
</td>
<td> 
<input type="text"   class="m-wrap" placeholder="Mobile No*"style="font-size:16px;" id="mob" maxlength="10" name="mobile" >
</td>
<td>
   <input class="m-wrap date-picker" size="16" type="text" value="" name="dob" data-date-format="dd-mm-yyyy" placeholder="Dob">
                         
</td>
<td>

<input class="m-wrap m-ctrl-medium " size="16" type="text" value="" name="relation" placeholder="Relationship">
                            
 </td>
 
 <td>
 </tr>

</table>
<div>
<button type="button" name="login" class="btn blue pull add_family "  style="  font-size:16px;">Add</button>
<button type="button" name="login" class="btn blue pull remove_family "  style="  font-size:16px;">Remove</button>
<button type="submit" name="login" class="btn blue pull"  style="  font-size:16px;">Submit</button>
<br>
</div>
</form>
</div>
<script>
$(document).ready(function(){

$('.add_family').live("click",function(){

var d=$("#add_h").val();
d++;
if(d!=11)
{
$("#add_h").val(d);

$("table.table_1").append("<tr id=tab"+d+"><td><input type='text'  class='m-wrap' name='name"+d+"' style='font-size:16px;' placeholder=' Name *'></td><td><input type='text'  class='m-wrap' name='email"+d+"'  style='font-size:16px;' placeholder='Email Address*'></td><td><input type='text'  class='m-wrap ' name='mobile"+d+"' style='font-size:16px;' placeholder=' Mobile No *'></td><td><input type='text'  class='m-wrap date-picker' name='dob"+d+"'  style='font-size:16px;' placeholder='Dob'></td><td><input type='text'  class='m-wrap ' name='relation"+d+"' style='font-size:16px;' placeholder='Relationship'></td></tr>");
}
});

});

$('.remove_family').live("click",function(){
var d=$("#add_h").val();
$("#tab"+d ).remove();
 d--;
 $("#add_h").val(d);
});
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

required: true,
email: true,
 remote: "signup_emilexits"
},
dob: {

required: true,
remote: "dob_check"
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