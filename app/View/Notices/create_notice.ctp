<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div class="portlet box" style="background-color:#4B77BE;">
<div class="portlet-title" >
<h4 class="block"><i class="icon-bullhorn"></i> Create New Notice</h4>
</div>
<div class="portlet-body form" style=" border: solid 1px #4B77BE; ">
<!-- BEGIN FORM-->
<form method="POST" class="form-horizontal">
   <div class="row-fluid">
		<div class="span6">
			<label class="" style="font-size:14px;">Subject<span style="color:red;">*</span><span style="font-size:12px; color:#999;">(Maximum 100 characters.)</span> </label>
			<input type="text" maxlength="100" class="span12 m-wrap" placeholder="Subject for e.g. Power shut down" name="notice_subject" >
		</div>
		<div class="span3" >
			<label class="" style="font-size:14px;">Category<span style="color:red;">*</span></label>
			<select class="span12 m-wrap " name="notice_category"   tabindex="1">
			<option value="">--Please select any category--*</option>
			<?php	foreach($result1 as $data){
			echo $category_id=$data['master_notice_category']['category_id'];
			$category_name=$data['master_notice_category']['category_name']; ?>
				<option value="<?php echo $category_id; ?>" ><?php echo $category_name; ?> </option>
			<?php } ?>
			</select>
		</div>
		<div class="span3" >
			<label class="" style="font-size:14px;">Expires By<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Your notice will expire by this date and Archived"> </i></label>
			<input type="text"  class="span12 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Please select date" name="notice_expire_date">
		</div>
	</div>
	
	
	<br/>
	<label class="" style="font-size:14px;">Notice<span style="color:red;">*</span></label>
	<div id="summernote"></div>
	
	<br/>
	<!---------------start visible-------------------------------->
			<div class="controls">
			<label class="" style="font-size:14px;">Notice should be visible to<span style="color:red;">*</span>   <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select any one"> </i></label>
			</div>
			
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
			<div class="checker"><span><input type="checkbox"  value="<?php echo $role_id; ?>" name="role<?php echo $role_id; ?>" class="v2 requirecheck1" id="requirecheck123"></span></div> <?php echo $role_name; ?>
			</label>
			<?php } ?>
			<label  id="requirecheck123"></label>
			</div>
			
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
			<br/><label id="requirecheck2"></label>
			</div><br/>
			
			</div>
		<!---------------end visible-------------------------------->
	
	<div class="form-actions">
	  <button type="submit" class="btn blue" name="publish">publish</button>
	  <button type="button" class="btn">Cancel</button>
	</div>
</form>
<!-- END FORM-->
</div>
</div>
<div id="output"></div>				  


<script>
$(document).ready(function(){
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

				  
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
<link href="<?php echo $webroot_path ; ?>summernote.css" rel="stylesheet">
<script src="<?php echo $webroot_path ; ?>summernote.min.js"></script>

<script>
$(document).ready(function() {
$('#summernote').summernote({
  height: 300,   
});
});
</script>


