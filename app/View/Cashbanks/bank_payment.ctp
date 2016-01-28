<?php
$default_date = date('d-m-Y');
?>
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
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<center>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment" class="btn yellow" rel='tab'>Create</a>
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_view" class="btn" rel='tab'>View</a>
<a href="#" class="btn purple" role="button" id="import" style="float:right; margin-right:8px;">Import csv</a>
</center>

<!------------------------- Start Bank Payment Form ----------------------------------->
<div id="url_main">
<form method="post" id="form2">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block">Post Bank Payment</h4>
</div>
<div class="portlet-body form">
<div id="validdn"></div>
<table class="table table-hover" style="background-color:#CDE9FE;" id="main_table">
<tr>
<td style="border:solid 1px blue;">

             <table class="table table-bordered" id="sub_table2">
              
			  <tr style="background-color:#E8EAE8;">
			  <th style="width:20%;">Transaction Date</th>
			  <th style="width:20%;">Ledger A/c</th>
			  <th style="width:20%;">Invoice Reference</th>
			  <th style="width:20%;">Amount</th>
			  <th style="width:20%;">TDS%</th>
			  </tr>


			  
			  <tr style="background-color:#E8F3FF;">
			  <td><input type="text" class="date-picker m-wrap span12" data-date-format="dd-mm-yyyy" 
			  value="<?php echo $default_date; ?>" 
			  style="background-color:white !important; margin-top:2.5px;" id="dattt1"></td>
			  
			  
					<td>
					<select class="m-wrap span12 chosen" id="ledger_account1">
					<option value="">--SELECT--</option>
					<?php
					foreach($cursor11 as $collection)
					{
					$auto_id = $collection['ledger_sub_account']['auto_id'];
					$name = $collection['ledger_sub_account']['name'];
					?>
					<option value="<?php echo $auto_id; ?>,1" ><?php echo $name; ?></option>
					<?php } ?>
					<?php
					foreach($cursor12 as $collection)
					{
					$auto_id_a = (int)$collection['accounts_group']['auto_id'];
					$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_a)));
					foreach($result33 as $collection)
					{
					$auto_id = (int)$collection['ledger_account']['auto_id'];
					$name = $collection['ledger_account']['ledger_name'];
					if($auto_id == 15)
					continue;
					?>
					<option value="<?php echo $auto_id; ?>,2" ><?php echo $name; ?></option>
					<?php }} ?>
					<?php
					foreach($cursor13 as $collection)
					{
					$auto_id_b = (int)$collection['accounts_group']['auto_id'];

					$result33 = $this->requestAction(array('controller' => 'hms', 'action' => 'expense_tracker_fetch2'),array('pass'=>array($auto_id_b)));
					foreach($result33 as $collection)
					{
					$auto_id = (int)$collection['ledger_account']['auto_id'];
					$name = $collection['ledger_account']['ledger_name'];
					?>
					<option value="<?php echo $auto_id; ?>,2" ><?php echo $name; ?></option>
					<?php }} ?>
					</select>
					</td>

  
			  <td><input type="text" class="m-wrap span12" 
			  style="background-color:white !important; margin-top:2.5px;" id="inv_ref1">
			  </td>
			  
			  
			  <td><input type="text" class="m-wrap span12" id="amttt1" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" maxlength="10" 
			  onkeyup="numeric_vali(this.value,1)" onchange="tdssssamt2(this.value,1)">
			  </td>
			  
			  
				<td><select class="m-wrap chosen span12" onchange="tdssssamt(this.value,1)" id="tdssss1">
				<option value="" style="display:none;">Select</option>
				<?php
				for($k=0; $k<sizeof($tds_arr); $k++)
				{
				$tds_sub_arr = $tds_arr[$k];	
				$tds_id = (int)$tds_sub_arr[1];
				$tds_tax = $tds_sub_arr[0];	
				?>
				<option value= "<?php echo $tds_id; ?>"><?php echo $tds_tax; ?></option>
				<?php } ?>                           
				</select>
				</td>
			  </tr>

              <tr style="background-color:#E8EAE8;">
			  <th>Net Amount</th>
			  <th>Mode of Payment</th>
			  <th>Instrument/UTR</th>
			  <th>Bank Account</th> 
			  <th>Narration</th>
			  </tr>
		
			  <tr style="background-color:#E8F3FF;">
				  
				  <td id="tds_show1"><input type="text"  class="m-wrap span12" 
				  readonly="readonly" style="background-color:white !important; margin-top:2.5px;" id="net_amtt1">
				  </td>
				  
				<td>
				<select class="m-wrap span12 chosen" id="moddd1">
				<option value="">Select</option>
				<option value="Cheque">Cheque</option>
				<option value="NEFT">NEFT</option>
				<option value="PG">PG</option>
				</select>
				</td>


			  <td><input type="text"  class="m-wrap span12" 
			  style="text-align:right; background-color:white !important; margin-top:2.5px;" id="instru1">
              </td>
			  
			  
					<td>
					<select onchange="get_value(this.value)" class="m-wrap chosen span12" id="bankk1">
					<option value="" style="display:none;">Select</option>    
					<?php
					foreach ($cursor2 as $db) 
					{
					$sub_account_id =(int)$db['ledger_sub_account']['auto_id'];
					$sub_account_name =$db['ledger_sub_account']['name'];
					$ac_number = $db['ledger_sub_account']['bank_account']; 
					$bank_acccc = substr($ac_number,-4);  
					?>
					<option value="<?php echo $sub_account_id; ?>"><?php echo $sub_account_name; ?>&nbsp;&nbsp;<?php echo $bank_acccc; ?></option>
					<?php } ?>
					</select>
					</td>


				  <td><input type="text" class="m-wrap span12" 
				  style="background-color:white !important; margin-top:2.5px;" id="desc1">
				  </td>
			  
              </tr>	
</table>			  

</td>
<td style="border:solid 1px blue;">
<a class="btn green mini adrww" onclick="add_rowwwww()"><i class="icon-plus"></i></a><br>
</td>
</tr>
</table>
<div class="form-actions">
<button type="submit" class="btn green">Submit</button>
</div>
</div>
</div>
</form>
</div>
<!----------------------------------- End Bank Payment Form ----------------------------------->	
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php

?>
<script>
$(document).ready(function() {

$("#import").bind('click',function(){
$("#myModal3").show();
});

$("#close_div").bind('click',function(){
$("#myModal3").hide();
});

});
</script>
<!---- Start Import Code -->
                <div id='suces'>
                <div id="error_msg"></div>
                <div id="myModal3" class="modal hide fade in" style="display:none;">
                <div class="modal-backdrop fade in"></div>
                <form id="form1" method="post" enctype="multipart/form-data">
                <div class="modal">
                <div class="modal-header">
                <h4 id="myModalLabel1">Import csv</h4>
                </div>
                <div class="modal-body">
                <input type="file" name="file" class="default" id="image-file">
                <label id="vali"></label>			
                <strong><a href="bank_payment_import_excel" download>Click here for sample format</a></strong>
                <br/>
                <h4>Instruction set to import receipts</h4>
                <ol>
                <li>Kindely delete second row, it is for example.</li>
                <li>All the field are compulsory.</li>
                <li>Amount should be numeric</li>
                <li>TDS % is optional field</li>
                 <li>Transaction date should be in open financial year</li>
                </ol>
                </div>
        <div class="modal-footer">
        <button type="button" class="btn" id="close_div">Close</button>
        <button type="submit" class="btn blue import_btn">Import</button>
        </div>
        </div>
        </form>
        </div>
        </div>
        </div>
<!-- End Import Code -->


<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<script>
function numeric_vali(vv,dd)
{
if($.isNumeric(vv))
{
$("#validdn").html('');	
}
else
{
$("#validdn").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">Amount Should be Numeric in row '+ dd +'</div>');
$("#amttt"+ dd).val("");
return false;		
}
}
</script>

<script>
function add_rowwwww()
{
var count = $("#main_table")[0].rows.length;
$(".adrww").hide();   
   count++;
     
		$.ajax({
		url: 'bank_payment_add_row?con=' + count,
		}).done(function(response) {
		
	$('#main_table').append(response)		
		$(".adrww").show();  
		 
	});
} 	
function delete_row(ttt)
{
	
$('.content_'+ttt).remove();	
	
}
    //$(".delete").live('click',function(){
    //var id = $(this).attr("id");
    //$('.content_'+id).remove();
    
    //});
 
    </script>

          
<script>
$(document).ready(function() {
$("#go").live('change',function(){
var tds = document.getElementById('go').value;
var amount=document.getElementById('amount').value;
$("#result").load('bank_payment_tds_ajax?tds='+tds+'&amount='+amount+'');
});
});
</script>	
<script>
function tdssssamt(vv,cc)
{
var amt = $("#amttt" + cc).val();
$("#tds_show" + cc).load('bank_payment_tds_ajax?tds='+vv+'&amount='+amt+'');
}

function tdssssamt2(vvv,ccc)
{
var tdsss = $("#tdssss" + ccc).val();
$("#tds_show" + ccc).load('bank_payment_tds_ajax?tds='+tdsss+'&amount='+vvv+'');	
}
</script>
	
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<script>
$(document).ready(function() { 
	$('form#form2').submit( function(ev){
	ev.preventDefault();
		var count = $("#main_table")[0].rows.length;
		var ar = [];
	
		for(var i=1;i<=count;i++)
		{
		var transaction_date = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(1) input").val();
		var ledger_account = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(2) select").val();
		var invoice = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(3) input").val();
		var amount = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(4) input").val();
		var tds_id = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(2) td:nth-child(5) select").val();
		var net_amt = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(1) input").val();
		var mode = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(2) select").val();
		var instrument = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(3) input").val();
		var bank_acc = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(4) select").val();
		var narration = $("#main_table tr:nth-child("+i+") td:nth-child(1) #sub_table2 tr:nth-child(4) td:nth-child(5) input").val();
		ar.push([transaction_date,ledger_account,amount,tds_id,net_amt,mode,instrument,bank_acc,invoice,narration]);
		}
		var myJsonString = JSON.stringify(ar);
			$.ajax({
			url: "bank_payment_json?q="+myJsonString,
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
			  $(".shwwtxtt").html(response.text);
			}
});			
});
});

</script>		
				
	


<?php //////////////////////////////////////////////////////////////////////////////////////////////////// ?>    
    
    
<div id="shwd" class="hide">
<div class="modal-backdrop fade in"></div>
<div   class="modal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-body">
<h4><b>Thank You</b></h4>
<p class="shwwtxtt"></p>
</div>
<div class="modal-footer">
<a href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_view" class="btn red" rel='tab'>OK</a>
</div>
</div>
</div> 
    
<script>
$(document).ready(function() {
$("#vali").bind('click',function(){
var fi = document.getElementById("fi").value;
var ti = document.getElementById("ti").value;
var cn = document.getElementById("cn").value;
var fe = fi.split(",");
var te = ti.split(",");
var date1 = document.getElementById("date").value;

var date = date1.split("-").reverse().join("-");

var nnn = 55;
for(var i=0; i<cn; i++)
{
var fd = fe[i];
var td = te[i]

if(date == "")
{
nnn = 555;
break;	
}
else if(Date.parse(fd) <= Date.parse(date))
{
if(Date.parse(td) >= Date.parse(date))
{
nnn = 5;
break;
}
else
{

}
} 
}


if(nnn == 55)
{
$("#result11").load("cash_bank_vali?ss=" + 2 + "");
return false;	
}
else if(nnn == 555)
{

}
else
{
$("#result11").load("cash_bank_vali?ss=" + 12 + "");		
}

});
});
</script>   
    
  <!--    Bank Payment Import  ----------->  
<script>
$(document).ready(function(){

		$(".delete").live('click',function(){
		var id = $(this).attr("del");
		$('#tr'+id).remove();
		});	
			
			$('form#form1').submit( function(ev){
			ev.preventDefault();
		
		var im_name=$("#image-file").val();
		var insert = 1;
		if(im_name==""){
		$("#vali").html("<span style='color:red;'>Please Select a Csv File</span>");	
		return false;
		}
		
		var ext = $('#image-file').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['csv']) == -1) {
		$("#vali").html("<span style='color:red;'>Please Select a Csv File</span>");
		return false;
		}

			$(".import_btn").text("Importing...");
			
			
			
			var m_data = new FormData();
			m_data.append( 'file', $('input[name=file]')[0].files[0]);
			$.ajax({
			url: "bank_payment_import_view",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			}).done(function(response){
			$("#myModal3").hide();
			$("#url_main").html(response);
		
			$(".bank_receipt_import").bind('click',function(){
			var count = $("#open_bal tr").length;
			
			var ar = [];
			var insert = 2;

			for(var i=1; i<=count; i++)
			{
				
			var TransactionDate = $("#open_bal tr:nth-child("+i+") td:nth-child(1) input").val();
			var ledger_acount=$("#open_bal tr:nth-child("+i+") td:nth-child(2) select").val();
			var amount =$("#open_bal tr:nth-child("+i+") td:nth-child(3) input").val();
			var tds_amount=$("#open_bal tr:nth-child("+i+") td:nth-child(4) select").val();
			var total_amt=$("#open_bal tr:nth-child("+i+") td:nth-child(5) input").val();
			var mode = $("#open_bal tr:nth-child("+i+") td:nth-child(6) select").val();
			var instrument = $("#open_bal tr:nth-child("+i+") td:nth-child(7) input").val();
			var bank_id = $("#open_bal tr:nth-child("+i+") td:nth-child(8) select").val();
			var invoice=$("#open_bal tr:nth-child("+i+") td:nth-child(9) input").val();
			var narration=$("#open_bal tr:nth-child("+i+") td:nth-child(10) input").val();
ar.push([TransactionDate,ledger_acount,amount,tds_amount,total_amt,mode,instrument,bank_id,invoice,narration,insert]);
			}

			var myJsonString = JSON.stringify(ar);
			myJsonString=encodeURIComponent(myJsonString);
			$.ajax({
			url: "save_bank_payment_imp?q="+myJsonString,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
						
			if(response.report_type=='validation')
			{
			$("#validdn").html('<div class="alert alert-error">'+response.text+'</div>');
			}
			if(response.report_type=='done')
			{
			$("#url_main").html('<div class="alert alert-block alert-success fade in"><h4 class="alert-heading">Success!</h4><p>Record Inserted Successfully</p><p><a class="btn green" href="<?php echo $webroot_path; ?>Cashbanks/bank_payment_view" rel="tab">OK</a></p></div>');
		}
		});
		});
		});
		});
		});
</script>	   
    

    
    
    
    
    