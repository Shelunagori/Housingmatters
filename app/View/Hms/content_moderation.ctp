<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:2px; box-shadow:5px; font-size:16px; color:#006;">
     
                <table width="100%">
                <tbody><tr>
                <td width="60%" style="color:#A96363; font-size:20px; padding-left:10px;">Content Moderation View </td>
				
             <td width="" valign="bottom" style="padding-top:10px;padding-right: 2%;" align="right">
			 <div class="controls">
		
			 <a onclick="content_blank();" href="javascript:ShowContactForm()" class=" btn blue" style="margin-bottom: 2%;" >Add New Content Moderation  </a>
			 </div></td>
                </tr>
                </tbody></table>
                 </div>
				 

<div class="pull-left" style="width:60%;">

<div class="tab-content">

<div class="tab-pane active" id="tab_1_2">


<div class="portlet box ">
<br/>
<ul class="nav nav-tabs">
			<li ><a href="master_sm_wing" > Wing</a></li>
            <li><a href="flat_type" >Flat Type</a></li>
            <li><a href="master_sm_flat" >Flat Number</a></li>
            <li ><a href="flat_nu_import" >Flat Number Import</a></li>
			 <li class="active"><a href="content_moderation">Banned Words</a></li>
			</ul>
			
<div class="portlet-body">
<table class="table table-striped table-bordered" id="sample_2">
<thead>
<tr>
<th style="">Sr No.</th>
<th>Content Moderation Word</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php
$i=0;
if(!empty($result_society))
{
foreach($result_society as $data)
{
$i++;
@$content=@$data['society']['content_moderation'];

@$qw=implode(',',$content);

?>
<tr class="odd gradeX" >
<td><?php echo $i ; ?></td>
<td>
<?php
echo $qw;
 ?> 
 </td>
<td>
<div class="btn-group ">
	<a class="btn mini" href="#" data-toggle="dropdown">
	Action
	<i class="icon-angle-down "></i>
	</a>
	<ul class="dropdown-menu">
	<li><a href="#" onclick="content_edit('<?php
echo $qw;
 ?> ',<?php echo $i ; ?>);"><i class="icon-pencil"></i> Edit</a></li>
	</ul>
</div>


  </td>
</tr>
<?php } } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>





</div>



<div class="pull-right" style="width:30%">


<div id="contact_hand" style="display:none;">

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
                        <h4> Content Moderation Add</h4>
                     </div>
                     <div class="portlet-body form " >
                        <h3 class="block"></h3>
                        <!-- BEGIN FORM-->
                        <form  id="contact-form"  method="post" name="form" enctype="multipart/form-data" onSubmit="return validate();">
                         <fieldset>
                           <div class="control-group ">
                              <div class="controls">
                               <label class="" style="font-size:14px;" >Content</label>
							   <input type="hidden" name="text_name" id="text_id" >
                                <textarea class="span12 m-wrap" style="resize:none;" name="name" id="na"></textarea>
                              </div>
                           </div>
                          <div class=""  >
						<input type="submit" style="background-color: #7490BE;"  class="btn blue" value="Submit" name="sub"> 
						<a  href="javascript:ShowContactcancel()" class=" btn " >Close </a>
						</div>
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

</div>


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
function content_edit(con,id)
{

document.getElementById('na').value=con;
document.getElementById('text_id').value=id;
ShowContactFormzzz();
}


function content_blank()
{
document.getElementById('na').value='';

}
</script>
