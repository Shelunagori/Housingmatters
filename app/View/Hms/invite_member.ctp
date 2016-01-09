
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<script>
 setTimeout( function(){$('#showing').hide();} , 2000);
  setTimeout( function(){$('#showing1').hide();} , 2000);
</script>
 <div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
               <i class="icon-credit-card"></i> Invite to HousingMatters <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="invite others members to join housingmatters"> </i>
                 </div>
				
				
				
<form method="post"  id="contact-form">			
<div class="portlet-body" style="padding:10px;width:80%; margin-left:7%" >
<!--BEGIN TABS-->
<div class="tabbable tabbable-custom">
<div class="tab-content" style="min-height:200px; ">
<div class="tab-pane active" id="tab_1_1">
<div class="control-group">
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span>
<input type="radio" name="committe" value="1" id="resident"  onClick="commite()"  style="opacity: 0; font-size:14px;" >
</span></div>
<span style="font-size:16px;">Your society residents</span>
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span class="checked">
<input type="radio" onClick="commite()"  name="committe" value="2"  id="other"  style="opacity: 0; font-size:14px;"" ></span></div>
<span style="font-size:16px;"> Others </span>
</label>  
</div>
</div>
<br>

<div  id="resident_show" style="display:none;">
<div class="alert alert-info"  style="width:40%; " ><strong style="color:#33C; font-family:Georgia, 'Times New Roman', Times, serif;">Info!</strong>
<span style="font-family:Georgia, 'Times New Roman', Times, serif; color:#60C;">You can invite your society residents to signup into housingmatters and join your society portal. </span>
</div>

<input type="hidden" id="t_box" name="hid_name" value="2">
 <table style="width:40%;" class="table_1">
 <tr>
 <td> <input type="text"  class="m-wrap large" name="name_user2" value="" id='' style="font-size:16px;" placeholder="Please type Name" ></td>
 <td> <input type="text"  class="m-wrap large" name="email2" value="" id='text_email' style="font-size:16px;" placeholder="Please type valid email address" >
 </td>
  <!--<td> <input type="text"  class="m-wrap large" name="mobile2" value="" id='text_mob' style="font-size:16px;" placeholder="Please type valid mobile number" maxlength="10">
 </td>-->
 
 </tr>
 </table>
<div>
<span><button type="button" name="" class="btn blue " style="font-size:16px;" id="btn1">Add</button></span>
<span><button type="button" name="" class="btn blue" style="font-size:16px;" id="btn2">Remove</button></span>
<span><button type="submit" name="sub" class="btn blue" style="font-size:16px;">Send</button></span>
 </div>
 </form>
</div>
<div  id="other_show" style="display:none;">
<div class="alert alert-info"  style="width:40%; " ><strong style="color:#33C; font-family:Georgia, 'Times New Roman', Times, serif;">Info!</strong>
<span style="font-family:Georgia, 'Times New Roman', Times, serif; color:#60C;">you can invite your friends to signup into housingmatters for their society </span>
</div>
<form method="post"  id="contact-form1">
<input type="hidden" id="t_box1" name="hid_name" value="2">
 <table style="width:40%;" class="table_2">
 <tr>
 <td> <input type="text"  class="m-wrap large" name="name_user2" value="" id='' style="font-size:16px;" placeholder="Please type Name" ></td>
 <td> <input type="text"  class="m-wrap large" name="email2" value="" id='text_email' style="font-size:16px;" placeholder="Please type valid email address" >
 </td>
 <!--<td> <input type="text"  class="m-wrap large" name="mobile2" value="" id='text_mob' style="font-size:16px;" placeholder="Please type valid mobile number" maxlength="10">
 </td>-->
 </tr>
 </table>
<div>
<span style=""><button type="button" name="" class="btn blue" style="font-size:16px;" id="btn3">Add</button></span>
<span><button type="button" name="" class="btn blue " style="font-size:16px;" id="btn4">Remove</button> </span>
<span> <button type="submit" name="sub" class="btn blue" style="font-size:16px;">Send</button> </span>
 </div>
 </form>

</div>
</div>
</div>
</div>
<!--END TABS-->
</div>
								
							
				
				 
				
 <?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
                
              
                                
				<!-- END PAGE CONTENT-->
			</div>
			

<script>
$(document).ready(function(){
$('#contact-form').validate({
rules: {
name_user2: {
required: true,
},
email2: {
required: true,
email: true
},
mobile2: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user3: {
required: true,
},
email3: {
required: true,
email: true
},
mobile3: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},

name_user4: {
required: true,
},
email4: {
required: true,
email: true
},
mobile4: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user5: {
required: true,
},
email5: {
required: true,
email: true
},
mobile5: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user6: {
required: true,
},
email6: {
required: true,
email: true
},
mobile6: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user7: {
required: true,
},
email7: {
required: true,
email: true
},
mobile7: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user8: {
required: true,
},
email8: {
required: true,
email: true
},
mobile8: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user9: {
required: true,
},
email9: {
required: true,
email: true
},
mobile9: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user10: {
required: true,
},
email10: {
required: true,
email: true
},
mobile10: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user11: {
required: true,
},
email11: {
required: true,
email: true
},
mobile11: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
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

$('#contact-form1').validate({
rules: {
name_user2:{
required: true,
},
email2: {
required: true,
email: true
},
mobile2: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user3: {
required: true,
},
email3: {
required: true,
email: true
},
mobile3: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},

name_user4: {
required: true,
},
email4: {
required: true,
email: true
},
mobile4: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user5: {
required: true,
},
email5: {
required: true,
email: true
},
mobile5: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user6: {
required: true,
},
email6: {
required: true,
email: true
},
mobile6: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user7: {
required: true,
},
email7: {
required: true,
email: true
},
mobile7: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user8: {
required: true,
},
email8: {
required: true,
email: true
},
mobile8: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user9: {
required: true,
},
email9: {
required: true,
email: true
},
mobile9: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user10: {
required: true,
},
email10: {
required: true,
email: true
},
mobile10: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
},
name_user11: {
required: true,
},
email11: {
required: true,
email: true
},
mobile11: {
required: true,
number: true,
minlength: 10,
maxlength: 10,
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

	
<script>
	function commite()
	{
		
		$("#resident").click(function(){
		$("#resident_show").show();
		$("#other_show").hide();
		
		});
		$("#other").click(function(){
			$("#resident_show").hide();
		$("#other_show").show();
		
		});
		
	}
    </script>
	
<script>
$(document).ready(function(){
$("#btn1").click(function(){
var d=$("#t_box").val();
d++;
if(d!=12)
{
$("#t_box").val(d);

$("table.table_1").append("<tr id=tab"+d+"><td><input type='text'  class='m-wrap large' name='name_user"+d+"'  style='font-size:16px;' placeholder='Please type Name'></td><td><input type='text'  class='m-wrap large' name='email"+d+"'  style='font-size:16px;' placeholder='Please type valid email address'></td></tr>");
}});
 $("#btn2").click(function(){
 var d=$("#t_box").val();
 $("#tab"+d ).remove();
 d--;
 $("#t_box").val(d);
  }); 
});
</script>
<script>
$(document).ready(function(){
$("#btn3").click(function(){
var d=$("#t_box1").val();
d++;
if(d!=12)
{
$("#t_box1").val(d);

$("table.table_2").append("<tr id=tab1"+d+"><td><input type='text'  class='m-wrap large' name='name_user"+d+"'  style='font-size:16px;' placeholder='Please type Name'></td><td><input type='text'  class='m-wrap large' name='email"+d+"'  style='font-size:16px;' placeholder='Please type valid email address'></td></tr>");
}});
 $("#btn4").click(function(){
 var d=$("#t_box1").val();
 $("#tab1"+d ).remove();
 d--;
 $("#t_box1").val(d);
  }); 
  
<?php

$status1=(int)$this->Session->read('invite_status');
if($status1==1)
{

?>
  $.gritter.add({
               
					title: '<i class="icon-credit-card"></i> Invitations',
					text: 'This Email is sent successfully.<p><strong> Thank you for refering us.</strong></p>',
					sticky: false,
					time: '10000',

            });


<?php 
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(17)));
}   
?>
  
});
</script>