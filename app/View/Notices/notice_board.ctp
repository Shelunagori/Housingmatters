<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<div align="center">
<a href='notice_board' <?php if(empty($blue_cat)){ ?> class="btn red " <?php } else { ?> class="btn blue "  <?php } ?>>All</a>
<?php
foreach($result1 as $data)
{
$category_id=$data['master_notice_category']['category_id'];
$cat=$this->requestAction(array('controller' => 'hms', 'action' => 'encode'), array('pass' => array($category_id,'housingmatters')));
$category_name=$data['master_notice_category']['category_name'];
?>
<a href='notice_board?con=<?php echo $cat; ?>' <?php if(@$red_cat==$category_id) {  ?> class="btn red "<?php } else { ?> class="btn blue " <?php } ?>><?php echo $category_name; ?></a>
<?php } ?>
</div>
<br/>
<br/>
<div class="portlet box" style="background-color:#35aa47;">
	<div class="portlet-body">
		<table class="table table-striped table-bordered" id="sample_2">
			<thead>
				<tr>
					<th width="7%"> Sr. No.</th>
					<th width="50%">Subject</th>
					<th>Posted on</th>
					<th>Valid Till</th>
					<th>Recipients</th>
					<th width="15%"></th>
				</tr>
			</thead>
			<tbody>
<?php
$i=0;
foreach($result_notice_visible as $data)
{ $i++;
$notice_id=$data['notice']['notice_id'];
$n_subject=$data['notice']['n_subject'];
$n_message=$data['notice']['n_message'];
$n_date=$data['notice']['n_date'];
$n_expire_date=$data['notice']['n_expire_date'];
$n_expire_date= date('d-m-Y', $n_expire_date->sec);
$visible=$data['notice']['visible'];
$sub_visible=$data['notice']['sub_visible'];

$visible_detail='';
if($visible==1) 
{
	$visible_show="All Users";
	$visible_detail="All Users";
}
if($visible==4) 
{
	$visible_show="All Owners";
	$visible_detail="All Owners";
}
if($visible==5) 
{
	$visible_show="All Tenants";
	$visible_detail="All Tenants";
}
if($visible==2) 
{
	unset($role_name); 
	$visible_show="Role wise";
	foreach ($sub_visible as $role_id) 
	{
	$role_name1=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array($role_id)));
		if(!empty($role_name1))
		{
		$role_name[]=$role_name1;
		}
	}
	
	$visible_detail=implode(" , ",$role_name);
}

if($visible==3) 
{
	unset($wing_name);
	$visible_show="Wing wise";
	foreach ($sub_visible as $wing_id) 
	{
	$wing_name1="wing-".$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wingname_via_wingid'), array('pass' => array($wing_id)));
		if(!empty($wing_name1))
		{
		$wing_name[]=$wing_name1;
		}
	}
	$visible_detail=implode(" , ",$wing_name);
}

?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $n_subject; ?></td>
					<td><?php echo $n_date; ?></td>
					<td><?php echo $n_expire_date; ?></td>
					<td><a style="cursor: default;" class="tooltips" data-placement="bottom" data-original-title="<?php echo @$visible_detail; ?>"><?php echo $visible_show; ?></a></td>
					<td><a href="notice_board_view?con=<?php echo $notice_id; ?>" rel='tab'  class="btn mini yellow"><i class="icon-search"></i> View Notice</a></td>
				</tr>
<?php  } ?> 
			</tbody>
		</table>
	</div>
</div>





<script>
$(document).ready(function() {
	$(".sel").live('click',function(){
			$(".sel").removeClass("red");
			$(".sel").addClass("blue");
			$(this).removeClass("blue");
			 $(this).addClass("red");
			 });
	 });
</script>









