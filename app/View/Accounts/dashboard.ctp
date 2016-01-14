<?php 
foreach ($result_user as $collection)   
              	 {
					$c_email = $collection['user']['email'];
					$c_mobile = $collection['user']['mobile'];
					$c_name = $collection['user']['user_name'];
					$profile = @$collection['user']['profile_status'];
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
if(@$profile==1 && $progres<82)
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

















<?php 
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            @$length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                @$output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}
?>


<div class="row-fluid" style="background-color:#fff;">
<!---------left section start------------------>
	<div class="span9" >
	<!---------last 3 section start------------------>
		<div class="row-fluid">
			<div class="span4" >
			<!-------content----------->
			<table class="table shadow table-bordered table-advance table-hover">
				<thead>
					<tr>
						<th style="background-color:#C3DEEB;font-weight: 500;">
						<span class="label label-info"><i class=" icon-comments"></i></span> Discussion Forum
						<a href="<?php echo $this->webroot; ?>Discussions/index" rel='tab' class="pull-right" style="font-size: 12px;" ><i class="icon-search" style="text-decoration: none;font-size: 14px;"></i></a>
						<a href="<?php echo $this->webroot; ?>Discussions/new_topic" rel='tab' class="pull-right"><i class="icon-plus" style="text-decoration: none;font-size: 14px;padding: 0px 5px 0px 0px;"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(sizeof($result_discussion_topics)==0)
					{
					?>
					<tr>
						<td>
						<div align="center" style="color: #A5A5A5;padding: 16px;"><i class="icon-thumbs-down" style="font-size: 20px;"></i>
						<br>There are no topics in your discussion forum.</div>
						</td>
					</tr>
					<?php
					}
					
					foreach($result_discussion_topics as $discussion_data) 
					{
					$discussion_id=(int)$discussion_data['discussion_post']['discussion_post_id'];
					$topic=$discussion_data['discussion_post']['topic'];
					$description=$discussion_data['discussion_post']['description'];
					
					$topic_cut=substrwords($topic,25,'...');
					
					
					?>
					<tr>
						<td><a href="<?php echo $this->webroot; ?>Discussions/index/<?php echo $discussion_id; ?>/0" rel='tab' class="" data-trigger="hover" data-placement="bottom" data-content="<?php echo $description; ?>" data-original-title="<?php echo $topic; ?>"> <?php echo $topic_cut; ?> </a></td>
					</tr>
					<?php } 
					
					if(sizeof($result_discussion_topics)==1)
					{
					?>
					<tr>
						<td style="height: 57px;"></td>
					</tr>
					<?php
					}
						
						
					if(sizeof($result_discussion_topics)==2)
					{
					?>
					<tr>
						<td style="height: 22px;"></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
			<!-------content----------->
			</div>
			<div class="span4" >
			<!-------content----------->
			<table class="table shadow table-bordered table-advance table-hover">
				<thead>
					<tr >
						<th style="background-color:#C0EEEB;font-weight: 500;">
						<span class="label" style="background-color:#44b6ae;"><i class=" icon-gift"></i></span> Events
						<a href="<?php echo $this->webroot; ?>Events/events" rel='tab' class="tooltips pull-right" style="font-size: 12px;"> <i class="icon-search" style="text-decoration: none;font-size: 14px;"></i></a>
						<a href="<?php echo $this->webroot; ?>Events/event_add" rel='tab' class="pull-right"><i class="icon-plus" style="text-decoration: none;font-size: 14px;padding: 0px 5px 0px 0px;"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(sizeof($result_event_last)==0)
					{
					?>
					<tr>
						<td>
						<div align="center" style="color: #A5A5A5;padding: 16px;"><i class="icon-thumbs-down" style="font-size: 20px;"></i>
						<br>There are no events to display.<br/><br/></div>
						</td>
					</tr>
					<?php
					}
					
					
					
					foreach($result_event_last as $event_data) 
					{
					$event_id=(int)$event_data['event']['event_id'];
					$e_name=$event_data['event']['e_name'];
					
					$e_name_cut=substrwords($e_name,25,'...');
					?>
					<tr>
						<td><a href="<?php echo $this->webroot; ?>Events/event_info/<?php echo $event_id; ?>" rel='tab'> <?php echo $e_name_cut; ?> </a></td>
					</tr>
					<?php }

					if(sizeof($result_event_last)==1)
					{
					?>
					<tr>
						<td style="height: 57px;"></td>
					</tr>
					<?php
					}
						
						
					if(sizeof($result_event_last)==2)
					{
					?>
					<tr>
						<td style="height: 22px;"></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
			<!-------content----------->
			</div>
			<div class="span4" >
			<!-------content----------->
			<?php if($role_id==3) { 
			$url_see_all='help_desk_sm_all_ticket';
			}

			if($role_id!=3) { 
			$url_see_all='help_desk_r_all_ticket';
			} ?>
			<table class="table shadow table-bordered table-advance table-hover">
				<thead>
					<tr >
						<th style="background-color:#FDEFD2;font-weight: 500;">
						<span class="label label-warning"><i class="icon-headphones"></i></span> Help-Desk
						<a href="<?php echo $this->webroot; ?>Helpdesks/<?php echo $url_see_all; ?>" rel='tab' class="pull-right" style="font-size: 12px;" ><i class="icon-search" style="text-decoration: none;font-size: 14px;"></i></a>
						<a href="<?php echo $this->webroot; ?>Helpdesks/help_desk_genarate_ticket" rel='tab' class="pull-right"><i class="icon-plus" style="text-decoration: none;font-size: 14px;padding: 0px 5px 0px 0px;"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if(sizeof($result_help_desk)==0)
				{
				?>
				<tr>
					<td>
					<div align="center" style="color: #A5A5A5;padding: 16px;"><i class="icon-thumbs-down" style="font-size: 20px;"></i>
					<br>There are no helpdesk tickets to display.</div>
					</td>
				</tr>
				<?php
				}
					
				foreach($result_help_desk as $help_desk_data) 
				{
				$help_desk_id=(int)$help_desk_data['help_desk']['help_desk_id'];
				$ticket_id=$help_desk_data['help_desk']['ticket_id'];
				$complain_type_id=$help_desk_data['help_desk']['help_desk_complain_type_id'];
				$help_desk_status=(int)$help_desk_data['help_desk']['help_desk_status'];
				
				$complain_name=$this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'), array('pass' => array($complain_type_id)));
				
				if($role_id==3) { 
				$url='help_desk_sm_view/'.$help_desk_id.'/'.$help_desk_status;
				}

				if($role_id!=3) { 
				$url='help_desk_r_view/'.$help_desk_id.'/'.$help_desk_status;
				}
				?>
					<tr>
						<td><a href="<?php echo $this->webroot; ?>Helpdesks/<?php echo $url; ?>" rel='tab'> <?php echo $ticket_id.' - '.$complain_name; ?> </a></td>
					</tr>
				<?php } 
				
				
				if(sizeof($result_help_desk)==1)
				{
				?>
				<tr>
					<td style="height: 57px;"></td>
				</tr>
				<?php
				}
					
					
				if(sizeof($result_help_desk)==2)
				{
				?>
				<tr>
					<td style="height: 22px;"></td>
				</tr>
				<?php
				}
				
				?>
				</tbody>
			</table>
			<!-------content----------->
			</div>
		</div>
	<!---------last 3 section end------------------>
	
	
	<div style="height: 10px;"></div>
	<!---------last 3 section start------------------>
		<div class="row-fluid">
			<div class="span4" >
			<!-------content----------->
			<?php if($role_id==3) { 
			$url_see_all='notice_publish';
			}

			if($role_id!=3) { 
			$url_see_all='notice_publish';
			} ?>
			<table class="table shadow table-bordered table-advance table-hover">
				<thead>
					<tr >
						<th style="background-color:#F3DDD8;font-weight: 500;">
						<span class="label label-important"><i class="icon-bullhorn"></i></span> Notices
						<a href="<?php echo $webroot_path; ?>Notices/<?php echo $url_see_all; ?>" rel='tab' class="pull-right" style="font-size: 12px;" ><i class="icon-search" style="text-decoration: none;font-size: 14px;"></i></a>
						<a href="<?php echo $webroot_path; ?>Notices/new_notice" rel='tab' class="pull-right"><i class="icon-plus" style="text-decoration: none;font-size: 14px;padding: 0px 5px 0px 0px;"></i></a>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					if(sizeof($result_notice_visible_last)==0)
					{
					?>
					<tr>
						<td>
						<div align="center" style="color: #A5A5A5;padding: 16px;"><i class="icon-thumbs-down" style="font-size: 20px;"></i>
						<br>There are no notices in the notice board</div>
						</td>
					</tr>
					<?php
					}
					
					
					foreach($result_notice_visible_last as $notice_data) 
					{
					$notice_id=(int)$notice_data['notice']['notice_id'];
					$n_subject=$notice_data['notice']['n_subject'];
					
					$n_subject_cut=substrwords($n_subject,25,'...');
					
					$url='notice_publish_view/'.$notice_id;

					
					?>
					<tr>
						<td><a href="<?php echo $webroot_path; ?>Notices/<?php echo $url; ?>" rel='tab'> <?php echo $n_subject_cut; ?> </a></td>
					</tr>
					<?php } 
					
					if(sizeof($result_notice_visible_last)==1)
					{
					?>
					<tr>
						<td style="height: 57px;"></td>
					</tr>
					<?php
					}
						
						
					if(sizeof($result_notice_visible_last)==2)
					{
					?>
					<tr>
						<td style="height: 22px;"></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
			<!-------content----------->
			</div>
			<div class="span4" >
			<!-------content----------->
			<table class="table shadow table-bordered table-advance table-hover">
				<thead>
					<tr >
						<th style="background-color:#EDC8F6;font-weight: 500;">
						<span class="label" style="background-color:#6d1b81;"><i class="icon-question-sign"></i></span> Polls
						<a href="<?php echo $this->webroot ; ?>Polls/polls" rel='tab' class="pull-right" style="font-size: 12px;" ><i class="icon-search" style="text-decoration: none;font-size: 14px;"></i></a>
						<a href="<?php echo $this->webroot ; ?>Polls/poll_add" rel='tab' class="pull-right"><i class="icon-plus" style="text-decoration: none;font-size: 14px;padding: 0px 5px 0px 0px;"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					if(sizeof($result_poll_last)==0)
					{
					?>
					<tr>
						<td>
						<div align="center" style="color: #A5A5A5;padding: 16px;"><i class="icon-thumbs-down" style="font-size: 20px;"></i>
						<br>There are no active polls in the Polling Booth.</div>
						</td>
					</tr>
					<?php
					}
					
					foreach($result_poll_last as $poll_data) 
					{
					$poll_id=(int)$poll_data['poll']['poll_id'];
					$question=$poll_data['poll']['question'];
					
					$question_cut=substrwords($question,25,'...');
					?>
					<tr>
						<td><a href="<?php echo $this->webroot ; ?>Polls/polls" rel='tab'> <?php echo $question_cut; ?> </a></td>
					</tr>
					<?php } 
					
					if(sizeof($result_poll_last)==1)
					{
					?>
					<tr>
						<td style="height: 57px;"></td>
					</tr>
					<?php
					}
						
						
					if(sizeof($result_poll_last)==2)
					{
					?>
					<tr>
						<td style="height: 22px;"></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
			<!-------content----------->
			</div>
			<div class="span4" >
			<!-------content----------->
			<table class="table shadow table-bordered table-advance table-hover">
				<thead>
					<tr >
						<th style="background-color:#BDE5C3;font-weight: 500;">
						<span class="label label-success"><i class="icon-file"></i></span> Documents
						<a href="<?php echo $this->webroot ; ?>Documents/resource_view" rel='tab' class="pull-right" style="font-size: 12px;" ><i class="icon-search" style="text-decoration: none;font-size: 14px;"></i></a>
						<a href="<?php echo $this->webroot ; ?>Documents/resource_add" rel='tab' class="pull-right"><i class="icon-plus" style="text-decoration: none;font-size: 14px;padding: 0px 5px 0px 0px;"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					if(sizeof($result_resource_last)==0)
					{
					?>
					<tr>
						<td>
						<div align="center" style="color: #A5A5A5;padding: 16px;"><i class="icon-thumbs-down" style="font-size: 20px;"></i>
						<br>There are no documents in the Resources.</div>
						</td>
					</tr>
					<?php
					}
					
					foreach($result_resource_last as $resource_data) 
					{
					$resource_id=(int)$resource_data['resource']['resource_id'];
					$resource_title=$resource_data['resource']['resource_title'];
					
					$resource_title_cut=substrwords($resource_title,25,'...');
					?>
					<tr>
						<td><a href="<?php echo $this->webroot ; ?>Documents/resource_view" rel='tab'> <?php echo $resource_title_cut; ?> </a></td>
					</tr>
					<?php } 
					
					if(sizeof($result_resource_last)==1)
					{
					?>
					<tr>
						<td style="height: 57px;"></td>
					</tr>
					<?php
					}
						
						
					if(sizeof($result_resource_last)==2)
					{
					?>
					<tr>
						<td style="height: 22px;"></td>
					</tr>
					<?php
					}
					
					?>
				</tbody>
			</table>
			<!-------content----------->
			</div>
		</div>
	<!---------last 3 section end------------------>
	</div>
<!---------left section end------------------>	

<!---------right section start------------------>	
	<div class="span3" >
	<!-------content----------->
	<div align="center" style="border: solid 2px #E2E2E2;padding: 20px;height: 270px;    color: #3D3D3D;">
	<i class="icon-time" style="font-size: 20px;"></i><br>
	<h5>New features coming soon, watchout for this space!</h5>
	</div>
	<!-------content----------->
	</div>
<!---------right section end------------------>
</div>

<style>
.shadow {
    box-shadow: 1px 1px 1px #888888;
}
</style>

<script>
function close_div(c3)
{

$("#div_close").hide();
window.location.href='dashboard?try=' + c3 ;
};
</script>


<script>

$(document).ready(function() {

<?php

 $cont_not= sizeof($not_res);
if($cont_not>0)
{
foreach($not_res as $data)
{
 $topic=$data['notice']['n_subject'];
  $notice_id=(int)$data['notice']['notice_id'];
 ?>	
            $.gritter.add({
               
                title: 'Notice',
               text: 'The Notice <?php echo $topic ; ?> is rejected. ',
               sticky: false,
                time: '10000',
				
            });
	<?php  $this->requestAction(array('controller' => 'hms', 'action' => 'reject_notification'), array('pass' => array($notice_id,1))); } }?>

<?php
$cont_dis= sizeof($disc_res);
if($cont_dis>0)
{
foreach($disc_res as $data)
{
 $topic=$data['discussion_post']['topic'];
 $discussion_post_id=$data['discussion_post']['discussion_post_id'];
 ?>	
 $.gritter.add({
               
                title: ' discussion forum ',
               text: 'The discussion topic <?php echo $topic ; ?> is rejected. ',
               sticky: false,
                time: '10000',
				
            });
	<?php $this->requestAction(array('controller' => 'hms', 'action' => 'reject_notification'), array('pass' => array($discussion_post_id,2)));} } ?>
	
<?php
$cont_poll= sizeof($poll_res);
if($cont_poll>0)
{
foreach($poll_res as $data)
{
 $topic=$data['poll']['question'];
 $poll_id=(int)$data['poll']['poll_id'];
 ?>	
 $.gritter.add({
               
               title: 'Polls',
               text: 'The Poll question <?php echo $topic ; ?> is rejected. ',
               sticky: false,
                time: '10000',
				
            });
	<?php $this->requestAction(array('controller' => 'hms', 'action' => 'reject_notification'), array('pass' => array($poll_id,3))); } } ?>
           
<?php
$cont_document= sizeof($resource_res);
if($cont_document>0)
{
foreach($resource_res as $data)
{
 $topic=$data['resource']['resource_title'];
 $resource_id=(int)$data['resource']['resource_id'];
 ?>	
 $.gritter.add({
               
               title: 'Document',
               text: 'The Document <?php echo $topic ; ?> is rejected. ',
               sticky: false,
                time: '10000',
				
            });
	<?php $this->requestAction(array('controller' => 'hms', 'action' => 'reject_notification'), array('pass' => array($resource_id,4))); } } ?>

<?php

$status1=(int)$this->Session->read('profile_status');
if($status1==1)
{

?>	

 $.gritter.add({
               
               title: '<i class="icon-user"></i> Profile',
               text: 'Your profile is successfully update.',
               sticky: false,
                time: '10000',
				
            });

<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(101)));
} 


$status5=(int)$this->Session->read('feedback_status');
if($status5==1)
{
?>

 $.gritter.add({
               
               title: '<i class="icon-phone-sign"></i> Feedback',
               text: '<p>Thank you for getting in touch with us.</p><p>We shall Respond to you within 24 hours.</p>',
               sticky: false,
                time: '10000',
				
            });

<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(102)));
}
?>


		   return false;

      

   
});


</script>

