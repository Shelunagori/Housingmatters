<div style="float:right;">
<a class="btn blue"  onclick="window.print();" >Print </a>
</div>
<br/>
<br/>

<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
             Login Report For Units
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Sr No.</th>
<th>Unit #</th>
<th>User Name</th>
<th>Last Logged In Time</th>

</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_user as $data)
{
$i++;

 $user_name=$data['user']['user_name'];
 $date=$data['user']['date'];
  $wing_id=$data['user']['wing'];
   $flat_id=$data['user']['flat'];
 $time=$data['user']['time'];
 $flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $flat ; ?> </td>
<td><?php echo $user_name ; ?> </td>

<td><?php echo $date ; ?> &nbsp <?php echo $time ; ?></td>

</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>