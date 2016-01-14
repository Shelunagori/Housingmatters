<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<h3><b>Master Flat Type Assign</b></h3>
</center>
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
function ch1()
		{
		
		     if(xobj)
			 {			
			var len = document.getElementById('verti').value;
		
			if(document.getElementById('chkk1').checked==true)
			{
	        for(var j=1; j<=len; j++)
			{
				
			document.getElementById("fchk"+ j).checked=true;	
				
			}
			
			}
		
					
					
				
			 }
			 xobj.send(null);
		  }
		  </script>
<?php /////////////////////////////////////////////////////////////////////////////////////////?>
<a href="master_flat_assign" class="btn purple">Master Flat Type Assign</a>
<a href="master_flat_assign2" class="btn yellow">Master Flat Assign</a>

<?php //////////////////////////////////////////////////////////////////////////////////////////?>

<br><br>
<center>
<div style="width:80%; border:solid 1px yellow;">
<form method="post">
<table class="table table-bordered" style="background-color:#FDFDEE;">
<tr>
<th style="text-align:center;" rowspan="2">Flat Name</th>
<th style="text-align:center;">Square Feet</th>
<th style="text-align:center;">BHK</th>
</tr>

<tr>
			<td style="text-align:center;">
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span><input type="radio" name="all" value="1" style="opacity: 0;" id="chkk1" onclick="ch1()"></span></div>
			Select All
			</label>
			</td>


			<td style="text-align:center;">
			<label class="radio">
			<div class="radio" id="uniform-undefined"><span><input type="radio" name="all" value="2" style="opacity: 0;" id="chkk2" onclick="ch1()"></span></div>
			Select All
			</label>
			</td>
			
	
<?php
$abc = sizeof($cursor1);
?>


<?php $i=0; $k=0;
foreach($cursor1 as $collection)
{
$i++;
$flat_id = (int)$collection['flat']['flat_id'];
$flat_name = $collection['flat']['flat_name'];
?>

<tr>
<td style="text-align:center;"><?php echo $flat_name; ?></td>
	<td style="text-align:center;">
		<label class="radio">
		<div class="radio" id="uniform-undefined"><input type="radio" name="flat_type<?php echo $flat_id; ?>"  id="fchk<?php echo $i; ?>" style="opacity: 0;"></div>
		</label>
</td>


<td style="text-align:center;">
<label class="radio">
<div class="radio" id="uniform-undefined">
<input type="radio" name="flat_type<?php echo $flat_id; ?>" id="schk<?php echo $i; ?>" value="2" ></div>
</label>
</td>
</tr>
<?php } ?>
</div>
<tr>
<td colspan="3" style="text-align:center;">
<button type="submit" class="btn green" name="sub">Submit</button>
</td>
</table>
</form>
</div>
</center>
<input type="hidden" id="verti" value="<?php echo $i;?>"/>
<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>

<!--
<script>

$(document).ready(function() {
	$("#first").live('click',function(){
	var t = document.getElementById('abcd').value;	
	for(var j=1; j<=t; j++)
	{
	document.getElementById('second' + j).checked = false;
	document.getElementById('first' + j).checked = true;
	
	
	}
	});
	
	$("#second").live('click',function(){
	var tt = document.getElementById('abcd').value;	
	for(var k=1; k<=tt; k++)
	{
	document.getElementById('first' + k).checked = false;
	document.getElementById('second' + k).checked = true;
	}
	});
	
});
</script>	-->	



































