<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
                Society Report
</div>

<div class="portlet-body" style="";>
			<!--BEGIN TABS-->
		<div class="tabbable tabbable-custom">
			<ul class="nav nav-tabs">
			<li class="active"><a href="asisgn_module_to_role" >View</a></li>
			</ul>
			<div class="tab-content" style="min-height:500px;">
				<div class="tab-pane active" id="tab_1_1">

	<span class="label label-info pull-right" style="padding:10px; font-size:20px"> Total Number of Societies : <?php echo $n ; ?></span>
	
<div class="portlet box ">
<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th>Sr No.</th>
<th>Society Name</th>
<th>Member</th>
</tr>
</thead>
	<tbody>

		<?php 
		$i=0;
		foreach($result_society as $data)
		{
			$i++;
			$society_name=$data['society']['society_name'];
			$society_id=$data['society']['society_id'];
			$count_member = $this->requestAction(array('controller' => 'hms', 'action' => 'society_count_user'),array('pass'=>array($society_id)));
			?>
			<tr class="odd gradeX" >
			<td><?php echo $i ; ?></td>
			<td><?php echo $society_name ; ?></td>
			<td><span class="label label-info pull" style=" font-size:14px"><?php echo $count_member; ?></span></td>
			</tr>
			<?php 
		}
		?>

	</tbody>
</table>
</div>
</div>
	
	
	
	
	
	
				</div>
			</div>
	</div>
</div>