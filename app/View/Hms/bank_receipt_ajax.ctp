
<?php
if($ff == 5)
{
?>
<select   name="recieved_from2"  class="medium m-wrap chosen" id="go">
						<option value="">Party Name</option>
						<?php foreach ($cursor1 as $collection) 
						{
						$auto_id=(int)$collection['ledger_sub_account']['auto_id'];
						$name=$collection['ledger_sub_account']['name'];
						$user_id=(int)@$collection['ledger_sub_account']['user_id'];
						$result = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));
						foreach ($result as $collection) 
						{
						$wing_id = $collection['user']['wing'];  
						$flat_id = (int)$collection['user']['flat'];
						$tenant = (int)$collection['user']['tenant'];
						}	
						$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
						if($tenant == 1)
						{
						?>
						<option value="<?php echo $auto_id; ?>"><?php echo $name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $wing_flat; ?><?php  ?></option>
						<?php }} ?>
						</select>	
<?php } ?>

<?php
if($ff == 8)
{
?>						

<input type="text" name="recieved_from" class="m-wrap medium" style="background-color:white !important;" placeholder="Party Name" id="re">






						
<?php } ?>						