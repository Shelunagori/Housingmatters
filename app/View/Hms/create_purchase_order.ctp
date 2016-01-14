<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; overflow:auto;" class="form_div">
<h4 style="color: #09F;font-weight: 500;border-bottom: solid 1px #DAD9D9;padding-bottom: 10px;"><i class="icon-money"></i> Post Purchase Order</h4>

<form method="post">
<div class="row-fluid">
<div class="span6">

<label style="font-size:14px;">Purchase Order Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date">
<label report="dat" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Delevery Date<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="date-picker m-wrap span7" data-date-format="dd-mm-yyyy" name="date" id="date2">
<label report="dat2" class="remove_report"></label>
</div>
<br />



<label style="font-size:14px;">Quatation<span style="color:red;">*</span></label>
<div class="controls">
<select id="qut" class="m-wrap span9">
<option value="">Select</option>
<option value="1">Quatation 1</option>
<option value="2">Quatation 2</option>
<option value="3">Quatation 3</option>
<option value="4">Quatation 4</option>
</select>
<label report="qut" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Item<span style="color:red;">*</span></label>
<div class="controls">
<select id="itm" class="m-wrap span9">
<option value="">Select</option>
<option value="1">item 1</option>
<option value="2">item 2</option>
<option value="3">item 3</option>
<option value="4">item 4</option>
</select>
<label report="itm" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">Unit of Measurement<span style="color:red;">*</span></label>
<div class="controls">
<select id="unt" class="m-wrap span9">
<option value="">Select</option>
<option value="1">unit 1</option>
<option value="2">unit 2</option>
<option value="3">unit 3</option>
<option value="4">unit 4</option>
</select>
<label report="unt" class="remove_report"></label>
</div>
<br />




</div>

<div class="span6">

<label style="font-size:14px;">Price<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" class="m-wrap span9" name="qty" id="qty">
<label report="qty" class="remove_report"></label>
</div>
<br />

<label style="font-size:14px;">Description<span style="color:red;">*</span></label>
<div class="controls">
<textarea   rows="4" name="desc" class="m-wrap span9" style="resize:none;" id="desc"></textarea>
<label report="des" class="remove_report"></label>
</div>
<br />






<label style="font-size:14px;">Sent To<span style="color:red;">*</span></label>
<div class="controls">
<select id="sent" class="m-wrap span9">
<option value="">Select</option>
<option value="1">Vendor 1</option>
<option value="2">Vendor 2</option>
<option value="3">Vendor 3</option>
<option value="4">Vendor 4</option>
</select>
<label report="sen" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">PO Issue<span style="color:red;">*</span></label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="issue" value="1" style="opacity: 0;" id="iss"></span></div>
Yes
</label>

<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="issue" value="2" style="opacity: 0;" id="iss"></span></div>
No
</label>
<label report="poiss" class="remove_report"></label>
</div>
<br />


<label style="font-size:14px;">PO Issue Description<span style="color:red;">*</span></label>
<div class="controls">
<textarea   rows="4" name="desc" class="m-wrap span9" style="resize:none;" id="iss_des"></textarea>
<label report="pdes" class="remove_report"></label>
</div>
<br />


</div>
</div>


<hr/>
<button type="submit" class="btn form_post" style="background-color: #09F; color:#fff;" value="xyz">Submit</button>
<a href="<?php echo $webroot_path; ?>Hms/create_purchase_order" style="background-color: #09F;color:#fff;" class="btn" rel='tab'>Reset</a>
<div style="display:none;" id='wait'><img src="<?php echo $webroot_path; ?>as/fb_loading.gif" /> Please Wait...</div>
<br /><br />
</form>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

  <script>
$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
	
		var m_data = new FormData();
		m_data.append( 'date', $('#date').val());
		m_data.append( 'date2', $('#date2').val());
		m_data.append( 'quta', $('#qut').val());
		m_data.append( 'itm', $('#itm').val());
		m_data.append( 'unt', $('#unt').val());
		m_data.append( 'qty', $('#qty').val());
		m_data.append( 'desc', $('#desc').val());
		m_data.append( 'sent', $('#sent').val());
		m_data.append( 'poiss', $('input:radio[name=issue]:checked').val());
		m_data.append( 'pdesc', $('#iss_des').val());
				
		$(".form_post").addClass("disabled");
		$("#wait").show();
			
			$.ajax({
			url: "purchase_order_json",
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
                $("#shwd").show()
				$(".success_report").show().html(response.report);	
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
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>


<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Purchase Order</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b class="success_report"></b></h5>
</center>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Hms/create_purchase_order" class="btn blue" rel='tab'>OK</a>
</div>
</div>
</div> 










