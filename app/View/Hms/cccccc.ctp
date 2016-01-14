<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:2px; box-shadow:5px; font-size:16px; color:#006;">
     
                <table width="100%">
                <tbody><tr>
                <td width="58%" style="color:#A96363; font-size:24px; padding-left:10px;">Contact Handbook 
				<span class=" tooltips" data-placement="right" data-original-title="This list is maintained by your society members"><i class=" icon-info-sign"></i></span>
				 <span style="float:right;"><a href='contact_handbook_export'class=' green  btn' download='download'><i class='icon-download-alt'></i> Export</a></span>
				</td>
             
             <td width="" valign="bottom" style="padding-top:10px;padding-right: 2%;" align="right">
			 <div class="controls">
		
			 <a  onclick="blank_value();" href="javascript:ShowContactForm()" class=" btn blue" style="margin-bottom: 2%;" ><i class='icon-plus-sign'></i> Add New Contact </a>
			 <input type="text" placeholder="Search " class="span8" style="" id="get_search" onkeyup="search_record()"></div></td>
                </tr>
                </tbody></table>
                 </div>

<div style="float:left; width:68%;">

<style>
.r_d{
width:32%; float:left; padding:5px;
}

@media (min-width: 650px) and (max-width: 1200px){
.r_d{
width:46%;float:left; padding:5px;
}
}

@media (max-width: 650px) {
.r_d{
width:100%; float:left; padding:5px;
}
}

.hv_b{
background-color:rgb(218, 236, 240);
}
</style>
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

	  
	  function search_record()
		  {
		    if(xobj)
			 {	
			 
		     var c1=document.getElementById("get_search").value;
			 var query="?con=" + c1;
			
			 xobj.open("GET","contact_handbook_view_page" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("view_search").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }
		  
	</script>



<div id="all_dir">





<div id="view_search" >

 <?php
			foreach ($result_contact_handbook as $collection)            
			{  
				$c_h_id=$collection['contact_handbook']["c_h_id"];
				$mobile=$collection['contact_handbook']["c_h_mobile"];
				$user_id=(int)$collection['contact_handbook']['user_id'];
				$name=$collection['contact_handbook']["c_h_name"];
				$email=$collection['contact_handbook']["c_h_email"];
				$web=$collection['contact_handbook']["c_h_web"];
				$service=$collection['contact_handbook']["c_h_service"];
	@$result_user=$this->requestAction(array('controller' => 'hms', 'action' => 'profile_picture'),array('pass'=>array($user_id)));			  
		foreach($result_user as $data)
		{
			 $user_name=$data['user']['user_name'];

		}			
				
?>

<div class="r_d fadeleftsome" style="width:45%" >
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
<div style="float:left;margin-left:3%;"  >
<i class="icon-user"></i> <span style="font-size:16px;"><?php echo $name; ?></span><br/>
<i class="icon-phone-sign"></i> <span style="font-size:14px;"><?php echo $mobile ; ?></span><br/>
<i class="icon-envelope-alt"></i> <span style="font-size:14px;"><?php echo $email ; ?></span><br/>
<i class="icon-sitemap"></i> <span style="font-size:14px;"><a href='<?php echo $web ; ?>' target="_blank"> <?php echo $web ; ?></a></span><br/>
<i class=" icon-wrench"></i> <span style="font-size:14px;"><?php echo $service ; ?></span><br/>
<i class="icon-user"></i> <span class=" tooltips" data-placement="right" data-original-title="<?php echo $user_name ; ?>">Updated by:</span><br/> 
<div style="">
<?php
if($s_user_id==$user_id || $role_id==3)
{
?>
<span class="btn mini yellow " onclick="contact_add(<?php echo $c_h_id ; ?>,'<?php echo $mobile ; ?>','<?php echo $name ; ?>','<?php echo $email; ?>','<?php echo $web; ?>','<?php echo $service ; ?>');"><i class=' icon-edit'></i> edit </span> 
<?php } ?>
<?php
if($role_id==3)
{ ?>
<span ><a role='button' element_id='<?php echo $c_h_id ; ?>' class="btn mini con_delete red" > <i class="icon-trash"></i> Delete </a></span>
<?php } ?>
</div>
</div>
</div>
</div>
<?php 
}
?>
</div>
</div>


<div id="con_show" style="display:none;" >
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body" style="font-size:16px;">

</div> 
<div class="modal-footer">
<div id='new_create'>
<a href="contact_handbook" class="btn green">OK</a> 
</div>
<a href="#" role="button" id="can" class="btn">No</a>
</div>
</div>

</div>


<div id="view_dir" style="display:none;" class="fadeleftsome">

<br/><br/><div align="center" style="font-size:24px;"><img src="<?php echo $this->webroot ; ?>/as/loading.gif" height="50px" width="50px"/><br/>Please Wait</div>

</div>

<script>
$(document).ready(function() {
	$("#back").live('click',function(){
			$("#view_dir").hide();
			$("#all_dir").show();	
	});
});

</script>

<script>

function view_ticket(id)
{

	$(document).ready(function() {
				
				
				$( "#view_dir" ).load( 'contact_handbook_view_page?id=' + id , function() {
				
				  $("#all_dir").hide();
				 
				  $("#view_dir").show();
				});
		
		
		});
	
}

$(document).ready(function() {
$(".con_delete").click(function(){
 var t=$(this).attr('element_id');
  $("#con_show").show();
  $('#con_show').html('<div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:14px;"><i class="icon-warning-sign" style="color:#d84a38;"></i> Sure, you want to delete the contact handbook permanently ? </div><div class="modal-footer"><a href="contact_handbook_delete?con='+t+'" class="btn blue" >Yes</a><a href="#"  role="button" id="can" class="btn">No</a></div></div>');
   $("#can").live('click',function(){
   $('#con_show').hide();
});
 
});
});
</script>

</div>
<div style="float:right; display:none;" id="contact_hand">

<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					
				</div>
                
       
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid" >
					<div>
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
				  
                 		 <div class="portlet box blue " style="">
                     <div class="portlet-title" style="background-color: #7490BE;" >
                        <h4> Contact Handbook Registration</h4>
                        
                     </div>
                     <div class="portlet-body form " >
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form"  method="post" name="form" enctype="multipart/form-data" onSubmit="return validate();">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Name</label>
                                 <input type="text" class="span12 m-wrap"  name="name" id="na">
                              </div>
                           </div>
                          
                                 <input type="hidden" class="span12 m-wrap"  name="text_id" id="hid_id">
                           
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Mobile</label>
                                 <input type="text" class="span12 m-wrap" name="mobile" maxlength="10" id="mob">
                              </div>
                           </div>
						   
						     <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Email</label>
                                 <input type="text" class="span12 m-wrap" name="email" id="email_tex">
                              </div>
                           </div>
						   
						    <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Website</label>
                                 <input type="text" class="span12 m-wrap" name="web" id="web_tex">
                              </div>
                           </div>
						   
						    <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Services Provider</label>
                                 <input type="text" class="span12 m-wrap" name="service" id="ser_tex" >
                              </div>
                           </div>
                          <br/>
                                       <div class=""  >
                             <input type="submit" style="background-color: #7490BE;"  class="btn blue" value="Submit" name="sub"> 
							 <a   href="javascript:ShowContactcancel()" class=" btn " >Cancel </a> </div>
                           
                           </fieldset>
                        </form>
                        <!-- END FORM-->
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            
            
            
            
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			
<div>	
</div>
</div>		
			
			    <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      name: {
	       
	        required: true
	      },
		  mobile: {
	       
	        required: true,
			number:true,
			minlength:10,
			maxlength:10
	      },
		   email: {
	       
	        //required: true,
			email:true
	      },
		    address: {
	        required: true
	      },
		 
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


<script>
var contact_advertiser = false;
function ShowContactForm()
{
	if(!contact_advertiser)
	{
		document.getElementById("contact_hand").style.display="block";
		contact_advertiser = true;
	}
	else
	{
		document.getElementById("contact_hand").style.display="none";
		contact_advertiser = false;
	}
}
</script>

<script>
var contact_advertiser = false;
function ShowContactFormzzz()
{
	if(!contact_advertiser)
	{
		document.getElementById("contact_hand").style.display="block";
		contact_advertiser = false;
	}
	else
	{
		document.getElementById("contact_hand").style.display="none";
		contact_advertiser = false;
	}
}
</script>
<script>
var contact_advertiser = false;
function ShowContactcancel()
{
	if(!contact_advertiser)
	{
	
		document.getElementById("contact_hand").style.display="none";
		contact_advertiser = false;
	}
	else
	{
		document.getElementById("contact_hand").style.display="none";
		contact_advertiser = false;
	}
}
</script>


<script>
function contact_add(id,mobi,nam,email_ch,web_ch,service_ch)
{
document.getElementById("na").value=nam;
document.getElementById("mob").value=mobi;
document.getElementById("hid_id").value=id;
document.getElementById("email_tex").value=email_ch;
document.getElementById("web_tex").value=web_ch;
document.getElementById("ser_tex").value=service_ch;
ShowContactFormzzz();

}

function blank_value()
{
document.getElementById("na").value="";
document.getElementById("mob").value="";
document.getElementById("hid_id").value="";
document.getElementById("email_tex").value="";
document.getElementById("web_tex").value="";
document.getElementById("ser_tex").value="";
}
</script>
<script>
function show_tooltips()
{
$(document).ready(function() {
 jQuery('.tooltips').tooltip();
});
}
</script>
