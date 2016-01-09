<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div style='float:right;  margin-right: 2px;'><a href="csv_import_signup" role='button' class='btn yellow' rel='tab'>Import User </a></div>

<div style='float:right;  margin-right: 2px;'><a href="new_user_enrollment" role='button' class='btn  ' rel='tab'>Manuly Enrollment </a></div>
<br>

<?php 
if(@$ok==2)
{
echo '<div class="alert alert-success">'.$sucess.'</div>';
?>
<h4>Imported users information</h4>
<div style="background-color:#fff;padding:5px;">
<table class="table table-bordered">
<tr>
<th>Sr.No.</th>
<th>Name</th>
<th>Wing</th>
<th>Flat</th>
<th>Email</th>
<th>Mobile</th>
<th>Owner</th>
<th>Committee</th>
<th>Residing</th>
</tr>
<?php
for($i=1;$i<sizeof($imported_data);$i++)
{
$r=explode(',',$imported_data[$i][0]);

$username=$r[0];
$wing=$r[1];
$flat=$r[2];
$email=$r[3];
$mobile=$r[4];
$owner=$r[5];
$committee=$r[6];
$residing=$r[7];
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $username; ?></td>
<td><?php echo $wing; ?></td>
<td><?php echo $flat; ?></td>
<td><?php echo $email; ?></td>
<td><?php echo $mobile; ?></td>
<td><?php echo $owner; ?></td>
<td><?php echo $committee; ?></td>
<td><?php echo $residing; ?></td>
</tr>
<?php } ?>
</table>
</div>
<div align="center"><a href="csv_import_signup" class="btn blue">ok</a></div>
<?php
}
if(@$ok==1)
{

echo '<div class="alert alert-error">';
echo "<h4>Error :</h4></br>";
foreach($error_msg as $er_msg)
{
echo '<p>'.$er_msg.'</p>';
}
echo '</div>';
}
?>





<?php 
if(@$ok!=2)
{ ?>
<div class="portlet box green">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Csv Import</h4>
	</div>
	<div class="portlet-body">
	<form  id="contact-form" name="myform" enctype="multipart/form-data" class="form-horizontal" method="post" >	
		<div class="">
		  <label class="control-label">Attach csv file</label>
		  <div class="">
			 <input type="file" name="file" id="file" class="default">
			 <input type="submit" name="sub" class="btn blue" value="Import" >
		  </div>
	   </div>
	    <label id="file" style="margin-left: 180px;margin-top: -20px;"></label>
	</form>	
	
	<strong><a href="<?php echo $this->webroot; ?>csv_file/demo/demo.csv" download>Click here for sample format</a></strong>
	<br/>
	<h4>Instruction set to import users</h4>
	<ol>
	<li>All the field are compulsory.</li>
	<li>Wing and Flat name be valid as per society setting.</li>
	<li>Email ID should be correct as all the further communication will be send to this email id. No duplicate Email is allowed.</li>
	<li>Mobile number should be 10 digits. No Duplicate Mobile No is allowed.</li>
	<li>Owner,Committee,Residing should be only "Yes" or "No".</li>
	</ol>
	</div>
</div>
<?php } ?>


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
		  file: {
		    required: true,
			accept: "csv",
			filesize: 1048576
	      },
		 
	    },
		messages: {
	                
					file: {
						accept: "File extension must be csv",
	                    filesize: "File size must be less than 1MB."
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