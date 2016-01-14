<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />
<center>                
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_receipt" class="btn yellow" rel='tab'>Create</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_receipt_view" class="btn" rel='tab'>View</a>
</center>

<!--------------------------------- Start Petty Cash Receipt Form ------------------------->
<?php
$default_date = date('d-m-Y');
?>
<form method="post">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Post Petty Cash Receipt</h4>
</div>
<div class="portlet-body form">
<div id="validdn" style="font-size:13px; font-weight:600; color:red;"></div>
 <table class="table table-bordered" id="tbbb" style="width:100%;">
    <thead>
	<tr style="background-color:#E8EAE8;">
          <th style="width:15%;">Transaction Date</th>
          <th style="width:15%;">A/c Group</th>
          <th style="width:15%;">Income/Party A/c</th>
          <th style="width:15%;">Account Head</th>
          <th style="width:15%;">Amount</th>
          <th style="width:30%;">Narration</th>
          <th></th>
    </tr>
    </thead>
	<tbody id="tbb">
    <tr style="background-color:#E8F3FF;">
    <td valign="top"><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" name="date" id="date" data-date-start-date="+0d" style="background-color:white !important; margin-top:2.5px;" value="<?php echo $default_date; ?>">
    </td>
           
    <td valign="top"><select class="m-wrap chosen span12" onchange="type_ajjxx(this.value,1)">
    <option value="" style="display:none;">Select</option>
    <option value="1">Sundry Debtors Control A/c</option>
    <option value="2">Other Income</option>
    </select>
    </td>
                
    <td id="show_user1" valign="top"><select class="m-wrap chosen span12">
    <option value="">Select</option>
    </select> 
    <label report="prt_ac" class="remove_report"></label>
    </td>
                    
    <td valign="top"><select class="m-wrap span12 chosen">
    <option value="" style="display:none;">Select</option>
    <option value="32" selected="selected">Cash-in-hand</option>
    </select> 
    </td>
                    
<td valign="top"><input type="text" class="m-wrap span12"  id="amttt1" style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="5" onkeyup="numeric_vali(this.value,1)">
</td>

<td valign="top">
<input type="text" class="m-wrap span12"  name="narration" id="narr" style="background-color:white !important; margin-top:2.5px;">
</td>
            
    <td><a class="btn green mini adrww" onclick="add_rowww()"><i class="icon-plus"></i></a><br></td>
        </tr>
     </table>
    
	 
<div class="form-actions">
<button type="submit" class="btn green">Submit</button>
</div>
</div>
</div>
<!------------------------------- End Petty Cash Receipt Form ----------------------------------->

<!------------------------------- Start Java Script Code ----------------------------------------->
<script>

   function add_rowww(){
			 var count = $("#tbb tr").length;
			 $(".adrww").hide();
			 count++;
			 $.ajax({
			 url: 'petty_cash_receipt_add_row?con=' + count,
			 }).done(function(response) {
			 $("#tbb").append(response);
			 $(".adrww").show();
			 });	
			 }

   function delete_row(ttttt){
			$('.content_'+ttttt).remove();
			}

   function numeric_vali(vv,dd){
			if($.isNumeric(vv))
			{
			$("#validdn").html('');	
			}
            else
			{
			$("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric Value in row '+ dd +'</div>');
			$("#amttt"+ dd).val("");
			return false;		
			}
            }

   function type_ajjxx(tt,dd){
            $("#show_user" + dd).load("petty_cash_receipt_ajax?value=" +tt+ "");
            }

</script>	

<script>
$(document).ready(function() { 
	$('form').submit( function(ev){
	ev.preventDefault();
		
		var count = $("#tbb tr").length;
		var ar = [];

		for(var i=1;i<=count;i++)
		{
		var transaction_date = $("#tbb tr:nth-child("+i+") td:nth-child(1) input").val();
		var ac_group = $("#tbb tr:nth-child("+i+") td:nth-child(2) select").val();
		var party_ac = $("#tbb tr:nth-child("+i+") td:nth-child(3) select").val();
		var ac_head = $("#tbb tr:nth-child("+i+") td:nth-child(4) select").val();
		var amount = $("#tbb tr:nth-child("+i+") td:nth-child(5) input").val();
		var narration = $("#tbb tr:nth-child("+i+") td:nth-child(6) input").val();
		ar.push([transaction_date,ac_group,party_ac,ac_head,amount,narration]);
		
		}
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "petty_cash_receipt_json?q="+myJsonString,
			dataType:'json',
			}).done(function(response){
				if(response.type == 'error'){
			
			 $("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
			$("html, body").animate({
					 scrollTop:0
					 },"slow");
			
			}
		    if(response.type == 'success'){
			  $("#shwd").show();
			  $(".swwtxx").html(response.text);
			}
});			
});
});

</script>		

<!---------------------------End Java Script Code -------------------------------------->
		
<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You!</b></h4>
<p class="swwtxx"></p>

</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Cashbanks/petty_cash_receipt_view" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 