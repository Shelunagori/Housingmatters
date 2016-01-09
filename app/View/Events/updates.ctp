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
<a href='<?php echo $this->webroot; ?>Events/events' rel='tab' style="font-size: 18px; color: #44b6ae;"><i class="icon-circle-arrow-left"></i> All Events</a>
<div style="width:80%; margin-left:10%;margin-top:4px;">
<a href="<?php echo $webroot_path; ?>Events/event_info/<?php echo $e_id; ?>" class="event_tab" rel='tab'> Event Details</a>
<a href="<?php echo $webroot_path; ?>Events/updates/<?php echo $e_id; ?>" class="event_tab tab_active" rel='tab'> Updates</a>
<a href="<?php echo $webroot_path; ?>Events/gallery/<?php echo $e_id; ?>" class="event_tab" rel='tab'> Gallery</a> 
<!-- BEGIN BORDERED TABLE PORTLET-->
<div class="portlet box" style="background-color:#44b6ae;">
<div class="portlet-body">

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


</div>
</div>
</div>




