<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<div class='alert alert-block alert-success fade in success_report' style="display:none;"></div>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto;" class="form_div">
	<h4 style="color: #1BBC9B;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;"><i class="icon-shopping-cart"></i> Post New Classified Ad</h4>
<!--FORM CONTENT START-->
<div id="output"></div>
<form method="post">
<div class="row-fluid">

	<div class="span6">
		<div id="selected_name"></div>
		<input type="hidden" id="cat_id" />
		<a href="#myModal1" role="button" data-toggle="modal">Select Category</a>
		<label report="cat_id" class="remove_report"></label>
		<div id="myModal1" class="modal fade hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<h4 id="myModalLabel1">Select Category for Classifieds Creation</h4>
			</div>
			<div class="modal-body">
				<div class="tabbable tabbable-custom tabs-left">
					<!-- Only required for left/right tabs -->
					<ul class="nav nav-tabs tabs-left">
					<?php 
					$i=0;
					foreach($result_select_category as $category) {
					$i++;
					$category_name=$category["master_classified_category"]["category_name"];
					$category_id=$category["master_classified_category"]["category_id"]; ?>
						<li <?php if($i==1) {echo 'class="active"'; } ?> ><a href="#tab_<?php echo $category_id; ?>" data-toggle="tab"><?php echo $category_name; ?></a></li>
					<?php } ?>
					</ul>
					<div class="tab-content">
					<?php 
					$i=0;
					foreach($result_select_category as $category) {
					$i++;
					$category_name=$category["master_classified_category"]["category_name"];
					$category_id=(int)$category["master_classified_category"]["category_id"]; ?>
						<div <?php if($i==1) {echo 'class="tab-pane active"'; } else{ echo 'class="tab-pane"';} ?> id="tab_<?php echo $category_id; ?>">
						
							<?php
							$sub_cat = $this->requestAction(array('controller' => 'hms', 'action' => 'master_classified_subcategory'),array('pass'=>array($category_id)));
							foreach ($sub_cat as $collection) {
							$subcategory_id = $collection['master_classified_subcategory']['subcategory_id'];
							$subcategory_name = $collection['master_classified_subcategory']["subcategory_name"];	
							?>
								<a href="#" role="button" data-dismiss="modal" aria-hidden="true" class="select_cat" value="<?php echo $category_id.','.$subcategory_id; ?>" cat_name="<?php echo $category_name.' <i class=icon-arrow-right></i> '.$subcategory_name; ?>"><?php echo $subcategory_name; ?></a><br/>
							<?php } ?>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		
		
			
		<br/><br/>	
		<label>Title<span style="color:red;">*</span></label>
		<div class="controls">
			<input type="text" class="span10 m-wrap" name="title">
			<label report="title" class="remove_report"></label>
		</div>
		
		
		
		<div class="controls">
			<label class="" style="font-size:14px;">Price </label>
			<input type="text" class="span6 m-wrap popovers" data-trigger="click "  data-content="Please enter full price like 10000, 25000000 etc.Do not enter characters or abbreviations like 10k, 2.5cr or 10,000" data-original-title="Information" name="price">
		
			<label class="radio" style="font-size:14px;">
				<div class="radio" id="uniform-undefined"><span><input type="radio" name="price_type" value="1" style="opacity: 0;"></span></div>
				Negotiable 
			</label>
			<label class="radio" style="font-size:14px;">
				<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="price_type" value="2" checked="" style="opacity: 0;"></span></div>
				Fixed
			</label>
			<label report="price" class="remove_report"></label>
		</div>
		
		<div class="controls">
			<label> Type of Ad* </label>
			<label class="radio" style="font-size:14px;">
				<div class="radio" id="uniform-undefined"><span><input type="radio" name="ad_type" value="1" style="opacity: 0;"></span></div>
				I want to sell
			</label>
			<label class="radio" style="font-size:14px;">
				<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="ad_type" value="2" checked="" style="opacity: 0;"></span></div>
				I want to buy
			</label> 
			<label report="ad_type" class="remove_report"></label>
		</div>
		<br/>
		<div class="controls">
			<label> Condition* </label>
			<label class="radio" style="font-size:14px;">
				<div class="radio" id="uniform-undefined"><span><input type="radio" name="condition" value="1" style="opacity: 0;"></span></div>
				Used
			</label>
			<label class="radio" style="font-size:14px;">
				<div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="condition" value="2" checked="" style="opacity: 0;"></span></div>
				New
			</label> 
			<label report="condition" class="remove_report"></label>
		</div>
		
		<br/>
		<div class="controls">
			<label style="font-size:14px;">Offer for</label>
			<select class="span3 m-wrap " name="offer"   tabindex="1">
				<option value="">--select--</option>
				<option value="7" >7 days</option>
				<option value="15" >15 days</option>
				<option value="30" >30 days</option>
				<option value="60" >60 days</option>
			</select>
			<div><span class="label label-important">NOTE!</span> By Default,Classified Ads will be Published for 30 Days,User can Delete/Extend the Ad Time peried.</div>
		</div>
						   
	</div>
	
	<div class="span6">
		
		<div class="control-group">
		  <label class="control-label">Image Upload</label>
		  <div class="controls">
			 <div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				   <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
				</div>
				<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				<div>
				   <span class="btn btn-file"><span class="fileupload-new">Select image</span>
				   <span class="fileupload-exists">Change</span>
				   <input type="file" name="file" id="image-file" class="default" /></span>
				   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				   <br/><span>Allowed extension: "jpg" , "jpeg", "bmp", "gif", "png" | Allowed size: 1 MB</span>
				</div>
			 </div>
			 <label report="file" class="remove_report"></label>
		  </div>
	   </div>
		
		
	<div class="controls">							   
		<label class="" style="font-size:14px;">Description</label>
		<textarea  class="span8 m-wrap" style="resize:none;" rows="5" name="description"></textarea>
		<label report="description" class="remove_report"></label>
	</div>
	
	</div>
</div>

<hr/>
<button type="submit" class="btn form_post" style="background-color: #1BBC9B;color:#fff;" name="publish" submit_type="publish">Publish Ad</button>
<!--<button type="submit" class="btn form_post" style="background-color: #1BBC9B;color:#fff;" name="draft" submit_type="draft">Save Ad as Draft</button>-->
<div style="display:none;" id='wait'><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> Please Wait...</div>
</form>
<!--FORM CONTENT END-->
</div>



<script>
$(document).ready(function() {
	$(".select_cat").bind('click',function(){
		var c=$(this).attr("value");
		$("#cat_id").val(c);
		var cn=$(this).attr("cat_name");
		$("#selected_name").html('<span class="label" style="background-color: #1BBC9B;">'+cn+'</span>');
		$('a[href="#myModal1"]').text("Select another category");
		
	});
	 });
</script>

<script>
$(document).ready(function() {
	$(".form_post").bind('click', function(e){
		$(".form_post").removeClass("clicked");
		$(this).addClass("clicked");
	});

			
	$('form').submit( function(ev){
	ev.preventDefault();
		if( $(this).find(".clicked").attr("submit_type") === "publish" ){
			var post_type=1;
		}
		if( $(this).find(".clicked").attr("submit_type") === "draft" ){
			var post_type=2;
		}
		var m_data = new FormData();
		m_data.append( 'cat_id', $('#cat_id').val());
		m_data.append( 'title', $('input[name=title]').val());
		m_data.append( 'price', $('input[name=price]').val());
		m_data.append( 'price_type', $('input:radio[name=price_type]:checked').val());
		m_data.append( 'ad_type', $('input:radio[name=ad_type]:checked').val());
		m_data.append( 'condition', $('input:radio[name=condition]:checked').val());
		m_data.append( 'offer', $('select[name=offer]').val());
		m_data.append( 'description', $('textarea[name=description]').val());
		m_data.append( 'file', $('input[name=file]')[0].files[0]);
		m_data.append( 'post_type', post_type);
		
		$(".form_post").addClass("disabled");
		$("#wait").show();
			
			$.ajax({
			url: "submit_ad",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
				if(response.report_type=='error'){
					$(".remove_report").html('');
						jQuery.each(response.report, function(i, val) {
						$("label[report="+val.label+"]").html('<span style="color:red;">'+val.text+'</span>');
					});
				}
				if(response.report_type=='publish'){
				
					$(".success_report").show().html("<p>"+response.report+"</p><p><a class='btn green' href='<?php echo $webroot_path; ?>Classifieds/classified_ads' rel='tab' >ok</a></p>");
					$(".form_div").remove();
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
