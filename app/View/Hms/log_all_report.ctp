<div> 
<a href="login_report_user"  class=" btn blue" > Back </a>
</div>
<br>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
           All Logged In Time For Users
</div>


<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">

<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_1">
<thead>
<tr>
<th>Sr No.</th>
<th>All Logged In Time </th>
</tr>
</thead>
<tbody>

<?php
$i=0;
foreach($result_log as $data)
{
$i++;
$date=$data['log']['date'];
$time=$data['log']['time'];

?>
<tr class="odd gradeX" >
<td><?php echo $i ; ?></td>
<td><?php echo @$date ; ?> &nbsp <?php echo @$time ; ?></td>

</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div> 