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
		  
	
		  
		  function approve_reg_mail(c1,c2)
		  {
		    if(xobj)
			 {			
				var query="?con=" + c1;
				
			 xobj.open("GET","resident_approve_mail" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	 
			   document.getElementById("apz" + c2).innerHTML=xobj.responseText;
			   
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }
		  
		  
		
</script>
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid" style="padding:0px; ">
				<!-- BEGIN PAGE HEADER-->
                
    <!--POP UP BOX-->            
 <div id="show_div"></div>       

</div>
<!--END OF POP UP BOX-->   
               
             
               
                
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>
<script>
$(document).ready(function() {

$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<!--<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
              Approval
</div>-->
				
                <div class="portlet-body" style="padding:10px;";>
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											
                                            
										</ul>
										<div class="tab-content">
											
											<div class="tab-pane active" id="tab_1_2">
												
												
											<div class="portlet box ">
							
							<div class="portlet-body">
								<table class="table table-striped table-bordered" id="">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Name</th>
                                           <th>Date</th>

                                            <th>Unit</th>
                                            <th>Status</th>
                                            <th class="hidden-phone">Mobile</th>
                                            <th class="hidden-phone">Reply</th>
                                            <th class="hidden-phone">Approve</th>
                                            <th class="hidden-phone">Reject</th>
										</tr>
									</thead>
									<tbody>
                                   
<?php
									
/////////////////////////fetch data /////////////////////////////////


$i=0;
foreach ($result_user_temp as $collection) 
{ 

	 $user_id=(int)$collection['user_temp']['user_temp_id'];
	
	$user_name=$collection['user_temp']['user_name'];
	$date=$collection['user_temp']['date'];
	$mobile=$collection['user_temp']['mobile'];
	$email=$collection['user_temp']['email'];
	$password=$collection['user_temp']['password'];
	$wing=(int)$collection['user_temp']['wing'];
	$flat=(int)$collection['user_temp']['flat'];
	$tenant=(int)$collection['user_temp']['tenant'];
	if($tenant==2) { $status='Tenant'; }
	if($tenant==1) { $status='Owner'; }
	$i++;
 $wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));

?>
							<tr class="odd gradeX" id="apz<?php echo $i; ?>">
								<td><?php echo $i; ?></td>
								<td><?php echo $user_name; ?></td>
							   <td><?php echo $date; ?></td>
								<td><?php echo @$wing_flat; ?></td>
								 <td><?php echo $status; ?></td>
								<td><?php echo $mobile; ?></a></td>
								 <td><a href="#<?php echo $i; ?>" role="button" class="btn mini yellow" data-toggle="modal">Reply</a>



<!--POP UP BOX-->
<div id="<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none; " align="center">
<div class="modal-header">

<h3 id="myModalLabel2"><b>Reply</b></h3>
</div>
<div class="modal-body">
<div>

<table align="center">
<tr><td>To</td><td><?php echo $email; ?></td><input type="hidden" name="" id="em<?php echo $i; ?>" value="<?php echo $email; ?>"></tr>

<tr>
<td>Subject</td><td><input type="text" id="subject<?php echo $i; ?>" style="width:96%"></td></tr>
<tr>
<td>Message</td><td><textarea rows="7" cols="80" style="resize:none; width:300px;" id="texs<?php echo $i; ?>"></textarea></td></tr></table> </div>
</div>
<div class="modal-footer">
<button  data-dismiss="modal" onClick="reply_reg(<?php echo $i; ?>,<?php echo $user_id;?>)" class="btn green">Send Email</button>
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

</div>
</div>
<!--END OF POP UP BOX-->          
</td>


                                             
                                             

<td><a href="#ap<?php echo $i; ?>" role="button" class="btn mini green" data-toggle="modal"><i class="icon-ok"></i>Approve</a>



<!--POP UP BOX-->
<div id="ap<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none; " align="center">
<div class="modal-header">
</div>
<div class="modal-body" >
<div style="text-align:justify; font-size:16px;">
The request has been approved and the User has been notified.
</div>
</div>
<div class="modal-footer">
<button  data-dismiss="modal" onClick="approve_reg_mail(<?php echo $user_id;?>,<?php echo $i; ?>)" class="btn blue">Ok</button>
</div>
</div>
<!--END OF POP UP BOX-->          
</td>
<td><a href="#del<?php echo $i; ?>" class="btn mini red" data-toggle="modal"><i class=" icon-remove" ></i> Reject</a>
</td>
<!--popup start -->
<div id="del<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
<div class="modal-header" >
<h4 id="myModalLabel3"><b>Conformation</b></h4>
</div>
<div class="modal-body">
<span style="color:red;"><i class="icon-warning-sign"></i></span> &nbsp;<b style="font-size:16px; font-family:'Times New Roman', Times, serif;">Are you sure to Delete</b>
</div>
<div class="modal-footer">
<a href="resident_approve_reject?con=<?php echo $email; ?> &con1=<?php echo $user_id ;?>" role="button"  class="btn blue" >Yes</a>
<button class="btn " data-dismiss="modal" aria-hidden="true">No</button>
</div>
</div>
<!--popup end -->
</tr>
<?php }  ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<!--END TABS-->
</div>
<?php
?>
<br>
</div>            
<!-- END PAGE CONTENT-->

<script>
function reply_reg(id,c4)
		  {
			   var c1=document.getElementById("subject" + id).value;
			
			 var c2=document.getElementById("texs" + id).value;
			
			 var c3=document.getElementById("em" + id).value;
			$(document).ready(function() {
			$('#show_div').html('<div class="modal-backdrop fade in"></div><div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true"><div class="modal-body" style="font-size:16px;" align="center"><img src="<?php echo $this->webroot ; ?>/as/loding.gif" />loding...</div></div>');
			
			$('#show_div').load('resident_approve_reply?con1=' + encodeURIComponent(c1) + '&con2=' + encodeURIComponent(c2) + '&con3=' + encodeURIComponent(c3) + '&con4=' + encodeURIComponent(c4));
				$("#can").live('click',function(){
				$('#show_div').hide();
				});
			});
		  }
</script>
