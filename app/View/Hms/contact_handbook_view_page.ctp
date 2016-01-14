
<?php
foreach($result_contact_handbook as $collection)            
			{  
				$c_h_id=$collection['contact_handbook']["c_h_id"];

				 $mobile=$collection['contact_handbook']["c_h_mobile"];
				$user_id=(int)$collection['contact_handbook']['user_id'];
				 $name=$collection['contact_handbook']["c_h_name"];
				 $email=$collection['contact_handbook']["c_h_email"];
				  $web=$collection['contact_handbook']["c_h_web"];
				   $service=$collection['contact_handbook']["c_h_service"];
					$service_name="";$result_contact_handbook_service='';
				if(!empty($service)){
				foreach($service as $data){
				$result_contact_handbook_service[]=$this->requestAction(array('controller' => 'hms', 'action' => 'contact_handbook_service'),array('pass'=>array($data)));	
				$service_name=implode(',',$result_contact_handbook_service);
				}
				}
	@$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));			  
		foreach($result_user as $data)
		{
			 $user_name=$data['user']['user_name'];

		}			


?>	
<div class="r_d fadeleftsome" style="width:45%" onmouseover="show_tooltips();" >
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
<div style="float:left;margin-left:3%;"  >

<i class="icon-user"></i> &nbsp; <span style="font-size:16px;"><?php echo $name; ?></span><br/>
 <i class=" icon-wrench"></i> &nbsp; <span style="font-size:14px;">Services : <?php echo $service_name ; ?></span><br/>
<i class="icon-phone-sign"></i> &nbsp; <span style="font-size:14px;"><?php echo $mobile ; ?></span><br/>
<i class="icon-envelope-alt"></i> &nbsp; <span style="font-size:14px;"><a style="text-decoration:blink" href="mailto:<?php echo $email ; ?>"><?php echo $email ; ?></a></span><br/>
<i class="icon-sitemap"></i> &nbsp; <span style="font-size:14px;"><?php echo $web ; ?></span><br/>
<i class="icon-user"></i> &nbsp; <span class="" data-placement="right" data-original-title="">Added by: <?php echo $user_name ; ?></span><br/> 
<div style="">
<?php
if($s_user_id==$user_id)
{
?>
<span class="btn mini yellow contact_edit" contact_id="<?php echo $c_h_id; ?>"><i class=' icon-edit'></i> </span> 
<?php } ?>
<?php 
if($s_user_id==$user_id)
{
?>
<span ><a href="contact_handbook_delete?con=<?php echo $c_h_id ; ?>" class="btn mini red" > <i class="icon-trash"></i> </a></span>
<?php } ?>
</div>
</div>
</div>
</div>
<?php 
}
if(empty($mobile) &&  empty($name))
				{ ?>
				<center><br><h4 style="color:#9F2D9F;"><b>No Record Found</b></h4></center>
			<?php	}

?>

