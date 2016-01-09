<script>
function validat()
{
var nn = document.getElementById("typ").value;
var mm = document.getElementById("rss").value;
for(var p=1; p<=nn; p++)
{
for(var q=1; q<=mm; q++)
{
var typ1 = document.getElementById("tp"+ p + q).value;	
if(typ1=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All     Fields</div>'); return false; }	
var rs1 = document.getElementById("rs"+ p + q).value;
if(rs1=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All Fields</div>'); return false; }	

}
}
}
</script>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
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
			<!--<td>
            <a href="it_due_tax" class="btn" style="font-size:16px;">Due tax</a>
            </td>-->
            <td>
            <a href="it_setup" class="btn " style="font-size:16px;">Terms & Condition</a>
            </td>
            <td>
            <a href="master_rate_card" class="btn yellow" style="font-size:16px;">Rate Card</a>
            </td>
			<td>
            <a href="master_noc" class="btn" style="font-size:16px;">Non Occupancy Charges</a>
            </td>
			<td>
            <a href="it_penalty" class="btn" style="font-size:16px;">Penalty Option</a>
            </td>
			</tr>
			</table> 
            
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br />
<center>
       <a href="master_rate_card" class="btn purple">Rate Card Add</a>     
       <a href="master_rate_card_view" class="btn yellow">Rate Card View / Update</a> 
       </center>    
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
   <!-- <form method="post">
    <div style="width:100%; background-color:white; overflow-x:scroll;">
    <table class="table table-bordered" style="background-color:white; width:100%;"> 
    <tr>
    <th style="text-align:center;">Flat Type</th>
    <?php
	foreach($cursor1 as $collection)
	{
	$charge = @$collection['flat_type']['charge'];
	}
	for($j=0; $j<sizeof($charge); $j++)
	{
	$charge2 = $charge[$j];
	$ih_id1 = (int)$charge2[0];
	
$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'income_head_fetch'),array('pass'=>array(        $ih_id1)));		
foreach($result1 as $collection)
{
$ih_name = $collection['income_head']['ih_name'];	
}
		
	
	?>
    <th style="text-align:center;"><?php echo $ih_name; ?></th>
	<?php
	}
    ?>
   <th style="text-align:center;">Edit</th>
   </tr>
   
    <?php
	foreach($cursor1 as $collection)
	{
	$flat_type = $collection['flat_type']['flat_name'];
	$charge3 = @$collection['flat_type']['charge'];
	$flat_type_id = $collection['flat_type']['auto_id'];	
	?>
    <tr id="result<?php echo $flat_type_id; ?>">
    <th style="text-align:center;"><?php echo $flat_type ?></th>
	<?php
    for($k=0; $k<sizeof($charge3); $k++)
	{
    $charge4 = $charge3[$k];
	$chtp = (int)$charge4[1];
	$amt = $charge4[2];
	if($chtp == 1)
	{
	$type="Lump Sum";	
	}
	else if($chtp == 2)
	{
	$type="Per Square Feet";	
	}
	else
	{
	$type="Flat Type";	
	}
    ?>
    <td style="text-align:center;">
    Charge Type: <?php echo $type; ?><br />
    Charge Amount: <?php echo $amt; ?>
    </td>
    <?php } ?>
    <td style="text-align:center;">
    
    <a class="btn mini purple" onclick="edit(<?php echo $flat_type_id; ?>)">Edit</a> 
    </td>
    </tr>
	<?php
	}
	?>
   
    
    </table>
   </div>
   </form> -->
     
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>

<form method="post" onSubmit="return validat()">
<center>
<br /><Br />
<div id="validate_result" style="background-color:white; width:100%;"></div>
<div style="overflow-x:scroll;">
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th style="text-align:center;">Flat Type</th>
<?php
foreach($cursor3 as $collection)
{
$income_head_arr = $collection['society']['income_head'];	
}
for($i=0; $i<sizeof($income_head_arr); $i++)
{
$income_head_arr_id = (int)$income_head_arr[$i];

$result1 = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head_arr_id)));	
foreach($result1 as $collection)
{
$ih_name = $collection['ledger_account']['ledger_name'];
}
?>
<th style="text-align:center;"><?php echo $ih_name; ?></th>
<?php } ?>
</tr>
<?php
$nn=0;
foreach($cursor1 as $collection)
{
$chr1 = "";	
$nn++;
$flat_type_id = (int)$collection['flat_type']['flat_type_id'];	
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$chr1 = @$collection['flat_type']['charge'];


$result = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($flat_type_id)));	
foreach($result as $collection)
{
$flat_name = $collection['flat_type_name']['flat_name'];	
}
?>
<tr>
<th style="text-align:center;"><?php echo $flat_name; ?></th>
<?php
$mm=0;
for($p=0; $p<sizeof($income_head_arr); $p++)
{
$b = 5;
$mm++;
$auto_id2 = $income_head_arr[$p];
?>
<td>
<?php
if(!empty($chr1))
{
for($j=0; $j<sizeof($chr1); $j++)
{
$chr2 = $chr1[$j];	
$ih_id = $chr2[0];
if($ih_id == $auto_id2)
{
$type_id = $chr2[1];
$amount = $chr2[2];	
$b = 55;
?>
<select name="charge_type<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="tp<?php echo $nn; ?><?php echo $mm; ?>">
<option value="">Select</option>
<option value="1" <?php if($type_id == 1) { ?> selected="selected" <?php } ?>>Lump Sum</option>
<option value="2" <?php if($type_id == 2) { ?> selected="selected" <?php } ?>>Per Square Feet</option>
<option value="3" <?php if($type_id == 3) { ?> selected="selected" <?php } ?>>Flat Type</option>
</select>
<input type="text" name="charge<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="rs<?php echo $nn; ?><?php echo $mm; ?>" value="<?php echo $amount; ?>"/>

<?php }}}
else
{
	$b = 50;
?>
<select name="charge_type<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="tp<?php echo $nn; ?><?php echo $mm; ?>">
<option value="">Select</option>
<option value="1">Lump Sum</option>
<option value="2">Per Square Feet</option>
<option value="3">Flat Type</option>
</select>
<input type="text" name="charge<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="rs<?php echo $nn; ?><?php echo $mm; ?>"/>

<?php } 
if($b == 5)
{
?>
<select name="charge_type<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="tp<?php echo $nn; ?><?php echo $mm; ?>">
<option value="">Select</option>
<option value="1">Lump Sum</option>
<option value="2">Per Square Feet</option>
<option value="3">Flat Type</option>
</select>
<input type="text" name="charge<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="rs<?php echo $nn; ?><?php echo $mm; ?>"/>
<?php	
}
?>




</td>
<?php } ?>
</tr>
<?php } ?>

</table>
<?php
//$imih = implode(",",$ih);

?>
<input type="hidden" value="<?php echo $nn; ?>" id="typ" />
<input type="hidden" value="<?php echo $mm; ?>" id="rss" />
<!-- <input type="hidden" name="inhd" value="<?php //echo $imih; ?>" /> -->
<button type="submit" name="sub" class="btn green">Submit</button>
</div>
</center>
</form>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function(){

$.validator.setDefaults({ ignore: ":hidden:not(select)" });


		$('#contact-form').validate({
		
		errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    },
		
		
		
	    rules: {
	     
		 "i_head[]": {
			 required: true
	      },

		},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); 
</script>	
	



<script>
function edit(auto_id)
{
	
$("#result" + auto_id).load("master_rate_card_edit?ss=" + auto_id + "");	
}
		</script>		














