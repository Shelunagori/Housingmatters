<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
	$( "#publish" ).mouseover(function() {
	
	var code=$("#summernote").code();
$("#textarea").val(code);
	});
		

});

</script>
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
				<label class="" style="font-size:14px;">Subject<span style="color:red;">*</span><span style="font-size:12px; color:#999;">(Maximum 100 characters.)</span> </label>
				<input type="text" value="<?php echo $n_subject; ?>" id="alloptions" class="span8 m-wrap" id="notice_sub_id" maxlength="100" placeholder="Subject for e.g. Power shut down" name="notice_subject">
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
				<label class="" style="font-size:14px;">Expires By<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Your notice will expire by this date and Archived"> </i></label>
				<input type="text"  class="span8 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Please select date" name="notice_expire_date" value="<?php echo $n_date; ?>">
				</div>
			</div>	
			
			<div class="controls">
				<div id="summernote"></div>
				<textarea name="Editor3" id="textarea" style="display:none;"></textarea>
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
			 <button type="submit" class="btn green tooltips" id="publish" data-placement="bottom" data-original-title="Click to publish your notice" name="publish_d" value="xyz">Publish</button>
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


<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
<link href="<?php echo $this->webroot ; ?>summernote.css" rel="stylesheet">
<script src="<?php echo $this->webroot ; ?>summernote.min.js"></script>

<script>
$(document).ready(function() {
 // $('#summernote').summernote();
  $('#summernote').summernote({
	  height: 150,   //set editable area's height
	  codemirror: { // codemirror options
		theme: 'monokai'
	  },
	  toolbar: [
    //[groupname, [button list]]
     
   
	['style', ['style' ,'bold', 'italic', 'underline' , 'strikethrough', 'clear']],
	['font', ['strikethrough']],
	['color', ['color']],
    ['fontsize', ['fontsize', 'fontname',]],
    ['Layout', ['ul', 'ol', 'height']],
	['paragraph', [ 'paragraph']],
    ['Misc', ['fullscreen'  , 'undo' , 'redo']],
    ['Insert', ['table' , 'hr']],
  ]
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
			maxlength:100
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
	                    maxlength: "Please Maximum 100 characters."
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

<script src="<?php echo $this->webroot ; ?>/as/bootstrap-maxlength.min.js"></script>
<script>
        $(document).ready(function () {
            $(
                'input#defaultconfig'
            ).maxlength()

            $(
                'input#thresholdconfig'
            ).maxlength({
                threshold: 20
            });

            $(
                'input#moreoptions'
            ).maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-danger"
            });

            $(
                'input#alloptions'
            ).maxlength({
                alwaysShow: true,
                warningClass: "label label-success",
                limitReachedClass: "label label-important",
                separator: ' out of ',
                preText: 'You typed ',
                postText: ' chars available.',
                validate: true
            });

            $(
                'textarea#textarea'
            ).maxlength({
                alwaysShow: true
            });

            $('input#placement')
                .maxlength({
                    alwaysShow: true,
                    placement: 'top-left'
                });

            hljs.initHighlightingOnLoad();

        });
    </script>