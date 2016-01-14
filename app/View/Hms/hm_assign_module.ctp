
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

	
	function designation(c1)
		  {
			 
		
		    if(xobj)
			 {			
				
			 var query="?con=" + c1;
			 xobj.open("GET","hm_assign_module_ajax" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("show_designation").innerHTML=xobj.responseText;
			   test();
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }
	function test()
	{
	var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle)");
	if (test) {
	test.uniform();
	}
	}



</script>	
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
               Assign Modules To Role
</div>-->
<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
	
</ul>
<div class="tab-content" style="min-height:500px;>
<div class="tab-pane active" >
<div >
<div class="portlet-body" >
 <?php if(!empty($mess))
					 { ?>
					 <div style="margin-left:30%;width:30%">
					 <div class="alert alert-info">
									<button class="close" data-dismiss="alert"></button>
									<strong>Info!</strong> <?php echo $mess ; ?>.
								</div>
					 <?php } ?>
					 </div>
<form method="post">

<label style="margin-left:40%;">Society Name</label>                                                            
<span style="margin-left:30%;">
 <select class="span4 chosen" name="r_name"  data-placeholder="Choose Society Name" tabindex="1" onchange="designation(this.value)">
                                    <option value="" style="display:none;"></option>
                                    <?php 
									
									foreach ($result_society as $collection) 
									{
									$society_name = $collection['society']['society_name'];
									$society_id=$collection['society']["society_id"];
                                    ?>
                                    <option value="<?php echo $society_id; ?>" /><?php echo $society_name; ?></option>
                                 	<?php }  ?>
                                 </select>
</span>
<div id="show_designation" ></div>

</div>
</div>
</div>    
</div>
</div>

<script>
$(document).ready(function(){
$(".chk_input").live('click',function(){
var c=$(this).val();
value = +$('#'+c).is( ':checked' );
if(value==0)
{
$(".all_chk" +c).parent('span').removeClass('checked');
$(".all_chk" +c).removeAttr('checked','checked');
}
else
{
$(".all_chk" +c).parent('span').addClass('checked');
$(".all_chk" +c).attr('checked','checked');
}
});
});

</script>