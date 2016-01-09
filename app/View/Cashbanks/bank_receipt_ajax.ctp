
<?php
if($ff == 5)
{
?>
<label style="font-size:14px;">Party Name<span style="color:red;">*</span></label>
<div class="controls">
<select   name="party_name_id"  class="span9 m-wrap chosen" id="go">
<option value="">Party Name</option>
<?php foreach ($cursor1 as $collection) 
{
$auto_id=(int)$collection['ledger_sub_account']['auto_id'];
//$name=$collection['ledger_sub_account']['name'];
$user_id=(int)@$collection['ledger_sub_account']['user_id'];
$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
foreach ($result as $collection) 
{
$name = $collection['user']['user_name']; 
$wing_id = $collection['user']['wing'];  
$flat_id = (int)$collection['user']['flat'];
$tenant = (int)$collection['user']['tenant'];
}	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat_with_brackets'),array('pass'=>array($wing_id,$flat_id)));									
if($tenant == 1)
{
?>
<option value="<?php echo $flat_id; ?>"><?php echo $name; ?> <?php echo $wing_flat; ?><?php  ?></option>
<?php }} ?>
</select>
<label id="go"></label>
</div>
<br />

<label style="font-size:14px;">Receipt For<span style="color:red;">*</span></label>
<div class="controls">
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="receipt_type" value="1" style="opacity: 0;" id="ttt"></span></div>
Maintenance
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" name="receipt_type"  value="2" style="opacity: 0;" id="ttt"></span></div>
Other
</label>
<label id="ttt"></label>
</div>
<br />
	
<?php } ?>
<?php
if($ff == 8)
{
?>						
<label style="font-size:14px;">Party Name<span style="color:red;">*</span></label>
<div class="controls">
<input type="text" name="party_name" class="m-wrap span9" style="background-color:white !important;" placeholder="Party Name" id="re">
<label id="re"></label> 
</div>
<br />
<?php } ?>						