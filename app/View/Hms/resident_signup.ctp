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

function society_wing()
{		

 $(document).ready(function() {
	
if(xobj)
{
var c1=document.getElementById("soc_wing").value;
var query="?con1=" + c1;
xobj.open("GET","resident_signup_ajax" +query,true);
xobj.onreadystatechange=function()
{
if(xobj.readyState==4 && xobj.status==200)
{	   
document.getElementById("echo_wing").innerHTML=xobj.responseText;
}
}

}
xobj.send(null);
 });
}


function wing_flat()
{		

$(document).ready(function() {
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
}
}

}
xobj.send(null);
});
}


</script>



<div class="logo">
<img src="<?php echo $webroot_path;?>/as/hm/hm-logo.png" alt="logo" /> 
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
<!-- BEGIN LOGIN FORM -->
<form id="contact-form" method="post" class="form-vertical login-form"  />
<fieldset>
<h3 class="form-title">Sign Up</h3>


<div class="control-group">
<label class="control-label" style="font-size:16px;">Society </label>
<div class="controls">
<select style="width:100%; font-size:16px;" onChange="society_wing()" id="soc_wing" class="m-wrap chosen " name="society"  data-placeholder="Choose a Category"   tabindex="1">
<option value="" >--Select Name of The Society--</option>
<?php 

foreach ($result as $db) 
{
$society_id=$db['society']["society_id"];
$society_name=$db['society']["society_name"];
?>
<option value="<?php echo $society_id; ?>"><?php echo $society_name; ?></option>
<?php } ?>
</select>
</div>
</div>


<div class="control-group">
<label class="control-label" style="font-size:16px;">Owner </label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" id="ty" onClick="commite()"name="tenant"  value="1"  style="opacity: 0; font-size:14px;" class="owner_tenant" ></span></div>
<span style="font-size:16px;"> Yes</span>
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" onClick="commite()" name="tenant" id="tno" value="2" checked  style="opacity: 0; font-size:14px;" class="owner_tenant"  ></span></div>
<span style="font-size:16px;"> No </span>
</label>  

</div>
</div>



<div class="control-group" id="resident_show" style="display:none;">
<label class="control-label" style="font-size:16px;">Committe Member</label>
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





<div class="control-group" id="echo_wing">
<!-- <label class="control-label" style="font-size:14px;">Society </label>-->
<div class="controls">
<select style="width:100%; font-size:16px;" class="m-wrap" name="wing"  data-placeholder="Choose a Category"   tabindex="1">
<option value="" style="">--Wing(Block)--</option>
</select>
</div>
</div>

<div class="control-group" id="echo_flat">
<div class="controls">
<select style="width:100%; font-size:16px;" class="m-wrap" name="flat"  data-placeholder="Choose a Category"   tabindex="1">
<option value="" style="">--Flat--</option>
</select>
</div>
</div>




<div class="form-actions">
<a href="sign_up_next?user=<?php echo $user_id; ?>" class="btn" style="font-size:16px;">Back</a>
<button type="submit" name="sub" class="btn blue pull-right" style="font-size:16px;">SIGN UP</button>
</div>


</fieldset>
</form>
<!-- END LOGIN FORM -->        
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
	
  ignore: 'null', 
rules: {

city: {

required: true
},
society: {

required: true
},
committe: {

required: true
},
tenant: {

//required: true,

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
residing: {
required: true,
}
},
messages: {
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
		$(document).ready(function() {
		$("#tno").click(function(){
		$("#resident_show").hide();
		//$("#tno").hide();
		
		});
		$("#ty").click(function(){
			$("#resident_show").show();
		//$("#other_show").show();
		
		});
		});
	}
</script>
