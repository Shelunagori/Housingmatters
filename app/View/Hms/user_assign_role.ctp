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

	
	function role(c1)
		  {
			if(xobj)
			 {		
			 var query="?con=" + c1;
			 xobj.open("GET","user_assign_role_ajax" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("show_designation").innerHTML=xobj.responseText;
			   test12();
			   }
			  }
			 }
			 xobj.send(null);
		  }

		 
	function test12()
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
               Assign Role To User
</div>-->

	<!--BEGIN TABS-->
	<div class="tabbable tabbable-custom">
		<ul class="nav nav-tabs">
			
		</ul>
		<div class="tab-content" style="min-height:500px;">
			<div class="tab-pane active" id="tab_1_1">
				<form method="post">
<div class="control-group" style="width:40%; margin-left:28%;">
<div class="controls" >

<label style="margin-left:30%;">Select User Name</label>


 <span style="margin-left:10%;">
<select class="span12 chosen" name="user" id="user"  data-placeholder="Type User Name" tabindex="1" onchange="role(this.value)">
	<option value="" style="display:none;"></option>
	<?php
	
	foreach ($result_user as $collection) 
	{
	$user_id = $collection['user']['user_id'];
	$user_name=$collection['user']["user_name"];
	$wing=(int)$collection['user']["wing"];
	$flat=(int)$collection['user']["flat"];
	
$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing,$flat)));
	
	?>
<option value="<?php echo $user_id; ?>" ><?php echo $user_name; ?> &nbsp;&nbsp;<?php echo $wing_flat ; ?></option>
	<?php } ?>
 </select>
 </span>
						  
</div>
</div>


<div id="show_designation" style="width:60%; margin-left:20%;">
</div>
</form>
			</div>
			
		</div>

<!-- END PAGE CONTENT-->
</div>