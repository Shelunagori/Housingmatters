<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<?php


foreach($result_notices as $data)
{
$n_category_id=$data['notice']['n_category_id'];
$n_subject=$data['notice']['n_subject'];
$n_message=$data['notice']['n_message'];
$n_date=$data['notice']['n_date'];
}
?>

<div style="padding:10px;" >
  <!-- BEGIN VALIDATION STATES-->
  <div class="portlet box green">
	 <div class="portlet-title">
		<h4><i class="icon-reorder"></i>Create Notice</h4>
	 </div>
	 <div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data" onSubmit="return checkbox_validation()">
			<div class="control-group">
			<div class="controls">
			 <label class="" style="font-size:14px;">Category<span style="color:red;">*</span> </label>
				 <select id="city" onchange="select_locality()" class=" span8 m-wrap chosen " name="notice_category"  data-placeholder="Choose a Category"   tabindex="1">
					<option value="">--Please select any category--*</option>
					<?php
					
					foreach($result1 as $data)
					{
					 echo $category_id=$data['master_notice_category']['category_id'];
					 $category_name=$data['master_notice_category']['category_name'];
					
					 ?>
					 <option value="<?php echo $category_id; ?>" <?php if($category_id==$n_category_id) { ?> selected <?php } ?> ><?php echo $category_name; ?> </option>
					 <?php } ?>
				 </select>
			 </div>
			</div>
			
			<div class="control-group">
				<div class="controls">
				<label class="" style="font-size:14px;">Subject<span style="color:red;">*</span><span style="font-size:12px; color:#999;">(Maximum 50 characters.)</span> </label>
				<input type="text" value="<?php echo $n_subject; ?>" class="span8 m-wrap" id="notice_sub_id" placeholder="Subject for e.g. Power shut down" name="notice_subject">
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
				<label class="" style="font-size:14px;">Expires By<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Your notice will expire by this date and Archived"> </i></label>
				<input type="text"  class="span8 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Please select date" name="notice_expire_date">
				</div>
			</div>	
			
			<div class="controls">
				<textarea class="span12 wysihtml5 m-wrap" rows="15" name="Editor3" id="notice_pre"  placeholder="Please text here....." style="width:80%;"><?php echo $n_message; ?></textarea>
				<input type="hidden" name="_wysihtml5_mode" value="1">
			</div>
			
			<div class="control-group">
			<div class="controls">
			<label class="" style="font-size:14px;"><span style="font-size:12px; color:#999;">(Limit 2 MB)</span></label>
			<div class="fileupload fileupload-new" data-provides="fileupload">
			<span class="btn btn-file">
			<span class="fileupload-new">Attachment</span>
			<span class="fileupload-exists">Select file</span>
			<input type="file" class="default" name="file">
			</span>
			<span class="fileupload-preview"></span>
			<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
			</div>
		</div>
			</div>
				
		
							   
							   
		   <div class="form-actions">
			 <button type="submit" class="btn green tooltips" data-placement="bottom" data-original-title="Click to publish your notice" name="publish_d" value="xyz">Publish</button>
		   </div>
		</form>
		<!-- END FORM-->
	 </div>
  </div>
  <!-- END VALIDATION STATES-->
</div>

<script>
$(document).ready(function() {
	
	$("#add").live('click',function(){
		t=document.getElementById('text_box').value;
		if(t<10)
		{
		t++;
		$("#choice").append('<li class="controls" id=' + t +'><input type="text" class="span5 m-wrap" placeholder="choice'+t+' (Maximum 20 characters.)"  name="choice'+t+'"></li>');
		document.getElementById('text_box').value=t;
		}
	 });
	 
	 $("#remove").live('click',function(){
		t=document.getElementById('text_box').value;
		if(t>2)
		{
		$("#" + t).remove();
		t--;
		document.getElementById('text_box').value=t;
		}
	 });
	 
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
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      notice_category: {
	       
	        required: true
	      },
		   notice_subject: {
	        
	        required: true,
			maxlength:50
	      },
		   notice_expire_date: {
	       
	        required: true
	      },
		  notice_visible_to: {
	       
	        required: true
	      },
		  sub_visible: {
	       
	        required: true
	      },
		  
		  

	    },
		messages: {
	                notice_subject: {
	                    maxlength: "Please Maximum 50 characters."
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

