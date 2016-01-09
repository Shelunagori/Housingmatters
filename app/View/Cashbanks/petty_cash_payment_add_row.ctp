<?php
$default_date = date('d-m-Y');
?>

        <tr class="content_<?php echo $count; ?>" style="background-color:#E8F3FF;">
        <td valign="top">
        <input type="text" class="m-wrap span12 date-picker" data-date-format="dd-mm-yyyy" name="date" id="date" style="background-color:white !important; margin-top:2.5px;" value="<?php echo $default_date; ?>">
        </td>

        <td valign="top">
        <select name="type" class="m-wrap span12 chosen" onchange="type_ajjxx(this.value,<?php echo $count; ?>)">						        <option value="" style="display:none;">Select</option>
        <option value="1">Sundry Creditors Control A/c</option>
        <option value="2">All Expenditure A/cs</option>
        </select>
        </td> 

        <td id="show_user<?php echo $count; ?>" valign="top">
        <select name="user_id" class="m-wrap span12 chosen">
        <option value="" style="display:none;">Select</option>
        </select>
        </td> 

        <td valign="top">
        <select name="account_head" class="m-wrap span12 chosen">
        <option value="" style="display:none;">Select</option><option value="32" selected="selected">Cash-in-hand</option>
        </select>
        </td>

        <td valign="top">
        <input type="text" class="m-wrap span12" style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="5" id="amttt<?php echo $count; ?>" onkeyup="numeric_vali(this.value,<?php echo $count; ?>)"></td>
        
        <td valign="top"><input type="text" class="m-wrap span12" style="background-color:white !important; margin-top:2.5px;">
        </td>
<td><a  class="btn green mini adrww" onclick="add_rowww()"><i class="icon-plus"></i></a><br>
<a  class="btn red mini" onclick="delete_row(<?php echo $count; ?>)"><i class=" icon-remove"></i></a></td>
</tr>