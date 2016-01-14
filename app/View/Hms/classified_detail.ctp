<div style=" background-color:#EFEFEF; overflow:auto; padding-top:2px;">
            <div style="float:left; font-size:24px; padding-top:8px; padding-left:5px; color:#666;">Classified Ads</div>
			<div style="float:right;">
            <a href="classified" class="btn green"><b>View</b></a>
            <a href="classified_draft" class="btn"><b>Draft</b></a>
            <a href="classified_my_post" class="btn"><b>My Post</b></a>
            <a href="classified_select_category" class="btn"><b>Post Classified</b></a>
            </div>
            </div>
            
        <?php    
       
        foreach ($result_cate as $collection)
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
			$classified_description=$collection['classified']['classified_description'];
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
        $main_category=(int)$collection['classified']['classified_post_category_id'];
        $sub_category=(int)$collection['classified']['classified_post_sub_category_id'];	
        $main_category_name = $this->requestAction(array('controller' => 'hms', 'action' => 'main_classified_category_name'),array('pass'=>array($main_category)));
		$res = $this->requestAction(array('controller' => 'hms', 'action' => 'master_classified_subcategory'),array('pass'=>array($sub_category)));
       
        foreach ($res as $collection)
        {
        $sub_category_name=$collection['master_classified_subcategory']['subcategory_name'];
        }
		}
$res_user = $this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($da_user_id)));		
		 foreach ($res_user as $collection)   
              	 {
			      $email = $collection['user']['email'];
		
				 }
		
		?>
           
		   <div style="padding:20px;">
           <div style="border:solid 2px #35aa47;">
             <table width="100%"   style="font-size:18px;" height="100%">
               <tr >
                 <td width="40%" valign="top" style="padding:20px;"><img src="<?php echo $this->webroot ; ?>/classified_photos/<?php echo $path; ?>" style="height:400px; width:100%;"></td>
                 <td valign="top" style="padding-top:20px; padding-right:20px;">
                   <table class="table table-striped table-hover" width="100%" cellpadding="5px;">
                     <tr>
                       <td width="30%" ><b>Title:</b></td>
                       <td width="70%"><?php echo $title; ?></td>
                     </tr>
                     <tr>
                       <td><b>Category:</b></td>
                       <td><?php echo $main_category_name.'/'.$sub_category_name; ?></td>
                     </tr>
                     <tr>
                       <td><b>Offer up To:</b></td>
                       <td><?php echo $valid_date; ?></td>
                     </tr>
                     <tr>
                       <td><b>Date:</b></td>
                       <td><?php echo $date; ?></td>
                     </tr>
                        <tr>
                        <td><b>Type of Ad :</b></td><td> <?php echo $classified_type_ad; ?></td>
                        </tr>
                        <tr>
   			<td><b>Condition:</b> </td><td> <?php echo $classified_condition; ?></td>
  			</tr>
                     <tr>
                       <td><b>Rs:</b></td>
                       <td><?php echo $price; ?></span> (<?php echo $price_type_name; ?>)</td>
                     </tr>
                     <tr>
                       <td valign="top"><b>Description:</b></td>
                       <td><?php echo $classified_description; ?></td>
                       
                     </tr>
                     <tr>
                   </table>
                 <div><a href="mail_post_ad?r=<?php echo $email; ?>&con=<?php echo $title; ?>" class="btn blue" >Interested</a> </div> 
                 </td>
                 
               </tr>
             </table>
           </div>
           </div>
          
			<!-- END PAGE CONTENT-->
		</div>