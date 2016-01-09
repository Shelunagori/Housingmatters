
<tr id="tr<?php echo $h; ?>">
<td><input type="text" class="span12 m-wrap tboxClass" name="name" id="name<?php echo $h; ?>" style="background-color: white !important;" placeholder="Name*" value=""></td>
<td>
<select class="span12 m-wrap wing" name="wing" id="wing<?php echo $h; ?>" inc_id="<?php echo $h; ?>">
<option value="">-Wing-</option>
<?php 
foreach($result_wing as $data) { 
$wing_id=$data["wing"]["wing_id"];
$wing_name=$data["wing"]["wing_name"];
?>
<option value="<?php echo $wing_id; ?>"><?php echo $wing_name; ?></option>
<?php } ?>
</select>
</td>
<td id="echo_flat<?php echo $h; ?>">
<select class="span12 m-wrap" name="flat" id="flat<?php echo $h; ?>">
<option value="">-Flat-</option>
</td>
<td><input type="text" class="span12 m-wrap" name="email" id="email<?php echo $h; ?>" style="font-size:16px;  background-color: white !important;" placeholder="Email" value=""></td>
<td><input type="text" class="span12 m-wrap" name="mobile" id="mobile<?php echo $h; ?>" style="font-size:16px;  background-color: white !important;" placeholder="Mobile" value="" maxlength="10"></td>
<td>
<div class="controls">
    <label class="radio line"><input type="radio" class="owner" name="owner<?php echo $h; ?>" value="1" inc_id="<?php echo $h; ?>">Yes</label>
    <label class="radio line"><input type="radio" class="owner" name="owner<?php echo $h; ?>" value="2" inc_id="<?php echo $h; ?>">No</label>
</div>
</td>
<td>
<div class="controls" id="committe<?php echo $h; ?>">
    <label class="radio line"><input type="radio" name="committe<?php echo $h; ?>" value="1">Yes</label>
    <label class="radio line"><input type="radio" name="committe<?php echo $h; ?>" value="2">No</label>
</div>
<div id="no<?php echo $h; ?>" style="display:none;">No</div>
</td>
<td>
<!--<div class="controls" id="residing_div<?php echo $h; ?>">
    <label class="radio line"><input type="radio" name="residing<?php echo $h; ?>" value="1">Self Occupied</label>
    <label class="radio line"><input type="radio" name="residing<?php echo $h; ?>" value="2">Leased</label>
</div>
<div id="not<?php echo $h; ?>" style="display:none;">No</div>-->
<div class="pull-right"><a href="#" role="button" class="btn mini black delete" id="<?php echo $h; ?>"><i class="icon-trash"></i> Delete</a></div>
</td>
</tr>
