<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
              Committee metters view
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th>Sr No.</th>
<th>Title</th>
<th>Date</th>
<th>To</th>
<th>From</th>
<th>Place</th>
<th>description</th>
</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_com as $data)
{
$i++;

 $title=$data['committee_metter']['com_title'];
 $date=$data['committee_metter']['com_date'];
 $time_to=$data['committee_metter']['com_time_to'];
 $time_from=$data['committee_metter']['com_time_from'];
 $place=$data['committee_metter']['com_place'];
 $description=$data['committee_metter']['com_description'];
  


?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $title ; ?> </td>
<td><?php echo $date ; ?></td>
<td><?php echo $time_to ; ?></td>
<td><?php echo $time_from ; ?></td>
<td><?php echo $place ; ?></td>
<td><a href="#ap<?php echo $i; ?>" role="button" class="btn mini green" data-toggle="modal">View</a>

<!--POP UP BOX-->
<div id="ap<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none; " align="center">
<div class="modal-header">

<h3 id="myModalLabel2" style=" padding:10px; font-size:16px; text-align:justify;"><b>Description</b></h3>
</div>
<div class="modal-body">
<div style=" padding:10px; font-size:16px; text-align:justify;" ><?php echo $description ; ?></div>

</div>
<div class="modal-footer">

<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>  
</div>
</div>
<!--END OF POP UP BOX-->  

			
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>