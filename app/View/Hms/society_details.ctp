<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Details
</div>
<?php

foreach($result_society as $data)
{
@$society_pan=$data['society']['pan'];
@$tex_number=$data['society']['tex_number'];
@$society_address=$data['society']['society_address'];
@$society_reg_num=$data['society']['society_reg_num'];
@$society_phone = $data['society']['society_phone'];
@$society_email = $data['society']['society_email'];
$sig_title = @$data['society']['sig_title'];
$society_logo = @$data['society']['logo'];
$society_sig = @$data['society']['signature'];
}



?>				 
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li  ><a href="<?php echo $webroot_path; ?>Hms/master_sm_wing" rel='tab'> Wing</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/flat_type" rel='tab' >Unit Number</a></li>
<li ><a href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel='tab' >Unit Configuration</a></li>
<!--<li><a href="<?php //echo $webroot_path; ?>Hms/flat_nu_import" rel='tab' >Flat Number Import</a></li>-->
<li class="active" ><a href="<?php echo $webroot_path; ?>Hms/society_details" rel='tab' >Society Details</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/society_settings" rel='tab' >Society Settings</a></li>
</ul>
<div class="tab-content" style="min-height:300px;">
<div class="tab-pane active" id="tab_1_1">
<div class="portlet-body">
<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>
<br />
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">
<form method="POST" id="contact-form" enctype="multipart/form-data">
<div class="row-fluid">
<div class="span6">



<label style="font-size:14px;">Society PAN #<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" maxlength="10"  class="m-wrap span9" style="font-size:16px;"  name="pan" value='<?php echo $society_pan ; ?>'>
</div>
<br />

<label style="font-size:14px;">Society Registrations Number<span style="color:red;">*</span></label>
<div class="controls">
<input type="text"   class="m-wrap span9" style="font-size:16px;"  name="s_number" value='<?php echo $society_reg_num ; ?>'>
</div>
<br />

<label style="font-size:14px;">Registered Address of Society<span style="color:red;">*</span></label>
<div class="controls">
<textarea rows='5' cols='5' style='resize:none;' name='address' class="m-wrap span9"><?php echo $society_address ; ?></textarea>
</div>
<br />



<label style="font-size:14px;">Society Signature<span style="color:red;">*</span></label>
<div class="controls">
<div class="fileupload fileupload-new" data-provides="fileupload">
<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
</div>
<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
<div>
<span class="btn btn-file"><span class="fileupload-new">Select image</span>
<span class="fileupload-exists">Change</span>
<input type="file" class="default" name="sig"></span>
<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
</div>
</div>
<label id="sig_vali"></label>
</div>
<br />


<label style="font-size:14px;">Society Logo<span style="color:red;">*</span></label>
<div class="controls">
<div class="fileupload fileupload-new" data-provides="fileupload">
<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
</div>
<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
<div>
<span class="btn btn-file"><span class="fileupload-new">Select image</span>
<span class="fileupload-exists">Change</span>
<input type="file" class="default" name="logo"></span>
<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
</div>
</div>
</div>
<br />







</div>
<div class="span6">
<h4 style="color:#999;">Optional Field</h4>
<br />

<label style="font-size:14px;">Society Service Tax Number</label>
<div class="controls">
<input type="text" class="m-wrap span9" style="font-size:16px;"  name="s_tax" value='<?php echo $tex_number ; ?>'>
</div>
<br />

<label style="font-size:14px;">Society Phone Number</label>
<div class="controls">
<input type="text" class="m-wrap span9" name="society_phone" value="<?php echo $society_phone; ?>" />
</div>
<br />


<label style="font-size:14px;">Society E-mail</label>
<div class="controls">
<input type="text" class="m-wrap span9" name="society_email" value="<?php echo $society_email; ?>" />
</div>
<br />

<label style="font-size:14px;">Signature Title<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="title" value="<?php echo @$sig_title; ?>" />
</div>
<br />






</div>
</div>
<hr/>
<button type="submit" class="btn blue" id="go">Update </button>
<br /><br />
</form>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////// ?>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function(){
 $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Only enter alphanumeric letters.");


		$('#contact-form').validate({
	    rules: {
				pan: {
				required: true,
				loginRegex : true 
				},

					  
				s_number: {
				required: true,
				},
		
		title: {
				required: true,
				},
		
		
		       address: {
				  required: true, 
			      },
		 
				mobile: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10,
				remote: "signup_mobileexit"
				}
	    },
		            messages: {
	                email: {
	                    remote: "Login-Id is Already Exist."
	                },
					 mobile: {
	                    remote: "Mobile-No is Already Exist."
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