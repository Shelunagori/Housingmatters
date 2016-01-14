
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
<i class="icon-credit-card"></i> Invite member View
</div>



<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th>Sr No.</th>
<th>Date</th>
<th>Name</th>
<th>Email</th>

</tr>
</thead>
<tbody>

<?php

////connection//////

$i=0;
foreach ($result_invitation as $collection) 
{ 
$i++;
$name=$collection['invitation']['name'];
$email=$collection['invitation']['email'];
$date=$collection['invitation']['date'];

?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $date; ?></td>
<td><?php echo $name; ?></td>
<td><?php echo $email; ?></td>
<?php } ?>
</tbody>
</table>

</div>
</div>
</div>
</div>