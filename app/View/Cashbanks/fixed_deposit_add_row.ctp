<?php
$default_date = date('d-m-Y');
?>

 <tr class="content_<?php echo $count; ?>">          
   <td style="border:solid 1px blue;">
       <table class="table table-bordered" id="sub_tablll">		 
		 <tr style="background-color:#E8EAE8;">
               <th>Bank Name</th>
			   <th>Branch</th>
			   <th>Account Reference</th>
			   <th>Principal Amount</th>
			   <th>Start Date</th>
			</tr> 
              
             <tr style="background-color:#E8F3FF;">
               <td>
			   <input type="text" class="m-wrap span12 corsrr" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]" 
			   style="background-color:#FFF !important;">
			   </td>
			   
			   <td>
			   <input type="text" class="m-wrap span12 corsrr" style="background-color:#FFF !important;" data-provide="typeahead" 
			   data-source="[<?php if(!empty($kendo_implode2)) { echo $kendo_implode2; } ?>]" >
			   </td>
			   
			   
               <td>
			   <input type="text" class="m-wrap span12 corsrr" style="background-color:#FFF !important;">
			   </td>
			   
			   <td>
			   <input type="text" class="m-wrap span12 corsrr" style="text-align:right; background-color:#FFF !important;" 
			   maxlength="10" onkeyup="numeric_vali(this.value,<?php echo $count; ?>)" id="amttt<?php echo $count; ?>">
			   </td>
			   
				 <td>
				 <input type="text" class="date-picker m-wrap span12 corsrr" data-date-format="dd-mm-yyyy" 
				 value="<?php echo $default_date; ?>" style="background-color:#FFF !important;">
				 </td>
			 
			 </tr>
			 <tr style="background-color:#E8EAE8;">
                 <th>Maturity Date</th>
				 <th>Interest Rate%</th>
				 <th>Attachment</th>
				 <th colspan="2">Purpose</th>
				 
             </tr>
					
					<tr style="background-color:#E8F3FF;">
					
                    <td>
					<input type="text" class="date-picker m-wrap span12 corsrr" 
					data-date-format="dd-mm-yyyy" style="background-color:#FFF !important;">
					</td>
					
					<td>
					<input type="text"  name="interest_rate" class="m-wrap span12 corsrr" 
					maxlength="5" onkeyup="intrest_vali(this.value,<?php echo $count; ?>)" 
					id="intrate<?php echo $count; ?>" style="background-color:#FFF !important; text-align:right;">
					</td>
					
						<td>
						<span class="btn btn-file corsrr">
						<i class="icon-upload-alt"></i>
						<input type="file" class="default" name="file2">
						</span>
						</td>
						
					<td colspan="2">
					<select class="m-wrap span12 chosen">
					<option value="" style="display:none;">Select</option>
					<option value="General Fund">General Fund</option>
					<option value="Reserve Fund">Reserve Fund</option>
					<option value="Repairs and Maintenance Fund">Repairs and Maintenance Fund</option>
					<option value="Sinking Fund">Sinking Fund</option>
					<option value="Major Repair Fund">Major Repair Fund</option>
					<option value="Education and Training Fund">Education and Training Fund</option>
					</select>
					</td>
					</tr>			 
			</table> 
     </td>
			
			
			<td style="border:solid 1px blue;">
			<a class="btn green mini adrww" onclick="fix_deposit_add_row()"><i class="icon-plus"></i></a><br>
			 <a  class="btn red mini" onclick="delete_rowwww(<?php echo $count; ?>)"><i class=" icon-remove"></i></a><br>
			</td>
</tr>