<div class="row-fluid">
			<div class="span12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
				
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
<div class="portlet box green" style="width:70%; margin-left:15%;" >
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i> Feedback/Contact HousingMatters</h4>
			 </div>
			 <div class="portlet-body form">
				<h3 class="block"></h3>
				<!-- BEGIN FORM-->
				<form  id="contact-form" class="form-horizontal" method="post" name="myform" enctype="multipart/form-data">
				 <fieldset>
				   <div class="control-group ">
					  <div class="controls">
		   <label class="" style="font-size:14px;" >Name of Resident:  &nbsp;&nbsp;<font> <b><?php echo $user_name;?></b></font></label>  
					  </div>
				   </div>
				   <div class="control-group ">
					  <div class="controls">
					   <label class="" style="font-size:14px;">Category </label>
						 <select name="sel" class="span8 m-wrap chosen" >
					<option value="">Select Category</option>
					<?php
				
	
		foreach ($result_fed_cat as $collection) 
		{
			$feedback_cat_id=$collection['feedback_category']["feedback_cat_id"];
			$feedback_cat_name=$collection['feedback_category']["feedback_cat_name"];
		
		?>
					<option value="<?php echo $feedback_cat_id ?> "><?php echo $feedback_cat_name ?></option>
					<?php } ?>
					</select> 
												 
					  </div>
				   </div>
			   <div class="control-group ">
					  <div class="controls">
					   <label class="" style="font-size:14px;" >Subject</label>
						 <input type="text" class="span8 m-wrap"  name="subject">
					  </div>
				   </div>
							  
						 <div class="control-group ">
					  <div class="controls">
					   <label class="" style="font-size:14px;" >Message</label>
					  <textarea rows="7" name=mess class="span8 m-wrap" style="resize:none;" > </textarea>
					  </div>
				   </div>
					 
				   
				   
				   <div class="form-actions">
					  <input type="submit" class="btn green tooltips "  data-placement="bottom" data-original-title="Click Feedback for  housingmatters " value="Submit" name="sub">
				   </div>
				   </fieldset>
				</form>
				<!-- END FORM-->
			 </div>
</div>
<script>
$(document).ready(function(){
$('#contact-form').validate({
 ignore: 'null', 
rules: {
  title: {
   
	required: true
  },
   mess: {
   
	required: true
  },
   subject: {
   
	required: true
  },
 
   sel: {
   
	required: true
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