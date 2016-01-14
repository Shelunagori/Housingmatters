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

<a href='notice_archive' rel='tab' <?php if(empty($blue_cat)){ ?> class="btn yellow " <?php } else { ?> class="btn  "  <?php } ?>>All</a>

<?php
foreach($result1 as $data)
{
$category_id=$data['master_notice_category']['category_id'];
$cat=$this->requestAction(array('controller' => 'hms', 'action' => 'encode'), array('pass' => array($category_id,'housingmatters')));
$category_name=$data['master_notice_category']['category_name'];
?>

<a href='notice_archive?con=<?php echo @$cat; ?>' rel='tab' <?php if(@$red_cat==$category_id) {  ?> class="btn yellow "<?php } else { ?> class="btn  " <?php } ?>><?php echo $category_name; ?></a>
<?php } ?>
</div>
<br/><br/>
<div style="background-color:#fff;padding:10px;">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
    <tr>
    <th width="7%"> Sr. No.</th>
    <th width="50%">Subject</th>
    <th>Posted on</th>
	 <th>Valid Till</th>
	 <th>Recipients</th>
    <th ></th>
    </tr>
</thead>
<tbody>
<?php
$i=0;
$current_date=date("d-m-Y");
foreach($result_notice_publish as $data)
{ 
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
	
	$role_name1=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_rolename_via_roleid'), array('pass' => array((int)$role_id)));
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




$i++;
?>
<tr class="odd gradeX">
    <td><?php echo $i; ?></td>
    <td><?php echo $n_subject; ?></td>
    <td><?php echo $n_date; ?></td>
	 <td><?php echo $n_expire_date; ?></td>
	 <td><a class="tooltips" style="cursor: default;" data-placement="bottom" data-original-title="<?php echo @$visible_detail; ?>"><?php echo $visible_show; ?></a></td>
    <td><a  rel='tab'  href="notice_publish_view/<?php echo $notice_id; ?>"  class="btn mini yellow " ><i class="icon-search"></i> View Notice</a></td>
	
</tr>
<?php }  ?> 
</tbody>
</table> 
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



<script>
$(document).ready(function() {
	$("#back").live('click',function(){
			$("#notice_view").hide();
			$("#all_notices").show();	
	});
});

</script>

<script>
function view_notice(n_id)
{

	$(document).ready(function() {
		
				$("#all_notices").hide();
				$("#notice_view").show();	
				$("#notice_view").html('<div align="center" style="padding:50px;"><img src="<?php echo $this->webroot ; ?>/as/windows.gif" /></div>').load('notice_publish_view?con=' + n_id);				
		
		
		});
	
}
</script>

<!--------REPLY------------>
<link href="<?php echo $this->webroot ; ?>/as/reply.css" rel="stylesheet" />
<?php $a=1; ?>
<script>
	

$(document).ready(function() {
	$("#reply").live('click',function(){
	
			var r=$("#msg_reply").val();
			var n_id=$("#notice_id").val();
			$("#reply_post").append('<div class="outt"><div><span class="pull-right" style="font-size:12px; color:#A5A5A5;">Few minutes ago</span><br>'+ r +'</div></div>');
			r=encodeURIComponent(r);
			$("#save_reply").html('Saving reply...').load('notice_save_reply?reply=' + r + '&n_id=' + n_id);
			$("#msg_reply").val('');
			
				
	});
});

</script>


