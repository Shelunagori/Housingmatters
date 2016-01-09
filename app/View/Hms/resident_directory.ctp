<?php 
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            @$length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                @$output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}
?>
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

	  function search_record()
		  {
			 
		
		    if(xobj)
			 {			
					
			
		
           var c1=document.getElementById("get_search").value;
		  
			 var query="?con=" + c1;
			 xobj.open("GET","resident_directory_search_name" +query,true);
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
		  
	  function search_wing_record()
		  {
			 
		
		    if(xobj)
			 {			
				
           var c1=document.getElementById("wing_value").value;
		   count_resident_wing_wise(c1);
			 var query="?con=" + c1;
			 xobj.open("GET","resident_directory_search_wing_ajax" +query,true);
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

<div id="all_dir"  >

<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:2px; box-shadow:5px; font-size:16px; color:#006;">
 <table width="100%" >
                <tr>
  <td width="45%" style="color:#666666; font-size:22px; padding-left:10px;"><i class="icon-book"></i> Resident Directory  <span style='font-size:18px;'> (<span id="count_wing_user"><?php echo $result_user_count; ?></span>)<span>  </td>
  <td width="10%" style="vertical-align: middle;"><span style="margin-left: 35px;">Search By </span></td>
                <td width="20%" valign="top" style="vertical-align: middle;">
				<div class="controls" class="span4" style="margin-left: 2px;">
				<select style="" id="wing_value" onchange="search_wing_record()" class="chosen" width="30%;">
					<option value="0">All Wing</option>

					<?php  

					foreach ($result_wing as $collection) 
					{
					$wing_id_edit = $collection['wing']['wing_id'];
					$wing_name_edit = $collection['wing']['wing_name'];	
					?>
					<option value="<?php echo $wing_id_edit; ?>"><?php  echo $wing_name_edit; ?></option>				
					<?php }	?>
					</select>
				</div> 
				</td>
				
              <td width="25%" valign="top" style="padding-top:5px;" align="right">
			  <div class="controls" class="span4" style="margin-right: 40px;">
			  <input type="text" placeholder="Name or Unit number"  style="height: 21px;" id="get_search" onkeyup="search_record()"> <i class=" icon-info-sign tooltips" data-placement="bottom" data-original-title="Name of the person whom you want to search "> </i>
			  </div> 
			  </td>
                </tr>
                </table>
      
</div>



<div id="view_search" style="overflow:auto;"  >

 <?php
			foreach ($result_user as $collection)            
			{
				$c_user_id = (int)$collection['user']['user_id'];          
				
				$medical_pro = @$collection['user']['medical_pro'];
				
				$c_name = $collection['user']['user_name'];
				$c_name_cut=substrwords($c_name,20,'...');
				@$profile_pic = $collection['user']['profile_pic'];
				$f_profile_pic = @$collection['user']['f_profile_pic'];
				$g_profile_pic = @$collection['user']['g_profile_pic'];
						
				//$multiple_flat = @$collection['user']['multiple_flat'];
				$c_wing_id = $collection['user']['wing'];
				$c_flat_id = $collection['user']['flat'];
				
				$result_user_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_user_flat_active'),array('pass'=>array($c_user_id)));
				foreach($result_user_flat as $data){
				
				
				$user_flat_id=$data['user_flat']['user_flat_id'];
				$flat_id=$data['user_flat']['flat_id'];
				
			
				$result_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'fetch_wing_id_via_flat_id'),array('pass'=>array($flat_id)));
				foreach($result_flat as $data2){
					
					$wing_id=$data2['flat']['wing_id'];
				}
								
				$wing_flat = $this->requestAction(array('controller' => 'hms', 'action' => 'wing_flat'),array('pass'=>array($wing_id,$flat_id)));			  
				
?>

<div class="r_d fadeleftsome" onclick="view_ticket(<?php echo $c_user_id;?>,<?php echo $user_flat_id; ?>)">
<div class="hv_b" style="overflow: auto;padding: 5px;cursor: pointer;" title="">
<?php if(!empty($profile_pic) and $profile_pic!="blank.jpg"){ ?>
<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
<?php } elseif(!empty($f_profile_pic)){ ?>
<img src="<?php echo $f_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
	
<?php } elseif(!empty($g_profile_pic)){ ?>
<img src="<?php echo $g_profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
<?php }elseif(empty($g_profile_pic) and empty($f_profile_pic)){ if(empty($profile_pic)){ $profile_pic="blank.jpg"; } ?>  

<img src="<?php echo $webroot_path ; ?>/profile/<?php echo $profile_pic; ?>" style="float:left;width:25%;height:80px;"/>
 <?php  } ?>
<div style="float:left;margin-left:3%;">
<span style="font-size:22px;"><?php echo $c_name_cut; ?> &nbsp; </span> 
<?php if(@$medical_pro==1){ ?> <span style="float:right;color:red; font-size:18px;"> <i class="icon-plus-sign"></i> </span> <?php } ?> <br/>
<span style="font-size:16px;"><?php echo $wing_flat ; ?></span><br>

</div>
</div>
</div>


<?php 
		} } 
?>
</div>
</div>



<div id="view_dir" style="display:none;" class="fadeleftsome">

<br/><br/><div align="center" style="font-size:24px;"><img src="<?php echo $this->webroot ; ?>/as/loading.gif" height="50px" width="50px"/><br/>Please Wait</div>

</div>
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

function count_resident_wing_wise(c_count){
		$(document).ready(function() { 
		
			$( "#count_wing_user" ).load( 'resident_directory_count_wing?id=' + c_count)
		});
}



function view_ticket(id,user_flat_id)
{
	$(document).ready(function() {
				
				
				$( "#view_dir" ).load( 'resident_directory_view?id=' + id +'&user_flat_id='+ user_flat_id , function() {
				
				  $("#all_dir").hide();
				 
				  $("#view_dir").show();
				});
		
		
		});
	
}
</script>