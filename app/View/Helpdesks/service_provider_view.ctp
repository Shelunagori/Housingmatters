<div class="hide_at_print">
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
<a href="service_provider_view" class="btn red" rel='tab' > View</a>
<a href="service_provider_add" class="btn blue" rel='tab' > Add</a>
</div>
</div>
<style>
table th { font-size:12px !important ; }
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
		  
	function service_provider_mail(id)
		  {		
		 	
			
		    if(xobj)
			 {
				
				  var c2=document.getElementById("texs" + id).value;
				   var c3=document.getElementById("em" + id).value;
				 
			 var query="?con2=" + c2 +"&con3=" +c3 ;
			  
			 xobj.open("GET","service_provider_mail" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("st").innerHTML=xobj.responseText;
			   }
			  }
			 
			 }
			 xobj.send(null);
		  }
		   </script>
	
<div id="st" class="h_d"> 
 </div>

<div class="portlet box " >
							
							<div class="portlet-body">
									<div align="right" class="hide_at_print">
									<a href="service_provider_excel" class="btn blue mini"><i class="fa fa-file-excel-o"></i> </a>
									<a class="btn green mini" onclick="window.print()"><i class="icon-print"></i>  </a>
									</div>
							<table class="table table-striped table-bordered" id="sample_1">
							<thead>
    						<tr >
                                        	
                                    <th style="width:5%;">Sr No</th>
									<th>Vendor Name</th>
                                    <th>Contact Person</th>
								    <th>Services</th>
									<th>Mobile</th>
									<th>Email</th>
                                    <th>Contract Type</th>
                                    <th>Contract from</th>
									<th>Contract to</th>
                                    <th>PAN Number</th>
									<th class="hide_at_print"><span style="font-size:14px;"><i class="icon-paper-clip"></i></span></th>
                                    <?php if($role_id==3)
									{ 
									?>
									<th class="hide_at_print"></th><?php }?>
									</tr>
									</thead>
									<tbody>
						
						
						<?php
                        $z=0;
                       
                        foreach ($result_service_provider as $collection) 
                        {
                        $z++;
                        $name=$collection['service_provider']['sp_name'];
                        $auto_id= (int)$collection['service_provider']['sp_id'];
                        $attachment=@$collection['service_provider']['sp_attachment'];
                        $ext = pathinfo($attachment, PATHINFO_EXTENSION);
                        $contect=@$collection['service_provider']['sp_mobile'];
		                $Contract_start=@$collection['service_provider']['sp_cont_start'];
                        $Contract_end=@$collection['service_provider']['sp_cont_end'];
                        $contrect_person=@$collection['service_provider']['sp_person'];
                        $email=@$collection['service_provider']['sp_email'];
                        $Contract_type=@$collection['service_provider']['sp_contract_type'];
                        $pan_number = @$collection['service_provider']['pan_number'];
						if($Contract_type=="Adhoc")
                        {
                        $Contract_start="N/A";
                        $Contract_end="N/A";
                        }
						 
						 
						
                        ?>
                            <tr class="odd gradeX">
                            <td><?php echo $z; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $contrect_person; ?></td>
                            <td>
							
                            <div class="btn-group hide_at_print">
                            <a class="btn mini" href="#" data-toggle="dropdown">
                            View Services
                            </a>
                <ul class="dropdown-menu" >
                       
                        <?php
                       $result_vendor = $this->requestAction(array('controller' => 'hms', 'action' => 'service_provider_vendor'),array('pass'=>array($auto_id)));
                        foreach ($result_vendor as $collection) 
						{
                         $category=(int)$collection['vendor']['category_id'];
						 $type = $this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'),array('pass'=>array($category)));
						?>
						 <li><a  data-toggle="modal"><i class="icon-legal"></i><?php echo $type; ?></a></li>
						 
                <?php } ?>
                </ul>
                </div>
                        <div style="display:none;" class="hide_to_show"> <?php
                       $result_vendor = $this->requestAction(array('controller' => 'hms', 'action' => 'service_provider_vendor'),array('pass'=>array($auto_id)));
                        foreach ($result_vendor as $collection) 
						{
                         $category=(int)$collection['vendor']['category_id'];
						 $type = $this->requestAction(array('controller' => 'hms', 'action' => 'help_desk_category_name'),array('pass'=>array($category)));
						?>  
						<?php echo $type; ?>,
					<?php } ?>

						</div>
                            
                            
                            </td>
                            <td><?php echo $contect; ?></td>
							<td><?php echo $email; ?></td>
                            <td><?php echo $Contract_type; ?></td>
                            <td><?php echo $Contract_start; ?></td>
                            <td><?php echo $Contract_end; ?></td>
                            <td><?php echo $pan_number; ?></td>
                            <td class="hide_at_print">
                            <?php
                            if(!empty($attachment))
							{
                            ?> 
							
							
							
							<a href="<?php echo $this->webroot; ?>service_provider_file/<?php echo $attachment; ?>" class=" tooltips"  data-placement="bottom" data-original-title="<?php echo $attachment; ?>" download="<?php echo $attachment ; ?>"><i class=" icon-download-alt"></i></a>
                            <?php
                            }
                            else
                            {
                            ?>
                            <a href="#" class=" tooltips" role='button' data-placement="bottom" data-original-title="<?php echo 'empty';?>"><i class=" icon-download-alt"></i></a>
                           <?php
                            } ?>
						
                             </td>
                            <?php if($role_id==3){ ?>                    
                            <td class="hide_at_print">
                
                <!---- action popup ----->
                <div class="btn-group">
                <a class="btn mini blue " href="#" data-toggle="dropdown">
                <i class=" icon-chevron-down"></i>
                </a>
                <ul class="dropdown-menu" style="min-width:50px !important;">
                <li><a href="service_provider_edit/<?php echo $auto_id; ?>"   rel='tab'><i class="icon-pencil"></i> </a></li>
                <li><a href="#<?php echo $z; ?>" data-toggle="modal"><i class="icon-trash"></i> </a></li>
                <li><a href="#mail<?php echo $z; ?>"  data-toggle="modal"><i class="icon-envelope"></i> </a></li>
                </ul>
                </div>
                <!----- end action popup ------->
   				<!--popup start -->
                        <div id="mail<?php echo $z; ?>" class="modal hide " tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none; " align="center">
                        <div class="modal-header">
                        <h3 id="myModalLabel2"><b>Send Email</b></h3>
                        </div>
                        <div class="modal-body">
                        <div>
                        <table align="center">
                        <tr><td>To</td><td><?php echo $name; ?>&nbsp;( <?php echo $email; ?> )</td>
                        <input type="hidden" name="" id="em<?php echo $z; ?>" value="<?php echo $email; ?>"></tr>
                        <tr>
                        <td>Subject</td><td><input type="text" value="HousingMatters" style="width:96%"></td></tr>
                        <tr>
                        <td>Message</td><td><textarea rows="7" cols="80" style="resize:none; width:300px;" 
                        id="texs<?php echo $z; ?>"></textarea></td>
                        </tr></table> </div>
                        </div>
                        <div class="modal-footer">
                        <button  data-dismiss="modal" onClick="service_provider_mail(<?php echo $z; ?>)"
                        class="btn green">Send Email</button>
                         <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        </div>
                        </div> 
                        <!--popup end -->  			   
                            </td><?php }?>
                        </tr>
                   <!--popup start -->
				   
<div id="<?php echo $z; ?>" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
									<div class="modal-header" >
										
									</div>
									<div class="modal-body">
									<span style="color:red;"><i class="icon-warning-sign"></i></span>
                                    <span style="font-size:16px;font-family:'Times New Roman', Times, serif;">Are you sure you want to delete the vendor record ? </span>
									</div>
									<div class="modal-footer">
                                        <a href="service_provider_delete?con=<?php echo $auto_id; ?>"    class="btn blue" >Yes</a>
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
									</div>
								</div>
								
								
					<!--popup end -->
     <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	
	<script>
	 $(document).ready(function () {
	  $('.h_d').delay(10000).fadeOut();
	 
	
	 });
	</script>