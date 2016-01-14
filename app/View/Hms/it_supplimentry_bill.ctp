<input type="hidden" id="fi" value="<?php echo $datef1; ?>" />
<input type="hidden" id="ti" value="<?php echo $datet1;  ?>" /> 
<input type="hidden" id="cn" value="<?php echo $count;  ?>" /> 


<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
		
		<table width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0">
		<tr>
		<td style="width:25%">
		<a href="it_regular_bill" class="btn blue btn-block"   style="font-size:16px;"> Regular Bill</a>
		</td>
		<td style="width:25%">
		<a href="it_supplimentry_bill" class="btn red btn-block"  style="font-size:16px;">Supplementary Bill</a>
		</td>
		<td style="width:25%">
		<a href="in_head_report" class="btn blue btn-block"  style="font-size:16px;">Reports</a>
		</td>
		<td style="width:25%">
		<a href="select_income_heads" class="btn blue btn-block"  style="font-size:16px;">Accounting Setup</a>
		</td>
		</tr>
		</table>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
 
			<div style="width:70%; margin-left:15%;">
			<div class="row-fluid">
			<div class="span12">
			<div class="portlet box green" style="border:solid 1px #ffb848;">
			<div class="portlet-body form">
			<h3 class="block"></h3>
			
			<form class="form-horizontal" method="post" id="contact-form" novalidate>		
		
        
       <!-- <div class="control-group">
        <div class="controls">
        <label class="" style="font-size:14px;">Billing Cycle</label>
        <select name="bill_p" id="bp" class="m-wrap medium">
        <option value="" style="display:none;"></option>
        <?php
		foreach($cursor5 as $collection)
		{
		$auto_id = (int)$collection['bill_period']['auto_id'];
		$period = $collection['bill_period']['period_name'];
		?>
        <option value="<?php echo $auto_id; ?>"><?php echo $period; ?></option>
        <?php
		}
		?>
        </select>
        <label id="bp" ></label>
        </div>
        </div>	 
        -->
        
        
<div class="controls">      
<label class="" style="font-size:14px;">Bill Date</label>    
<input type="text" name="from" id="from" class="m-wrap medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Bill Date" />
<div id="result11"></div>
</div>        
 <br />       
        
        
        
        
        
        
			
			<!--<div class="controls">
			<label class="" style="font-size:14px;">Period*</label>
			<div class="input-prepend"><span class="add-on">from</span> </div>
			<input type="text" class="span3 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="From*" name="from" id="from">
			<span> - </span>
			<div class="input-prepend"><span class="add-on">to</span></div>
			<input type="text" class="span3 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="to*" name="to" id="to">
			<label id="from"></label><label id="to"></label>
            <div id="result11"></div>
			</div><br/>	-->	
		
 
 
 <div class="control-group">
		<div class="controls">
		<label class="" style="font-size:14px; color:red;">Payment Due Date</label>
        <input type="text" class="span3 m-wrap  m-ctrl-medium date-picker" data-date-format="dd-mm-yyyy" placeholder="Due Date" name="due_date" id="due" style="color:red; border-color:red;">
        <label id="due" ></label>
		 <div id="result12"></div>
        </div>
		</div>	
 

 

			<div class="control-group ">
			<div class="controls">
			<label class="radio">
			<div class="radio requirecheck1" id="uniform-undefined"><input type="radio" class="go requirecheck1" name="type" value="1" style="opacity: 0;" id="requirecheck1"></div>
			Non-residential
			</label>
			<label class="radio">
			<div class="radio" id="uniform-undefined"><input type="radio" class="go1 requirecheck1" name="type" value="2"  style="opacity: 0;" id="requirecheck1"></span></div>
			Residential
			</label> 
<label id="requirecheck1"></label>			
			</div>
			</div>		
		
		
			
			<div id="div1" class="hide">
			<div class="control-group ">
			<div class="controls">
			<label class="" style="font-size:14px;">Company Name</label>
			<input type="text" class="span8 m-wrap section1" name="c_name" id="cn">
			<label id="cn"></label>
			</div>
			</div>
                 		
		 
			<div class="control-group ">
			<div class="controls">
			<label class="" style="font-size:14px;">Person Name</label>
			<input type="text" class="span8 m-wrap section1" name="p_name" id="pn">
			<label id="pn"></label>
			</div>
			</div>
		    </div>
		
	 
			<div id="div2" class="hide">
			<div class="control-group">
			<div class="controls">
			<label >Resident Name</label>
			<select class="chosen qwerty2 section2" name="r_name"  data-placeholder="Choose Resident Name" tabindex="1" id="hide1">
			<option value=""></option>
			<?php
			foreach ($cursor1 as $collection) 
			{
			$auto_id = (int)$collection['ledger_sub_account']['auto_id'];
			$user_name=$collection['ledger_sub_account']["name"];
			?>
			<option value="<?php echo $auto_id; ?>" /><?php echo $user_name; ?></option>
			<?php } ?>
			</select>
			<label id = "hide1"></label>
			</div>
			</div>
            </div>	
            
            
            <div id="div6" class="hide">
			<div class="control-group">
			<div class="controls">
			<label >Amount</label>
			<input type="text" class="span8 m-wrap section1" name="amt" id="amt">
			<label id="amt"></label>
			</div>
			</div>
            </div>	
            
            
            
            
            
            
            
            
            
            
            
		
            <div id="div5" class="hide">
			<div class="control-group">
			<div class="controls">
            
            <table border="0">
			<tr>
            <th><label><b>Select Income Heads</b></label></th>
            <th><label><b>Amount (Rs.)</b></label></th>
            </tr>
			<?php
			foreach ($cursor2 as $collection) 
			{
			$income_heads_id= (int)$collection['ledger_account']["auto_id"];
			$income_heads_name=$collection['ledger_account']["ledger_name"];
			?>
            <tr>
            <td>
<label class="checkbox">
<div class="checker" id="uniform-undefined"><span><input type="checkbox" value="<?php echo $income_heads_id; ?>" style="opacity: 0;" id="ih<?php echo $income_heads_id; ?>" name="ih<?php echo $income_heads_id; ?>" onclick="show(<?php echo $income_heads_id; ?>)"></span></div><?php echo $income_heads_name; ?>
</label>
</td>
<td>
<input type="text" class="m-wrap small" id="amt<?php echo $income_heads_id; ?>" name="amt<?php echo $income_heads_id; ?>" style="display:none;"/>
</td>
</tr>
			<?php } ?>
            <tr>
            <td>
<label class="checkbox">
<div class="checker" id="uniform-undefined"><span><input type="checkbox" value="43" style="opacity: 0;" name="ih43" id="ih43" onclick="show(43)"></span></div>Non Occupancy Charges
</label>
            </td>
            <td>
            <input type="text" class="m-wrap small" id="amt43" name="amt43" style="display:none;"/>
            </td>
            </tr>
            </table>
           	</div>
			</div>
		    </div>
	
    
    <!--
			<div class="control-group">
			<div class="controls">
			<label class="" >Taxes</label>
			<?php
			foreach ($cursor3 as $collection) 
			{
			$taxes_id=$collection['ledger_sub_account']["auto_id"];
			$taxes_name=$collection['ledger_sub_account']["name"];
			if($taxes_id != 33)
			{
			?>
			<label class="radio">
			<div class="radio" id="uniform-undefined">
			<span><input type="radio" name="tax" value="<?php echo $taxes_id; ?>" style="opacity: 0;" id="tax"></span>
			</div>
			<?php echo $taxes_name; ?>
			</label>
			<?php }} ?>
			<label id="tax"></label>
			</div>
			</div> -->

		
			<div class="control-group ">
			<div class="controls">
			<label class="" style="font-size:14px;">Billing Description</label>
			<textarea class="span8 m-wrap" name="description" style="resize:none;" rows="3" id="des"></textarea>
			<label id="des"></label>
			</div>
			</div>
		
		
		<!--	<div class="control-group ">
			<div class="controls">
			<label class="" style="font-size:14px;">Terms and Condition</label>
			<select data-placeholder="Select Terms and Conditions"  name="terms[]" id="terms" class="chosen m-wrap large" multiple="multiple" tabindex="6">	
			<?php
			$q=0;
			foreach ($cursor4 as $collection) 
			{
			$q++;
			$terms_conditions=$collection['terms_conditions']['terms_conditions'];
			$terms_conditions_id=$collection['terms_conditions']['terms_conditions_id'];
			?>
			<option value="<?php echo $terms_conditions_id; ?>"><?php echo $terms_conditions; ?></option>				
			<?php } ?>
			</select>	
           <label id="terms"></label>			
			</div>
			</div> -->
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			<div class="form-actions">
			<button type="submit" class="btn green" value="Generate Bill" name="sub1" id="go5">Preview Bill</button>
			<a href="it_supplimentry_bill" class="btn">Reset</a>
			</div>
			
            </div>
            </div>
            </div>
            </div>
            </div>
<?php ///////////////////////////////////////////////////////////////////////////////////////// ?>		
		
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>		
<script>
$(document).ready(function() {
	$(".go").live('click',function(){
		$("#div1").show();
		$("#div2").hide();
		$("#div6").show();
	    $("#div5").hide();
		$(".section2").addClass( "ignore" );
		$(".section1").removeClass( "ignore" );
	
	});
	
	$(".go1").live('click',function(){
		$("#div2").show();
		$("#div1").hide();
		$("#div5").show();
		$("#div6").hide();
		$(".section2").removeClass( "ignore" );
		$(".section1").addClass( "ignore" );
	});
	
});
</script>			
		
		
<script>
$.validator.addMethod('requirecheck1', function (value, element) {
	 return $('.requirecheck1:checked').size() > 0;
}, 'Please check at least one role.');

$.validator.addMethod('requirecheck2', function (value, element) {
	 return $('.requirecheck2:checked').size() > 0;
}, 'Please check at least one wing.');

$.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
    return this.optional(element) || (element.files[0].size <= param) 
});

$(document).ready(function(){
			var checkboxes = $('.requirecheck1');
			var checkbox_names = $.map(checkboxes, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			
			var checkboxes2 = $('.requirecheck2');
			var checkbox_names2 = $.map(checkboxes2, function(e, i) {
				return $(e).attr("name")
			}).join(" ");
			
			
			

	
	
		$('#contact-form').validate({
		
		 errorElement: "label",
                    //place all errors in a <div id="errors"> element
                    errorPlacement: function(error, element) {
                        //error.appendTo("label#errors");
						error.appendTo('label#' + element.attr('id'));
                    }, 
	    groups: {
            asdfg: checkbox_names,
			qwerty: checkbox_names2
        },
		
		ignore: ".ignore",
		rules: {
	      from: {
	        required: true
	      },
		  
		  to: {
	        required: true
	      },
		  due: {
	        required: true
	      },
		  c_name: {
	        required: true
	      },
		  due_date: {
	        required: true
	      },
		  r_name: {
	        required: true
	      },
		  "i_head[]": {
	        required: true
	      },
		   "terms[]": {
	        required: true
	      },
		    bill_p: {
	        required: true
	      },
		  
		  p_name: {
	        required: true
	      },
		  amt: {
	        required: true,
			number : true
			
	      },
		  
		  file: {
			accept: "gif,jpg",
			filesize: 1048576
	      },
		 
	    },
		messages: {
	                from: {
	                    required: "From date is required."
	                },
					to: {
	                    required: "To date is required."
	                },
					file: {
						accept: "File extension must be gif or jpg",
	                    filesize: "File size must be less than 1MB."
	                },
					description: {
	                    maxlength: "Max 500 characters allowed."
	                }
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
		$("#go5").live('click',function(){
        
		var fi = document.getElementById("fi").value;
		var ti = document.getElementById("ti").value;
		var cn = document.getElementById("cn").value;
		var fe = fi.split(",");
		var te = ti.split(",");
		var from1 = document.getElementById("from").value;
		//var to1 = document.getElementById("to").value;
		var due1 = document.getElementById("due").value;
		
		var from = from1.split("-").reverse().join("-");
		//var to = to1.split("-").reverse().join("-");
		var due = due1.split("-").reverse().join("-");
		if(from == "")
		{
		}
		//else if(to == "")
		//{
			
		//}
		//else if(Date.parse(to) <= Date.parse(from))
		//{
       	//$("#result11").load("supplimentry_vali?ss=" + 1 + "");
        //return false;
		//}
		//else
		//{
		//$("#result11").load("supplimentry_vali?ss=" + 11 + "");
       	//}
		
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
			//else if(to == "")
			//{
				//nnn = 555;
				//break;
			//}
			else if(Date.parse(fd) <= Date.parse(from))
		     {
			 if(Date.parse(td) >= Date.parse(from))
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
		$("#result11").load("supplimentry_vali?ss=" + 2 + "");
        return false;	
		}
		else if(nnn == 555)
		{
			
		}
		else
		{
		$("#result11").load("supplimentry_vali?ss=" + 12 + "");		
		}
		
		
		
		
		if(due == "")
		{
			
		}
		else if(Date.parse(due) <= Date.parse(from))	 
		{
		$("#result12").load("supplimentry_vali?ss=" + 3 + "");
		return false;
		}
		else
		{
		$("#result12").load("supplimentry_vali?ss=" + 13 + "");	 
		}
		 
		
		});
		});
		</script>	
		
		
		
		
<script>
function show(k)
{
if($("#ih"+k).is(':checked')) 
{
$("#amt"+k).show();
} 
else 
{
$("#amt"+k).hide();
}
}
</script>		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		