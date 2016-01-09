<style>
.topic:hover{
/*background-color:#8CC1FD !important; color:#FFF !important;*/
border-color:#169ef4 !important;

}
.blue{
background-color:#169ef4 !important;
color:#FFF !important;	
}
.animated {
	-webkit-transition: height 0.2s;
	-moz-transition: height 0.2s;
	transition: height 0.2s;
}


.showme{
display:none;
}
.showhim:hover .showme{
display:block;
}
</style>  

<div style="border-bottom:solid 1px #ccc; overflow:auto; background-color: rgba(250, 250, 250, 0.59);" class="hide_at_print">
<div class="pull-left"><h4 style="color:#269abc;">&nbsp;<i class="icon-comments"></i> <b>Discussion Forum</b></h4></div>

<div class="pull-right" style="padding-top:2px;">

<a href="<?php echo $webroot_path; ?>Discussions/index/<?php echo @$id; ?>/0" role='button' rel="tab" class="btn" style=" background-color: #398439;color:#fff;" ><i class="icon-cloud"></i> All Topics</a>
<a href="<?php echo $webroot_path; ?>Discussions/index/<?php echo @$id; ?>/1" role='button' rel="tab" class="btn" style=" background-color: #d58512; color:#fff;"><i class="icon-heart"></i> My Topics</a>
<a href="<?php echo $webroot_path; ?>Discussions/new_topic" role='button' rel="tab" class="btn" style="background-color: #357ebd; color:#fff;"><i class=" icon-plus-sign"></i> Start Topic</a>
<input type="text" class="m-wrap" id="search_topic_box" placeholder="Search Topic" onkeyup="search_topic()" style="background-color: #FFF !important;height: 22px;">
<a href="<?php echo $webroot_path; ?>Discussions/index/<?php echo @$id; ?>/2" role='button' rel="tab" class="btn black"><i class="icon-trash"></i> Archives</a>
</div>

</div>


<!---------last 3 section start------------------>
<form  method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
<div class="row-fluid">
	<div class="span6" style="padding: 15px;">
	
	<!-------content----------->
	<div class="control-group ">
		<div class="controls">
		<label  style="font-size:14px;">Topic Name <span style="font-size:12px; color:#999;">(Maximum 100 characters.)</span></label>
		<input type="text" class="span12 m-wrap" id="alloptions" style="background-color: #fff !important;" maxlength="100"  name="topic" >
		<label id="alloptions" ></label>
		</div>
	</div>
	<div class="control-group ">
		<div class="controls">
		<label class="" style="font-size:14px;">Description  <span style="font-size:12px; color:#999;">(Maximum 500 characters.)</span></label>
		<textarea class="span8 m-wrap" id="textarea" maxlength="500" style="background-color: #fff !important; resize:none; width:100%" name=description onkeyup=limiter()  rows="4"></textarea>
		<label id="textarea" ></label>
		</div>
	</div>
	
	
	
	
	
	<div class="controls">
	
	<label class="" style="font-size:14px;">Image &nbsp; (Limit 1MB)</label>
	<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="fileupload-new thumbnail" style="width: 150px; height: 75px;">
	<img src="http://www.placehold.it/150x75/EFEFEF/AAAAAA&amp;text=no+image" alt="">
	</div>
	<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 75px; line-height: 10px;"></div>
	<div>
	<span class="btn  btn-file" ><span class="fileupload-new" ><i class="icon-camera"></i> Select image</span>
	<span class="fileupload-exists">Change</span>
	<input type="file" name="file" id="file" class="default"></span>
	<a href="#" role='button' class="btn  fileupload-exists" data-dismiss="fileupload" >Remove</a>
<span>Allowed: jpg,gif</span>
	</div>
	</div>
	</div>
	<label id="file" ></label>
	<!-------content----------->
	</div>
	<div class="span6">
	<!-------content----------->
<div>
	<!---------------start visible-------------------------------->
	<label class="" style="font-size:14px;">Discussion should be visible to<span style="color:red;">*</span>   <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please select any one"> </i></label>

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
	</div><br/><br/>
	<label id="requirecheck2"></label>
	</div>
	<!---------------end visible-------------------------------->	
</div>

<br/><br/>
<div style="padding-top:25px;"><button type="submit" class="btn green" name="sub">Start Topic</button></div>


	<!-------content----------->
	
	</div>
</div>
<!---------last 3 section end------------------>
</form>
	


<div id="delete_topic_result"></div>

 
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
		
		
		rules: {
	      topic: {
	       
	        required: true,
			maxlength: 100
	      },
		  
		  description: {
	        required: true,
			maxlength: 500,
			//remote:"<?php echo $webroot_path;?>hms/content_check_des"
	      },
		  file: {
			accept: "gif,jpg",
			filesize: 1048576
	      },
		 
	    },
		messages: {
	                topic: {
	                    maxlength: "Maximum 100 characters only."
	                },
					file: {
						accept: "File extension must be gif or jpg",
	                    filesize: "File size must be less than 1MB."
	                },
					description: {
	                    maxlength: "Max 500 characters allowed.",
						remote:"You have enter wrong word."
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
function my_topic(q)
{
$('#topics_list').html('<div style="border:solid 2px #F4F8FF; padding:5px;" align="center"><img src="<?php echo $webroot_path ; ?>/as/windows.gif" /></div>').load('discussion_my_topic?q=' + q);
}



function details_topic(t)
{
//$("#topic_detail").removeClass('animated zoomIn');
$("#topic_detail").removeClass('fadeleftsome');
$('#topic_detail').html('<div style="border:solid 2px #F4F8FF; margin-top:25px;" align="center"><img src="<?php echo $webroot_path ; ?>/as/windows.gif" /></div>').load('topic_view?t=' + t);

}

function details_topic_deleted(x)
{
$("#topic_detail").removeClass('fadeleftsome');
$('#topic_detail').html('<div style="border:solid 2px #F4F8FF; margin-top:25px;" align="center"><img src="<?php echo $webroot_path ; ?>/as/windows.gif" /></div>').load('topic_view_deleted?t=' + x);

}


function comment(tid)
{

var old_c=$('#posttext').val()
var c=encodeURIComponent(old_c);
var u_name='<?php echo $user_name; ?>';
var flat='<?php echo $flat_info; ?>';
if(c!="")
{
$('#post_comment').hide();
	$( "#save_comment" ).load( 'discussion_save_comment?tid=' + tid+'&c='+c, function() {
		$('#comments_container').load('discussion_comment_refresh?con='+tid);
		$('#posttext').val('');
		$('#post_comment').show();
	});
}
}
</script>

<script>
$(document).ready(function() {
	$("body").live('click',function(){
		$('.animated').autosize();
	});
});
</script>


<script>
function delete_topic(dt)
{
$('#delete_topic_result').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to archive the topic & close it for further discussion ? </div><div class="modal-footer"><a href="discussion_delete_topic?con='+dt+'" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');

$("#can").live('click',function(){
   $('#pp').hide();
});
}
</script>

<script>
function delete_topic_archive(dt)
{

$('#delete_topic_result').html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Sure, you want to delete the discussion permanently ?</div><div class="modal-footer"><a href="discussion_delete_topic_archive?con='+dt+'" class="btn blue" id="yes">Yes</a><a href="#" role="button" id="can" class="btn">No</a></div></div></div>');

$("#can").live('click',function(){
   $('#pp').hide();
});
}
</script>


<script>
function delete_comment(cm_id)
{

$('#delete_topic_result').html('<div id="main_div"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:16px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Sure, you want to delete the comment ?</div><div class="modal-footer"><a href="#" role="button" class="btn blue" id="yes" onclick="hide_comment_div('+cm_id+')">Yes</a><a href="#" role="button" id="no" class="btn">No</a></div></div></div>');

$("#no").live('click',function(){
  $('#main_div').hide();
});

}


function offensive_delete(co_id,co_u_id)
{
 $('#comm'+co_id).load('<?php echo $webroot_path ; ?>/Discussions/discussion_offensive_delete_ajax?c_id='+co_id +'&c_u_id='+co_u_id);
 $('#comm'+co_id).addClass('animated zoomOut');
setTimeout(
  function() 
  {
   
  $('#comm'+co_id).hide();
  }, 500);

 
}

function hide_comment_div(ca)
{
$('#delete_topic_result').load('<?php echo $webroot_path ; ?>/Discussions/discussion_comment_delete_ajax?c_id='+ca);
$('#main_div').hide();
$('#comm'+ca).addClass('animated zoomOut');
setTimeout(
  function() 
  {
    $('#comm'+ca).hide();
  }, 500);
}
</script>

<script>

function search_topic()
{

var s=$('#search_topic_box').val();
$('#topics_list').html('<div style="border:solid 2px #F4F8FF; padding:5px;" align="center"><img src="<?php echo $webroot_path ; ?>/as/windows.gif" /></div>').load('discussion_search_topic?s='+s);
}
</script>


<script>
$(document).ready(function() {
	$(".sel").live('click',function(){
			$(".topic").removeClass("blue");
			 $(this).addClass("blue");
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
<script src="<?php echo $webroot_path ; ?>/as/bootstrap-maxlength.min.js"></script>
	
<script>
	$(document).ready(function () {
		$(
			'input#alloptions'
		).maxlength({
			alwaysShow: true,
			warningClass: "label label-success",
			limitReachedClass: "label label-warning",
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
	});
</script>
