<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
            
            <table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
            <td style="width:25%">
            <a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
            </td>
            <td style="width:25%">
             <a href="it_supplimentry_bill" class="btn blue btn-block"  style="font-size:16px;">Supplementary Bill</a>
            </td>
            <td style="width:25%">
            <a href="in_head_report" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
            </td>
            <td style="width:25%">
            <a href="select_income_heads" class="btn red btn-block"  style="font-size:16px;">Accounting Setup</a>
            </td>
            </tr>
            </table>
            
            <table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
            <tr>
			<td><a href="select_income_heads" class="btn">Selection of Income Heads</a>
			</td>
			<td>
            <a href="it_setup" class="btn" style="font-size:16px;">Terms & Condition</a>
            </td>
            <td>
            <a href="master_rate_card" class="btn" style="font-size:16px;">Rate Card</a>
            </td>
            <td>
            <a href="master_noc" class="btn yellow" style="font-size:16px;">Non Occupancy Charges</a>
            </td>
            <td>
            <a href="it_penalty" class="btn" style="font-size:16px;">Penalty Option</a>
            </td>
			</tr>
			</table> 
<br />            
<center>         
<a href="master_noc" class="btn purple">Non Occupancy Charges Add</a>
<a href="master_noc_view" class="btn yellow">Non Occupancy Charges View / Update</a>
</center>
            <br />
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>  
<br /><br />
<center>
<form method="post" onsubmit="return vali()">
<div id="validate_result" style="width:80%;"></div>
<table class="table table-bordered" style="width:80%; background-color:white;">
<tr>
<th style="text-align:center;">Flat Type</th>
<th style="text-align:center;" colspan="3">Non Occupancy charges(Leased Only)</th>
</tr>

<?php
$n = 0;
foreach($cursor1 as $collection)
{
$noc_ch = "";	
$n++;
$noc_ch = @$collection['flat_type']['noc_charge'];
$flat_type_id = (int)$collection['flat_type']['flat_type_id'];
//$flat_name = $collection['flat_type']['flat_name'];	
$auto_id = 	(int)$collection['flat_type']['auto_id'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($flat_type_id)));	
foreach($result as $collection)
{
$flat_name = $collection['flat_type_name']['flat_name'];	
}
?>
<tr>
<th style="text-align:center;"><?php echo $flat_name; ?></th>
<td style="text-align:center;">
<?php
$type = $noc_ch[0];
if($type != 4)
{
$amt = $noc_ch[1];	
}
else
{
$amt = "";	
}
?>
<select name="ctp<?php echo $auto_id; ?>" class="m-wrap medium go" id="tp<?php echo $n; ?>">
<option value="" style="display:none;">Select</option>
<option value="1" <?php if($type == 1) { ?> selected="selected" <?php } ?>>Lump Sum</option>
<option value="2" <?php if($type == 2) { ?> selected="selected" <?php } ?>>Per Square Feet</option>
<option value="3" <?php if($type == 3) { ?> selected="selected" <?php } ?>>Flat Type</option>
<option value="4" <?php if($type == 4) { ?> selected="selected" <?php } ?>>10% of Maintanance Charge</option>
<option value="5" <?php if($type == 4) { ?> selected="selected" <?php } ?>>Not Applicable</option>
</select>

<input type="text" name="amt<?php echo $auto_id; ?>" <?php if($type == 4) { ?> disabled="disabled" <?php } ?>  class="m-wrap medium" id="tx<?php echo $n; ?>" value="<?php echo $amt; ?>"/>

</td>
</tr>
<?php
}
?>
<input type="hidden" value="<?php echo $n; ?>" id="count" />
</table>
<br />
<div style="width:100%">
<button type="submit" class="btn green" name="sub">Submit</button>
</div>
<input type="hidden" value="<?php echo $n; ?>" id="cnt" />
</form>
</center>


<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>


<script>
		$(document).ready(function() {
		$(".go").live('change',function(){

   var count = document.getElementById("cnt").value;		
   for(var i=1; i<=count; i++)
   {
	var tp = document.getElementById("tp" + i).value;
	
	   
	if(tp == 4)
	{
	$("#tx" + i).value = "none";
	$("#tx" + i).attr('disabled','disabled');
		
	}
	else
	{
	$("#tx" + i).removeAttr('disabled');	
	}
	
   }

});
});
		</script>	



<script>
function vali()
{
var count = document.getElementById("count").value;	
for(var i=1; i<=count; i++)
{
	
var tp = document.getElementById("tp" + i).value;
if(tp=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All Fields</div>'); return false; }	
if(tp == 4)
{

}
else
{
amt = document.getElementById("tx" + i).value;
if(amt=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All Fields</div>'); return false; }		
}

}

}
</script>































          
            