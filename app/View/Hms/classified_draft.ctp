
			<!-- BEGIN PAGE CONTAINER-->
			
            <div style=" background-color:#EFEFEF; overflow:auto; padding-top:2px;">
            <div style="float:left; font-size:24px; padding-top:8px; padding-left:5px; color:#666;">Classified Ads</div>
			<div style="float:right;">
            <a href="classified" class="btn "><b>View</b></a>
            <a href="classified_draft" class="btn green"><b>Draft</b></a>
            <a href="classified_my_post" class="btn"><b>My Post</b></a>
            <a href="classified_select_category" class="btn"><b>Post Classified</b></a>
            </div>
            </div>
            
           
             
            <!--<div style="padding:10px;">
            <a href="classified" <?php if(empty($cat)) { ?>class="btn green" <?php } if(!empty($cat)) {?>class="btn" <?php } ?>>All</a>
			<?php
			


				foreach ($result_classified_draft as $collection)
				{
				$category_id=$collection['master_classified_category']['category_id'];
				$category_name=$collection['master_classified_category']['category_name'];

			?>
			<a href="classified?cat=<?php echo $category_id; ?>" <?php if($cat!=$category_id) { ?> class="btn" <?php } ?> <?php if($cat==$category_id) { ?>class="btn green"<?php } ?>><?php echo $category_name; ?></a>
			<?php } ?>
            </div> --> 
			
            <div style="overflow:auto; padding-top:5px;" >
            <span style="float:right;"><input type="text" placeholder="Search" name="serch" id="ser_text" class="span11 m-wrap"></span>
            </div>
                
            
            
            
        <?php 
       
		
        foreach ($resut_cat as $collection)
        { 
			$date = $collection['classified']['classified_date'];
			$current_date=date("d-m-Y");
			$auto_id=$collection['classified']['classified_id'];
			$price=$collection['classified']['classified_price'];
			$price_type = $collection['classified']['classified_price_type'];
			$valid_date=$collection['classified']['classified_offer_up_to_date'];
			$da_user_id = (int)$collection['classified']['user_id'];
			$da_society_id = (int)$collection['classified']['society_id'];
			$path=$collection['classified']['classified_attachment'];
			$classified_type_ad = @$collection['classified']['classified_type_ad'];
			$classified_condition = @$collection['classified']['classified_condition'];
			if($classified_type_ad==1)
			 { 
			 $classified_type_ad="Sell"; 
			 } 
			 else
			{
				 $classified_type_ad="Buy";
			 }
			 if($classified_condition==1)
			 { 
			 $classified_condition="Used"; 
			 } 
			 else
			{
				 $classified_condition="New";
			 }
			if(empty($path))
			{
				$path = "classified_images.png";
			}
			
			if($price_type==1) { $price_type_name="Negotiable"; }
			if($price_type==2) { $price_type_name="Fixed"; }
			
		$title=$collection['classified']['classified_title'];
        $description_ad=$collection['classified']['classified_description'];
        $photo ='	 <img src="classified_photos/'.$path.'" style="width:150px; height:100px;" >';
        $photo2 ='	 <img src="classified_photos/'.$path.'" style="width:500px; height:400px;" >';	  
        $main_category=(int)$collection['classified']['classified_post_category_id'];
        $sub_category=(int)$collection['classified']['classified_post_sub_category_id'];	
        
$main_category_name = $this->requestAction(array('controller' => 'hms', 'action' => 'main_classified_category_name'),array('pass'=>array($main_category)));
$res = $this->requestAction(array('controller' => 'hms', 'action' => 'master_classified_subcategory'),array('pass'=>array($sub_category)));

foreach ($res as $collection)
        {
        $sub_category_name=$collection['master_classified_subcategory']['subcategory_name'];
        }
		?>
			
            <div style="float:left; width:50%; ">
            <div style="padding:10px;" >
			<div class="perple">
            <table  width="100%" style="background-color:#F4F4F4; box-shadow: 2px 2px 10px 1px #787878; " cellpadding="2px;" cellspacing="2px;">
            <tr>
    		<td width="30%" rowspan="8" valign="top"><img src="<?php echo $this->webroot ; ?>/classified_photos/<?php echo $path; ?>" style="height:150px; width:100%;"></td>
    		<td width=""><b>Title:</b> <?php echo $title; ?> </td>
  			</tr>
  			<tr>
    		<td><b>Category :</b><?php echo $main_category_name.'/'.$sub_category_name; ?></td>
  			</tr>
 			<tr>
   			<td><b>Offer up To :</b> <?php echo $valid_date; ?></td>
 			</tr>
  			<tr>
   			<td><b>Date :</b> <?php echo $date; ?></td>
  			</tr>
             <tr>
   			<td><b>Type of Ad :</b> <?php echo $classified_type_ad; ?></td>
  			</tr>
             <tr>
   			<td><b>Condition:</b> <?php echo $classified_condition; ?></td>
  			</tr>
            <tr>
            <td><span style="font-size:16px;"><b>Rs:</b> <?php echo $price; ?></span> (<?php echo $price_type_name; ?>)</td>
  			</tr>
            <tr>
   			<td align="right">
            <a href="classified_post_draft_edit?e=<?php echo $auto_id; ?>" class="btn mini"  style="border:solid 2px #999;" >Edit</a>
           <!-- <a href="classified_detail.php?con=<?php //echo $auto_id; ?>" class="btn mini"  style="border:solid 2px #999;" >View Detail</a>-->
            </td>
  			</tr>
            </table>
			</div>
            </div>
            </div>
			
			
  <?php } ?>   
            
				
                
                
             
                
               
				
                
			<!-- END PAGE CONTENT-->
		</div>
			<!-- END PAGE CONTAINER-->	
		</div>