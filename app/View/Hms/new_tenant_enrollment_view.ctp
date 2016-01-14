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
View
</div>-->
<div style="float:right;"><span><a href="tenant_excel" class="blue mini btn" download="download"><i class=" icon-download-alt"></i> Download in Excel</a></span></div>
<div class="portlet-body" style="padding:10px;";>
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">

										</ul>
										<div class="tab-content" style="min-height:500px;">
											<div class="tab-pane active" id="tab_1_1">
					
					
				
            
            <div class="portlet-body">
            <table class="table table-striped table-bordered" id="sample_1">
            <thead>
            <tr >
            <th>#</th>
            <th>Name</th>
			<th>Flat</th>
            <th>Mobile</th>
			 <th>Email</th>
            <th>Start date</th>
             <th>End date</th>
			  <th>Agreement Copy</th>
            <th>Police NOC</th>
            <th>Remarks</th>
             <th>Permanent Address</th>
			 <th><span style="font-size:14px;"><i class="icon-paper-clip"></i></span></th>
			 <th>Action</th>
            </tr>
            </thead>
            <tbody>
          
            <?php
			$i=0;
           
            foreach ($user_tenant as $collection) 
            {
			$i++;
            $name=$collection['tenant']['name'];
			$d_user_id=(int)$collection['tenant']['user_id'];
            $mobile=$collection['tenant']['t_mobile'];
            $t_address=@$collection['tenant']['t_address'];
            $t_agreement=@$collection['tenant']['t_agreement'];
			$t_police=@$collection['tenant']['t_police'];
            $verification=@$collection['tenant']['verification'];
            $t_start_date=@$collection['tenant']['t_start_date'];
            $t_end_date=@$collection['tenant']['t_end_date'];
			$t_file=@$collection['tenant']['t_file'];
			if($t_agreement==1)
			{
				$t_agreement='Yes';
			}
			else
			{
			$t_agreement='No';
			
			}
			if($t_police==1)
			{
				$t_police='Yes';
			}
			else
			{
			$t_police='No';
			
			}
$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_id)));
foreach($result_user as $data)
{
$wing=$data['user']['wing'];
$flat=$data['user']['flat'];
$email=$data['user']['email'];
}

$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
		
            ?>
             <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $name; ?></td>
			 <td><?php echo $wing_flat; ?></td>
            <td><?php echo $mobile; ?></td>
			 <td><?php echo $email; ?></td>
            <td><?php echo $t_start_date; ?></td>
            <td><?php echo $t_end_date; ?></td>
			 <td><?php echo $t_agreement; ?></td> 
			  <td><?php echo $t_police; ?></td>
            <td class="hidden-phone"><?php echo $verification; ?></td>
             <td width="20%"><?php echo $t_address; ?></td>
			 <td>
			<?php if(!empty($t_file)){?> <a href="<?php echo $webroot_path ?>tenant_upload/<?php echo $t_file ; ?>" target="_blank" class="" download="download"> <i class=" icon-download-alt"></i> </a> <?php } ?>
			 </td>
			 <td>
			 
			 <div class="btn-group">
                <a class="btn mini blue" href="#" data-toggle="dropdown">
                Action
                
                </a>
                <ul class="dropdown-menu">
                <li><a href="new_tenant_edit/<?php echo $d_user_id ; ?>" rel="tab"><i class="icon-pencil"></i> Edit</a></li>
                </ul>
                </div>
			 </td>
            </tr> <?php } ?>
            </tbody>
            </table>
            </div>
            </div>
			
					
											</div>
											
										</div>
</div>