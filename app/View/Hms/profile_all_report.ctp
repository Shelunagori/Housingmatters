<div> 
<a href="profile_report"  class=" btn blue" > Back </a>
</div>
<br>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
           All Profile update log Time For Users
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="">
<thead>
<tr>
<th>Sr No.</th>
<th>email</th>
<th>mobile</th>
<th>change email</th>
<th>change mobile</th>
<th>All profile update Logged In Time </th>
</tr>
</thead>
<tbody>

<?php
$i=0;

foreach($result_profile_log as $data)
{
$i++;
$date=$data['profile_log']['date'];
$time=$data['profile_log']['time'];
$old_email=$data['profile_log']['email'];
$new_email=$data['profile_log']['new_email'];
$old_mobile=$data['profile_log']['mobile'];
$new_mobile=$data['profile_log']['new_mobile'];

?>
<tr class="odd gradeX" >
<td><?php echo $i ; ?></td>
<td><?php echo $old_email ; ?></td>
<td><?php echo $old_mobile ; ?></td>
<td><?php echo $new_email ; ?></td>
<td><?php echo $new_mobile ; ?></td>
<td><?php echo @$date ; ?> &nbsp <?php echo @$time ; ?></td>

</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div> 