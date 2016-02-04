

<div style="background-color: #FFF;">
<table style="backgroud-color:white; width:100%;">
<tr>
<td style="border:solid 1px blue;">

             <table id="sub_table2">
              
			  <tr>
			  <th style="width:20%; font-size8px;">Transaction Date</th>
			  <th style="width:20%; font-size8px;">Ledger A/c</th>
			  <th style="width:20%; font-size8px;">Invoice Reference</th>
			  <th style="width:20%; font-size8px;">Amount</th>
			  <th style="width:20%; font-size8px;">TDS%</th>
			  </tr>


			  
			  <tr>
			  <td><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
			  value="<?php echo $default_date; ?>" 
			  style="background-color:white !important; margin-top:2.5px;" id="dattt1"></td>
			  
			  
					<td>
					<select class="m-wrap span12 chosen" id="ledger_account1">
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
			  style="background-color:white !important; margin-top:2.5px;" id="inv_ref1">
			  </td>
			  
			  
			  <td><input type="text" class="m-wrap span12" id="amttt1" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" 
			  onkeyup="numeric_vali(this.value,1)" onchange="tdssssamt2(this.value,1)">
			  </td>
			  
			  
				<td><select class="m-wrap chosen span12" onchange="tdssssamt(this.value,1)" id="tdssss1">
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

              <tr>
			  <th>Net Amount</th>
			  <th>Mode of Payment</th>
			  <th>Instrument/UTR</th>
			  <th>Bank Account</th> 
			  <th>Narration</th>
			  </tr>
		
			  <tr>
				  
				  <td id="tds_show1"><input type="text"  class="m-wrap span12" 
				  readonly="readonly" style="background-color:white !important; margin-top:2.5px;" id="net_amtt1">
				  </td>
				  
				<td>
				<select class="m-wrap span12 chosen" id="moddd1">
				<option value="">Select</option>
				<option value="Cheque">Cheque</option>
				<option value="NEFT">NEFT</option>
				<option value="PG">PG</option>
				</select>
				</td>


			  <td><input type="text"  class="m-wrap span12" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" id="instru1">
              </td>
			  
			  
					<td>
					<select onchange="get_value(this.value)" class="m-wrap chosen span12" id="bankk1">
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
				  style="background-color:white !important; margin-top:2.5px;" id="desc1">
				  </td>
			  
              </tr>	
			  </table>
			  </tr>
			  </table> 
			  </div>