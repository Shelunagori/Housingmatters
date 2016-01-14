
<tr class="table table-bordered table-hover" id="tr<?php echo $t; ?>">
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; ">

<select class=" m-wrap chosen" onchange="show_ledger_type(this.value,<?php echo $t; ?>)" name="l_type_id<?php echo $t; ?>" id="lac<?php echo $t; ?>" >
<option value="">--SELECT--</option>
<?php
foreach ($cursor1 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option> 
<?php } ?>
</select>

</td>


<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; " id="show_ledger_type<?php echo $t; ?>">

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

































