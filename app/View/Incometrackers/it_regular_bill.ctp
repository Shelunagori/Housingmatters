
<?php
echo $this->requestAction(array('controller' => 'hms', 'action' => 'submenu'), array('pass' => array()));
?>				   
<script>
$(document).ready(function() {
$("#fix<?php echo $id_current_page; ?>").removeClass("blue");
$("#fix<?php echo $id_current_page; ?>").addClass("red");
});
</script>
<?php ///////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1; ?>" />
<input type="hidden" id="cn" value="<?php echo $count; ?>" />
<input type="hidden" id="fb" value="<?php echo @$datefb; ?>" />
<input type="hidden" id="tb" value="<?php echo @$datetb; ?>" />
<?php
$default_date = date('d-m-Y');
?>
<?php ///////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php 
foreach($socct1 as $data)
{
$society_registration_number = @$data['society']['society_reg_num'];
$society_address = @$data['society']['society_address'];
$society_income_head = @$data['society']['income_head'];
}
if(empty($society_registration_number) || empty($society_address))
{
$society_detail = "NOT";
}
else
{
$society_detail = "YES";	
}
?>
<?php //////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
$income_head_detail = 'YES'; 
foreach($flat_tpp as $data2)
{

$charge = @$data2['flat_type']['charge'];
$noc_charge = @$data2['flat_type']['noc_charge'];

if(empty($charge) && empty($noc_charge))
{
$income_head_detail = "NOT";
break;	
}
if(empty($society_income_head) && empty($charge))
{
$income_head_detail = "YES";
break;
}

$s=55;
for($t=0; $t<sizeof($charge); $t++)
{
$charge_array = $charge[$t];
if($charge_array[2]=="")
{
$s=555;
break;	
}
}
if($s == 555)
{
$income_head_detail = "NOT";
break;	
}

}

if($income_head_detail == 'YES')
{
$charge_count = sizeof(@$charge);
$society_income_head_count = sizeof($society_income_head);
if($charge_count != $society_income_head_count)
{
$income_head_detail = "NOT";
}
}
if($income_head_detail == 'YES')
{
for($t=0; $t<sizeof(@$charge); $t++)
{
$charge2 = $charge[$t];
$income_head_arr[] = $charge2[0];
}
$rrr = @array_diff(@$income_head_arr,@$society_income_head);
$count = sizeof($rrr);
if($count == 0)
{
$income_head_detail = "YES";	
}
else
{
$income_head_detail = "NOT";	
}
}

?>	
<?php ////////////////////////////////////////////////////////////////////////////////////////////// ?>
<?php
if($society_detail == 'YES')
{
if($income_head_detail == 'YES')	
{	
?>
<form method="post" id="contact-form">
<div class="portlet box blue">
<div class="portlet-title">
<h4 class="block"><i class="icon-reorder"></i>Generate Regular Bill</h4>
</div>
<div class="portlet-body form">
   
<div class="row-fluid">

<div class="span6">

        <label style="font-size:14px;">Billing Cycle<span style="color:red;">*</span></label>
        <div class="controls">
        <select id="billing_period" class="m-wrap span7 chosen">
        <option value="" style="display:none;">Select</option>
        <?php
        for($k=0; $k<sizeof($bill_period_arr); $k++)
        {
        $period_arr = $bill_period_arr[$k];
        $priod_name = $period_arr[0];
        $period_id = $period_arr[1];	
        ?>
        <option value="<?php echo $period_id; ?>"><?php echo $priod_name; ?></option>
        <?php
        }
        ?>
        </select>
        </div>
        <br />



        <label style="font-size:14px;">Billing Start Date<span style="color:red;">*</span></label>
        <div class="controls">
        <input type="text" class="m-wrap span7 date-picker" 
		data-date-format="dd-mm-yyyy" placeholder="Bill Date" id="from" value="<?php echo $default_date; ?>"/>
        </div>
        <br />


        <label style="font-size:14px; color:red;">Payment Due Date<span style="color:red;">*</span></label>
       <div class="controls">
       <input type="text" class="m-wrap span7 date-picker" data-date-format="dd-mm-yyyy" placeholder="Due Date" id="due" style="color:red; border-color:red;">
       
        </div>
        <br />
        
</div>


<div class="span6">
<label class="" style="font-size:14px;">Bill For<span style="color:red;">*</span></label>
        <div class="controls">
        <label class="radio">
        <div class="radio" id="uniform-undefined"><span><input type="radio" name="bill_for" value="1" style="opacity: 0;" id="bill_for"  onclick="wing()"></span></div>
        Wing Wise
        </label>
        <label class="radio">
        <div class="radio" id="uniform-undefined"><span><input type="radio" name="bill_for" value="2" style="opacity: 0;" id="bill_for" onclick="flat()"></span></div>
        All Units
        </label>
        </div>       
        <br /> 
		

        <div id="show_bill_for" class="hide">
        <div class="controls">
        <label style="font-size:14px;">Select Wing<span style="color:red;">*</span></label>
        <?php
        foreach($cursor5 as $collection)
        {
        $wing_id = (int)$collection['wing']['wing_id'];	
        $wing_name = $collection['wing']['wing_name'];		
        ?>
        <label class="checkbox">
        <div class="checker" id="uniform-undefined"><span>
        <input type="checkbox" value="<?php echo $wing_id; ?>" style="opacity: 0;" id="win"></span></div><?php echo $wing_name; ?> 
        </label>
        <?php } ?><br />
        </div>
        </div>        
        <br />    





	
<div class="controls">
<label class="" style="font-size:14px;">&nbsp;&nbsp;&nbsp;Penalty<i class=" icon-info-sign tooltips" data-placement="right" data-original-title="Please choose penalty yes/no "> </i></label>

<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" value="1" style="opacity: 0;" id="pen"></span></div>
Yes
</label>
<label class="radio">
<div class="radio" id="uniform-undefined"><span><input type="radio" value="2" style="opacity: 0;" id="pen"></span></div>
No
</label>
</div>
<br />

<div class="control-group">
<div class="controls">
<label style="font-size:14px;">Billing Description</label>
<textarea class="span9 m-wrap" id="description" style="resize:none;" rows="3"></textarea>
</div>
</div>








</div>
</div>
<br />


 <div class="form-actions">
 <button type="submit" class="btn red" value="Generate Bill" name="sub1" id="go">Preview Bill</button>
<a href="#" class="btn" onclick="hdd_ppupp()">No</a>
</div>

</div>
</div>
</form>

<script>
$(document).ready(function(){
$('form').submit( function(ev){ 

	ev.preventDefault();	
	var m_data = new FormData(); 
	
	
	var ar=[];
	
var billing_period = $("#billing_period").val();
var fromm = $("#from").val();
var due = $("#due").val();
var bill_for = $("#bill_for").val();
var win = $("#win").val();
var pen = $("#pen").val();
var description = $("#description").val();

alert(bill_for);



ar.push([posting_date,date_of_invoice,due_date,ex_head,invoice_ref,party_ac,amt_inv,description]);
			
	var myJsonString = JSON.stringify(ar);
	m_data.append('myJsonString',myJsonString);
	$.ajax({
			url: "expense_tracker_json",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			}).done(function(response) {
				//alert(response);
				$("#output").html(response);
			if(response.report_type=='error'){
			
					$("#output").html('<div class="alert alert-error" style="color:red; font-weight:600; font-size:13px;">'+response.text+'</div>');
					 //setInterval(function(){ $("#output").html(''); }, 10000);
					//$("#output").html('');
			}
			if(response.report_type=='submit'){
				$(".portal").remove();
				$("#shwd").show();
				$(".swwtxx").html(response.text);
				$("#output").remove();
			}
			$("html, body").animate({
			scrollTop:0
			},"slow");
			//$("#output").html(response);
			
	});
	
});
});
</script>











		


<script>

		$(document).ready(function() {
		$("#go").bind('click',function(){
	
		var from1 = document.getElementById("from").value;
		var per_tp = document.getElementById("bp").value;
		var date = from1.split("-"); 
		var d = date[0];
		var m = date[1];
		var y = date[2];
		var date2 = m + "/" + d + "/" + y; 
		//alert(date2);
		var datobj=new Date(date2);
			
		if(per_tp == 1)
		{
		var to1 = new Date(date2).addMonths(1);  //
		to1 = to1.setDate(to1.getDate()-1);
		to1 =  new Date(to1);
		var to1 = to1.toString("dd-MM-yyyy");
		}
		else if(per_tp == 2)
		{
		var to1 = new Date(date2).addMonths(2);  //
		to1 = to1.setDate(to1.getDate()-1);
		to1 =  new Date(to1);
		var to1 = to1.toString("dd-MM-yyyy");
		}
		else if(per_tp == 3)
		{
		var to1 = new Date(date2).addMonths(3);  //
		to1 = to1.setDate(to1.getDate()-1);
		to1 =  new Date(to1);
		var to1 = to1.toString("dd-MM-yyyy");
		}
		else if(per_tp == 4)
		{
		var to1 = new Date(date2).addMonths(6);  //
		to1 = to1.setDate(to1.getDate()-1);
		to1 =  new Date(to1);
		var to1 = to1.toString("dd-MM-yyyy");
		}
		else if(per_tp == 5)
		{
		var to1 = new Date(date2).addMonths(12);  //
		to1 = to1.setDate(to1.getDate()-1);
		to1 =  new Date(to1);
		var to1 = to1.toString("dd-MM-yyyy");
		}
	
		var Typpp = $("input[name='bill_for']:checked").val();
		
		var fi = document.getElementById("fi").value;
		var ti = document.getElementById("ti").value;
		var cn = document.getElementById("cn").value;
		var fe = fi.split(",");
		var te = ti.split(",");
		var due1 = document.getElementById("due").value;
		var fb = document.getElementById("fb").value;
		var tb= document.getElementById("tb").value;
		var from = from1.split("-").reverse().join("-");
		var to = to1.split("-").reverse().join("-");
		var due = due1.split("-").reverse().join("-");
		if(from == "")
		{
		}
		else if(to == "")
		{
			
		}
		else if(Date.parse(to) <= Date.parse(from))
		{
       	$("#result11").load("regular_vali?ss=" + 1 + "");
        return false;
		}
		else if(Date.parse(tb) >= Date.parse(from) && Typpp == 2)
		{
		$("#result11").load("regular_vali?ss=" + 5 + "");
        return false;	
		}
		else
		{
		$("#result11").load("regular_vali?ss=" + 11 + "");
       	}
		
		var nnn = 55;
		for(var i=0; i<cn; i++)
		{
		var fd = fe[i];
		var td = te[i]
		
		    if(from == "")
			{
				nnn = 555;
			break;	
			}
			else if(to == "")
			{
				nnn = 555;
				break;
			}
			else if(Date.parse(fd) <= Date.parse(from))
		     {
			 if(Date.parse(td) >= Date.parse(to))
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
		$("#result11").load("regular_vali?ss=" + 2 + "");
        return false;	
		}
		else if(nnn == 555)
		{
			
		}
		else
		{
		$("#result11").load("regular_vali?ss=" + 12 + "");		
		}
		if(due == "")
		{
			
		}
		else if(Date.parse(due) <= Date.parse(from))	 
		{
		$("#result12").load("regular_vali?ss=" + 3 + "");
		return false;
		}
		else if(Date.parse(due) > Date.parse(to))
		{
		$("#shwd").show();
			
		//$("#result12").load("regular_vali?ss=" + 505 + "");	
		return false;
		}
		else
		{
		$("#result12").load("regular_vali?ss=" + 13 + "");	 
		}
		
		
var bb = $('input[type=radio]:checked').val();
if(bb == 1)
{       
if($('input[type=checkbox]:checked').length == 0)
{
$('#chk_vali').html('<p style="color:red; font-size:15px;">Select at list One wing</p>'); return false;
}		
else
{
$('#chk_vali').html('<p style="color:red;"></p>');	
}
}		
		
		
		

});
});
</script>
        
<script>        
function wing()
{
$("#show_bill_for").show();	
}
function flat()
{
$("#show_bill_for").hide();	
}
</script>   

<?php }} ?>
<?php 
if($society_detail == 'NOT')
{
?>	     
<br /><br />
<center>
<div  class="alert alert-info" style="width:70%;">
<h4><b>
Dear Sir, For Regular Bill genereation you have to full fill the Society Registartion Number and Society Address at Society Setup. Without these detail you can not generate Regular Bill, So Please fill these details.
</b></h4>
</div>
</center>
<?php } ?>
<?php 
if($income_head_detail == 'NOT')
{
?>
<br /><br />
<center>
<div  class="alert alert-info" style="width:70%;">
<h4><b>
Dear Sir, For Regular Bill genereation you have to full fill the Non Occupancy Charges and Rate card at Accounting Setup. Without these detail you can not generate Regular Bill, So Please fill these details.
</b></h4>
</div>
</center>
<?php
}
?>



<div id="submiting_div" style="display:none;">
	<div class="modal-backdrop fade in"></div>
	<div class="modal" id="poll_edit_content">
		<div class="modal-body">
		<div align="center">
		<img src="<?php echo $webroot_path; ?>as/fb_loading.gif" style="height: 15px;" />
		<h4>Please Wait</h4>
		<h5>Your data is under processing, kindly wait.</h5>
		</div>
        </div>
	</div>
</div>
