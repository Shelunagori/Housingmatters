 <?php
		
if($search_value >0)
	{	
		foreach ($result_yellow as $collection)            
			{  
				$yellowpage_id=$collection['yellow_registration']["yellowpage_id"];
				$website=$collection['yellow_registration']["yellowpage_website"];
				$mobile=$collection['yellow_registration']["yellowpage_mobile"];
				$path=$collection['yellow_registration']["yellowpage_attachment"];
				$address=$collection['yellow_registration']['yellowpage_address'];
				$ad=mb_strimwidth($address, 0, 30, "....");
				$category_id=$collection['yellow_registration']['yellowpage_category'];
				$name=$collection['yellow_registration']["yellowpage_name"];
				if(empty($path))
				{
				$path="blank.jpg"; 
				}
?>

<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $yellowpage_id;?>)">
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
<img src="<?php echo $this->webroot ; ?>/yellow_page_file/<?php echo $path; ?>" style="float:left;width:20%;height:60px;"/>
<div style="float:left;margin-left:3%;">
<i class="icon-user"></i> <span style="font-size:20px;"><?php echo $name; ?></span><br/>
<i class="icon-phone-sign"></i> <span style="font-size:16px;"><?php echo $mobile ; ?></span><br/>
<i class="icon-home"></i> <span style="font-size:16px;"><?php echo $ad ; ?></span><br/>
</div>
</div>
</div>


<?php 
}
if($count_yellow == 0)
				{ ?>
				<center><h4 style="color:#9F2D9F;"><b>No Record Found</b></h4></center>
			<?php	}



}
?>
</div>
</div>




 <?php
		
if($search_value==0)
	{	
		foreach ($result_ye_registration as $collection)            
			{  
				$yellowpage_id=$collection['yellow_registration']["yellowpage_id"];
				$website=$collection['yellow_registration']["yellowpage_website"];
				$mobile=$collection['yellow_registration']["yellowpage_mobile"];
				$path=$collection['yellow_registration']["yellowpage_attachment"];
				$address=$collection['yellow_registration']['yellowpage_address'];
				$ad=mb_strimwidth($address, 0, 30, "....");
				$category_id=$collection['yellow_registration']['yellowpage_category'];
				$name=$collection['yellow_registration']["yellowpage_name"];
				if(empty($path))
				{
				$path="blank.jpg"; 
				}
?>

<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $yellowpage_id;?>)">
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
<img src="<?php echo $this->webroot ; ?>/yellow_page_file/<?php echo $path; ?>" style="float:left;width:20%;height:60px;"/>
<div style="float:left;margin-left:3%;">
<i class="icon-user"></i> <span style="font-size:20px;"><?php echo $name; ?></span><br/>
<i class="icon-phone-sign"></i> <span style="font-size:16px;"><?php echo $mobile ; ?></span><br/>
<i class="icon-home"></i> <span style="font-size:16px;"><?php echo $ad ; ?></span><br/>
</div>
</div>
</div>


<?php 
}
}
?>
</div>
</div>



