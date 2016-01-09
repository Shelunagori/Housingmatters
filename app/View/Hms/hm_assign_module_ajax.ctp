

<script>
$( document ).ready( function() {
   jQuery('.tooltips').tooltip();
   
   
    var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle)");
        if (test) {
            test.uniform();
        }

   
});
</script>






<div class="portlet-body" style='width:49%;margin-left:20%;'>
	<div class="accordion in collapse" id="accordion1" style="height: auto;">
								
								<?php
$i=0;
foreach ($result_main_module as $collection) 
{
	$i++;	
	$module_type_id=(int)$collection["module_type"]["module_type_id"];
	$module_type_name=$collection["module_type"]["module_type_name"];
	$icon=$collection["module_type"]["icon"];

	?>
<div class="accordion-group" style="";>
	<div class="accordion-heading" style="padding: 5px;">
	<table width="100%" style="font-size: 15px;">
		<tr>
		<td width="30%"><i class="<?php echo $icon ; ?>"></i> <?php echo $module_type_name; ?></td>
		<td width="10%">Select all <input type="checkbox" name="" value="<?php echo $module_type_id ; ?>" class='chk_input' id='<?php echo $module_type_id ; ?>'></td>
		<td width="10%">
		<a class="btn mini   accordion-toggle collapsed"  data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $i; ?>" style="">
		<i class="icon-search"></i> sub-modules
		</a>
		</td>
		
		</tr>
	</table>
	</div>
	<div id="collapse<?php echo $i; ?>" class="accordion-body collapse" style="height: 0px;">
		<div class="accordion-inner">
			<?php
						$result_sub_module=$this->requestAction(array('controller' => 'hms', 'action' => 'fetch_module_name'), array('pass' => array($module_type_id)));
					foreach ($result_sub_module as $collection) 
					{		  
					$module_id = $collection['main_module']['auto_id'];
					$module_name = $collection['main_module']['module_name']; 
					$c=$this->requestAction(array('controller' => 'hms', 'action' => 'count'),array('pass'=>array($module_id,$society_id)));            

							
			
				?>
				
				<div style="padding:5px; font-size:14px;border-bottom:solid 1px #ccc;">
				<label >
				
				<input type="checkbox" name="<?php echo $module_id; ?>" value="1" <?php if($c>0) { ?> checked <?php }  ?> <?php if($module_id==18) { ?> checked <?php } ?> class='all_chk<?php echo $module_type_id ;?>'>
				<span class=""  data-placement="right" data-original-title=""><?php echo $module_name; 			
 ?></span>
				
				
				</label>
				
				</div>
				
				<?php
				}
			 ?>
		</div>
	</div>
</div>
									
<?php } ?>	
								
	<div style="padding: 10px;" >
<button type="submit" name="sub" value="xyz" class="btn blue">Assign Modules</button>
</div>	
</form>							
		</div>
	</div>
	
	
	

