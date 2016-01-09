<?php 
if(@$ok1==2 && @$ok2==2 && @$ok3==2 && @$ok4==2 )
{
echo '<div class="alert alert-success">'.$sucess.'</div>';
}
if(@$ok1==1 || @$ok2==1 || @$ok3==1 || @$ok4==1 )
{

echo '<div class="alert alert-error">';
echo "<h4>Error :</h4></br>";
foreach($error_msg as $er_msg)
{
echo '<p>'.$er_msg.'</p>';
}
echo '</div>';
}
?>
<div class="portlet box green">
	<div class="portlet-title">
		<h4><i class="icon-cogs"></i> Csv Import</h4>
	</div>
	<div class="portlet-body">
	<form  id="contact-form" name="myform" enctype="multipart/form-data" class="form-horizontal" method="post" >	
		<div class="control-group">
		  <label class="control-label">Attach csv file</label>
		  <div class="controls">
			 <input type="file" name="file" class="default">
			 <input type="submit" name="sub" class="btn blue" value="Import" >
		  </div>
	   </div>
	</form>	
	</div>
</div>