<br>
<div id="back" class="btn blue" >Back</div>


<br>
<br>
<div style="position:fixed; background-color:#FCFCFC; border:solid 2px #e1e1e1; z-index:9999; width:100%; width:90%; margin-left:5%;  overflow:auto;  margin-top:1%;" >

<div class="modal-header">
<h3 id="myModalLabel3" style="color:black;">Yellow Page Detail</h3>
</div>

<div class="modal-body" id="yellow_page_view_contant" style="">


<?php
foreach($result_yellow as $collection)            
			{  
				$cate="";
				$website=$collection['yellow_registration']["yellowpage_website"];
				$mobile=$collection['yellow_registration']["yellowpage_mobile"];
				$path=$collection['yellow_registration']["yellowpage_attachment"];
				$address=$collection['yellow_registration']['yellowpage_address'];
				$email=$collection['yellow_registration']['yellowpage_email'];
				$ad=mb_strimwidth($address, 0, 30, "....");
				@$category_id=$collection['yellow_registration']['yellowpage_category'];
				$name=$collection['yellow_registration']["yellowpage_name"];
				if(empty($path))
				{
				$path="blank.jpg"; 
				}
				
				?>
				
					<table width="100%" >
					<tr>
					<td width="30%" valign="top"><img src='<?php echo $this->webroot ; ?>/yellow_page_file/<?php echo $path; ?> ' width="100%" /></td>
					<td width="70%" valign="top" style="padding-left:10px;">
					<h4><i class="icon-user"></i> <?php echo $name; ?></h4>
					<h4><i class="icon-phone-sign"></i> <?php echo $mobile; ?></h4>
					<h4><i class="icon-envelope-alt"></i> <?php echo $email; ?></h4>
					<h4><i class="icon-cog"></i>
					<?php 
					
					foreach($category_id as $cat)
						{				
						@$result_cat=$this->requestAction(array('controller' => 'hms', 'action' => 'yellow_category_name'),array('pass'=>array($cat)));			  
							foreach($result_cat as $data)
							{
							 $category_name=$data['yellow_category']['yellow_cat_name']; 
$cate.=$category_name;

							 ?>
							 
							 
								 <?php echo $category_name; ?> </b> <?php
							}

						}		
						?>
					</h4>
					
					<h4><i class="icon-link"></i> <a target="_blank" href="http://<?php echo $website; ?>"><?php echo $website; ?></a></h3>
					<h4><i class="icon-home"></i> <?php echo $address; ?></h4>
					</td>
					</tr>
					</table>
				
				<?php		
			
			}
			
?>
</div>
</div>