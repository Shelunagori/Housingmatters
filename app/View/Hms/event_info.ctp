<?php
if(sizeof($result_event_detail)==0)
{
echo '<div style="min-height: 85%;margin-top: 60px; " align="center">
	<h2>Sorry<br/>This page is not available.</h2>
	<img src="<?php echo $this->webroot ; ?>/as/hm/hm-logo.png" alt="logo">
	<br/><h4>Back to <a href="dashboard">All Events</a></h4>
	</div>';
}
?>

<?php
if(sizeof($result_event_detail)>0)
{ 
echo '<a href="events" rel="tab" style="font-size: 22px; color: #44b6ae;"><i class="icon-circle-arrow-left"></i> All Events</a>';
foreach($result_event_detail as $data)
{
$event_id=$data["event"]["event_id"];
$e_name=$data["event"]["e_name"];
$day_type=$data["event"]["day_type"];
$d_user_id=(int)$data["event"]["user_id"];
$rsvp=@$data["event"]["rsvp"];
if(sizeof($rsvp)==0) { $rsvp=array();}
$not_in_rsvp=@$data["event"]["not_in_rsvp"];
if(sizeof($not_in_rsvp)==0) { $not_in_rsvp=array();}


$date_created=$data["event"]["date"];
$date_created = date('d-m-Y',$date_created->sec);

$date_from=$data["event"]["date_from"];
$date_from = date('d-m-Y',$date_from->sec);

$date_to=$data["event"]["date_to"];
$date_to = date('d-m-Y',$date_to->sec);

if($day_type==1) { $date_string="on ".$date_from; }
if($day_type==2) { $date_string="from ".$date_from." to ".$date_to; }

$location=$data["event"]["location"];
$description=$data["event"]["description"];
}


$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($d_user_id)));
foreach($result_user_info as $collection2)
{
$user_name=$collection2["user"]["user_name"];
$profile_pic=$collection2["user"]["profile_pic"];
$wing=$collection2["user"]["wing"];
$flat=$collection2["user"]["flat"];

}

$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
?>
<div style="width:80%; margin-left:10%;margin-top:4px;">
<!-- BEGIN BORDERED TABLE PORTLET-->
<div class="portlet box" style="background-color:#44b6ae;border-top: solid 2px #44b6ae;">
	
	<div class="portlet-body" >
		<table width="100%" >
			<tr >
				<td width="60%" valign="top" align="left" >
				<span style="font-size:22px;"><?php echo $e_name; ?></span><br/>
				<span><?php echo $date_string; ?></span>
				</td>
				<td width="30%" valign="top" align="right"  >
				<span style="font-weight: 100;">Created on: </span><span><?php echo $date_created; ?></span><br/>
				<span style="font-weight: 100;">Created by: </span><span><?php echo $user_name.' '.$flat_info; ?></span>
				</td>
			</tr>
			
			<tr >
				<td colspan="2">
				<br/>
				<h4><i class="icon-map-marker" style="font-size: 24px;"></i> <?php echo $location; ?></h4>
				<p><?php echo $description; ?></p>						
							
				</td>
			</tr>
		</table>
		<?php 
		if (!in_array($s_user_id, $rsvp)  &&  !in_array($s_user_id, @$not_in_rsvp))
		  { ?>
		  <hr>
		<div class="alert alert-block alert-info fade in" >
			<h4 class="alert-heading" style="color:#000;">Wiil you join this event ?</h4><br>
			<p>
				<a class="btn green" href="#" id="event_yes" element_id="<?php echo $event_id; ?>" role="button">Yes</a> 
				<a class="btn red" href="#" id="event_no" element_id="<?php echo $event_id; ?>" role="button">No</a>
			</p>
		</div>
		  <?php } ?>
		
		
		
		<hr>
		
		<div class="row-fluid">
			<div class="span6">
			<h5 style="font-weight: bold;">users who accept invitation </h5>
			<!-------content----------->
			<?php foreach($rsvp as $data1)
			{
				$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($data1)));
				foreach($result_user_info as $collection2)
				{
				$user_name=$collection2["user"]["user_name"];
				$profile_pic=$collection2["user"]["profile_pic"];
				$wing=$collection2["user"]["wing"];
				$flat=$collection2["user"]["flat"];

				}

				$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
				?>
				<span><?php echo $user_name.' '.$flat_info; ?></span>
				<?php
			}
			?>
			
			<!-------content----------->
			</div>
			<div class="span6">
			<h5 style="font-weight: bold;">users who decile invitation </h5>
			<!-------content----------->
			<?php foreach($not_in_rsvp as $data2)
			{
				$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($data2)));
				foreach($result_user_info as $collection2)
				{
				$user_name=$collection2["user"]["user_name"];
				$profile_pic=$collection2["user"]["profile_pic"];
				$wing=$collection2["user"]["wing"];
				$flat=$collection2["user"]["flat"];

				}

				$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
				?>
				<span><?php echo $user_name.' '.$flat_info; ?></span>
				<?php
			}
			?>
			
			<!-------content----------->
			</div>
		</div>
		
		
		
		
		
		
		
		
		
		
		
		<hr>
		<h5 style="font-weight: bold;">Updates</h5>
		<?php 
		$updts=@$result_event_detail[0]['event']['updates'];
		if(sizeof($updts)==0) { $updts=array(); echo '<h5>There is no any update for this event.</h5>';} 
		foreach($updts as $up)
		{?>
		<div style="padding:5px;border-left:solid 2px <?php echo $up['color']; ?>;background-color:#EEE;margin-bottom: 10px;">
		<h4><i class=" icon-exclamation-sign" style="color: <?php echo $up['color']; ?>;"></i> <?php echo $up['title']; ?></h4>
		<p><?php echo $up['des']; ?></p>
		</div>
		<?php } ?>
		
		
		
		
	<?php if($d_user_id==$s_user_id) { ?>
		<div style="border: solid 1px #C9C2C2;padding: 5px;background-color: rgb(245, 243, 243);">
		<h5 style="font-weight: bold;">create Update </h5>
		<form method="post" id="contact-form" name="myform" enctype="multipart/form-data" >
		<table width="100%">
		<tr>
		<td width="70%">
		<input type="text" name="title" class="span12 m-wrap" style="background-color: #fff !important;font-size:18px;" placeholder="Type Update Title">
		</td>
		<td width="30%">
		<select class="span12 m-wrap" name="title_cat" placeholder="Choose Update Category" tabindex="1" style="background-color: #fff !important;">
			<option value="" style="display:none;">Choose Update Category</option>
			<option value="#398439">Green</option>
			<option value="#eea236">Yellow</option>
			<option value="#d43f3a">Red</option>
			<option value="#357ebd">Blue</option>
		</select>
		</td>
		</tr>
		</table>
		
		<div class="controls">
		<textarea class="m-wrap" name="description" style="resize:none; width:98%; height:80px;background-color: #fff !important;font-size:14px;" placeholder="Type Update Description..."></textarea>
		</div>
		
		<div class="modal-footer">
		<button type="submit" name="sub_update" class="btn blue"><i class=" icon-share"></i> Send Update</button>
		</div>
		
		</div>
	<?php } ?>
	
	</div>
</div>
<!-- END BORDERED TABLE PORTLET-->
</div>
<?php } ?>




<?php $phts=@$result_event_detail[0]['event']['photos']; ?>
<!-- BEGIN GALLERY MANAGER PORTLET-->
<div class="portlet box " style="width:80%;margin-left:10%;">
	<div class="portlet-title">
		
	</div>
	<div class="portlet-body">
		<!-- BEGIN GALLERY MANAGER PANEL-->
		<div class="row-fluid">
			<div class="span4">
				<h4 style="font-weight:bold;">Photo Gallery</h4>
			</div>
		</div>
		<!-- END GALLERY MANAGER PANEL-->
		<hr class="clearfix" />
		<!-- BEGIN GALLERY MANAGER LISTING-->
		<!--upload photo---------->
		<?php if($d_user_id==$s_user_id) { ?>
		<div align="right">
			<div class="controls">
			 <div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="input-append">
				   <div class="uneditable-input">
					  <i class="icon-file fileupload-exists"></i> 
					  <span class="fileupload-preview"></span>
				   </div>
				   <span class="btn btn-file">
				   <span class="fileupload-new">Select file</span>
				   <span class="fileupload-exists">Change</span>
				   <input type="file" name="file" class="default">
				   </span>
				   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
				<button type="submit" name="up_photo" class="btn green"><i class="icon-upload-alt"></i> Upload</button>
			 </div>
			</div>
		</form>	
		</div>
		<?php } ?>
		<!--upload photo---------->
		
		
		
		<?php 
		$a=3;
		if(sizeof($phts)==0) {$phts=array(); echo '<h5>There is no photo for this event.</h5>';}
		foreach($phts as $ph) { $a++;
			if(($a%4)==0) { echo '<div class="row-fluid">'; } 
			 ?>
		
			<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
				<div class="item">
					<a class="fancybox-button" data-rel="fancybox-button" title="Photo" href="<?php echo $this->webroot ; ?>/event_file/event<?php echo $e_id; ?>/<?php echo $ph; ?>">
						<div class="zoom">
							<img src="<?php echo $this->webroot ; ?>/event_file/event<?php echo $e_id; ?>/<?php echo $ph; ?>" style="height:100px;width:100%;">							
							<div class="zoom-icon"></div>
						</div>
					</a>
				</div>
			</div>
		<?php if(($a%4)==3) { echo "</div>"; } if(sizeof($phts)==($a-3)) { echo "</div>"; } } ?>
		<!-- END GALLERY MANAGER LISTING-->
	</div>
</div>
<!-- END GALLERY MANAGER PORTLET-->





<script>
$(document).ready(function() { 
	 $("#event_yes").live('click',function(){
		var e=$(this).attr('element_id');
		$(".alert-block").html('Please wait...').load('save_rsvp?e='+e+'&type=1');
	 });
	 $("#event_no").live('click',function(){
		var e=$(this).attr('element_id');
		$(".alert-block").html('Please wait...').load('save_rsvp?e='+e+'&type=2');
	 });
});
</script>
<script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      question: {
	       
	        //required: true
	      },
		description:
        {
           //required: true,
            remote: "content_check_des"
        },
		  password: {
	        required: true,
	      },

	    },
		messages: {
	                email: {
	                    remote: "Login-Id is Already Exist."
	                },
					 description: {
	                    remote: "You have enter wrong word."
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