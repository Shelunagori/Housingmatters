<script>
function balance() 
{
var t_date=document.getElementById('date').value;
if(t_date=== '') { $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;">Please Fill The Transaction Date</div>'); return false; }


var hidden_value=document.getElementById('t_box').value;
for(var nn = 1; nn <= hidden_value; nn++)
{
var lac = document.getElementById('lac' + nn).value;
if(lac=== '') { $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;">Please Fill The Ledger Account</div>'); return false; }

if(lac == 15 || lac == 33 || lac == 35 || lac == 34)
{
var subled = document.getElementById('sul' + nn).value;
if(subled=== '') { $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;">Please Fill The Sub Ledger Account</div>'); return false; }

}


var b_debit = document.getElementById('debit' + nn).value;
var b_credit = document.getElementById('credit' + nn).value;
if(b_debit == "" && b_credit == "")
{
 $('#validate_result').html('<div style="background-color:#f2dede; color:#b94a48; padding:5px;">Please Fill Debit Or Credit Account</div>'); return false;
}


}

var total11 = document.getElementById('total').value;
var total22 = document.getElementById('total_c').value;
if(total11 == total22)
{
return true;
}
else
{
alert('Debit and Credit not Match');
return false;
}
}
</script>
<script>
function dllok(r)
{
$(document).ready(function() {
$("#tab"+r).remove();
});
}
</script>


<script>
function total_am(x)
{
var t_d = 0;
var count = document.getElementById('t_box').value;
for(var j = 1; j<=count; j++)
{
var debit = document.getElementById('debit' + j).value;
if(debit == "")
{
debit = 0;
}
else
{
debit = eval(debit);
}
if(debit!=0)
{
t_d = eval(t_d + debit);
}
}
document.getElementById('total').value = t_d;
}
</script>



<script>

function total_amc(l)
{
var t_c = 0;
var count = document.getElementById('t_box').value;
for(var k = 1; k<=count; k++)
{
var credit = document.getElementById('credit' + k).value;
if(credit == "")
{
credit = 0;
}
else
{
credit = eval(credit);
}
t_c = eval(t_c + credit);

}
document.getElementById('total_c').value = t_c;
}
</script>


















<script>
function aj()
{
alert();
$("this").load("journal_add_row");
}
$(document).ready(function() {
  
 
 
 $("#button_add").live('click',function(){

	var c=$('#t_box').val();
  c++;
   
  $('#add_div').append($('<div>').load('journal_add_row?con=' + c));
 
  document.getElementById('t_box').value=c;
  //$("#add_div").load("journal_add_row");
  
  //$('.date-picker').datepicker().on('changeDate', function(){
	//$(this).blur();
	//});
});

$("#button_remove").live('click',function(){
	d=document.getElementById('t_box').value;
	//alert(d);
   if(d>2) {
	//$(this).hide();
     $('#tab' + d).remove();
      d--; 
   //document.getElementById('t_box').value=d;
   $('#t_box').val(d);
   //$(this).show();
   }
	
});
});
</script>


<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>			
			<center>
			<table width="50%" border="1" bordercolor="#FFFFFF" cellpadding="0">
			<tr>
			<td style="width:25%">
			<a href="journal_view" class="btn red btn-block"  style="font-size:16px;">Journal</a>
			</td>
			<td style="width:25%">
			<a href="ledger" class="btn blue btn-block"  style="font-size:16px;">Ledger</a>
			</td>
			</tr>
			</table>
			</center>

			
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>			
					<?php 
					if($zz == 0)
					{
					?>      

					<div class="alert">
					<button class="close" data-dismiss="alert"></button>
					<center>
					No Previous Receipt
					</center>
					</div> 
					
					<?php
					}
					else
					{
					?>

					<div class="alert">
					<button class="close" data-dismiss="alert"></button>
					<center>
					The Last Receipt Number is : <?php echo $zz; ?>
					</center>
					</div> 

					<?php } ?>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
 <center>
<a href="journal_add" class="btn red"> Create</a>
<a href="journal_view" class="btn blue"> View</a>
<br><br>              
</center>            					
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
  <div class="portlet box grey" style="width:100%;">
              <div class="portlet-title">
              <h4><i class="icon-reorder"></i>Journal</h4>
              </div>
              <div class="portlet-body form">

	<form  method="POST" onSubmit="return balance()" >			  
			  
			  <br>

<input type="text" id="date"  name="date" class="all_validate  m-wrap m-ctrl-medium date-picker"  data-date-format="dd-mm-yyyy" style="background-color:#FFF !important;" placeholder="Transaction Date" >

<br><br>

<center>
<div id="result11"></div>
<div id="validate_result"></div>
					
					
					
					
					<input type="hidden" id="t_box" name="xyz" value="2">
					
					<div style="padding:2px;">
					<div style="border:solid 1px #eee;">
					<div  style="background-color:rgba(226, 228, 255, 0.39); ">
					
					
					<table width="100%" >
					<tr class="table table-bordered table-hover" style="font-size:16px;">
				
					<th width="20.2%">Ledger A/c</th>
					<th width="19.8%">Subledger</th>
					<th width="20%">Debits</th>
					<th width="20%">Credits</th>
					<th width="20%">Description</th>
					
					</tr>
					</table>
					
					
					</div>					
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>					
<div id="add_div" >
<table width="100%"  >

<tr class="table table-bordered table-hover">

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<select class="all_validate span12 m-wrap chosen" onchange="show_ledger_type(this.value,1)" name="l_type_id1" id="lac1">
<option value="">--SELECT--</option>					
					
<?php
foreach ($cursor2 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>
<?php } ?>               
</select>
</div>
</div>
</td>					
					
					
					
					
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;" id="show_ledger_type1">

</td>					
					
					
					
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">

<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;" onblur="total_am('1')" name="debit1" placeholder="Debits" id="debit1">


</div>
</div>
</td>					
					
					
<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;" name="credit1" onblur="total_amc('1')" placeholder="Credits" id="credit1">
</div>
</div>
</td>


<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<input type="text"  name="remark1" class="all_validate span12 m-wrap m-ctrl-medium"  style="background-color:#FFF !important;" placeholder="Description" id="desc1">
</td>


</tr>
					
</table>					
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>					
<table width="100%" >

<tr class="table table-bordered table-hover">




<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<select class="all_validate span12 m-wrap chosen qwerty" onchange="show_ledger_type(this.value,2)" name="l_type_id2" id="lac2">
<option value="">--SELECT--</option>
<?php

foreach ($cursor2 as $collection) 
{
$auto_id = (int)$collection['ledger_account']['auto_id'];
$name = $collection['ledger_account']['ledger_name'];
?>
<option value="<?php echo $auto_id; ?>"><?php echo $name; ?></option>               
<?php } ?>               
</select>
</div>
</div>
</td>


<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;" id="show_ledger_type2">

</td>



<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">

<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;" onblur="total_am('2')" name="debit2" placeholder="Debits" id="debit2">


</div>
</div>
</td>


<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">
<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important;"  name="credit2" onblur="total_amc('2')" placeholder="Credits" id="credit2">
</div>
</div>
</td>

<td style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<input type="text"  name="remark2" class="all_validate span12 m-wrap m-ctrl-medium" style="background-color:#FFF !important;" placeholder="Description" id="desc2">
</td>


</tr>



</table>



</div>

<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<table width="100%" >

<tr class="table table-bordered table-hover">




<th style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:40.1%; text-align:right;">
Total
</th>


<th style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:19.9%;">

<div class="control-group">
<div class="controls">

<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important; border:none !important;" id="total" style="border:none !important">


</div>
</div>


</th>


<th style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">
<div class="control-group">
<div class="controls">

<input type="text" class="all_validate span12 m-wrap" style="background-color:#FFF !important; border:none !important;" id="total_c" style="border:none !important">


</div>
</div>
</th>

<th style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:0px; width:20%;">

</th>



</tr>



</table>





<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>

<input type="hidden" id="total_dr5">

					
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
</div>
</div>
</div>
<br>

<div class="form-actions" style="background-color:#CCC;">
<button type="submit" class="btn blue" name="journal_add" onclick="matchdc()" id="vali">Submit</button>
<button type="button" id="button_add" class="btn blue"> <i class="icon-plus"></i> Add Row</button>
<button type="button" id="button_remove" class="btn red"> <i class=" icon-remove"></i>Delete Row</button>
<a href="journal_add" class="btn">Reset</a>

</div>



<br><Br>
</form>
</div>
</div>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
 


<script>

function show_ledger_type(c1,t)
{

$(document).ready(function() {

	
$("#show_ledger_type" + t).load("show_ledger_type?c1=" +c1+ "&t=" +t+ "");

});
}
</script>



<script>
		$(document).ready(function() {
		$("#vali").live('click',function(){
        
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

















































					
					
					
					
					
					