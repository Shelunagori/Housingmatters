<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>

<script>
/*
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
*/
</script>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?><table  align="center" border="1" bordercolor="#FFFFFF" cellpadding="0">
<tr>
<td><a href="<?php echo $webroot_path; ?>Incometrackers/select_income_heads" class="btn" rel='tab'>Selection of Income Heads</a>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn yellow" style="font-size:16px;" rel='tab'>Rate Card</a>
</td>
<td>
<a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn" style="font-size:16px;" rel='tab'>Non Occupancy Charges</a>
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
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<div id="validate_result"></div>
<div class="alert alert-error hide" id="mgg">
<button class="close" data-dismiss="alert"></button>
<center>
<strong>Record Updated Successfully</strong>
</center>
</div>


<form method="post" onsubmit="">
<center>
<br /><Br />
<div id="error_msg" style="background-color:white; width:100%;"></div>
<div style="overflow-x:scroll;">
<table class="table table-bordered" style="width:100%; background-color:white;">
<tr>
<th style="text-align:center;">Flat Type</th>
<?php
foreach($cursor3 as $collection)
{
$income_head_arr = @$collection['society']['income_head'];	
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
$validattt_value = 5;
$flat_areaaa="";	
$chr1 = "";	
$nn++;
$flat_type_id = (int)$collection['flat_type']['flat_type_id'];	
$auto_id1 = (int)$collection['flat_type']['auto_id'];
$chr1 = @$collection['flat_type']['charge'];


$flat_detailll = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_flat_detail_via_flat_type_id'),array('pass'=>array($flat_type_id)));	
foreach($flat_detailll as $flat_dataattt)
{
$flat_areaaa = $flat_dataattt['flat']['flat_area'];	
if(empty($flat_areaaa))
{
$validattt_value=555;
break;	
}
}



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

<select name="charge_type<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="tp<?php echo $nn; ?><?php echo $mm; ?>" onchange="validattt_flarreaa(this.value,<?php echo $validattt_value; ?>,<?php echo $nn; ?>,<?php echo $mm; ?>)">
<option value="" style="display:none;">Select</option>
<option value="1" <?php if($type_id == 1) { ?> selected="selected" <?php } ?>>Lump Sum</option>
<option value="2" <?php if($type_id == 2) { ?> selected="selected" <?php } ?>><?php if($area_typppp == 0) { ?>Per Square Feet<?php } else { ?>Per Square Meter<?php } ?></option>
<option value="3" <?php if($type_id == 3) { ?> selected="selected" <?php } ?>>Flat Type</option>
</select>
<input type="text" name="charge<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="rs<?php echo $nn; ?><?php echo $mm; ?>" value="<?php echo $amount; ?>" style="text-align:right;" maxlength="10" onkeyup="amt_validattt(this.value,<?php echo $nn; ?>,<?php echo $mm; ?>)"/>
<input type="hidden" value="<?php echo $auto_id1; ?>" id="flat_type_auto_id<?php echo $nn; ?><?php echo $mm; ?>" />
<input type="hidden" value="<?php echo $auto_id2; ?>" id="income_head_id<?php echo $nn; ?><?php echo $mm; ?>" />
<?php }}}
else
{
$b = 50;
?>
<select name="charge_type<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="tp<?php echo $nn; ?><?php echo $mm; ?>" onchange="validattt_flarreaa(this.value,<?php echo $validattt_value; ?>,<?php echo $nn; ?>,<?php echo $mm; ?>)">
<option value="" style="display:none;">Select</option>
<option value="1">Lump Sum</option>
<option value="2"><?php if($area_typppp == 0) { ?>Per Square Feet<?php } else { ?>Per Square Meter<?php } ?></option>
<option value="3">Flat Type</option>
</select>
<input type="text" name="charge<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="rs<?php echo $nn; ?><?php echo $mm; ?>" style="text-align:right;" maxlength="10" onkeyup="amt_validattt(this.value,<?php echo $nn; ?>,<?php echo $mm; ?>)"/>
<input type="hidden" value="<?php echo $auto_id1; ?>" id="flat_type_auto_id<?php echo $nn; ?><?php echo $mm; ?>" />
<input type="hidden" value="<?php echo $auto_id2; ?>" id="income_head_id<?php echo $nn; ?><?php echo $mm; ?>" />
<?php } 
if($b == 5)
{
?>
<select name="charge_type<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="tp<?php echo $nn; ?><?php echo $mm; ?>" onchange="validattt_flarreaa(this.value,<?php echo $validattt_value; ?>,<?php echo $nn; ?>,<?php echo $mm; ?>)">
<option value="" style="display:none;">Select</option>
<option value="1">Lump Sum</option>
<option value="2"><?php if($area_typppp == 0) { ?>Per Square Feet<?php } else { ?>Per Square Meter<?php } ?></option>
<option value="3">Flat Type</option>
</select>
<input type="text" name="charge<?php echo $auto_id1; ?><?php echo $auto_id2; ?>" class="m-wrap small" id="rs<?php echo $nn; ?><?php echo $mm; ?>" style="text-align:right;" maxlength="10" onkeyup="amt_validattt(this.value,<?php echo $nn; ?>,<?php echo $mm; ?>)"/>
<input type="hidden" value="<?php echo $auto_id1; ?>" id="flat_type_auto_id<?php echo $nn; ?><?php echo $mm; ?>" />
<input type="hidden" value="<?php echo $auto_id2; ?>" id="income_head_id<?php echo $nn; ?><?php echo $mm; ?>" />
<?php	
}
?>
</td>
<?php } ?>
</tr>
<?php } ?>

</table>
<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Rate Card</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<h5><b class="success_report"></b></h5>
</center>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Incometrackers/master_rate_card" class="btn blue" rel='tab'>No</a>
<button type="submit" class="btn blue form_post" submit_type="con" onclick="mssg()">Yes</button>
</div>
</div>
</div> 

<?php
//$imih = implode(",",$ih);

?>
<input type="hidden" value="<?php echo $nn; ?>" id="typ" />
<input type="hidden" value="<?php echo $mm; ?>" id="rss" />
<button type="submit" name="suxgxbb" class="btn green form_post" submit_type="sub">Update</button>
</div>
</center>
</form>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
function amt_validattt(vvv,nnn,mmm)
{

if($.isNumeric(vvv))
{
$("#error_msg").html('');	
}
else
{
$("#error_msg").html('<div class="alert alert-error">Please Fill Numeric amount</div>');
$("#rs"+ nnn + mmm).val("");
return false;		
}
}
</script>
<script>
$(document).ready(function() {
	$(".form_post").bind('click', function(e){
		$(".form_post").removeClass("clicked");
		$(this).addClass("clicked");
	});
 
	$('form').submit( function(ev){
	ev.preventDefault();
	if( $(this).find(".clicked").attr("submit_type") === "sub" ){
			var post_type=1;
		}
		if( $(this).find(".clicked").attr("submit_type") === "con" ){
			var post_type=2;
		}
		var nn = document.getElementById("typ").value;
		var mm = document.getElementById("rss").value;
		
		var ar = [];
		for(var p=1; p<=nn; p++)
		{
		for(var q=1; q<=mm; q++)
		{
		var type = $("#tp"+ p + q).val();	
        var amt = $("#rs"+ p + q).val(); 
			if(type=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All     Fields</div>'); return false; }	
			var rs1 = document.getElementById("rs"+ p + q).value;
			if(amt=== '') { $('#validate_result').html('<div style="background-color:white; color:red; padding:5px;">Please Fill All Fields</div>'); return false; }
			$('#validate_result').html('');
        var flat_type_id = $("#flat_type_auto_id"+ p + q).val();
        var income_head = $("#income_head_id"+ p + q).val();
		ar.push([type,amt,flat_type_id,income_head,mm]);
		
		var myJsonString = JSON.stringify(ar);
		}
		}
		var abc = JSON.stringify(post_type);
			
			$.ajax({
			url: "rate_card_json?q="+myJsonString+"&b="+abc,
			dataType:'json',
			}).done(function(response) {
			
				if(response.type == 'error'){  
					output = '<div class="alert alert-error">'+response.text+'</div>';
					$("#submit").removeClass("disabled").text("submit");
					$("html, body").animate({
					 scrollTop:0
					 },"slow");
				}
				if(response.type=='succ'){
				$("#shwd").show();
				
				$(".success_report").show().html(response.text);
				
			    }
				
				if(response.type=='okk'){
				$("#shwd").hide();
				}
				//$("#error_msg").html(output);
			});

	 
	});
});

</script>

		
<script>
function mssg()
{

$("#mgg").show();
setTimeout( function(){$('#mgg').hide();} , 3000);
}

function validattt_flarreaa(ttt,vvv,nnn,mmm)
{

if(ttt == 2 && vvv == 555)
{
$("#shwd22").show();
$("#tp" + nnn + mmm).val(1).attr("selected","selected");
}

}


</script>
<script>
function hhhddddd()
{
$("#shwd22").hide();
}
</script>

<div id="shwd22" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<p style="font-size:14px; font-weight:500;">Untill you do not fill area for all flats of 1 bhk category, can not select "per square feet" option.</p>
</div>
<div class="modal-footer">
<button type="" onclick="hhhddddd()" class="btn red">OK</button>
</div>
</div>
</div> 



