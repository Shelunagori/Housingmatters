<div class="hide_at_print">	
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));

foreach($result_society as $data){
$income_heads=$data["society"]["income_head"];
$vallllll = (int)@$data["society"]["area_scale"];
}
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
</div>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<style>
#report_tb th{
	font-size: 10px !important;background-color:#C8EFCE;padding:2px;border:solid 1px #55965F;white-space: nowrap !important; 
}
#report_tb td{
	padding:2px;
	font-size: 12px;border:solid 1px #55965F;background-color:#FFF;white-space: nowrap !important; 
}
.text_bx{
	width: 50px;
	height: 15px !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
.text_rdoff{
	width: 50px;
	height: 15px !important;
	border: none !important;
	margin-bottom: 0px !important;
	font-size: 12px;
}
</style>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		

<div style="text-align:center;" class="hide_at_print">
<a href="<?php echo $webroot_path; ?>Incometrackers/in_head_report" class="btn yellow" rel='tab'>Regular Bill Report</a>
<!--<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_regular" class="btn" rel='tab'>Regular Report</a>-->
<a href="<?php echo $webroot_path; ?>Incometrackers/it_reports_supplimentry" class="btn" rel='tab'>Supplementary Bill Report</a>
<!--<a href="<?php //echo $webroot_path; ?>Incometrackers/income_heads_report" class="btn" rel='tab'>Income head report</a>-->
<a href="<?php echo $webroot_path; ?>Incometrackers/account_statement" class="btn" rel='tab'>Account Statement</a>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
if(sizeof($result_new_regular_bill)>0){
	$nnn = 555;
	
	foreach($result_new_regular_bill as $regular_bill){
		$auto_id=$regular_bill["new_regular_bill"]["auto_id"];
		$one_time_id=$regular_bill["new_regular_bill"]["one_time_id"];
		
		$array_for_select_box[$auto_id]=$one_time_id;
	}
	$array_for_select_box=array_unique($array_for_select_box);
}else{
	$nnn = 555555;

} 
?>
    
           <div class="hide_at_print" align="center">
           <table border="0">
           <tr>
		   <td>
			
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span>
			<input type="radio" name="optionsRadios1" value="1" style="opacity: 0;" checked="checked" onclick="first()"></span></div>
			All
			</label>
								 
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span>
			<input type="radio" name="optionsRadios1" value="2" style="opacity: 0;" onclick="second()"></span></div>
			Wing Wise
			</label>
								 
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span>
			<input type="radio" name="optionsRadios1" value="3" style="opacity: 0;" onclick="third()"></span></div>
			Member Wise
			</label>
		  
		   </td>
           <td id="one">
           <select class="m-wrap medium chosen" id="un">
           <?php
		   $count=0;
		   foreach($array_for_select_box as $key=>$value)
		   { $count++;
			   if($count==1){ $last_one_time_id=$value; };
		   foreach($result_new_regular_bill as $regular_bill){
				$auto_id=$regular_bill["new_regular_bill"]["auto_id"];
				
				if($auto_id==$key){
					$bill_start_date=$regular_bill["new_regular_bill"]["bill_start_date"];
					$bill_end_date=$regular_bill["new_regular_bill"]["bill_end_date"];
				}
			}
		   ?>
           <option value="<?php echo $value; ?>"><?php echo date("d-M",$bill_start_date); ?> to <?php echo date("d-M-Y",$bill_end_date); ?></option>
           <?php } ?>
           </select>
           </td>
		   <td class="hide" id="two">
		   <select class="m-wrap medium chosen" id="wwng">
           <option value="" style="display:none;">Select Wing</option>		  
		    <?php
			foreach($cursor2 as $collection)
			{
			$wing_id = (int)$collection['wing']['wing_id'];	
			$wing_name = $collection['wing']['wing_name'];	
			?>
			<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
			<?php } ?>
		    </select>
		   </td>
		   <td class="hide" id="three">
		<?php
		$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down')); ?>  
		
		   
		   </td>
		   
		   
           <td>
           <button class="btn yellow" id="go" style="">Go</button>
           </td>
           </tr>
           </table>
           <div id="validate_result"></div> 
           </div>

<?php 
$max_size=0;
foreach($result_new_regular_bill as $regular_bill){
	$one_time_id=$regular_bill["new_regular_bill"]["one_time_id"];
	if($one_time_id==$last_one_time_id){
		$income_head_array=$regular_bill["new_regular_bill"]["income_head_array"];
		  if($max_size<sizeof($income_head_array))
		  {
			  $income_head_array_size=$income_head_array;
			  $max_size=sizeof($income_head_array);
		  }
		 
		  
	}
}   
 ?>
<br />
<?php
if($nnn == 555555)
{
?>
<div align="center" style="width:100%; overflow:auto;" id="result">
		<br/><br/><h3>No bills raised.</h3>
	</div>
<?php
}
else
{
?>

<div style="width:100%; overflow:auto;" id="result" align="center">
<div align="right">
<a href="in_head_excel?one=<?php echo @$last_one_time_id; ?>" class="btn blue mini"><i class="icon-download"></i></a>
<a href="print_all_bill/<?php echo @$last_one_time_id; ?>" target="_blank" class="btn purple mini"><i class="icon-print"></i></a>
</div>
<div style="width:100%; overflow:auto; margin-top:10px;" class="hide_at_print">
<label class="m-wrap pull-right"><input type="text" id="search" class="m-wrap medium" style="background-color:#FFF !important;" placeholder="Search"></label>	
</div>	
<table id="report_tb">
	        <thead>
		    <tr>
			<th>Unit Number</th>
			<th>Name</th>
			<th>Area <?php if($vallllll == 0) { ?>(sq. feet)<?php } else {?> (sq. mtr) <?php } ?></th>
			<th>Bill No.</th>
			<?php 	
			foreach($income_head_array_size as $income_head=>$value){ 
			$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($income_head)));	
			foreach($result_income_head as $data2){
				$income_head_name = $data2['ledger_account']['ledger_name'];
			} ?>
			<th><?php echo $income_head_name; ?></th>	
			<?php }  ?>
			<th>Non Occupancy charges</th>
			
			<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach($other_charges_ids as $other_charges_id){
					$result_income_head = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account_fetch2'),array('pass'=>array($other_charges_id)));	
						foreach($result_income_head as $data2){
							$income_head_name = $data2['ledger_account']['ledger_name'];
						}
					?>
					<th><?php echo $income_head_name; ?></th>
					<?php
				} 
			}?>
			<th>Total</th>
			<th>Arrears-Principal</th>
			<th>Arrears-Interest</th>
			<th>Interest on Arrears</th>
			<th>Credit/Adjustment</th>
			<th>Due For Payment</th>
			<th>View|Edit</th>
		</tr>
	</thead>
	<tbody id="table">
<?php
$total_noc_charges=0; $total_total=0; $total_arrear_maintenance=0; $total_arrear_intrest=0; $total_intrest_on_arrears=0; $total_credit_stock=0; $total_due_for_payment=0;
	
foreach($result_new_regular_bill as $regular_bill){
	$creater_name = "";
	$approve_by = "";
	$one_time_id=$regular_bill["new_regular_bill"]["one_time_id"];
	if($one_time_id==$last_one_time_id){
		$auto_id=$regular_bill["new_regular_bill"]["auto_id"];
		$bill_start_date=$regular_bill["new_regular_bill"]["bill_start_date"];
		$bill_end_date=$regular_bill["new_regular_bill"]["bill_end_date"];
		$flat_id=$regular_bill["new_regular_bill"]["flat_id"];
		$bill_no=$regular_bill["new_regular_bill"]["bill_no"];
		$income_head_array=$regular_bill["new_regular_bill"]["income_head_array"];
		$noc_charges=$regular_bill["new_regular_bill"]["noc_charges"];
		$other_charges_array=$regular_bill["new_regular_bill"]["other_charges_array"];
		$total=$regular_bill["new_regular_bill"]["total"];
		$arrear_maintenance=$regular_bill["new_regular_bill"]["arrear_maintenance"];
		$arrear_intrest=$regular_bill["new_regular_bill"]["arrear_intrest"];
		$intrest_on_arrears=$regular_bill["new_regular_bill"]["intrest_on_arrears"];
		$credit_stock=$regular_bill["new_regular_bill"]["credit_stock"];
		$due_for_payment=$regular_bill["new_regular_bill"]["due_for_payment"];
		$prepaired_by = (int)$regular_bill["new_regular_bill"]["created_by"]; 
		$current_date = $regular_bill["new_regular_bill"]["current_date"];
        $approved_by_id = (int)$regular_bill["new_regular_bill"]["approved_by"]; 
        $approved_date = $regular_bill["new_regular_bill"]["approved_date"]; 
		
		
		$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($approved_by_id)));
		foreach ($user_dataaaa as $user_detailll) 
		{
		$approved_by = @$user_detailll['user']['user_name'];
		}	
		
		
			$current_datttt = date('d-m-Y',($current_date));
		
		$user_dataaaa = $this->requestAction(array('controller' => 'hms', 'action' => 'user_fetch'),array('pass'=>array($prepaired_by)));
		foreach ($user_dataaaa as $user_detailll) 
		{
		$creater_name = @$user_detailll['user']['user_name'];
		}	
		
		//wing_id via flat_id//
		$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
		foreach($result_flat_info as $flat_info){
			$wing_id=$flat_info["flat"]["wing_id"];
		}
					
		
		$wing_flat=$this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'), array('pass' => array($wing_id,$flat_id)));
		
		$wingg_flat = explode('-',$wing_flat);
		
		$wing_name = $wingg_flat[0];
		$flat_name = $wingg_flat[1];
		
		//user info via flat_id//
		$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
		foreach($result_user_info as $user_info){
			$user_name=$user_info["user"]["user_name"];
		}
		
		$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_fetch2'),array('pass'=>array(@$flat_id,$wing_id))); 
		foreach($result_flat as $data2){
			$flat_type_id = (int)$data2['flat']['flat_type_id'];
			$noc_ch_id = (int)@$data2['flat']['noc_ch_tp'];
			$sq_feet = $data2['flat']['flat_area'];
		}
		
					
 		?>
		<tr>
			<td><?php echo $wing_flat; ?></td>
			<td><?php echo $user_name; ?></td>
			<td><?php echo $sq_feet; ?></td>
			<td><?php echo $bill_no; ?></td>
			<?php 
			
			foreach($income_head_array_size as $income_head=>$value){ 
			//foreach($income_head_array as $income_head=>$value)
			{
				$total_income_heads[$income_head][]=@$income_head_array[$income_head];
			 ?>
			<td><?php echo @$income_head_array[$income_head]; ?></td>	
			<?php } } ?>
			<td><?php echo $noc_charges; $total_noc_charges+=$noc_charges; ?></td>
			<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach(@$other_charges_ids as $other_charges_id){
					$total_other_charges[$other_charges_id][]=@(int)$other_charges_array[$other_charges_id];
					?>
					<td><?php echo @(int)$other_charges_array[$other_charges_id]; ?></td>
					<?php
				} 
			} ?>
			<td><?php echo $total; $total_total+=$total; ?></td>
			<td><?php echo $arrear_maintenance; $total_arrear_maintenance+=$arrear_maintenance; ?></td>
			<td><?php echo $arrear_intrest; $total_arrear_intrest+=$arrear_intrest; ?></td>
			<td><?php echo $intrest_on_arrears; $total_intrest_on_arrears+=$intrest_on_arrears; ?></td>
			<td><?php echo $credit_stock; $total_credit_stock+=$credit_stock; ?></td>
			<td><?php echo $due_for_payment; $total_due_for_payment+=$due_for_payment; ?></td>
			<td>
			
			
  
  
		<div class="btn-group">
		<a class="btn blue mini" href="#" data-toggle="dropdown">
		<i class="icon-chevron-down"></i>	
		</a><ul class="dropdown-menu" style="min-width:80px !important;">
		<li><a href="regular_bill_view/<?php echo $auto_id; ?>" target="_blank"><i class="icon-search"></i> View</a></li>
		<li>
		<a href="regular_bill_edit2/<?php echo $auto_id; ?>" role="button" rel='tab'><i class="icon-edit"></i> Edit</a></li>
		</ul>
		</div>
  
  
		<?php if(!empty($creater_name))
		{ ?>
		<i class="icon-info-sign tooltips" data-placement="left" data-original-title="Created by: 
		<?php echo $creater_name; ?> on: <?php echo $current_datttt; ?>"></i>
		<?php } ?>
  
  
  
            </td>
		</tr>
			
		<?php
		}}
		
?>
	</tbody>
		<tr>
			<td colspan="4" align="right"><b>Total<b/></td>
			<?php foreach($income_head_array_size as $income_head=>$value){ $total_income_heads_am=0;
				foreach($total_income_heads[$income_head] as $data5){
					$total_income_heads_am+=$data5;
				}
			 ?>
			<td><b><?php echo $total_income_heads_am; ?></b></td>	
			<?php }   ?>
			<td><b><?php echo $total_noc_charges; ?></b></td>
			
			<?php 
			if(sizeof(@$other_charges_ids)>0){
				foreach($other_charges_ids as $other_charges_id){ $total_other_charges_am=0;
					foreach($total_other_charges[$other_charges_id] as $data6){
						$total_other_charges_am+=$data6;
					}
					?>
					<td><b><?php echo $total_other_charges_am; ?></b></td>
					<?php
				} 
			}?>
			<td><b><?php echo $total_total; ?></b></td>
			<td><b><?php echo $total_arrear_maintenance; ?></b></td>
			<td><b><?php echo $total_arrear_intrest; ?></b></td>
			<td><b><?php echo $total_intrest_on_arrears; ?></b></td>
			<td><b><?php echo $total_credit_stock; ?></b></td>
			<td><b><?php echo $total_due_for_payment; ?></b></td>
			<td></td>
		</tr>
</table>


</div>
<?php } ?>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
$(document).ready(function() {
	$("#go").bind('click',function(){
	
	var type = $('input[type=radio]:checked').val();
	
	if(type == 1)
	{
	var unic = document.getElementById('un').value;
	
	$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loding....</div>').load("in_report_ajax?un=" +unic+ "");
	}
	if(type == 2)
	{
	var wing = $("#wwng").val();	
	$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("regular_report_show_ajax?wise=" +1+ "&wing=" +wing+ "");	
		
	
	}
	if(type == 3)
	{
	var mem = $(".resident_drop_down").val();		
	$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("regular_report_show_ajax?wise=" +2+ "&user=" +mem+ "");	
	}
	
	});
});
</script>	
<?php 
$bill_updated=(int)$this->Session->read('bill_updated');
if($bill_updated==1){ ?>
<script>
$(document).ready(function() {
	$.gritter.add({
		title: '<i class="icon-plus-sign"></i> Income Tracker',
		text: '<p>Bill Updated Successfully</p>',
		sticky: false,
		time: '10000',
	});
});
</script>
<?php }
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array(1111)));
?>

<script>
<?php
$bill_update_status=(int)$this->Session->read('bill_update_status');
if($bill_update_status==1)
{
?>
 $.gritter.add({
	   title: '<i class="icon-phone-sign"></i> Regular Bill Update',
	   text: '<p>Bill Updated Successfully</p>',
	   sticky: false,
		time: '10000',
	});
<?php
$this->requestAction(array('controller' => 'hms', 'action' => 'griter_notification'), array('pass' => array("bill_update")));
}
?>
</script>
<script>
		 var $rows = $('#table tr');
		 $('#search').keyup(function() {
			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
			
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
		});
 </script>
 
<script>
function first()
{
$("#one").show();	
$("#two").hide();
$("#three").hide();
}	
function second()
{
	$("#one").hide();
$("#two").show();
$("#three").hide();	
}	
function third()	
{
$("#one").hide();
$("#two").hide();
$("#three").show();	
}

</script>

 
 