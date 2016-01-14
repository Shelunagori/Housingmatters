<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Setup
</div>

<div class="tabbable tabbable-custom">
    <ul class="nav nav-tabs">
    <li><a href="master_sm_wing" > Wing</a></li>
    <li><a href="flat_type" >Flat Type</a></li>
    <li class="active"><a href="flat_area" >Flat Area</a></li>
    <li><a href="master_sm_flat" >Flat No.</a></li>
	 <li><a href="content_moderation" >Banned Words</a></li>
    </ul>
    <div class="tab-content" style="min-height:300px;">
    <div class="tab-pane active" id="tab_1_1">
    
    
<div class="portlet box" style="width:80%;">
<?php /////////////////////////////////////////////////////////////////////////////////////////// ?>
  <div class="portlet-body" style="float:right; width:70%;" align="center">
	<form method="post">
    <table border="0">
    <tr>				
    <td>                
     <select name="flat_type" class="m-wrap medium" onchange="flat_area(this.value)">               
     <option value="">--SELECT FLAT TYPE--</option>            
     <?php
	 foreach($cursor1 as $collection)
	 {
    $auto_id = (int)$collection['flat_type']['auto_id'];		 
	$flat_type = $collection['flat_type']['flat_name'];
	$number_of_Flat = (int)$collection['flat_type']['number_of_flat'];	 
     ?>  
       <option value="<?php echo $auto_id; ?>"><?php echo $flat_type; ?></option> 
       <?php } ?> 
        </select>
        </td>
        </tr>            
        </table>       
        <div id="result" style="width:100%;">
        
        </div> 
                          
    </form>                
	</div>                  
<?php //////////////////////////////////////////////////////////////////////////////////////////// ?>
</div>
    
  
    </div>
   
    </div>
	
	
   <script>
$(document).ready(function(){
		$('#contact-form').validate({
	    rules: {
	      wing_name: {
	       
	        required: true,
			maxlength: 4,
			remote:"master_sm_wing_ajax"
			
	      }		  
	    },
		 messages: {
	                wing_name: {
	                    maxlength: "Please Maximum 4 characters.",
						 remote: "Wing Name is Already Exists."
						 
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
<script>
function flat_area(g)
{
$("#result").html('<div align="center" style="padding:10px;"><img src="as/loding.gif" />Loading....</div>').load("flat_area_ajax?con=" +g+ "");




}

</script>	