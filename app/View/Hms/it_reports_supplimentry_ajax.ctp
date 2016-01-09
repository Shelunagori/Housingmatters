<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  ?>
<?php
if($c == 2)
{
?>
			<div id="echo_table">
			<div style="padding:20px;" id="echo_table">
            
			<table class="table table-bordered table-striped table-hover" style="background-color:white;">
					<thead>
					<tr>
					<th>#</th>
					<th style="width:5%;">Bill No</th>
					<th style="width:10%;">Genetared on</th>
					<th>Genetared For</th>
					<th>Flat</th>
					<th>Amount</th>
					<th>Status</th>
					<th>View</th>
					</tr>
					</thead>
					<tbody>
					 
					 <?php
							$grand_total = 0;
							$i=0;
							foreach ($cursor1 as $collection) 
							{
							$i++;
							$adhoc_bill=$collection['adhoc_bill']["adhoc_bill_id"];
							$date=$collection['adhoc_bill']["date"];
							$residential=$collection['adhoc_bill']["residential"];
							$g_total=$collection['adhoc_bill']["g_total"];
			                $d_user_id=(int)$collection['adhoc_bill']["person_name"];
					        $pay_status = (int)$collection['adhoc_bill']['pay_status'];
					                $result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_id)));
									foreach ($result_user as $collection) 
									{
									$wing_id = (int)$collection['user']['wing'];  
									$flat_id = (int)$collection['user']['flat'];
									$user_name = $collection['user']['user_name'];
									}	
									$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
                                    $bill_for = $wing_flat;
								   
					                $date = date('d-m-Y',$date->sec);
					                $grand_total = $grand_total + $g_total;
									?>
										
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $adhoc_bill; ?></td>
									<td><?php echo $date; ?></td>
									<td class="hidden-phone"><?php echo $user_name; ?></td>
									<td style="color:#666;">(<?php echo $bill_for; ?>)</td>
									<td><?php echo $g_total; ?></td>
									<td><?php if($pay_status==0) { ?><span class="label label-important">Unpaid</span> <?php } 
									 else { ?>
									<span class="label label-important">paid</span><?php } ?>
								    </td>
									<td><a href="supplimentry_bill_view?bill=<?php echo $adhoc_bill; ?>" class="btn mini yellow">View</a>
									
									<a href="supplimentry_bill_pdf?p=<?php echo $adhoc_bill; ?>" class="btn mini purple" target="_blank">Pdf</a>
									</td>
								</tr>
                                <?php } ?>
                                <tr>
                                <th colspan="5">Total</th>
					            <th><?php echo $grand_total;  ?></th>
                                <th colspan="2"></th>
                                </tbody>
								</table>
                                </div>
                                </div>
					
					<?php } ?>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($c == 3)
{
?>
					<div id="echo_table">
					<div style="padding:20px;" id="echo_table">
            
			<table class="table table-bordered table-striped table-hover" style="background-color:white;">
						<thead>
						<tr>
						<th>#</th>
						<th style="width:5%;">Bill No</th>
						<th style="width:10%;">Genetared on</th>
						<th>Genetared For</th>
						<th>Flat</th>
						<th>Amount</th>
						<th>Status</th>
						<th>View</th>
						</tr>
						</thead>
						<tbody>					
					 
					 <?php
						$grand_total = 0;
						$i=0;
						foreach ($cursor2 as $collection) 
						{
						$i++;
						$adhoc_bill=$collection['adhoc_bill']["adhoc_bill_id"];
						$date=$collection['adhoc_bill']["date"];
						$residential=$collection['adhoc_bill']["residential"];
						$g_total=$collection['adhoc_bill']["g_total"];
					    $user_name=$collection['adhoc_bill']["person_name"];
					    $pay_status = (int)$collection['adhoc_bill']['pay_status'];			
						$bill_for="Non-residential";
					
					    $date = date('d-m-Y',$date->sec);
					    $grand_total = $grand_total + $g_total;
					   
					    ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $adhoc_bill; ?></td>
											<td><?php echo $date; ?></td>
											<td class="hidden-phone"><?php echo $user_name; ?></td>
											<td style="color:#666;">(<?php echo $bill_for; ?>)</td>
                                            <td><?php echo $g_total; ?></td>
                                            <td><?php if($pay_status==0) { ?><span class="label label-important">Unpaid</span> <?php } 
									 else { ?>
									<span class="label label-important">paid</span><?php } ?></td>
									<td><a href="supplimentry_bill_view?bill=<?php echo $adhoc_bill; ?>" class="btn mini yellow">View</a>
									<a href="supplimentry_bill_pdf?p=<?php echo $adhoc_bill; ?>" class="btn mini purple" target="_blank">Pdf</a>
									</td>
									
										</tr>
                                    
										<?php } ?>
                                        <tr>
                                        <th colspan="5">Total</th>
                                        <th><?php echo $grand_total; ?></th>
                                        <th colspan="2"></th>
                                        </tr>
										</tbody>
										</table>
										</div>
										</div>
										<?php } ?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php if($c == 1) { ?>					
					<div id="echo_table">
					<div style="padding:20px;" id="echo_table">
                
				  <table class="table table-bordered table-striped table-hover" style="background-color:white;">
						<thead>
						<tr>
						<th>#</th>
						<th style="width:5%;">Bill No</th>
						<th style="width:10%;">Genetared on</th>
						<th>Genetared For</th>
						<th>Flat</th>
						<th>Amount</th>
						<th>Status</th>
						<th>View</th>
						</tr>
						</thead>
						<tbody>					
					
					    <?php
						$grand_total = 0;
						$i=0;
						foreach ($cursor3 as $collection) 
						{
						$i++;
						$adhoc_bill=$collection['adhoc_bill']["adhoc_bill_id"];
						$date=$collection['adhoc_bill']["date"];
						$residential=$collection['adhoc_bill']["residential"];
						$g_total=$collection['adhoc_bill']["g_total"];
					    $pay_status = (int)$collection['adhoc_bill']['pay_status'];	
						if($residential=="y")
						{
						$d_user_id=(int)$collection['adhoc_bill']["person_name"];
						$result_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($d_user_id)));
						foreach ($result_user as $collection) 
						{
						$wing_id = (int)$collection['user']['wing'];  
						$flat_id = (int)$collection['user']['flat'];
						$user_name = $collection['user']['user_name'];
						}	
						$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));									
						$bill_for = $wing_flat;
						}

						if($residential=="n")
						{
						$user_name=$collection['adhoc_bill']["person_name"];
						$bill_for="Non-residential";
						}
					
					      $date = date('d-m-Y',$date->sec);
						  $grand_total = $grand_total + $g_total;
									?>
									
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $adhoc_bill; ?></td>
									<td><?php echo $date; ?></td>
									<td class="hidden-phone"><?php echo $user_name; ?></td>
									<td style="color:#666;">(<?php echo $bill_for; ?>)</td>
									<td><?php echo $g_total; ?></td>
					                <td>
									<?php if($pay_status==0) { ?> <span class="label label-important">Unpaid</span> <?php }
									else
									 { ?> <span class="label label-success">paid</span> <?php } ?>
									</td>
									<td><a href="supplimentry_bill_view?bill=<?php echo $adhoc_bill; ?>" class="btn mini yellow">View</a>
									<a href="supplimentry_bill_pdf?p=<?php echo $adhoc_bill; ?>" class="btn mini purple" target="_blank">Pdf</a>
									</td>
					                </tr>
									
									<?php } ?>
                                    <tr>
                                    <th colspan="5">Total</th>
                                    <th><?php echo $grand_total; ?></th>
                                    <th colspan="2"></th>
                                    </tr>
									</tbody>
									</table>
									</div>
									</div>
					
					<?php } ?>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					