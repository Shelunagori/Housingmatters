<?php 
$default_date = date('d-m-Y'); 
?>
<tr class="content_<?php echo $count; ?>">
<td style="border:solid 1px blue;">

             <table class="table table-bordered" id="sub_table2">
              
			  <tr style="background-color:#E8EAE8;">
			  <th style="width:20%;">Transaction Date</th>
			  <th style="width:20%;">Ledger A/c</th>
			  <th style="width:20%;">Invoice Reference</th>
			  <th style="width:20%;">Amount</th>
			  <th style="width:20%;">TDS%</th>
			  </tr>


			  
			  <tr style="background-color:#E8F3FF;">
			  <td><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
			  value="<?php echo $default_date; ?>" 
			  style="background-color:white !important; margin-top:2.5px;" id="dattt<?php echo $count; ?>"></td>
			  
			  
					<td>
					<select class="m-wrap span12 chosen" id="ledger_account<?php echo $count; ?>">
					<option value="">--SELECT--</option>
					<?php
					foreach($cursor11 as $collection)
					{
					$auto_id = $collection['ledger_sub_account']['auto_id'];
					$name = $collection['ledger_sub_account']['name'];
					?>
					<option value="<?php echo $auto_id; ?>,1" ><?php echo $name; ?></option>
					<?php } ?>
					<?php
					foreach($cursor12 as $collection)
					{
					$auto_id_a = (int)$collection['accounts_group']['auto_id'];
					$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_a)));
					foreach($result33 as $collection)
					{
					$auto_id = (int)$collection['ledger_account']['auto_id'];
					$name = $collection['ledger_account']['ledger_name'];
					if($auto_id == 15)
					continue;
					?>
					<option value="<?php echo $auto_id; ?>,2" ><?php echo $name; ?></option>
					<?php }} ?>
					<?php
					foreach($cursor13 as $collection)
					{
					$auto_id_b = (int)$collection['accounts_group']['auto_id'];

					$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_b)));
					foreach($result33 as $collection)
					{
					$auto_id = (int)$collection['ledger_account']['auto_id'];
					$name = $collection['ledger_account']['ledger_name'];
					?>
					<option value="<?php echo $auto_id; ?>,2" ><?php echo $name; ?></option>
					<?php }} ?>
					</select>
					</td>

  
			  <td><input type="text" class="m-wrap span12" 
			  style="background-color:white !important; margin-top:2.5px;" id="inv_ref<?php echo $count; ?>">
			  </td>
			  
			  
			  <td><input type="text" class="m-wrap span12" id="amttt<?php echo $count; ?>" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" 
			  onkeyup="numeric_vali(this.value,<?php echo $count; ?>)" onchange="tdssssamt2(this.value,<?php echo $count; ?>)">
			  </td>
			  
			  
				<td><select class="m-wrap chosen span12" onchange="tdssssamt(this.value,<?php echo $count; ?>)" id="tdssss<?php echo $count; ?>">
				<option value="" style="display:none;">Select</option>
				<?php
				for($k=0; $k<sizeof($tds_arr); $k++)
				{
				$tds_sub_arr = $tds_arr[$k];	
				$tds_id = (int)$tds_sub_arr[1];
				$tds_tax = $tds_sub_arr[0];	
				?>
				<option value= "<?php echo $tds_id; ?>"><?php echo $tds_tax; ?></option>
				<?php } ?>                           
				</select>
				</td>
			  </tr>

              <tr style="background-color:#E8EAE8;">
			  <th>Net Amount</th>
			  <th>Mode of Payment</th>
			  <th>Instrument/UTR</th>
			  <th>Bank Account</th> 
			  <th>Narration</th>
			  </tr>
		
			  <tr style="background-color:#E8F3FF;">
				  
				  <td id="tds_show<?php echo $count; ?>"><input type="text"  class="m-wrap span12" 
				  readonly="readonly" style="background-color:white !important; margin-top:2.5px;" id="net_amtt<?php echo $count; ?>">
				  </td>
				  
				<td>
				<select class="m-wrap span12 chosen" id="moddd<?php echo $count; ?>">
				<option value="">Select</option>
				<option value="Cheque">Cheque</option>
				<option value="NEFT">NEFT</option>
				<option value="PG">PG</option>
				</select>
				</td>


			  <td><input type="text"  class="m-wrap span12" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" id="instru<?php echo $count; ?>">
              </td>
			  
			  
					<td>
					<select onchange="get_value(this.value)" class="m-wrap chosen span12" id="bankk<?php echo $count; ?>">
					<option value="" style="display:none;">Select</option>    
					<?php
					foreach ($cursor2 as $db) 
					{
					$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
					$sub_account_name =$db['ledger_sub_account']['name'];
					$ac_number = $db['ledger_sub_account']['bank_account']; 
					$bank_acccc = substr($ac_number,-4);  
					?>
					<option value="<?php echo $sub_account_id; ?>"><?php echo $sub_account_name; ?>&nbsp;&nbsp;<?php echo $bank_acccc; ?></option>
					<?php } ?>
					</select>
					</td>


				  <td><input type="text" class="m-wrap span12" 
				  style="background-color:white !important; margin-top:2.5px;" id="desc<?php echo $count; ?>">
				  </td>
			  
              </tr>	
</table>			  

</td>
<td style="border:solid 1px blue;">
 <a  class="btn green mini adrww" onclick="add_rowwwww()"><i class="icon-plus"></i></a><br>
<a  class="btn red mini" onclick="delete_row(<?php echo $count; ?>)"><i class=" icon-remove"></i></a><br>

</td>
</tr>