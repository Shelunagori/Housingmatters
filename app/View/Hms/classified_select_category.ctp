
			
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid" style="padding:0px; background-color:##EFEFEF; overflow:auto;" >
				
				<!-- BEGIN PAGE CONTENT-->
				
				
                
                                            
            <div style=" background-color:#EFEFEF; overflow:auto; padding-top:2px;">
            <div style="float:left; font-size:24px; padding-top:8px; padding-left:5px; color:#666;">Classified Ads</div>
			<div style="float:right;">
            <a href="classified" class="btn "><b>View</b></a>
            <a href="classified_draft" class="btn"><b>Draft</b></a>
            <a href="classified_my_post" class="btn"><b>My Post</b></a>
            <a href="classified_select_category" class="btn green"><b>Post Classified</b></a>
            </div>
            </div>
                <br>

				     
                
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div style="width:70%; margin-left:15%;">
						<!-- BEGIN ACCORDION PORTLET-->
						<div align="center">
								<h3 style="color:blue"><b>Classifieds Creation</b></h3>
								
							</div>
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Select Category</h4>
								
							</div>
							<div class="portlet-body">
								<div class="accordion in collapse" id="accordion1" style="height: auto;">
	<?php
									
                                       foreach ($result_select_category as $collection) {
									   $classified_category_id = (int)$collection['master_classified_category']["category_id"];
                                       $classified_category_name = $collection['master_classified_category']["category_name"];									
									?>
									<div class="accordion-group">
								
										<div class="accordion-heading">
											<a class="accordion-toggle collapsed btn black " data-toggle="collapse" data-parent="#accordion1" href="#abc<?php echo $classified_category_id; ?>">
											<i class="icon-angle-left"></i>
											<?php
											echo $classified_category_name;
											?>
											</a>
										</div>
										
										<div id="abc<?php echo $classified_category_id; ?>" class="accordion-body collapse">
											<div class="accordion-inner">
												<?php
												
		$sub_cat = $this->requestAction(array('controller' => 'hms', 'action' => 'master_classified_subcategory'),array('pass'=>array($classified_category_id)));
											
									
                                       foreach ($sub_cat as $collection) {
										   $classified_subcategory_id = $collection['master_classified_subcategory']['subcategory_id'];
									   
                                       $classified_subcategory_name = $collection['master_classified_subcategory']["subcategory_name"];									
									?>
												
												<a href="classified_post_ad?a=<?php echo $classified_category_id; ?>&b=<?php echo $classified_subcategory_id; ?>" style="border:solid 2px white; width:95%;" class="btn"><?php echo $classified_subcategory_name;?></a><br/>
												<?php
												}
												?>
											</div>
										</div>
										
										
									</div>
									
<?php
										}
										?>
									
								</div>
							</div>
						
						<!-- END ACCORDION PORTLET-->      
					</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>