<?php 
foreach ($result_user as $collection)   
              	 {
					$c_email = $collection['user']['email'];
					$c_mobile = $collection['user']['mobile'];
					$c_name = $collection['user']['user_name'];
					$profile = $collection['user']['profile_status'];
					@$profile_pic = $collection['user']['profile_pic'];
					$c_sex = (int)@$collection['user']['sex'];
					$c_wing_id = (int)$collection['user']['wing'];
					 $c_flat_id = (int)$collection['user']['flat'];
					$da_dob=@$collection['user']['dob'];
					$per_address=@$collection['user']['per_address'];
					$com_address=@$collection['user']['comm_address'];
					$hobbies=@$collection['user']['hobbies'];
					$private_field=@$collection['user']['private'];
					
				  }
				  $ccc=0;
									if(!empty($c_email))
									{
										$ccc++;
									}
									if(!empty($c_mobile))
									{
										$ccc++;
									}
									if(!empty($c_name))
									{
										$ccc++;
									}
									if(!empty($profile_pic))
									{
										$ccc++;
									}
									if(!empty($c_sex))
									{
										$ccc++;
									}
									if(!empty($c_wing_id))
									{
										$ccc++;
									}
									if(!empty($c_flat_id))
									{
										$ccc++;
									}
									if(!empty($da_dob))
									{
										$ccc++;
									}
									if(!empty($per_address))
									{
										$ccc++;
									}
									if(!empty($com_address))
									{
										$ccc++;
									}
									if(!empty($hobbies))
									{
										$ccc++;
									}
						(int)$progres=$ccc*100/11;
if($profile==1 && $progres<82)
{
?>

<div id="div_close">
    <!----alert-------------->
	
            <div class="modal-backdrop fade in" ></div>
            <div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-body" >
			<div><span style="color:#00A0E3; font-size:20px;">Your profile completeness</span> <span>
                                        <b style="font-size:16px;"><?php echo (int)$progres ; ?>% </b> </span> 
										<p>
                                        <div id="bar" class="progress progress-success progress-striped" style="width:53%;">
                                        <div class="bar" style="width: <?php echo $progres ; ?>%;"></div>
                                        </div></p></div>
			
			<p style="font-size:16px;"> Do you want to complete your status </p> 
            </div> 
            <div class="modal-footer">
            <a href="profile?try=1" id=""  class="btn blue">Yes</a>
            <button data-dismiss="modal" class="btn blue" onclick="close_div(1);"> Later</button>
            </div>
            </div>
      <!----alert-------------->
   </div>
<?php } ?>   


<h3 class="page-title">Dashboard</h3>

<div class="row-fluid">
	<div class="span4">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet">
			<div class="portlet box" style="background-color:#4b77be;">
				<div class="portlet-title">
					<h4><i class="icon-comments" style="font-size:18px;"></i> DISCUSSION FORUM</h4>
					<a href="discussion" class="btn mini pull-right" style="color: #fff;background-color: transparent;border: solid 1px #fff;border-radius: 10px !important;">All Topics</a>
				</div>
				<div class="portlet-body" style="padding: 0px;height: 190px;">
					<table class="table  table-striped table-hover" style="cursor: pointer;">
						<?php
						foreach($result_discussion_last as $data)
						{
						$topic=$data['discussion_post']['topic'];
						$topic_cut=(strlen($topic) > 40) ? substr($topic,0,37).'...' : $topic; 
						$date=$data['discussion_post']['date'];?>
							<tr>
								<td width="75%"><?php echo $topic_cut; ?></td>
								<td width="25%"><span style="color: #969696;"><?php echo $date; ?></span></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
	<div class="span4">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet">
			<div class="portlet box" style="background-color:#35aa47;">
				<div class="portlet-title">
					<h4><i class="icon-bullhorn" style="font-size:18px;"></i>  NOTICE BOARD</h4>
					<a href="notice_board" class="btn mini pull-right" style="color: #fff;background-color: transparent;border: solid 1px #fff;border-radius: 10px !important;">All Notices</a>
				</div>
				<div class="portlet-body" style="padding: 0px;height: 190px;">
					<table class="table  table-striped table-hover" style="cursor: pointer;">
						<?php
						foreach($result_notice_visible as $data2)
						{
						$n_subject=$data2['notice']['n_subject'];
						$n_subject_cut=(strlen($n_subject) > 40) ? substr($n_subject,0,37).'...' : $n_subject;
						$n_date=$data2['notice']['n_date']; ?>
							<tr>
								<td width="75%"><?php echo $n_subject; ?></td>
								<td width="25%"><span style="color: #969696;"><?php echo $n_date; ?></span></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
	<div class="span4">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet">
			<div class="portlet box" style="background-color:#9b59b6;">
				<div class="portlet-title">
					<h4><i class="icon-briefcase" style="font-size:18px;"></i>   HELP-DESK</h4>
					<a href="help_desk_r_all_ticket" class="btn mini pull-right" style="color: #fff;background-color: transparent;border: solid 1px #fff;border-radius: 10px !important;">All Tickets</a>
				</div>
				<div class="portlet-body" style="padding: 0px;height: 190px;">
					<table class="table  table-striped table-hover" style="cursor: pointer;">
						<?php
						foreach($result_help_desk as $data3)
						{
						$ticket_id=$data3['help_desk']['ticket_id'];
						$help_desk_status=$data3['help_desk']['help_desk_status'];
						if($help_desk_status==0) { $status='<span class="label" style="background-color: #d84a38;">Open</span>'; }
						if($help_desk_status==1) { $status='<span class="label label-success">Close</span>'; }
						$help_desk_date=$data3['help_desk']['help_desk_date']; 
						?>
							<tr>
								<td width="50%"><?php echo $ticket_id; ?></td>
								<td width="25%"><?php echo $status; ?></td>
								<td width="25%"><span style="color: #969696;"><?php echo $help_desk_date; ?></span></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
</div>
				
				
				
				
				
				
<div class="row-fluid">
	<div class="span4">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet">
			<div class="portlet box" style="background-color:#bb9521;">
				<div class="portlet-title">
					<h4><i class="icon-bar-chart" style="font-size:18px;"></i>  POLLS</h4>
					<a href="polls" class="btn mini pull-right" style="color: #fff;background-color: transparent;border: solid 1px #fff;border-radius: 10px !important;">All Polls</a>
				</div>
				<div class="portlet-body" style="padding: 0px;height: 190px;">
					<table class="table  table-striped table-hover" style="cursor: pointer;">
						<?php
						foreach($result_poll as $data4)
						{
						$question=$data4['poll']['question'];
						$question_cut=(strlen($question) > 40) ? substr($question,0,37).'...' : $question;
						$date=$data4['poll']['date']; 
						?>
							<tr>
								<td width="75%"><?php echo $question_cut; ?></td>
								<td width="25%"><span style="color: #969696;"><?php echo $date; ?></span></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
	<div class="span4">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet">
			<div class="portlet box" style="background-color:#f13e46;">
				<div class="portlet-title">
					<h4><i class=" icon-leaf" style="font-size:18px;"></i>  RESOURCES</h4>
					<a href="resource_view" class="btn mini pull-right" style="color: #fff;background-color: transparent;border: solid 1px #fff;border-radius: 10px !important;">All Resources</a>
				</div>
				<div class="portlet-body" style="padding: 0px;height: 190px;">
					<table class="table  table-striped table-hover" style="cursor: pointer;">
						<?php
						foreach($result_resource as $data5)
						{
						$resource_title=$data5['resource']['resource_title'];
						$resource_title_cut=(strlen($resource_title) > 40) ? substr($resource_title,0,37).'...' : $resource_title;
						$resource_date=$data5['resource']['resource_date']; 
						?>
							<tr>
								<td width="75%"><?php echo $resource_title_cut; ?></td>
								<td width="25%"><span style="color: #969696;"><?php echo $resource_date; ?></span></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
	<div class="span4">
		<!-- BEGIN Portlet PORTLET-->
		<div class="portlet">
			<div class="portlet box" style="background-color:#44b6ae;">
				<div class="portlet-title">
					<h4><i class="icon-calendar" style="font-size:18px;"></i> EVENTS</h4>
					<a href="events" class="btn mini pull-right" style="color: #fff;background-color: transparent;border: solid 1px #fff;border-radius: 10px !important;">All Events</a>
				</div>
				<div class="portlet-body" style="padding: 0px;height: 190px;">
					<table class="table  table-striped table-hover" style="cursor: pointer;">
						<?php
						foreach($result_event as $data6)
						{
						$e_name=$data6['event']['e_name'];
						$e_name_cut=(strlen($e_name) > 40) ? substr($e_name,0,37).'...' : $e_name;
						$date=$data6['event']['date']; 
						?>
							<tr>
								<td width="75%"><?php echo $e_name_cut; ?></td>
								<td width="25%"><span style="color: #969696;"><?php echo $date; ?></span></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
		<!-- END Portlet PORTLET-->
	</div>
</div>				
				
				
<script>
function close_div(c3)
{

$("#div_close").hide();
window.location.href='dashboard?try=' + c3 ;
};


</script>				
				
				
				
