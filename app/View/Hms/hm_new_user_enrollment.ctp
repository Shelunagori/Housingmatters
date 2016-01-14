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

<script>
function society_wing()
{
var s=$("#soc_wing").val();

$( "#echo_wing" ).load( "resident_signup_ajax?con1=" + s );

}
</script>
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
New Enrollment 
</div>



<div class="portlet-body" style="padding:10px;";>
<!--BEGIN TABS-->
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li class="" ><a href="new_society_enrollment" >New Society Enrollment</a></li>
<li class="active" ><a href="hm_new_user_enrollment" >New User Enrollment</a></li>
</ul> 
<div class="tab-content" style="min-height:300px;">
<form id="contact-form" method="POST" class="" />
<center>
<table>
<tr>
<td>
<div class="control-group">
<div class="controls">
<select style="width:100%; font-size:16px;" onChange="society_wing()" id="soc_wing" class="m-wrap chosen " name="society"  data-placeholder="Choose a Category"   tabindex="1">
<option value="" >--Select Name of The Society--</option>
<?php 

foreach ($result_society as $db) 
{
$society_id=$db['society']["society_id"];
$society_name=$db['society']["society_name"];
?>
<option value="<?php echo $society_id; ?>"><?php echo $society_name; ?></option>
<?php } ?>
</select>
</div>
</div>
</td>
</tr>
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
<div class="control-group" id='echo_wing' >
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
<label style="color:red;"><?php echo @$tenant_allow; ?> </label>
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

<!--<tr><td>           
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
</td></tr>-->
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
society: {

required: true
},
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
remote: {
        url: "flat_already_exits",
        type: "post",
        data: {
          society: function() { return $("#soc_wing").val();return $("#flat").val();},
		  tenant:  function(){   return $('input:radio[name=tenant]:checked').val(); }
			}
			}
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
					flat: {
	                    remote: "Flat is Already Exist."
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