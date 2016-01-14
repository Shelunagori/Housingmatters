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
<style>
.event_tab{
color: rgb(68, 182, 174);
font-size: 15px;
font-weight: bold;
margin-right: 10px;
text-decoration: none !important;
}
.event_tab:hover{
color: rgb(68, 182, 174);
border-bottom:solid 2px rgb(68, 182, 174);
}
.tab_active{
border-bottom:solid 2px rgb(68, 182, 174);
}
</style>
<?php
if(sizeof($result_event_detail)>0)
{ 
echo '<a href='.$this->webroot.'Events/events rel="tab" style="font-size: 18px; color: #44b6ae;"><i class="icon-circle-arrow-left"></i> All Events</a>';
foreach($result_event_detail as $data)
{
$event_id=$data["event"]["event_id"];
$e_name=$data["event"]["e_name"];
$e_time=@$data["event"]["time"];
$day_type=$data["event"]["day_type"];
$d_user_id=(int)$data["event"]["user_id"];
$rsvp=@$data["event"]["rsvp"];
if(sizeof($rsvp)==0) { $rsvp=array();}
$not_in_rsvp=@$data["event"]["not_in_rsvp"];
if(sizeof($not_in_rsvp)==0) { $not_in_rsvp=array();}


$date_created=$data["event"]["date"];


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
<a href="<?php echo $webroot_path; ?>Events/event_info/<?php echo $e_id; ?>" class="event_tab tab_active" rel='tab'> Event Details</a>
<!--<a href="<?php echo $webroot_path; ?>Events/updates/<?php echo $e_id; ?>" class="event_tab" rel='tab'> Updates</a>
<a href="<?php echo $webroot_path; ?>Events/gallery/<?php echo $e_id; ?>" class="event_tab" rel='tab'> Gallery</a> -->
<!-- BEGIN BORDERED TABLE PORTLET-->
<div class="portlet box" style="background-color:#44b6ae;">
	
	<div class="portlet-body" >
		<table width="100%" >
			<tr >
				<td width="60%" valign="top" align="left" >
				<span style="font-size:22px;"><?php echo $e_name; ?></span><br/>
				<span><?php echo $date_string; ?></span><br/>
				<span>Time:- <?php echo @$e_time; ?></span>
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
		<?php if(sizeof($rsvp)>0) { ?>
			<div class="span6">
			<h5 style="font-weight: bold;">
			users who accept invitation </h5>
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
				<span><?php echo $user_name.' '.$flat_info; ?><br/></span>
				<?php
			}
			?>
			
			<!-------content----------->
			</div> <?php } ?>
			<?php if(sizeof($not_in_rsvp)>0) { ?>
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
				<span><?php echo $user_name.' '.$flat_info; ?><br/></span>
				<?php
			}
			?>
			
			<!-------content----------->
			</div><?php } ?>
		</div>
	
	</div>
</div>
<!-- END BORDERED TABLE PORTLET-->
</div>
<?php } ?>



<script>
$(document).ready(function() { 
	 $("#event_yes").live('click',function(){
		var e=$(this).attr('element_id');
		$(".alert-block").html('Please wait...').load('<?php echo $this->webroot; ?>Events/save_rsvp?e='+e+'&type=1');
	 });
	 $("#event_no").live('click',function(){
		var e=$(this).attr('element_id');
		$(".alert-block").html('Please wait...').load('<?php echo $this->webroot; ?>Events/save_rsvp?e='+e+'&type=2');
	 });
	 $("#send_member").live('click',function(){
		var e=$(this).attr('element_id');
		var no=$("#members").val();
		$(".alert-block").html('Please wait...').load('<?php echo $this->webroot; ?>Events/save_rsvp?e='+e+'&type=3'+'&no='+no);
	 });
});
</script>
