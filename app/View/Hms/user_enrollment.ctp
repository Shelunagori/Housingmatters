<script type="text/javascript">
var xobj;
//modern browers
if(window.XMLHttpRequest)
{
xobj=new XMLHttpRequest();
}
//for ie
else if(window.ActiveXObject)
{
xobj=new ActiveXObject("Microsoft.XMLHTTP");
}
else
{
alert("Your broweser doesnot support ajax");
}

function wing_flat()
{		


if(xobj)
{
var c2=document.getElementById("wi_flat").value;
var query="?con2=" + c2;
xobj.open("GET","resident_signup_wing_flat_ajax" +query,true);
xobj.onreadystatechange=function()
{
if(xobj.readyState==4 && xobj.status==200)
{	   
document.getElementById("echo_flat").innerHTML=xobj.responseText;
test();
}
}

}
xobj.send(null);

}
function test()
{
$(".chosen").chosen();
$(".chosen-with-diselect").chosen({
allow_single_deselect: true
});
}
</script>

<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
New User Enrollment 
</div>-->



<div class="portlet-body" style="padding:10px;";>
<!--BEGIN TABS-->
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">

</ul> 
<div class="tab-content" style="min-height:300px;">
<form id="contact-form" method="POST" class="" />
<center>
<table>
<tr>
<td>
<div class="control-group">
<div class="controls">
<div>
<input type="text"   class="span12 m-wrap" name="name" id="nam" style="font-size:16px;" placeholder="Name*" value="<?php echo @$nam; ?>" >
</div>
</div>
</div>
 </td></tr>
<tr><td> 
<div class="control-group" >
<div class="controls">
<select style="width:100%; font-size:16px;" id="wi_flat" onChange="wing_flat()"  class="m-wrap chosen" name="wing"  data-placeholder="Choose a Category"   tabindex="1">
<option value="">--Wing(Block)--</option>
<?php
foreach ($result_wing as $db) 
{
 $wing_id=$db['wing']["wing_id"];
 $wing_name=$db['wing']["wing_name"];
?>
<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
<?php } ?>
</select>
</div>
</div>
</td></tr>

<tr><td> 
<div class="control-group" id="echo_flat">
<div class="controls">
<select style="width:100%; font-size:16px;" class="m-wrap chosen " name="flat"  data-placeholder="Choose a Category"   tabindex="1">
<option value="" style="">--Flat--</option>
</select>
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
<div class="input-icon left"><i class="icon-lock"></i>
<input type="text"   class="m-wrap" placeholder="Mobile No"style="font-size:16px;" id="mob" maxlength="10" name="mobile" >
<div id="mob_exit"></div>
</div>
</div>
</div>

<label>Note : <span class="tooltips" data-placement="right" data-original-title="Minimum one contact detail (email or mobile number ) is required to send any communication"> <i class='icon-info-sign'></i> </span></label>
</td></tr>
<tr><td> 
<!--<div class="control-group">
<div class="controls">
<div class="input-icon left"><i class="icon-lock"></i>
<input type="password"   class="m-wrap" placeholder="Password*" style="font-size:16px;"  " name="password" >
</div>
</div>
</div>--> 
</td></tr>
 <tr><td>                

<div class="control-group">
<label class="control-label" style="font-size:16px;">Owner </label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" id="ty" onClick="commite()"name="tenant"  value="1"  style="opacity: 0; font-size:14px;""  ></span></div>
<span style="font-size:16px;"> Yes</span>
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" onClick="commite()" name="tenant" id="tno" value="2" checked  style="opacity: 0; font-size:14px;""   ></span></div>
<span style="font-size:16px;"> No </span>
</label>  

</div>
</div>

</td></tr> 
<tr>
<td>



<div class="control-group" id="resident_show" style="display:none;">
<label class="control-label" style="font-size:16px;">Committee Member</label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span>
<input type="radio" name="committe" value="1" id="cmy"   style="opacity: 0; font-size:14px;" >
</span></div>
<span style="font-size:16px;">Yes</span>
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span class="checked">
<input type="radio"  name="committe" value="2" checked style="opacity: 0; font-size:14px;"" ></span></div>
<span style="font-size:16px;"> No </span>
</label>  
</div>
</div>
</td>
</tr>   

<tr><td>           
<div class="control-group">
<label class="control-label" style="font-size:16px;">Residing </label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="residing" value="1" style="opacity: 0;"  ></span></div>
<span style="font-size:16px;">  Yes </span>
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" checked name="residing" value="2"  style="opacity: 0;"   ></span></div>
<span style="font-size:16px;"> No</span>
</label>  
</div>
</div>
</td></tr>
<tr><td> 
<div  >
<button type="submit" name="login" class="btn blue pull" onMouseOver="emilexits()" style="width:40%;  font-size:16px;">Submit</button>
</div>


</td></tr></table>

</center>
</form>

</div>
</div>
<!--END TABS-->
</div>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->	
</div>
<!-- END PAGE -->	 	
</div>
</div>
</div>

<script>
$(document).ready(function(){
$('#contact-form').validate({
  ignore: 'null',
rules: {
name: {

required: true
},
email: {

//required: true,
email: true,
 remote: "signup_emilexits"
},
password: {
required: true,
},
wing: {
required: true,
},
flat: {
required: true,
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

<script>

function commite()
	{
		
		$("#tno").click(function(){
		$("#resident_show").hide();
		//$("#tno").hide();
		
		});
		$("#ty").click(function(){
			$("#resident_show").show();
		//$("#other_show").show();
		
		});
		
	}
</script>