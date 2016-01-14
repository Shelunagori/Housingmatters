<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>


<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Master Ledger Sub Accounts</b></h3>
</center>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<a href="master_ledger_account_coa" class="btn yellow">Ledger Accounts</a>
<a href="master_ledger_sub_accounts_coa" class="btn purple">Ledger Sub Accounts</a>

<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
                         <form method="post" id="contact-form"> 
                         <table>
                         <tr>
                         <td>
                         <select class="medium m-wrap chosen" name="main_id" id="go">
                         <option value="">--SELECT CATEGORY--</option>
                         <?php
                         foreach ($cursor1 as $collection) 
						 {
                         $auto_id = (int)$collection['ledger_account']['auto_id'];
                         $name = $collection['ledger_account']['ledger_name']; 
                         ?>
                         <option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
                         <?php } ?>
                         </select>
						 <label id="go"></label>
                         </td>
                         </tr>
                        
                        
                        <tr>
                        <td>
			            <input type="text" name="cat_name" placeholder="Name" class="m-wrap medium" style="background-color:white !important;" id="cat">
						<label id="cat"></label>
			            </td>
                        </tr>

                       
                        <tr>
                        <td id="result">
			            
						
						<label id="ui"></label><label id="si"></label><label id="ba"></label><label id="tx"></label>
			            </td>
                        </tr>
                       
                       
                       
                       
                       
                       <tr>
                       <td>
                       <button type="submit" name="sub" class="btn blue">Add</button>
			           </td>
                       </tr>
                       </table>
                       </form>
    
               </center>
			   
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////// ?>	

<center>

<div class="portlet box grey" style="width:90%;">
<div style="background-color:#B2B2B2; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
<b style="color:white;">  Ledger Sub Accounts </b>
</div>
<div class="portlet-body">


										<div style="width:100%;">
					<table style="width:100%; background-color:white;" class="table table-bordered" id="sample_2">			
					<thead>
                    <tr>
					<th>Sr.No.</th>
					<th>Account Category Name</th>
					<th>Accounts Group Name</th>
					<th>Ledger Name</th>
					<th>Ledger Sub Account Name</th>
                    <th>Edit</th>
					</tr>        
                    </thead>
                    <tbody>
					<?php
					$n = 1;
					foreach ($cursor2 as $collection) 
					{
					$ledger_id = (int)$collection['ledger_sub_account']['ledger_id'];
					$name = $collection['ledger_sub_account']['name'];
                    $auto_id = (int)$collection['ledger_sub_account']['auto_id'];
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
					<td><?php echo $name;     ?> </td>
                    <td style="text-align:center;">
               <a href="#myModal<?php echo $auto_id; ?>" role="button" class="btn mini purple" data-toggle="modal">Edit</a>
                    </td>
                    </tr>           
					<?php $n++; } ?> 
                    </tbody>  
					</table>
					</div> 
                    </div>
                    </div>        
					</center>

<?php ////////////////////////////////////////////////////////////////////////////////////// ?>
<form method="post">
<?php
foreach ($cursor2 as $collection) 
{
$auto_id2 = (int)$collection['ledger_sub_account']['auto_id'];
$name2 = $collection['ledger_sub_account']['name'];
$ledger_id2 = (int)$collection['ledger_sub_account']['ledger_id'];


?>
<div id="myModal<?php echo $auto_id2; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="display: block;">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Ledger Sub Accounts</b></h3>
</center>
</div>
<div class="modal-body">
<center>
<table border="0">
<tr>
<td>
<select name="gr" class="m-wrap medium">
<?php
foreach($cursor1 as $collection3)
{
$led_id = (int)$collection3['ledger_account']['auto_id'];
$ledger_name = $collection3['ledger_account']['ledger_name'];	
?>
<option value="<?php echo $led_id; ?>" <?php if($led_id == $ledger_id2) { ?> selected="selected" <?php } ?>><?php echo $ledger_name; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="text" value="<?php echo $name2; ?>" name="name"  class="m-wrap medium"/>
</td>
</tr>
</table>
</center>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
<button type="submit" class="btn blue" name="sub<?php echo $auto_id2; ?>">Update</button>
</div>
</div>                        
<?php } ?>                    
</form>                 
<?php ///////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function() {
	$("#go").live('change',function(){
		var value=document.getElementById('go').value;
		
		
		$("#result").load("master_ledger_sub_account_ajax?value=" +value+ "");
		
		
	});
	
});
</script>	

<script>

$(document).ready(function(){
		$.validator.setDefaults({ ignore: ":hidden:not(select)" });
		
		$('#contact-form').validate({
		
		errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    },
					
	    rules: {
	      main_id: {
	       
	        required: true
	      },
		  
		  
		  cat_name: {
	       
	        required: true
	      },
		  
		
		 user_id: {
	       
	        required: true
	      },
		  
		   sp_id: {
	       
	        required: true
	      },
		
		 bank_account: {
	       
	        required: true
	      },
		 
		  tax: {
	       
	        required: true
	      },
		
		
		},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); 
</script>































