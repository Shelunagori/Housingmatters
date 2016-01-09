		 <?php
      		if(empty($value))
	   			{ ?>
        <label style="font-size:14px;">Select flat<span style="color:#F00;">*</span></label>
        <div class="controls">
        <select class="m-wrap span9" name="fflt" id="fll">
        <option value="">Select Flat</option>
		<?php 
        foreach($flat_data as $data)
        {
		$flat_id = (int)$data['flat']['flat_id'];
		$flat_name = $data['flat']['flat_name'];		
        ?>
		<option value="<?php echo $flat_id; ?>"><?php echo $flat_name; ?></option>
		<?php
        }
        ?>
		</select>
        <label id="fll"></label>
       
        </div>
        
<?php
}
if(!empty($value))
{
?>
<table class="table table-bordered" style="width:80%;"> 	
<tr style="background-color:#6FF;">
<th>Wing Name</th>
<th>Flat Name</th>
</tr>	
<?php	

foreach($user_data as $usss_ddd)
{
	
@$flat_id = $usss_ddd['user_flat']['flat_id'];

$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach($result_flat_info as $flat_info){
	$wing_id=$flat_info["flat"]["wing_id"];
} 
				

$flat_detaill = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,@$wing_id)));
foreach($flat_detaill as $ffllddd)
{
$flat_name = $ffllddd['flat']['flat_name'];	
}
$wing_detail = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_fetch'),array('pass'=>array(@$wing_id)));
foreach($wing_detail as $fflldddd)
{
$wing_name = $fflldddd['wing']['wing_name'];	
}
?>
<tr>
<td style="text-align:left;"><?php echo @$wing_name; ?></td>
<td style="text-align:left;"><?php echo @$flat_name; ?></td> 	    
</tr>
<?php } ?>
</table>
<?php
}
?>