<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>           
		   <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:25%">
            <a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
            </td>
            <td style="width:25%">
             <a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
            </td>
            <td style="width:25%">
            <a href="it_reports_regular" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
            </td>
            <td style="width:25%">
            <a href="it_setup_insert_taxes" class="btn red btn-block"  style="font-size:16px;">Set-Up</a>
            </td>
            </tr>
            </table>
 
            <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td>
            <a href="it_setup" class="btn" style="font-size:16px;">Terms & Condition</a>
            </td>
            <td>
            <a href="master_flat_rent" class="btn yellow" style="font-size:16px;">Flat Rent</a>
            </td>
            </tr>
            </table>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
			<br>
				<div class="portlet box grey" style="width:60%; margin-left:20%; margin-right:20%;">
				<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Assign Flat Type</h4>
				</div>
				<div class="portlet-body form">			
	
	
				<center>
				<form method="post" id="contact-form">
				<table class="" style="width:80%;">
	
	
	
	
	
					<tr>
					<td>
					<br>
					<label class="" style="font-size:14px;">Resident Name</label></td>
					</td>
					<td>
					<br>
					<select name="user_id" class="m-wrap medium" id="go">
					<option value="">Select</option>
					<?php
					
					foreach ($cursor1 as $collection)
					{
					$user_id = (int)$collection['user']['user_id'];
					$user_name = $collection['user']['user_name'];
					$role_id = $collection['user']['role_id'];

					for($i=0;$i<sizeof($role_id);$i++)
					{
					if($role_id[$i] == 2)
					{
					?>
					<option value="<?php echo $user_id; ?>"><?php echo $user_name; ?></option>
					<?php }}} ?>
					</select>
					</td>
					</tr>
	

					<tr>
					<td><br>Wing-Flat</td>
					<td id="result"><br><input type="text" class="m-wrap medium" readonly ></td>
					</tr>
	
	
					<tr>
					<td>
					<br>
					<label class="" style="font-size:14px;">Flat Type</label>
					</td>
					<td>
					<br>
					<label class="radio">
					<div class="radio" id="uniform-undefined"><span><input type="radio" name="flat_type" value="1" style="opacity: 0;" id="go1"></span></div>
					By Square Feet
					</label>
					<label class="radio">
					<div class="radio" id="uniform-undefined"><span><input type="radio" name="flat_type" value="2" style="opacity: 0;" id="go2"></span></div>
					By BHK
					</label>
					</td>
					</tr>
	
	
					<tr class="hide" id="div2">
					<td>
					<br>
					<label class="" style="font-size:14px;">How Many Square Feet</label>
					</td>
					<td>
					<br>
					<input type="text" name="flat_size_s" class="m-wrap medium">
					</td>
					</tr>

	
	
					<tr class="hide" id="div1">
					<td>
					<br>
					<label class="" style="font-size:14px;">Select BHK</label></td>
					<td>
					<br>
					<select class="m-wrap medium" name="flat_size">
					<option value="">Select</option>
					<?php
					
					foreach ($cursor2 as $collection) 
					{
					$auto_id = (int)$collection['flat_rent']['auto_id'];
					$name = $collection['flat_rent']['name'];	
					?>
					<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
					<?php } ?>
					</select>
					</td>
					</tr>
	
	
	
	</center>
	</table>
	
	
	
  <br><Br>
                             <div class="form-actions" style="background-color:#CCC;">
                             <button type="submit" class="btn green" name="sub" value="xyz">Submit</button>
                             <button type="button" class="btn">Cancel</button>
                             </div>
          

</form>




</div>
</div>	

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").live('change',function(){
		var user_id=document.getElementById('go').value;
		
		
	    $("#result").load("flat_assign_ajax?user_id=" +user_id+ "");
		
		
	});
	
});
</script>	

 <script>
$(document).ready(function() {
	$("#go2").live('click',function(){
		$("#div1").show();
		$("#div2").hide();
		
	});
	
	$("#go1").live('click',function(){
		$("#div2").show();
		$("#div1").hide();
		
	});
	
});
</script> 
 
 <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      user_id: {
	       
	        required: true
	      },
		  
		  
		  flat_type: {
	       
	        required: true
	      },
		  
		   flat_size_s: {
	       
	        required: true,
			number: true
	      },
		  
		   flat_size: {
	       
	        required: true
	      },

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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	