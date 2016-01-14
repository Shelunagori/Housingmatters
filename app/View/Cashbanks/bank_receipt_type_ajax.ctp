<?php if($type == 1) { ?>

<select class="m-wrap chosen span12" id="ttppp<?php echo $kkk; ?>" onchange="amtshw2(this.value,<?php echo $kkk; ?>)">
				<option value="" style="display:none;">Select Receipt Type</option>
				<option value="1">Maintanace Receipt</option>
				<option value="2">Other Receipt</option>
				</select>
				
<?php } else { ?>
	
<input type="text" class="m-wrap span12"  placeholder="Bill Reference" 
				id="bllreff<?php echo $kkk; ?>" style="background-color:#FFF !important; margin-top:3px;"/>	
	
	
	
<?php 	
}
?>