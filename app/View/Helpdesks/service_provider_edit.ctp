<div>
<a href='<?php echo $this->webroot;?>/Helpdesks/service_provider_view' role='button' rel='tab' class='btn blue'>Back</a>
</div>
<?php 
foreach ($result_sp as $collection) 
                {
                $name=@$collection['service_provider']['sp_name'];
                $attachment=@$collection['service_provider']['sp_attachment'];
                $mobile=@$collection['service_provider']['sp_mobile'];
                $Contract_start=@$collection['service_provider']['sp_cont_start'];
                $Contract_end=@$collection['service_provider']['sp_cont_end'];
                $contrect_person=@$collection['service_provider']['sp_person'];
                $email=@$collection['service_provider']['sp_email'];
                $Contract_type=@$collection['service_provider']['sp_contract_type'];
                $pan_number = @$collection['service_provider']['pan_number']; 
				}
?>



<div class="container-fluid">

				<!-- BEGIN PAGE HEADER-->
				
			
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div style="width:70%; margin-left:15%;">
                        <div class="row-fluid"  >

              			 <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                 		 <div class="portlet box green">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i> Service provider Edit</h4>
                        
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Vendor Name</label>
                                 <input type="text" id="name" class="span8 m-wrap"  name="name" value="<?php echo $name ;?>" >                               <label id="name" ></label>
                              </div>
                           </div>
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Name of Person </label>
                                <input id="prson" type="text" class="span8 m-wrap"  name="person" value="<?php echo $contrect_person ; ?>" >
                                <label id="prson"></label>
                              </div>
                           </div>
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               
                               <div class="span4">
                               <label class="" style="font-size:14px;" >Mobile</label>
                                 <input type="text" class="span8 m-wrap" name="mobile" maxlength="10" value="<?php echo $mobile ;?>" id="mobil">
                                  <label id="mobil"></label>
                               </div>                            
                            <div class="span6">
                            <label class="" style="font-size:14px;" >PAN Number</label>
                            <input type="text" class="span7 m-wrap" id='pan' name="pan_no" maxlength="10" value="<?php echo $pan_number; ?>">
                            <label id="pan"></label>
                            </div>
                              </div>
                           </div>
                           
                          
                           
                            <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Email</label>
                                 <input type="text" class="span8 m-wrap" name="email" value="<?php echo $email ; ?>" id="mail">
                                  <label id="mail"></label>
                              </div>
                           </div>
                           
                           
                           <div class="control-group ">
                              <div class="controls">
                              <label class="" style="font-size:14px;">Attachment</label>
                                 <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" >
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                                                        

                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"> <?php echo $attachment ; ?></span>
                                         
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
                                 <div class="radio" ><span><input type="radio" id="amc"  name="amc" value="1"  <?php if($Contract_type == "AMC") { ?> checked= "checked" <?php } ?> ></span></div>
                                 AMC
                                 </label>
                                 <label class="radio">
                                 <div class="radio" id="uniform-undefined"><span><input type="radio" id="adhoc" name="amc"  value="2"  <?php if($Contract_type == "Adhoc") { ?> checked= "checked" <?php } ?> ></span></div>
                                 Adhoc
                                 </label>  
                               
                              </div>
                           </div >
                           <div >
                           
                           <div class="control-group text_box" style="display:none;">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Contract start Period</label>
                      <input type="text" class="span8 m-wrap date-picker" data-date-format="dd-mm-yyyy"  name="cont_start" value="<?php echo $Contract_start; ?>" id="xxx">
                      <label id="xxx"></label>
                              </div>
                           </div>
                           
                            <div class="control-group text_box " style="display:none;">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Contract end Period</label>
                                 <input type="text" class="span8 m-wrap date-picker" data-date-format="dd-mm-yyyy"  name="cont_end"  value="<?php echo $Contract_end ;?>" id="yyy">
                                 <label id="yyy"></label> <label id="end_d"></label>
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
				foreach($vvndrr as $data)
				{
				$cat_id = $data['vendor']['category_id'];
				if($cat_id == $id)
				{
				$mm = 555;
				break;	
				}
				else
				{
				$mm = 5;	
				}
				}
           		if($i%3==0)
				{ ?>          
                      <tr> <td>  <input type="checkbox" class="requirecheck1" id="requirecheck1" name="<?php echo $id; ?>" value="<?php echo $id; ?>" <?php if(@$mm == 555) { ?> checked="checked" <?php } ?>><?php echo $servies; ?> </td><?php } ?>
                <?php  if($i%3==1)
				 { ?> <td><input type="checkbox" class="requirecheck1" id="requirecheck1" name="<?php echo $id; ?>" value="<?php echo $id; ?>" <?php if(@$mm == 555) { ?> checked="checked" <?php } ?> ><?php echo $servies; ?> </td><?php } ?>    
                 <?php if($i%3==2)
				 { ?>  <td><input type="checkbox" class="requirecheck1" id="requirecheck1" name="<?php echo $id; ?>" value="<?php echo $id; ?>" <?php if(@$mm == 555) { ?> checked="checked" <?php } ?> ><?php echo $servies; ?> </td> </tr><?php } } ?>     
                             
                             </table> <label id="requirecheck1" ></label> </div>
                           </div>
                           </div>
                       
                           <div class="form-actions">
                              <input type="submit" class="btn green" value="Update" name="sub">
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
				<!-- END PAGE CONTENT-->
			</div>
			
			
<script>

function validateForm() {

var startDate = $('#xxx').val(); 
var enddate = $('#yyy').val(); 

if(startDate.split('-').reverse().join('') <= enddate.split('-').reverse().join('')){
	  document.getElementById("end_d").innerHTML="";
}else{
	document.getElementById("end_d").innerHTML = "<span style='color:red;'>Contract end date should be > than start date </span>";

	return false;
}  
}


 $(document).ready(function() {
 $("#amc").live('click',function(){
   $('.text_box').show();
});
$("#adhoc").live('click',function(){
   $('.text_box').hide();
});
});
 </script>
 
  <script>
$.validator.addMethod('requirecheck1', function (value, element) {
	 return $('.requirecheck1:checked').size() > 0;
}, 'Please check at least one category.');

$.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Only enter alphanumeric letters.");

	
$(document).ready(function(){
var checkboxes = $('.requirecheck1');
			var checkbox_names = $.map(checkboxes, function(e, i) {
				return $(e).attr("name")
			}).join(" ");

		$('#contact-form').validate({
		 errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	     groups: {
            asdfg: checkbox_names
			
        },
	
		rules: {
	      name: {
	       required: true
	      },
		  mobile: {
	       
	        //required: true,	
			number:true,
			minlength:10,
			maxlength:10
	      },
		   email: {
	       
	        //required: true,
			email:true
	      },
		    person: {
	       
	        //required: true
	      },
		  
		   pan_no: {
		   	   
	        //required: true
			loginRegex : true
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