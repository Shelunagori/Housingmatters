<a href="<?php echo $webroot_path; ?>Notices/notice_draft" rel="tab" class="btn  blue"><i class="icon-caret-left"></i> Back</a>

<div id="output"></div>	
<div class="portlet box" style="background-color:#4B77BE;">
<div class="portlet-title" >
<h4 class="block"><i class="icon-bullhorn"></i> Edit and Publish Notice</h4>
</div>
<div class="portlet-body form" style=" border: solid 1px #4B77BE; ">
<!-- BEGIN FORM-->
<form method="POST" class="form-horizontal">
   <div class="row-fluid">
		<div class="span6">
			<label class="" style="font-size:14px;">Subject<span style="color:red;">*</span><span style="font-size:12px; color:#999;">(Maximum 100 characters.)</span> </label>
			<input type="text" maxlength="100" class="span12 m-wrap" placeholder="Subject for e.g. Power shut down" name="notice_subject" value="<?php echo $result_notices[0]['notice']['n_subject']; ?>">
		</div>
		<div class="span3" >
			<label class="" style="font-size:14px;">Category<span style="color:red;">*</span></label>
			<select class="span12 m-wrap " name="notice_category"   tabindex="1">
			<option value="">--Please select any category--*</option>
			<?php	foreach($result1 as $data){
			$category_id=$data['master_notice_category']['category_id'];
			$category_name=$data['master_notice_category']['category_name']; ?>
				<option value="<?php echo $category_id; ?>" <?php if($result_notices[0]['notice']['n_category_id']==$category_id){ echo "selected"; } ?>  ><?php echo $category_name; ?> </option>
			<?php } ?>
			</select>
		</div>
		<div class="span3" >
			<label class="" style="font-size:14px;">Expires By<span style="color:red;">*</span> <i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Your notice will expire by this date and Archived"> </i></label>
			<input type="text"  class="span12 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Please select date" name="notice_expire_date" value="<?php echo date('d-m-Y',$result_notices[0]['notice']['n_expire_date']->sec); ?>">
		</div>
	</div>
	
	
	<br/>
	<label class="" style="font-size:14px;">Notice<span style="color:red;">*</span></label>
	<div id="summernote"><?php echo $result_notices[0]['notice']['n_message']; ?></div>
	
						   
	
	
	<div class="form-actions">
	  <button type="submit" class="btn blue form_post" name="publish" submit_type="post">Publish Notice</button>
	  <div style="display:none;" id='wait'><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> Please Wait...</div>
	</div>
</form>
<!-- END FORM-->
</div>
</div>


<div class="alert alert-block alert-success fade in" style="display:none;">
	<h4 class="alert-heading">Success!</h4>
</div>

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

<script>
$(document).ready(function() {
	$('form').submit( function(ev){
	ev.preventDefault();
		var m_data = new FormData();    
		m_data.append( 'notice_subject', $('input[name=notice_subject]').val());
		m_data.append( 'notice_category', $('select[name=notice_category]').val());
		m_data.append( 'notice_expire_date', $('input[name=notice_expire_date]').val());
		m_data.append( 'code', $('#summernote').code());
		
		$(".form_post").addClass("disabled");
		$("#wait").show();
			
			$.ajax({
			url: "<?php echo $webroot_path; ?>Notices/submit_notice_edit?q=<?php echo $result_notices[0]['notice']['notice_id']; ?>",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
			if(response.type=='approve'){
				$(".portlet").remove();
				$(".alert-success").show().append("<p>"+response.text+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Notices/new_notice' rel='tab' >ok</a></p>");
				$("#output").remove();
			}
			if(response.type=='created'){
				$(".portlet").remove();
				$(".alert-success").show().append("<p>"+response.text+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Notices/notice_publish' rel='tab' >ok</a></p>");
				$("#output").remove();
			}
			if(response.type=='error'){
				$("#output").html('<div class="alert alert-error">'+response.text+'</div>');
			}
			$("html, body").animate({
			scrollTop:0
			},"slow");
			$(".form_post").removeClass("disabled");
			$("#wait").hide();
			});

	 
	});
});

</script>