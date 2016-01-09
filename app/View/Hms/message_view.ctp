<div class="hide_at_print">
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
</div>

<div style="padding:5px;" align="center" class="hide_at_print">
<a href="message_view" class="btn red">SMS History</a>
<a href="message" class="btn blue">Send SMS</a>
</div>


<div id="all_message" class="fadeleftsome">
<label class="m-wrap pull-right">Search: <input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;"></label>
<div class="portlet-body" style="padding-left:20px;padding-right:20px;">
<div style="border:solid 2px #4cae4c;">
<table class="table table-striped table-hover">
	<thead>
		<tr style="background-color: #5cb85c;border-bottom: solid 2px #4cae4c; color:#fff;">
			<th width="80%">Message </th>
			<th width="20%">Time</th>
		</tr>
	</thead>
	<tbody id="table">
	<?php
	foreach($result_sms as $data)
	{
	$sms_id=$data["sms"]["sms_id"];
	$text=$data["sms"]["text"];
	$date=$data["sms"]["date"];
	$time=$data["sms"]["time"];
	?>
		<tr class="hand" onclick="message_detail(<?php echo $sms_id; ?>)">
			<td><?php echo $text; ?></td>
			<td><span class="label"><?php echo $date; ?>&nbsp;&nbsp;<?php echo $time; ?></span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</div>
</div>
</div>





<div id="view_message" class="fadeleftsome">

</div>


<style>
.hand{
cursor: pointer;
}
</style>


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
			maxlength: 50
	      },
		  
		  description: {
	        required: true,
			maxlength: 500
	      },
		  file: {
			accept: "gif,jpg",
			filesize: 1048576
	      },
		 
	    },
		messages: {
	                topic: {
	                    maxlength: "Maximum 50 characters only."
	                },
					file: {
						accept: "File extension must be gif or jpg",
	                    filesize: "File size must be less than 1 MB."
	                },
					description: {
	                    maxlength: "Max 500 characters allowed."
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

function message_detail(c)
{

	$(document).ready(function() {
				
				$( "#view_message" ).load( 'message_view_ajax?id=' + c, function() {
				  $("#all_message").hide();
				  $("#view_message").show();
				});
		
		
		});
	
}
</script>

<script>
$(document).ready(function() {
	$("#back").live('click',function(){
			$("#view_message").hide();
			$("#all_message").show();	
	});
});

</script>

<script type="text/javascript">
		 var $rows = $('#table tr');
		 $('#search').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
			
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
 </script>