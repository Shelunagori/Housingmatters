
<script>
$('.date-picker').datepicker().on('changeDate', function(){
		$(this).blur();
		});
</script>


<table width="100%" id="tab<?php echo $t; ?>">
<tr class="table table-bordered table-hover">






<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20.2%;">
<div class="control-group">
<div class="controls">
<select class="span12 m-wrap chosen" onchange="show_ledger_type(this.value,<?php echo $t; ?>)" name="l_type_id<?php echo $t; ?>" id="lac<?php echo $t; ?>">
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
</div>
</div>
</td>


<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:19.8%;" id="show_ledger_type<?php echo $t; ?>">

</td>


<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">

<input type="text" name="debit<?php echo $t; ?>"  class=" span12 m-wrap m-ctrl-medium" onblur="total_am(<?php echo $t; ?>)" style="background-color:#FFF !important;" placeholder="Debits" id="debit<?php echo $t; ?>">

</div>
</div>
</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<input type="text" class="span12 m-wrap" style="background-color:#FFF !important;" name="credit<?php echo $t; ?>" onblur="total_amc(<?php echo $t; ?>)"placeholder="Credits" id="credit<?php echo $t; ?>">
</div>
</div>
</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<input type="text" name="remark<?php echo $t; ?>"  class=" span12 m-wrap m-ctrl-medium"  style="background-color:#FFF !important;" placeholder="Description" id="desc<?php echo $t; ?>">
</div>
</div>
</td>





</tr>
</table>

































