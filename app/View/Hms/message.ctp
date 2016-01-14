<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<div style="padding:5px;" align="center">
<a href="message_view" class="btn blue">SMS History</a>
<a href="message" class="btn red">Send SMS</a>
</div>


<div style="border:solid 2px #4cae4c; width:80%; margin-left:10%;">
<div style="border-bottom:solid 2px #4cae4c; color:white; background-color: #5cb85c; padding:4px; font-size:20px;" ><i class="icon-envelope-alt"></i> Send SMS</div>
<div style="padding:10px;background-color:#FFF;">
<!----------------------------------------------->
<form method="post">
<div class="controls">
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r1" checked name="radio" value="1" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send SMS to Individual</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio"  id="r3"  name="radio" value="3" style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send SMS to Default Groups</span>
 </label>
 <label class="radio">
 <div class="radio" id="uniform-undefined"><input type="radio" id="r2" name="radio" value="2"  style="opacity: 0;"></div>
 <span style="font-size:16px;" >Send SMS to Custom Groups</span>
 </label>  
</div>
<label style="font-size:14px; font-weight:bold;">To <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="SMS will be sent to only those users whose valid mobile numbers are registered with HousingMatters"> </i></label>
<!------------------------->
<div class="control-group" id="d1" >
  <div class="controls">
   
	 <select data-placeholder="Type or select name"  name="multi[]" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
<?php
foreach ($result_users as $collection) 
{
$user_id=$collection["user"]["user_id"];
$user_name=$collection["user"]["user_name"];
$mobile=$collection["user"]["mobile"];
$wing=$collection["user"]["wing"];
$flat=$collection["user"]["flat"];

$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

?>
<option value="<?php echo $user_id; ?>,<?php echo $mobile; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat; ?>,<?php echo $mobile; ?></option>
<?php } ?>           
		  
	 </select>
  </div>
</div>
<!------------------------->

<!-------------------------->

<div style="display:none; padding:5px;" id="d2" >
<?php
foreach ($result_group as $collection) 
{
$group_name=$collection["group"]["group_name"];
$group_id=$collection["group"]["group_id"];
?>
<label class="checkbox">
<input type="checkbox" name="grp<?php echo $group_id; ?>" value="<?php echo $group_id; ?>"> <?php echo $group_name; ?>
</label>
<?php } ?> 
</div>
<!--------------------------->


<!-------------------------->

<div style="display:none; padding:5px;" id="d3" >
<!---------------start visible-------------------------------->
			
			<div class="controls">
			<label class="radio line">
			<div class="radio"><span><input type="radio" checked name="visible" value="1" id="v1"></span></div>All Users
			</label>
			</div>
			
			<div class="controls">
			<label class="radio line">
			<div class="radio"><span><input type="radio"  name="visible" value="4" id="v1"></span></div>All Owners  
			</label>
			</div>
			
			<div class="controls">
			<label class="radio line">
			<div class="radio"><span><input type="radio"  name="visible" value="5" id="v1"></span></div>All Tenant
			</label>
			</div>
			
			
			<div class="controls">
			<label class="radio line">
			<div class="radio" ><span><input type="radio"  name="visible" value="2" id="v2" ></span></div>Role Wise
			</label>
			</div>
			<div id="show_2" style="display:none; margin-left:5%;">
			<div class="controls">
			<?php
			foreach ($role_result as $collection) 
			{
			$role_id=$collection["role"]["role_id"];
			$role_name=$collection["role"]["role_name"];
			?>
			<label class="checkbox">
			<div class="checker"><span><input type="checkbox"  value="<?php echo $role_id; ?>" name="role<?php echo $role_id; ?>" class="v2 requirecheck1" id="requirecheck1"></span></div> <?php echo $role_name; ?>
			</label>
			<?php } ?>
			</div>
			<label  id="requirecheck1"></label>
			</div>

			<div class="controls">
			<label class="radio line">
			<div class="radio"><span><input type="radio" name="visible" value="3" id="v3" ></span></div>Wing Wise
			</label> 
			</div>
			<div id="show_3" style="display:none; margin-left:5%;">
			<div class="controls">
			<?php
			foreach ($wing_result as $collection) 
			{
			$wing_id=$collection["wing"]["wing_id"];
			$wing_name=$collection["wing"]["wing_name"];
			?>
			<div style="float:left; padding-left:15px;">
			<label class="checkbox" >
			<div class="checker"><span><input type="checkbox"  value="<?php echo $wing_id; ?>" name="wing<?php echo $wing_id; ?>" class="v3 requirecheck2" id="requirecheck2" ></span></div> <?php echo $wing_name; ?>
			</label>
			</div>
			<?php } ?>
			</div><br/>
			<label id="requirecheck2"></label>
			</div>
			<!---------------end visible-------------------------------->
</div>
<!--------------------------->

<div class="control-group">                    
<div class="controls">
<table  width="100%">
<tr>
<td><label style="font-size:14px; font-weight:bold;">Message</label></td>
<td><div  style="float:right;">
<span style="background-color:#d84a38; color:white; padding:2px;">Note</span>: Please restrict your message length to 459 characters in one message.
</div></td>
</tr>
</table>
 <textarea  style="resize:none;font-size: 18px;" class="m-wrap span12"  onKeyUp="count_msg()" id="massage" name="massage" rows="7"></textarea>
 <table width="100%">
 <tr>
 <td>
 <div id="count_result"><span style="font-size:14px; color:#666; font-weight:bold;">No. of Messages</span><input type="text" style="width:80px; background-color:#008000; color:#FFF;" value="0 / 1 SMS" readonly ></div></td>
 <td>
 <a href="#myModal3" role="button" class="btn blue pull-right" data-toggle="modal">Templates</a>
 <div id="myModal3" style="margin-top:-5%;" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel3">Select Template</h3>
	</div>
	
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1_1" data-toggle="tab">Events</a></li>
			<li class=""><a href="#tab_1_2" data-toggle="tab">Finance</a></li>
			<li class=""><a href="#tab_1_3" data-toggle="tab">Maintenance</a></li>
			<li class=""><a href="#tab_1_4" data-toggle="tab">Meetings</a></li>
			<li class=""><a href="#tab_1_5" data-toggle="tab">Notice</a></li>
			<li class=""><a href="#tab_1_6" data-toggle="tab">Updates</a></li>
			<li class=""><a href="#tab_1_7" data-toggle="tab">Vendors</a></li>
		</ul>
		<div class="scroller" data-height="400px">
		<!---------content---------------------->
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1_1">
			<?php
			foreach ($result_template1 as $cat1) 
			{
			$template=$cat1["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_2">
			<?php
			foreach ($result_template2 as $cat2) 
			{
			$template=$cat2["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_3">
			<?php
			foreach ($result_template3 as $cat3) 
			{
			$template=$cat3["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_4">
			<?php
			foreach ($result_template4 as $cat4) 
			{
			$template=$cat4["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_5">
			<?php
			foreach ($result_template5 as $cat5) 
			{
			$template=$cat5["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_6">
			<?php
			foreach ($result_template6 as $cat6) 
			{
			$template=$cat6["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
			
			<div class="tab-pane" id="tab_1_7">
			<?php
			foreach ($result_template7 as $cat7) 
			{
			$template=$cat7["template"]["template"];
			?>                                 
			<div class="tmplt t_hov" onClick="templt('<?php echo $template; ?>')" data-dismiss="modal">
			<?php echo $template; ?>
			</div>
			<?php } ?>
			</div>
		</div>
		<!---------content---------------------->								
		</div>


	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
 </td>
 </tr>
 </table>
</div>

</div>
<!----------------------------------------------->

<!---------------------------------------------->
<?php
date_default_timezone_set('Asia/Kolkata');
$date=date("d-m-Y");
$time=time();
$time=strtotime('+30 minutes');
$time_h = date('H', $time); 
$time_m = date('i', $time);
$r=$time_m%15;
$add=15-$r;
$m =$time_m+$add;
?>






<div class="row-fluid">
	<div class="span4">
		
		
	<div class="control-group">
	<label style="font-size:14px; font-weight:bold;">Date</label>
	<div class="controls">
	 <input class="m-wrap m-ctrl-medium date-picker" readonly name="date" size="16" data-date-format="dd-mm-yyyy" type="text" value="<?php echo $date; ?>">
	</div>
	</div>
		
		
	</div>
	<div class="span6">
		
<div class="control-group">		
<label style="font-size:14px; font-weight:bold;">Time</label>
<select class="span2 m-wrap" name="time_h">
<?php for($w=1;$w<=24;$w++) { ?>
<option value="<?php echo $w; ?>" <?php if($w==$time_h) { ?> selected <?php } ?>><?php echo $w; ?></option>
<?php } ?>

</select>

<select class="span2 m-wrap" name="time_m">
<option value="00" <?php if($m==00) { ?> selected <?php } ?>>00</option>
<option value="15" <?php if($m==15) { ?> selected <?php } ?>>15</option>
<option value="30" <?php if($m==30) { ?> selected <?php } ?>>30</option>
 <option value="45" <?php if($m==45) { ?> selected <?php } ?>>45</option>
</select>
</div>		
		
	</div>
</div>
<!----------------------->









</div>

<div class="form-actions" style="margin-bottom:0px !important;">
	<button type="submit" name="send" class="btn blue"><i class=" icon-share-alt"></i> Send</button>
</div>
</form>
</div>





<!------------------------------------------->
<script>
function count_msg()
{

	len=0; c=0;
	var c2=document.getElementById("massage").value;
	var len = c2.length;
	
	if(len<153) { var c = 1; }
	if(len>=153 && len<306) { var c = 2; }
	if(len>=306 && len<=459) { var c = 3; }
	if(len>459) { 
	var t_cut = c2.substring(0, 459);
	document.getElementById("massage").value=t_cut;
	 return false;
	 }
	
	var l=len+ ' / ' + c + ' SMS';

	
	document.getElementById("count_result").innerHTML='<span style="font-size:14px; color:#666;font-weight:bold;">No. of Messages</span><input type="text" style="width:80px; background-color:#008000; color:#FFF; " value="'+l+'" readonly id="count_result">';
	if(len==459) {
		document.getElementById("count_result").innerHTML='<span style="font-size:14px; color:#666;font-weight:bold;">No. of Messages</span><input type="text" style="width:80px;background-color:#d84a38; color:#FFF; " value="'+l+'" readonly id="count_result">';
	}

}
</script>

<script>
$(document).ready(function(){
  $("#r1").click(function(){
    $("#d2").hide();
    $("#d1").show();
	$("#d3").hide();
	
  });
  $("#r2").click(function(){
    $("#d1").hide();
    $("#d2").show();
	$("#d3").hide();
  });
  $("#r3").click(function(){
    $("#d1").hide();
    $("#d3").show();
	$("#d2").hide();
  });
});
</script>


<script>
$(document).ready(function() { 
	 $("#v3").live('click',function(){
		$("#show_3").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_1").slideUp('fast');
	 });
	 
	 $("#v2").live('click',function(){
		$("#show_2").slideDown('fast');
		$("#show_3").slideUp('fast');
		$("#show_1").slideUp('fast');
	 });
	 
	 $("#v1").live('click',function(){
		$("#show_1").slideDown('fast');
		$("#show_2").slideUp('fast');
		$("#show_3").slideUp('fast');
	 });
});
</script>

<script>
function templt(t)
{
	document.getElementById("massage").value=t;
	count_msg();
}
</script>


<style>
.tmplt{
border-bottom:solid 2px #ccc; padding:15px; font-size:16px; cursor:pointer;	
}
.t_hov:hover{
background-color:rgba(207, 202, 255, 0.32);	
}
</style>