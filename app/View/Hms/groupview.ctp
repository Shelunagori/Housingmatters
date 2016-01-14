<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$( document ).ready( function() {
   jQuery('.tooltips').tooltip();
   
   
    var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle)");
        if (test) {
            test.uniform();
        }

   
});
</script>
<a href="groups" rel="tab" class="btn  blue"><i class="icon-caret-left"></i> All Groups</a><br/><br/>
<div class="span9">
	<!-- BEGIN BORDERED TABLE PORTLET-->
	<div class="portlet box green">
		<div class="portlet-title">
			<h4><?php echo $group_name; ?></h4>
		</div>
		<div class="portlet-body">
		<div class="pull-left">Total Members :<span class="label label-info"><?php echo sizeof($result_group_info); ?></span></div>
		<form  method="POST">
		<a href="#myModal1" role="button" class="btn btn-primary pull-right" data-toggle="modal">Add or Remove Members</a>
		<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 id="myModalLabel1">Add or Remove Members</h3>
			</div>
			<div class="modal-body">
				
				<?php foreach($all_users as $user) { 
				$user_id=$user['user']['user_id'];
				$name=$user['user']['user_name'];
				$profile_pic=$user['user']['profile_pic'];
				
				?>
				
					<div  style="width:49%;float:left;">
					<label class="checkbox">
					<table width="100%" class="user_div">
						<tr>
						<td width="20px">
						<div class="checker" id="uniform-undefined"><span>
						<input type="checkbox" value="1" name="user<?php echo $user_id; ?>" <?php if (in_array($user_id, $result_group_info)) { echo 'checked="checked"'; } ?> style="opacity: 0;">
						</span></div> 
						</td>
						<td>
						<table width="100%">
							<tr>
							<td width="35px"><img src="<?php echo $this->webroot; ?>profile/<?php echo $profile_pic; ?>" style="width: 35px;height: 35px;"/><td>
							<td valign="top"><div style="font-size:16px;"><?php echo $name; ?></div><div style="font-size:14px;">A-101</div><td>
							</tr>
						</table>
						</td>
						</tr>
					</table>
					</label>	
							
							
						
						
						
					</div>
				<?php } ?>
				
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<button type="submit" class="btn blue" name="update_members">Update Members</button>
			</div>
			
		</div>
		</form>						
								
			<table class="table-striped" width="100%">
				<tbody>
				<?php if($result_group_info==null) { $result_group_info=array();} ?>
				<?php foreach($result_group_info as $user_id) { 
				$result_user_info=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'), array('pass' => array($user_id)));
				foreach($result_user_info as $collection2)
				{
				$user_name=$collection2["user"]["user_name"];
				$profile_pic=$collection2["user"]["profile_pic"];
				$wing=$collection2["user"]["wing"];
				$flat=$collection2["user"]["flat"];
				}
				$flat_info=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing,$flat)));
				?>
					<tr>
						<td width="50px"><img src="<?php echo $this->webroot; ?>profile/<?php echo $profile_pic; ?>" style="width: 35px;height: 35px;"/></td>
						<td width="40%"><?php echo $user_name; ?></td>
						<td><?php echo $flat_info; ?></td>
					</tr>
				
				<?php } ?>
				<?php if(sizeof($result_group_info)==0){ ?>
					<tr>
						<td colspan="3" align="center">
						<div align="center">No member added.<br/><a href="#myModal1" role="button" class="btn btn-primary " data-toggle="modal">Add Members</a></div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- END BORDERED TABLE PORTLET-->
</div>

<style>
.user_div:hover{
background-color:#F0EFEF;
}
</style>