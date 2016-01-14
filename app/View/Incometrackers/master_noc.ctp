<?php
foreach($cursor3 as $dataaa)
{
@$income_head_array = @$dataaa['society']['income_head'];	
}
?>



	<?php
	echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
	?>				   
	<script>
	$(document).ready(function() {
	$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
	$("#fix<?php echo $id_current_page; ?>").addClass("red");
	});
	</script>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>            
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
    <a href="master_noc" class='btn red' role="button" rel='tab'>Non Occupancy Charges</a>
    <a href="master_noc_status" class='btn blue' role="button"  rel='tab'>Non Occupancy Status</a>
    </div>

        <div class="alert alert-error hide" id="mgg">
        <button class="close" data-dismiss="alert"></button>
        <center>
        <strong>Record Updated Successfully</strong>
        </center>
        </div>        
<!---------------------------------- Start Non Occupancy Charges Form ------------------------->
<form method="post">
			
			<div class="portlet box blue">
			<div class="portlet-title">
			<h4 class="block">Non Occupancy Charges</h4>
			</div>
			<div class="portlet-body form">
			<div id="error_msg" style="width:80%;"></div>
        
		<table class="table table-bordered" style="width:100%; background-color:white;">
        <tr style="background-color:#E8EAE8;">
        <th style="text-align:center;" rowspan="2">Flat Type</th>
        <th style="text-align:center;" colspan="4">Non Occupancy charges(Leased Only)</th>
		</tr>
		<tr style="background-color:#F4F7F5;">
		<th style="width:20%;">Type of Charge</th>
		<th style="width:10%;">Amount Applied</th>
		<th style="width:30%;">Income Head</th>
		<th style="width:30%;"></th>
		</tr>
			<?php
				$n = 0;
				foreach($cursor1 as $collection)
				{
				$validattt_value = 5;	
				$flat_areaaa = "";	
				$noc_ch = "";	
				$n++;
				$noc_ch = @$collection['flat_type']['noc_charge'];
				$flat_type_id = (int)$collection['flat_type']['flat_type_id'];
				$auto_id = 	(int)$collection['flat_type']['auto_id'];
                $charge = @$collection['flat_type']['charge'];
				
				
				$type_noc = (int)$noc_ch[0];
				
				if($type_noc == 4)
				{					
				$noc_income_array = $noc_ch[2];	
				$total_income_amt = 0;

				foreach($noc_income_array as $in_iddd)
				{
					$income_id2 = (int)$in_iddd;
				foreach($charge as $data4){
					
				if($data4[1]==1){
					$ih_charges=$data4[2];
				if($income_id2 == $data4[0])
				{
				$total_income_amt+=$ih_charges;	
				}
				
				}
				if($data4[1]==2){
				   // $ih_charges=$sq_feet*$data4[2];
				}
				if($data4[1]==3){
					$ih_charges=$data4[2];
					
				if($income_id2 == $data4[0])
				{
				$total_income_amt+=$ih_charges;	
				}
				}
				
				}
				}
				}
				
				
				
				
				
				
				
				
				
				
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
    <tr style="background-color:#E8F3FF;">
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
           $ih_id = $noc_ch[2];		   
            }
            ?>
    <select name="ctp<?php echo $auto_id; ?>" class="m-wrap medium go" id="tp<?php echo $n; ?>" onchange="area_validdd(this.value,<?php echo $validattt_value; ?>,<?php echo $n; ?>)">
    <option value="" style="display:none;">Select</option>
    <option value="1" <?php if($type == 1) { ?> selected="selected" <?php } ?>>Lump Sum</option>
    <option value="2" <?php if($type == 2) { ?> selected="selected" <?php } ?> ><?php if($area_typppp == 0) { ?>Per Square Feet<?php } else { ?>Per Square Meter<?php } ?></option>
    <option value="3" <?php if($type == 3) { ?> selected="selected" <?php } ?>>Flat Type</option>
    <option value="4" <?php if($type == 4) { ?> selected="selected" <?php } ?>>10% of Maintanance Charge</option>
    <option value="5" <?php if($type == 5) { ?> selected="selected" <?php } ?>>Not Applicable</option>
    </select>
    </td>
    <td style="border-left-color:#FFF;">
    <div id="show<?php echo $n; ?>" <?php if($type == 5) { ?> class="hide" <?php } ?>>
    <input type="text" name="amt<?php echo $auto_id; ?>" class="m-wrap small" id="tx<?php echo $n; ?>" value="<?php echo $amt; ?>" style="text-align:right; background-color:white !important;" maxlength="10" onkeyup="amt_validattt(this.value,<?php echo $n; ?>)" <?php if($type == 4) { ?> disabled="disabled" <?php } ?>/>
    <input type="hidden" value="<?php echo $auto_id; ?>" id="fltp<?php echo $n; ?>" />
    </div>
    </td>
    <td>
	<span id="heads<?php echo $n; ?>" <?php if($type != 4) { ?> class="hide" <?php } ?>>
	
<select data-placeholder="Select Account Heads" id="i_head<?php echo $n; ?>" class="m-wrap large chosen" multiple="multiple" tabindex="6">	
<option value="" style="display:none;">Select</option>
<?php
foreach($income_head_array as $income_head)
{
$ledgerac = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));			
foreach($ledgerac as $collection2)
{
$ac_name = $collection2['ledger_account']['ledger_name'];
$income_id = (int)$collection2['ledger_account']['auto_id'];		
}
?>	
<option value="<?php echo $income_id; ?>" <?php foreach($ih_id as $dddd) { $inhead_idd = (int)$dddd; 
if($inhead_idd == $income_id) { ?> selected="selected" <?php } } ?>><?php echo $ac_name; ?></option>
<?php } ?>
</select>

	
	</span>
	</td>    
    <td>
	<span id="cal_amt<?php echo $n; ?>" <?php if($type != 4) { ?> class="hide" <?php } ?>>
	<!--<input type="text" class="m-wrap small" readonly="readonly" style="background-color:white !important;" value="<?php $income_amt = round((10/100)*$total_income_amt); echo $income_amt; ?>">-->
	</span>
	</td>
    </tr>
	<?php
    }
    ?>
	<input type="hidden" value="<?php echo $n; ?>" id="count" />
	</table>
             
        <input type="hidden" value="<?php echo $n; ?>" id="cnt" />

        <div id="shwd" class="hide">
		<div class="modal-backdrop fade in"></div>
		<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-body">
		<h4><b>Are You Sure</b></h4>
		</div>
		<div class="modal-footer">
		<a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn" rel='tab'>NO</a>
        <button type="submit" class="btn red form_post" submit_type="con" onclick="mssg()">YES</button>
        </div>
		</div>
        </div> 
 

<div class="form-actions">
  <button type="submit" class="btn green form_post" name="sub" submit_type="sub">Update</button>
</div>  

</div>
</div>

  </form>
            

<!------------------------------- End Non Occupancy Charges Form ------------------------------->

<script>
function amt_validattt(vvv,nnn)
{

if($.isNumeric(vvv))
{
$("#error_msg").html('');	
}
else
{
$("#error_msg").html('<div class="alert alert-error">Please Fill Numeric amount</div>');
$("#tx"+ nnn).val("");
return false;		
}
}
</script>


<script>
	$(document).ready(function() {
		
	$(".go").live('change',function(){

		var count = document.getElementById("cnt").value;		
		for(var i=1; i<=count; i++)
		{
			var tp = document.getElementById("tp" + i).value;
			if(tp == 5)
			{
			$("#tx" + i).hide();
			}
			else
			{
			$("#show" + i).show();
			$("#tx" + i).show();	
			}
			if(tp == 4)
			{
			$("#tx" + i).val(" ");
			$("#tx" + i).attr('disabled','disabled');
			$("#heads" + i).show();
			$("#cal_amt" + i).show();
			}
			else
			{
			$("#heads" + i).hide();
			$("#cal_amt" + i).hide();
			$("#tx" + i).removeAttr('disabled');	
			}
		}
	});
});
</script>	

<?php //////////////////////////////////////////////////////////////////////////////////////////// ?>

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
		var hidden=$("#cnt").val();
		var ar = [];
		for(var i=1;i<=hidden;i++)
		{
		var fltp = $("#fltp"+i).val();
		var type = $("#tp"+i).val();
		if(type != 4)
		{
		var amt = $("#tx"+i).val();
		}
		if(type != 4)
		{
		ar.push([type,amt,fltp]);
		}
		else
		{
		var amt = $("#tx"+i).val();
		var in_head = $("#i_head"+i).val();
		ar.push([type,amt,fltp,in_head]);	
		}
		var myJsonString = JSON.stringify(ar);
		}
		
		var abc = JSON.stringify(post_type);
			
			$.ajax({
			url: "noc_json?q="+myJsonString+"&b="+abc,
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
				
				$("#error_msg").html(output);
			});

	 
	});
});

</script>

<script>
function mssg()
{
$("#shwddd").show();
}
</script>

<script>

function area_validdd(ttt,vvv,nnn)
{
if(ttt == 2 && vvv == 555)
{
$("#shwd222").show();
$("#tp" + nnn).val(1).attr("selected","selected");

//$("#tx" + nnn).val("");
//document.getElementById("tx" + nnn).value = "0";
}
}

function hhhddd()
{
$("#shwd222").hide();
}

</script>



<div id="shwddd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<p>Record Updated Successfully</p>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Incometrackers/master_noc" class="btn red" rel='tab'>OK</a>

</div>
</div>
</div> 


























          
            