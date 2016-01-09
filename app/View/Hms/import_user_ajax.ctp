<?php
$i=0;
foreach($table as $child){
	$i++;
	?>
	<tr id="tr<?php echo $i; ?>">
		<td width="15%"><input type="text" class="span12 m-wrap textbox" name="name" id="name1" style="font-size:16px;  background-color: white !important;" placeholder="Name*" value="<?php echo $child[0]; ?>"></td>
		
		<td width="10%">
		<select class="span12 m-wrap wing" id="wing2" name="wing" inc_id="<?php echo $i; ?>">
		<option value="">-Wing-</option>
		<?php 
		foreach($result_wing as $data) { 
		$wing_id=$data["wing"]["wing_id"];
		$wing_name=$data["wing"]["wing_name"];
		?>
		<option value="<?php echo $wing_id; ?>" <?php if($wing_id==$child[1]){ echo 'selected';} ?> ><?php echo $wing_name; ?></option>
		<?php } ?>

		</select>
		</td>
		
		<td id="echo_flat<?php echo $i; ?>" width="10%">
		<?php $result_flat=$this->requestAction(array('controller' => 'Hms', 'action' => 'flat'), array('pass' => array($child[1]))); ?>
		<select class="span12 m-wrap" id="flat1" name="flat" >
		<option value="">Flat</option>
		<?php 
		foreach($result_flat as $data) { 
		$flat_id=$data["flat"]["flat_id"];
		$flat_name=$data["flat"]["flat_name"];
		?>
		<option value="<?php echo $flat_id; ?>" <?php if($flat_id==$child[2]){ echo 'selected';} ?> ><?php echo $flat_name; ?></option>
		<?php } ?>
		</select>
		</td>
		
		<td width="20%"><input type="text" class="span12 m-wrap textbox" name="email" id="email1" style="font-size:16px;  background-color: white !important;" placeholder="Email" value="<?php echo $child[3]; ?>"></td>
		<td width="15%"><input type="text" class="span12 m-wrap textbox" name="mobile" id="mobile1" style="font-size:16px;  background-color: white !important;" placeholder="Mobile" value="<?php echo $child[4]; ?>"></td>
		
		<td width="10%">
		<div class="controls">
		<label class="radio"><input type="radio" class="owner" name="owner<?php echo $i; ?>" <?php if(1==$child[5]){ echo 'checked';} ?> value="1" inc_id="<?php echo $i; ?>">Yes</label>
		<label class="radio"><input type="radio" class="owner" name="owner<?php echo $i; ?>" <?php if(2==$child[5]){ echo 'checked';} ?> value="2" inc_id="<?php echo $i; ?>">No</label>
		</div>
		</td>
		
		<td width="10%">
		<div class="controls" id="committe<?php echo $i; ?>">
		<label class="radio"><input type="radio" name="committe<?php echo $i; ?>" <?php if(1==$child[6]){ echo 'checked';} ?> value="1">Yes</label>
		<label class="radio"><input type="radio" name="committe<?php echo $i; ?>" <?php if(2==$child[6]){ echo 'checked';} ?> value="2">No</label>
		</div>
		<div id="no1" style="display:none;">No</div>
		</td>
		
		
		<td width="10%">
		<!--<div class="controls">
		<label class="radio"><input type="radio" name="residing<?php echo $i; ?>" <?php if(1==$child[7]){ echo 'checked';} ?> value="1">Self Occupied</label>
		<label class="radio"><input type="radio" name="residing<?php echo $i; ?>" <?php if(2==$child[7]){ echo 'checked';} ?> value="2">Leased</label>-->
		</div>
		
		<?php if($i>0) { ?> <div class="pull-right"><a href="#" role="button" class="btn mini black delete" id="<?php echo $i; ?>"><i class="icon-trash"></i> Delete</a></div> <?php } ?>
		</td>
	</tr>
	<?php
}
?>