<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
           
<table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
<tr>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn" rel='tab'>Selection of Income Heads</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn" style="font-size:16px;" rel='tab'>Rate Card</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn yellow" style="font-size:16px;" rel='tab'>Non Occupancy Charges</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_penalty" class="btn" style="font-size:16px;" rel='tab'>Penalty Option</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/neft_add" class="btn" style="font-size:16px;" rel='tab'>Add NEFT</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/it_setup" class="btn" style="font-size:16px;" rel='tab'>Remarks</a>
</td>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/other_charges" class="btn" rel='tab'>Other Charges</a>
</td>
</tr>
</table> 
<div align="center">
<a href="master_noc" class='btn blue' role="button" rel='tab'>Non Occupancy Charges</a>
<a href="master_noc_status" class='btn red' role="button"  rel='tab'>Non Occupancy Status</a>
</div>
<br/>
<div align="right">
<?php 
$z=0;$j=0;

foreach($flats_for_bill as $flat_data_id){
$noc_flat1= $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch'),array('pass'=>array($flat_data_id)));
	foreach($noc_flat1 as $dafa){
		@$noc_type1=@$dafa['flat']['noc_ch_tp'];
	}
	if(@$noc_type1==1){

	$z++;
	}
	if(@$noc_type1==2){
	$j++;
	}
} 
?>
<span class="label label-info"> Number of Self Occupied flats <span style="font-size:15px;"><?php echo $z; ?> </span> </span> 
<span class="label label-info"> Number of Leased flats <span style="font-size:15px;"><?php echo $j; ?> </span></span>
</div>
<form method="post">

<div style="background-color: #fff;">
<br/>
<table class="table table-striped table-bordered dataTable" id="" aria-describedby="sample_1_info" >
<thead>
<tr>
<th>Sr.n.</th>
<th>User Name</th>
<th >Unit</th>
<th>NOC Type
 &nbsp; 
<label class="radio"><input type="radio"  name="" class="all_chk" value="1" ><span style="font-size:12px;">Select All (Self Occupied)</span></label>
<label class="radio"><input type="radio"  name="" class="all_chk"  value="2" ><span style="font-size:12px;">Select All (Leased)</span></label>
	</th>
</tr>
</thead>
<tbody>
<?php 

$i=0;

foreach($flats_for_bill as $flat_data_id){
$i++;
$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_data_id)));

foreach($result_flat_info as $flat_info){
	$wing_id=$flat_info["flat"]["wing_id"];

	$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_data_id)));
	$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_data_id)));
	

	foreach($result_user_info as $user_info){
		$user_id=(int)$user_info["user"]["user_id"];
		$user_name=$user_info["user"]["user_name"];

	$noc_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch'),array('pass'=>array($flat_data_id)));

	foreach($noc_flat as $dafa){
	@$noc_type=@$dafa['flat']['noc_ch_tp'];
	}
		
	?>
	<tr>
	<td><?php echo $i ; ?></td>
	<td><?php echo $user_name ; ?></td>
	<td><?php echo $wing_flat ; ?></td>
	
	<td>
	<div class="controls" id="residing_div1">
	<label class="radio"><input type="radio" class="self_occ" name="<?php echo $flat_data_id; ?>" <?php if(@$noc_type==1) { ?> checked <?php } ?>   value="1">Self Occupied</label>
	<label class="radio"><input type="radio" class="leas"  name="<?php echo $flat_data_id; ?>" <?php if(@$noc_type==2) { ?> checked <?php } ?>  value="2">Leased</label>
	</div>
	</td>
	</tr>
	<?php
} 	
	
	
}

}

?>
</tbody>
</table>
</div>
	<div class="">
	<button type="submit" class="btn blue"><i class="icon-ok"></i> Update</button>

	</div>
</form>

<script>
$(document).ready(function(){
$(".all_chk").bind("click",function(){
var r=$(this).val();

if(r==1)
{
$(".self_occ").attr('checked','checked');
$(".self_occ").parent('span').addClass('checked');

$(".leas").parent('span').removeClass('checked');
$(".leas").removeAttr('checked','checked');

}
else
{
$(".leas").attr('checked','checked');
$(".leas").parent('span').addClass('checked');

$(".self_occ").parent('span').removeClass('checked');
$(".self_occ").removeAttr('checked','checked');

}
});


})
</script>