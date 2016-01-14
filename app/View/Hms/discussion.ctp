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

<a class="btn" style=" background-color: #398439;color:#fff;" onclick="my_topic(2)"><i class="icon-cloud"></i> All Topics</a>
<a class="btn" style=" background-color: #d58512; color:#fff;" onclick="my_topic(1)"><i class="icon-heart"></i> My Topics</a>
<a href="#close" role='button' data-toggle="modal" class="btn" style=" background-color: #357ebd; color:#fff;"><i class=" icon-plus-sign"></i> Start Topic</a>
<input type="text" class="m-wrap" id="search_topic_box" placeholder="Search Topic" onkeyup="search_topic()" style="background-color: #FFF !important;height: 22px;">
<a class="btn black" onclick="my_topic(3)"><i class="icon-trash"></i> Archives</a>
</div>

</div>


<table boder="1" width="100%">
<tr>
<td width="60%" valign="top">
<div id="topic_detail">
<?php
if(sizeof($result_discussion_last)>0)
{
foreach($result_discussion_last as $data2)
{
$topic=$data2["discussion_post"]["topic"];
$description=$data2["discussion_post"]["description"];
$file=$data2["discussion_post"]["file"];
$d_user_id=(int)$data2["discussion_post"]["user_id"];
$post_date=$data2["discussion_post"]["date"];
$post_time=$data2["discussion_post"]["time"];
$description=$data2["discussion_post"]["description"];
$discussion_post_id=(int)$data2["discussion_post"]["discussion_post_id"];
$visible=$data2["discussion_post"]["visible"];
$sub_visible=$data2["discussion_post"]["sub_visible"];
}

$visible_detail='';
if($visible==1 ) 
{
	$visible_show="All Users";
	$visible_detail="All Users";
}

if($visible==4 ) 
{
	$visible_show="All Owners";
	$visible_detail="All Owners";
}

if($visible==5) 
{
	$visible_show="All Tenant";
	$visible_detail="All Tenant";
}

if($visible==2) 
{ 
$visible_show="Role wise";
	foreach ($sub_visible as $role_id) 
	{
	$role_name[]=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array($role_id)));
	}
	$visible_detail=implode(" , ",$role_name);
}

if($visible==3) 
{ 
$visible_show="Wing wise"; 
	foreach ($sub_visible as $wing_id) 
	{
	$wing_name[]="wing-".$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wingname_via_wingid'), array('pass' => array($wing_id)));
	}
	$visible_detail=implode(" , ",$wing_name);
}

$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach($result_user_info as $collection2)
{
$user_name=$collection2["user"]["user_name"];
$profile_pic=$collection2["user"]["profile_pic"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];

}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>
<!---------------------------------------------->
<div style="margin-left:10%; width:80%;">
<div style="background-color:#269abc; text-align:center; color:white; font-size:18px; font-weight:bold; padding:5px;"><?php echo $topic; ?></div>
<!--<div class="pull-right">
<a href="discussion_pdf?con=<?php echo $last_discussion_post_id; ?>" class="btn red mini hide_at_print ">pdf</i></a>
<a class="btn blue mini hide_at_print" onclick="window.print()">print</a>
</div>-->
<!---------------------------------------------->


<!---------------------------------------------->
<div style="margin-top:2px;" >
<table>
<tr>
<td width="15%"><img src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>" style="height:50px; width:50px;"/></td>
<td width="85%" valign="top" style="padding-left:5px;" >
<span style="font-size:16px;"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat_info; ?></span>

<span style="font-size:16px;cursor: default;"><span class="tooltips" data-placement="bottom" data-original-title="This discussion is visible to :- <?php echo @$visible_detail; ?>"><?php //echo $visible_show; ?><i class=" icon-info-sign"></i></span></span>
<br/>
<span style="color:#ADABAB;"><?php echo $post_date; ?>&nbsp;&nbsp;<?php echo $post_time; ?></span>
</td>
</tr>
</table>
<div>
<!---------------------------------------------->


<!---------------------------------------------->
<div style="margin-top:2px;font-size:16px;color:#007091;" ><?php echo $description; ?><div>
<!---------------------------------------------->


<!---------------------------------------------->
<?php if(!empty($file)) { ?>
<div style="margin-top:2px;" >
<img src="<?php echo $this->webroot ; ?>/discussion_file/<?php echo $file; ?>" style="width:100%; height:160px;">
<div>
<?php } ?>
<!---------------------------------------------->

<!---------------------------------------------->
<div id="comments_container">
<?php 
foreach($result_comment_last as $collection2)
{
$discussion_comment_id=$collection2["discussion_comment"]["discussion_comment_id"];
$comment=$collection2["discussion_comment"]["comment"];
$comment_user_id=$collection2["discussion_comment"]["user_id"];
$date=$collection2["discussion_comment"]["date"];
$time=$collection2["discussion_comment"]["time"];
$color=$collection2["discussion_comment"]["color"];


$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($comment_user_id)));
foreach($result_user_info as $collection2)
{
$user_name=$collection2["user"]["user_name"];
$profile_pic=$collection2["user"]["profile_pic"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];

}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>
<div style="background-color: #fafafa;border-top: solid 2px #f1f3fa;" id="comm<?php echo $discussion_comment_id; ?>" class="">
<table width="100%">
<tr>
<td width="15%" valign="top" style="padding:10px;"><img src="<?php echo $this->webroot ; ?>/profile/<?php echo $profile_pic; ?>" style="height:50px; width:50px;"/></td>
<td width="85%" valign="top" style="padding-left:5px;">
				
<?php if($s_user_id==$comment_user_id) { ?>
<a href="#" role='button' class="btn mini red pull-right showme" onclick="delete_comment(<?php echo $discussion_comment_id; ?>)"><i class="icon-trash"></i> </a>
<?php } ?>


<span style="font-size:14px;color:<?php echo $color; ?>"><?php echo $user_name; ?>&nbsp;&nbsp;<?php echo $flat_info; ?></span>
<span style="color:#ADABAB;font-size:12px;" class="pull-right"><?php echo $date; ?>&nbsp;&nbsp;<?php echo $time; ?></span><br/>
<span style="color:#000;font-size:14px;"><?php echo $comment; ?></span>
</td>
</tr>
</table>
</div>
<?php } ?>
</div>
<!---------------------------------------------->


<!---------------------------------------------->
<div class="chat-form hide_at_print" style="margin-left: 5px;width: 94%;">
	<textarea class="span12 m-wrap animated"  type="text" id="posttext" placeholder="Type a message here..." style="background-color:#FFF !important; resize:none;" ></textarea>
	<div align="right">
	<div class="pull-left" id="save_comment"></div>
	<button type="button" id="post_comment" style="margin-top:-10px;" onclick="comment(<?php echo $discussion_post_id; ?>)" class="btn blue icn-only tooltips" data-placement="bottom" data-original-title="Tab + Enter for post comment">POST</button>
	</div>
</div>
<!---------------------------------------------->
<?php } else { ?><h4>There are no any topics strated.</h4><?php } ?>
</div>
</td>
<td width="40%" valign="top" class="hide_at_print"> 
<div  class="scroller"  data-height="700px" id="topics_list">
<div align="center" style="font-size:16px; padding:2px;">All Topics</div>
<?php
foreach($result_discussion as $collection)
{
$discussion_post_id=(int)$collection["discussion_post"]["discussion_post_id"];
$topic=$collection["discussion_post"]["topic"];
$d_user_id=(int)$collection["discussion_post"]["user_id"];
$date=$collection["discussion_post"]["date"];
$time=$collection["discussion_post"]["time"];

$n_comments=$this->requestAction(array('controller' => 'hms', 'action' => 'count_comment_of_topic'), array('pass' => array($discussion_post_id)));
?>
<a href="<?php echo $discussion_post_id; ?>" role='topic' rel="tab" style="text-decoration:none;">
<div style="padding:2px;">
<div  style="background-color:#F4F8FF; cursor:pointer; color:#06F; padding:5px; border:solid 2px #D9E8FF;" class="topic sel" id="t1" >
<div align="center" style="font-size:18px;" ><?php echo $topic; ?></div>
<div align="center" ><span>(<?php echo $n_comments; ?> Comments )</span>&nbsp;&nbsp;<?php echo $date; ?>&nbsp;&nbsp; <?php echo $time; ?></div>
</div>
</div>
</a>
<?php } ?>
</div>
</td>
</tr>
</table>


<!-- stat new topic --------->

<!-- Modal -->
<div id="close" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="margin-top:-5%;">
<div class="modal-header">
<h3 id="myModalLabel3">Start New Topic</h3>
</div>
	<div class="modal-body" style="max-height:500px !important;">
	<form  method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
	<div class="control-group ">
	<div class="controls">
	<label  style="font-size:14px;">Topic Name <span style="font-size:12px; color:#999;">(Maximum 100 characters.)</span></label>
	<input type="text" class="span12 m-wrap" id="alloptions" maxlength="100"  name="topic" >
	<label id="alloptions" ></label>
	</div>
	</div>
	<div class="control-group ">
	<div class="controls">
	<label class="" style="font-size:14px;">Description  <span style="font-size:12px; color:#999;">(Maximum 500 characters.)</span></label>
	<textarea class="span8 m-wrap" id="textarea" maxlength="500" style=" resize:none; width:100%" name=description onkeyup=limiter()  rows="4"></textarea>
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
	
	<br/>
	
	
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
			</div><br/>
			<label id="requirecheck2"></label>
			</div>
			<!---------------end visible-------------------------------->
			
			
			
			
</div>
			
	
<div class="modal-footer">
<input type="submit" class="btn green " data-placement="bottom" data-original-title="Click New Topic Submit"  value="Start Topic" name="sub">&nbsp;
<button data-dismiss="modal" class="btn " data-placement="bottom" data-original-title="Click Notice is Saved by Draft"  type="button">Cancel</button>
</div>

</form>
</div>
						
<!-- Modal -->
<!-- end new topic --------->

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
			remote:"content_check_des"
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
$('#topics_list').html('<div style="border:solid 2px #F4F8FF; padding:5px;" align="center"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('discussion_my_topic?q=' + q);
}



function details_topic(t)
{
//$("#topic_detail").removeClass('animated zoomIn');
$("#topic_detail").removeClass('fadeleftsome');
$('#topic_detail').html('<div style="border:solid 2px #F4F8FF; margin-top:25px;" align="center"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('topic_view?t=' + t);

}

function details_topic_deleted(x)
{
$("#topic_detail").removeClass('fadeleftsome');
$('#topic_detail').html('<div style="border:solid 2px #F4F8FF; margin-top:25px;" align="center"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('topic_view_deleted?t=' + x);

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
 $('#comm'+co_id).load('discussion_offensive_delete_ajax?c_id='+co_id +'&c_u_id='+co_u_id);
 $('#comm'+co_id).addClass('animated zoomOut');
setTimeout(
  function() 
  {
   
  $('#comm'+co_id).hide();
  }, 500);

 
}

function hide_comment_div(ca)
{
$('#delete_topic_result').load('discussion_comment_delete_ajax?c_id='+ca);
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
$('#topics_list').html('<div style="border:solid 2px #F4F8FF; padding:5px;" align="center"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('discussion_search_topic?s='+s);
}
</script>


<script>
$(document).ready(function() {
	$('#t1').addClass("blue");
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
<script src="<?php echo $this->webroot ; ?>/as/bootstrap-maxlength.min.js"></script>
	
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
