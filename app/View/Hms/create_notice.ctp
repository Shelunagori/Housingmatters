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
$(document).ready(function() {
	$( "#publish" ).mouseover(function() {
	var code=$("#summernote").code();
$("#textarea").val(code);
	});
		

});

</script>


  <!-- BEGIN VALIDATION STATES-->
  <div class="portlet box green" style="margin: 0px auto;width: 90%;">
	 <div class="portlet-title">
		<h4><i class="icon-reorder"></i>Create Notice</h4>
	 </div>
	 <div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form id="contact-form" method="POST" class="form-horizontal" enctype="multipart/form-data" onSubmit="return doSomeWork()">
			<div class="control-group">
			<div class="controls">
			 <label class="" style="font-size:14px;">Category<span style="color:red;">*</span> </label>
				 <select id="city" onchange="select_locality()" class=" span8 m-wrap " name="notice_category"  data-placeholder="Choose a Category"   tabindex="1">
					<option value="">--Please select any category--*</option>
					<?php
					
					foreach($result1 as $data)
					{
					 echo $category_id=$data['master_notice_category']['category_id'];
					 $category_name=$data['master_notice_category']['category_name'];
					
					 ?>
					 <option value="<?php echo $category_id; ?>" ><?php echo $category_name; ?> </option>
					 <?php } ?>
				 </select>
				 <label id="city"></label>
			 </div>
			</div>
			
			<div class="control-group">
				<div class="controls">
				<label class="" style="font-size:14px;">Subject<span style="color:red;">*</span><span style="font-size:12px; color:#999;">(Maximum 100 characters.)</span> </label>
				<input type="text" maxlength="100" class="span8 m-wrap" id="alloptions" placeholder="Subject for e.g. Power shut down" name="notice_subject" >
				<label id="alloptions"></label>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
				<label class="" style="font-size:14px;">Expires By<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Your notice will expire by this date and Archived"> </i></label>
				<input type="text"  class="span4 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Please select date" name="notice_expire_date" id="notice_expire_date">
				<label id="notice_expire_date"></label>
				</div>
			</div>	
			
			<div class="controls">
				<div id="summernote"></div>
				<textarea name="description" id="textarea" style="display:none;"></textarea>
			</div>
			<div class="control-group">
			  <label class="control-label"><i class=" icon-paper-clip" style="font-size:18px;"></i> Attachment</label>
			  <div class="controls">
				 <div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="input-append">
					   <div class="uneditable-input">
						  <i class="icon-file fileupload-exists"></i> 
						  <span class="fileupload-preview"></span>
					   </div>
					   <span class="btn btn-file">
					   <span class="fileupload-new">Select file</span>
					   <span class="fileupload-exists">Change</span>
					   <input type="file" class="default" name='file'>
					   </span>
					   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					</div>
				 </div>
			  </div>
		   </div>
		   
		   
		   
		   
		   
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
			 <button type="submit" class="btn green tooltips" data-placement="bottom" data-original-title="Click to publish your notice" name="publish" id="publish"  >Publish</button>

			 &nbsp
			 <button type="submit" class="btn green tooltips" data-placement="bottom" data-original-title="Click to save your notice" name="draft" id="publish" >Save as draft</button>
		   </div>
		</form>
		<!-- END FORM-->
	 </div>
  </div>
  <!-- END VALIDATION STATES-->


<script>
$(document).ready(function(){
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


$.validator.addMethod('requirecheck1', function (value, element) {
	 return $('.requirecheck1:checked').size() > 0;
}, 'Please check at least one role.');

$.validator.addMethod('requirecheck2', function (value, element) {
	 return $('.requirecheck2:checked').size() > 0;
}, 'Please check at least one wing.');

$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
});





$(document).ready(function(){

	var checkboxes = $('.requirecheck1');
			var checkbox_names = $.map(checkboxes, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			
			var checkboxes2 = $('.requirecheck2');
			var checkbox_names2 = $.map(checkboxes2, function(e, i) {
				return $(e).attr("name")
			}).join(" ");

$.validator.setDefaults({ ignore: ":hidden:not(select)" });
$('#contact-form').validate({

			errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	    groups: {
            asdfg: checkbox_names,
			qwerty: checkbox_names2
        },
	
 ignore: ":hidden:not(textarea)",   
rules: {
  notice_category: {
   
	required: true
  },
  description: {
   
	//remote:"content_check_des"
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
				maxlength: "Please Maximum 50 characters."
			},
			description:{
			remote: "You have enter wrong word."
			
			}
		},
	highlight: function(element) {
		$(element).closest('.control-group').removeClass('success').addClass('error');
	},
	success: function(element) {
		element
		.text('OK!').addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	},
	
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

