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

<div>
<div><span class="label label-info " style="padding:10px; font-size:20px;float:left;" >Total two wheeler slot: <?php echo $two_n;?></span></div>
<div><span class="label label-info"style="padding:10px;font-size:20px;float:right;">Total four wheeler slot: <?php echo $four_n;?></span></div>
</div>
<br><br><br><br>
<div class="tab-content" >

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th style="">Sr No.</th>
<th>Slot no </th>
<th>Type</th>
</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_parking as $data)
{
$i++;
@$slot_no=@$data['parking']['slot_no'];
@$type=@$data['parking']['type'];

?>
<tr class="odd gradeX" >
<td><?php echo $i ; ?></td>
<td>
<?php echo $slot_no ; ?>
 </td>
<td>
<?php echo $type ; ?>


  </td>
</tr>
<?php  } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>