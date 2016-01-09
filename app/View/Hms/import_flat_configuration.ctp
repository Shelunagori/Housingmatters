<div>
<div id="vali5"></div>
<div id="ttt"></div>
<table class="m-wrap table table-bordered" id="open_bal">
<tr>
<th>Wing</th>
<th>Unit Number</th>
<th>Unit Type</th>
<th>Unit Area (Sq.Ft.)</th>
<th>Delete</th>
</tr>
<?php 
$i=0;
foreach($table as $child){
$i++;
?>
<tr id="tr<?php echo $i; ?>">
<td>
<!--
<select class="span10 m-wrap wing" id="wing2" name="wing" inc_id="<?php echo $i; ?>">
<option value="">Select</option>
<?php
// 
//foreach($result_wing as $data) { 
//$wing_id=$data["wing"]["wing_id"];
//$wing_name=$data["wing"]["wing_name"];
?>
<option value="<?php //echo $wing_id; ?>" <?php //if($wing_id==$child[0]){ echo 'selected';} ?> ><?php //echo $wing_name; ?></option>
<?php //} ?>
</select>

-->
<?php
foreach($result_wing as $data) { 
$wing_id=$data["wing"]["wing_id"];
$wing_name=$data["wing"]["wing_name"];
if($wing_id==$child[0])
{
?>
<input type="text" class="m-wrap span10" value="<?php echo $wing_name; ?>" style="background-color:white !important;" readonly="readonly" />

<?php
}}
?>
</td>
<td>
<input type="text" class="m-wrap span10" value="<?php echo $child[1]; ?>" style="background-color:white !important;" readonly="readonly"/>
</td>
		
<td id="echo_flat_type<?php echo $i; ?>">
<select class="span10 m-wrap" id="flat1" name="flat_type" >
<option value="">Flat type</option>
<?php 
foreach($result_flat_type as $data) { 
$flat_type_id=$data["flat_type_name"]["auto_id"];
$flat_type_name=$data["flat_type_name"]["flat_name"];

?>
<option value="<?php echo $flat_type_id; ?>" <?php if($flat_type_id==$child[2]){ echo 'selected';} ?> ><?php echo $flat_type_name; ?></option>
<?php } ?>
</select>
</td>
		
					
<td><input type="text" class="span10 m-wrap textbox" name="area1" id="area" style="font-size:16px;  background-color: white !important;" placeholder="area" value="<?php echo $child[3]; ?>"></td>

<td><a href="#" role="button" class="btn mini red delete" id="<?php echo $i; ?>"><i class="icon-remove icon-white"></i></a></td>			
</tr>
<?php } ?>
</table>
<a class="btn" href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel="tab">Cancel</a>
<button type="submit" class="btn blue import_op">Import</button>
</div>