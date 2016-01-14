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
<a href="<?php echo $webroot_path; ?>Events/updates/<?php echo $e_id; ?>" class="event_tab " rel='tab'> Updates</a>
<a href="<?php echo $webroot_path; ?>Events/gallery/<?php echo $e_id; ?>" class="event_tab tab_active" rel='tab'> Gallery</a> 
<!-- BEGIN BORDERED TABLE PORTLET-->
<div class="portlet box" style="background-color:#44b6ae;">
<div class="portlet-body">

	<h5 style="font-weight: bold;">Gallery</h5>
	There is no any image for this event.


</div>
</div>
</div>




