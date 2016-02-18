
<tr class="table table-bordered table-hover" id="tr<?php echo $t; ?>">
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">
<select class="large m-wrap chosen">
						<option value="" style="display:none;">Select Ledger A/c</option>
						<?php
							 foreach ($cursor1 as $collection) 
							 {
							   $auto_id = (int)$collection['ledger_account']['auto_id'];
							   $name = $collection['ledger_account']['ledger_name'];
						if($auto_id != 34 && $auto_id != 33 && $auto_id != 35 && $auto_id != 15 && $auto_id != 112)
						{
						?>
						<option value="<?php echo $auto_id; ?>,2"><?php echo $name; ?></option>
							 <?php }}
                             foreach ($cursor2 as $collection) 
							 {
							$account_number = "";
							$wing_flat = "";
							 $auto_id2 = (int)$collection['ledger_sub_account']['auto_id'];
							 $name2 = $collection['ledger_sub_account']['name']; 
                             $ledger_id = (int)$collection['ledger_sub_account']['ledger_id'];
						
						if($ledger_id == 34)
						{							
$flat_id = @$collection['ledger_sub_account']['flat_id'];
$wing_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
foreach($wing_detailll as $wing_dataaa)
{
$wing_idddd = (int)$wing_dataaa['flat']['wing_id'];	
}
$wing_flat= $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_new'),array('pass'=>array($wing_idddd,$flat_id)));
						}
						if($ledger_id == 33){
$account_number = $collection['ledger_sub_account']['bank_account'];  	
							
						}
							 ?>
                          
					<option value="<?php echo $auto_id2; ?>,1"><?php echo $name2; ?> &nbsp;&nbsp; <?php echo @$wing_flat; ?><?php echo @$account_number; ?></option>
						  
						  <?php } ?>
						</select>

</td>





<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">
<div class="control-group">
<div class="controls">

<input type="text" name="debit<?php echo $t; ?>"  class=" span12 m-wrap m-ctrl-medium" onblur="total_am(<?php echo $t; ?>)" style="background-color:#FFF !important;text-align:right;" placeholder="" maxlength="10" id="debit<?php echo $t; ?>" onkeyup="amtvalidat1(this.value,<?php echo $t; ?>)">

</div>
</div>
</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">
<div class="control-group">
<div class="controls">
<input type="text" class="span12 m-wrap" style="background-color:#FFF !important;text-align:right;" name="credit<?php echo $t; ?>" onblur="total_amc(<?php echo $t; ?>)"placeholder="" maxlength="10" id="credit<?php echo $t; ?>" onkeyup="amtvalidat2(this.value,<?php echo $t; ?>)">
</div>
</div>
</td>


<td width="2%"><a href="#" role="button" class="btn mini black delete_row" id="<?php echo $t; ?>"><i class="icon-remove"></i></a></td>
</tr>

































