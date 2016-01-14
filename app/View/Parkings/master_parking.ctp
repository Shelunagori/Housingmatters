<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>

<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
               Manage Roles
</div>-->

<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
	
</ul>
        <div class="tab-content">
        <div class="tab-pane active" >
        <div class="span6" style="margin-left:25%;  ">
        <div class="portlet-body" >
        <table class="table table-hover table-bordered" id="tb">
        <tr>
        <th>Sr.no.</th>
        <th>Parking Area</th>
        </tr>
		<?php 
		$i=0;
		foreach($result_parking as $data)
		{
		$i++;
		$parking_area_cat=$data['parking_area']['parking_area_cat'];
		?>
		<tr>
       <td><?php echo $i ; ?></td>
	    <td><?php echo $parking_area_cat ; ?></td>
        </tr>
	<?php } ?>
        </table>
        <form method="post" id="contact-form">
        <div class="input-append" style="margin-left:23%;">                      
        <input class="m-wrap" size="16" type="text" placeholder="Parking Area" id="role_name" name="parking_area" required="required">
        <button class="btn blue" type="submit" name="add_role" >Add Parking Area</button>
        </div>
        </form>
        
        
        </div>
        </div>
        </div>
        
        </div>
        </div>