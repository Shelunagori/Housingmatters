<?php
$c_id=$result_classified[0]["classified"]["classified_id"];
$mobile=$result_user[0]["user"]["mobile"];
$email=$result_user[0]["user"]["email"];
if(!empty($email)){
$to=$email;
}else{
$to=$mobile;
}
?>
<div style="padding:10px;">
	<div class="portlet box blue">
		<div class="portlet-title">
			<h4><i class="icon-phone-sign"></i> Message to Advertiser</h4>
			<div class="tools">
				<a href="javascript:;" class="model_close remove hidden-phone"></a>
			</div>
		</div>
		<div class="portlet-body">
			<table width="100%">
				<tr><td><b>Message:</b><br/><textarea class="span6 m-wrap type_message" rows="3"></textarea></td></tr>
			</table>
			<a href="#" role="button" class="btn blue" id="send_message" c_id="<?php echo $c_id; ?>">Send Message</a>
		</div>
	</div>
</div>