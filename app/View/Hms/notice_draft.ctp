<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>


<div align="center">
<a href='notice_draft' <?php if(empty($blue_cat)){ ?> class="btn red " <?php } else { ?> class="btn blue "  <?php } ?>>All</a>
<?php
foreach($result1 as $data)
{
$category_id=$data['master_notice_category']['category_id'];
$cat=$this->requestAction(array('controller' => 'hms', 'action' => 'encode'), array('pass' => array($category_id,'housingmatters')));
$category_name=$data['master_notice_category']['category_name'];
?>

<a href='notice_draft?con=<?php echo @$cat; ?>' <?php if(@$red_cat==$category_id) {  ?> class="btn red "<?php } else { ?> class="btn blue " <?php } ?>><?php echo $category_name; ?></a>
<?php } ?>
</div> 
<br/><br/>
<div style="background-color:#fff;padding:10px;">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
    <tr>
    <th width="7%"> Sr. No.</th>
    <th>Subject</th>
    <th class="hidden-phone">Date</th>
    <th width="15%"></th>
    </tr>
</thead>
<tbody>
<?php
$i=0;
foreach($result_notice_draft as $data)
{ $i++;
$notice_id=$data['notice']['notice_id'];
$n_subject=$data['notice']['n_subject'];
$n_message=$data['notice']['n_message'];
$n_date=$data['notice']['n_date'];




?>
<tr class="odd gradeX">
    <td><?php echo $i; ?></td>
    <td><?php echo $n_subject; ?></td>
    <td><?php echo $n_date; ?></td>
    <td><a href="notice_edit?n=<?php echo $notice_id; ?>" role="button" class="btn mini yellow tooltips" data-placement="bottom" data-original-title="Click to edit the notice" data-toggle="modal"><i class=" icon-edit"></i> Edit Notice</a></td>
	
</tr>
<?php } ?> 
</tbody>
</table> 
</div>