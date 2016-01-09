
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

.hv_b:hover{
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

	  
	  function search_wing_record()
		  {
		    if(xobj)
			 {	
			 
		     var c1=document.getElementById("wing_value").value;
			 var query="?con=" + c1;
			 xobj.open("GET","yellow_page_view_ajax" +query,true);
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

<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:2px; box-shadow:5px; font-size:16px; color:#006;">
     
                <table width="100%" >
                <tr>
                <td width="60%" style="color:#666666; font-size:24px; padding-left:10px;">Yellow Page</td>
                <td width="20%" valign="bottom"><select style="" id="wing_value" onchange="search_wing_record()" class="chosen"><option value="0">All Category </option>
                
                 <?php  
												foreach ($result_yellow_category as $collection)
												{ 
												$id=$collection['yellow_category']['yellow_cat_id'];
												$servies=$collection['yellow_category']['yellow_cat_name'];
												?>  
				                                  <option value="<?php echo $id; ?>"><?php  echo $servies; ?></option>				
					                              <?php }	?>
                
                
                
                
                </select></td>
               <!-- <td width="20%" valign="bottom" style="padding-top:10px;" align="right"><div class="controls"><input type="text" placeholder="Name"  style="" id="get_search" onkeyup="search_record()"></div></td> -->
                </tr>
                </table>
                 </div>



<div id="view_search" >

 <?php
			foreach ($result_ye_registration as $collection)            
			{  
				$yellowpage_id=$collection['yellow_registration']["yellowpage_id"];
				$website=$collection['yellow_registration']["yellowpage_website"];
				$mobile=$collection['yellow_registration']["yellowpage_mobile"];
				$path=$collection['yellow_registration']["yellowpage_attachment"];
				$address=$collection['yellow_registration']['yellowpage_address'];
				$ad=mb_strimwidth($address, 0, 30, "....");
				$category_id=$collection['yellow_registration']['yellowpage_category'];
				$name=$collection['yellow_registration']["yellowpage_name"];
				if(empty($path))
				{
				$path="blank.jpg"; 
				}
?>

<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $yellowpage_id;?>)">
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
<img src="<?php echo $this->webroot ; ?>/yellow_page_file/<?php echo $path; ?>" style="float:left;width:20%;height:60px;"/>
<div style="float:left;margin-left:3%;">
<i class="icon-user"></i> <span style="font-size:20px;"><?php echo $name; ?></span><br/>
<i class="icon-phone-sign"></i> <span style="font-size:16px;"><?php echo $mobile ; ?></span><br/>
<i class="icon-home"></i> <span style="font-size:16px;"><?php echo $ad ; ?></span><br/>
</div>
</div>
</div>


<?php 
}
?>
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
				
				
				$( "#view_dir" ).load( 'yellow_page_view?id=' + id , function() {
				
				  $("#all_dir").hide();
				 
				  $("#view_dir").show();
				});
		
		
		});
	
}
</script>