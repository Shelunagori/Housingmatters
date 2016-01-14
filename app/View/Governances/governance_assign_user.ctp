<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<div align="center">
<a href="governance_designation" rel="tab" class="btn blue">Add Designation</a>
<a href="governance_assign_user" rel="tab" class="btn red" >Assign Designation</a>
</div>
<div style="background-color:#fff;padding:5px;width:96%;margin:auto; " class="form_div">
<form method="post" id="sucess">

<table class="table table-bordered table-hover" style="width:50%;margin:auto;">
<tr>
<th>Committee Member</th>
<th>Designation</th>
</tr>

<?php
foreach ($result_users_com as $collection) 
{
$user_id=$collection["user"]["user_id"];
$user_name=$collection["user"]["user_name"];
$email=$collection["user"]["email"];
$wing=$collection["user"]["wing"];
$flat=$collection["user"]["flat"];
$designation_id=(int)@$collection["user"]["designation_id"];

$flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));

?>
<tr>
<td><?php echo $user_name; ?></td>
<td>
<select  name="designation<?php echo $user_id;?>" id="designation" class="span8"  tabindex="6">
<option value="">--Select designation-- </option>
<?php
foreach ($governance_designation_result as $collection) 
{
	$gov_id=$collection['governance_designation']['governance_designation_id'];
	$gov_name=$collection['governance_designation']['designation_name'];


?>
<option value="<?php echo $gov_id; ?>" <?php if($gov_id==$designation_id){?> selected <?php } ?>><?php echo $gov_name; ?></option>
<?php } ?>           
		  
	 </select>
	 <label id="designation"></label>
  </td>

</tr>
<?php } ?>           

</table>
<div style="width:50%;margin:auto;">
<button type="submit" class="btn form_post" style="background-color: #09F; color:#fff;" name="send" value="xyz">Assign designation</button>
</div>
</form>
</div>

<script>
$(document).ready(function(){

		$('#sucess').validate({
			ignore: ".ignore",
			errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	    rules: {
	      hed: {
	       
	        required: true
	      },
		 
	     "multi1[]": {
	        required: true,
	      },
		  designation: {
	        required: true,
	      },
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

