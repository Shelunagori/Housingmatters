<div style="float:right;">
<a class="btn blue hide_at_print"  onclick="window.print();" >Print </a>
</div>
<br/>
<br/>

<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;"><i class="icon-user-md"></i>
             Profile Report For Users
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="">
<thead>
<tr>
<th>Sr No.</th>
<th>Flat</th>
<th>User Name</th>
<th>Last Profile update  In Time</th>

</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_user as $data)
{
$i++;

 $user_name=$data['user']['user_name'];
 $da_user_id=$data['user']['user_id'];
   $wing_id=$data['user']['wing'];
   $flat_id=$data['user']['flat'];
  $flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
   $result_log=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_log'), array('pass' => array($da_user_id)));
   foreach($result_log as $data)
   {
    @$date=$data['profile_log']['date'];
    @$time=$data['profile_log']['time'];
	
   }
?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $flat ; ?> </td>
<td><a href="profile_all_report?con=<?php echo $da_user_id ; ?>"> <?php echo $user_name ; ?> </a> </td>
<td><?php echo @$date ; ?> &nbsp <?php echo @$time ; ?></td>

</tr>
<?php $date='';$time=''; } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>