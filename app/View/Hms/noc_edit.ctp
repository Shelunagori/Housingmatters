<?php
if($nnn == 5)
{
?>
<a href="master_noc_view" class="btn green"><i class="icon-arrow-left"></i>Back</a>
<br /><br />
<center>
<div style="width:90%; background-color:white; overflow:auto;" >
<br />
<h3><b>Non Occupancy Charges Update</b></h3>
<form method="post" id="contact-form">
<?php
foreach($cursor1 as $collection)
{
$fl_tp_id  = (int)$collection['flat_type']['flat_type_id'];
$charge = $collection['flat_type']['noc_charge'];

$fl_tp = $this->requestAction(array('controller' => 'hms', 'action' => 'flat_type_name_fetch'),array('pass'=>array($fl_tp_id)));		
foreach($fl_tp as $collection)
{
//$auto_id1 = (int)$collection['flat_type_name']['auto_id'];	
$flat_type = $collection['flat_type_name']['flat_name'];
}
}
?>
<input type="hidden" value="<?php echo $auto_id; ?>" name="au" />
<h4><b>Flat Type : <?php echo $flat_type; ?></b></h4>

<table class="table table-bordered">
<tr>
<td style="text-align:center;">
<?php
$type = $charge[0];
if($type == 4)
{
$amount = "";	
}
else
{
$amount = $charge[1];
}
?>
<select name="tp" class="m-wrap medium go" id="tp">
<option value="1" <?php if($type == 1) { ?> selected="selected" <?php } ?>>Lump Sum</option>
<option value="2" <?php if($type == 2) { ?> selected="selected" <?php } ?>>Per Square Feet</option>
<option value="3" <?php if($type == 3) { ?> selected="selected" <?php } ?>>Flat Type</option>
<option value="4" <?php if($type == 4) { ?> selected="selected" <?php } ?>>10% of Maintanance Charge</option>
</select>
<div <?php if($type==4) { ?> class="hide" <?php } ?> id="div1">
<input type="text" name="amt" class="m-wrap medium" value="<?php echo $amount; ?>" id="amt" />
</div>
</td>
</tr>
</table>
<label id="amt"></label>
<br />
<div>
<button type="submit" name="sub" class="btn blue">Update</button>
</div>
</form>
<br />
</div>
</center>
<?php
}
if($nnn == 55)
{
?>
<form method="post">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-header">
<center>
<h3 id="myModalLabel3" style="color:#999;"><b>Non Occupancy Charges Update</b></h3>
</center>
</div>
<div class="modal-body">
<input type="hidden" name="auto_id" value="<?php echo $au; ?>" />
<input type="hidden" name="val" value="<?php echo $ch1; ?>" />
<center>
<h3><b>Are You Sure</b></h3>
</center>
</div>
<div class="modal-footer">
<a href="noc_edit?a=<?php echo $au; ?>" class="btn">Cancel</a>
<button type="submit" name="sub2" class="btn blue">Confirm</button>
</div>
</div>


</form>
<?php } ?>
<?php ///////////////////////////////////////////////////////////////////////////////// ?>
	
<?php ///////////////////////////////////////////////////////////////////////////////////// ?>


 <script>
$(document).ready(function(){

$.validator.setDefaults({ ignore: ":hidden:not(select)" });
		$('#contact-form').validate({
			
		
		errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    },
		
		
		
	    rules: {
	     
		 amt: {
			 required: true,
			 number: true
			 
	      },

           		},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); 
</script>
	
<script>
$(document).ready(function() {
$(".go").live('change',function(){

var tp = document.getElementById("tp").value;  
if(tp == 4)
{
$("#div1").hide();	
}
else
{
$("#div1").show();	
}



});
});
</script>	














