<div style="float:right;">
<a class="btn blue hide_at_print"  onclick="window.print();" >Print </a>
</div>
<br/>
<br/>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px;  box-shadow:5px; font-size:16px; color:#006;"><i class="icon-group"></i>
              List of contact reports
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="" >
<thead>
<tr>
<th>Sr No.</th>
<th>User Name</th>
<th>Contact</th>

</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_user as $data)
{
$i++;

 $user_name=$data['user']['user_name'];
 $mobile=$data['user']['mobile'];
 $date=$data['user']['date'];
  $time=$data['user']['time'];
 
?>
<tr class="odd gradeX" >
<td><?php echo $i; ?></td>
<td><?php echo $user_name ; ?> </td>
<td><?php echo $mobile ; ?></td>

</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>