

<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>


<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Parking Managment System 
</div>-->

<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th style="">Sr No.</th>
<th>Flat </th>
<th>User Name </th>
<th>Slot no </th>
<th>Type</th>
<th>Vehicle Number</th>

</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_user as $data)
{
$parking=$data['user']['parking'];


$wing=$data['user']['wing'];
$flat=$data['user']['flat'];
$user_name=$data['user']['user_name'];
$wing_f= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));

foreach($parking as $dd)
{

  $park=$dd[0];
  $vehicle_no=$dd[1];
$park_id= $this->requestAction(array('controller' => 'hms', 'action' => 'parking_slot'),array('pass'=>array((int)$park)));

foreach($park_id as $dd)
{
 $i++;
 $slot_no=$dd['parking']['slot_no']; 
$type=$dd['parking']['type']; 
?>
<tr class="odd gradeX" >
<td><?php echo $i ; ?></td>
<td><?php echo $wing_f ; ?></td>
<td><?php echo $user_name ; ?></td>
<td><?php echo $slot_no ; ?></td>
<td><?php echo $type ; ?></td>
<td><?php echo $vehicle_no ; ?></td>
</tr>
<?php } } }
 ?>
</tbody>
</table>
</div>
</div>
</div>
</div>