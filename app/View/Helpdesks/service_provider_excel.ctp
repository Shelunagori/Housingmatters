<?php 

$filename=$society_name.'_service_provider';
$filename = str_replace(' ', '_', $filename);
$filename = str_replace(' ', '-', $filename);
header ("Expires: 0");
header ("border: 1");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls");
header ("Content-Description: Generated Report" );

?>

<div align="center"> 
<span style="font-size:16px;"><?php echo $society_name; ?><span>
<br/>
<span> Services Provider Report <span>
</div>


<div class="portlet box " >
							
							<div class="portlet-body">
									
							<table class="table table-striped table-bordered" id="sample_2" border="1">
							<thead>
    						<tr >
                                        	
                                    <th style="width:5%;">Sr No</th>
									<th>Vendor Name</th>
                                    <th>Contact Person</th>
								    <th>Services</th>
									<th>Mobile</th>
									<th>Email</th>
                                    <th>Contract Type</th>
                                    <th>Contract from</th>
									<th>Contract to</th>
                                    <th>PAN Number</th>
									</tr>
									</thead>
									<tbody>
						
						
						<?php
                        $z=0;
                       
                        foreach ($result_service_provider as $collection) 
                        {
                        $z++;
                        $name=$collection['service_provider']['sp_name'];
                        $auto_id= (int)$collection['service_provider']['sp_id'];
                        $attachment=@$collection['service_provider']['sp_attachment'];
                        $ext = pathinfo($attachment, PATHINFO_EXTENSION);
                        $contect=@$collection['service_provider']['sp_mobile'];
		                $Contract_start=@$collection['service_provider']['sp_cont_start'];
                        $Contract_end=@$collection['service_provider']['sp_cont_end'];
                        $contrect_person=@$collection['service_provider']['sp_person'];
                        $email=@$collection['service_provider']['sp_email'];
                        $Contract_type=@$collection['service_provider']['sp_contract_type'];
                        $pan_number = @$collection['service_provider']['pan_number'];
						if($Contract_type=="Adhoc")
                        {
                        $Contract_start="N/A";
                        $Contract_end="N/A";
                        }
						 
						 
						
                        ?>
                            <tr class="odd gradeX">
                            <td><?php echo $z; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $contrect_person; ?></td>
                            <td>
                        <?php
                       $result_vendor = $this->requestAction(array('controller' => 'hms', 'action' => 'service_provider_vendor'),array('pass'=>array($auto_id)));
                        foreach ($result_vendor as $collection) 
						{
                         $category=(int)$collection['vendor']['category_id'];
						 $type = $this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'),array('pass'=>array($category)));
						?>
						 <?php echo $type; ?>,
                <?php } ?>
                   </td>
                            <td><?php echo $contect; ?></td>
							<td><?php echo $email; ?></td>
                            <td><?php echo $Contract_type; ?></td>
                            <td><?php echo $Contract_start; ?></td>
                            <td><?php echo $Contract_end; ?></td>
                            <td><?php echo $pan_number; ?></td>
                           
                           
                        </tr> <?php } ?>
                   
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
			
