<?php 
$ddd_date = date('d-m-Y');
?>
<tr class="content_<?php echo $count; ?>">
<td style="border:solid 1px blue;">
			<table class="table table-bordered" id="sub_table">
					 <tr style="background-color:#E8EAE8;">
							<th style="width:13%;">Transaction Date</th>
							<th style="width:17%;">Deposited In</th>
							<th style="width:20%;">Receipt Mode</th>
							<th style="width:15%;">Cheque/UTR Ref</th>
							<th style="width:15%;">Date</th>
							<th style="width:20%;">Drawn on which bank</th>
					 </tr>
	  <tr style="background-color:#E8F3FF;">
					  
					  <td>
					  <input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
					  style="background-color:white !important; margin-top:3px;"
					  value="<?php echo $ddd_date; ?>" id="date<?php echo $count; ?>">
					  </td>
							  
							  
						<td>
						<select class="span12 m-wrap chosen" id="wbnk<?php echo $count; ?>">
						<option value="" style="display:none;">Select Bank</option>    
						<?php
						foreach ($cursor3 as $db) 
						{
						$bank_id = (int)$db['ledger_sub_account']["auto_id"];
						$bank_ac = $db['ledger_sub_account']["name"];
						$bank_account_number = $db['ledger_sub_account']["bank_account"];
						?>
						<option value="<?php echo $bank_id; ?>"><?php echo $bank_ac; ?> &nbsp;(<?php echo $bank_account_number; ?>)</option>
						<?php } ?>
						</select>
						</td>
						
						
						<td>
						<select class="span12 m-wrap chosen" onchange="receipt_mode(this.value,<?php echo $count; ?>)" id="modd<?php echo $count; ?>">
						<option value="" style="display:none;">receipt mode</option>    
						<option value="Cheque">Cheque</option>
						<option value="NEFT">NEFT</option>
						<option value="PG">PG</option>
						</select>
						</td>
						  
						  
		<td>
		<input type="text" placeholder="Cheque No." 
		class="m-wrap span12" style="background-color:#FFF !important; margin-top:3px;" id="chhno<?php echo $count; ?>">
		</td>
						
						
					<td>
					<input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
					placeholder="Date" style="background-color:#FFF !important; margin-top:3px;" id="dtt<?php echo $count; ?>"/>
					</td>
							  
							  
		<td>
		<input type="text" class="m-wrap span12" placeholder="Drawn on which bank?" id="bnkkk<?php echo $count; ?>" 
		style="background-color:#FFF !important; margin-top:3px;" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]">
		</td>
				 </tr>
				 
				 <tr style="background-color:#E8EAE8;">
				    <th>Branch</th>
                    <th>Received From</th>
		            <th><span id="sel_resdnt<?php echo $count; ?>">Select Resident</span><span id="prt_nam<?php echo $count; ?>" class="hide">Party Name
					<a class="btn mini green" style="float:right;" onclick="add_member()"><i class="icon-plus"></i></a></span></th>
		            <th><span id="recet_typp<?php echo $count; ?>">Receipt Type</span><span id="refrnc<?php echo $count; ?>" class="hide">Bill Reference</span></th>
		            <th>Amount Applied</th>
                    <th>Narration</th>
				   </tr>
				
				 <tr style="background-color:#E8F3FF;">
					
<td>
<input type="text" id="branchh<?php echo $count; ?>" class="m-wrap span12" 
placeholder="Branch of Bank" style="background-color:#FFF !important; margin-top:3px;" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode2)) { echo $kendo_implode2; } ?>]">
</td>
					
					<td>
					<select class="span12 m-wrap chosen" valign="top" onchange="rcpttypp(this.value,<?php echo $count; ?>)" id="rec_typp<?php echo $count; ?>">
					<option value="" style="display:none;">received from</option>    
					<option value="1">Residential</option>
					<option value="2">Non-Residential</option>
					</select>
				     </td>
					 
					 
					<td>
					<div id="pppp_nnn<?php echo $count; ?>">
					<?php
					$this->requestAction(array('controller' => 'Hms', 'action' => 'resident_drop_down')); ?>
					</div>
				    </td>
								 
				<td id="bill_refe_type<?php echo $count; ?>">
				<select class="m-wrap chosen span12" id="ttppp<?php echo $count; ?>" onchange="amtshw2(this.value,<?php echo $count; ?>)">
				<option value="" style="display:none;">Select Receipt Type</option>
				<option value="1">Maintanace Receipt</option>
				<option value="2">Other Receipt</option>
				</select>
				</td>
								 
				 <td id="amtview<?php echo $count; ?>">
				 <input type="text" class="m-wrap span12" 
				 style="text-align:right; background-color:#FFF !important; margin-top:3px;"
				 maxlength="10" onkeyup="numeric_vali(this.value,<?php echo $count; ?>)" id="amttt<?php echo $count; ?>"/>
				 </td>
								 
				 <td>
				 <input type="text" class="m-wrap span12" style="background-color:#FFF !important; margin-top:3px;" id="desc<?php echo $count; ?>"/>
				 </td>
				 
				 </tr>
			</table>
	</td>

         
		 
         <td style="border:solid blue 1px;" valign="right">
		 <a  class="btn green mini adrww" onclick="add_rowww()"><i class="icon-plus"></i></a><br>
		 <a  class="btn red mini" onclick="delete_row(<?php echo $count; ?>)"><i class=" icon-remove"></i></a><br>
		 </td>
</tr>