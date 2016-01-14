<div class="hide_at_print">
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
</div>

<div style="padding:5px;" align="center" class="hide_at_print">
<a href="email_view" class="btn red">Email History</a>
<a href="email" class="btn blue">Send Email</a>
</div>

<div id="all_email" class="fadeleftsome">
<label class="m-wrap pull-right">Search: <input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;"></label>
<div class="portlet-body" style="padding-left:20px;padding-right:20px;">
<div style="border:solid 2px #4cae4c;">
<table class="table table-striped table-hover">
	<thead>
		<tr style="background-color: #5cb85c;border-bottom: solid 2px #4cae4c; color:#fff;">
			<th width="80%">Subject</th>
			<th width="20%">Time</th>
		</tr>
	</thead>
	<tbody id="table">
	<?php
	foreach($result_email as $data)
	{
	$email_id=$data["email_communication"]["email_id"];
	$subject=$data["email_communication"]["subject"];
	$date=$data["email_communication"]["date"];
	$time=$data["email_communication"]["time"];
	?>
		<tr class="hand" onclick="message_detail(<?php echo $email_id; ?>)">
			<td><?php echo $subject; ?></td>
			<td><span class="label "><?php echo $date; ?>&nbsp;&nbsp;<?php echo $time; ?></span></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</div>
</div>
</div>





<div id="view_email" class="fadeleftsome">

</div>


<style>
.hand{
cursor: pointer;
}
</style>


<script>

function message_detail(c)
{

	$(document).ready(function() {
				
				$( "#view_email" ).load( 'email_view_ajax?id=' + c, function() {
				  $("#all_email").hide();
				  $("#view_email").show();
				});
		
		
		});
	
}
</script>

<script>
$(document).ready(function() {
	$("#back").live('click',function(){
			$("#view_email").hide();
			$("#all_email").show();	
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