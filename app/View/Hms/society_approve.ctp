<!--<script type="text/javascript">
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
			
				document.getElementById("apz" + c2).innerHTML=xobj.innerHTML='<div align="center"><h6>loding...</h6></div>';
				var query="?con1=" + c1 ;
				
				xobj.open("GET","society_approve_mail" +query,true);
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
</script>-->

<div class="container-fluid" style="padding:0px; ">
				<!-- BEGIN PAGE HEADER-->
				
               
               
                       
                
             
               <div id="show_div"></div> 
                
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
                <div class="portlet-body" style="padding:10px;";>
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											
											<li class="active"><a href="society_approve" >Approval</a></li>
                                            
										</ul>
										<div class="tab-content">
											
											<div class="tab-pane active" id="tab_1_2">
												
												
											<div class="portlet box ">
							
							<div class="portlet-body">
								<table class="table table-striped table-bordered" id="sample_2">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Society Name</th>
                                            <th>Contact Person</th>
                                            <th>Mobile</th>
                                             <th>Date</th>
                                            <th class="hidden-phone">Approve</th>
                                            <th class="hidden-phone">Reject</th>
										</tr>
									</thead>
									<tbody>
<?php

$i=0;
foreach ($result_user_temp as $collection) 
{ 
 $da_society_id=(int)$collection['user_temp']["society_id"];
 $da_user_id=(int)$collection['user_temp']["user_temp_id"];
 $password=$collection['user_temp']["password"];
 $user_name=$collection['user_temp']["user_name"];
 $email=$collection['user_temp']["email"];
 $mobile=$collection['user_temp']['mobile'];
 $date=$collection['user_temp']['date'];
$society = $this->requestAction(array('controller' => 'hms', 'action' => 'society_name'),array('pass'=>array($da_society_id)));

foreach ($society as $collection) 
{ 
$society_name=$collection['society']['society_name'];
}
$i++;

	?>
										<tr class="odd gradeX" id="apz<?php echo $i; ?>">
											<td><?php echo $i; ?></td>
											<td><?php echo $society_name; ?></td>
                                    		 <td><?php echo $user_name; ?></td>
                                     		 <td><?php echo $mobile; ?></td>
                                     		 <td><?php echo $date; ?></td>
                                         <td><a href="#ap<?php echo $i; ?>" role="button" class="btn mini green" data-toggle="modal"><i class="icon-ok"></i>Approve</a>
                                            <!--POP UP BOX-->
 <div id="ap<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none; " align="center">
									<div class="modal-header">
										
										<h3 id="myModalLabel2"><b>Approve</b></h3>
									</div>
									<div class="modal-body">
										<div>
                                        
                                        <table align="center">
                                        <tr><td>To</td><td><?php echo $email; ?></td><input type="hidden" name="" id="em<?php echo $i; ?>" value="<?php echo $email; ?>"></tr>
                                        
                                        <tr>
                                        <td>Subject</td><td>HousingMatters</td></tr>
                                        <tr>
                                        <td>Message</td><td>Username:<?php echo "    ".$email; ?><br/>Password:<?php echo "   ".$password ;?></td></tr></table> </div>
									</div>
									<div class="modal-footer">
										<button  data-dismiss="modal" id1="<?php echo $da_user_id;?>"  id2="<?php echo $i;?>" id3="<?php echo $da_society_id;?>" class="btn blue approve">Send Email</button>
                                       <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>  
									</div>
								</div>
                                   <!--END OF POP UP BOX-->          
                                             </td>
       <!--  <td><a href="aprv_query.php?con=<?php //echo $username; ?>" class="btn mini green"><i class="icon-ok"></i> Approve</a></td>-->
		<td><a href="#del<?php echo $i; ?>" class="btn mini red" data-toggle="modal"><i class=" icon-remove" ></i> Reject</a>
        </td>
                                                <!--popup start -->
<div id="del<?php echo $i; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
									<div class="modal-header" >
										
										<h4 id="myModalLabel3"><b>Conformation </b></h4>
									</div>
									<div class="modal-body">
									<span style="color:red;"><i class="icon-warning-sign"></i></span> &nbsp;<b style="font-size:16px; font-family:'Times New Roman', Times, serif;">Are you sure you want to delete new society ?</b>
									</div>
									<div class="modal-footer">
                                        <a href="society_approve_reject?con=<?php echo $email; ?> &con1=<?php echo $da_user_id ;?>" role="button"  class="btn blue" >Yes</a>
                                        <button class="btn " data-dismiss="modal" aria-hidden="true">No</button>
									</div>
								</div>
		<!--popup end -->
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
											</div>
											<span id="st"></span>	
										</div>
									</div>
									<!--END TABS-->
								</div>
                <?php
                
           		
				?>
               <br>
               
                </div>            
                                
				<!-- END PAGE CONTENT-->
			</div>
			
			
			
<script>
$(document).ready(function() { 
	 $(".approve").live('click',function(){
		var c1=$(this).attr('id1');
		var c2=$(this).attr('id2');
		var c3=$(this).attr('id3');
		$("#apz"+c2).load("society_approve_mail?con1="+c1, function() {
			window.location.href = 'hm_assign_module?q='+c3;
		});
	 });
});
</script>