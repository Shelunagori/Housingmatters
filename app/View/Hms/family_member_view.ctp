<script>
$(document).ready(function(){
$(".add").bind("click",function(){

var c=$('#hid').val();

c++;

 $("table.table_1").append("<tr id=tab"+c+"><td width='20%'><input type='text'  class='span12 m-wrap ' name='name"+c+"' id='name"+c+"'  style='font-size:16px;' placeholder='Name*'></td><td width='20%'><input type='text'  class='span12 m-wrap' name='email"+c+"' id='email"+c+"' style='font-size:16px;' placeholder='Email Address'></td><td width='10%'><input type='text'  class='span12 m-wrap' name='mobile"+c+"' id='mobile"+c+"' style='font-size:16px;' placeholder='Mobile No' maxlength='10'></td><td width='5%'><input type='text'  class='span12 m-wrap' name='dob"+c+"' id='dob"+c+"' style='font-size:16px;' maxlength='2' placeholder='Age'></td><td width='10%'><select class=' span12 m-wrap '  name='blood_group"+c+"'  id='blood_group"+c+"'><option value='' style='display:none;'>Blood Group</option><option value='1'>  A+ </option><option value='2'>  B+</option><option value='3'>  AB+  </option><option value='4'>  O+  </option></option><option value='5'>  A- </option><option value='6'>  B-</option><option value='7'>  AB-  </option><option value='8'>  O-  </option></select></td><td width='25%'><input type='text'  class='span8 m-wrap' name='relation"+c+"' id='relation"+c+"' style='font-size:16px;' placeholder='Relationship'></td></tr>");
$('#hid').val(c);

});
$(".rem").bind("click",function(){
var c=$('#hid').val();
if(c!=1)
{
$('#tab'+c).remove();
c--;
$('#hid').val(c);
}
});
});




</script>
<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->		
						<h3 style="color:#999;">Family Member</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>

<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											<li class=""><a href="profile" rel='tab' >Basic</a></li>
											<li class="active"><a href="family_member_view" rel='tab' >Family Member</a></li>
										</ul>
										<div class="tab-content">
										<br>
										<div id="error_msg"></div>
										<br>
										
			<div>
			<form method="post" id="contact-form">
			
	<input type="hidden" value="1" id="hid" name="hid_id">
	<table class="table_1" width="100%" >
	<tr >
	<td  width="20%">
	
	<input type="text"   class="span12 m-wrap" name="name1" id="name1" style="font-size:16px;" placeholder="Name*" value="<?php echo @$nam; ?>" >
	
	
	</td>
	
	<td width="20%" > 


<input type="text" class=" span12 m-wrap" placeholder="Email Address"  id="email1" style="font-size:16px;" name="email1" >
<div id="echo_exit"></div>


</td>

<td width="10%" > 
<input type="text"   class="span12 m-wrap" placeholder="Mobile No"style="font-size:16px;" id="mobile1" maxlength="10" name="mobile1" >


</td>
	
	
	<td width="5%" >

                             
                            
							 
 <input class=" span12 m-wrap "  type="text" value="" maxlength='2' name="dob1" placeholder="Age" id="dob1">
                              
                        
 </td>
	
	
	
	<td width="10%" > 

<select class=" span12 m-wrap "placeholder=" Blood Group" name="blood_group1" id="blood_group1">
<option value="" style="display:none;">Blood group</option>
<option value="1">  A+ </option>
<option value="2">  B+ </option>
<option value="3">  AB+  </option>
<option value="4">  O+  </option>
<option value="5">  A- </option>
<option value="6">  B- </option>
<option value="7">  AB-  </option>
<option value="8">  O-  </option>
</select>



 </td>
 
 <td width="25%" >

                                 <input class="span8 m-wrap " type="text" value="" name="relation1" placeholder="Relationship" id='relation1'>
                       
 </td>
	
	</tr>
			
	
			

										
										
										
		
	</table>
<div class="form-actions">
<button type="submit" class="btn blue" name="flat_add">Submit</button>
<button type="button"  class="btn blue add"> <i class="icon-plus"></i> Add Row</button>
<button type="button" id="button_remove " class="btn red rem"> <i class=" icon-remove "></i>Delete Row</button>
</div>	
		</form>
		</div>
										
										
						<div id="show"></div>				
										
									<div style="width:100%;">	
										<table width="100%" class="table  table-bordered" id="sample_2">
<thead>                                               
											   <tr>
												<td>Sr.no</td>
												<td>Name</td>
												<td>Flat</td>
												<td>Mobile</td>
												<td>Email</td>
												<td>Relation</td>
												<td>Age</td>
												<td>Blood Group</td>
												<td>Action</td>
												</tr>
												</thead>
<tbody>

												<?php
												$i=0;
												
											foreach($result_user as $data)
											{
												
												$i++;
												$user_name=$data['user']['user_name'];
												$user_id=$data['user']['user_id'];
												$mobile=$data['user']['mobile'];
												$email=$data['user']['email'];
												$dob=$data['user']['dob'];
												$relation=$data['user']['relation'];
												@$blood_group=$data['user']['blood_group'];
												$wing=(int)$data['user']['wing'];
												$flat = (int)$data['user']['flat'];
												$flat_wing = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));				  
													if($blood_group==1)
													{
													$b_group="A+";
													}
													if($blood_group==2)
													{
													$b_group="B+";
													}
													if($blood_group==3)
													{
													$b_group="AB+";
													}
													if($blood_group==4)
													{
													$b_group="O+";
													}
													
													if($blood_group==5)
													{
													$b_group="A-";
													}
													if($blood_group==6)
													{
													$b_group="B-";
													}
													if($blood_group==7)
													{
													$b_group="AB-";
													}
													if($blood_group==8)
													{
													$b_group="O-";
													}
												?>
												<tr>
												
												<td><?php echo $i ; ?></td>
												<td><?php echo $user_name ; ?></td>
												<td><?php echo $flat_wing ; ?></td>
												<td><?php echo $mobile ; ?></td>
												<td><?php echo $email ; ?></td>
												<td><?php echo $relation; ?></td>
												<td><?php echo $dob; ?></td>
												<td><?php echo @$b_group; ?></td>
                                <td>
								

										<div class="btn-group">
										<a class="btn mini blue" href="#" data-toggle="dropdown">
										Action

										</a>
										<ul class="dropdown-menu">
										<li><a href="family_member_add_ajax?con=<?php echo $user_id ; ?>" ><i class="icon-pencil"></i> Edit</a></li>

										<li><a href="#1" role="button" class="dec" atid="<?php echo $user_id ; ?>" ><i class="icon-trash"></i> Deactive</a></li>
										</ul>
										</div>

								
								</td>
												</tr>
									  <?php } ?>
												</tbody>
												</table>
												</div>
										<br><br>
										</div>
										</div>
										
										
</div>	





<script>

$(document).ready(function() { 
	$('form').submit( function(ev){
	
	ev.preventDefault();
	
	var hidden=$('#hid').val();
	var ar = [];
	
	for(var i=1;i<=hidden;i++)
	{
	
		var n=$("#name"+i).val();
		var e=$("#email"+i).val();
		var m=$("#mobile"+i).val();
	    var d=$("#dob"+i).val();
		var b=$("#blood_group"+i).val();
		var r=$("#relation"+i).val();
	   
	   ar.push([n,d,b,r,e,m]);
		var myJsonString = JSON.stringify(ar);
	}
	$.ajax({
			url: "family_member_valid?q="+myJsonString,
			dataType:'json',
			}).done(function(response) {
			
				if(response.type == 'error'){  
					output = '<div class="alert alert-error">'+response.text+'</div>';
					$("#submit").removeClass("disabled").text("submit");
					$("html, body").animate({
					 scrollTop:0
					 },"slow");
				}
				else{
				   					
				output ='<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;">'+response.text+' </div><div class="modal-footer"><a href="family_member_view" class="btn blue" id="yes">ok</a></div></div></div>';
					
			}
			if(response.type == 'sucess')
			{
			output ='<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;">'+response.text+' </div><div class="modal-footer"><a href="family_member_view" class="btn blue" id="yes">ok</a></div></div></div>';
					
			}
				
				
				$("#error_msg").html(output);
				
			});
	
	
	
	});
	});


</script>	


<script>
$(document).ready(function(){
$(".dec").live("click",function(){

var d_id=$(this).attr("atid");

$("#show").html('<div id="pp"><div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Are you sure you want to deactive family members ? </div><div class="modal-footer"><a href="family_member_deactive?con='+d_id+'" class="btn blue" id="yes">Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div></div>');

$("#can").live("click",function(){
$("#pp").hide();

});

});


});

</script>								