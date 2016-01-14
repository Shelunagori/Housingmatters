<input type="hidden" value="2" id="stype"/>
<div class="modal-header">
	<h4 id="myModalLabel1">Import csv</h4>
</div>
<div class="modal-body">
<center>
<div id="ovrlp"></div>
<div id="rpp"></div>
</center>
	<table class="table table-bordered">
		<tr>
			<th width="40%">Wing</th>
			<th width="40%">Unit number</th>
            <th width="20%">Delete</th>
		</tr>
	</table>
	<table class="table table-bordered" id="flats_main">
	<?php 
	$j=0;
	?>
	<?php foreach($table as $data){ 
	$j++;
	?>
		<tr id="tr<?php echo $j; ?>">
			<td width="40%">
				<select class="span6 m-wrap" data-placeholder="Choose a Category" tabindex="1">
				<option value="">Select...</option>
				<?php foreach($result_wing as $wdata){
				$wing_id=$wdata["wing"]["wing_id"];
				$wing_name=$wdata["wing"]["wing_name"];
				?>
				<option value="<?php echo $wing_id; ?>" <?php if($wing_id==$data[0]){ echo 'selected'; } ?> ><?php echo $wing_name; ?></option>
				<?php } ?>
				
				</select>
			</td>
			<td width="40%"><input type="text" class="m-wrap span7" maxlength="10" value="<?php echo $data[1]; ?>"></td>
            <td width="20%"><a href="#" role="button" class="btn mini red delete" del="<?php echo $j; ?>"><i class="icon-remove icon-white"></i></a></td>
		</tr>
	<?php } ?>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="btn" id="import_close">Cancel</button>
	<button type="submit" class="btn blue ">Import</button>
</div>
