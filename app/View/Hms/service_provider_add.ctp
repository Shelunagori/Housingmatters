<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<div align="center">
<a href="service_provider_view" class="btn blue"> View</a>
<a href="service_provider_add" class="btn red"> Add</a>
</div>

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

   function service_provider_amc(c1)
		  {
		    if(xobj)
			 {
			 var query="?con=" + c1;
			 if(c1==2)
			 {
			 document.getElementById("zzz").disabled=true;
			  document.getElementById("xxx").disabled=true;
			   document.getElementById("zzz").value="";
			   document.getElementById("xxx").value="";
			   
			 }
			  if(c1==1)
			 {
			 document.getElementById("zzz").disabled=false;
			  document.getElementById("xxx").disabled=false;
			 }
			// xobj.open("GET","service_provider_amc_ajax.php" +query,true);
			// xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("amc_vendor").innerHTML=xobj.responseText;
			   }
			  }
			 }
			 xobj.send(null);
		  }
 </script>                


<div class="row-fluid">
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >
              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                 		 <div class="portlet box green">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i> Service Provider Registration Form</h4>
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form" class="form-horizontal" method="post" enctype="multipart/form-data">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" > Name of Service Provider</label>
                                 <input type="text" class="span8 m-wrap"  name="name">
                              </div>
                           </div>
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Name of Contact Person </label>
                                <input type="text" class="span8 m-wrap"  name="person">
                              </div>
                           </div>
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Mobile</label>
                                 <input type="text" class="span8 m-wrap" name="mobile">
                              </div>
                           </div>
                           
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Email</label>
                                 <input type="text" class="span8 m-wrap" name="email">
                              </div>
                           </div>
                           
                           
                           <div class="control-group ">
                              <div class="controls">
                              <label class="" style="font-size:14px;">Attachment</label>
                                 <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden">
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"></span>
                                       </div>
                                       <span class="btn btn-file">
                                       <span class="fileupload-new">Select file</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file"  class="span8 m-wrap" name="file" multiple >
                                       </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                          
                          
                          <div class="control-group">
                           <div class="controls">
                              <label class="" style="font-size:14px;" >Contract Type</label>
                             
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span><input type="radio" name="amc" value="1" checked  onClick="service_provider_amc(1)"></span></div>
                                 AMC
                                 </label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span><input type="radio" name="amc" class="act" onClick="service_provider_amc(2)" value="2" ></span></div>
                                 Adhoc
                                 </label>  
                               
                              </div>
                           </div>
                            <div id="amc_vendor">
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Contract start Period</label>
                                 <input type="text" class="span8 m-wrap date-picker act" data-date-format="dd-mm-yyyy" id="zzz" name="cont_start">
                              </div>
                           </div>
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Contract end Period</label>
                                 <input type="text" class="span8 m-wrap date-picker act" data-date-format="dd-mm-yyyy" id="xxx" name="cont_end">
                              </div>
                           </div>
                          
                          </div>
                         
                       <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Category </label>
                               <table>
                                 <?php  
                
				$i=2;
				foreach ($result_help_desk_category as $collection)
				{ 
				$i++;
				$id=$collection['help_desk_category']['help_desk_category_id'];
				$servies=$collection['help_desk_category']['help_desk_category_name'];
           		if($i%3==0)
				{ ?>          
                      <tr> <td>  <input type="checkbox" name="<?php echo $id; ?>" value="<?php echo $id; ?>" ><?php echo $servies; ?> </td><?php } ?>
                <?php  if($i%3==1)
				 { ?> <td><input type="checkbox" name="<?php echo $id; ?>" value="<?php echo $id; ?>" ><?php echo $servies; ?> </td><?php } ?>    
                 <?php if($i%3==2)
				 { ?>  <td><input type="checkbox" name="<?php echo $id; ?>" value="<?php echo $id; ?>" ><?php echo $servies; ?> </td> </tr><?php } } ?>     
                             
                             </table> </div>
                           </div>
                           
                           <div class="form-actions">
                              <input type="submit" class="btn green" value="Submit" name="sub">
                           </div>
                           </fieldset>
                        </form>
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            
            
            
            
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
	       
	        required: true,
			email:true
	      },
		    person: {
	       
	        required: true
	      },
		    cont_start: {
	       
	        required: true
	      },
		   cont_end: {
	       
	        required: true
	      }
	    },
		
		messages: {
			mobile: {
				maxlength: "Please enter 10 digits only"
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