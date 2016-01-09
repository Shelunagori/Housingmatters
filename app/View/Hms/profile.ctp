  


  <script type="text/javascript">
 var xobj;
   //modern browers
   if(window.XMLHttpRequest)
    {
	  xobj=new XMLHttpRequest();
	  }
	  //for ie
	  else if(window.ActiveXObject)
	   {
	    xobj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
		  alert("Your broweser doesnot support ajax");
		  }
	  function show_flat()
		  {
		    if(xobj)
			 {			
           var c1=document.getElementById("get_wing_id").value;
			 var query="?con=" + c1;
			
			 xobj.open("GET","profile_flat_ajax" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("view_flat").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }
		  
		   function check_public(c1)
		  {
		    if(xobj)
			 {			
			
			 var query="?con=" + c1;
			 xobj.open("GET","profile_check_private" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("show_public").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }
		 
		  </script>


<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
						<h3 style="color:#999;">User Profile</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				
                <?php
               				
          		foreach ($result_user as $collection)   
              	 {
					$c_email = $collection['user']['email'];
					$c_mobile = $collection['user']['mobile'];
					$medical_pro = @$collection['user']['medical_pro'];
					$c_name = $collection['user']['user_name'];
					@$profile_pic = $collection['user']['profile_pic'];
					@$f_profile_pic = $collection['user']['f_profile_pic'];
					@$g_profile_pic = $collection['user']['g_profile_pic'];
					$c_sex = (int)@$collection['user']['sex'];
					$c_wing_id = (int)$collection['user']['wing'];
					 $c_flat_id = (int)$collection['user']['flat'];
					$da_dob=@$collection['user']['dob'];
					$per_address=@$collection['user']['per_address'];
					$com_address=@$collection['user']['comm_address'];
					$hobbies=@$collection['user']['hobbies'];
					@$blood_group=@$collection['user']['blood_group'];
					$private_field=@$collection['user']['private'];
					$multi_flat=@$collection['user']['multiple_flat'];
					$contact_emergency3=@$collection['user']['contact_emergency'];
					
				 }
				  
$flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($c_wing_id,$c_flat_id)));				  
					$ccc=0;
									if(!empty($c_email))
									{
										$ccc++;
									}
									if(!empty($c_mobile))
									{
										$ccc++;
									}
									if(!empty($c_name))
									{
										$ccc++;
									}
									if(!empty($profile_pic))
									{
										$ccc++;
									}
									if(!empty($c_sex))
									{
										$ccc++;
									}
									/*if(!empty($c_wing_id))
									{
										$ccc++;
									}
									if(!empty($c_flat_id))
									{
										$ccc++;
									}*/
									if(!empty($da_dob))
									{
										$ccc++;
									}
									if(!empty($per_address))
									{
										$ccc++;
									}
									if(!empty($com_address))
									{
										$ccc++;
									}
									if(!empty($hobbies))
									{
										$ccc++;
									}
									if(!empty($contact_emergency3))
									{
										$ccc++;
									}
						//$progres=$ccc*100/11;
						$progres=$ccc*100/10;
				

?>
							<!-- BEGIN PORTLET-->
						
								
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											<li class="active"><a href="profile" rel='tab' >Basic</a></li>
											<li class=""><a href="family_member_view" rel='tab' >Family Member</a></li>
										</ul>
										<div class="tab-content">
										 
										
											    <div class="tab-pane active" id="tab_1_1">
												
												<form method="post" enctype="multipart/form-data" id="contact-form1"> 
												<table  width="100%">
                                                <tr>
                                                <td width="20%;" valign="top">
                                               <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->  
       
                            <div class="controls" style="width:100%;">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 80%; height: 150px;">
									<?php if(!empty($profile_pic) && $profile_pic!="blank.jpg"){ ?>
									 <img src="<?php echo $webroot_path; ?>profile/<?php echo $profile_pic; ?>" style="width:100%; height:200px;" alt="Profile Picture">
									<?php }
									elseif(!empty($f_profile_pic)){ ?>
										 <img src="<?php echo $f_profile_pic; ?>" style="width:100%; height:200px;" alt="Profile Picture">
									<?php }
									elseif(!empty($g_profile_pic)){ ?>
										 <img src="<?php echo $g_profile_pic; ?>" style="width:100%; height:200px;" alt="Profile Picture">
									<?php }
									else{ ?>
										 <img src="<?php echo $webroot_path; ?>profile/<?php echo $profile_pic; ?>" style="width:100%; height:200px;" alt="Profile Picture">
									<?php } ?>
                                      
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn btn-file mini black"><span class="fileupload-new">Change</span>
                                       <span class="fileupload-exists">Remove</span>
                                      
                                       <input type="file" class="default" name="profile_photo"></span>
                                      
                                                                          
                                     </div>
                                 </div>
                                
                            </div> 
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
  <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                                                
                                                </td>
                                                <td valign="top" width="80%">
                                                
							
							    <div class="portlet-body" style="padding-left:0%;">
								<div class="" id="accordion1" style="height: auto;">
									
									<div class="" style="border:solid 0px white;">
										<div class="" style="background-color:#FFFFFF; padding-left:10px;">
                                            <table width="100%">
                                            <tr>
                                            <td width="40%" style="font-size:14px; ">Name</td>
                                            <td width="60%">
											<input type="text" class="m-wrap" id="name" value="<?php echo $c_name;  ?>" name="name">
											<label id="name"></label>
											</td>
                                            </tr>
                                            </table>
											
										</div>
										
								<div class="portlet-body" style="padding-left:0%;">
								<div class="" id="accordion1" style="height: auto;">
									
									<div class="" style="border:solid 0px white;">
										<div class="" style="background-color:#FFFFFF; padding-left:10px;">
                                            <table width="100%">
                                            <tr>
                                            <td width="40%" style="font-size:14px;">Wing-Flat</td>
                                            <td width="60%">
											<?php if(!empty($multi_flat)) { ?>
											<select name='wing_flt'>
											<option style='display:none;'></option>
											<?php 
											foreach($multi_flat as $ds)
											{
											 
												$wing_id=$ds[0];
												$flat_id=$ds[1];
												$wing_flat1 = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));
											?>
											<option value='<?php echo $wing_id; ?>,<?php echo $flat_id ; ?>' <?php if($flat==$wing_flat1) { ?> selected <?php } ?>><?php echo $wing_flat1 ; ?> </option>
											<?php }  ?>
											</select> <?php } else { echo $flat ; } ?>
											<label id="name"></label>
											</td>
                                            </tr>
                                            </table>
											
										</div>
										
																			
									<div class="" style="border:solid 0px white;">
										<div class="" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%" >
                                        <tr>
                                        <td width="40%" style="font-size:14px; ">Mobile Number</td>
                                        <td width="40%"><input type="text" class="m-wrap" value="<?php echo $c_mobile; ?>" name="mobile1" maxlength="10"></td>
											<td width="15%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="mobile,0" >Public</option>
								    <option value="mobile,1"<?php if(@in_array('mobile',$private_field)) { ?> selected <?php } ?> >Private</option>
                                   
                                 </option></select>
                            
											
											<td>
                                        </tr>
                                        </table>
										</div>
										
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%" >
                                        <tr>
                                        <td width="40%" style="font-size:14px;"> Email-Id </td>
                                        <td width="40%"><input type="text" value="<?php echo $c_email;  ?>" class=" m-wrap" name="email">
											</td>
											<td width="15%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="email,0">Public</option>
								    <option value="email,1" <?php if(@in_array('email',$private_field)) { ?> selected <?php } ?>>Private</option>

                                 </option></select>
                            
											
											<td>
                                        </tr>
                                        </table>
										</div>
										
                                                </td>
                                                </tr>
                                                </table>
								
                                        <center>    
                                          <div>
                                <p style="font-size:20px; color:#666;">Other Information</p>
                                </div>
                                           </center>
 <!--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->      
                                            
                                            
                                            
                                <div class="accordion collapse in" id="accordion2" style="height: auto;">
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
                                            <table width="100%">
                                            <tbody><tr>
                                            <td width="55%" style="font-size:14px; color:#666; "><span style="margin-left:40%;">Gender</span></td>
                                           
                                            <td width="29%" >
											 <label class="radio">
                                        <input type="radio" name="sex" value="1" <?php if( @$c_sex == 0 ||  @$c_sex == 1) { ?>checked <?php } ?> >
                                          Male
                                          </label>
                                             <label class="radio">
                                          <input type="radio" name="sex" value="2" <?php if( @$c_sex == 2) { ?>checked <?php } ?>>
                                        Female
                                          </label>
												
											
											</td>
											<td width="12%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="sex,0">Public</option>
								    <option value="sex,1" <?php if(@in_array('sex',$private_field)) { ?> selected <?php } ?> >Private</option>
                                   
                                 </option></select>
                            
											
											<td>
                                            </tr>
                                            </tbody></table>
											
										</div>
										
									</div>
                                    
									
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%">
                                        <tbody><tr>
                                        <td width="55%"><span style="margin-left:40%; font-size:14px; color:#666;">Age Group </span></td>
                                       
                                        <td width="29%">
																  
										  
											<select class="m-wrap m-ctrl-medium " data-placeholder="Choose Age Group" name="age">
											<option value="" style="display:none;"></option>
											<option value="1"<?php if($da_dob==1){?>selected <?php } ?>> 18-24 </option>
											<option value="2" <?php if($da_dob==2){?>selected <?php } ?>> 25-34 </option>
											<option value="3"<?php if($da_dob==3){?>selected <?php } ?>> 35-44 </option>
											<option value="4"<?php if($da_dob==4){?>selected <?php } ?>> 45-54 </option>
											<option value="5" <?php if($da_dob==5){?>selected <?php } ?>> 55-64 </option>
											<option value="6" <?php if($da_dob==6){?>selected <?php } ?>> 65+</option>
											</select> 
										  
										  
										</td>
											
											<td width="12%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="date,0">Public</option>
								    <option value="date,1" <?php if(@in_array('date',$private_field)) { ?> selected <?php } ?>>Private</option>
                                   
                                 </option></select>
                            
											
											<td>
											
                                        </tr>
                                        </tbody></table>
										</div>
										
									</div>
									
									
									
									
									
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%">
                                        <tbody><tr>
                                        <td width="55%"><span style="margin-left:40%; font-size:14px; color:#666;">Contact number Emergency</span></td>
                                       
                                        <td width="29%">
																  
										  <input type="text" class="m-wrap valid" id="cont_emergency" value="<?php echo $contact_emergency3 ; ?>" name="contact_emergency1" maxlength="10">
											
										  
										  
										</td>
											
										<td width="12%">
										<div id="show_public"> </div>
										<select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
										<option value="contact_emergency,0">Public</option>
										<option value="contact_emergency,1" <?php if(@in_array('contact_emergency',$private_field)) { ?> selected <?php } ?>>Private</option>

										</option></select>


										<td>
											
                                        </tr>
                                        </tbody></table>
										</div>
										
									</div>
									
									
									
									
									
									
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%">
                                        <tbody><tr>
                                        <td width="55%"><span style="margin-left:40%; font-size:14px; color:#666;">Permanent address</span></td>
                                        
                                        <td width="29%">
										<textarea rows="5" cols="" name="per_address" class="m-wrap" style="resize:none;" ><?php echo $per_address; ?></textarea>
											</td>
											<td width="12%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="per_address,0">Public</option>
								    <option value="per_address,1" <?php if(@in_array('per_address',$private_field)) { ?> selected <?php } ?>>Private</option>
                                   
                                 </option></select>
                            
											
											<td>
											
											
                                        </tr>
                                        </tbody></table>
										</div>
										
									</div>
									
									
									
									
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%">
                                        <tbody><tr>
                                        <td width="55%"><span style="margin-left:40%; font-size:14px; color:#666;">Communication address</span></td>
                                       
                                        <td width="29%">
										 <textarea rows="5" cols="" name="com_address" class="m-wrap m-ctrl-medium" style="resize:none;" ><?php echo $com_address; ?></textarea>
											</td>
											<td width="12%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="com_address,0">Public</option>
								    <option value="com_address,1" <?php if(@in_array('com_address',$private_field)) { ?> selected <?php } ?>>Private</option>
                                   
                                 </option></select>
                            
											
											<td>
                                        </tr>
                                        </tbody></table>
										</div>
										
									</div>
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%">
                                        <tbody><tr>
                                        <td width="55%"><span style="margin-left:40%; font-size:14px; color:#666;">Hobbies:</span></td>
                                   
									<td width="29%">
									 <!--<input type="text" name="hob" class="m-wrap m-ctrl-medium " data-provide="typeahead" data-source="[<?php if(!empty($kendo_implode)) { echo $kendo_implode; } ?>]" value="<?php echo $hobbies ; ?>" data-items="4"> -->
									 
									 <select data-placeholder="select hobbies"  name="hob[]" id="multi" class="chosen span9" multiple="multiple" tabindex="6">
									 <?php
									foreach($hobbies_category as $data){
										
										$hobbies_id=$data['hobbies_category']['hobbies_id'];
										$hobbies_name=$data['hobbies_category']['hobbies_name'];
										 ?>
										 
									 <option value="<?php echo $hobbies_id; ?>" <?php if(@in_array($hobbies_id,$hobbies)) { ?> selected <?php } ?>><?php echo $hobbies_name; ?></option>
									 
									 <?php } ?>
									 </select>
									 
											
									</td>
											<td width="12%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="hobi,0">Public</option>
								    <option value="hobi,1" <?php if(@in_array('hobi',$private_field)) { ?> selected <?php } ?>>Private</option>
                                   
                                 </option></select>
                            
											
											<td>
											
                                        </tr>
                                        </tbody></table>
										</div>
										
									</div>
									
									
									
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
											<table width="100%">
                                        <tbody><tr>
                                        <td width="55%"><span style="margin-left:40%; font-size:14px; color:#666;">Blood Group:</span></td>
                                    
                                        <td width="29%">
										<div class="control-group">
										<div class="controls">
										<select class="m-wrap m-ctrl-medium chosen" data-placeholder="Choose A Blood Group" name="blood_group">
										<option value="" style="display:none;"></option>
										<option value="1" <?php if(@$blood_group==1){ ?> selected <?php } ?>>  A+ </option>
										<option value="2" <?php if(@$blood_group==2){ ?> selected <?php } ?>>  B+ </option>
										<option value="3" <?php if(@$blood_group==3){ ?> selected <?php } ?>>  AB+  </option>
										<option value="4" <?php if(@$blood_group==4){ ?> selected <?php } ?>>  O+  </option>
										<option value="5" <?php if(@$blood_group==5){ ?> selected <?php } ?>>  A- </option>
										<option value="6" <?php if(@$blood_group==6){ ?> selected <?php } ?>>  B- </option>
										<option value="7" <?php if(@$blood_group==7){ ?> selected <?php } ?>>  AB-  </option>
										<option value="8" <?php if(@$blood_group==8){ ?> selected <?php } ?>>  O-  </option>
										</select>
										</div>
										</div>
                                                
											</td>
											<td width="12%">
										<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="bl_g,0">Public</option>
								    <option value="bl_g,1" <?php if(@in_array('bl_g',$private_field)) { ?> selected <?php } ?>>Private</option>
                                   
                                 </option></select>
                            
											
											<td>
											
                                        </tr>
                                        </tbody></table>
										</div>
										
									</div>
									
									
									
									
									<div class="accordion-group" style="border:solid 0px white;">
										<div class="accordion-heading" style="background-color:#FFFFFF; padding-left:10px;">
                                            <table width="100%">
                                            <tbody><tr>
                                            <td width="55%" style="font-size:14px; color:#666; "><span style="margin-left:40%;">Are you a medical professional ?</span></td>
                                           
                                            <td width="29%">
											 <label class="radio">
                                        <div class="radio" id="uniform-undefined"><span class="checked"><input type="radio" name="medical" value="1"  style="opacity: 0;" <?php  if($medical_pro==1){ ?>checked="" <?php } ?>></span></div>
                                           Yes
                                          </label>
                                             <label class="radio">
                                          <div class="radio" id="uniform-undefined"><span><input type="radio" name="medical" value="2" style="opacity: 0;"<?php  if($medical_pro==2){ ?>checked="" <?php } ?> ></span></div>
                                         No
                                          </label>
												
											
											</td>
											<td width="12%">
										<!--<div id="show_public"> </div>
                                 <select class="span12 m-wrap" data-placeholder="Choose a Category" tabindex="1" name="sel_private" onchange="check_public(this.value)" id="check_id">
                                   <option value="sex,0">Public</option>
								    <option value="sex,1">Private</option>
                                   
                                 </select>
                            
											
											</td> --><td>
                                            </td></tr>
                                            </tbody></table>
											
										</div>
										
									</div>
									
									
									
									
									
									
									<br>
									
									<br>
									<div style='width:80%; margin-left:20%;'>
                                        
                                        <div><span style="color:blue;">Your profile completeness</span> <span style="margin-left:70%">
                                        <b><?php echo (int)$progres ; ?>% </b> </span> 
                                        <div id="bar" class="progress progress-success progress-striped" style="width:100%;">
                                        <div class="bar" style="width: <?php echo $progres ; ?>%;"></div>
                                        </div></div>
									</div>
									<br>
									<div class="form-actions" >
									
                              <button type="submit" class="btn blue" name="sub" style='margin-left:20%;'>Update</button> 
                              </form>  
                           </div>
								 	
									
								</div>
                                           
                                      
                                            </div>
                                            
											
										</div>
									</div>
									
									<!--END TABS-->
								</div>
								
							<!-- END PORTLET-->
						<!-- END ACCORDION PORTLET-->      
					</div>
<script>

$(document).ready(function(){
		$('#contact-form1').validate({
	    rules: {
	name: {
			required: true,
			
	      },

mobile1: {
			//required: true,
			number: true,
			minlength: 10,
			maxlength: 10,
			remote: "profile_mobile_check"
	      },
email: {
			//required: true,
			email : true,
			remote: "profile_email_check"
	      },

contact_emergency1: {
			number: true,
			minlength: 10,
			maxlength: 10,
			
	      },
		  
	    },
		
		messages: {
	                email: {
	                    remote: "Login-Id is Already Exist."
	                },
					 mobile1: {
	                    remote: "Mobile-No is Already Exist."
	                }
	            },
		
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

});


</script>					
					
					
