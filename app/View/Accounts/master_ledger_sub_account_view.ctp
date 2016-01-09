<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<center>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_account_coa" class="btn" rel='tab'>Ledger Accounts Add</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_sub_accounts_coa" class="btn" rel='tab'>Ledger Sub Accounts Add</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_accounts_view" class="btn" rel='tab'>Master Ledger  Account View</a>
<a href="<?php echo $webroot_path; ?>Accounts/master_ledger_sub_account_view" class="btn yellow" rel='tab'>Master Ledger Sub Account View</a>
</center>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<br />
<center>
<div class="portlet box grey" style="width:100%;">
<div style="background-color:#B2B2B2; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
<b style="color:white;">  Ledger Sub Accounts View </b>
</div>
<div class="portlet-body">
<div style="width:100%;">
					<table style="width:100%; background-color:white;" class="table table-bordered" id="sample_2">			
					<thead>
                    <tr>
					<th>Sr.No.</th>
					<th>Account Category</th>
					<th>Accounts Group</th>
					<th>Ledger Account</th>
					<th>Ledger Sub Account</th>
                   	</tr>        
                    </thead>
                    <tbody>
					<?php
					$n = 1; 
					foreach ($cursor2 as $collection) 
					{
					 $ledger_id = (int)$collection['ledger_sub_account']['ledger_id'];
					$deactive = @$collection['ledger_sub_account']['deactive'];
					$name = $collection['ledger_sub_account']['name'];
                    $auto_id = (int)$collection['ledger_sub_account']['auto_id'];
					$wing_flat = "";
					$wing_id = "";
                    $flat_id = "";
					$user_id = "";
					if($ledger_id==33){
					$name.=' - '.$collection['ledger_sub_account']['bank_account'];
					}
					if($ledger_id == 34)
					{
						
					$flat_id = (int)$collection['ledger_sub_account']['flat_id'];	
					}
					
					//wing_id via flat_id//
					$result_flat_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
					foreach($result_flat_info as $flat_info){
						$wing_id=$flat_info["flat"]["wing_id"];
					} 
					
					//user info via flat_id//
					$result_user_info=$this->requestAction(array('controller' => 'Hms', 'action' => 'fetch_user_info_via_flat_id'),array('pass'=>array($wing_id,$flat_id)));
					foreach($result_user_info as $user_info){
						$user_id=(int)$user_info["user"]["user_id"];
						$user_name=$user_info["user"]["user_name"];

					} 
				


$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
					
  $result_la = $this->requestAction(array('controller' => 'hms', 'action' => 'ledger_account'),array('pass'=>array($ledger_id)));
					foreach ($result_la as $collection) 
					{
					$group_id = (int)$collection['ledger_account']['group_id'];	
					$ledger_name = $collection['ledger_account']['ledger_name'];	
					}
					
					
					
					
					
$result_ag = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_group'),array('pass'=>array($group_id)));
foreach ($result_ag as $collection) 
{
$accounts_id = (int)$collection['accounts_group']['accounts_id'];	
$group_name = $collection['accounts_group']['group_name'];	
}

$result_ac = $this->requestAction(array('controller' => 'hms', 'action' => 'accounts_category'),array('pass'=>array($accounts_id)));		   
foreach ($result_ac as $collection) 
{
$main_name = $collection['accounts_category']['category_name'];	
} 
?>        
					
<tr>
<td><?php echo $n; ?></td>
<td><?php echo $main_name; ?></td>
<td><?php echo $group_name; ?></td>
<td><?php echo $ledger_name; ?></td>
<td><?php echo $name; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $wing_flat;  ?>  </td>
</tr>           
<?php $n++; $name=''; } ?> 
</tbody>  
</table>
</div> 
</div>
</div>        
</center>
