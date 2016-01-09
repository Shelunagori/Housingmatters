<div style="background-color:#EFEFEF; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
Society Setup
</div>

<div class="tabbable tabbable-custom">
<ul class="nav nav-tabs">
<li><a href="<?php echo $webroot_path; ?>Hms/master_sm_wing" rel='tab' > Wing</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/flat_type" rel='tab' >Flat Type</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/master_sm_flat" rel='tab' >Flat Configuration</a></li>
<!--<li class="active" ><a href="<?php //echo $webroot_path; ?>Hms/flat_nu_import" rel='tab' >Flat Number Import</a></li>-->
<li><a href="<?php echo $webroot_path; ?>Hms/society_details" rel='tab' >Society Details</a></li>
<li><a href="<?php echo $webroot_path; ?>Hms/society_settings" rel='tab' >Society Settings</a></li>
</ul>
<div class="tab-content" style="min-height:300px;">
<div class="tab-pane active" id="tab_1_1">

<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<a href="<?php echo $webroot_path; ?>Hms/flat_type" class="btn yellow">Flat Type</a>
<a href="<?php echo $webroot_path; ?>Hms/flat_nu_import" class="btn purple">Flat Import</a> 

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<?php
if(@$ok==2)
{
echo '<div class="alert alert-success">'.$sucess.'</div>';
}
if(@$ok==1)
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
<br /><br />

<div class="portlet box green">
<div class="portlet-title">
<h4><i class="icon-cogs"></i>Flat Number Import</h4>
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
	
<strong><a href="<?php echo $webroot_path; ?>/csv_file/demo/flat_import.csv" download="">Click here for sample format</a></strong>
<br>
<h4>Instruction set to import users</h4>
<ol>
<li>All the field are compulsory.</li>
<li>The field flat fype format is : (1 BHK)</li>
<li>Flat area shouls be in square feet</li>
</ol>
</div>
</div>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
</div>
</div>
</div>
