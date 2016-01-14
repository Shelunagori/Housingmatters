<center><h3><b>Master Accounts Category</b></h3></center>
<br>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<div style="width:100%;">
<a href="master_accounts_category_hm" class="btn purple">Accounts Category</a>
<a href="master_accounts_group_hm" class="btn yellow">Accounts Group</a>
<a href="master_ledger_account_hm" class="btn yellow">Ledger Account</a>
</div>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<form method="post" id="contact-form"> 
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Add Accounts Category</h4>
</div>
<div class="portlet-body form">

<label style="font-size:14px;">Accounts Category</label>                   
<input type="text" name="cat_name" placeholder="Accounts Category" class="m-wrap span5" style="background-color:white !important;" id="cat">
<label id="cat"></label>                       
                           
                           
<br>                          
<div class="form-actions">
<button type="submit" name="sub" class="btn blue">Add</button>
</div>
	
</div>
</div>
</form>


			   
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////

if(!empty($del_id))
{
?>
<!----alert-------------->
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<form method="post">
<div class="modal-body" style="font-size:16px;">
Are you sure
<input type="hidden" value="<?php echo $del_id; ?>" name="del_id" />
</div> 
<div class="modal-footer">
<a href="master_accounts_category_hm" class="btn">Cancel</a>
<button type="submit" name="delc" class="btn green">Delete</button>
</form>
</div>
</div>
<!----alert-------------->
<?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////// ?>



<?php /////////////////////////////////////////////////////////////////////////////////////////////////// ?>			   
			<br>
			<form method="post">
			<center><a href="accounts_category_excel_hm" class="btn blue" style="float:right; margin-right:10%;">Export in Excel</a>
					<div class="portlet box grey" style="width:80%;">
    <div style="background-color:#B2B2B2; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; padding:10px; box-shadow:5px; font-size:16px; color:#006;">
        <b style="color:white;">  Accounts Category </b>
        </div>
						
							<div class="portlet-body">
					<table style="width:100%; background-color:white;" class="table table-bordered" id="sample_2">			
					<thead>
                    <tr>
					<th style="text-align:left;">Sr.No.</th>
					<th style="text-align:left;">Accounts Category</th>
                    <th style="text-align:center;">Edit</th> 
					</tr>        
                </thead>
			<tbody>
			<?php
            $n = 1;
			foreach ($cursor1 as $collection) 
			{
            $name = $collection['accounts_category']['category_name'];
			$auto_id = (int)$collection['accounts_category']['auto_id'];
			?>

			
   
			
			<tr>
			<td style="text-align:left;"><?php echo $n; ?></td>
			<td style="text-align:left;"><?php echo $name; ?></td>
           <td style="text-align:center;">
<!--<a href="#collapse<?php echo $auto_id; ?>" class="mini purple btn accordion-toggle collapsed" data-toggle=     "collapse" data-parent="#accordion1">Edit</a> -->
<a href="#myModal<?php echo $auto_id; ?>" role="button" class="btn mini purple" data-toggle="modal">Edit</a>
<!--
<a href="master_accounts_category_hm?con=<?php echo $auto_id; ?>" class="btn mini black">Delete</a>-->
            </td> 
		 	</tr> 
           <!-- <tr>
            <td style="text-align:center; padding:0px; margin:0px;" colspan="3">
   
    <div id="collapse<?php echo $auto_id; ?>" class="accordion-body collapse" style="height: 0px;">
    <input type="text" style="margin-top:10px; background-color:white !important;" class="m-wrap medium" value="<?php echo $name; ?>" name="cat<?php echo $auto_id; ?>" >
    <button type="submit" class="btn yellow" style="margin-top:10px;" name="sub<?php echo $auto_id; ?>">Update</button>
    </div>
  
            
            </td>
            </tr> -->       
			<?php $n++; } ?>
            </tbody>   
			</table>
			</div> 
            </div>        
			</center>
 


<?php
foreach ($cursor1 as $collection) 
{
$name = $collection['accounts_category']['category_name'];
$auto_id2 = (int)$collection['accounts_category']['auto_id'];

?>
<div id="myModal<?php echo $auto_id2; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="display: block;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<center>
<h3 id="myModalLabel3">Accounts Group</h3>
</center>
</div>
<div class="modal-body">
<center>
<input type="text" style="margin-top:10px; background-color:white !important;" class="m-wrap medium" value="<?php echo $name; ?>" name="cat<?php echo $auto_id2; ?>" >
  
  </center>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
<button type="submit" class="btn blue" name="sub<?php echo $auto_id2; ?>">Update</button>
</div>
</div> 

<?php
}
?>
</form>






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
	      cat_name: {
	       
	        required: true
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







































